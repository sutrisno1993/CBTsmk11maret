<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * ZYA CBT
 * Modul Jadwal & Matriks Tes Harian
 */
class Tes_jadwal extends Member_Controller {
	private $kode_menu = 'tes-jadwal';
	private $kelompok = 'tes';
	private $url = 'manager/tes_jadwal';

	function __construct(){
		parent::__construct();
		$this->load->model('cbt_tes_model');
		$this->load->model('cbt_topik_model');
		$this->load->model('cbt_modul_model');
		$this->load->model('cbt_tesgrup_model');
		$this->load->model('cbt_user_grup_model');
		$this->load->model('cbt_tes_topik_set_model');
		$this->load->model('cbt_tes_user_model');
		$this->load->model('cbt_user_model');
		$this->load->model('cbt_konfigurasi_model');

		parent::cek_akses($this->kode_menu);
	}

	public function index(){
		$data['kode_menu'] = $this->kode_menu;
		$data['url'] = $this->url;

		$filter_tgl = $this->input->get('tanggal', TRUE);
		if(empty($filter_tgl)){
			$filter_tgl = 'semua';
		}
		$data['filter_tgl'] = $filter_tgl;

		// Ambil daftar tanggal unik yang memiliki tes untuk dropdown filter
		$this->db->select('DATE(tes_begin_time) as tgl_tes, COUNT(*) as jml_tes')
				 ->from('cbt_tes')
				 ->group_by('DATE(tes_begin_time)')
				 ->order_by('tgl_tes', 'ASC');
		$data['daftar_tanggal'] = $this->db->get()->result();

		// Ambil data jadwal terstruktur
		$data['jadwal_harian'] = $this->get_data_jadwal($filter_tgl);

		$this->template->display_admin($this->kelompok.'/tes_jadwal_view', 'Jadwal & Matriks Tes', $data);
	}

	public function cetak(){
		$filter_tgl = $this->input->get('tanggal', TRUE);
		if(empty($filter_tgl)){
			$filter_tgl = 'semua';
		}
		$data['filter_tgl'] = $filter_tgl;

		$query_konfig = $this->cbt_konfigurasi_model->get_by_kolom_limit('konfigurasi_kode', 'cbt_nama', 1);
		$data['cbt_nama'] = ($query_konfig->num_rows() > 0) ? $query_konfig->row()->konfigurasi_isi : 'Computer Based-Test';

		$query_ket = $this->cbt_konfigurasi_model->get_by_kolom_limit('konfigurasi_kode', 'cbt_keterangan', 1);
		$data['cbt_keterangan'] = ($query_ket->num_rows() > 0) ? $query_ket->row()->konfigurasi_isi : 'Ujian Online Berbasis Komputer';

		$data['jadwal_harian'] = $this->get_data_jadwal($filter_tgl);

		$this->load->view($this->kelompok.'/tes_jadwal_cetak_view', $data);
	}

