<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* ZYA CBT
* Achmad Lutfi
* achmdlutfi@gmail.com
* achmadlutfi.wordpress.com
*/
class Welcome extends CI_Controller {
	private $kelompok = 'ujian';
	private $url = 'welcome';

	function __construct(){
		parent:: __construct();
		$this->load->model('cbt_konfigurasi_model');
		$this->load->library('access_tes');
		$this->load->library('user_agent');
		$this->load->model('cbt_konfigurasi_model');
	}
    
	public function index(){
		$data['url'] = $this->url;
		$data['timestamp'] = strtotime(date('Y-m-d H:i:s'));
		if ($this->agent->is_browser()){
            if($this->agent->browser()=='Internet Explorer' ){
                $this->template->display_user('blokbrowser_view', 'Browser yang didukung');
            }else{
				$akses_cbt = 1;
				if($this->agent->is_mobile()){
					$query = $this->cbt_konfigurasi_model->get_by_kolom_limit('konfigurasi_kode', 'cbt_mobile_lock_xambro', 1);
					if($query->row()->konfigurasi_isi=="ya"){
						$agent = $this->agent->agent_string();
						if(strpos($agent, 'ZYACBT')==false){
							$akses_cbt = 0;
						}
					}
				}
				if($akses_cbt==1){
					if(!$this->access_tes->is_login()){
						$data['link_login_operator'] = "tidak";
						$query_konfigurasi = $this->cbt_konfigurasi_model->get_by_kolom_limit('konfigurasi_kode', 'link_login_operator', 1);
						if($query_konfigurasi->num_rows()>0){
							$data['link_login_operator'] = $query_konfigurasi->row()->konfigurasi_isi;
						}
						
						$data['cbt_keterangan'] = "Ujian Online Berbasis Komputer";
						$query_konfigurasi = $this->cbt_konfigurasi_model->get_by_kolom_limit('konfigurasi_kode', 'cbt_keterangan', 1);
						if($query_konfigurasi->num_rows()>0){
							$data['cbt_keterangan'] = $query_konfigurasi->row()->konfigurasi_isi;
						}

						// Pengaturan Radius GPS Sekolah
						$data['radius_lock'] = $this->cbt_konfigurasi_model->get_value('cbt_radius_lock', 'tidak');
						$data['sekolah_lat'] = $this->cbt_konfigurasi_model->get_value('cbt_sekolah_latitude', '-6.175392');
						$data['sekolah_lng'] = $this->cbt_konfigurasi_model->get_value('cbt_sekolah_longitude', '106.827153');
						$data['sekolah_radius'] = $this->cbt_konfigurasi_model->get_value('cbt_sekolah_radius', '200');
						
						$client_ip = $this->input->ip_address();
						$ip_bypass_str = $this->cbt_konfigurasi_model->get_value('cbt_sekolah_ip_bypass', '192.168., 10., 172.16., 127.0.0.1');
						$data['is_ip_bypass'] = $this->check_ip_bypass($client_ip, $ip_bypass_str) ? 1 : 0;
						$data['client_ip'] = $client_ip;
						
						$this->template->display_user($this->kelompok.'/welcome_view', 'Selamat Datang', $data);
					}else{
						redirect('tes_dashboard');
					}					
				}else{
					$this->template->display_user('lockmobile_view', 'Exam Browser');
				}
            }
        }else{
            $this->template->display_user('blokbrowser_view', 'Browser yang didukung');
        }
	}

