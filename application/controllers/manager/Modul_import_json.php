<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Modul_import_json extends Member_Controller {
	private $kode_menu = 'modul-import-json';
	private $kelompok = 'modul';
	private $url = 'manager/modul_import_json';
	
    function __construct(){
		parent:: __construct();
		$this->load->model('cbt_modul_model');
		$this->load->model('cbt_topik_model');
		$this->load->model('cbt_jawaban_model');
		$this->load->model('cbt_soal_model');
		$this->load->helper('directory');
		$this->load->helper('file');

		// Pastikan menu dan izin akses terdaftar jika belum ada
		$cek_m = $this->db->where('kode_menu', $this->kode_menu)->get('user_menu');
		if($cek_m->num_rows() == 0){
			$this->db->insert('user_menu', array(
				'tipe' => 1,
				'parent' => 'modul',
				'kode_menu' => $this->kode_menu,
				'nama_menu' => 'Import Soal JSON / AI',
				'url' => 'manager/modul_import_json',
				'icon' => 'fa fa-code',
				'urutan' => 5
			));
		}
		foreach(array('admin', 'operator-soal', 'guru') as $lvl){
			$cek_a = $this->db->where('level', $lvl)->where('kode_menu', $this->kode_menu)->get('user_akses');
			if($cek_a->num_rows() == 0){
				$this->db->insert('user_akses', array('level' => $lvl, 'kode_menu' => $this->kode_menu, 'add' => 1, 'edit' => 1));
			}
		}

        parent::cek_akses($this->kode_menu);
	}
	
    public function index(){
        $data['kode_menu'] = $this->kode_menu;
        $data['url'] = $this->url;

        $selected_topik_id = $this->input->get('topik_id');
        $data['selected_topik_id'] = $selected_topik_id;

        $query_user = $this->users_model->get_user_by_username($this->access->get_username());
        $select = '';
        $counter = 0;
        if($query_user->num_rows()>0){
            $query_user = $query_user->row();
            $level = $this->session->userdata('cbt_level');

            if($level == 'guru' && !empty($query_user->opsi1)){
                $user_topik = explode(',', $query_user->opsi1);
                foreach ($user_topik as $topik_id) {
                    $query_topik = $this->cbt_topik_model->get_by_kolom_join_modul('topik_id', $topik_id);
                    if($query_topik->num_rows()>0){
                        $topik = $query_topik->row();
                        $counter++;
                        $jml_soal = $this->cbt_soal_model->count_by_kolom('soal_topik_id', $topik->topik_id)->row()->hasil;

                        $hari = '';
                        if(preg_match('/\[(SENIN|SELASA|RABU|KAMIS|JUMAT)/i', $topik->topik_nama, $m_hari)){
                            $hari = strtoupper($m_hari[1]);
                        }
                        $grade = '';
                        if(preg_match('/\b(XII)\b/i', $topik->topik_nama)){
                            $grade = 'XII';
                        }else if(preg_match('/\b(XI)\b/i', $topik->topik_nama)){
                            $grade = 'XI';
                        }else if(preg_match('/\b(X)\b/i', $topik->topik_nama)){
                            $grade = 'X';
                        }

                        $sel = (!empty($selected_topik_id) && $selected_topik_id == $topik->topik_id) ? 'selected' : '';
                        $select = $select.'<option value="'.$topik->topik_id.'" '.$sel.' data-modul="'.htmlspecialchars($topik->modul_nama).'" data-hari="'.$hari.'" data-grade="'.$grade.'">'.$topik->modul_nama.' - '.$topik->topik_nama.' ['.$jml_soal.' butir]</option>';
                    }
                }
            }else{
                // Tampilkan semua topik terkelompok per modul
                $query_modul = $this->cbt_modul_model->get_modul();
                if($query_modul->num_rows()>0){
                    $select = '';
                    $query_modul = $query_modul->result();
                    foreach ($query_modul as $temp) {
                        $query_topik = $this->cbt_topik_model->get_by_kolom_join_modul('topik_modul_id', $temp->modul_id);
                        if($query_topik->num_rows()){
                            $select = $select.'<optgroup label="Modul '.$temp->modul_nama.'">';

                            $query_topik = $query_topik->result();
                            foreach ($query_topik as $topik) {
                                $counter++;
                                $jml_soal = $this->cbt_soal_model->count_by_kolom('soal_topik_id', $topik->topik_id)->row()->hasil;

                                $hari = '';
                                if(preg_match('/\[(SENIN|SELASA|RABU|KAMIS|JUMAT)/i', $topik->topik_nama, $m_hari)){
                                    $hari = strtoupper($m_hari[1]);
                                }
                                $grade = '';
                                if(preg_match('/\b(XII)\b/i', $topik->topik_nama)){
                                    $grade = 'XII';
                                }else if(preg_match('/\b(XI)\b/i', $topik->topik_nama)){
                                    $grade = 'XI';
                                }else if(preg_match('/\b(X)\b/i', $topik->topik_nama)){
                                    $grade = 'X';
                                }

                                $sel = (!empty($selected_topik_id) && $selected_topik_id == $topik->topik_id) ? 'selected' : '';
                                $select = $select.'<option value="'.$topik->topik_id.'" '.$sel.' data-modul="'.htmlspecialchars($temp->modul_nama).'" data-hari="'.$hari.'" data-grade="'.$grade.'">'.$temp->modul_nama.' - '.$topik->topik_nama.' ['.$jml_soal.' butir]</option>';
                            }

                            $select = $select.'</optgroup>';
                        }
                    }
                }
            }
        }

        if($counter==0){
        	$select = '<option value="kosong">Tidak Ada Data Topik</option>';
        }
        
        $data['select_topik'] = $select;
        
        $this->template->display_admin($this->kelompok.'/modul_import_json_view', 'Import Soal JSON / AI Generator', $data);
    }

    /**
     * AJAX endpoint untuk Validasi & Preview JSON
     */
    public function validasi_json(){
        $raw_json = $this->input->post('json_data', false);
        
        // Handle file upload jika ada
        if(!empty($_FILES['file_json']['tmp_name'])){
            $raw_json = file_get_contents($_FILES['file_json']['tmp_name']);
        }

        if(empty($raw_json)){
            echo json_encode(array('status' => 0, 'pesan' => 'Teks JSON tidak boleh kosong! Tempelkan JSON atau unggah file .json.'));
            return;
        }

        $parsed = $this->_parse_json($raw_json);
        if(!$parsed['success']){
            echo json_encode(array('status' => 0, 'pesan' => $parsed['error']));
            return;
        }

        $questions = $parsed['data'];
        $total = count($questions);

        // Buat HTML pratinjau tabel soal
        $html = '<div class="table-responsive" style="max-height: 450px; overflow-y: auto;">';
        $html .= '<table class="table table-bordered table-striped" style="font-size: 13px;">';
        $html .= '<thead><tr style="background:#f4f6f9;"><th width="5%">No</th><th width="45%">Isi Pertanyaan Soal</th><th width="50%">Pilihan Jawaban (A-E)</th></tr></thead><tbody>';

        $letters = array('A', 'B', 'C', 'D', 'E');
        foreach($questions as $idx => $q){
            $html .= '<tr>';
            $html .= '<td class="text-center" style="font-weight: bold; vertical-align: top;">'.($idx+1).'</td>';
            $html .= '<td style="vertical-align: top;">'.nl2br(htmlspecialchars($q['soal'])).'</td>';
            $html .= '<td style="vertical-align: top;">';
            $html .= '<ul class="list-unstyled" style="margin-bottom: 0;">';
            foreach($q['opsi'] as $o_idx => $opsi){
                $label = isset($letters[$o_idx]) ? $letters[$o_idx] : ($o_idx+1);
                $is_key = ($opsi['kunci'] == 1);
                if($is_key){
                    $html .= '<li style="padding: 2px 0;"><span class="badge bg-green" style="font-size: 11px; margin-right: 5px;">'.$label.' <i class="fa fa-check"></i> KUNCI</span> <strong class="text-success">'.htmlspecialchars($opsi['teks']).'</strong></li>';
                } else {
                    $html .= '<li style="padding: 2px 0; color: #555;"><span class="badge bg-gray" style="font-size: 11px; margin-right: 5px;">'.$label.'</span> '.htmlspecialchars($opsi['teks']).'</li>';
                }
            }
            $html .= '</ul>';
            $html .= '</td>';
            $html .= '</tr>';
        }
        $html .= '</tbody></table></div>';

        echo json_encode(array(
            'status' => 1,
            'total_soal' => $total,
            'preview_html' => $html
        ));
    }

    /**
     * AJAX endpoint untuk Menyimpan Soal ke Database
     */
    public function simpan_json(){
        $id_topik = $this->input->post('topik_id', true);
        $raw_json = $this->input->post('json_data', false);

        if(!empty($_FILES['file_json']['tmp_name'])){
            $raw_json = file_get_contents($_FILES['file_json']['tmp_name']);
        }

        if(empty($id_topik) || $id_topik == 'kosong'){
            echo json_encode(array('status' => 0, 'pesan' => 'Silakan pilih topik mata pelajaran tujuan terlebih dahulu!'));
            return;
        }

        if(empty($raw_json)){
            echo json_encode(array('status' => 0, 'pesan' => 'Teks JSON tidak boleh kosong!'));
            return;
        }

        $parsed = $this->_parse_json($raw_json);
        if(!$parsed['success']){
            echo json_encode(array('status' => 0, 'pesan' => $parsed['error']));
            return;
        }

        $questions = $parsed['data'];
        $sukses_soal = 0;
        $sukses_jawaban = 0;

        foreach($questions as $q){
            $soal_data = array(
                'soal_topik_id'   => $id_topik,
                'soal_detail'     => nl2br(htmlspecialchars($q['soal'])),
                'soal_tipe'       => 1, // Pilihan Ganda
                'soal_difficulty' => isset($q['kesulitan']) ? intval($q['kesulitan']) : 1,
                'soal_aktif'      => 1
            );

            $soal_id = $this->cbt_soal_model->save($soal_data);
            if(!empty($soal_id)){
                $sukses_soal++;

                foreach($q['opsi'] as $opsi){
                    $jawaban_data = array(
                        'jawaban_soal_id' => $soal_id,
                        'jawaban_detail'  => nl2br(htmlspecialchars($opsi['teks'])),
                        'jawaban_benar'   => ($opsi['kunci'] == 1) ? 1 : 0,
                        'jawaban_aktif'   => 1
                    );
                    $this->cbt_jawaban_model->save($jawaban_data);
                    $sukses_jawaban++;
                }
            }
        }

        echo json_encode(array(
            'status' => 1,
            'pesan' => 'Alhamdulillah! Berhasil mengimpor '.$sukses_soal.' butir soal dan '.$sukses_jawaban.' pilihan jawaban ke bank soal.'
        ));
    }

    /**
     * Helper Universal Parser JSON Soal (Mendukung Format A-E, Opsi Array, Objek)
     */
    private function _parse_json($json_str){
        // Bersihkan Markdown Codeblocks ```json ... ``` dari respon ChatGPT / Claude
        $json_str = trim($json_str);
        if(preg_match('/^```(?:json)?\s*(.*?)\s*```$/is', $json_str, $m)){
            $json_str = trim($m[1]);
        }

        $data = json_decode($json_str, true);
        if(json_last_error() !== JSON_ERROR_NONE){
            return array('success' => false, 'error' => 'Format JSON tidak valid: ' . json_last_error_msg() . '. Pastikan kurung kurawal, tanda petik ganda, dan koma sudah benar.');
        }

        // Jika dibungkus objek semisal {"soal": [...]} atau {"data": [...]} atau {"questions": [...]}
        if(is_array($data) && !isset($data[0])){
            foreach(array('soal', 'data', 'questions', 'items', 'list') as $wrapper_key){
                if(isset($data[$wrapper_key]) && is_array($data[$wrapper_key])){
                    $data = $data[$wrapper_key];
                    break;
                }
            }
        }

        if(!is_array($data) || empty($data)){
            return array('success' => false, 'error' => 'JSON tidak berisi array butir soal. Format yang diharapkan adalah daftar [...] butir soal.');
        }

        $clean_questions = array();

        foreach($data as $idx => $item){
            if(!is_array($item)) continue;

            // Cari teks soal
            $soal_text = '';
            foreach(array('soal', 'pertanyaan', 'question', 'text', 'tanya') as $sk){
                if(!empty($item[$sk])){
                    $soal_text = trim($item[$sk]);
                    break;
                }
            }

            if(empty($soal_text)){
                return array('success' => false, 'error' => 'Butir soal ke-'.($idx+1).' tidak memiliki teks pertanyaan ("soal").');
            }

            // Cari Kunci Jawaban
            $kunci_val = null;
            foreach(array('kunci', 'jawaban', 'kunci_jawaban', 'answer', 'key') as $kk){
                if(isset($item[$kk])){
                    $kunci_val = $item[$kk];
                    break;
                }
            }

            $opsi_list = array();

            // MODEL 1: Opsi berupa properti huruf terpisah A, B, C, D, E
            if(isset($item['A']) || isset($item['a'])){
                $letters = array('A', 'B', 'C', 'D', 'E');
                foreach($letters as $let){
                    $val = isset($item[$let]) ? $item[$let] : (isset($item[strtolower($let)]) ? $item[strtolower($let)] : null);
                    if($val !== null && trim($val) !== ''){
                        $is_benar = 0;
                        if($kunci_val !== null){
                            $clean_kunci = strtoupper(trim(strval($kunci_val)));
                            if($clean_kunci === $let || $clean_kunci === strtoupper(trim(strval($val)))){
                                $is_benar = 1;
                            }
                        }
                        $opsi_list[] = array('teks' => trim($val), 'kunci' => $is_benar);
                    }
                }
            }
            // MODEL 2: Opsi berupa array di dalam 'opsi' / 'pilihan' / 'options'
            else {
                $raw_options = null;
                foreach(array('opsi', 'pilihan', 'options', 'choices', 'jawaban_list') as $ok){
                    if(isset($item[$ok]) && is_array($item[$ok])){
                        $raw_options = $item[$ok];
                        break;
                    }
                }

                if(!empty($raw_options)){
                    $letters = array('A', 'B', 'C', 'D', 'E');
                    foreach($raw_options as $o_idx => $opt){
                        if(is_array($opt)){
                            // Format: {"teks": "...", "kunci": 1}
                            $teks = isset($opt['teks']) ? $opt['teks'] : (isset($opt['text']) ? $opt['text'] : (isset($opt['jawaban']) ? $opt['jawaban'] : ''));
                            $is_benar = (isset($opt['kunci']) && $opt['kunci'] == 1) ? 1 : (isset($opt['benar']) && $opt['benar'] == 1 ? 1 : 0);
                            $opsi_list[] = array('teks' => trim($teks), 'kunci' => $is_benar);
                        } else {
                            // Format: ["Opsi 1", "Opsi 2", ...]
                            $teks = strval($opt);
                            $is_benar = 0;
                            if($kunci_val !== null){
                                $clean_kunci = strtoupper(trim(strval($kunci_val)));
                                $cur_letter = isset($letters[$o_idx]) ? $letters[$o_idx] : '';
                                if($clean_kunci === $cur_letter || $clean_kunci === strval($o_idx) || $clean_kunci === strtoupper(trim($teks))){
                                    $is_benar = 1;
                                }
                            }
                            $opsi_list[] = array('teks' => trim($teks), 'kunci' => $is_benar);
                        }
                    }
                }
            }

            if(count($opsi_list) < 2){
                return array('success' => false, 'error' => 'Soal nomor '.($idx+1).' memiliki kurang dari 2 pilihan jawaban.');
            }

            // Pastikan ada setidaknya 1 kunci jawaban yang benar
            $has_kunci = false;
            foreach($opsi_list as $o){
                if($o['kunci'] == 1){
                    $has_kunci = true;
                    break;
                }
            }
            if(!$has_kunci){
                // Jika tidak ada kunci yang cocok, tandai opsi pertama sebagai default kunci atau beri peringatan
                $opsi_list[0]['kunci'] = 1;
            }

            $clean_questions[] = array(
                'soal' => $soal_text,
                'kesulitan' => isset($item['kesulitan']) ? intval($item['kesulitan']) : 1,
                'opsi' => $opsi_list
            );
        }

        return array('success' => true, 'data' => $clean_questions);
    }
}
