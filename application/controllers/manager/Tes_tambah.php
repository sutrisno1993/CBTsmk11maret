<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* ZYA CBT
* Achmad Lutfi
* achmdlutfi@gmail.com
* achmadlutfi.wordpress.com
*/
class Tes_tambah extends Member_Controller {
	private $kode_menu = 'tes-tambah';
	private $kelompok = 'tes';
	private $url = 'manager/tes_tambah';
	
    function __construct(){
		parent:: __construct();
		$this->load->model('cbt_modul_model');
		$this->load->model('cbt_tes_model');
        $this->load->model('cbt_tes_user_model');
		$this->load->model('cbt_tesgrup_model');
		$this->load->model('cbt_user_grup_model');
		$this->load->model('cbt_tes_topik_set_model');
		$this->load->model('cbt_modul_model');
		$this->load->model('cbt_topik_model');
		$this->load->model('cbt_soal_model');

        parent::cek_akses($this->kode_menu);
	}
	
    public function index($tes_id=null){
        $data['kode_menu'] = $this->kode_menu;
        $data['url'] = $this->url;

        $is_edit = 0;
        if(!empty($tes_id)){
        	$query_tes = $this->cbt_tes_model->count_by_kolom('tes_id', $tes_id)->row()->hasil;
        	if($query_tes>0){
        		$is_edit = 1;
        	}
        }

        $tanggal_awal = date('Y-m-d 07:30');
        $tanggal_akhir = date('Y-m-d 09:00');
        
        $data['rentang_waktu'] = $tanggal_awal.' - '.$tanggal_akhir;

        $query_group = $this->cbt_user_grup_model->get_group();

        $group_list = array();
        $jurusan_set = array();
        if($query_group->num_rows()>0){
        	$select = '';
        	$query_group = $query_group->result();
        	foreach ($query_group as $temp) {
                $info = $this->parse_grup_nama($temp->grup_nama);
                $is_selected = 0;
        		if($is_edit!=0){
        			if($this->cbt_tesgrup_model->count_by_tes_and_group($tes_id, $temp->grup_id)->row()->hasil>0){
                        $is_selected = 1;
        				$select = $select.'<option value="'.$temp->grup_id.'" selected>'.$temp->grup_nama.'</option>';
        			}else{
        				$select = $select.'<option value="'.$temp->grup_id.'">'.$temp->grup_nama.'</option>';
        			}
        		}else{
        			$select = $select.'<option value="'.$temp->grup_id.'">'.$temp->grup_nama.'</option>';
        		}

                if(!empty($info['jurusan'])){
                    $jurusan_set[$info['jurusan']] = true;
                }

                $group_list[] = array(
                    'id' => $temp->grup_id,
                    'nama' => $temp->grup_nama,
                    'tingkat' => $info['tingkat'],
                    'jurusan' => $info['jurusan'],
                    'selected' => $is_selected
                );
        	}

        }else{
        	$select = '<option value="0">Tidak Ada Group</option>';
        }
        $data['select_group'] = $select;
        $data['group_list'] = $group_list;
        
        // 5 Jurusan Utama SMK 11 Maret: TKR, TSM, TKJ, OTKP, AK
        $default_jurusan = array('TKR', 'TSM', 'TKJ', 'OTKP', 'AK');
        $jurusan_keys = $default_jurusan;
        foreach (array_keys($jurusan_set) as $j) {
            if (!in_array($j, $jurusan_keys)) {
                $jurusan_keys[] = $j;
            }
        }
        $data['jurusan_list'] = $jurusan_keys;

        $query_modul = $this->cbt_modul_model->get_modul();
        $counter = 0;
        if($query_modul->num_rows()>0){
        	$select = '';
        	$query_modul = $query_modul->result();
        	foreach ($query_modul as $temp) {
                $select = $select.'<option value="'.$temp->modul_id.'">'.$temp->modul_nama.'</option>';
                $counter++;
        	}
        }
        if($counter==0){
        	$select = '<option value="kosong">Tidak Ada Modul</option>';
        }
        $data['select_modul'] = $select;

        if($is_edit!=0){
        	$data['data_tes'] = '
        		edit(\''.$tes_id.'\');
        	';
        }
        
        $this->template->display_admin($this->kelompok.'/tes_tambah_view', 'Tambah Tes', $data);
    }

    function get_topik_by_modul($modul=null){
        $data['data']=0;

        $data['select_topik'] = '<option value="kosong">Tidak Ada Topik</option>';
        if(!empty($modul)){
            $data['data']=1;
            $level = $this->session->userdata('cbt_level');
            if($level == 'guru'){
                $user_id = $this->session->userdata('cbt_user_id');
                $user_obj = $this->users_model->get_user_by_username($user_id)->row();
                $uid = (!empty($user_obj) && !empty($user_obj->id)) ? $user_obj->id : 0;
                $query_topik = $this->cbt_topik_model->get_by_tipe_user('uh', $uid, $modul);
            }else{
                $query_topik = $this->cbt_topik_model->get_by_kolom('topik_modul_id', $modul);
            }

            if($query_topik->num_rows()){
                $query_topik = $query_topik->result();
                $select = '';
                foreach ($query_topik as $topik) {
                    $jml_soal = $this->cbt_soal_model->count_by_kolom('soal_topik_id', $topik->topik_id)->row()->hasil;
                    $select = $select.'<option value="'.$topik->topik_id.'">'.$topik->topik_nama.' ['.$jml_soal.' soal]</option>';
                }

                $data['select_topik'] = $select;
            }
        }

        echo json_encode($data);
    }

    function tambah_tes(){
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('tambah-nama', 'Nama Tes','required|strip_tags');
        $this->form_validation->set_rules('tambah-deskripsi', 'Deskripsi Tes','required|strip_tags');
        $this->form_validation->set_rules('tambah-rentang-waktu', 'Rentang Waktu Pengerjaan Tes','required|strip_tags');
        $this->form_validation->set_rules('tambah-waktu', 'Waktu Pengerjaan Tes','required|integer|strip_tags');
        $this->form_validation->set_rules('tambah-group[]', 'Grup','required|strip_tags');
        $this->form_validation->set_rules('tambah-poin', 'Poin Dasar','required|numeric|strip_tags');
        $this->form_validation->set_rules('tambah-poin-salah', 'Poin Jawaban Salah','required|numeric|strip_tags');
        $this->form_validation->set_rules('tambah-poin-kosong', 'Poin Jawaban Kosong','required|numeric|strip_tags');
        
        if($this->form_validation->run() == TRUE){
        	$tes_id = $this->input->post('tambah-id', true);
        	$nama_lama = $this->input->post('tambah-nama-lama', true);
            $data['tes_nama'] = $this->input->post('tambah-nama', true);
            $data['tes_detail'] = $this->input->post('tambah-deskripsi', true);
            $data['tes_duration_time'] = $this->input->post('tambah-waktu', true);
            $data['tes_score_right'] = $this->input->post('tambah-poin', true);
            $data['tes_score_wrong'] = $this->input->post('tambah-poin-salah', true);
            $data['tes_score_unanswered'] = $this->input->post('tambah-poin-kosong', true);

            $tunjukkan_hasil = $this->input->post('tambah-tunjukkan-hasil', true);
            if(!empty($tunjukkan_hasil)){
            	$data['tes_results_to_users'] = $tunjukkan_hasil;
            }else{
            	$data['tes_results_to_users'] = '0';
            }

            $detail_hasil = $this->input->post('tambah-detail-hasil', true);
            if(!empty($detail_hasil)){
                $data['tes_detail_to_users'] = $detail_hasil;
            }else{
                $data['tes_detail_to_users'] = '0';
            }
            
            $token = $this->input->post('tambah-token', true);
            if(!empty($token)){
            	$data['tes_token'] = $token;
            }else{
            	$data['tes_token'] = '0';
            }

            $rentang_waktu = $this->input->post('tambah-rentang-waktu', true);
            $tanggal = explode(" - ", $rentang_waktu);
            $data['tes_begin_time'] = $tanggal[0];
            $data['tes_end_time'] = $tanggal[1];

            $hari = $this->input->post('tambah-hari', true);
            if(!empty($hari)){
                $data['tes_hari'] = $hari;
            }else{
                $data['tes_hari'] = NULL;
            }

            $shift = $this->input->post('tambah-shift', true);
            if(!empty($shift)){
                $data['tes_shift'] = $shift;
            }else{
                $data['tes_shift'] = NULL;
            }

            $jam_ke = $this->input->post('tambah-jam-ke', true);
            if(!empty($jam_ke)){
                $data['tes_jam_ke'] = $jam_ke;
            }else{
                $data['tes_jam_ke'] = NULL;
            }

            $cek_nama = 1;
            if(!empty($nama_lama)){
            	if($nama_lama==$data['tes_nama']){
            		$cek_nama = 0;
            	}
            }

            if($cek_nama==1 and $this->cbt_tes_model->count_by_kolom('tes_nama', $data['tes_nama'])->row()->hasil>0){
            	$status['status'] = 0;
            	$status['pesan'] = 'Nama Tes sudah digunakan, silahkan menggunakan yang lainnya';
            }else{
                $is_process = 1;
            	// Menyimpan data tes
            	if(empty($tes_id)){
            		$tes_id = $this->cbt_tes_model->save($data);
            	}else{
            		// Cek dulu apakah kondisi tes sudah berjalan
                    if($this->cbt_tes_user_model->count_by_kolom('tesuser_tes_id', $tes_id)->row()->hasil>0){
                        $data_time['tes_begin_time'] = $data['tes_begin_time'];
                        $data_time['tes_end_time'] = $data['tes_end_time'];
                        $data_time['tes_hari'] = $data['tes_hari'];
                        $data_time['tes_shift'] = $data['tes_shift'];
                        $data_time['tes_jam_ke'] = $data['tes_jam_ke'];
                        $this->cbt_tes_model->update('tes_id', $tes_id, $data_time);

                        $status['status'] = 0;
                        $status['pesan'] = 'Rentang Waktu, Hari, Shift, dan Jam Ke Tes saja yang dapat diubah, karena Tes masih digunakan.';
                        $is_process = 0;
                    }else{
                        $this->cbt_tes_model->update('tes_id', $tes_id, $data);
                    }
            	}

                if($is_process==1){
                    // Menyimpan data group yang mengikuti tes
                    $groups = $this->input->post('tambah-group', true);
                    // menghapus data group berdasarkan tes terlebih dahulu
                    $this->cbt_tesgrup_model->delete('tstgrp_tes_id', $tes_id);
                    if(is_array($groups)){
                        foreach ($groups as $group) {
                            $data_group['tstgrp_tes_id'] = $tes_id;
                            $data_group['tstgrp_grup_id'] = $group;

                            // Jika group tidak kosong
                            if(!empty($group) && $group != '0'){
                                $this->cbt_tesgrup_model->save($data_group);
                            }
                        }
                    }

                    // Mengupdate score maximal
                    $data_tes['tes_max_score'] = $this->hitung_skor($tes_id);
                    $this->cbt_tes_model->update('tes_id', $tes_id, $data_tes);
                    $status['max_score']=$data_tes['tes_max_score'];
                    

                    if(!empty($tes_id)){
                        $status['status'] = 1;
                        $status['tes_id'] = $tes_id;
                        $status['tes_nama'] = $data['tes_nama'];
                        $status['pesan'] = 'Tes berhasil disimpan, silahkan mengecek data Soal';
                    }else{
                        $status['status'] = 1;
                        $status['tes_id'] = $tes_id;
                        $status['pesan'] = 'Tes berhasil ditambahkan, silahkan menambah data Soal';
                    }
                }
            }
        }else{
            $status['status'] = 0;
            $status['pesan'] = validation_errors();
        }
        
        echo json_encode($status);
    }

    function tambah_soal(){
    	$this->load->library('form_validation');
        
        $this->form_validation->set_rules('soal-tes-id', 'Tes','required|strip_tags');
        $this->form_validation->set_rules('soal-topik', 'Topik','required|strip_tags');
        $this->form_validation->set_rules('soal-jml', 'Jumlah Soal','required|greater_than[1]|integer|strip_tags');
        $this->form_validation->set_rules('soal-tipe', 'Tipe Soal','required|strip_tags');
        $this->form_validation->set_rules('soal-kesulitan', 'Tingkat Kesulitan','required|strip_tags');
        $this->form_validation->set_rules('soal-jml-jawaban', 'Jumlah Jawaban','required|greater_than[2]|integer|strip_tags');
        
        if($this->form_validation->run() == TRUE){
        	$data['tset_tes_id'] = $this->input->post('soal-tes-id', true);
        	$data['tset_topik_id'] = $this->input->post('soal-topik', true);
        	$data['tset_tipe'] = $this->input->post('soal-tipe', true);
        	$data['tset_difficulty'] = $this->input->post('soal-kesulitan', true);
        	$data['tset_jumlah'] = $this->input->post('soal-jml', true);
            $data['tset_jawaban'] = $this->input->post('soal-jml-jawaban', true);
            
            $acak_soal = $this->input->post('soal-acak-soal', true);
            if(!empty($acak_soal)){
                $data['tset_acak_soal'] = $acak_soal;
            }else{
                $data['tset_acak_soal'] = '0';
            }

            $acak_jawaban = $this->input->post('soal-acak-jawaban', true);
            if(!empty($acak_jawaban)){
                $data['tset_acak_jawaban'] = $acak_jawaban;
            }else{
                $data['tset_acak_jawaban'] = '0';
            }


        	// Cek dulu apakah kondisi tes sudah berjalan
            if($this->cbt_tes_user_model->count_by_kolom('tesuser_tes_id', $data['tset_tes_id'])->row()->hasil>0){
                $status['status'] = 0;
                $status['pesan'] = 'Data Soal tidak bisa di tambah. Tes masih digunakan.';
            }else{
                $jml_soal = $this->cbt_soal_model->count_by_kolom('soal_topik_id', $data['tset_topik_id'])->row()->hasil;

                // Apakah jml soal yang dimasukkan sudah sesuai dengan jumlah soal pada topik
                if($data['tset_jumlah']<=$jml_soal){
                    // Cek apakah soal sudah ada pada tabel subject_set sebelumnya
                    if($this->cbt_tes_topik_set_model->count_by_test_topik($data['tset_tes_id'], $data['tset_topik_id'])->row()->hasil>0){
                        $status['status'] = 0;
                        $status['pesan'] = 'Data soal sudah terdapat pada Tes, silahkan cek kembali';
                    }else{
                        $this->cbt_tes_topik_set_model->save($data);

                        $status['status'] = 1;
                        $status['pesan'] = 'Soal berhasil ditambahkan';

                        // update max score di table ctb_test
                        $data_tes['tes_max_score'] = $this->hitung_skor($data['tset_tes_id']);
                        $this->cbt_tes_model->update('tes_id', $data['tset_tes_id'], $data_tes);
                        $status['max_score']=$data_tes['tes_max_score'];
                    }
                }else{
                    $status['status'] = 0;
                    $status['pesan'] = 'Jumlah soal pada Topik lebih sedikit dari Jumlah Soal yang diminta';
                }
            }   
        }else{
        	$status['status'] = 0;
            $status['pesan'] = validation_errors();
        }

        echo json_encode($status);
    }

    function hapus_soal_by_id($id=null){
    	$data['data'] = 0;
		if(!empty($id)){
			// Cek dulu apakah kondisi tes sudah berjalan
            $query_soal = $this->cbt_tes_topik_set_model->get_by_kolom_limit('tset_id', $id, 1)->row();
            if($this->cbt_tes_user_model->count_by_kolom('tesuser_tes_id', $query_soal->tset_tes_id)->row()->hasil>0){
                $data['data'] = 0;
                $data['pesan'] = 'Data Soal tidak bisa di hapus. Tes masih digunakan.';
            }else{
                // hapus soal dari tes
                $this->cbt_tes_topik_set_model->delete('tset_id', $id);
                $data['data'] = 1;
                $data['pesan'] = 'Data Soal berhasil dihapus';

                // update max score di table ctb_test
                $data_tes['tes_max_score'] = $this->hitung_skor($query_soal->tset_tes_id);
                $this->cbt_tes_model->update('tes_id', $query_soal->tset_tes_id, $data_tes);
                $data['max_score'] = $data_tes['tes_max_score'];
            }
		}
		echo json_encode($data);
    }

    private function hitung_skor($tes_id=null){
        $max_score = 0;
        if(!empty($tes_id)){
            $query_tes = $this->cbt_tes_model->get_by_kolom_limit('tes_id', $tes_id, 1);
            if($query_tes->num_rows()>0){
                $query_tes = $query_tes->row();
                $query_soal = $this->cbt_tes_topik_set_model->get_by_kolom('tset_tes_id', $tes_id)->result();
                foreach ($query_soal as $soal) {
                    $max_score = $max_score+($soal->tset_jumlah*$query_tes->tes_score_right);
                }
            }
        }
        return $max_score;
    }
    
    function get_by_id($id=null){
    	$data['data'] = 0;
		if(!empty($id)){
			$query = $this->cbt_tes_model->get_by_kolom('tes_id', $id);
			if($query->num_rows()>0){
				$query = $query->row();
				$data['data'] = 1;
				$data['id'] = $query->tes_id;
				$data['nama'] = $query->tes_nama;
				$data['deskripsi'] = $query->tes_detail;
				$data['waktu'] = $query->tes_duration_time;
	            $data['poin'] = $query->tes_score_right;
	            $data['poin_salah'] = $query->tes_score_wrong;
	            $data['poin_kosong'] = $query->tes_score_unanswered;
	            $data['tunjukkan_hasil'] = $query->tes_results_to_users;
                $data['detail_hasil'] = $query->tes_detail_to_users;
	            $data['token'] = $query->tes_token;
	            $data['rentang_waktu'] = $query->tes_begin_time.' - '.$query->tes_end_time;
	            $data['hari'] = !empty($query->tes_hari) ? $query->tes_hari : '';
	            $data['shift'] = !empty($query->tes_shift) ? $query->tes_shift : '';
	            $data['jam_ke'] = !empty($query->tes_jam_ke) ? $query->tes_jam_ke : '';

                // Ambil daftar grup yang terpilih untuk tes ini
                $grup_query = $this->cbt_tesgrup_model->get_by_tes_id($id);
                $group_ids = array();
                if($grup_query->num_rows() > 0){
                    foreach($grup_query->result() as $g){
                        $group_ids[] = $g->tstgrp_grup_id;
                    }
                }
                $data['group_ids'] = $group_ids;
			}
		}
		echo json_encode($data);
    }
    
    function get_datatable_soal(){
    	$tes_id = $this->input->get('tes-id');

		// variable initialization
		$search = "";
		$start = 0;
		$rows = 10;

		// get search value (if any)
		if (isset($_GET['sSearch']) && $_GET['sSearch'] != "" ) {
			$search = $_GET['sSearch'];
		}

		// limit
		$start = $this->get_start();
		$rows = $this->get_rows();

		// run query to get user listing
		$query = $this->cbt_tes_topik_set_model->get_datatable($start, $rows, $tes_id);
		$iFilteredTotal = $query->num_rows();
		
		$iTotal= $this->cbt_tes_topik_set_model->get_datatable_count($tes_id)->row()->hasil;
	    
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
	        "iTotalRecords" => $iTotal,
	        "iTotalDisplayRecords" => $iTotal,
	        "aaData" => array()
	    );

	    // get result after running query and put it in array
		$i=$start;
		$query = $query->result();
	    foreach ($query as $temp) {			
			$record = array();
            
            $record[] = ++$i;
            
            $ket_acak = '';
            if($temp->tset_acak_soal==1){
                $ket_acak = $ket_acak.' Acak Soal=YA';
            }else{
                $ket_acak = $ket_acak.' Acak Soal=TDK';
            }
            if($temp->tset_acak_jawaban==1){
                $ket_acak = $ket_acak.'; Acak JWB=YA';
            }else{
                $ket_acak = $ket_acak.'; Acak JWB=TDK';
            }
			
			$query_topik = $this->cbt_topik_model->get_by_kolom_limit('topik_id', $temp->tset_topik_id, 1)->row();
			$query_modul = $this->cbt_modul_model->get_by_kolom_limit('modul_id', $query_topik->topik_modul_id, 1)->row();
			
			if(!empty($query_modul->modul_nama)){
				$record[] = 'Modul '.$query_modul->modul_nama.'<br />'.$query_topik->topik_nama.' ['.$temp->tset_jumlah.'] ['.$temp->tset_jawaban.']'.$ket_acak;
			}else{
				$record[] = $query_topik->topik_nama.' ['.$temp->tset_jumlah.'] ['.$temp->tset_jawaban.']'.$ket_acak;
			}
            $record[] = '<a onclick="hapus_soal(\''.$temp->tset_id.'\')" title="Hapus Daftar Soal" style="cursor: pointer;" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-remove"></span></a>';

			$output['aaData'][] = $record;
		}
		// format it to JSON, this output will be displayed in datatable
        
		echo json_encode($output);
	}
	
