<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* ZYA CBT
* Achmad Lutfi
* achmdlutfi@gmail.com
* achmadlutfi.wordpress.com
*/
class Tes_hasil extends Member_Controller {
	private $kode_menu = 'tes-hasil';
	private $kelompok = 'tes';
	private $url = 'manager/tes_hasil';
	
    function __construct(){
		parent:: __construct();
		$this->load->model('cbt_user_model');
		$this->load->model('cbt_user_grup_model');
		$this->load->model('cbt_tes_model');
		$this->load->model('cbt_tes_token_model');
		$this->load->model('cbt_tes_topik_set_model');
		$this->load->model('cbt_tes_user_model');
		$this->load->model('cbt_tesgrup_model');
		$this->load->model('cbt_soal_model');
		$this->load->model('cbt_jawaban_model');
		$this->load->model('cbt_tes_soal_model');
		$this->load->model('cbt_tes_soal_jawaban_model');
		$this->load->model('cbt_topik_model');
		$this->load->model('cbt_modul_model');
		$this->load->model('users_model');

        parent::cek_akses($this->kode_menu);
	}
	
    public function index($page=null, $id=null){
        $data['kode_menu'] = $this->kode_menu;
        $data['url'] = $this->url;

        $tanggal_awal = date('Y-m-d H:i', strtotime('- 1 days'));
        $tanggal_akhir = date('Y-m-d H:i', strtotime('+ 1 days'));
        
        $data['rentang_waktu'] = $tanggal_awal.' - '.$tanggal_akhir;

        $query_user = $this->users_model->get_user_by_username($this->access->get_username());
        $user_topik_ids = array();
        $is_guru = false;
        if($query_user->num_rows()>0){
            $user = $query_user->row();
            if(!empty($user->opsi1)){
                $user_topik_ids = explode(',', $user->opsi1);
                $is_guru = true;
            }
        }

        $select_topik = '<option value="semua">Semua Mata Pelajaran</option>';
        if($is_guru){
            foreach($user_topik_ids as $tid){
                $q_tp = $this->cbt_topik_model->get_by_kolom_join_modul('topik_id', $tid);
                if($q_tp->num_rows()>0){
                    $tp = $q_tp->row();
                    $select_topik .= '<option value="'.$tp->topik_id.'">'.$tp->modul_nama.' - '.$tp->topik_nama.'</option>';
                }
            }
        }else{
            $q_modul = $this->cbt_modul_model->get_modul();
            if($q_modul->num_rows()>0){
                foreach($q_modul->result() as $m){
                    $q_tp = $this->cbt_topik_model->get_by_kolom_join_modul('topik_modul_id', $m->modul_id);
                    if($q_tp->num_rows()>0){
                        $select_topik .= '<optgroup label="Modul '.$m->modul_nama.'">';
                        foreach($q_tp->result() as $tp){
                            $select_topik .= '<option value="'.$tp->topik_id.'">'.$tp->modul_nama.' - '.$tp->topik_nama.'</option>';
                        }
                        $select_topik .= '</optgroup>';
                    }
                }
            }
        }
        $data['select_topik'] = $select_topik;
        $data['is_guru'] = $is_guru;

        $query_group = $this->cbt_user_grup_model->get_group();
        $select = '';
        if($query_group->num_rows()>0){
        	$query_group = $query_group->result();
        	foreach ($query_group as $temp) {
        		$select = $select.'<option value="'.$temp->grup_id.'">'.$temp->grup_nama.'</option>';
        	}
        }else{
        	$select = '<option value="0">Tidak Ada Group</option>';
        }
        $data['select_group'] = $select;

        $query_tes = $this->cbt_tes_user_model->get_by_group();
        $select = '<option value="semua">Semua Tes</option>';
        if($query_tes->num_rows()>0){
        	$query_tes = $query_tes->result();
        	foreach ($query_tes as $temp) {
        		$select = $select.'<option value="'.$temp->tes_id.'">'.$temp->tes_nama.'</option>';
        	}
        }
        $data['select_tes'] = $select;
        
        $this->template->display_admin($this->kelompok.'/tes_hasil_view', 'Hasil Tes', $data);
    }

