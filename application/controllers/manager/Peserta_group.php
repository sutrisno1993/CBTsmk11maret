<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Peserta_group extends Member_Controller {
	private $kode_menu = 'peserta-group';
	private $kelompok = 'peserta';
	private $url = 'manager/peserta_group';
	
    function __construct(){
		parent:: __construct();
		$this->load->model('cbt_user_grup_model');
		$this->load->model('cbt_tesgrup_model');
		$this->load->model('cbt_user_model');

		parent::cek_akses($this->kode_menu);
	}
	
    public function index(){
        $data['kode_menu'] = $this->kode_menu;
        $data['url'] = $this->url;
        $data['all_groups'] = $this->cbt_user_grup_model->get_group()->result();
        
        $this->template->display_admin($this->kelompok.'/peserta_group_view', 'Daftar Group', $data);
    }

    /**
     * Signature kanonik kelas SMK untuk mencegah pembuatan kelas ganda/sinonim (misal X TSM 1 vs X TBSM 1)
     */
    private function get_class_canonical_signature($nama_kelas){
        $clean = strtoupper(trim($nama_kelas));
        $clean = preg_replace('/[\-\_\.\/]+/', ' ', $clean);
        $clean = preg_replace('/\s+/', ' ', $clean);
        $clean = preg_replace('/^(KELAS|KLS)\s+/', '', $clean);

        $parts = explode(' ', $clean);
        if(count($parts) < 2){
            return 'RAW|' . $clean;
        }

        $tingkat_raw = $parts[0];
        $tingkat = $tingkat_raw;
        if($tingkat_raw === '10' || $tingkat_raw === 'X') $tingkat = 'X';
        else if($tingkat_raw === '11' || $tingkat_raw === 'XI') $tingkat = 'XI';
        else if($tingkat_raw === '12' || $tingkat_raw === 'XII') $tingkat = 'XII';

        $jurusan_raw = $parts[1];
        $jurusan_map = array(
            'TSM' => 'MOT', 'TBSM' => 'MOT',
            'TKR' => 'MOB', 'TKRO' => 'MOB',
            'TKJ' => 'JAR', 'TJKT' => 'JAR',
            'OTKP' => 'PER', 'MPLB' => 'PER', 'MP' => 'PER', 'AP' => 'PER',
            'AKL' => 'AKU', 'AK' => 'AKU'
        );
        $jurusan = isset($jurusan_map[$jurusan_raw]) ? $jurusan_map[$jurusan_raw] : $jurusan_raw;

        $rombel = '';
        if(isset($parts[2])){
            $sisa = array_slice($parts, 2);
            $rombel_str = implode(' ', $sisa);
            $rombel = is_numeric($rombel_str) ? strval(intval($rombel_str)) : $rombel_str;
        }

        return $tingkat . '|' . $jurusan . '|' . $rombel;
    }

    private function find_synonym_group($nama_baru, $exclude_id = 0){
        $sig_baru = $this->get_class_canonical_signature($nama_baru);
        if(strpos($sig_baru, 'RAW|') === 0){
            return null;
        }
        $all = $this->cbt_user_grup_model->get_group()->result();
        foreach($all as $g){
            if(intval($g->grup_id) === intval($exclude_id)) continue;
            if($this->get_class_canonical_signature($g->grup_nama) === $sig_baru){
                return $g;
            }
        }
        return null;
    }

    function tambah(){
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('tambah-group', 'Nama Group','required|strip_tags');
        
        if($this->form_validation->run() == TRUE){
            $data['grup_nama'] = trim($this->input->post('tambah-group', true));

            if($this->cbt_user_grup_model->count_by_kolom('grup_nama', $data['grup_nama'])->row()->hasil>0){
                $status['status'] = 0;
                $status['pesan'] = 'Nama Group sudah terpakai !';
            }else{
                $syn = $this->find_synonym_group($data['grup_nama']);
                if($syn !== null){
                    $status['status'] = 0;
                    $status['pesan'] = '<b>Screening Duplikasi Kelas SMK:</b> Kelas <b>"'.htmlspecialchars($data['grup_nama']).'"</b> identik/sinonim dengan Kelas Resmi <b>"'.htmlspecialchars($syn->grup_nama).'"</b> yang sudah ada! Gunakan kelas tersebut agar jadwal ujian siswa tidak terpecah.';
                }else{
				    $this->cbt_user_grup_model->save($data);
                    $status['status'] = 1;
                    $status['pesan'] = 'Group berhasil disimpan ';
                }
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
			$query = $this->cbt_user_grup_model->get_by_kolom('grup_id', $id);
			if($query->num_rows()>0){
				$query = $query->row();
				$data['data'] = 1;
				$data['id'] = $query->grup_id;
				$data['group'] = $query->grup_nama;
			}
		}
		echo json_encode($data);
    }

    function edit(){
        $this->load->library('form_validation');
        
		$this->form_validation->set_rules('edit-id', 'ID','required|strip_tags');
		$this->form_validation->set_rules('edit-group', 'Nama Group','required|strip_tags');
        $this->form_validation->set_rules('edit-pilihan', 'Pilihan','required|strip_tags');
        $this->form_validation->set_rules('edit-group-asli', 'Nama Group','required|strip_tags');
        
        if($this->form_validation->run() == TRUE){
            $pilihan = $this->input->post('edit-pilihan', true);
            $id = $this->input->post('edit-id', true);
            
            if($pilihan=='hapus'){//hapus
            	if($this->cbt_tesgrup_model->count_by_kolom('tstgrp_grup_id', $id)->row()->hasil>0){
            		$status['status'] = 0;
					$status['pesan'] = 'Group tidak dapat dihapus, Group masih digunakan Tes !';
            	}else{
            		$this->cbt_user_grup_model->delete('grup_id', $id);
					$status['status'] = 1;
					$status['pesan'] = 'Group berhasil dihapus !';
            	}
            }else if($pilihan=='simpan'){//simpan
				$group_asli = $this->input->post('edit-group-asli', true);
                $data['grup_nama'] = $this->input->post('edit-group', true);

                if($group_asli!=$data['grup_nama']){
                	if($this->cbt_user_grup_model->count_by_kolom('grup_nama', $data['grup_nama'])->row()->hasil>0){
		                $status['status'] = 0;
		                $status['pesan'] = 'Nama Group sudah terpakai !';
		            }else{
						$this->cbt_user_grup_model->update('grup_id', $id, $data);
		                
		                $status['status'] = 1;
		                $status['pesan'] = 'Group berhasil disimpan ';
		            }
                }else{
                	$status['status'] = 1;
                	$status['pesan'] = 'Group Berhasil disimpan';
                }
            }
            
        }else{
            $status['status'] = 0;
            $status['pesan'] = validation_errors();
        }
        
        echo json_encode($status);
    }
    
    function get_datatable(){
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
		$query = $this->cbt_user_grup_model->get_datatable($start, $rows, 'grup_nama', $search);
		$iFilteredTotal = $query->num_rows();
		
		$iTotal= $this->cbt_user_grup_model->get_datatable_count('grup_nama', $search)->row()->hasil;
	    
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
            $record[] = '<b>'.htmlspecialchars($temp->grup_nama).'</b>';

            $jml_siswa = $this->db->where('user_grup_id', $temp->grup_id)->count_all_results('cbt_user');
            $badge_siswa = ($jml_siswa > 0) ? '<span class="badge bg-green">'.$jml_siswa.' Siswa</span>' : '<span class="badge bg-gray">0 Siswa</span>';
            $record[] = $badge_siswa;

            $jml_tes = $this->db->where('tstgrp_grup_id', $temp->grup_id)->count_all_results('cbt_tesgrup');
            $badge_tes = ($jml_tes > 0) ? '<span class="badge bg-aqua">'.$jml_tes.' Jadwal Tes</span>' : '<span class="badge bg-yellow">0 Tes</span>';
            $record[] = $badge_tes;

            $record[] = '<a onclick="edit(\''.$temp->grup_id.'\')" style="cursor: pointer;" class="btn btn-default btn-xs"><i class="fa fa-edit"></i> Edit</a>';

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