<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * ZYA CBT - Modul Pendaftaran Guru Mandiri
 */
class Guru_daftar extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('cbt_konfigurasi_model');
		$this->load->model('users_model');
		$this->load->library('access');
		
		// Inisialisasi role dan hak akses guru secara otomatis jika belum ada
		$this->users_model->init_guru_role();
	}

	public function index(){
		if($this->access->is_login()){
			redirect('manager/dashboard');
			return;
		}

		$data['site_name'] = 'ZYACBT';
		$query = $this->cbt_konfigurasi_model->get_by_kolom_limit('konfigurasi_kode', 'cbt_nama', 1);
		if($query->num_rows() > 0){
			$data['site_name'] = $query->row()->konfigurasi_isi;
		}

		$this->template->display_user('guru/guru_daftar_view', 'Pendaftaran Guru CBT', $data);
	}

	public function simpan(){
		$this->load->library('form_validation');

		$this->form_validation->set_rules('nama', 'Nama Lengkap Guru', 'required|trim|min_length[3]|max_length[150]|strip_tags');
		$this->form_validation->set_rules('no_wa', 'Nomor WhatsApp', 'required|trim|numeric|min_length[10]|max_length[16]|strip_tags');

		if($this->form_validation->run() == TRUE){
			$nama = $this->input->post('nama', true);
			$no_wa = preg_replace('/[^0-9]/', '', $this->input->post('no_wa', true));

			if(empty($no_wa) || strlen($no_wa) < 10){
				$status['status'] = 0;
				$status['pesan'] = 'Nomor WhatsApp tidak valid. Masukkan minimal 10 digit angka.';
				echo json_encode($status);
				return;
			}

			// Cek apakah nomor WA / username sudah digunakan
			if($this->users_model->get_login_info($no_wa)){
				$status['status'] = 0;
				$status['pesan'] = 'Nomor WhatsApp <b>'.$no_wa.'</b> sudah terdaftar di sistem! Silakan langsung login di Portal CBT.';
				echo json_encode($status);
				return;
			}

			// Topik diatur kemudian (default kosong = belum dibatasi)
			$data_user = array(
				'username' => $no_wa,
				'password' => sha1($no_wa), // default password = no whatsapp
				'nama' => $nama,
				'opsi1' => '',
				'opsi2' => $no_wa,
				'keterangan' => 'Guru Mata Pelajaran',
				'level' => 'guru'
			);

			$this->users_model->save($data_user);

			$status['status'] = 1;
			$status['pesan'] = 'Pendaftaran Akun Guru berhasil!<br><br>Gunakan Nomor WhatsApp <b>'.$no_wa.'</b> sebagai <b>Username</b> dan <b>Password</b> untuk masuk ke Portal CBT.';
			$status['redirect'] = site_url('admin');
		}else{
			$status['status'] = 0;
			$status['pesan'] = validation_errors();
		}

		echo json_encode($status);
	}
}