    /**
     * Melakukan perubahan pada tes yang diseleksi
     */
    function edit_tes(){
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('edit-testuser-id[]', 'Hasil Tes','required|strip_tags');
        $this->form_validation->set_rules('edit-pilihan', 'Pilihan','required|strip_tags');
        
        if($this->form_validation->run() == TRUE){
            $pilihan = $this->input->post('edit-pilihan', true);
            $tesuser_id = $this->input->post('edit-testuser-id', TRUE);

            if($pilihan=='hapus'){
                foreach( $tesuser_id as $kunci => $isi ) {
                    if($isi=="on"){
                        $this->cbt_tes_user_model->delete('tesuser_id', $kunci);
                    }
                }
            	$status['status'] = 1;
            	$status['pesan'] = 'Hasil tes berhasil dihapus';
            }else if($pilihan=='hentikan'){
            	foreach( $tesuser_id as $kunci => $isi ) {
                    if($isi=="on"){
                    	$data_tes['tesuser_status']=4;
            			$this->cbt_tes_user_model->update('tesuser_id', $kunci, $data_tes);
                    }
                }
            	$status['status'] = 1;
            	$status['pesan'] = 'Tes berhasil dihentikan';
            }else if($pilihan=='buka'){
            	foreach( $tesuser_id as $kunci => $isi ) {
                    if($isi=="on"){
                    	$data_tes['tesuser_status']=1;
            			$this->cbt_tes_user_model->update('tesuser_id', $kunci, $data_tes);
                    }
                }
            	$status['status'] = 1;
            	$status['pesan'] = 'Tes berhasil dibuka, user bisa mengerjakan kembali';
            }else if($pilihan=='waktu'){
            	foreach( $tesuser_id as $kunci => $isi ) {
                    if($isi=="on"){
                    	$waktu = intval($this->input->post('waktu-menit', TRUE));

            			$this->cbt_tes_user_model->update_menit($kunci, $waktu);
                    }
                }
            	$status['status'] = 1;
            	$status['pesan'] = 'Waktu Tes berhasil ditambah';
            }

        }else{
            $status['status'] = 0;
            $status['pesan'] = validation_errors();
        }
        
        echo json_encode($status);
    }

    function export($tes_id=null, $grup_id=null, $waktu=null, $urutkan=null, $status=null, $keterangan=null, $topik_id=null){
        if(!empty($tes_id) AND !empty($grup_id) AND !empty($waktu) AND !empty($urutkan) AND !empty($status)){
            $this->load->library('excel');
            $waktu =  urldecode($waktu);
            $tanggal = explode(" - ", $waktu);
			if(!empty($keterangan)){
				$keterangan =  urldecode($keterangan);
			}
            if(!empty($grup_id)){
                $grup_id = urldecode($grup_id);
            }
            if(!empty($topik_id)){
                $topik_id = urldecode($topik_id);
            }else{
                $topik_id = 'semua';
            }

            // Jika user adalah guru dan belum memilih topik spesifik, defaultkan ke topik miliknya
            $query_user = $this->users_model->get_user_by_username($this->access->get_username());
            if($query_user->num_rows()>0){
                $u = $query_user->row();
                if(!empty($u->opsi1)){
                    if(empty($topik_id) || $topik_id=='semua'){
                        $topik_id = $u->opsi1;
                    }
                }
            }

			if($status=='mengerjakan'){
				$query = $this->cbt_tes_user_model->get_by_tes_group_urut_tanggal($tes_id, $grup_id, $urutkan, $tanggal, $keterangan, $topik_id);
			}else{
				$query = $this->cbt_user_model->get_by_tes_group_urut_tanggal($tes_id, $grup_id, $urutkan, $tanggal, $keterangan, $topik_id);
			}
            $inputFileName = './public/form/form-data-hasil-tes.xlsx';
            $excel = PHPExcel_IOFactory::load($inputFileName);
            $worksheet = $excel->getSheet(0);

            if($query->num_rows()>0){
                $query = $query->result();
                $row = 2;
                foreach ($query as $temp) {
                    $worksheet->setCellValueByColumnAndRow(0, $row, ($row-1));
                    $worksheet->setCellValueByColumnAndRow(1, $row, $temp->tesuser_creation_time);
                    $worksheet->setCellValueByColumnAndRow(2, $row, $temp->tes_nama);
                    $worksheet->setCellValueByColumnAndRow(3, $row, $temp->user_name);
                    $worksheet->setCellValueByColumnAndRow(4, $row, stripslashes($temp->user_firstname));
                    $worksheet->setCellValueByColumnAndRow(5, $row, $temp->grup_nama);
                    $worksheet->setCellValueByColumnAndRow(6, $row, $temp->nilai);

                    $row++;
                }
            }
            $filename='Data Hasil Tes - '.date('Y-m-d H:i').'.xlsx';
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="'.$filename.'"');
            header('Cache-Control: max-age=0');
                 
            $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
            $objWriter->save('php://output');
        }
    }
    
