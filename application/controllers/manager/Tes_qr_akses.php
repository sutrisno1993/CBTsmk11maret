<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tes_qr_akses extends Member_Controller {
	private $kode_menu = 'tes-qr-akses';
	private $kelompok = 'tes';
	private $url = 'manager/tes_qr_akses';
	
    function __construct(){
		parent:: __construct();
		$this->load->model('cbt_konfigurasi_model');

        // Pastikan menu tes-qr-akses terdaftar di user_menu
        $cek_menu = $this->db->where('kode_menu', $this->kode_menu)->get('user_menu');
        if($cek_menu->num_rows() == 0){
            $this->db->insert('user_menu', array(
                'tipe' => 1,
                'parent' => 'tes',
                'kode_menu' => $this->kode_menu,
                'nama_menu' => 'QR Akses Siswa (Data Mandiri)',
                'url' => $this->url,
                'icon' => 'fa fa-qrcode',
                'urutan' => 6
            ));
        }

        // Pastikan level admin, pengawas, dan guru memiliki hak akses ke tes-qr-akses
        $levels = array('admin', 'pengawas', 'guru');
        foreach($levels as $lvl){
            $cek_akses = $this->db->where('kode_menu', $this->kode_menu)->where('level', $lvl)->get('user_akses');
            if($cek_akses->num_rows() == 0){
                $this->db->insert('user_akses', array(
                    'level' => $lvl,
                    'kode_menu' => $this->kode_menu,
                    'add' => 1,
                    'edit' => 1
                ));
            }
        }

		parent::cek_akses($this->kode_menu);
	}
	
    public function index(){
        $data['kode_menu'] = $this->kode_menu;
        $data['url'] = $this->url;

        // Ambil URL Akses Publik (Default: Cloudflare Tunnel Sekolah)
        $public_url = $this->cbt_konfigurasi_model->get_value('cbt_public_url', 'https://made-bible-intent-engines.trycloudflare.com');
        if(empty($public_url)){
            $public_url = 'https://made-bible-intent-engines.trycloudflare.com';
        }
        $data['public_url'] = rtrim($public_url, '/');

        $token = $this->cbt_konfigurasi_model->get_qr_token(0);
        $data['current_token'] = $token;
        $data['expires_in'] = $this->cbt_konfigurasi_model->get_qr_expires_in();
        $data['valid_until'] = date('H:00:00', strtotime('+1 hour')) . ' WIB';
        
        // Link lengkap yang akan discan siswa
        $data['access_url'] = $data['public_url'] . '/index.php/welcome/akses/' . $token;

        $this->template->display_admin($this->kelompok.'/tes_qr_akses_view', 'QR Code Akses Siswa', $data);
    }

    /**
     * API AJAX untuk sinkronisasi token dan sisa waktu secara live
     */
    function get_qr_status(){
        $public_url = $this->cbt_konfigurasi_model->get_value('cbt_public_url', 'https://made-bible-intent-engines.trycloudflare.com');
        if(empty($public_url)){
            $public_url = 'https://made-bible-intent-engines.trycloudflare.com';
        }
        $public_url = rtrim($public_url, '/');

        $token = $this->cbt_konfigurasi_model->get_qr_token(0);
        $expires_in = $this->cbt_konfigurasi_model->get_qr_expires_in();
        $valid_until = date('H:00:00', strtotime('+1 hour')) . ' WIB';
        $access_url = $public_url . '/index.php/welcome/akses/' . $token;

        $response = array(
            'status' => 1,
            'token' => $token,
            'expires_in' => $expires_in,
            'valid_until' => $valid_until,
            'server_time' => date('H:i:s') . ' WIB',
            'public_url' => $public_url,
            'access_url' => $access_url
        );

        echo json_encode($response);
    }

    /**
     * Simpan / Perbarui URL Publik (Cloudflare Tunnel atau IP Publik)
     */
    function simpan_public_url(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('public_url', 'URL Publik', 'required|strip_tags');

        if($this->form_validation->run() == TRUE){
            $public_url = trim($this->input->post('public_url', TRUE));
            $public_url = rtrim($public_url, '/');
            
            $this->cbt_konfigurasi_model->set_value('cbt_public_url', $public_url);

            $token = $this->cbt_konfigurasi_model->get_qr_token(0);
            $access_url = $public_url . '/index.php/welcome/akses/' . $token;

            $status['status'] = 1;
            $status['pesan'] = 'URL Publik berhasil disimpan. QR Code otomatis diperbarui!';
            $status['public_url'] = $public_url;
            $status['access_url'] = $access_url;
        }else{
            $status['status'] = 0;
            $status['pesan'] = validation_errors();
        }

        echo json_encode($status);
    }

    /**
     * Reset / Buat Salt Baru untuk merotasi instan seluruh token aktif
     */
    function regenerate_salt(){
        $new_salt = 'ZYACBT_' . uniqid() . '_' . time();
        $this->cbt_konfigurasi_model->set_value('cbt_qr_secret_salt', $new_salt);

        $status['status'] = 1;
        $status['pesan'] = 'Kunci token berhasil dirotasi ulang secara instan!';
        echo json_encode($status);
    }
}
