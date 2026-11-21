<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cbt_tes_model extends CI_Model{
	public $table = 'cbt_tes';
	
	
	function __construct(){
		parent::__construct();
		$this->check_kolom();
	}

	function check_kolom(){
		$fields = $this->db->list_fields($this->table);
		if(!in_array('tes_hari', $fields)){
			$this->db->query("ALTER TABLE `".$this->table."` ADD `tes_hari` VARCHAR(30) NULL DEFAULT NULL AFTER `tes_nama`");
		}
		if(!in_array('tes_shift', $fields)){
			$this->db->query("ALTER TABLE `".$this->table."` ADD `tes_shift` VARCHAR(20) NULL DEFAULT NULL AFTER `tes_hari`");
		}
		if(!in_array('tes_jam_ke', $fields)){
			$this->db->query("ALTER TABLE `".$this->table."` ADD `tes_jam_ke` VARCHAR(30) NULL DEFAULT NULL AFTER `tes_shift`");
		}
	}

    /**
     * Normalisasi Otomatis Poin Dasar & Max Score ke Skala 100 (Poin = 100 / Total Soal)
     * Sekaligus menghitung ulang (Recalculate) nilai siswa yang sudah terlanjur mengerjakan tes tersebut.
     */
    function normalisasi_skala_100($tes_id = null){
        // Pastikan kolom mendukung presisi 4 desimal untuk jumlah soal ganjil (misal 30 soal -> 3.3333)
        $this->db->query("ALTER TABLE `cbt_tes` MODIFY `tes_score_right` DECIMAL(10,4) NULL DEFAULT 1.0000");
        $this->db->query("ALTER TABLE `cbt_tes_soal` MODIFY `tessoal_nilai` DECIMAL(10,4) NULL DEFAULT NULL");

        $where_tes = '';
        if(!empty($tes_id) && $tes_id != 'semua' && is_numeric($tes_id)){
            $where_tes = ' WHERE t.tes_id = '.intval($tes_id);
        }

        $sql = "
            SELECT t.tes_id, t.tes_nama, t.tes_score_right, t.tes_score_wrong, t.tes_score_unanswered, t.tes_max_score,
                   COALESCE(SUM(ts.tset_jumlah), 0) AS total_soal
            FROM cbt_tes t
            INNER JOIN cbt_tes_topik_set ts ON ts.tset_tes_id = t.tes_id
            $where_tes
            GROUP BY t.tes_id
            HAVING total_soal > 0
        ";
        $tes_list = $this->db->query($sql)->result();

        $jml_tes_diubah = 0;
        $jml_peserta_dihitung = 0;

        foreach($tes_list as $t){
            $total_soal = intval($t->total_soal);
            if($total_soal <= 0) continue;

            $poin_baru = round(100 / $total_soal, 4);
            $poin_salah = floatval($t->tes_score_wrong);
            $poin_kosong = floatval($t->tes_score_unanswered);

            // 1. Update tes_score_right dan tes_max_score = 100 di cbt_tes
            $this->db->where('tes_id', $t->tes_id)->update('cbt_tes', array(
                'tes_score_right' => $poin_baru,
                'tes_max_score' => 100.00
            ));
            $jml_tes_diubah++;

            // 2. Hitung ulang (Recalculate) tessoal_nilai untuk siswa yang sudah mengerjakan tes ini
            // a) Soal Pilihan Ganda (soal_tipe = 1) yang dijawab BENAR
            $sql_recalc_benar = "
                UPDATE cbt_tes_soal ts
                INNER JOIN cbt_tes_user tu ON ts.tessoal_tesuser_id = tu.tesuser_id
                INNER JOIN cbt_soal s ON ts.tessoal_soal_id = s.soal_id
                INNER JOIN cbt_tes_soal_jawaban tsj ON tsj.soaljawaban_tessoal_id = ts.tessoal_id AND tsj.soaljawaban_selected = 1
                INNER JOIN cbt_jawaban j ON tsj.soaljawaban_jawaban_id = j.jawaban_id
                SET ts.tessoal_nilai = ".$this->db->escape($poin_baru)."
                WHERE tu.tesuser_tes_id = ".intval($t->tes_id)."
                  AND s.soal_tipe = 1
                  AND j.jawaban_benar = 1
            ";
            $this->db->query($sql_recalc_benar);

            // b) Soal Pilihan Ganda (soal_tipe = 1) yang dijawab SALAH
            $sql_recalc_salah = "
                UPDATE cbt_tes_soal ts
                INNER JOIN cbt_tes_user tu ON ts.tessoal_tesuser_id = tu.tesuser_id
                INNER JOIN cbt_soal s ON ts.tessoal_soal_id = s.soal_id
                INNER JOIN cbt_tes_soal_jawaban tsj ON tsj.soaljawaban_tessoal_id = ts.tessoal_id AND tsj.soaljawaban_selected = 1
                INNER JOIN cbt_jawaban j ON tsj.soaljawaban_jawaban_id = j.jawaban_id
                SET ts.tessoal_nilai = ".$this->db->escape($poin_salah)."
                WHERE tu.tesuser_tes_id = ".intval($t->tes_id)."
                  AND s.soal_tipe = 1
                  AND j.jawaban_benar = 0
            ";
            $this->db->query($sql_recalc_salah);

            // c) Soal Jawaban Singkat (soal_tipe = 3) yang sudah dijawab
            $sql_recalc_singkat = "
                UPDATE cbt_tes_soal ts
                INNER JOIN cbt_tes_user tu ON ts.tessoal_tesuser_id = tu.tesuser_id
                INNER JOIN cbt_soal s ON ts.tessoal_soal_id = s.soal_id
                SET ts.tessoal_nilai = CASE
                    WHEN UPPER(TRIM(ts.tessoal_jawaban_text)) = UPPER(TRIM(s.soal_kunci)) THEN ".$this->db->escape($poin_baru)."
                    ELSE ".$this->db->escape($poin_salah)."
                END
                WHERE tu.tesuser_tes_id = ".intval($t->tes_id)."
                  AND s.soal_tipe = 3
                  AND ts.tessoal_change_time IS NOT NULL
            ";
            $this->db->query($sql_recalc_singkat);

            $cnt_tu = $this->db->where('tesuser_tes_id', $t->tes_id)->count_all_results('cbt_tes_user');
            $jml_peserta_dihitung += $cnt_tu;
        }

        return array(
            'jml_tes' => $jml_tes_diubah,
            'jml_peserta' => $jml_peserta_dihitung
        );
    }

    function save($data){
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
    
    function delete($kolom, $isi){
        $this->db->where($kolom, $isi)
                 ->delete($this->table);
    }
    
    function update($kolom, $isi, $data){
        $this->db->where($kolom, $isi)
                 ->update($this->table, $data);
    }
    
    function count_by_kolom($kolom, $isi){
        $this->db->select('COUNT(*) AS hasil')
                 ->where($kolom, $isi)
                 ->from($this->table);
        return $this->db->get();
    }
	
	function get_by_kolom($kolom, $isi){
        $this->db->where($kolom, $isi)
                 ->from($this->table);
        return $this->db->get();
    }

    function get_by_tanggal($tglawal, $tglakhir){
        $this->db->where('(DATE(tes_begin_time)>="'.$tglawal.'" AND DATE(tes_begin_time)<="'.$tglakhir.'")')
                 ->from($this->table);
        return $this->db->get();
    }
	
	function get_by_now(){
		$now = date('Y-m-d H:i:s');
        $this->db->where('(DATE(tes_begin_time)<=DATE("'.$now.'") AND DATE(tes_end_time)>=DATE("'.$now.'"))')
                 ->from($this->table)
				 ->order_by('tes_id', 'ASC');
        return $this->db->get();
    }
	
	function get_by_kolom_limit($kolom, $isi, $limit){
        $this->db->select('tes_id,tes_nama,tes_hari,tes_shift,tes_jam_ke,tes_detail,tes_begin_time,tes_end_time,tes_duration_time,tes_ip_range,tes_results_to_users, tes_score_right, tes_score_wrong, tes_score_unanswered, tes_max_score, tes_token')
                 ->where($kolom, $isi)
                 ->from($this->table)
				 ->limit($limit);
        return $this->db->get();
    }
	
	function get_datatable($start, $rows, $kolom, $isi, $hari=null, $jam_ke=null, $shift=null){
		$this->db->where('('.$kolom.' LIKE "%'.$isi.'%")');
		if(!empty($hari) && $hari != 'semua'){
			$this->db->where('tes_hari', $hari);
		}
		if(!empty($shift) && $shift != 'semua'){
			$this->db->where('tes_shift', $shift);
		}
		if(!empty($jam_ke) && $jam_ke != 'semua'){
			$this->db->where('tes_jam_ke', $jam_ke);
		}
		$this->db->from($this->table)
				 ->order_by('tes_id', 'DESC')
				 ->limit($rows, $start);
        return $this->db->get();
	}
    
    function get_datatable_count($kolom, $isi, $hari=null, $jam_ke=null, $shift=null){
		$this->db->select('COUNT(*) AS hasil')
                 ->where('('.$kolom.' LIKE "%'.$isi.'%")');
		if(!empty($hari) && $hari != 'semua'){
			$this->db->where('tes_hari', $hari);
		}
		if(!empty($shift) && $shift != 'semua'){
			$this->db->where('tes_shift', $shift);
		}
		if(!empty($jam_ke) && $jam_ke != 'semua'){
			$this->db->where('tes_jam_ke', $jam_ke);
		}
		$this->db->from($this->table);
        return $this->db->get();
	}
}