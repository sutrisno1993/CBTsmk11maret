<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Modul_mapel extends Member_Controller {
	private $kode_menu = 'modul-mapel';
	private $kelompok = 'modul';
	private $url = 'manager/modul_mapel';
	
    function __construct(){
		parent:: __construct();
		$this->load->model('cbt_modul_model');
		$this->load->model('cbt_topik_model');

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
        
        $this->template->display_admin($this->kelompok.'/modul_mapel_view', 'Mata Pelajaran (Modul)', $data);
    }

    function tambah(){
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('tambah-nama', 'Nama Mata Pelajaran / Modul','required|strip_tags');
        
        if($this->form_validation->run() == TRUE){
            $data['modul_nama'] = trim($this->input->post('tambah-nama', true));
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

		if (isset($_GET['sSearch']) && $_GET['sSearch'] != "" ) {
			$search = $_GET['sSearch'];
		}

		$start = $this->get_start();
		$rows = $this->get_rows();

		$query = $this->cbt_modul_model->get_datatable($start, $rows, 'modul_nama', $search);
		$iFilteredTotal = $query->num_rows();
		$iTotal = $this->cbt_modul_model->get_datatable_count('modul_nama', $search)->row()->hasil;
	    
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
	        "iTotalRecords" => $iTotal,
	        "iTotalDisplayRecords" => $iTotal,
	        "aaData" => array()
	    );

		$i = $start;
		$query = $query->result();
	    foreach ($query as $temp) {			
			$record = array();
            
			$record[] = ++$i;
            $record[] = '<b>'.$temp->modul_nama.'</b>';

            // Hitung jumlah topik di bawah modul ini
            $jml_topik = $this->cbt_topik_model->count_by_kolom('topik_modul_id', $temp->modul_id)->row()->hasil;
            $record[] = '<span class="badge bg-aqua">'.$jml_topik.' Topik</span>';

            // Status aktif
            if($temp->modul_aktif == 1){
                $record[] = '<span class="label label-success"><i class="fa fa-check"></i> Aktif</span>';
            }else{
                $record[] = '<span class="label label-danger"><i class="fa fa-times"></i> Nonaktif</span>';
            }

            $record[] = '
            	<a href="'.site_url('manager/modul_topik').'?modul='.$temp->modul_id.'" class="btn btn-info btn-xs" title="Lihat Topik Mapel ini"><i class="fa fa-list"></i> Topik</a>
            	<a onclick="edit(\''.$temp->modul_id.'\')" style="cursor: pointer;" class="btn btn-default btn-xs" title="Edit Modul"><span class="glyphicon glyphicon-edit"></span> Edit</a>
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

            $status['status'] = 1;
            $status['pesan'] = 'Sinkronisasi data Mata Pelajaran, Topik STS, dan Kelas berhasil dimuat!';
        }else{
            $status['status'] = 0;
            $status['pesan'] = 'File sync_data_lokal.sql tidak ditemukan.';
        }
        echo json_encode($status);
    }
}
