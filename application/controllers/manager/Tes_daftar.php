<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* ZYA CBT
* Achmad Lutfi
* achmdlutfi@gmail.com
* achmadlutfi.wordpress.com
*/
class Tes_daftar extends Member_Controller {
	private $kode_menu = 'tes-daftar';
	private $kelompok = 'tes';
	private $url = 'manager/tes_daftar';
	
    function __construct(){
		parent:: __construct();
		$this->load->model('cbt_tes_model');
		$this->load->model('cbt_topik_model');
		$this->load->model('cbt_modul_model');
		$this->load->model('cbt_tesgrup_model');
		$this->load->model('cbt_tes_topik_set_model');

		parent::cek_akses($this->kode_menu);
	}
	
    public function index($status=null, $pesan=null){
        $data['kode_menu'] = $this->kode_menu;
        $data['url'] = $this->url;

        if(!empty($pesan)){
        	if($status=='0'){
        		$data['pesan_hapus'] = '<div class="alert alert-warning alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h4><i class="icon fa fa-info"></i> Perhatian</h4>'.$pesan.'</div>';
        	}else{
        		$data['pesan_hapus'] = '<div class="alert alert-info alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h4><i class="icon fa fa-info"></i> Informasi</h4>'.$pesan.'</div>';
        	}
        }
        
        $this->template->display_admin($this->kelompok.'/tes_daftar_view', 'Daftar Tes', $data);
    }

    function hapus_tes(){
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('hapus-id', 'ID Tes','required|strip_tags');
        $this->form_validation->set_rules('hapus-nama', 'Nama Tes','required|strip_tags');
        $this->form_validation->set_rules('hapus-deskripsi', 'Deskripsi Tes','required|strip_tags');
        
        if($this->form_validation->run() == TRUE){
            $tes_id = $this->input->post('hapus-id', true);

            $this->cbt_tes_model->delete('tes_id', $tes_id);

            $status['status'] = 1;
            $status['pesan'] = 'Tes berhasil dihapus';
        }else{
            $status['status'] = 0;
            $status['pesan'] = validation_errors();
        }
        
        echo json_encode($status);
    }

    /**
     * Normalisasi Poin Dasar & Max Score ke Skala 100 sekaligus Hitung Ulang Nilai Siswa
     */
    function normalisasi_skala_100($tes_id = null){
        $hasil = $this->cbt_tes_model->normalisasi_skala_100($tes_id);
        $status = array(
            'status' => 1,
            'pesan' => 'Berhasil menormalisasi '.$hasil['jml_tes'].' Jadwal Tes ke Skala 100 (Poin = 100 / Jumlah Soal) dan menghitung ulang nilai pada '.$hasil['jml_peserta'].' lembar ujian peserta!'
        );
        echo json_encode($status);
    }