	private function get_data_jadwal($filter_tgl = 'semua'){
		$now = date('Y-m-d H:i:s');

		$this->db->from('cbt_tes');
		if($filter_tgl != 'semua' && !empty($filter_tgl)){
			$this->db->where('DATE(tes_begin_time)', $filter_tgl);
		}
		$this->db->order_by('tes_begin_time', 'ASC');
		$query_tes = $this->db->get();

		$jadwal_per_hari = array();

		if($query_tes->num_rows() > 0){
			foreach($query_tes->result() as $tes){
				$tgl = date('Y-m-d', strtotime($tes->tes_begin_time));

				// 1. Ambil Modul dan Topik
				$this->db->select('cbt_topik.topik_nama, cbt_modul.modul_nama, cbt_tes_topik_set.tset_jumlah')
						 ->from('cbt_tes_topik_set')
						 ->join('cbt_topik', 'cbt_tes_topik_set.tset_topik_id = cbt_topik.topik_id')
						 ->join('cbt_modul', 'cbt_topik.topik_modul_id = cbt_modul.modul_id')
						 ->where('cbt_tes_topik_set.tset_tes_id', $tes->tes_id);
				$query_topik = $this->db->get();
				$daftar_mapel = array();
				if($query_topik->num_rows() > 0){
					foreach($query_topik->result() as $topik){
						$daftar_mapel[] = array(
							'modul' => $topik->modul_nama,
							'topik' => $topik->topik_nama,
							'jumlah_soal' => $topik->tset_jumlah
						);
					}
				}

				// 2. Ambil Daftar Group / Rombel
				$this->db->select('cbt_user_grup.grup_id, cbt_user_grup.grup_nama')
						 ->from('cbt_tesgrup')
						 ->join('cbt_user_grup', 'cbt_tesgrup.tstgrp_grup_id = cbt_user_grup.grup_id')
						 ->where('cbt_tesgrup.tstgrp_tes_id', $tes->tes_id)
						 ->order_by('cbt_user_grup.grup_nama', 'ASC');
				$query_grup = $this->db->get();
				$daftar_grup = array();
				$grup_ids = array();
				if($query_grup->num_rows() > 0){
					foreach($query_grup->result() as $grup){
						$daftar_grup[] = $grup->grup_nama;
						$grup_ids[] = $grup->grup_id;
					}
				}

				// 3. Hitung Total Peserta Terdaftar vs Yang Sudah Mengerjakan
				$total_target = 0;
				if(!empty($grup_ids)){
					$this->db->select('COUNT(*) as total')
							 ->from('cbt_user')
							 ->where_in('user_grup_id', $grup_ids);
					$total_target = $this->db->get()->row()->total;
				}

				$this->db->select('COUNT(*) as total_peserta, COUNT(CASE WHEN tesuser_status = 4 THEN 1 END) as total_selesai')
						 ->from('cbt_tes_user')
						 ->where('tesuser_tes_id', $tes->tes_id);
				$stat_tes = $this->db->get()->row();
				$total_ikut = ($stat_tes) ? $stat_tes->total_peserta : 0;
				$total_selesai = ($stat_tes) ? $stat_tes->total_selesai : 0;

				// 4. Tentukan Status Berjalan
				if($now < $tes->tes_begin_time){
					$status_kode = 'belum';
					$status_label = 'Belum Mulai';
					$status_badge = 'label-warning';
				} else if($now >= $tes->tes_begin_time && $now <= $tes->tes_end_time){
					$status_kode = 'berjalan';
					$status_label = 'Sedang Berlangsung';
					$status_badge = 'label-success';
				} else {
					$status_kode = 'selesai';
					$status_label = 'Selesai';
					$status_badge = 'label-default';
				}

				// Format jam
				$jam_mulai = date('H:i', strtotime($tes->tes_begin_time));
				$jam_selesai = date('H:i', strtotime($tes->tes_end_time));
				$sesi_waktu = $jam_mulai . ' - ' . $jam_selesai;

				$jadwal_per_hari[$tgl][] = array(
					'tes_id' => $tes->tes_id,
					'tes_nama' => $tes->tes_nama,
					'tes_detail' => $tes->tes_detail,
					'hari' => !empty($tes->tes_hari) ? $tes->tes_hari : null,
					'shift' => !empty($tes->tes_shift) ? $tes->tes_shift : null,
					'jam_ke' => !empty($tes->tes_jam_ke) ? $tes->tes_jam_ke : null,
					'jam_mulai' => $jam_mulai,
					'jam_selesai' => $jam_selesai,
					'sesi_waktu' => $sesi_waktu,
					'durasi' => $tes->tes_duration_time,
					'token' => $tes->tes_token,
					'mapel' => $daftar_mapel,
					'grup' => $daftar_grup,
					'total_target' => $total_target,
					'total_ikut' => $total_ikut,
					'total_selesai' => $total_selesai,
					'status_kode' => $status_kode,
					'status_label' => $status_label,
					'status_badge' => $status_badge
				);
			}
		}

		return $jadwal_per_hari;
	}
}
