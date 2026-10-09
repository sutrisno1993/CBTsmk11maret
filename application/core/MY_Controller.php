<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MY_Controller extends CI_Controller{
	function __construct(){
		parent::__construct();
	}
}

class Member_Controller extends CI_Controller{
	function __construct(){
		parent::__construct();
		if(!$this->access->is_login()){
			// diredirect ke bagian login
			redirect('manager/welcome');
		}
	}
	
	function is_login(){
		return $this->access->is_login();
	}
	
	function cek_akses($kode_menu){
		if(!$this->access->cek_akses($kode_menu)){
			redirect('manager');
		}
	}
    
    function cek_akses_crud($kode_menu, $tipe){
		if(!$this->access->cek_akses_crud($kode_menu, $tipe)){
			redirect('manager');
		}
	}
}

class Tes_Controller extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->library('access_tes');
		$this->load->model('cbt_konfigurasi_model');
		
		if(!$this->access_tes->is_login()){
			// diredirect ke bagian login
			redirect('welcome');
		}

		// Optimasi performa: jika siswa sudah terverifikasi di WiFi lokal, lewati pengecekan DB
		$is_wifi_session = $this->session->userdata('cbt_tes_is_wifi');
		if($is_wifi_session === 1){
			return;
		}

		// Batasi akses data pribadi / IP Publik maksimal 12 Jam (43200 detik)
		$client_ip = $this->input->ip_address();
		$is_ip_bypass = $this->cbt_konfigurasi_model->check_ip_bypass($client_ip);

		if($is_ip_bypass){
			$this->session->set_userdata('cbt_tes_is_wifi', 1);
		}else{
			$this->session->set_userdata('cbt_tes_is_wifi', 0);
			$qr_time = $this->session->userdata('cbt_qr_access_time');
			if(empty($qr_time)){
				$cookie_time = $this->input->cookie('cbt_qr_time', TRUE);
				if(!empty($cookie_time)){
					$qr_time = intval($cookie_time);
				}
			}
			if(!empty($qr_time) && (time() - intval($qr_time) > 43200)){
				// Melebihi 12 jam! Logout dan wajib minta link / scan QR baru
				$this->session->unset_userdata('cbt_qr_access_granted');
				$this->session->unset_userdata('cbt_qr_access_time');
				$this->access_tes->logout();
				$this->session->set_flashdata('pesan_qr', 'error_2hours');
				redirect('welcome');
			}
		}
	}
	
	function is_login(){
		return $this->access_tes->is_login();
	}
}