    function duplikat_tes(){
        $this->load->library('form_validation');

        $this->form_validation->set_rules('duplikat-id', 'ID Tes Asal', 'required|integer|strip_tags');
        $this->form_validation->set_rules('duplikat-nama', 'Nama Tes Baru', 'required|strip_tags');
        $this->form_validation->set_rules('duplikat-deskripsi', 'Deskripsi Tes', 'required|strip_tags');
        $this->form_validation->set_rules('duplikat-rentang-waktu', 'Rentang Waktu', 'required|strip_tags');

        if($this->form_validation->run() == TRUE){
            $tes_id_asal = $this->input->post('duplikat-id', true);
            $nama_baru = trim($this->input->post('duplikat-nama', true));
            $deskripsi_baru = $this->input->post('duplikat-deskripsi', true);
            $rentang_waktu = $this->input->post('duplikat-rentang-waktu', true);
            $hari = $this->input->post('duplikat-hari', true);
            $shift = $this->input->post('duplikat-shift', true);
            $jam_ke = $this->input->post('duplikat-jam-ke', true);

            if($this->cbt_tes_model->count_by_kolom('tes_nama', $nama_baru)->row()->hasil > 0){
                $status['status'] = 0;
                $status['pesan'] = 'Nama Tes Baru sudah digunakan, silakan gunakan nama lain (misal tambahkan keterangan Shift Siang / Susulan).';
            }else{
                $q_asal = $this->cbt_tes_model->get_by_kolom_limit('tes_id', $tes_id_asal, 1);
                if($q_asal->num_rows() > 0){
                    $asal = $q_asal->row();
                    $tanggal = explode(" - ", $rentang_waktu);

                    $this->db->trans_start();

                    $data_baru = array(
                        'tes_nama' => $nama_baru,
                        'tes_detail' => $deskripsi_baru,
                        'tes_begin_time' => isset($tanggal[0]) ? $tanggal[0] : $asal->tes_begin_time,
                        'tes_end_time' => isset($tanggal[1]) ? $tanggal[1] : $asal->tes_end_time,
                        'tes_duration_time' => $asal->tes_duration_time,
                        'tes_ip_range' => $asal->tes_ip_range,
                        'tes_results_to_users' => $asal->tes_results_to_users,
                        'tes_detail_to_users' => isset($asal->tes_detail_to_users) ? $asal->tes_detail_to_users : 0,
                        'tes_score_right' => $asal->tes_score_right,
                        'tes_score_wrong' => $asal->tes_score_wrong,
                        'tes_score_unanswered' => $asal->tes_score_unanswered,
                        'tes_max_score' => $asal->tes_max_score,
                        'tes_token' => $asal->tes_token,
                        'tes_hari' => !empty($hari) ? $hari : $asal->tes_hari,
                        'tes_shift' => !empty($shift) ? $shift : $asal->tes_shift,
                        'tes_jam_ke' => !empty($jam_ke) ? $jam_ke : $asal->tes_jam_ke
                    );
                    if($this->db->field_exists('tes_user_id', 'cbt_tes') && isset($asal->tes_user_id)){
                        $data_baru['tes_user_id'] = $asal->tes_user_id;
                    }

                    $new_tes_id = $this->cbt_tes_model->save($data_baru);

                    // Salin daftar grup / rombel
                    $q_grup = $this->cbt_tesgrup_model->get_by_kolom('tstgrp_tes_id', $tes_id_asal);
                    if($q_grup->num_rows() > 0){
                        foreach($q_grup->result() as $g){
                            $this->cbt_tesgrup_model->save(array(
                                'tstgrp_tes_id' => $new_tes_id,
                                'tstgrp_grup_id' => $g->tstgrp_grup_id
                            ));
                        }
                    }

                    // Salin komposisi topik soal
                    $q_topik = $this->cbt_tes_topik_set_model->get_by_kolom('tset_tes_id', $tes_id_asal);
                    if($q_topik->num_rows() > 0){
                        foreach($q_topik->result() as $tset){
                            $this->cbt_tes_topik_set_model->save(array(
                                'tset_tes_id' => $new_tes_id,
                                'tset_topik_id' => $tset->tset_topik_id,
                                'tset_tipe' => $tset->tset_tipe,
                                'tset_difficulty' => $tset->tset_difficulty,
                                'tset_jumlah' => $tset->tset_jumlah,
                                'tset_jawaban' => $tset->tset_jawaban,
                                'tset_acak_jawaban' => $tset->tset_acak_jawaban,
                                'tset_acak_soal' => $tset->tset_acak_soal
                            ));
                        }
                    }

                    $this->db->trans_complete();

                    $status['status'] = 1;
                    $status['pesan'] = 'Tes berhasil diduplikasi menjadi "'.$nama_baru.'" beserta komposisi soal dan rombelnya.';
                }else{
                    $status['status'] = 0;
                    $status['pesan'] = 'Data Tes asal tidak ditemukan.';
                }
            }
        }else{
            $status['status'] = 0;
            $status['pesan'] = validation_errors();
        }

        echo json_encode($status);
    }

