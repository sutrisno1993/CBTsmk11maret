<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Modul_mapel extends Member_Controller {
	private $kode_menu = 'modul-mapel';
	private $kelompok = 'modul';
	private $url = 'manager/modul_mapel';
	
    function __construct(){
		parent:: __construct();
		$this->load->model('cbt_modul_model');
		$this->load->model('cbt_topik_model');
		$this->load->model('cbt_soal_model');
		$this->load->model('cbt_tes_topik_set_model');

        // Bersihkan duplikat baris user_menu / user_akses untuk modul-mapel jika pernah terduplikasi
        $q_dup_akses = $this->db->where('kode_menu', $this->kode_menu)->where('level', 'admin')->order_by('id', 'ASC')->get('user_akses');
        if($q_dup_akses->num_rows() > 1){
            $rows_a = $q_dup_akses->result();
            for($k = 1; $k < count($rows_a); $k++){
                $this->db->where('id', $rows_a[$k]->id)->delete('user_akses');
            }
        }

        // Pastikan menu modul-mapel terdaftar di user_menu
        $cek_menu = $this->db->where('kode_menu', $this->kode_menu)->get('user_menu');
        if($cek_menu->num_rows() == 0){
            $this->db->insert('user_menu', array(
                'tipe' => 1,
                'parent' => 'modul',
                'kode_menu' => $this->kode_menu,
                'nama_menu' => 'Mata Pelajaran (Modul)',
                'url' => $this->url,
                'icon' => 'fa fa-book',
                'urutan' => 0
            ));
        }

        // Pastikan level admin memiliki hak akses ke modul-mapel
        $cek_akses = $this->db->where('kode_menu', $this->kode_menu)->where('level', 'admin')->get('user_akses');
        if($cek_akses->num_rows() == 0){
            $this->db->insert('user_akses', array(
                'level' => 'admin',
                'kode_menu' => $this->kode_menu,
                'add' => 1,
                'edit' => 1
            ));
        }

		parent::cek_akses($this->kode_menu);
	}
	
    public function index(){
        $data['kode_menu'] = $this->kode_menu;
        $data['url'] = $this->url;

        // Hitung ringkasan monitoring modul & topik untuk Executive Summary Cards
        $summary = $this->get_monitoring_summary();
        $data['summary'] = $summary;
        
        $this->template->display_admin($this->kelompok.'/modul_mapel_view', 'Mata Pelajaran (Modul)', $data);
    }

    /**
     * Tambah Topik Cepat langsung dari halaman Mata Pelajaran (Modul)
     */
    function tambah_topik_cepat(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('cepat-modul-id', 'Modul / Mata Pelajaran', 'required|integer|strip_tags');
        $this->form_validation->set_rules('cepat-topik-nama', 'Nama Topik', 'required|strip_tags');
        $this->form_validation->set_rules('cepat-topik-detail', 'Deskripsi Topik', 'required|strip_tags');

        if($this->form_validation->run() == TRUE){
            $modul_id = intval($this->input->post('cepat-modul-id', true));
            $topik_nama = trim($this->input->post('cepat-topik-nama', true));
            $topik_detail = trim($this->input->post('cepat-topik-detail', true));

            if($this->cbt_topik_model->count_by_topik_modul($topik_nama, $modul_id)->row()->hasil > 0){
                $status['status'] = 0;
                $status['pesan'] = 'Nama Topik sudah ada pada Mata Pelajaran ini!';
            }else{
                $level = $this->session->userdata('cbt_level');
                $user_id = $this->session->userdata('cbt_user_id');
                $user_obj = $this->users_model->get_user_by_username($user_id)->row();
                $data_topik = array(
                    'topik_modul_id' => $modul_id,
                    'topik_nama' => $topik_nama,
                    'topik_detail' => $topik_detail,
                    'topik_aktif' => 1,
                    'topik_tipe' => ($level == 'guru') ? 'uh' : 'panitia',
                    'topik_user_id' => (!empty($user_obj) && !empty($user_obj->id)) ? $user_obj->id : 0
                );
                $this->cbt_topik_model->save($data_topik);
                $status['status'] = 1;
                $status['pesan'] = 'Topik "'.$topik_nama.'" berhasil ditambahkan!';
            }
        }else{
            $status['status'] = 0;
            $status['pesan'] = validation_errors();
        }
        echo json_encode($status);
    }

    /**
     * Analisis kelengkapan topik (Tingkat X/XI/XII & 5 Jurusan SMK) untuk satu Modul
     */
    private function analyze_modul_topics($modul_id, $modul_nama, $topik_rows){
        $nama_upper = strtoupper($modul_nama);
        $is_kejuruan = (
            strpos($nama_upper, 'KEAHLIAN') !== false ||
            strpos($nama_upper, 'KEJURUAN') !== false ||
            strpos($nama_upper, 'MAPEL PILIHAN') !== false ||
            strpos($nama_upper, 'PRODUKTIF') !== false
        );

        // Deteksi apakah modul spesifik untuk 1 tingkat tertentu (misal "Kelas XII", "Kelas XI", "Kelas X")
        $specific_tingkat = '';
        if(preg_match('/\b(XII|12)\b/i', $modul_nama)){
            $specific_tingkat = 'XII';
        }else if(preg_match('/\b(XI|11)\b/i', $modul_nama)){
            $specific_tingkat = 'XI';
        }else if(preg_match('/\b(X|10)\b/i', $modul_nama)){
            $specific_tingkat = 'X';
        }

        $tingkat_found = array('X' => 0, 'XI' => 0, 'XII' => 0);
        $jurusan_found = array('TKR' => 0, 'TSM' => 0, 'TKJ' => 0, 'OTKP' => 0, 'AKL' => 0);

        $jurusan_aliases = array(
            'TKR'  => array('TKR', 'TKRO', 'OTOMOTIF'),
            'TSM'  => array('TSM', 'TBSM', 'OTOMOTIF'),
            'TKJ'  => array('TKJ', 'TJKT'),
            'OTKP' => array('OTKP', 'MPLB', 'MP', 'AP'),
            'AKL'  => array('AKL', 'AK')
        );

        $total_soal_modul = 0;
        $topik_kosong_count = 0;
        $topik_terjadwal_count = 0;
        $topik_details = array();

        foreach($topik_rows as $t){
            $t_upper = strtoupper($t->topik_nama);
            $t_tingkat = '';
            if(preg_match('/\b(XII|12)\b/', $t_upper)){
                $t_tingkat = 'XII';
                $tingkat_found['XII']++;
            }else if(preg_match('/\b(XI|11)\b/', $t_upper)){
                $t_tingkat = 'XI';
                $tingkat_found['XI']++;
            }else if(preg_match('/\b(X|10)\b/', $t_upper)){
                $t_tingkat = 'X';
                $tingkat_found['X']++;
            }else if(!empty($specific_tingkat)){
                $t_tingkat = $specific_tingkat;
                $tingkat_found[$specific_tingkat]++;
            }

            $t_jurusan_list = array();
            foreach($jurusan_aliases as $j_key => $aliases){
                foreach($aliases as $al){
                    if(preg_match('/\b'.preg_quote($al, '/').'\b/', $t_upper)){
                        $jurusan_found[$j_key]++;
                        $t_jurusan_list[] = $j_key;
                        break;
                    }
                }
            }

            $jml_soal = isset($t->jml_soal) ? intval($t->jml_soal) : 0;
            $jml_tes = isset($t->jml_tes) ? intval($t->jml_tes) : 0;
            $total_soal_modul += $jml_soal;
            if($jml_soal == 0){
                $topik_kosong_count++;
            }
            if($jml_tes > 0){
                $topik_terjadwal_count++;
            }

            $topik_details[] = array(
                'topik_id' => $t->topik_id,
                'topik_nama' => $t->topik_nama,
                'topik_detail' => $t->topik_detail,
                'topik_aktif' => $t->topik_aktif,
                'tingkat' => $t_tingkat,
                'jurusan' => !empty($t_jurusan_list) ? implode('/', $t_jurusan_list) : 'Umum',
                'jml_soal' => $jml_soal,
                'jml_tes' => $jml_tes
            );
        }

        // Cek kekurangan (Gap Analysis)
        $missing_items = array();
        $coverage_badges = '';

        if(count($topik_rows) == 0){
            $missing_items[] = 'Belum ada topik sama sekali';
        }else if($is_kejuruan){
            // Cek kelengkapan 5 jurusan utama SMK
            foreach(array('TKR', 'TSM', 'TKJ', 'OTKP', 'AKL') as $jk){
                if($jurusan_found[$jk] > 0){
                    $coverage_badges .= '<span class="label label-success" style="margin-right:3px; font-size:10px;" title="Topik jurusan '.$jk.' sudah tersedia"><i class="fa fa-check"></i> '.$jk.'</span>';
                }else{
                    $coverage_badges .= '<span class="label label-danger" style="margin-right:3px; font-size:10px;" title="Belum ada topik untuk jurusan '.$jk.'"><i class="fa fa-exclamation-circle"></i> '.$jk.'?</span>';
                    $missing_items[] = 'Jurusan '.$jk;
                }
            }
        }else{
            // Mapel Umum: Cek kelengkapan Tingkat X, XI, XII (kecuali mapel spesifik tingkat seperti IPAS/Informatika/PKK/Simulasi)
            $expected_tingkat = array('X', 'XI', 'XII');
            if(in_array($nama_upper, array('IPAS', 'INFORMATIKA'))){
                $expected_tingkat = array('X');
            }else if($nama_upper == 'PKK'){
                $expected_tingkat = array('XI', 'XII');
            }else if(strpos($nama_upper, 'SIMULASI') !== false || $nama_upper == 'DEFAULT'){
                $expected_tingkat = array();
            }else if(!empty($specific_tingkat)){
                $expected_tingkat = array($specific_tingkat);
            }

            foreach($expected_tingkat as $tk){
                if($tingkat_found[$tk] > 0){
                    $coverage_badges .= '<span class="label label-success" style="margin-right:3px; font-size:10px;" title="Topik Kelas '.$tk.' sudah tersedia"><i class="fa fa-check"></i> Kls '.$tk.'</span>';
                }else{
                    $coverage_badges .= '<span class="label label-warning" style="margin-right:3px; font-size:10px;" title="Belum ada topik untuk Kelas '.$tk.'"><i class="fa fa-exclamation-triangle"></i> Kls '.$tk.'?</span>';
                    $missing_items[] = 'Kelas '.$tk;
                }
            }
        }

        $is_warning = (!empty($missing_items) || $topik_kosong_count > 0 || count($topik_rows) == 0);

        return array(
            'jml_topik' => count($topik_rows),
            'total_soal' => $total_soal_modul,
            'topik_kosong' => $topik_kosong_count,
            'topik_terjadwal' => $topik_terjadwal_count,
            'is_kejuruan' => $is_kejuruan,
            'coverage_badges' => $coverage_badges,
            'missing_items' => $missing_items,
            'is_warning' => $is_warning,
            'topik_details' => $topik_details
        );
    }

    public function get_monitoring_summary(){
        $moduls = $this->db->order_by('modul_id', 'DESC')->get('cbt_modul')->result();
        $sql_topik = "
            SELECT t.*,
                   (SELECT COUNT(*) FROM cbt_soal s WHERE s.soal_topik_id = t.topik_id) AS jml_soal,
                   (SELECT COUNT(*) FROM cbt_tes_topik_set ts WHERE ts.tset_topik_id = t.topik_id) AS jml_tes
            FROM cbt_topik t
            ORDER BY t.topik_id ASC
        ";
        $all_topiks = $this->db->query($sql_topik)->result();
        $topik_by_modul = array();
        foreach($all_topiks as $tr){
            $topik_by_modul[$tr->topik_modul_id][] = $tr;
        }

        $total_modul = count($moduls);
        $total_topik = count($all_topiks);
        $total_soal_all = 0;
        $modul_lengkap = 0;
        $modul_perlu_perhatian = 0;
        $topik_kosong_all = 0;

        foreach($moduls as $m){
            $t_list = isset($topik_by_modul[$m->modul_id]) ? $topik_by_modul[$m->modul_id] : array();
            $an = $this->analyze_modul_topics($m->modul_id, $m->modul_nama, $t_list);
            $total_soal_all += $an['total_soal'];
            $topik_kosong_all += $an['topik_kosong'];
            if($an['is_warning']){
                $modul_perlu_perhatian++;
            }else{
                $modul_lengkap++;
            }
        }

        return array(
            'total_modul' => $total_modul,
            'total_topik' => $total_topik,
            'total_soal' => $total_soal_all,
            'modul_lengkap' => $modul_lengkap,
            'modul_perlu_perhatian' => $modul_perlu_perhatian,
            'topik_kosong' => $topik_kosong_all
        );
    }

    function tambah(){
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('tambah-nama', 'Nama Mata Pelajaran / Modul','required|strip_tags');
        
        if($this->form_validation->run() == TRUE){
            $data['modul_nama'] = trim($this->input->post('tambah-nama', true));
            $durasi = $this->input->post('tambah-durasi', true);
            $data['modul_durasi'] = !empty($durasi) ? intval($durasi) : 90;
            $data['modul_aktif'] = 1;

            if($this->cbt_modul_model->count_by_kolom('modul_nama', $data['modul_nama'])->row()->hasil > 0){
                $status['status'] = 0;
                $status['pesan'] = 'Nama Mata Pelajaran / Modul sudah ada!';
            }else{
				$this->cbt_modul_model->save($data);
                
                $status['status'] = 1;
                $status['pesan'] = 'Mata Pelajaran / Modul berhasil ditambahkan';
            }
        }else{
            $status['status'] = 0;
            $status['pesan'] = validation_errors();
        }
        
        echo json_encode($status);
    }
    
    function get_by_id($id=null){
    	$data['data'] = 0;
		if(!empty($id)){
			$query = $this->cbt_modul_model->get_by_kolom('modul_id', $id);
			if($query->num_rows() > 0){
				$query = $query->row();
				$data['data'] = 1;
				$data['id'] = $query->modul_id;
				$data['nama'] = $query->modul_nama;
                $data['durasi'] = !empty($query->modul_durasi) ? $query->modul_durasi : 90;
                $data['aktif'] = $query->modul_aktif;
			}
		}
		echo json_encode($data);
    }

    function edit(){
        $this->load->library('form_validation');
        
		$this->form_validation->set_rules('edit-id', 'ID','required|strip_tags');
		$this->form_validation->set_rules('edit-nama', 'Nama Modul','required|strip_tags');
        $this->form_validation->set_rules('edit-pilihan', 'Pilihan','required|strip_tags');
        
        if($this->form_validation->run() == TRUE){
            $pilihan = $this->input->post('edit-pilihan', true);
            $id = $this->input->post('edit-id', true);
            
            if($pilihan=='hapus'){
                // Cek apakah modul memiliki topik
            	if($this->cbt_topik_model->count_by_kolom('topik_modul_id', $id)->row()->hasil > 0){
            		$status['status'] = 0;
					$status['pesan'] = 'Modul tidak dapat dihapus karena masih memiliki data Topik Soal! Hapus atau pindahkan data Topik terlebih dahulu.';
            	}else{
            		$this->cbt_modul_model->delete('modul_id', $id);
					$status['status'] = 1;
					$status['pesan'] = 'Mata Pelajaran / Modul berhasil dihapus!';
            	}
            }else if($pilihan=='simpan'){
				$nama_asli = $this->input->post('edit-nama-asli', true);
                $data['modul_nama'] = trim($this->input->post('edit-nama', true));
                $durasi = $this->input->post('edit-durasi', true);
                $data['modul_durasi'] = !empty($durasi) ? intval($durasi) : 90;
                $data['modul_aktif'] = $this->input->post('edit-aktif', true) == '1' ? 1 : 0;

                if($nama_asli != $data['modul_nama'] && $this->cbt_modul_model->count_by_kolom('modul_nama', $data['modul_nama'])->row()->hasil > 0){
                    $status['status'] = 0;
                    $status['pesan'] = 'Nama Mata Pelajaran / Modul sudah terpakai!';
                }else{
                    $this->cbt_modul_model->update('modul_id', $id, $data);
                    
                    $status['status'] = 1;
                    $status['pesan'] = 'Mata Pelajaran / Modul berhasil diperbarui';
                }
            }
        }else{
            $status['status'] = 0;
            $status['pesan'] = validation_errors();
        }
        
        echo json_encode($status);
    }
    
    function get_datatable(){
		$search = "";
		$start = 0;
		$rows = 10;
		$filter_status = $this->input->get('filter_status', true);

		if (isset($_GET['sSearch']) && $_GET['sSearch'] != "" ) {
			$search = $_GET['sSearch'];
		}

		$start = $this->get_start();
		$rows = $this->get_rows();

		// Ambil semua modul yang cocok dengan pencarian
		$this->db->where('(modul_nama LIKE "%'.$this->db->escape_like_str($search).'%")')
		         ->from('cbt_modul')
		         ->order_by('modul_id', 'DESC');
		$all_matched_moduls = $this->db->get()->result();

		// Ambil seluruh topik beserta jumlah soal dan jumlah pemakaian di tes dalam 1 query cepat
		$sql_topik = "
			SELECT t.*,
			       (SELECT COUNT(*) FROM cbt_soal s WHERE s.soal_topik_id = t.topik_id) AS jml_soal,
			       (SELECT COUNT(*) FROM cbt_tes_topik_set ts WHERE ts.tset_topik_id = t.topik_id) AS jml_tes
			FROM cbt_topik t
			ORDER BY t.topik_nama ASC
		";
		$all_topiks = $this->db->query($sql_topik)->result();
		$topik_by_modul = array();
		foreach($all_topiks as $tr){
			$topik_by_modul[$tr->topik_modul_id][] = $tr;
		}

		// Filter berdasarkan status kelengkapan jika dipilih
		$filtered_moduls = array();
		foreach($all_matched_moduls as $m){
			$t_list = isset($topik_by_modul[$m->modul_id]) ? $topik_by_modul[$m->modul_id] : array();
			$analysis = $this->analyze_modul_topics($m->modul_id, $m->modul_nama, $t_list);
			$m->_analysis = $analysis;

			if($filter_status == 'perhatian' && !$analysis['is_warning']){
				continue;
			}
			if($filter_status == 'lengkap' && $analysis['is_warning']){
				continue;
			}
			$filtered_moduls[] = $m;
		}

		$iTotal = count($filtered_moduls);
		$paged_moduls = array_slice($filtered_moduls, $start, $rows);
	    
		$output = array(
			"sEcho" => isset($_GET['sEcho']) ? intval($_GET['sEcho']) : 1,
	        "iTotalRecords" => $iTotal,
	        "iTotalDisplayRecords" => $iTotal,
	        "aaData" => array()
	    );

		$i = $start;
	    foreach ($paged_moduls as $temp) {			
			$record = array();
			$an = $temp->_analysis;
			$jml_topik = $an['jml_topik'];
            
			$record[] = ++$i;

			// Bangun panel ekspansi (daftar topik di bawah modul ini)
			$expand_html = '<div id="panel-topik-'.$temp->modul_id.'" class="modul-topik-drawer" style="display:none; margin-top:10px; background:#f8fafc; border:1px solid #cbd5e1; border-left:4px solid #3c8dbc; border-radius:6px; padding:12px;">';
			$expand_html .= '<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px; padding-bottom:6px; border-bottom:1px solid #e2e8f0;">';
			$expand_html .= '<span style="font-weight:700; font-size:12.5px; color:#1e293b;"><i class="fa fa-folder-open text-primary"></i> Rincian Topik pada Modul '.htmlspecialchars($temp->modul_nama).' ('.$jml_topik.' Topik / '.$an['total_soal'].' Butir Soal)</span>';
			$expand_html .= '<button type="button" onclick="tambah_topik_cepat(\''.$temp->modul_id.'\', \''.htmlspecialchars(addslashes($temp->modul_nama)).'\')" class="btn btn-primary btn-xs"><i class="fa fa-plus-circle"></i> + Tambah Topik di Mapel Ini</button>';
			$expand_html .= '</div>';

			if(!empty($an['missing_items'])){
				$expand_html .= '<div class="alert alert-warning" style="padding:6px 10px; margin-bottom:8px; font-size:12px;">';
				$expand_html .= '<i class="fa fa-exclamation-triangle"></i> <b>Deteksi Kekurangan Topik:</b> Mapel ini terdeteksi belum memiliki topik untuk: <b>'.implode(', ', $an['missing_items']).'</b>.';
				$expand_html .= '</div>';
			}

			if($jml_topik > 0){
				$expand_html .= '<table class="table table-condensed table-bordered" style="margin-bottom:0; background:#fff; font-size:12px;">';
				$expand_html .= '<thead><tr style="background:#eef2f7; color:#334155;">';
				$expand_html .= '<th style="width:28px; text-align:center;">#</th>';
				$expand_html .= '<th>Nama Topik / Bank Soal</th>';
				$expand_html .= '<th style="width:110px; text-align:center;">Tingkat / Jurusan</th>';
				$expand_html .= '<th style="width:115px; text-align:center;">Jumlah Soal</th>';
				$expand_html .= '<th style="width:115px; text-align:center;">Status Jadwal</th>';
				$expand_html .= '<th style="width:170px; text-align:center;">Aksi Cepat</th>';
				$expand_html .= '</tr></thead><tbody>';

				$no_t = 0;
				foreach($an['topik_details'] as $td){
					$no_t++;
					$badge_tj = '';
					if(!empty($td['tingkat'])){
						$badge_tj .= '<span class="label label-default" style="margin-right:2px;">'.$td['tingkat'].'</span>';
					}
					$badge_tj .= '<span class="label label-info">'.$td['jurusan'].'</span>';

					if($td['jml_soal'] == 0){
						$badge_soal = '<span class="label label-danger" title="Belum ada butir soal!"><i class="fa fa-warning"></i> 0 Soal (Kosong)</span>';
					}else if($td['jml_soal'] < 20){
						$badge_soal = '<span class="label label-warning" title="Jumlah soal masih sedikit">'.$td['jml_soal'].' Butir Soal</span>';
					}else{
						$badge_soal = '<span class="label label-success"><i class="fa fa-check-circle"></i> '.$td['jml_soal'].' Butir Soal</span>';
					}

					if($td['jml_tes'] > 0){
						$badge_tes = '<span class="label label-primary" title="Sudah terhubung ke '.$td['jml_tes'].' Jadwal Tes"><i class="fa fa-calendar-check-o"></i> Terjadwal ('.$td['jml_tes'].')</span>';
					}else{
						$badge_tes = '<span class="label label-default" style="color:#555; background:#e2e8f0;">Belum Dijadwalkan</span>';
					}

					$expand_html .= '<tr>';
					$expand_html .= '<td style="text-align:center;">'.$no_t.'</td>';
					$expand_html .= '<td><b>'.htmlspecialchars($td['topik_nama']).'</b>';
					if(!empty($td['topik_detail'])){
						$expand_html .= '<div style="font-size:11px; color:#64748b;">'.htmlspecialchars($td['topik_detail']).'</div>';
					}
					$expand_html .= '</td>';
					$expand_html .= '<td style="text-align:center; vertical-align:middle;">'.$badge_tj.'</td>';
					$expand_html .= '<td style="text-align:center; vertical-align:middle;">'.$badge_soal.'</td>';
					$expand_html .= '<td style="text-align:center; vertical-align:middle;">'.$badge_tes.'</td>';
					$expand_html .= '<td style="text-align:center; vertical-align:middle;">';
					$expand_html .= '<a href="'.site_url('manager/modul_soal').'?topik_id='.$td['topik_id'].'" class="btn btn-primary btn-xs" style="margin-right:3px;" title="Input / Kelola Butir Soal"><i class="fa fa-pencil"></i> Soal</a>';
					$expand_html .= '<a href="'.site_url('manager/modul_daftar/preview/'.$td['topik_id']).'" target="_blank" class="btn btn-success btn-xs" style="margin-right:3px;" title="Preview Naskah Soal"><i class="fa fa-eye"></i> Preview</a>';
					$expand_html .= '<a href="'.site_url('manager/modul_import_word').'?topik_id='.$td['topik_id'].'" class="btn btn-default btn-xs" title="Import Soal Word"><i class="fa fa-file-word-o"></i></a>';
					$expand_html .= '</td>';
					$expand_html .= '</tr>';
				}
				$expand_html .= '</tbody></table>';
			}else{
				$expand_html .= '<div class="text-center text-muted" style="padding:12px; background:#fff; border:1px dashed #cbd5e1; border-radius:4px;">';
				$expand_html .= '<i class="fa fa-info-circle text-red"></i> Belum ada topik soal di dalam mata pelajaran ini. Silakan klik tombol <b>+ Tambah Topik di Mapel Ini</b> di sudut kanan atas.';
				$expand_html .= '</div>';
			}
			$expand_html .= '</div>';

			// Kolom Nama Modul + Tombol Ekspansi + Indikator Cakupan Tingkat/Jurusan
			$btn_chevron = '<button type="button" id="btn-exp-'.$temp->modul_id.'" onclick="toggle_topik(\''.$temp->modul_id.'\')" class="btn btn-xs btn-default" style="margin-right:8px; border-radius:4px; width:24px; text-align:center;" title="Klik untuk melihat / menyembunyikan daftar topik"><i id="icon-exp-'.$temp->modul_id.'" class="fa fa-chevron-right text-primary"></i></button>';
			$judul_modul = '<a href="javascript:void(0)" onclick="toggle_topik(\''.$temp->modul_id.'\')" style="color:#1e293b; font-weight:700; font-size:13.5px; text-decoration:none;">'.htmlspecialchars($temp->modul_nama).'</a>';

			$sub_info = '<div style="margin-top:4px; margin-left:32px; display:flex; align-items:center; flex-wrap:wrap; gap:4px;">';
			if(!empty($an['coverage_badges'])){
				$sub_info .= $an['coverage_badges'];
			}
			if(!empty($an['missing_items'])){
				$sub_info .= '<span class="label label-warning" style="font-size:10px;"><i class="fa fa-warning"></i> Kurang: '.implode(', ', $an['missing_items']).'</span>';
			}
			if($an['topik_kosong'] > 0){
				$sub_info .= '<span class="label label-danger" style="font-size:10px;"><i class="fa fa-exclamation-circle"></i> '.$an['topik_kosong'].' Topik Masih 0 Soal</span>';
			}
			$sub_info .= '</div>';

            $record[] = '<div>'.$btn_chevron.$judul_modul.$sub_info.$expand_html.'</div>';

            // Durasi pengerjaan default
            $durasi = !empty($temp->modul_durasi) ? $temp->modul_durasi : 90;
            $record[] = '<span class="badge bg-purple"><i class="fa fa-clock-o"></i> '.$durasi.' Menit</span>';

            // Kolom Jumlah Topik & Total Soal (Bisa diklik untuk expand)
            $badge_color = ($jml_topik == 0) ? 'bg-red' : (($an['is_warning']) ? 'bg-yellow' : 'bg-aqua');
            $topik_col = '<a href="javascript:void(0)" onclick="toggle_topik(\''.$temp->modul_id.'\')" title="Klik untuk ekspansi rincian topik">';
            $topik_col .= '<span class="badge '.$badge_color.'" style="font-size:12px; padding:4px 9px;"><i class="fa fa-folder-open-o"></i> '.$jml_topik.' Topik</span>';
            $topik_col .= '</a>';
            $topik_col .= '<div style="font-size:11px; color:#64748b; margin-top:3px;">Total: <b>'.$an['total_soal'].'</b> Soal</div>';
            $record[] = $topik_col;

            // Status aktif & kelengkapan
            $status_html = '';
            if($temp->modul_aktif == 1){
                $status_html .= '<span class="label label-success"><i class="fa fa-check"></i> Aktif</span>';
            }else{
                $status_html .= '<span class="label label-danger"><i class="fa fa-times"></i> Nonaktif</span>';
            }
            if(!$an['is_warning'] && $jml_topik > 0){
                $status_html .= '<div style="margin-top:4px;"><span class="label label-primary" style="font-size:9.5px;"><i class="fa fa-shield"></i> Topik Lengkap</span></div>';
            }else{
                $status_html .= '<div style="margin-top:4px;"><span class="label label-warning" style="font-size:9.5px;"><i class="fa fa-bell"></i> Cek Topik/Soal</span></div>';
            }
            $record[] = $status_html;

            $record[] = '
            	<button type="button" onclick="toggle_topik(\''.$temp->modul_id.'\')" class="btn btn-info btn-xs" style="margin-bottom:3px; width:100%;" title="Ekspansi Daftar Topik di sini"><i class="fa fa-chevron-down"></i> Rincian</button><br>
            	<button type="button" onclick="tambah_topik_cepat(\''.$temp->modul_id.'\', \''.htmlspecialchars(addslashes($temp->modul_nama)).'\')" class="btn btn-success btn-xs" style="margin-bottom:3px; width:100%;" title="Tambah Topik Baru ke Mapel ini"><i class="fa fa-plus"></i> +Topik</button><br>
            	<a onclick="edit(\''.$temp->modul_id.'\')" style="cursor: pointer; width:100%;" class="btn btn-default btn-xs" title="Edit Modul"><span class="glyphicon glyphicon-edit"></span> Edit</a>
            ';

			$output['aaData'][] = $record;
		}
        
		echo json_encode($output);
	}
	
	function get_start() {
		$start = 0;
		if (isset($_GET['iDisplayStart'])) {
			$start = intval($_GET['iDisplayStart']);
			if ($start < 0) $start = 0;
		}
		return $start;
	}

	function get_rows() {
		$rows = 10;
		if (isset($_GET['iDisplayLength'])) {
			$rows = intval($_GET['iDisplayLength']);
			if ($rows < 5 || $rows > 500) $rows = 10;
		}
		return $rows;
	}

    /**
     * Sinkronkan data modul, topik, dan grup jadwal STS Ganjil
     */
    function sync_jadwal(){
        $sql_file = FCPATH . 'sync_data_lokal.sql';
        if(file_exists($sql_file)){
            $sql = file_get_contents($sql_file);
            $queries = explode(";\n", $sql);
            foreach($queries as $query){
                $query = trim($query);
                if(!empty($query) && substr($query, 0, 2) != '--' && substr($query, 0, 2) != '/*'){
                    @$this->db->query($query);
                }
            }
            // Bersihkan sisa MM jika ada
            $this->db->query("DELETE FROM cbt_user_grup WHERE grup_nama LIKE '%MM%'");

            // Pastikan seluruh jadwal tes hasil sinkronisasi otomatis berskala 100 (Poin = 100 / Total Soal)
            $this->load->model('cbt_tes_model');
            $this->cbt_tes_model->normalisasi_skala_100();

            $status['status'] = 1;
            $status['pesan'] = 'Sinkronisasi data Mata Pelajaran, Topik STS, dan Kelas berhasil dimuat!';
        }else{
            $status['status'] = 0;
            $status['pesan'] = 'File sync_data_lokal.sql tidak ditemukan.';
        }
        echo json_encode($status);
    }
}
