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