	function login(){
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('username', 'Username','required|strip_tags');
        $this->form_validation->set_rules('password', 'Password','required|strip_tags');
        if($this->form_validation->run() == TRUE){

			// Pengecekan Kunci Radius Lokasi GPS Sekolah
			$radius_lock = $this->cbt_konfigurasi_model->get_value('cbt_radius_lock', 'tidak');
			if($radius_lock == 'ya'){
				$client_ip = $this->input->ip_address();
				$ip_bypass_str = $this->cbt_konfigurasi_model->get_value('cbt_sekolah_ip_bypass', '192.168., 10., 172.16., 127.0.0.1');
				
				if(!$this->check_ip_bypass($client_ip, $ip_bypass_str)){
					$lat_siswa = $this->input->post('latitude', TRUE);
					$lng_siswa = $this->input->post('longitude', TRUE);
					
					if(empty($lat_siswa) || empty($lng_siswa) || $lat_siswa == '0' || $lng_siswa == '0' || !is_numeric($lat_siswa) || !is_numeric($lng_siswa)){
						$status['status'] = 0;
						$status['error'] = '<b>Akses Ditolak: Lokasi GPS Tidak Terdeteksi!</b><br>Ujian hanya dapat diikuti di lingkungan sekolah. Mohon pastikan GPS/Lokasi di HP Anda aktif dan berikan izin akses lokasi pada browser.';
						echo json_encode($status);
						return;
					}
					
					$lat_sekolah = (float)$this->cbt_konfigurasi_model->get_value('cbt_sekolah_latitude', '0');
					$lng_sekolah = (float)$this->cbt_konfigurasi_model->get_value('cbt_sekolah_longitude', '0');
					$radius_max = (int)$this->cbt_konfigurasi_model->get_value('cbt_sekolah_radius', '200');
					
					if($lat_sekolah != 0 && $lng_sekolah != 0){
						$jarak = $this->calculate_distance((float)$lat_siswa, (float)$lng_siswa, $lat_sekolah, $lng_sekolah);
						if($jarak > $radius_max){
							$status['status'] = 0;
							$status['error'] = '<b>Akses Ditolak: Di Luar Lingkungan Sekolah!</b><br>Perangkat Anda terdeteksi berada di luar area sekolah.<br>Jarak Anda saat ini: <b>' . round($jarak) . ' meter</b> (Batas Maksimal: ' . $radius_max . ' meter).<br>Silakan masuk ke area sekolah untuk mengikuti ujian.';
							echo json_encode($status);
							return;
						}
					}
				}
			}

            $this->form_validation->set_rules('token','token','callback_check_login');
			if($this->form_validation->run() == FALSE){
				//Jika login gagal
                $status['status'] = 0;
                $status['error'] = validation_errors();
			}else{
				//Jika sukses
				$username = $this->input->post('username',TRUE);
				
				//Cek proteksi_multilogin aktif
				$hasil = 1;
				$query_konfigurasi = $this->cbt_konfigurasi_model->get_by_kolom_limit('konfigurasi_kode', 'proteksi_multilogin', 1);
				if($query_konfigurasi->num_rows()>0){
					if($query_konfigurasi->row()->konfigurasi_isi=='ya'){
						//Jika aktif, cek apakah user sudah login
						if($this->cbt_user_model->count_by_login($username)->row()->hasil>0){
							// User terdeteksi login, info kalau user sudah login diperangkat lain
							$hasil = 0;
						}else{
							// User belum terdeteksi login, update user_login dan user_login_date
							$data['user_login']=1;
							$data['user_login_date']=date('Y-m-d');
							
							if(!empty($username)){
								$this->cbt_user_model->update('user_name', $username, $data);
							}				
						}
					}
				}
				
				if($hasil==1){
					$result = $this->cbt_user_model->get_by_username($username);
					
					// Simpan IP & Koordinat GPS ke database cbt_user
					$data_login = array(
						'user_login' => 1,
						'user_login_date' => date('Y-m-d'),
						'user_ip' => $client_ip,
						'user_lat' => $lat_siswa,
						'user_lng' => $lng_siswa
					);
					if(!empty($username)){
						$this->cbt_user_model->update('user_name', $username, $data_login);
					}

					// Menyimpan session
					$tanda = '@ZYACBT@';
					$this->session->set_userdata('cbt_tes_tanda',$tanda.$result->user_name.$tanda);
					$this->session->set_userdata('cbt_tes_user_id',$result->user_name);
					$this->session->set_userdata('cbt_tes_nama',stripslashes($result->user_firstname));
					$this->session->set_userdata('cbt_tes_group',$result->grup_nama);
					$this->session->set_userdata('cbt_tes_group_id',$result->grup_id);
					$this->session->set_userdata('cbt_tes_lat', $lat_siswa);
					$this->session->set_userdata('cbt_tes_lng', $lng_siswa);
					$this->session->set_userdata('cbt_tes_ip', $client_ip);
					
					$status['status'] = 1;
				}else{
					$status['status'] = 0;
					$status['error'] = 'User terdeteksi masih Login. Silahkan hubungi Petugas.';
				}
			}
        }else{
            $status['status'] = 0;
            $status['error'] = validation_errors();
        }
        echo json_encode($status);
    }
    
    function logout(){
		//Update user_login menjadi 0
		$data['user_login']=0;
		$username = $this->access_tes->get_username();
		if(!empty($username)){
			$this->cbt_user_model->update('user_name', $username, $data);
		}
		
		$this->access_tes->logout();
		redirect('welcome');
	}
	
	function check_login(){	
		$username = $this->input->post('username',TRUE);
		$password = $this->input->post('password',TRUE);
		
		$login = $this->access_tes->login($username, $password, $this->input->ip_address());
		if($login==1){
			return TRUE;
		}else if($login==2){
			$this->form_validation->set_message('check_login','Password yang dimasukkan salah');
			return FALSE;
		}else{
			$this->form_validation->set_message('check_login','Username yang dimasukkan tidak dikenal');
			return FALSE;
		}
	}

	private function check_ip_bypass($client_ip, $ip_bypass_str){
		if(empty($ip_bypass_str)){
			return false;
		}
		$list = explode(',', $ip_bypass_str);
		foreach($list as $ip_entry){
			$ip_entry = trim($ip_entry);
			if(!empty($ip_entry)){
				if(strpos($client_ip, $ip_entry) === 0 || $client_ip === $ip_entry){
					return true;
				}
			}
		}
		return false;
	}

	private function calculate_distance($lat1, $lon1, $lat2, $lon2){
		$earth_radius = 6371000; // Earth radius in meters
		$dLat = deg2rad($lat2 - $lat1);
		$dLon = deg2rad($lon2 - $lon1);
		$a = sin($dLat / 2) * sin($dLat / 2) +
		     cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
		     sin($dLon / 2) * sin($dLon / 2);
		$c = 2 * atan2(sqrt($a), sqrt(1 - $a));
		return $earth_radius * $c;
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */