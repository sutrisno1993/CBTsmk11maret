<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller Sederhana Ulangan Harian Khusus Guru
 * Didesain ringkas, 1 halaman praktis untuk Guru yang tidak ingin ribet
 */
class Guru_ulangan extends Member_Controller {
	private $kode_menu = 'guru-ulangan';
	private $kelompok = 'guru';
	private $url = 'manager/guru_ulangan';
	
    function __construct(){
		parent:: __construct();
		$this->load->model('cbt_modul_model');
		$this->load->model('cbt_topik_model');
		$this->load->model('cbt_soal_model');
		$this->load->model('cbt_tes_model');
        $this->load->model('cbt_tes_user_model');
		$this->load->model('cbt_tesgrup_model');
		$this->load->model('cbt_user_grup_model');
		$this->load->model('cbt_tes_topik_set_model');
		$this->load->model('cbt_tes_token_model');
		$this->load->model('cbt_konfigurasi_model');

        // Auto migration kolom tes_user_id di cbt_tes jika belum ada
        if(!$this->db->field_exists('tes_user_id', 'cbt_tes')){
            $this->load->dbforge();
            $fields = array(
                'tes_user_id' => array(
                    'type' => 'INT',
                    'constraint' => 11,
                    'default' => 0,
                    'null' => FALSE
                )
            );
            $this->dbforge->add_column('cbt_tes', $fields);
        }

        // Pastikan konfigurasi default tersimpan jika belum ada
        if($this->cbt_konfigurasi_model->count_by_kolom('konfigurasi_kode', 'cbt_tipe_soal_global')->row()->hasil == 0){
            $this->cbt_konfigurasi_model->save(array(
                'konfigurasi_kode' => 'cbt_tipe_soal_global',
                'konfigurasi_isi' => 'pilihan_ganda'
            ));
        }
        if($this->cbt_konfigurasi_model->count_by_kolom('konfigurasi_kode', 'cbt_use_token')->row()->hasil == 0){
            $this->cbt_konfigurasi_model->save(array(
                'konfigurasi_kode' => 'cbt_use_token',
                'konfigurasi_isi' => 'tidak'
            ));
        }

        // Sinkronisasi: Semua ulangan harian tidak memakai token dulu
        $this->db->where('tes_user_id >', 0)->update('cbt_tes', array('tes_token' => 0));

        parent::cek_akses($this->kode_menu);
	}
	
    public function index(){
        $data['kode_menu'] = $this->kode_menu;
        $data['url'] = $this->url;

        $user_login = $this->users_model->get_user_by_username($this->access->get_username())->row();
        $uid = !empty($user_login->id) ? $user_login->id : 0;
        $data['user'] = $user_login;

        // Ambil status konfigurasi global
        $q_tipe = $this->cbt_konfigurasi_model->get_by_kolom_limit('konfigurasi_kode', 'cbt_tipe_soal_global', 1);
        $data['tipe_global'] = ($q_tipe->num_rows() > 0) ? $q_tipe->row()->konfigurasi_isi : 'pilihan_ganda';

        $q_token = $this->cbt_konfigurasi_model->get_by_kolom_limit('konfigurasi_kode', 'cbt_use_token', 1);
        $data['use_token'] = ($q_token->num_rows() > 0) ? $q_token->row()->konfigurasi_isi : 'tidak';

        // 1. Ambil daftar kelas/grup siswa
        $data['daftar_kelas'] = $this->cbt_user_grup_model->get_group()->result();

        // 2. Ambil topik Ulangan Harian milik guru ini saja (tanpa soal panitia)
        $data['daftar_topik'] = $this->cbt_topik_model->get_by_tipe_user('uh', $uid)->result();

        // 3. Ambil daftar ulangan harian yang pernah dibuat guru ini
        $this->db->select('cbt_tes.*, cbt_tes_token.token_isi')
                 ->from('cbt_tes')
                 ->join('cbt_tes_token', 'cbt_tes_token.token_tes_id = cbt_tes.tes_id', 'left')
                 ->where('cbt_tes.tes_user_id', $uid)
                 ->order_by('cbt_tes.tes_id', 'DESC');
        $query_tes = $this->db->get();

        $daftar_ulangan = array();
        if($query_tes->num_rows() > 0){
            foreach($query_tes->result() as $t){
                // Ambil nama kelas/grup yang mengikuti tes ini
                $kelas_list = array();
                $q_grup = $this->cbt_tesgrup_model->get_by_kolom('tstgrp_tes_id', $t->tes_id);
                if($q_grup->num_rows() > 0){
                    foreach($q_grup->result() as $g){
                        $q_nama_grup = $this->cbt_user_grup_model->get_by_kolom('grup_id', $g->tstgrp_grup_id);
                        if($q_nama_grup->num_rows() > 0){
                            $kelas_list[] = $q_nama_grup->row()->grup_nama;
                        }
                    }
                }

                // Ambil jumlah peserta yang sudah mengerjakan tes ini
                $jml_peserta = $this->cbt_tes_user_model->count_by_kolom('tesuser_tes_id', $t->tes_id)->row()->hasil;

                // Status apakah tes masih aktif (waktu sekarang berada di antara begin dan end time)
                $now = date('Y-m-d H:i:s');
                $is_aktif = ($now >= $t->tes_begin_time && $now <= $t->tes_end_time) ? 1 : 0;

                // Ambil topik yang digunakan pada tes ini
                $topik_nama = '-';
                $topik_id = 0;
                $tipe_soal_label = 'Pilihan Ganda';
                $q_tset = $this->cbt_tes_topik_set_model->get_by_kolom('tset_tes_id', $t->tes_id);
                if($q_tset->num_rows() > 0){
                    $tset = $q_tset->row();
                    $topik_id = $tset->tset_topik_id;
                    if($tset->tset_tipe == 2){
                        $tipe_soal_label = 'Essay';
                    } else if($tset->tset_tipe == 0){
                        $tipe_soal_label = 'Campuran';
                    }
                    $q_topik = $this->cbt_topik_model->get_by_kolom('topik_id', $topik_id);
                    if($q_topik->num_rows() > 0){
                        $topik_nama = $q_topik->row()->topik_nama;
                    }
                }

                $daftar_ulangan[] = array(
                    'tes' => $t,
                    'kelas' => implode(', ', $kelas_list),
                    'jml_peserta' => $jml_peserta,
                    'is_aktif' => $is_aktif,
                    'topik_nama' => $topik_nama,
                    'topik_id' => $topik_id,
                    'tipe_soal' => $tipe_soal_label
                );
            }
        }
        $data['daftar_ulangan'] = $daftar_ulangan;

        $this->template->display_admin('guru/guru_ulangan_view', 'Jalankan Ulangan Harian', $data);
    }

    /**
     * Membuat & Menjalankan Ulangan Harian dalam 1 Kali Klik (Super Sederhana)
     */
    public function mulai_ulangan(){
        $this->load->library('form_validation');

        $this->form_validation->set_rules('nama_ulangan', 'Nama Ulangan', 'required|strip_tags');
        $this->form_validation->set_rules('kelas[]', 'Pilihan Kelas', 'required');
        $this->form_validation->set_rules('durasi', 'Durasi Ujian', 'required|integer');

        if($this->form_validation->run() == TRUE){
            $user_login = $this->users_model->get_user_by_username($this->access->get_username())->row();
            $uid = !empty($user_login->id) ? $user_login->id : 0;

            $nama_ulangan = $this->input->post('nama_ulangan', true);
            $kelas_pilihan = $this->input->post('kelas', true);
            $durasi = intval($this->input->post('durasi', true));
            if($durasi <= 0) { $durasi = 60; }

            $sumber_soal = $this->input->post('sumber_soal', true);
            $topik_id = 0;

            if($sumber_soal == 'pilih'){
                $topik_id = intval($this->input->post('topik_id', true));
            } else {
                // Buat topik baru otomatis dengan nama yang sama dengan nama ulangan
                $nama_topik = !empty($this->input->post('nama_topik_baru', true)) ? $this->input->post('nama_topik_baru', true) : $nama_ulangan;
                $data_topik = array(
                    'topik_modul_id' => 9, // Modul default
                    'topik_nama' => $nama_topik,
                    'topik_detail' => 'Topik Ulangan Harian: '.$nama_ulangan,
                    'topik_aktif' => 1,
                    'topik_tipe' => 'uh',
                    'topik_user_id' => $uid
                );
                $this->cbt_topik_model->save($data_topik);
                $topik_id = $this->db->insert_id();
            }

            // Ambil pengaturan tipe soal global
            $tipe_global = 'pilihan_ganda';
            $q_tipe = $this->cbt_konfigurasi_model->get_by_kolom_limit('konfigurasi_kode', 'cbt_tipe_soal_global', 1);
            if($q_tipe->num_rows() > 0){
                $tipe_global = $q_tipe->row()->konfigurasi_isi;
            }

            // Tentukan tipe soal untuk ulangan:
            // 1 = Pilihan Ganda (Default), 2 = Essay, 0 = Campuran
            $tset_tipe = 1;
            if($tipe_global == 'essay'){
                $tset_tipe = 2;
            } else if($tipe_global == 'campuran'){
                $tset_tipe = 0;
            }

            // Pengaturan token global (Ulangan harian tidak pakai token dulu)
            $tes_token_flag = 0;
            $q_token = $this->cbt_konfigurasi_model->get_by_kolom_limit('konfigurasi_kode', 'cbt_use_token', 1);
            if($q_token->num_rows() > 0 && $q_token->row()->konfigurasi_isi == 'ya'){
                $tes_token_flag = 1;
            }

            // 1. Simpan Data Tes di cbt_tes
            $data_tes = array(
                'tes_nama' => $nama_ulangan,
                'tes_detail' => 'Ulangan Harian Mandiri Guru',
                'tes_begin_time' => date('Y-m-d H:i:s'),
                'tes_end_time' => date('Y-m-d 23:59:59', strtotime('+1 days')),
                'tes_duration_time' => $durasi,
                'tes_ip_range' => '*.*.*.*',
                'tes_results_to_users' => 1,
                'tes_detail_to_users' => 1,
                'tes_score_right' => 1.00,
                'tes_score_wrong' => 0.00,
                'tes_score_unanswered' => 0.00,
                'tes_max_score' => 100.00,
                'tes_token' => $tes_token_flag,
                'tes_user_id' => $uid
            );
            $tes_id = $this->cbt_tes_model->save($data_tes);

            // 2. Hubungkan Kelas yang Dipilih di cbt_tesgrup
            if(!empty($kelas_pilihan)){
                foreach($kelas_pilihan as $gid){
                    $this->cbt_tesgrup_model->save(array(
                        'tstgrp_tes_id' => $tes_id,
                        'tstgrp_grup_id' => $gid
                    ));
                }
            }

            // 3. Pasang Soal Topik di cbt_tes_topik_set
            // Sesuai permintaan user: "soal ulangan semuanya pilihan ganda gaada essay yaa"
            // Hitung hanya soal yang sesuai dengan tipe yang dipilih (Pilihan Ganda Saja, Essay Saja, atau Campuran)
            if($tset_tipe == 1){
                $jml_soal_tersedia = $this->db->where('soal_topik_id', $topik_id)->where('soal_tipe', 1)->from('cbt_soal')->count_all_results();
            } else if($tset_tipe == 2){
                $jml_soal_tersedia = $this->db->where('soal_topik_id', $topik_id)->where('soal_tipe', 2)->from('cbt_soal')->count_all_results();
            } else {
                $jml_soal_tersedia = $this->db->where('soal_topik_id', $topik_id)->from('cbt_soal')->count_all_results();
            }

            $data_tset = array(
                'tset_tes_id' => $tes_id,
                'tset_topik_id' => $topik_id,
                'tset_tipe' => $tset_tipe,
                'tset_difficulty' => 1,
                'tset_jumlah' => ($jml_soal_tersedia > 0) ? $jml_soal_tersedia : 1,
                'tset_jawaban' => 5,
                'tset_acak_soal' => 1,
                'tset_acak_jawaban' => 1
            );
            $this->cbt_tes_topik_set_model->save($data_tset);

            $token_baru = '-';
            if($tes_token_flag == 1){
                $token_karakter = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
                $token_baru = '';
                for ($i = 0; $i < 6; $i++) {
                    $token_baru .= $token_karakter[rand(0, strlen($token_karakter) - 1)];
                }

                $this->db->where('token_tes_id', $tes_id)->delete('cbt_tes_token');
                $this->db->insert('cbt_tes_token', array(
                    'token_isi' => $token_baru,
                    'token_user_id' => $uid,
                    'token_aktif' => 1,
                    'token_tes_id' => $tes_id,
                    'token_ts' => date('Y-m-d H:i:s')
                ));
            }

            $respon = array(
                'status' => 1,
                'pesan' => 'Ulangan Harian berhasil dimulai! (Mode Bebas Token: Siswa dapat langsung login dan klik Mulai Ujian)',
                'use_token' => $tes_token_flag,
                'token' => $token_baru,
                'tipe_soal' => ($tset_tipe == 1) ? 'Pilihan Ganda' : (($tset_tipe == 2) ? 'Essay' : 'Campuran'),
                'tes_id' => $tes_id,
                'topik_id' => $topik_id,
                'jml_soal' => $jml_soal_tersedia
            );
        } else {
            $respon = array(
                'status' => 0,
                'pesan' => validation_errors()
            );
        }

        echo json_encode($respon);
    }

