<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller Monitoring & Preview Soal Guru (Akses Publik / Tanpa Perlu Login)
 * Digunakan oleh Bapak/Ibu Guru untuk menelaah butir soal, memberi catatan koreksi,
 * serta menandatangani/mengesahkan naskah soal yang telah sesuai standar ujian.
 */
class Monitoring_soal extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('cbt_konfigurasi_model');
        $this->load->model('cbt_modul_model');
        $this->load->model('cbt_topik_model');
        $this->load->model('cbt_soal_model');
        $this->load->model('cbt_jawaban_model');
        $this->load->model('cbt_soal_koreksi_model');
    }

    /**
     * Helper untuk membersihkan nama topik dari tag hari (misal [SENIN], [SELASA-1], dll)
     * sehingga hanya menampilkan Mata Pelajaran dan Tingkat Kelas
     */
    public static function clean_topik_nama($topik_nama){
        if(empty($topik_nama)) return '';
        // Bersihkan tag hari dalam kurung siku seperti [SENIN], [SELASA-1], [RABU_2], dll.
        $clean = preg_replace('/\[(SENIN|SELASA|RABU|KAMIS|JUMAT|SABTU|MINGGU|HARI)[^\]]*\]\s*/i', '', $topik_nama);
        // Hapus tanda kurung siku lain jika diawali tag hari
        $clean = preg_replace('/^\[[^\]]+\]\s*/', '', $clean);
        return trim($clean);
    }

    /**
     * Helper ekstraksi tingkat kelas (X, XI, XII)
     */
    public static function extract_tingkat($topik_nama){
        if(preg_match('/\b(XII)\b/i', $topik_nama)){
            return 'XII';
        } else if(preg_match('/\b(XI)\b/i', $topik_nama)){
            return 'XI';
        } else if(preg_match('/\b(X)\b/i', $topik_nama)){
            return 'X';
        }
        return 'Umum';
    }

    /**
     * Halaman Utama Portal Monitoring Soal Guru
     */
    public function index(){
        $query_konfig = $this->cbt_konfigurasi_model->get_by_kolom_limit('konfigurasi_kode', 'cbt_nama', 1);
        $data['site_name'] = ($query_konfig->num_rows() > 0) ? $query_konfig->row()->konfigurasi_isi : 'CBT Online';
        $data['title'] = 'Portal Monitoring & Telaah Naskah Soal Guru';

        // Ambil data topik lengkap
        $sql = "SELECT t.topik_id, t.topik_modul_id, t.topik_nama, t.topik_detail, t.topik_aktif,
                       m.modul_id, m.modul_nama,
                       COUNT(s.soal_id) AS jml_soal
                FROM cbt_topik t
                JOIN cbt_modul m ON t.topik_modul_id = m.modul_id
                LEFT JOIN cbt_soal s ON s.soal_topik_id = t.topik_id
                GROUP BY t.topik_id
                ORDER BY m.modul_nama ASC, t.topik_nama ASC";
        $topik_raw = $this->db->query($sql)->result();

        // Ambil status verifikasi semua topik
        $verifikasi_list = array();
        $q_verif = $this->cbt_soal_koreksi_model->get_all_verifikasi()->result();
        foreach($q_verif as $v){
            $verifikasi_list[$v->verifikasi_topik_id] = $v;
        }

        // Ambil data catatan koreksi per topik
        $koreksi_counts = array();
        $q_kor = $this->db->select('koreksi_topik_id, 
                                   COUNT(koreksi_id) as total_koreksi, 
                                   SUM(CASE WHEN koreksi_status = "pending" THEN 1 ELSE 0 END) as pending_koreksi')
                          ->group_by('koreksi_topik_id')
                          ->get('cbt_soal_koreksi')->result();
        foreach($q_kor as $k){
            $koreksi_counts[$k->koreksi_topik_id] = $k;
        }

        $topik_list = array();
        $stat_total = count($topik_raw);
        $stat_terisi = 0;
        $stat_kosong = 0;
        $stat_acc = 0;
        $stat_revisi = 0;

        foreach($topik_raw as $t){
            $clean_name = self::clean_topik_nama($t->topik_nama);
            $tingkat = self::extract_tingkat($t->topik_nama);
            $jml = intval($t->jml_soal);

            $verif = isset($verifikasi_list[$t->topik_id]) ? $verifikasi_list[$t->topik_id] : null;
            $kor = isset($koreksi_counts[$t->topik_id]) ? $koreksi_counts[$t->topik_id] : null;

            if($jml > 0){
                $stat_terisi++;
            } else {
                $stat_kosong++;
            }

            $status_acc = false;
            if(!empty($verif) && $verif->verifikasi_status == 'sesuai'){
                $status_acc = true;
                $stat_acc++;
            }

            $pending_koreksi = (!empty($kor) && !empty($kor->pending_koreksi)) ? intval($kor->pending_koreksi) : 0;
            if($pending_koreksi > 0){
                $stat_revisi++;
            }

            $t->clean_nama = $clean_name;
            $t->tingkat = $tingkat;
            $t->verifikasi = $verif;
            $t->is_acc = $status_acc;
            $t->pending_koreksi = $pending_koreksi;
            $t->total_koreksi = (!empty($kor) && !empty($kor->total_koreksi)) ? intval($kor->total_koreksi) : 0;

            $topik_list[] = $t;
        }

        $data['topik_list'] = $topik_list;
        $data['stat_total'] = $stat_total;
        $data['stat_terisi'] = $stat_terisi;
        $data['stat_kosong'] = $stat_kosong;
        $data['stat_acc'] = $stat_acc;
        $data['stat_revisi'] = $stat_revisi;

        $this->load->view('monitoring_soal/portal_view', $data);
    }

    /**
     * Halaman Detail Pratinjau Lembar Soal & Form Koreksi/Verifikasi Guru
     */
    public function detail($topik_id = null){
        if(empty($topik_id)){
            redirect('monitoring_soal');
            return;
        }

        $query_topik = $this->cbt_topik_model->get_by_kolom_join_modul('topik_id', $topik_id);
        if($query_topik->num_rows() == 0){
            show_error('Data Topik Ujian tidak ditemukan atau telah dihapus.', 404, 'Topik Tidak Ditemukan');
            return;
        }

        $topik = $query_topik->row();
        $topik->clean_nama = self::clean_topik_nama($topik->topik_nama);
        $topik->tingkat = self::extract_tingkat($topik->topik_nama);

        $query_konfig = $this->cbt_konfigurasi_model->get_by_kolom_limit('konfigurasi_kode', 'cbt_nama', 1);
        $data['site_name'] = ($query_konfig->num_rows() > 0) ? $query_konfig->row()->konfigurasi_isi : 'CBT Online';
        $data['title'] = 'Telaah & Verifikasi Soal: '.$topik->clean_nama;
        $data['topik'] = $topik;

        // Ambil seluruh butir soal topik ini
        $query_soal = $this->cbt_soal_model->get_by_kolom('soal_topik_id', $topik_id);
        $soal_list = array();

        if($query_soal->num_rows() > 0){
            foreach($query_soal->result() as $s){
                $jawaban_list = array();
                if($s->soal_tipe == 1){
                    $query_jawaban = $this->cbt_jawaban_model->get_by_soal($s->soal_id);
                    if($query_jawaban->num_rows() > 0){
                        $jawaban_list = $query_jawaban->result();
                    }
                }

                // Ambil riwayat koreksi untuk butir soal ini
                $koreksi_soal = $this->cbt_soal_koreksi_model->get_koreksi_by_soal($s->soal_id)->result();

                $soal_list[] = array(
                    'soal' => $s,
                    'jawaban' => $jawaban_list,
                    'koreksi' => $koreksi_soal
                );
            }
        }
        $data['soal_list'] = $soal_list;

        // Ambil data verifikasi topik
        $query_verif = $this->cbt_soal_koreksi_model->get_verifikasi_by_topik($topik_id);
        $data['verifikasi'] = ($query_verif->num_rows() > 0) ? $query_verif->row() : null;

        $this->load->view('monitoring_soal/detail_view', $data);
    }

    /**
     * AJAX: Simpan Catatan Koreksi Butir Soal oleh Guru
     */
    public function simpan_koreksi(){
        $soal_id = $this->input->post('soal_id', TRUE);
        $topik_id = $this->input->post('topik_id', TRUE);
        $guru_nama = trim($this->input->post('guru_nama', TRUE));
        $catatan = trim($this->input->post('catatan', TRUE));

        if(empty($soal_id) || empty($topik_id) || empty($guru_nama) || empty($catatan)){
            echo json_encode(array(
                'status' => 0,
                'message' => 'Mohon lengkapi Nama Guru dan Catatan Koreksi yang ingin disampaikan.'
            ));
            return;
        }

        $insert_data = array(
            'koreksi_topik_id' => intval($topik_id),
            'koreksi_soal_id' => intval($soal_id),
            'koreksi_guru_nama' => $guru_nama,
            'koreksi_catatan' => $catatan,
            'koreksi_status' => 'pending'
        );

        $saved = $this->cbt_soal_koreksi_model->simpan_koreksi($insert_data);
        if($saved){
            echo json_encode(array(
                'status' => 1,
                'message' => 'Catatan koreksi berhasil dikirim dan akan segera dinotifikasikan ke Tim Admin/Operator untuk diperbaiki.',
                'guru_nama' => htmlspecialchars($guru_nama),
                'catatan' => nl2br(htmlspecialchars($catatan)),
                'waktu' => date('d-m-Y H:i')
            ));
        } else {
            echo json_encode(array(
                'status' => 0,
                'message' => 'Gagal menyimpan catatan koreksi. Silakan coba kembali.'
            ));
        }
    }

    /**
     * AJAX: Simpan Verifikasi & TTD Soal (ACC Soal Sudah Sesuai)
     */
    public function simpan_verifikasi(){
        $topik_id = $this->input->post('topik_id', TRUE);
        $guru_nama = trim($this->input->post('guru_nama', TRUE));
        $guru_nip = trim($this->input->post('guru_nip', TRUE));
        $catatan = trim($this->input->post('catatan', TRUE));
        $status = $this->input->post('status', TRUE);
        $ttd_digital = $this->input->post('ttd_digital', TRUE);

        if(empty($topik_id) || empty($guru_nama)){
            echo json_encode(array(
                'status' => 0,
                'message' => 'Mohon lengkapi Nama Lengkap Guru Penelaah / Verifikator.'
            ));
            return;
        }

        if(empty($status)){
            $status = 'sesuai';
        }

        $verif_data = array(
            'verifikasi_guru_nama' => $guru_nama,
            'verifikasi_guru_nip' => !empty($guru_nip) ? $guru_nip : '-',
            'verifikasi_status' => $status,
            'verifikasi_catatan' => $catatan,
            'verifikasi_ttd' => $ttd_digital
        );

        $saved = $this->cbt_soal_koreksi_model->simpan_verifikasi(intval($topik_id), $verif_data);
        if($saved){
            echo json_encode(array(
                'status' => 1,
                'message' => 'Pengesahan naskah soal berhasil disimpan! Status topik telah diperbarui menjadi "SUDAH SESUAI (ACC)".',
                'guru_nama' => htmlspecialchars($guru_nama),
                'waktu' => date('d-m-Y H:i')
            ));
        } else {
            echo json_encode(array(
                'status' => 0,
                'message' => 'Gagal menyimpan status verifikasi. Silakan coba kembali.'
            ));
        }
    }

    /**
     * AJAX: Ambil riwayat koreksi untuk satu butir soal
     */
    public function get_koreksi_soal($soal_id = null){
        if(empty($soal_id)){
            echo json_encode(array('status' => 0, 'data' => array()));
            return;
        }
        $data = $this->cbt_soal_koreksi_model->get_koreksi_by_soal(intval($soal_id))->result();
        echo json_encode(array('status' => 1, 'data' => $data));
    }
}
