<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends Member_Controller {
    function __construct(){
		parent:: __construct();
	}
    
    public function index(){
        // Pastikan menu modul-mapel terdaftar di user_menu & user_akses
        $cek_m = $this->db->where('kode_menu', 'modul-mapel')->get('user_menu');
        if($cek_m->num_rows() == 0){
            $this->db->insert('user_menu', array(
                'tipe' => 1,
                'parent' => 'modul',
                'kode_menu' => 'modul-mapel',
                'nama_menu' => 'Mata Pelajaran (Modul)',
                'url' => 'manager/modul_mapel',
                'icon' => 'fa fa-book',
                'urutan' => 0
            ));
        }
        $cek_a = $this->db->where('level', 'admin')->where('kode_menu', 'modul-mapel')->get('user_akses');
        if($cek_a->num_rows() == 0){
            $this->db->insert('user_akses', array(
                'level' => 'admin',
                'kode_menu' => 'modul-mapel',
                'add' => 1,
                'edit' => 1
            ));
        }

        // Pastikan guru memiliki akses ke import spreadsheet (Excel) & modul-mapel
        $cek_g_imp = $this->db->where('level', 'guru')->where('kode_menu', 'modul-import')->get('user_akses');
        if($cek_g_imp->num_rows() == 0){
            $this->db->insert('user_akses', array('level' => 'guru', 'kode_menu' => 'modul-import', 'add' => 1, 'edit' => 1));
        }
        $cek_g_map = $this->db->where('level', 'guru')->where('kode_menu', 'modul-mapel')->get('user_akses');
        if($cek_g_map->num_rows() == 0){
            $this->db->insert('user_akses', array('level' => 'guru', 'kode_menu' => 'modul-mapel', 'add' => 1, 'edit' => 1));
        }

        // Pastikan operator-soal memiliki akses ke import word & modul-mapel
        $cek_op_word = $this->db->where('level', 'operator-soal')->where('kode_menu', 'modul-import-word')->get('user_akses');
        if($cek_op_word->num_rows() == 0){
            $this->db->insert('user_akses', array('level' => 'operator-soal', 'kode_menu' => 'modul-import-word', 'add' => 1, 'edit' => 1));
        }
        $cek_op_map = $this->db->where('level', 'operator-soal')->where('kode_menu', 'modul-mapel')->get('user_akses');
        if($cek_op_map->num_rows() == 0){
            $this->db->insert('user_akses', array('level' => 'operator-soal', 'kode_menu' => 'modul-mapel', 'add' => 1, 'edit' => 1));
        }

        // Pastikan menu modul-import-json terdaftar di user_menu
        $cek_m_json = $this->db->where('kode_menu', 'modul-import-json')->get('user_menu');
        if($cek_m_json->num_rows() == 0){
            $this->db->insert('user_menu', array(
                'tipe' => 1,
                'parent' => 'modul',
                'kode_menu' => 'modul-import-json',
                'nama_menu' => 'Import Soal JSON / AI',
                'url' => 'manager/modul_import_json',
                'icon' => 'fa fa-code',
                'urutan' => 5
            ));
        }

        // Berikan hak akses modul-import-json ke admin, operator-soal, dan guru
        foreach(array('admin', 'operator-soal', 'guru') as $lvl){
            $cek_a_json = $this->db->where('level', $lvl)->where('kode_menu', 'modul-import-json')->get('user_akses');
            if($cek_a_json->num_rows() == 0){
                $this->db->insert('user_akses', array(
                    'level' => $lvl,
                    'kode_menu' => 'modul-import-json',
                    'add' => 1,
                    'edit' => 1
                ));
            }
        }

        $this->load->helper('form');
        $data['nama'] = $this->access->get_nama();

        $data['post_max_size'] = ini_get('post_max_size');
        $data['upload_max_filesize'] = ini_get('upload_max_filesize');
        $data['waktu_server'] = date('Y-m-d H:i:s');
		$data['timezone'] = date_default_timezone_get();

        $dir1 = './public/uploads/';
        $dir2 = './uploads/';

        $data['dir_public_uploads'] = 'Not Writeable';
        if(is_writable($dir1)){
        	$data['dir_public_uploads'] = 'Writeable';
        }

        $data['dir_uploads'] = 'Not Writeable';
        if(is_writable($dir2)){
        	$data['dir_uploads'] = 'Writeable';
        }

        // Statistik Real-time CBT
        $data['total_siswa'] = $this->db->count_all('cbt_user');
        $data['total_soal'] = $this->db->count_all('cbt_soal');
        $data['total_tes'] = $this->db->count_all('cbt_tes');
        $data['siswa_aktif_tes'] = $this->db->where('tesuser_status', 1)->count_all_results('cbt_tes_user');
        $data['siswa_login'] = $this->db->where('user_login', 1)->count_all_results('cbt_user');

        // Token Aktif Terkini
        $query_token = $this->db->select('token_isi, token_ts')->order_by('token_id', 'DESC')->limit(1)->get('cbt_tes_token');
        $data['token_aktif'] = ($query_token->num_rows() > 0) ? $query_token->row()->token_isi : '-';

        // Jadwal Tes Aktif / Hari Ini
        $this->db->select('tes_id, tes_nama, tes_begin_time, tes_end_time, tes_duration_time, tes_token');
        $this->db->where('tes_end_time >=', date('Y-m-d 00:00:00'));
        $this->db->order_by('tes_begin_time', 'DESC');
        $this->db->limit(5);
        $data['tes_berjalan'] = $this->db->get('cbt_tes')->result();

        if($this->access->get_level() == 'guru'){
            $this->template->display_admin('guru/guru_dashboard_view', 'Portal Guru CBT', $data);
            return;
        }

        $this->template->display_admin('manager/dashboard_view', 'Dashboard', $data);
    }
	
	function password(){
        $this->load->library('form_validation');
        
		$this->form_validation->set_rules('password-old', 'Password Lama','required|strip_tags');
		$this->form_validation->set_rules('password-new', 'Password Baru','required|strip_tags');
        $this->form_validation->set_rules('password-confirm', 'Confirm Password','required|strip_tags');
        
        if($this->form_validation->run() == TRUE){
			$old = $this->input->post('password-old', TRUE);
			$new = $this->input->post('password-new', TRUE);
			$confirm = $this->input->post('password-confirm', TRUE);
			
			$username = $this->access->get_username();
			
			if($this->users_model->get_user_count($username, $old)>0){
				if($new==$confirm){
					$this->users_model->change_password($username, $new);
					$status['status'] = 1;
					$status['error'] = '';
				}else{
					$status['status'] = 0;
					$status['error'] = 'Kedua password baru tidak sama';
				}
			}else{
				$status['status'] = 0;
				$status['error'] = 'Password Lama tidak Sesuai';
			}
        }else{
            $status['status'] = 0;
            $status['error'] = validation_errors();
        }
        
        echo json_encode($status);
    }
}