<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller Portal Download Hasil Nilai Peserta Didik untuk Guru (Terpisah per Kelas / Rombel)
 * Dapat diakses langsung oleh Bapak/Ibu Guru untuk melihat & mengunduh rekap nilai per kelas
 * (baik 1 file Excel per kelas maupun 1 file Excel Multi-Sheet untuk seluruh kelas).
 */
class Portal_nilai extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('cbt_konfigurasi_model');
        $this->load->model('cbt_modul_model');
        $this->load->model('cbt_topik_model');
        $this->load->model('cbt_tes_model');
        $this->load->model('cbt_user_grup_model');
        $this->load->model('cbt_user_model');
        $this->load->model('cbt_tes_user_model');
    }

    public static function clean_topik_nama($topik_nama){
        if(empty($topik_nama)) return '';
        $clean = preg_replace('/\[(SENIN|SELASA|RABU|KAMIS|JUMAT|SABTU|MINGGU|HARI)[^\]]*\]\s*/i', '', $topik_nama);
        $clean = preg_replace('/^\[[^\]]+\]\s*/', '', $clean);
        return trim($clean);
    }

    public static function extract_tingkat($str){
        if(preg_match('/\b(XII|12)\b/i', $str)){
            return 'XII';
        } else if(preg_match('/\b(XI|11)\b/i', $str)){
            return 'XI';
        } else if(preg_match('/\b(X|10)\b/i', $str)){
            return 'X';
        }
        return 'Umum';
    }

    public static function format_label_kelas_alias($grup_nama){
        $upper = strtoupper(trim($grup_nama));
        if(preg_match('/\bOTKP\b/', $upper)){
            $alias = preg_replace('/\bOTKP\b/i', 'MP / MPLB', $grup_nama);
            return $grup_nama . ' (' . $alias . ')';
        }
        if(preg_match('/\bTBSM\b/', $upper)){
            $alias = preg_replace('/\bTBSM\b/i', 'TSM', $grup_nama);
            return $grup_nama . ' (' . $alias . ')';
        }
        if(preg_match('/\bTKRO\b/', $upper)){
            $alias = preg_replace('/\bTKRO\b/i', 'TKR', $grup_nama);
            return $grup_nama . ' (' . $alias . ')';
        }
        if(preg_match('/\bAKL\b/', $upper)){
            $alias = preg_replace('/\bAKL\b/i', 'AK', $grup_nama);
            return $grup_nama . ' (' . $alias . ')';
        }
        return $grup_nama;
    }

    /**
     * Halaman Utama Portal Download Nilai Guru per Kelas
     */
    public function index($topik_id = null){
        if(empty($topik_id)){
            $topik_id = $this->input->get('topik_id', TRUE);
        }
        $selected_grup_id = $this->input->get('grup_id', TRUE);
        $data['selected_grup_id'] = !empty($selected_grup_id) ? $selected_grup_id : 'ALL';

        $query_konfig = $this->cbt_konfigurasi_model->get_by_kolom_limit('konfigurasi_kode', 'cbt_nama', 1);
        $data['site_name'] = ($query_konfig->num_rows() > 0) ? $query_konfig->row()->konfigurasi_isi : 'SMART-CBT';
        $data['title'] = 'Portal Unduh Nilai Peserta Didik per Kelas';

        // Ambil daftar seluruh topik mata pelajaran beserta jumlah soal & jumlah peserta yang sudah mengerjakan
        $sql_topik = "
            SELECT t.topik_id, t.topik_modul_id, t.topik_nama, t.topik_detail,
                   m.modul_nama,
                   (SELECT COUNT(*) FROM cbt_soal s WHERE s.soal_topik_id = t.topik_id) AS jml_soal,
                   (SELECT COUNT(DISTINCT ts.tset_tes_id) FROM cbt_tes_topik_set ts WHERE ts.tset_topik_id = t.topik_id) AS jml_jadwal,
                   (SELECT COUNT(DISTINCT tu.tesuser_user_id)
                    FROM cbt_tes_user tu
                    INNER JOIN cbt_tes_topik_set ts2 ON ts2.tset_tes_id = tu.tesuser_tes_id
                    WHERE ts2.tset_topik_id = t.topik_id) AS jml_peserta_ujian
            FROM cbt_topik t
            INNER JOIN cbt_modul m ON t.topik_modul_id = m.modul_id
            ORDER BY m.modul_nama ASC, t.topik_nama ASC
        ";
        $raw_topiks = $this->db->query($sql_topik)->result();

        $topik_list = array();
        $selected_topik = null;

        foreach($raw_topiks as $rt){
            $rt->clean_nama = self::clean_topik_nama($rt->topik_nama);
            $rt->tingkat = self::extract_tingkat($rt->modul_nama . ' ' . $rt->topik_nama);
            $topik_list[] = $rt;

            if(!empty($topik_id) && intval($rt->topik_id) === intval($topik_id)){
                $selected_topik = $rt;
            }
        }

        // Jika belum ada topik yang dipilih, pilih topik pertama yang sudah ada peserta ujiannya (atau topik pertama)
        if($selected_topik === null && !empty($topik_list)){
            foreach($topik_list as $tl){
                if(intval($tl->jml_peserta_ujian) > 0){
                    $selected_topik = $tl;
                    break;
                }
            }
            if($selected_topik === null){
                $selected_topik = $topik_list[0];
            }
        }

        $data['topik_list'] = $topik_list;
        $data['selected_topik'] = $selected_topik;
        $data['rekap_kelas'] = array();

        if($selected_topik !== null){
            $data['rekap_kelas'] = $this->get_rekap_nilai_per_kelas($selected_topik->topik_id, $selected_topik);
        }

        $this->load->view('portal_nilai/portal_nilai_view', $data);
    }

    /**
     * Mengambil data lengkap nilai peserta didik yang dikelompokkan berdasarkan Kelas (Rombel)
     * untuk satu Topik Mata Pelajaran (menggabungkan seluruh shift / jadwal tes pada topik tersebut).
     */
    private function get_rekap_nilai_per_kelas($topik_id, $topik_obj = null){
        $topik_id = intval($topik_id);
        if($topik_obj === null){
            $q_tp = $this->cbt_topik_model->get_by_kolom_join_modul('topik_id', $topik_id);
            if($q_tp->num_rows() == 0) return array();
            $topik_obj = $q_tp->row();
            $topik_obj->clean_nama = self::clean_topik_nama($topik_obj->topik_nama);
            $topik_obj->tingkat = self::extract_tingkat($topik_obj->modul_nama . ' ' . $topik_obj->topik_nama);
        }

        // 1. Cari semua tes_id yang menggunakan topik_id ini
        $q_tset = $this->db->select('tset_tes_id, tset_jumlah')
                           ->from('cbt_tes_topik_set')
                           ->where('tset_topik_id', $topik_id)
                           ->get();
        $tes_ids = array();
        $target_jml_soal = 0;
        foreach($q_tset->result() as $ts){
            $tes_ids[] = intval($ts->tset_tes_id);
            if(intval($ts->tset_jumlah) > $target_jml_soal){
                $target_jml_soal = intval($ts->tset_jumlah);
            }
        }
        if($target_jml_soal == 0){
            $target_jml_soal = $this->db->where('soal_topik_id', $topik_id)->count_all_results('cbt_soal');
        }

        // 2. Cari semua grup_id (Kelas) yang terdaftar mengikuti tes-tes tersebut di cbt_tesgrup
        $grup_ids = array();
        if(!empty($tes_ids)){
            $q_tg = $this->db->select('DISTINCT(tstgrp_grup_id) AS grup_id')
                             ->from('cbt_tesgrup')
                             ->where_in('tstgrp_tes_id', $tes_ids)
                             ->get();
            foreach($q_tg->result() as $tg){
                $grup_ids[] = intval($tg->grup_id);
            }
        }

        // Jika belum ada di cbt_tesgrup, filter kelas berdasarkan tingkat & jurusan yang cocok dengan nama topik
        if(empty($grup_ids)){
            $all_grups = $this->cbt_user_grup_model->get_group()->result();
            $t_upper = strtoupper($topik_obj->modul_nama . ' ' . $topik_obj->topik_nama);
            $tingkat = $topik_obj->tingkat;

            $jurusan_filter = array();
            $map_j = array(
                'AKL'  => array('AKL', 'AK'),
                'OTKP' => array('OTKP', 'MPLB', 'MP', 'AP'),
                'TKJ'  => array('TKJ', 'TJKT'),
                'TKRO' => array('TKRO', 'TKR', 'OTOMOTIF'),
                'TBSM' => array('TBSM', 'TSM', 'OTOMOTIF')
            );
            foreach($map_j as $canon => $aliases){
                foreach($aliases as $al){
                    if(preg_match('/\b'.preg_quote($al, '/').'\b/', $t_upper)){
                        $jurusan_filter = array_merge($jurusan_filter, $aliases);
                        break;
                    }
                }
            }

            foreach($all_grups as $ag){
                $g_upper = strtoupper($ag->grup_nama);
                if($tingkat !== 'Umum' && !preg_match('/\b'.preg_quote($tingkat, '/').'\b/', $g_upper)){
                    continue;
                }
                if(!empty($jurusan_filter)){
                    $matched_j = false;
                    foreach($jurusan_filter as $jf){
                        if(preg_match('/\b'.preg_quote($jf, '/').'\b/', $g_upper)){
                            $matched_j = true;
                            break;
                        }
                    }
                    if(!$matched_j) continue;
                }
                $grup_ids[] = intval($ag->grup_id);
            }
        }

        if(empty($grup_ids)){
            return array();
        }

        // 3. Ambil daftar kelas urut abjad grup_nama
        $this->db->from('cbt_user_grup')
                 ->where_in('grup_id', $grup_ids)
                 ->order_by('grup_nama', 'ASC');
        $kelas_rows = $this->db->get()->result();

        // 4. Ambil seluruh siswa pada kelas-kelas tersebut (urut abjad user_firstname ASC)
        $this->db->select('user_id, user_grup_id, user_name, user_firstname, user_detail')
                 ->from('cbt_user')
                 ->where_in('user_grup_id', $grup_ids)
                 ->order_by('user_firstname', 'ASC');
        $all_students = $this->db->get()->result();

        $students_by_grup = array();
        foreach($all_students as $st){
            $students_by_grup[$st->user_grup_id][] = $st;
        }

        // 5. Ambil seluruh hasil ujian siswa untuk tes_ids tersebut dalam 1 query agregasi cepat
        $scores_by_user = array();
        if(!empty($tes_ids)){
            $tes_ids_str = implode(',', $tes_ids);
            $sql_nilai = "
                SELECT tu.tesuser_id, tu.tesuser_user_id, tu.tesuser_tes_id, tu.tesuser_status,
                       tu.tesuser_creation_time, tu.tesuser_pelanggaran,
                       t.tes_nama, t.tes_duration_time,
                       COUNT(ts.tessoal_id) AS total_butir,
                       COUNT(CASE WHEN ts.tessoal_change_time IS NOT NULL THEN 1 END) AS jml_dijawab,
                       COUNT(CASE WHEN ts.tessoal_nilai > 0 THEN 1 END) AS jml_benar,
                       COUNT(CASE WHEN ts.tessoal_change_time IS NOT NULL AND ts.tessoal_nilai <= 0 THEN 1 END) AS jml_salah,
                       IF(ROUND(SUM(ts.tessoal_nilai), 1) >= 99.9, 100, ROUND(SUM(ts.tessoal_nilai), 2)) AS nilai_akhir
                FROM cbt_tes_user tu
                INNER JOIN cbt_tes t ON tu.tesuser_tes_id = t.tes_id
                LEFT JOIN cbt_tes_soal ts ON ts.tessoal_tesuser_id = tu.tesuser_id
                WHERE tu.tesuser_tes_id IN ($tes_ids_str)
                GROUP BY tu.tesuser_id
                ORDER BY nilai_akhir DESC, tu.tesuser_creation_time DESC
            ";
            $nilai_rows = $this->db->query($sql_nilai)->result();
            foreach($nilai_rows as $nr){
                // Simpan hasil dengan nilai tertinggi jika siswa punya >1 sesi di tes berbeda pada topik yang sama
                if(!isset($scores_by_user[$nr->tesuser_user_id])){
                    $scores_by_user[$nr->tesuser_user_id] = $nr;
                }
            }
        }

        // 6. Susun struktur per kelas
        $rekap_kelas = array();
        foreach($kelas_rows as $kr){
            $siswa_kelas = isset($students_by_grup[$kr->grup_id]) ? $students_by_grup[$kr->grup_id] : array();
            $total_siswa = count($siswa_kelas);
            $sudah_ujian = 0;
            $belum_ujian = 0;
            $sum_nilai = 0;
            $max_nilai = null;
            $min_nilai = null;
            $daftar_siswa = array();
            $nama_belum_ujian = array();

            foreach($siswa_kelas as $sk){
                $sc = isset($scores_by_user[$sk->user_id]) ? $scores_by_user[$sk->user_id] : null;
                if($sc !== null){
                    $sudah_ujian++;
                    $val_nilai = floatval($sc->nilai_akhir);
                    $sum_nilai += $val_nilai;
                    if($max_nilai === null || $val_nilai > $max_nilai) $max_nilai = $val_nilai;
                    if($min_nilai === null || $val_nilai < $min_nilai) $min_nilai = $val_nilai;

                    $status_label = 'SELESAI';
                    if($sc->tesuser_status == 3){
                        $status_label = 'TERKUNCI ANTI-CHEAT';
                    }else if($sc->tesuser_status == 1){
                        $dt_now = new DateTime();
                        $dt_end = new DateTime($sc->tesuser_creation_time);
                        $dt_end->modify('+'.$sc->tes_duration_time.' minutes');
                        if($dt_now < $dt_end){
                            $status_label = 'SEDANG MENGERJAKAN';
                        }
                    }

                    $daftar_siswa[] = array(
                        'user_id' => $sk->user_id,
                        'username' => $sk->user_name,
                        'nama' => stripslashes($sk->user_firstname),
                        'kelas' => $kr->grup_nama,
                        'ruang' => !empty($sk->user_detail) ? $sk->user_detail : '-',
                        'sudah_ujian' => true,
                        'waktu_mulai' => $sc->tesuser_creation_time,
                        'jml_soal' => intval($sc->total_butir) > 0 ? intval($sc->total_butir) : $target_jml_soal,
                        'jml_benar' => intval($sc->jml_benar),
                        'jml_salah' => intval($sc->jml_salah),
                        'nilai' => $val_nilai,
                        'status' => $status_label
                    );
                }else{
                    $belum_ujian++;
                    $nama_belum_ujian[] = stripslashes($sk->user_firstname);
                    $daftar_siswa[] = array(
                        'user_id' => $sk->user_id,
                        'username' => $sk->user_name,
                        'nama' => stripslashes($sk->user_firstname),
                        'kelas' => $kr->grup_nama,
                        'ruang' => !empty($sk->user_detail) ? $sk->user_detail : '-',
                        'sudah_ujian' => false,
                        'waktu_mulai' => '-',
                        'jml_soal' => $target_jml_soal,
                        'jml_benar' => 0,
                        'jml_salah' => 0,
                        'nilai' => 0,
                        'status' => 'BELUM UJIAN'
                    );
                }
            }

            $rata_rata = ($sudah_ujian > 0) ? round($sum_nilai / $sudah_ujian, 2) : 0;

            $rekap_kelas[] = array(
                'grup_id' => $kr->grup_id,
                'grup_nama' => $kr->grup_nama,
                'grup_label_alias' => self::format_label_kelas_alias($kr->grup_nama),
                'total_siswa' => $total_siswa,
                'sudah_ujian' => $sudah_ujian,
                'belum_ujian' => $belum_ujian,
                'rata_rata' => $rata_rata,
                'nilai_max' => ($max_nilai !== null) ? $max_nilai : 0,
                'nilai_min' => ($min_nilai !== null) ? $min_nilai : 0,
                'nama_belum_ujian' => $nama_belum_ujian,
                'siswa_list' => $daftar_siswa
            );
        }

        return $rekap_kelas;
    }

    /**
     * Download File Excel (.xlsx) untuk 1 Kelas Spesifik pada 1 Topik Mata Pelajaran
     */
    public function download_kelas($topik_id = null, $grup_id = null){
        if(empty($topik_id) || empty($grup_id)){
            redirect('portal_nilai');
            return;
        }

        $q_tp = $this->cbt_topik_model->get_by_kolom_join_modul('topik_id', intval($topik_id));
        if($q_tp->num_rows() == 0){
            show_error('Topik Mata Pelajaran tidak ditemukan.', 404);
            return;
        }
        $topik = $q_tp->row();
        $topik->clean_nama = self::clean_topik_nama($topik->topik_nama);
        $topik->tingkat = self::extract_tingkat($topik->modul_nama . ' ' . $topik->topik_nama);

        $rekap_all = $this->get_rekap_nilai_per_kelas($topik_id, $topik);
        $target_kelas = null;
        foreach($rekap_all as $rk){
            if(intval($rk['grup_id']) === intval($grup_id)){
                $target_kelas = $rk;
                break;
            }
        }

        if($target_kelas === null){
            show_error('Data Kelas tidak ditemukan pada mata pelajaran ini.', 404);
            return;
        }

        $this->load->library('excel');
        $excel = new PHPExcel();
        $excel->getProperties()
              ->setCreator('SMART-CBT SMK 11 MARET')
              ->setTitle('Daftar Nilai ' . $target_kelas['grup_nama'] . ' - ' . $topik->clean_nama);

        $sheet = $excel->setActiveSheetIndex(0);
        $this->populate_class_worksheet($sheet, $topik, $target_kelas);

        $clean_kls = preg_replace('/[^A-Za-z0-9\-_ ]/', '', $target_kelas['grup_nama']);
        $clean_mapel = preg_replace('/[^A-Za-z0-9\-_ ]/', '', $topik->clean_nama);
        $filename = 'Nilai_' . str_replace(' ', '_', $clean_kls) . '_' . str_replace(' ', '_', $clean_mapel) . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
    }

    /**
     * Download File Excel (.xlsx) untuk Kelas yang Dicentang / Dipilih Guru Saja (Bisa 1 Kelas atau Beberapa Kelas Pilihan)
     */
    public function download_pilihan(){
        $topik_id = $this->input->get('topik_id', TRUE);
        $grup_ids_param = $this->input->get('grup_ids', TRUE);

        if(empty($topik_id) || empty($grup_ids_param)){
            redirect('portal_nilai');
            return;
        }

        $chosen_ids = array_filter(array_map('intval', explode(',', $grup_ids_param)));
        if(empty($chosen_ids)){
            redirect('portal_nilai?topik_id='.intval($topik_id));
            return;
        }

        // Jika hanya 1 kelas yang dipilih, langsung panggil download_kelas (1 sheet khusus kelas tersebut saja)
        if(count($chosen_ids) === 1){
            $single_gid = reset($chosen_ids);
            $this->download_kelas($topik_id, $single_gid);
            return;
        }

        // Jika beberapa kelas spesifik yang dipilih (misal X MP 1 dan X TKJ 1 saja), buat file Excel hanya untuk kelas-kelas tersebut
        $q_tp = $this->cbt_topik_model->get_by_kolom_join_modul('topik_id', intval($topik_id));
        if($q_tp->num_rows() == 0){
            show_error('Topik Mata Pelajaran tidak ditemukan.', 404);
            return;
        }
        $topik = $q_tp->row();
        $topik->clean_nama = self::clean_topik_nama($topik->topik_nama);
        $topik->tingkat = self::extract_tingkat($topik->modul_nama . ' ' . $topik->topik_nama);

        $rekap_all = $this->get_rekap_nilai_per_kelas($topik_id, $topik);
        $rekap_filtered = array();
        foreach($rekap_all as $rk){
            if(in_array(intval($rk['grup_id']), $chosen_ids)){
                $rekap_filtered[] = $rk;
            }
        }

        if(empty($rekap_filtered)){
            show_error('Kelas yang dipilih tidak ditemukan.', 404);
            return;
        }

        $this->load->library('excel');
        $excel = new PHPExcel();
        $excel->getProperties()
              ->setCreator('SMART-CBT SMK 11 MARET')
              ->setTitle('Daftar Nilai Kelas Pilihan - ' . $topik->clean_nama);

        $sheet_index = 0;
        foreach($rekap_filtered as $rk){
            if($sheet_index == 0){
                $sheet = $excel->setActiveSheetIndex(0);
            }else{
                $sheet = $excel->createSheet($sheet_index);
            }
            $this->populate_class_worksheet($sheet, $topik, $rk);
            $sheet_index++;
        }

        $excel->setActiveSheetIndex(0);
        $clean_mapel = preg_replace('/[^A-Za-z0-9\-_ ]/', '', $topik->clean_nama);
        $filename = 'Nilai_' . count($rekap_filtered) . '_Kelas_Pilihan_' . str_replace(' ', '_', $clean_mapel) . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
    }

    /**
     * Download 1 File Excel (.xlsx) Berisi SEMUA KELAS Sekaligus (Otomatis Pisah Sheet / Tab per Kelas)
     */
    public function download_semua_kelas($topik_id = null){
        if(empty($topik_id)){
            redirect('portal_nilai');
            return;
        }

        $q_tp = $this->cbt_topik_model->get_by_kolom_join_modul('topik_id', intval($topik_id));
        if($q_tp->num_rows() == 0){
            show_error('Topik Mata Pelajaran tidak ditemukan.', 404);
            return;
        }
        $topik = $q_tp->row();
        $topik->clean_nama = self::clean_topik_nama($topik->topik_nama);
        $topik->tingkat = self::extract_tingkat($topik->modul_nama . ' ' . $topik->topik_nama);

        $rekap_all = $this->get_rekap_nilai_per_kelas($topik_id, $topik);
        if(empty($rekap_all)){
            show_error('Belum ada data kelas pada mata pelajaran ini.', 404);
            return;
        }

        $this->load->library('excel');
        $excel = new PHPExcel();
        $excel->getProperties()
              ->setCreator('SMART-CBT SMK 11 MARET')
              ->setTitle('Rekap Nilai Semua Kelas - ' . $topik->clean_nama);

        // SHEET 0: RINGKASAN SELURUH KELAS
        $summarySheet = $excel->setActiveSheetIndex(0);
        $summarySheet->setTitle('REKAP SEMUA KELAS');

        $summarySheet->setCellValue('A1', 'REKAPITULASI NILAI UJIAN PER KELAS - SMART-CBT');
        $summarySheet->setCellValue('A2', 'Mata Pelajaran : ' . $topik->modul_nama . ' (' . $topik->clean_nama . ')');
        $summarySheet->setCellValue('A3', 'Waktu Unduh    : ' . date('d-m-Y H:i:s'));
        $summarySheet->getStyle('A1:A2')->getFont()->setBold(true)->setSize(12);

        $headers_sum = array('No', 'Nama Kelas / Rombel', 'Total Siswa', 'Sudah Ujian', 'Belum Ujian (Susulan)', 'Rata-rata Kelas', 'Nilai Tertinggi', 'Nilai Terendah');
        $col_letters = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H');
        foreach($headers_sum as $idx => $htext){
            $cell = $col_letters[$idx] . '5';
            $summarySheet->setCellValue($cell, $htext);
            $summarySheet->getStyle($cell)->getFont()->setBold(true);
            $summarySheet->getStyle($cell)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('1E3C72');
            $summarySheet->getStyle($cell)->getFont()->getColor()->setRGB('FFFFFF');
        }

        $r_idx = 6;
        $no_k = 1;
        foreach($rekap_all as $rk){
            $summarySheet->setCellValue('A'.$r_idx, $no_k++);
            $summarySheet->setCellValue('B'.$r_idx, $rk['grup_nama']);
            $summarySheet->setCellValue('C'.$r_idx, $rk['total_siswa']);
            $summarySheet->setCellValue('D'.$r_idx, $rk['sudah_ujian']);
            $summarySheet->setCellValue('E'.$r_idx, $rk['belum_ujian']);
            $summarySheet->setCellValue('F'.$r_idx, $rk['rata_rata']);
            $summarySheet->setCellValue('G'.$r_idx, $rk['nilai_max']);
            $summarySheet->setCellValue('H'.$r_idx, $rk['nilai_min']);
            $r_idx++;
        }
        foreach($col_letters as $cl){
            $summarySheet->getColumnDimension($cl)->setAutoSize(true);
        }

        // SHEET 1..N: MASING-MASING KELAS DI SHEET TERPISAH
        $sheet_index = 1;
        foreach($rekap_all as $rk){
            $newSheet = $excel->createSheet($sheet_index);
            $this->populate_class_worksheet($newSheet, $topik, $rk);
            $sheet_index++;
        }

        // Aktifkan sheet kelas pertama atau rekap
        $excel->setActiveSheetIndex(0);

        $clean_mapel = preg_replace('/[^A-Za-z0-9\-_ ]/', '', $topik->clean_nama);
        $filename = 'Rekap_Nilai_Per_Kelas_' . str_replace(' ', '_', $clean_mapel) . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
    }

    /**
     * Mengisi 1 Sheet Excel untuk 1 Kelas (Urut Abjad A-Z + Siswa Belum Ujian + Jml Benar/Salah/Nilai Skala 100)
     */
    private function populate_class_worksheet($sheet, $topik, $kelas_data){
        // Bersihkan nama sheet agar valid di Excel (maks 31 karakter, tanpa karakter : \ / ? * [ ])
        $safe_title = preg_replace('/[\:\\\/\?\*\[\]]/', ' ', $kelas_data['grup_nama']);
        $safe_title = trim(substr($safe_title, 0, 31));
        if(empty($safe_title)) $safe_title = 'Kelas_' . $kelas_data['grup_id'];
        $sheet->setTitle($safe_title);

        // Header Informasi Kelas & Mapel
        $sheet->setCellValue('A1', 'DAFTAR NILAI UJIAN PESERTA DIDIK - SMART-CBT');
        $sheet->setCellValue('A2', 'Mata Pelajaran : ' . $topik->modul_nama . ' - ' . $topik->clean_nama);
        $sheet->setCellValue('A3', 'Kelas / Rombel : ' . $kelas_data['grup_nama']);
        $sheet->setCellValue('A4', 'Ringkasan      : Total ' . $kelas_data['total_siswa'] . ' Siswa | Sudah Ujian: ' . $kelas_data['sudah_ujian'] . ' | Belum Ujian: ' . $kelas_data['belum_ujian'] . ' | Rata-rata: ' . $kelas_data['rata_rata']);

        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(13);
        $sheet->getStyle('A2:A4')->getFont()->setBold(true)->setSize(10);

        // Header Tabel (Baris 6)
        $headers = array(
            'A' => 'No.',
            'B' => 'Username / NIS',
            'C' => 'Nama Lengkap Peserta Didik',
            'D' => 'Kelas',
            'E' => 'Ruang / Sesi',
            'F' => 'Waktu Mulai Ujian',
            'G' => 'Jml Soal',
            'H' => 'Jml Benar',
            'I' => 'Jml Salah',
            'J' => 'Nilai (Skala 100)',
            'K' => 'Status Kehadiran Ujian'
        );

        foreach($headers as $col => $text){
            $cell = $col . '6';
            $sheet->setCellValue($cell, $text);
            $sheet->getStyle($cell)->getFont()->setBold(true)->getColor()->setRGB('FFFFFF');
            $sheet->getStyle($cell)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('1E3C72');
            $sheet->getStyle($cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        }

        // Isi Data Siswa (Urut Abjad A-Z)
        $row = 7;
        $no = 1;
        foreach($kelas_data['siswa_list'] as $s){
            $sheet->setCellValue('A'.$row, $no++);
            $sheet->setCellValueExplicit('B'.$row, (string)$s['username'], PHPExcel_Cell_DataType::TYPE_STRING);
            $sheet->setCellValue('C'.$row, $s['nama']);
            $sheet->setCellValue('D'.$row, $s['kelas']);
            $sheet->setCellValue('E'.$row, $s['ruang']);
            $sheet->setCellValue('F'.$row, $s['waktu_mulai']);
            $sheet->setCellValue('G'.$row, $s['jml_soal']);
            $sheet->setCellValue('H'.$row, $s['sudah_ujian'] ? $s['jml_benar'] : '-');
            $sheet->setCellValue('I'.$row, $s['sudah_ujian'] ? $s['jml_salah'] : '-');
            if($s['sudah_ujian']){
                $sheet->setCellValue('J'.$row, $s['nilai']);
            }else{
                $sheet->setCellValue('J'.$row, '');
            }
            $sheet->setCellValue('K'.$row, $s['status']);

            // Highlight kuning/merah lembut jika siswa BELUM UJIAN agar guru langsung tahu siapa yang harus susulan
            if(!$s['sudah_ujian']){
                $sheet->getStyle('A'.$row.':K'.$row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('FFF3CD');
                $sheet->getStyle('K'.$row)->getFont()->setBold(true)->getColor()->setRGB('B45309');
            }else{
                $sheet->getStyle('J'.$row)->getFont()->setBold(true);
            }

            $sheet->getStyle('A'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('D'.$row.':K'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $row++;
        }

        // Border seluruh tabel
        $last_row = max(6, $row - 1);
        $border_style = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => 'CBD5E1')
                )
            )
        );
        $sheet->getStyle('A6:K'.$last_row)->applyFromArray($border_style);

        foreach(array_keys($headers) as $col){
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
    }
}