    function get_datatable(){
		// variable initialization
		$tes_id = $this->input->get('tes');
		$grup_id = $this->input->get('group');
		$topik_id = $this->input->get('topik');
		$urutkan = $this->input->get('urutkan');
		$waktu = $this->input->get('waktu');
		$keterangan = $this->input->get('keterangan');
		$status = $this->input->get('status');
		$tanggal = explode(" - ", $waktu);

        // Jika user adalah guru dan belum memilih topik spesifik, defaultkan ke topik miliknya
        $query_user = $this->users_model->get_user_by_username($this->access->get_username());
        if($query_user->num_rows()>0){
            $u = $query_user->row();
            if(!empty($u->opsi1)){
                if(empty($topik_id) || $topik_id=='semua'){
                    $topik_id = $u->opsi1;
                }
            }
        }

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
		if($status=='mengerjakan'){
			$query = $this->cbt_tes_user_model->get_datatable($start, $rows, $tes_id, $grup_id, $urutkan, $tanggal, $keterangan, $search, $topik_id);
			$iTotal= $this->cbt_tes_user_model->get_datatable_count($tes_id, $grup_id, $urutkan, $tanggal, $keterangan, $search, $topik_id)->row()->hasil;
		}else{
			$query = $this->cbt_user_model->get_datatable_hasiltes($start, $rows, $tes_id, $grup_id, $urutkan, $tanggal, $keterangan, $search, $topik_id);
			$iTotal= $this->cbt_user_model->get_datatable_hasiltes_count($tes_id, $grup_id, $urutkan, $tanggal, $keterangan, $search, $topik_id)->row()->hasil;
		}
		
		$iFilteredTotal = $query->num_rows();
	    
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
			if(empty($temp->tesuser_creation_time)){
				$record[] = 'Belum memulai tes';
				$record[] = '0';
			}else{
				$record[] = $temp->tesuser_creation_time;
				$record[] = $temp->tes_duration_time.' menit';
			}
			$record[] = $temp->tes_nama;
            $record[] = $temp->grup_nama;
			if(empty($temp->tesuser_id)){
				$record[] = '<b>'.stripslashes($temp->user_firstname).'</b>';
			}else{
				$record[] = '<a href="#" title="Klik untuk mengetahui Detail Tes" onclick="detail_tes(\''.$temp->tesuser_id.'\')"><b>'.stripslashes($temp->user_firstname).'</b></a>';
			}
			if(empty($temp->nilai)){
				$record[] = '0';
			}else{
				$record[] = $temp->nilai;
			}
			
			if(empty($temp->tesuser_status)){
				$record[] = 'Belum memulai';
			}else{
				if($temp->tesuser_status==1){
					$tanggal = new DateTime();
					// Cek apakah tes sudah melebihi batas waktu
					$tanggal_tes = new DateTime($temp->tesuser_creation_time);
					$tanggal_tes->modify('+'.$temp->tes_duration_time.' minutes');
					if($tanggal>$tanggal_tes){
						$record[] = 'Selesai';
					}else{
						$tanggal = $tanggal_tes->diff($tanggal);
						$menit_sisa = ($tanggal->h*60)+($tanggal->i);
						$record[] = 'Berjalan (-'.$menit_sisa.' menit)';
					}
				}else{
					$record[] = 'Selesai';
				}
			}
			
			// menampilkan pilihan edit untuk data yang sudah mengerjakan
			if(empty($temp->tesuser_id)){
				$record[] = '';
			}else{
				$record[] = '<input type="checkbox" name="edit-testuser-id['.$temp->tesuser_id.']" >';
			}

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