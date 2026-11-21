<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Peserta_import extends Member_Controller {
	private $kode_menu = 'peserta-import';
	private $kelompok = 'peserta';
	private $url = 'manager/peserta_import';
	
    function __construct(){
		parent:: __construct();
		$this->load->model('cbt_user_grup_model');
		$this->load->model('cbt_user_model');
		$this->load->model('cbt_tesgrup_model');

        parent::cek_akses($this->kode_menu);
	}
	
    public function index(){
        $this->import();
    }

    public function import(){
        $data['kode_menu'] = $this->kode_menu;
        $data['url'] = $this->url;

        $this->load->library('form_validation');

        $data['error'] = '';
        $data['error_upload'] = '';

        // Ambil daftar seluruh kelas resmi di database beserta jumlah siswa & jumlah jadwal tes
        $data['kelas_resmi'] = $this->get_daftar_kelas_resmi();

        // Jika operator mengirimkan form konfirmasi pemetaan manual dari hasil screening sebelumnya
        $cached_file = $this->input->post('cached_excel_file', true);
        $custom_mapping = $this->input->post('map_kelas', true);
        $mode_update = $this->input->post('mode_update', true);

        if(!empty($cached_file) && file_exists('./public/uploads/'.$cached_file)){
            $data['filename'] = 'File '.$cached_file.' diproses dengan Pemetaan Kelas Terverifikasi';
            $data['hasil'] = $this->import_file($cached_file, is_array($custom_mapping) ? $custom_mapping : array(), $mode_update);
        } else if(!empty($_FILES['userfile']['name'])){
			$config['upload_path'] = './public/uploads/';
	        $config['allowed_types'] = 'xlsx|xls';
	        $config['max_size']	= '0';
	        $config['overwrite'] = true;
	        $config['file_name'] = $_FILES['userfile']['name'];
	            
	        $this->load->library('upload', $config);
            if (!$this->upload->do_upload()){
            	$data['error_upload'] = $this->upload->display_errors().'Tipe file yang di upload adalah '.$_FILES['userfile']['type'];
            }else{
            	$upload_data = $this->upload->data();
                $data['filename'] = 'File '.$upload_data['file_name'].' berhasil diunggah dan melalui Screening Kelas SMK';
                        
                // Proses screening & import data
                $mode_upd = $this->input->post('mode_update', true);
                $data['hasil'] = $this->import_file($upload_data['file_name'], array(), $mode_upd);
            }   
        }else{
        	$data['error_upload'] = 'Pilih File Excel (.xlsx) yang akan di-screening & di-import';
        }
        
        // Refresh daftar kelas resmi setelah import
        $data['kelas_resmi'] = $this->get_daftar_kelas_resmi();

        $this->template->display_admin($this->kelompok.'/peserta_import_view', 'Import Peserta (Smart Screening SMK)', $data);
    }

    /**
     * Mengambil daftar kelas resmi di database beserta jumlah siswa dan jumlah tes yang terhubung
     */
    private function get_daftar_kelas_resmi(){
        $sql = "
            SELECT g.grup_id, g.grup_nama,
                   (SELECT COUNT(*) FROM cbt_user u WHERE u.user_grup_id = g.grup_id) AS jml_siswa,
                   (SELECT COUNT(*) FROM cbt_tesgrup tg WHERE tg.tstgrp_grup_id = g.grup_id) AS jml_tes
            FROM cbt_user_grup g
            ORDER BY g.grup_nama ASC
        ";
        return $this->db->query($sql)->result();
    }

    /**
     * Membuat Signature Kanonik Kelas SMK untuk menyamakan sinonim jurusan & format tingkat:
     * Contoh:
     *   "X TSM 1", "10 TSM 01", "X-TBSM-1", "X TBSM 1" -> Signature: "X|MOT|1"
     *   "XI TKR 2", "11 TKRO 2"                         -> Signature: "XI|MOB|2"
     *   "XII MP 1", "XII MPLB 1", "XII OTKP 1"          -> Signature: "XII|PER|1"
     *   "X AK 1", "X AKL 1"                             -> Signature: "X|AKU|1"
     *   "X TJKT 2", "X TKJ 2"                           -> Signature: "X|JAR|2"
     */
    private function get_class_canonical_signature($nama_kelas){
        $clean = strtoupper(trim($nama_kelas));
        // Ganti tanda hubung, garis miring, titik, underscore dengan spasi
        $clean = preg_replace('/[\-\_\.\/]+/', ' ', $clean);
        $clean = preg_replace('/\s+/', ' ', $clean);

        // Hapus kata awalan "KELAS" atau "KLS" jika ada
        $clean = preg_replace('/^(KELAS|KLS)\s+/', '', $clean);

        $parts = explode(' ', $clean);
        if(count($parts) < 2){
            return 'RAW|' . $clean;
        }

        // 1. Normalisasi Tingkat
        $tingkat_raw = $parts[0];
        $tingkat = $tingkat_raw;
        if($tingkat_raw === '10' || $tingkat_raw === 'X'){
            $tingkat = 'X';
        }else if($tingkat_raw === '11' || $tingkat_raw === 'XI'){
            $tingkat = 'XI';
        }else if($tingkat_raw === '12' || $tingkat_raw === 'XII'){
            $tingkat = 'XII';
        }

        // 2. Normalisasi Jurusan (Sinonim Kurikulum 2013 vs Kurikulum Merdeka SMK)
        $jurusan_raw = $parts[1];
        $jurusan_map = array(
            // Teknik Sepeda Motor
            'TSM'   => 'MOT',
            'TBSM'  => 'MOT',
            // Teknik Kendaraan Ringan
            'TKR'   => 'MOB',
            'TKRO'  => 'MOB',
            // Teknik Komputer & Jaringan
            'TKJ'   => 'JAR',
            'TJKT'  => 'JAR',
            // Perkantoran
            'OTKP'  => 'PER',
            'MPLB'  => 'PER',
            'MP'    => 'PER',
            'AP'    => 'PER',
            // Akuntansi
            'AKL'   => 'AKU',
            'AK'    => 'AKU'
        );
        $jurusan = isset($jurusan_map[$jurusan_raw]) ? $jurusan_map[$jurusan_raw] : $jurusan_raw;

        // 3. Normalisasi Nomor Rombel (misal "01" -> "1", atau gabungan sisa token)
        $rombel = '';
        if(isset($parts[2])){
            $sisa = array_slice($parts, 2);
            $rombel_str = implode(' ', $sisa);
            if(is_numeric($rombel_str)){
                $rombel = strval(intval($rombel_str));
            }else{
                $rombel = $rombel_str;
            }
        }

        return $tingkat . '|' . $jurusan . '|' . $rombel;
    }

    /**
     * Mencocokkan nama kelas dari Excel ke Kelas Resmi di database cbt_user_grup
     * Mengembalikan array:
     *   status: 'exact' | 'alias' | 'mapped' | 'unrecognized'
     *   grup_id: int (0 jika tidak dikenali)
     *   grup_nama_resmi: string
     *   catatan: string
     */
    private function resolve_group_screening($excel_group_name, $db_groups, $custom_mapping = array()){
        $raw = trim($excel_group_name);
        $upper_raw = strtoupper(preg_replace('/\s+/', ' ', $raw));

        // 0. Cek apakah sudah dipetakan manual oleh operator melalui form Screening
        $map_key = md5($upper_raw);
        if(isset($custom_mapping[$map_key]) && !empty($custom_mapping[$map_key])){
            $chosen = $custom_mapping[$map_key];
            if($chosen === 'CREATE_NEW'){
                // Operator secara eksplisit meminta buat kelas baru
                $q_cek = $this->cbt_user_grup_model->get_by_kolom_limit('grup_nama', $raw, 1);
                if($q_cek->num_rows() > 0){
                    $g = $q_cek->row();
                    return array('status' => 'mapped', 'grup_id' => $g->grup_id, 'grup_nama_resmi' => $g->grup_nama, 'catatan' => 'Dibuat sebagai kelas baru atas persetujuan operator');
                }else{
                    $this->cbt_user_grup_model->save(array('grup_nama' => $raw));
                    $new_id = $this->db->insert_id();
                    return array('status' => 'mapped', 'grup_id' => $new_id, 'grup_nama_resmi' => $raw, 'catatan' => 'Kelas baru dibuat manual oleh operator');
                }
            }else if(is_numeric($chosen) && intval($chosen) > 0){
                $chosen_id = intval($chosen);
                foreach($db_groups as $dbg){
                    if(intval($dbg->grup_id) === $chosen_id){
                        return array(
                            'status' => 'mapped',
                            'grup_id' => $dbg->grup_id,
                            'grup_nama_resmi' => $dbg->grup_nama,
                            'catatan' => 'Dipetakan manual oleh operator dari "'.$raw.'" ke "'.$dbg->grup_nama.'"'
                        );
                    }
                }
            }
        }

        // 1. Cek Exact Match (Case-insensitive & normalisasi spasi)
        foreach($db_groups as $dbg){
            $db_upper = strtoupper(preg_replace('/\s+/', ' ', trim($dbg->grup_nama)));
            if($upper_raw === $db_upper){
                return array(
                    'status' => 'exact',
                    'grup_id' => $dbg->grup_id,
                    'grup_nama_resmi' => $dbg->grup_nama,
                    'catatan' => 'Cocok 100% dengan Kelas Resmi'
                );
            }
        }

        // 2. Cek Canonical Alias Match (Misal: "X TSM 1" -> "X TBSM 1", "X TKR 1" -> "X TKRO 1", "10 AK 1" -> "X AKL 1")
        $excel_sig = $this->get_class_canonical_signature($raw);
        foreach($db_groups as $dbg){
            $db_sig = $this->get_class_canonical_signature($dbg->grup_nama);
            if($excel_sig === $db_sig && strpos($excel_sig, 'RAW|') !== 0){
                return array(
                    'status' => 'alias',
                    'grup_id' => $dbg->grup_id,
                    'grup_nama_resmi' => $dbg->grup_nama,
                    'catatan' => 'Otomatis disesuaikan dari sinonim "'.$raw.'" ➔ Kelas Resmi "'.$dbg->grup_nama.'"'
                );
            }
        }

        // 3. Tidak Dikenali! Jangan buat grup liar otomatis agar siswa tidak kehilangan soal ujian
        return array(
            'status' => 'unrecognized',
            'grup_id' => 0,
            'grup_nama_resmi' => '',
            'catatan' => 'Kelas "'.$raw.'" tidak terdaftar di Daftar Kelas Resmi dan bukan sinonim jurusan yang valid!'
        );
    }

    function import_file($inputfile, $custom_mapping = array(), $mode_update = 'ya'){
        $this->load->library('excel');
        $inputFileName = './public/uploads/'.$inputfile;

        $excel = PHPExcel_IOFactory::load($inputFileName);
        $worksheet = $excel->getSheet(0);
        $highestRow = $worksheet->getHighestRow();

        $db_groups = $this->get_daftar_kelas_resmi();

        if($highestRow <= 2){
            return '<div class="alert alert-warning"><h4><i class="icon fa fa-warning"></i> File Kosong!</h4>Tidak ada baris data peserta yang dapat diproses. Pastikan data dimulai dari baris ke-2 sesuai template.</div>';
        }

        // TAHAP 1: SCREENING SELURUH BARIS EXCEL TERLEBIH DAHULU
        $rows_parsed = array();
        $unrecognized_classes = array(); // key: md5(upper), val: array(raw_name, count, sample_students)
        $alias_converted = array();      // key: raw -> array(target_name, count)
        $exact_matched = array();        // key: target_name -> count
        $duplicate_in_excel = array();
        $seen_usernames = array();
        $baris_format_error = array();

        $row = 2;
        $kosong = 0;
        while($kosong < 4 && $row <= $highestRow + 1){
            $kosong = 0;
            $kolom1 = trim((string)$worksheet->getCellByColumnAndRow(1, $row)->getValue()); // username
            $kolom2 = trim((string)$worksheet->getCellByColumnAndRow(2, $row)->getValue()); // password
            $kolom3 = trim((string)$worksheet->getCellByColumnAndRow(3, $row)->getValue()); // nama
            $kolom4 = trim((string)$worksheet->getCellByColumnAndRow(4, $row)->getValue()); // email
            $kolom5 = trim((string)$worksheet->getCellByColumnAndRow(5, $row)->getValue()); // group / kelas
            $kolom6 = trim((string)$worksheet->getCellByColumnAndRow(6, $row)->getValue()); // keterangan (Ruang/Sesi)

            if(empty($kolom1)){ $kosong++; }
            if(empty($kolom2)){ $kosong++; }
            if(empty($kolom3)){ $kosong++; }
            if(empty($kolom5)){ $kosong++; }

            if($kosong == 0){
                // Cek duplikat username di dalam file Excel yang sama
                $uname_lower = strtolower($kolom1);
                if(isset($seen_usernames[$uname_lower])){
                    $duplicate_in_excel[] = 'Baris ke-'.$row.' (Username: <b>'.htmlspecialchars($kolom1).'</b> - '.htmlspecialchars($kolom3).') ganda dengan baris ke-'.$seen_usernames[$uname_lower];
                }else{
                    $seen_usernames[$uname_lower] = $row;
                }

                // Screening nama kelas
                $res_grup = $this->resolve_group_screening($kolom5, $db_groups, $custom_mapping);
                // Refresh db_groups jika baru saja dibuat lewat CREATE_NEW
                if($res_grup['status'] === 'mapped'){
                    $db_groups = $this->get_daftar_kelas_resmi();
                }

                if($res_grup['status'] === 'unrecognized'){
                    $upper_k5 = strtoupper(preg_replace('/\s+/', ' ', $kolom5));
                    $mkey = md5($upper_k5);
                    if(!isset($unrecognized_classes[$mkey])){
                        $unrecognized_classes[$mkey] = array(
                            'raw_name' => $kolom5,
                            'count' => 0,
                            'samples' => array()
                        );
                    }
                    $unrecognized_classes[$mkey]['count']++;
                    if(count($unrecognized_classes[$mkey]['samples']) < 3){
                        $unrecognized_classes[$mkey]['samples'][] = $kolom3 . ' ('.$kolom1.')';
                    }
                }else if($res_grup['status'] === 'alias' || $res_grup['status'] === 'mapped'){
                    $akey = $kolom5 . ' ➔ ' . $res_grup['grup_nama_resmi'];
                    if(!isset($alias_converted[$akey])){
                        $alias_converted[$akey] = 0;
                    }
                    $alias_converted[$akey]++;
                }else{
                    $tname = $res_grup['grup_nama_resmi'];
                    if(!isset($exact_matched[$tname])){
                        $exact_matched[$tname] = 0;
                    }
                    $exact_matched[$tname]++;
                }

                $rows_parsed[] = array(
                    'row' => $row,
                    'username' => preg_replace('/\s+/', '', $kolom1), // Bersihkan spasi liar di username
                    'password' => $kolom2,
                    'nama' => ucwords(addslashes($kolom3)),
                    'nama_raw' => $kolom3,
                    'email' => $kolom4,
                    'kelas_excel' => $kolom5,
                    'keterangan' => $kolom6,
                    'screening' => $res_grup
                );
            }else if($kosong < 4){
                $baris_format_error[] = 'Baris ke-'.$row.' tidak lengkap (Username: <b>'.htmlspecialchars($kolom1).'</b> | Nama: <b>'.htmlspecialchars($kolom3).'</b> | Kelas: <b>'.htmlspecialchars($kolom5).'</b>)';
            }
            $row++;
        }

        // JIKA ADA KELAS YANG TIDAK DIKENALI, TAHAN (HOLD) ATAU TAMPILKAN FORM PEMETAAN KELAS INTERAKTIF!
        // Siswa pada kelas yang sudah valid/alias tetap kita proses atau kita tahan?
        // Lebih aman: Proses siswa yang kelasnya sudah Valid (Exact & Alias), dan tahan siswa yang kelasnya Tidak Dikenali sambil menampilkan Tabel Pemetaan Interaktif agar operator tinggal pilih dropdown kelas resmi lalu klik "Selesaikan Import"!
        $jmldatasukses = 0;
        $jmldataupdate = 0;
        $jmldataskip = 0;
        $jmldatatertahan = 0;

        foreach($rows_parsed as $item){
            $scr = $item['screening'];
            if($scr['status'] === 'unrecognized' || $scr['grup_id'] == 0){
                $jmldatatertahan++;
                continue;
            }

            $data_user = array(
                'user_name' => $item['username'],
                'user_password' => $item['password'],
                'user_email' => $item['email'],
                'user_firstname' => $item['nama'],
                'user_grup_id' => $scr['grup_id'],
                'user_detail' => $item['keterangan']
            );

            if($this->cbt_user_model->count_by_kolom('user_name', $item['username'])->row()->hasil > 0){
                if($mode_update !== 'skip'){
                    $this->cbt_user_model->update('user_name', $item['username'], $data_user);
                    $jmldataupdate++;
                }else{
                    $jmldataskip++;
                }
            }else{
                $this->cbt_user_model->save($data_user);
                $jmldatasukses++;
            }
        }

        // BANGUN LAPORAN HASIL SCREENING DETAIL
        $html = '';

        // 1. Tampilkan Kotak Peringatan & Form Resolusi Jika Ada Kelas Tidak Dikenali
        if(!empty($unrecognized_classes)){
            $html .= '<div class="box box-danger box-solid" style="margin-top: 15px;">';
            $html .= '<div class="box-header with-border"><h3 class="box-title"><i class="fa fa-shield"></i> SCREENING KETAT: Ditemukan '.count($unrecognized_classes).' Nama Kelas di Excel yang Tidak Terdaftar! ('.$jmldatatertahan.' Siswa Ditahan)</h3></div>';
            $html .= '<div class="box-body">';
            $html .= '<p style="font-size:13px;">Untuk mencegah kejadian <b>soal ujian tidak muncul</b> akibat nama kelas di Excel berbeda dengan kelas di Jadwal Tes, sistem menahan <b>'.$jmldatatertahan.' siswa</b> berikut. Silakan pilih <b>Kelas Resmi Tujuan</b> di bawah ini lalu klik <b>Terapkan Pemetaan Kelas &amp; Import</b> (tanpa perlu mengedit file Excel):</p>';
            $html .= '<input type="hidden" name="cached_excel_file" value="'.htmlspecialchars($inputfile).'">';
            $html .= '<table class="table table-bordered table-striped" style="background:#fff; font-size:12.5px;">';
            $html .= '<thead><tr style="background:#f8fafc;"><th>Nama Kelas Tertulis di Excel</th><th style="width:110px; text-align:center;">Jumlah Siswa</th><th>Contoh Siswa di Baris Tersebut</th><th style="width:320px;">Pilih Kelas Resmi Tujuan di Database</th></tr></thead><tbody>';

            foreach($unrecognized_classes as $mkey => $uinfo){
                $html .= '<tr>';
                $html .= '<td><span class="label label-danger" style="font-size:12px;">'.htmlspecialchars($uinfo['raw_name']).'</span></td>';
                $html .= '<td style="text-align:center;"><b>'.$uinfo['count'].' Siswa</b></td>';
                $html .= '<td style="font-size:11.5px; color:#475569;">'.htmlspecialchars(implode(', ', $uinfo['samples'])).'</td>';
                $html .= '<td>';
                $html .= '<select name="map_kelas['.$mkey.']" class="form-control input-sm" required>';
                $html .= '<option value="">-- Pilih Kelas Resmi yang Sesuai --</option>';
                foreach($db_groups as $dbg){
                    $html .= '<option value="'.$dbg->grup_id.'">➔ Masukkan ke Kelas Resmi: '.htmlspecialchars($dbg->grup_nama).' ('.$dbg->jml_tes.' Tes)</option>';
                }
                $html .= '<option value="CREATE_NEW">➕ Buat Sebagai Kelas Baru: "'.htmlspecialchars($uinfo['raw_name']).'"</option>';
                $html .= '</select>';
                $html .= '</td>';
                $html .= '</tr>';
            }
            $html .= '</tbody></table>';
            $html .= '<div class="text-right" style="margin-top:10px;">';
            $html .= '<button type="submit" class="btn btn-danger"><i class="fa fa-check-circle"></i> Terapkan Pemetaan Kelas &amp; Import Siswa Sekarang</button>';
            $html .= '</div>';
            $html .= '</div></div>';
        }

        // 2. Tampilkan Laporan Konversi Sinonim Otomatis (Misal X TSM 1 -> X TBSM 1)
        if(!empty($alias_converted)){
            $html .= '<div class="alert alert-warning" style="margin-top: 15px;">';
            $html .= '<h4><i class="icon fa fa-magic"></i> Smart Screening SMK: Penyesuaian Otomatis Sinonim Kelas!</h4>';
            $html .= '<p style="margin-bottom:6px;">Sistem mendeteksi penulisan singkatan kelas di Excel yang berbeda dengan nama kelas resmi di database dan <b>telah otomatis menyamakannya ke Kelas Resmi</b> agar soal ujian siswa tetap muncul:</p><ul style="margin-bottom:0;">';
            foreach($alias_converted as $label_conv => $cnt){
                $html .= '<li><b>'.htmlspecialchars($label_conv).'</b> (<b>'.$cnt.' siswa</b> otomatis masuk ke kelas resmi)</li>';
            }
            $html .= '</ul></div>';
        }

        // 3. Tampilkan Peringatan Duplikat Username di dalam Excel atau Baris Error
        if(!empty($duplicate_in_excel) || !empty($baris_format_error)){
            $html .= '<div class="alert alert-danger" style="margin-top: 15px;">';
            $html .= '<h4><i class="icon fa fa-exclamation-circle"></i> Catatan Temuan Screening Data Baris Excel:</h4><ul style="margin-bottom:0;">';
            foreach($duplicate_in_excel as $dmsg){
                $html .= '<li>⚠️ <b>Duplikat Username di Excel:</b> '.$dmsg.'</li>';
            }
            foreach($baris_format_error as $emsg){
                $html .= '<li>❌ <b>Data Kolom Tidak Lengkap:</b> '.$emsg.'</li>';
            }
            $html .= '</ul></div>';
        }

        // 4. Ringkasan Sukses Import
        $box_color = ($jmldatatertahan > 0) ? 'alert-info' : 'alert-success';
        $html .= '<div class="alert '.$box_color.' alert-dismissable" style="margin-top: 15px;">';
        $html .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
        $html .= '<h4><i class="icon fa fa-check-square-o"></i> Hasil Screening &amp; Eksekusi Import Peserta</h4>';
        $html .= '<table class="table table-condensed" style="max-width:520px; margin-bottom:8px; background:rgba(255,255,255,0.15); color:#fff;">';
        $html .= '<tr><td>✅ Peserta Baru Berhasil Ditambahkan</td><td>: <b>'.$jmldatasukses.' Siswa</b></td></tr>';
        $html .= '<tr><td>🔄 Peserta Lama Diperbarui (Kelas / Ruang / Password)</td><td>: <b>'.$jmldataupdate.' Siswa</b></td></tr>';
        if($jmldataskip > 0){
            $html .= '<tr><td>⏭️ Peserta Lama Dilewati (Skip)</td><td>: <b>'.$jmldataskip.' Siswa</b></td></tr>';
        }
        if($jmldatatertahan > 0){
            $html .= '<tr><td>🛑 Peserta Ditahan (Menunggu Konfirmasi Kelas Resmi di Atas)</td><td>: <b>'.$jmldatatertahan.' Siswa</b></td></tr>';
        }
        $html .= '<tr><td>📊 Total Baris Valid di Excel</td><td>: <b>'.count($rows_parsed).' Baris</b></td></tr>';
        $html .= '</table>';

        if(!empty($exact_matched)){
            $ringkasan_exact = array();
            foreach($exact_matched as $kname => $kcnt){
                $ringkasan_exact[] = htmlspecialchars($kname).' ('.$kcnt.')';
            }
            $html .= '<div style="font-size:12px;"><b>Kelas Cocok Persis:</b> '.implode(', ', $ringkasan_exact).'</div>';
        }
        $html .= '</div>';

        return $html;
    }
}