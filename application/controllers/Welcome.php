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
		$this->load->model('cbt_user_model');
		$this->load->model('cbt_konfigurasi_model');
		$this->load->library('access_tes');
		$this->load->library('user_agent');
	}
    
	public function index(){
		$data['url'] = $this->url;
		$data['timestamp'] = strtotime(date('Y-m-d H:i:s'));
		if ($this->agent->is_browser()){
            if($this->agent->browser()=='Internet Explorer' ){
                $this->template->display_user('blokbrowser_view', 'Browser yang didukung');
            }else{
				$akses_cbt = 1;
				$is_apk_webview = 0;
				$agent = $this->agent->agent_string();
				if(stripos($agent, 'ZYACBT') !== false || stripos($agent, 'Exambro') !== false || stripos($agent, 'ExamBrowser') !== false || stripos($agent, 'CBTBrowser') !== false || stripos($agent, '; wv)') !== false){
					$is_apk_webview = 1;
				}
				if($this->agent->is_mobile()){
					$query = $this->cbt_konfigurasi_model->get_by_kolom_limit('konfigurasi_kode', 'cbt_mobile_lock_xambro', 1);
					if($query->num_rows() > 0 && $query->row()->konfigurasi_isi=="ya"){
						if(stripos($agent, 'ZYACBT') === false && stripos($agent, 'Exambro') === false && stripos($agent, 'ExamBrowser') === false){
							$akses_cbt = 0;
						}
					}
				}

				// Verifikasi instan jika siswa mengakses URL dengan parameter QR (?qr=TOKEN atau /welcome/akses/TOKEN)
				$token_input = $this->input->get('qr', TRUE);
				if(empty($token_input) && $this->uri->segment(2) == 'akses'){
					$token_input = $this->uri->segment(3);
				}
				if(!empty($token_input)){
					if($this->cbt_konfigurasi_model->is_valid_qr_token($token_input)){
						$now = time();
						$canonical_token = $this->cbt_konfigurasi_model->get_qr_token(0);
						$this->session->set_userdata('cbt_qr_access_granted', 1);
						$this->session->set_userdata('cbt_qr_access_token', $canonical_token);
						$this->session->set_userdata('cbt_qr_access_time', $now);
						$this->session->set_userdata('cbt_qr_access_ip', $this->input->ip_address());

						$this->input->set_cookie(array('name' => 'cbt_qr_pass', 'value' => $canonical_token, 'expire' => 43200, 'path' => '/'));
						$this->input->set_cookie(array('name' => 'cbt_qr_time', 'value' => strval($now), 'expire' => 43200, 'path' => '/'));
						$this->session->set_flashdata('pesan_qr', 'success');
					}else{
						$this->session->set_flashdata('pesan_qr', 'error');
					}
				}

				if($akses_cbt==1){
					if(!$this->access_tes->is_login()){
						$data['is_apk_webview'] = $is_apk_webview;
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

						$client_ip = $this->input->ip_address();
						$ip_bypass_str = $this->cbt_konfigurasi_model->get_value('cbt_sekolah_ip_bypass', '192.168., 10., 172.16., 158.11., 127.0.0.1');
						$data['is_ip_bypass'] = $this->check_ip_bypass($client_ip, $ip_bypass_str) ? 1 : 0;
						$data['client_ip'] = $client_ip;

						// Pengecekan Akses QR Code Dinamis (Maksimal 12 Jam untuk Data Pribadi)
						$qr_status = $this->get_qr_access_status($client_ip, $data['is_ip_bypass']);
						$data['qr_status'] = $qr_status;
						$data['is_qr_valid'] = $qr_status['valid'];
						$data['qr_remaining_seconds'] = $qr_status['remaining_seconds'];
						$data['pesan_qr'] = $this->session->flashdata('pesan_qr');

						// Pengaturan Radius GPS Sekolah
						$data['radius_lock'] = $this->cbt_konfigurasi_model->get_value('cbt_radius_lock', 'tidak');
						$data['sekolah_lat'] = $this->cbt_konfigurasi_model->get_value('cbt_sekolah_latitude', '-6.175392');
						$data['sekolah_lng'] = $this->cbt_konfigurasi_model->get_value('cbt_sekolah_longitude', '106.827153');
						$data['sekolah_radius'] = $this->cbt_konfigurasi_model->get_value('cbt_sekolah_radius', '200');
						
						$this->template->display_user($this->kelompok.'/welcome_view', 'Selamat Datang', $data);
					}else{
						redirect('tes_dashboard');
					}					
				}else{
					$lock_data = array();
					$lock_data['scanned_qr_code'] = '';
					if(!empty($token_input) && $this->cbt_konfigurasi_model->is_valid_qr_token($token_input)){
						$lock_data['scanned_qr_code'] = strtoupper(substr($this->cbt_konfigurasi_model->get_qr_token(0), 0, 6));
					}
					$this->template->display_user('lockmobile_view', 'Gunakan Aplikasi Exam Browser', $lock_data);
				}
            }
        }else{
            $this->template->display_user('blokbrowser_view', 'Browser yang didukung');
        }
	}

	/**
	 * Helper untuk memvalidasi batas waktu izin akses data pribadi (Maksimal 12 Jam = 43200 Detik)
	 */
	private function get_qr_access_status($client_ip, $is_ip_bypass){
		if($is_ip_bypass){
			return array('valid' => 1, 'is_wifi' => 1, 'remaining_seconds' => 43200);
		}

		$qr_granted = $this->session->userdata('cbt_qr_access_granted');
		$qr_time = $this->session->userdata('cbt_qr_access_time');

		if(empty($qr_granted) || empty($qr_time)){
			$cookie_token = $this->input->cookie('cbt_qr_pass', TRUE);
			$cookie_time = $this->input->cookie('cbt_qr_time', TRUE);
			if(!empty($cookie_token) && !empty($cookie_time) && $this->cbt_konfigurasi_model->is_valid_qr_token($cookie_token)){
				$qr_granted = 1;
				$qr_time = intval($cookie_time);
				$this->session->set_userdata('cbt_qr_access_granted', 1);
				$this->session->set_userdata('cbt_qr_access_time', $qr_time);
			}
		}

		if(!empty($qr_granted) && !empty($qr_time)){
			$elapsed = time() - intval($qr_time);
			if($elapsed <= 43200){ // Maksimal 12 Jam
				$remaining = 43200 - $elapsed;
				return array('valid' => 1, 'is_wifi' => 0, 'expired' => 0, 'remaining_seconds' => $remaining);
			}else{
				// Melebihi 12 jam! Reset sesi & cookie
				$this->session->unset_userdata('cbt_qr_access_granted');
				$this->session->unset_userdata('cbt_qr_access_time');
				return array('valid' => 0, 'is_wifi' => 0, 'expired' => 1, 'remaining_seconds' => 0);
			}
		}

		return array('valid' => 0, 'is_wifi' => 0, 'expired' => 0, 'remaining_seconds' => 0);
	}

	/**
	 * Endpoint untuk verifikasi scan QR Code atau input Kode Akses 6-Digit dari perangkat siswa / APK WebView (Izin berlaku 12 Jam)
	 */
	public function akses($token = null){
		if(empty($token)){
			$token = $this->input->get_post('qr', TRUE);
		}
		
		if(!empty($token) && $this->cbt_konfigurasi_model->is_valid_qr_token($token)){
			$now = time();
			$canonical_token = $this->cbt_konfigurasi_model->get_qr_token(0);
			// Token valid: berikan hak akses kuota pribadi ke sesi siswa maksimal 12 jam
			$this->session->set_userdata('cbt_qr_access_granted', 1);
			$this->session->set_userdata('cbt_qr_access_token', $canonical_token);
			$this->session->set_userdata('cbt_qr_access_time', $now);
			$this->session->set_userdata('cbt_qr_access_ip', $this->input->ip_address());

			// Simpan cookie selama 12 jam (43200 detik)
			$cookie_pass = array(
				'name'   => 'cbt_qr_pass',
				'value'  => $canonical_token,
				'expire' => 43200,
				'path'   => '/'
			);
			$this->input->set_cookie($cookie_pass);

			$cookie_time = array(
				'name'   => 'cbt_qr_time',
				'value'  => strval($now),
				'expire' => 43200,
				'path'   => '/'
			);
			$this->input->set_cookie($cookie_time);

			if($this->input->is_ajax_request()){
				echo json_encode(array('status' => 1, 'pesan' => 'Kode Akses Ruang terverifikasi! Izin akses kuota mandiri aktif selama 12 jam.'));
				return;
			}

			$this->session->set_flashdata('pesan_qr', 'success');
			redirect('welcome');
		}else{
			if($this->input->is_ajax_request()){
				echo json_encode(array('status' => 0, 'error' => 'Kode Akses Ruang / Token QR tidak valid atau sudah kadaluarsa. Silakan lihat 6 digit Kode Akses di layar proyektor ruang ujian.'));
				return;
			}
			$this->session->set_flashdata('pesan_qr', 'error');
			redirect('welcome');
		}
	}

	function login(){
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('username', 'Username','required|strip_tags');
        $this->form_validation->set_rules('password', 'Password','required|strip_tags');
        if($this->form_validation->run() == TRUE){

			$client_ip = $this->input->ip_address();
			$ip_bypass_str = $this->cbt_konfigurasi_model->get_value('cbt_sekolah_ip_bypass', '192.168., 10., 172.16., 158.11., 127.0.0.1');
			$is_ip_bypass = $this->check_ip_bypass($client_ip, $ip_bypass_str);

			// Jika siswa mengisi Kode Akses Ruang / QR langsung di form login (solusi Cookie Jar APK Exam Browser)
			$kode_qr_input = trim((string)$this->input->post('kode_qr_akses', TRUE));
			if(!$is_ip_bypass && !empty($kode_qr_input)){
				if($this->cbt_konfigurasi_model->is_valid_qr_token($kode_qr_input)){
					$now = time();
					$canonical_token = $this->cbt_konfigurasi_model->get_qr_token(0);
					$this->session->set_userdata('cbt_qr_access_granted', 1);
					$this->session->set_userdata('cbt_qr_access_token', $canonical_token);
					$this->session->set_userdata('cbt_qr_access_time', $now);
					$this->session->set_userdata('cbt_qr_access_ip', $client_ip);

					$this->input->set_cookie(array('name' => 'cbt_qr_pass', 'value' => $canonical_token, 'expire' => 43200, 'path' => '/'));
					$this->input->set_cookie(array('name' => 'cbt_qr_time', 'value' => strval($now), 'expire' => 43200, 'path' => '/'));
				}else{
					$status['status'] = 0;
					$status['error'] = '<b>Kode Akses Ruang / QR Tidak Valid!</b><br>Kode 6 karakter yang Anda masukkan salah atau telah berganti shift. Silakan periksa Kode Akses di layar proyektor Pengawas.';
					echo json_encode($status);
					return;
				}
			}

			// Pengecekan Izin Akses Data Pribadi (Wajib Scan QR atau Input Kode Akses & Maksimal 12 Jam)
			$qr_status = $this->get_qr_access_status($client_ip, $is_ip_bypass);
			if($qr_status['valid'] != 1){
				$status['status'] = 0;
				if(!empty($qr_status['expired'])){
					$status['error'] = '<b>Akses Ditolak: Batas Waktu 12 Jam Telah Habis!</b><br>Masa berlaku akses perangkat Anda (maksimal 12 jam) telah selesai.<br><br>Silakan pindai QR Code terbaru atau masukkan <b>6 Digit Kode Akses Ruang</b> dari layar proyektor Pengawas.';
				}else{
					$status['error'] = '<b>Akses Ditolak: Izin Akses Belum Terverifikasi!</b><br>Perangkat Anda menggunakan jaringan data pribadi di luar WiFi sekolah. Silakan pindai QR Code atau ketik <b>6 Digit Kode Akses Ruang</b> yang ditampilkan Pengawas/Proktor pada kolom di bawah.';
				}
				echo json_encode($status);
				return;
			}

			$lat_siswa = $this->input->post('latitude', TRUE);
			$lng_siswa = $this->input->post('longitude', TRUE);

			// Pengecekan Kunci Radius Lokasi GPS Sekolah
			$radius_lock = $this->cbt_konfigurasi_model->get_value('cbt_radius_lock', 'tidak');
			if($radius_lock == 'ya' && !$is_ip_bypass){
				$has_valid_coords = (!empty($lat_siswa) && !empty($lng_siswa) && $lat_siswa != '0' && $lng_siswa != '0' && is_numeric($lat_siswa) && is_numeric($lng_siswa));
				if($has_valid_coords){
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
				}else{
					// Jika koordinat GPS tidak terkirim karena keterbatasan APK WebView lawas atau koneksi HTTP non-SSL,
					// izinkan masuk HANYA JIKA perangkat telah terverifikasi dengan QR Code / Kode Ruang Kelas aktif ($qr_status['valid'] == 1)
					$gps_fallback_qr = $this->input->post('gps_fallback_qr', TRUE);
					if($qr_status['valid'] != 1 || empty($gps_fallback_qr)){
						$status['status'] = 0;
						$status['error'] = '<b>Akses Ditolak: Lokasi GPS Tidak Terdeteksi!</b><br>Ujian hanya dapat diikuti di lingkungan sekolah. Mohon aktifkan GPS/Lokasi di HP Anda atau pastikan Anda telah memverifikasi <b>Kode Akses QR Ruang Ujian</b>.';
						echo json_encode($status);
						return;
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
					
					// Simpan data login ke database cbt_user secara aman
					$data_login = array(
						'user_login' => 1,
						'user_login_date' => date('Y-m-d')
					);
					if($this->db->field_exists('user_ip', 'cbt_user')){
						$data_login['user_ip'] = $client_ip;
					}
					if(!empty($lat_siswa) && $this->db->field_exists('user_lat', 'cbt_user')){
						$data_login['user_lat'] = $lat_siswa;
					}
					if(!empty($lng_siswa) && $this->db->field_exists('user_lng', 'cbt_user')){
						$data_login['user_lng'] = $lng_siswa;
					}

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
					$this->session->set_userdata('cbt_tes_lat', !empty($lat_siswa) ? $lat_siswa : '');
					$this->session->set_userdata('cbt_tes_lng', !empty($lng_siswa) ? $lng_siswa : '');
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

	private function check_ip_bypass($client_ip, $ip_bypass_str = null){
		return $this->cbt_konfigurasi_model->check_ip_bypass($client_ip, $ip_bypass_str);
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