    function hapus_daftar_tes(){
    	$this->load->library('form_validation');
        
        $this->form_validation->set_rules('edit-tes-id[]', 'ID Tes','required|strip_tags');
        
        $status=0;
        $pesan='';
        if($this->form_validation->run() == TRUE){
        	$tes_id = $this->input->post('edit-tes-id', TRUE);
            $centang = $this->input->post('centang', TRUE);
            if($centang=='1'){
            	foreach( $tes_id as $kunci => $isi ) {
					if($isi=="on"){
						// Memulai transaction mysql
						$this->db->trans_start();

		            	$this->cbt_tes_model->delete('tes_id', $kunci);

		            	// Menutup transaction mysql
						$this->db->trans_complete();
	            	}
	            }
            	$status=1;
        		$pesan='Tes yang dipilih berhasil dihapus';
            }else{
            	$pesan='Centang pernyataan bahwa anda yakin untuk menghapus Tes=';
            }
        }else{
            $pesan='Pilih terlebih dahulu Tes yang akan dihapus';
        }
        
    	$this->index($status, $pesan);
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
	            $data['token'] = $query->tes_token;
	            $data['rentang_waktu'] = $query->tes_begin_time.' - '.$query->tes_end_time;
	            $data['hari'] = !empty($query->tes_hari) ? $query->tes_hari : '';
	            $data['shift'] = !empty($query->tes_shift) ? $query->tes_shift : '';
	            $data['jam_ke'] = !empty($query->tes_jam_ke) ? $query->tes_jam_ke : '';
			}
		}
		echo json_encode($data);
    }
    
    function get_datatable(){
		// variable initialization
		$search = "";
		$start = 0;
		$rows = 10;

		$hari = $this->input->get('hari', true);
		$shift = $this->input->get('shift', true);
		$jam_ke = $this->input->get('jam_ke', true);

		// get search value (if any)
		if (isset($_GET['sSearch']) && $_GET['sSearch'] != "" ) {
			$search = $_GET['sSearch'];
		}

		// limit
		$start = $this->get_start();
		$rows = $this->get_rows();

		// run query to get user listing
		$query = $this->cbt_tes_model->get_datatable($start, $rows, 'tes_nama', $search, $hari, $jam_ke, $shift);
		$iFilteredTotal = $query->num_rows();
		
		$iTotal= $this->cbt_tes_model->get_datatable_count('tes_nama', $search, $hari, $jam_ke, $shift)->row()->hasil;
	    
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
            $record[] = $temp->tes_nama;
            $record[] = !empty($temp->tes_hari) ? '<span class="label label-info">'.$temp->tes_hari.'</span>' : '<span class="text-muted">-</span>';

            // Badge Shift (Pagi / Siang)
            if(!empty($temp->tes_shift)){
            	if(strtolower($temp->tes_shift) == 'pagi'){
            		$record[] = '<span class="label label-warning"><i class="fa fa-sun-o"></i> Pagi</span>';
            	}else{
            		$record[] = '<span class="label label-danger"><i class="fa fa-cloud"></i> Siang</span>';
            	}
            }else{
            	$record[] = '<span class="text-muted">-</span>';
            }

            $record[] = !empty($temp->tes_jam_ke) ? '<span class="label label-primary">'.$temp->tes_jam_ke.'</span>' : '<span class="text-muted">-</span>';
            if(floatval($temp->tes_max_score) == 100){
                $record[] = '<span class="badge bg-green">100</span>';
            }else{
                $record[] = '<a href="javascript:void(0)" onclick="normalisasi_semua_skala_100(\''.$temp->tes_id.'\')" title="Klik untuk normalisasi tes ini ke Skala 100"><span class="badge bg-red"><i class="fa fa-warning"></i> '.$temp->tes_max_score.' (Fix 100)</span></a>';
            }
            $record[] = $temp->tes_begin_time;
            $record[] = $temp->tes_end_time;
            $record[] = $temp->tes_duration_time.' Menit';
            $record[] = $temp->tes_score_right;

            if($temp->tes_results_to_users==1){
            	$record[] = 'Ya';
            }else{
            	$record[] = 'Tidak';
            }

            if($temp->tes_token==1){
            	$record[] = 'Ya';
            }else{
            	$record[] = 'Tidak';
            }

			$query_topik = $this->cbt_tes_topik_set_model->get_by_kolom('tset_tes_id', $temp->tes_id);
			if($query_topik->num_rows()>0){
				$query_topik = $query_topik->result();
				$data_soal = '';
				foreach($query_topik as $topik){
					$query_topik = $this->cbt_topik_model->get_by_kolom_limit('topik_id', $topik->tset_topik_id, 1)->row();
					$query_modul = $this->cbt_modul_model->get_by_kolom_limit('modul_id', $query_topik->topik_modul_id, 1)->row();
					
					$ket_acak = '';
					if($topik->tset_acak_soal==1){
						$ket_acak = $ket_acak.' Acak Soal=YA';
					}else{
						$ket_acak = $ket_acak.' Acak Soal=TDK';
					}
					if($topik->tset_acak_jawaban==1){
						$ket_acak = $ket_acak.'; Acak JWB=YA';
					}else{
						$ket_acak = $ket_acak.'; Acak JWB=TDK';
					}
					
					if(empty($data_soal)){
						$data_soal = '['.$query_modul->modul_nama.'] '.$query_topik->topik_nama.' ['.$topik->tset_jumlah.'] ['.$topik->tset_jawaban.']'.$ket_acak;
					}else{
						$data_soal = $data_soal.'<br />'.'['.$query_modul->modul_nama.'] '.$query_topik->topik_nama.' ['.$topik->tset_jumlah.'] ['.$topik->tset_jawaban.']'.$ket_acak;
					}
				}
				
				$record[] = $data_soal;
			}else{
				$record[] = 'Belum ada soal';
			}
            
			$query_grup = $this->cbt_tesgrup_model->get_by_tes_id($temp->tes_id);
			if($query_grup->num_rows()>0){
				$query_grup = $query_grup->result();
				$data_grup = '';
				foreach($query_grup as $grup){
					if(empty($data_grup)){
						$data_grup = $grup->grup_nama;
					}else{
						$data_grup = $data_grup.', '.$grup->grup_nama;
					}
				}
				$record[] = $data_grup;
			}else{
				$record[] = 'Belum ada grup';
			}
			
            $record[] = '
            	<a onclick="edit(\''.$temp->tes_id.'\')" style="cursor: pointer;" class="btn btn-default btn-xs" title="Ubah Tes"><span class="glyphicon glyphicon-edit"></span></a>
            	<a onclick="duplikat(\''.$temp->tes_id.'\')" style="cursor: pointer;" class="btn btn-info btn-xs" title="Duplikat / Gandakan Tes (Shift Lain / Susulan)"><span class="glyphicon glyphicon-duplicate"></span></a>
            	<a onclick="hapus(\''.$temp->tes_id.'\')" style="cursor: pointer;" class="btn btn-default btn-xs" title="Hapus Tes"><span class="glyphicon glyphicon-remove"></span></a>
            ';

            $record[] = '<input type="checkbox" name="edit-tes-id['.$temp->tes_id.']" >';

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