	/**
	* funsi tambahan 
	* 
	* 
*/
	
    private function parse_grup_nama($grup_nama){
        $tingkat = '';
        $jurusan = '';
        $nama = trim($grup_nama);

        // Deteksi Tingkat
        if (preg_match('/\b(XII|12)\b/i', $nama)) {
            $tingkat = 'XII';
        } elseif (preg_match('/\b(XI|11)\b/i', $nama)) {
            $tingkat = 'XI';
        } elseif (preg_match('/\b(X|10)\b/i', $nama)) {
            $tingkat = 'X';
        }

        // 1. Pemetaan 5 Jurusan Utama SMK 11 Maret beserta alias
        $primary_majors = array(
            'TKR'  => array('TKR', 'TKRO'),
            'TSM'  => array('TSM', 'TBSM'),
            'TKJ'  => array('TKJ'),
            'OTKP' => array('OTKP', 'MP', 'AP'),
            'AK'   => array('AK', 'AKL'),
        );
        $nama_upper = strtoupper($nama);
        foreach ($primary_majors as $utama => $aliases) {
            foreach ($aliases as $alias) {
                if (preg_match('/\b' . preg_quote($alias, '/') . '\b/', $nama_upper)) {
                    $jurusan = $utama;
                    break 2;
                }
            }
        }

        // 2. Deteksi Jurusan SMK umum lainnya jika bukan dari 5 jurusan utama
        if (empty($jurusan)) {
            $other_majors = array('RPL', 'DKV', 'BDP', 'PM', 'TB', 'TP', 'TITL', 'TEI');
            foreach ($other_majors as $m) {
                if (preg_match('/\b' . preg_quote($m, '/') . '\b/', $nama_upper)) {
                    $jurusan = $m;
                    break;
                }
            }
        }

        // Jika belum ketemu lewat daftar umum, ambil kata setelah tingkat
        if (empty($jurusan)) {
            $clean = preg_replace('/[-_]/', ' ', $nama);
            $parts = preg_split('/\s+/', trim($clean));
            foreach ($parts as $idx => $part) {
                if (preg_match('/^(X|XI|XII|10|11|12|KELAS)$/i', $part)) {
                    if (isset($parts[$idx + 1]) && !preg_match('/^(X|XI|XII|10|11|12)$/i', $parts[$idx + 1])) {
                        if (!is_numeric($parts[$idx + 1])) {
                            $jurusan = strtoupper($parts[$idx + 1]);
                            break;
                        }
                    }
                }
            }
        }

        return array('tingkat' => $tingkat, 'jurusan' => $jurusan);
    }

	function get_start() {
		$start = 0;
		if (isset($_GET['iDisplayStart'])) {
			$start = intval($_GET['iDisplayStart']);

			if ($start < 0)
				$start = 0;
		}

		return $start;
	}

	function get_rows() {
		$rows = 10;
		if (isset($_GET['iDisplayLength'])) {
			$rows = intval($_GET['iDisplayLength']);
			if ($rows < 5 || $rows > 500) {
				$rows = 10;
			}
		}

		return $rows;
	}

	function get_sort_dir() {
		$sort_dir = "ASC";
		$sdir = strip_tags($_GET['sSortDir_0']);
		if (isset($sdir)) {
			if ($sdir != "asc" ) {
				$sort_dir = "DESC";
			}
		}

		return $sort_dir;
	}
}