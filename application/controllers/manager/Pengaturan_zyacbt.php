<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pengaturan_zyacbt extends Member_Controller {
	private $kode_menu = 'user-zyacbt';
	private $kelompok = 'pengaturan';
	private $url = 'manager/pengaturan_zyacbt';
	
    function __construct(){
		parent:: __construct();
		$this->load->model('cbt_konfigurasi_model');

		parent::cek_akses($this->kode_menu);
	}
	
    public function index($page=null, $id=null){
        $data['kode_menu'] = $this->kode_menu;
        $data['url'] = $this->url;
        
        $this->template->display_admin($this->kelompok.'/pengaturan_zyacbt_view', 'Pengaturan ZYACBT', $data);
    }

    function simpan(){
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('zyacbt-nama', 'Nama ZYACBT','required|strip_tags');
        $this->form_validation->set_rules('zyacbt-keterangan', 'Keterangan ZYACBT','required|strip_tags');
		$this->form_validation->set_rules('zyacbt-link-login', 'Link Login Operator','required|strip_tags');
		$this->form_validation->set_rules('zyacbt-proteksi-multilogin', 'Proteksi MultiLogin Peserta','required|strip_tags');
		$this->form_validation->set_rules('zyacbt-mobile-lock-xambro', 'Lock Mobile Exam Browser','required|strip_tags');
		$this->form_validation->set_rules('zyacbt-anti-cheating', 'Anti-Cheating Browser','required|strip_tags');
		$this->form_validation->set_rules('zyacbt-tipe-soal-global', 'Tipe Soal Ujian Global','required|strip_tags');
		$this->form_validation->set_rules('zyacbt-use-token', 'Penggunaan Token Ujian','required|strip_tags');
		$this->form_validation->set_rules('zyacbt-informasi', 'Informasi Peserta Tes','required');
        
        if($this->form_validation->run() == TRUE){
            $data['konfigurasi_isi'] = $this->input->post('zyacbt-nama', true);
			$this->cbt_konfigurasi_model->update('konfigurasi_kode', 'cbt_nama', $data);
			
			$data['konfigurasi_isi'] = $this->input->post('zyacbt-keterangan', true);
			$this->cbt_konfigurasi_model->update('konfigurasi_kode', 'cbt_keterangan', $data);
			
			$data['konfigurasi_isi'] = $this->input->post('zyacbt-link-login', true);
			$this->cbt_konfigurasi_model->update('konfigurasi_kode', 'link_login_operator', $data);
			
			$data['konfigurasi_isi'] = $this->input->post('zyacbt-mobile-lock-xambro', true);
			$this->cbt_konfigurasi_model->update('konfigurasi_kode', 'cbt_mobile_lock_xambro', $data);
			
			$data['konfigurasi_isi'] = $this->input->post('zyacbt-proteksi-multilogin', true);
			$this->cbt_konfigurasi_model->update('konfigurasi_kode', 'proteksi_multilogin', $data);

			$data['konfigurasi_isi'] = $this->input->post('zyacbt-anti-cheating', true);
			$this->cbt_konfigurasi_model->update('konfigurasi_kode', 'cbt_anti_cheating', $data);

			// Pengaturan Tipe Soal Global: pilihan_ganda / campuran / essay
			$tipe_soal = $this->input->post('zyacbt-tipe-soal-global', true);
			if($this->cbt_konfigurasi_model->count_by_kolom('konfigurasi_kode', 'cbt_tipe_soal_global')->row()->hasil == 0){
				$this->cbt_konfigurasi_model->save(array(
					'konfigurasi_kode' => 'cbt_tipe_soal_global',
					'konfigurasi_isi' => $tipe_soal
				));
			}else{
				$this->cbt_konfigurasi_model->update('konfigurasi_kode', 'cbt_tipe_soal_global', array('konfigurasi_isi' => $tipe_soal));
			}

			// Pengaturan Token Global: ya / tidak
			$use_token = $this->input->post('zyacbt-use-token', true);
			if($this->cbt_konfigurasi_model->count_by_kolom('konfigurasi_kode', 'cbt_use_token')->row()->hasil == 0){
				$this->cbt_konfigurasi_model->save(array(
					'konfigurasi_kode' => 'cbt_use_token',
					'konfigurasi_isi' => $use_token
				));
			}else{
				$this->cbt_konfigurasi_model->update('konfigurasi_kode', 'cbt_use_token', array('konfigurasi_isi' => $use_token));
			}

			// Jika admin memilih tidak menggunakan token, sinkronkan semua tes di database ke tes_token = 0
			if($use_token == 'tidak'){
				$this->db->update('cbt_tes', array('tes_token' => 0));
			}
			
			// Pengaturan Kunci Lokasi GPS Sekolah
			$radius_lock = $this->input->post('zyacbt-radius-lock', true);
			$this->cbt_konfigurasi_model->set_value('cbt_radius_lock', !empty($radius_lock) ? $radius_lock : 'tidak');

			$sekolah_lat = $this->input->post('zyacbt-sekolah-latitude', true);
			$this->cbt_konfigurasi_model->set_value('cbt_sekolah_latitude', !empty($sekolah_lat) ? $sekolah_lat : '-6.175392');

			$sekolah_lng = $this->input->post('zyacbt-sekolah-longitude', true);
			$this->cbt_konfigurasi_model->set_value('cbt_sekolah_longitude', !empty($sekolah_lng) ? $sekolah_lng : '106.827153');

			$sekolah_radius = $this->input->post('zyacbt-sekolah-radius', true);
			$this->cbt_konfigurasi_model->set_value('cbt_sekolah_radius', !empty($sekolah_radius) ? $sekolah_radius : '200');

			$ip_bypass = $this->input->post('zyacbt-sekolah-ip-bypass', true);
			$this->cbt_konfigurasi_model->set_value('cbt_sekolah_ip_bypass', !empty($ip_bypass) ? $ip_bypass : '192.168., 10., 172.16., 127.0.0.1');

			$data['konfigurasi_isi'] = $this->input->post('zyacbt-informasi', true);
			$this->cbt_konfigurasi_model->update('konfigurasi_kode', 'cbt_informasi', $data);

            $status['status'] = 1;
			$status['pesan'] = 'Pengaturan berhasil disimpan ';
        }else{
            $status['status'] = 0;
            $status['pesan'] = validation_errors();
        }
        
        echo json_encode($status);
    }
    
    function get_pengaturan_zyacbt(){
    	$data['data'] = 1;
		$query = $this->cbt_konfigurasi_model->get_by_kolom_limit('konfigurasi_kode', 'link_login_operator', 1);
		$data['link_login_operator'] = 'ya';
		if($query->num_rows()>0){
			$data['link_login_operator'] = $query->row()->konfigurasi_isi;
		}
		
		$query = $this->cbt_konfigurasi_model->get_by_kolom_limit('konfigurasi_kode', 'cbt_nama', 1);
		$data['cbt_nama'] = 'Computer Based-Test';
		if($query->num_rows()>0){
			$data['cbt_nama'] = $query->row()->konfigurasi_isi;
		}
		
		$query = $this->cbt_konfigurasi_model->get_by_kolom_limit('konfigurasi_kode', 'cbt_keterangan', 1);
		$data['cbt_keterangan'] = 'Ujian Online Berbasis Komputer';
		if($query->num_rows()>0){
			$data['cbt_keterangan'] = $query->row()->konfigurasi_isi;
		}
		
		$query = $this->cbt_konfigurasi_model->get_by_kolom_limit('konfigurasi_kode', 'cbt_informasi', 1);
		$data['cbt_informasi'] = 'Silahkan pilih Tes yang diikuti dari daftar tes yang tersedia dibawah ini. Apabila tes tidak muncul, silahkan menghubungi Operator yang bertugas.';
		if($query->num_rows()>0){
			$data['cbt_informasi'] = $query->row()->konfigurasi_isi;
		}
		
		$query = $this->cbt_konfigurasi_model->get_by_kolom_limit('konfigurasi_kode', 'cbt_mobile_lock_xambro', 1);
		$data['mobile_lock_xambro'] = 'ya';
		if($query->num_rows()>0){
			$data['mobile_lock_xambro'] = $query->row()->konfigurasi_isi;
		}
		
		$query = $this->cbt_konfigurasi_model->get_by_kolom_limit('konfigurasi_kode', 'proteksi_multilogin', 1);
		$data['proteksi_multilogin'] = 'ya';
		if($query->num_rows()>0){
			$data['proteksi_multilogin'] = $query->row()->konfigurasi_isi;
		}

		$query = $this->cbt_konfigurasi_model->get_by_kolom_limit('konfigurasi_kode', 'cbt_anti_cheating', 1);
		$data['anti_cheating'] = 'tidak';
		if($query->num_rows()>0){
			$data['anti_cheating'] = $query->row()->konfigurasi_isi;
		}

		$query = $this->cbt_konfigurasi_model->get_by_kolom_limit('konfigurasi_kode', 'cbt_tipe_soal_global', 1);
		$data['tipe_soal_global'] = 'pilihan_ganda';
		if($query->num_rows()>0){
			$data['tipe_soal_global'] = $query->row()->konfigurasi_isi;
		}

		$query = $this->cbt_konfigurasi_model->get_by_kolom_limit('konfigurasi_kode', 'cbt_use_token', 1);
		$data['use_token'] = 'tidak';
		if($query->num_rows()>0){
			$data['use_token'] = $query->row()->konfigurasi_isi;
		}

		$data['radius_lock'] = $this->cbt_konfigurasi_model->get_value('cbt_radius_lock', 'tidak');
		$data['sekolah_latitude'] = $this->cbt_konfigurasi_model->get_value('cbt_sekolah_latitude', '-6.175392');
		$data['sekolah_longitude'] = $this->cbt_konfigurasi_model->get_value('cbt_sekolah_longitude', '106.827153');
		$data['sekolah_radius'] = $this->cbt_konfigurasi_model->get_value('cbt_sekolah_radius', '200');
		$data['sekolah_ip_bypass'] = $this->cbt_konfigurasi_model->get_value('cbt_sekolah_ip_bypass', '192.168., 10., 172.16., 127.0.0.1');
		
		echo json_encode($data);
    }
}