    /**
     * Selesaikan / Tutup Ulangan Harian
     */
    public function tutup_ulangan($tes_id=null){
        if(!empty($tes_id)){
            $user_login = $this->users_model->get_user_by_username($this->access->get_username())->row();
            $uid = !empty($user_login->id) ? $user_login->id : 0;

            // Pastikan hanya pemilik tes yang bisa menutup
            $data_update = array(
                'tes_end_time' => date('Y-m-d H:i:s', strtotime('-1 minute'))
            );
            $this->db->where('tes_id', $tes_id);
            if($this->session->userdata('cbt_level') == 'guru'){
                $this->db->where('tes_user_id', $uid);
            }
            $this->db->update('cbt_tes', $data_update);
        }
        redirect($this->url);
    }

    /**
     * Aktifkan Kembali Ulangan Harian
     */
    public function aktifkan_ulangan($tes_id=null){
        if(!empty($tes_id)){
            $user_login = $this->users_model->get_user_by_username($this->access->get_username())->row();
            $uid = !empty($user_login->id) ? $user_login->id : 0;

            $data_update = array(
                'tes_begin_time' => date('Y-m-d H:i:s'),
                'tes_end_time' => date('Y-m-d 23:59:59', strtotime('+1 days'))
            );
            $this->db->where('tes_id', $tes_id);
            if($this->session->userdata('cbt_level') == 'guru'){
                $this->db->where('tes_user_id', $uid);
            }
            $this->db->update('cbt_tes', $data_update);
        }
        redirect($this->url);
    }

    /**
     * Buat Token Baru untuk Ulangan Tertentu
     */
    public function refresh_token($tes_id=null){
        $respon = array('status' => 0, 'pesan' => 'Gagal membuat token baru.');
        if(!empty($tes_id)){
            $user_login = $this->users_model->get_user_by_username($this->access->get_username())->row();
            $uid = !empty($user_login->id) ? $user_login->id : 0;

            $token_karakter = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
            $token_baru = '';
            for ($i = 0; $i < 6; $i++) {
                $token_baru .= $token_karakter[rand(0, strlen($token_karakter) - 1)];
            }

            $this->db->where('token_tes_id', $tes_id)->delete('cbt_tes_token');
            $this->db->insert('cbt_tes_token', array(
                'token_isi' => $token_baru,
                'token_user_id' => $uid,
                'token_aktif' => 1,
                'token_tes_id' => $tes_id,
                'token_ts' => date('Y-m-d H:i:s')
            ));

            $respon = array(
                'status' => 1,
                'token' => $token_baru,
                'pesan' => 'Token berhasil diperbarui!'
            );
        }
        echo json_encode($respon);
    }
}
