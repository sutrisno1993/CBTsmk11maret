<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cbt_soal_koreksi_model extends CI_Model {
    public $table_koreksi = 'cbt_soal_koreksi';
    public $table_verifikasi = 'cbt_topik_verifikasi';

    function __construct(){
        parent::__construct();
        $this->check_tables();
    }

    private function check_tables(){
        // Auto create table cbt_soal_koreksi
        if(!$this->db->table_exists($this->table_koreksi)){
            $sql = "CREATE TABLE IF NOT EXISTS `".$this->table_koreksi."` (
                `koreksi_id` INT(11) NOT NULL AUTO_INCREMENT,
                `koreksi_topik_id` INT(11) NOT NULL,
                `koreksi_soal_id` INT(11) NOT NULL,
                `koreksi_guru_nama` VARCHAR(150) NOT NULL,
                `koreksi_catatan` TEXT NOT NULL,
                `koreksi_status` VARCHAR(20) NOT NULL DEFAULT 'pending',
                `koreksi_created_at` DATETIME NOT NULL,
                `koreksi_updated_at` DATETIME DEFAULT NULL,
                PRIMARY KEY (`koreksi_id`),
                KEY `idx_topik` (`koreksi_topik_id`),
                KEY `idx_soal` (`koreksi_soal_id`),
                KEY `idx_status` (`koreksi_status`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
            $this->db->query($sql);
        }

        // Auto create table cbt_topik_verifikasi
        if(!$this->db->table_exists($this->table_verifikasi)){
            $sql = "CREATE TABLE IF NOT EXISTS `".$this->table_verifikasi."` (
                `verifikasi_id` INT(11) NOT NULL AUTO_INCREMENT,
                `verifikasi_topik_id` INT(11) NOT NULL,
                `verifikasi_guru_nama` VARCHAR(150) NOT NULL,
                `verifikasi_guru_nip` VARCHAR(50) DEFAULT NULL,
                `verifikasi_status` VARCHAR(20) NOT NULL DEFAULT 'sesuai',
                `verifikasi_catatan` TEXT DEFAULT NULL,
                `verifikasi_ttd` TEXT DEFAULT NULL,
                `verifikasi_created_at` DATETIME NOT NULL,
                `verifikasi_updated_at` DATETIME DEFAULT NULL,
                PRIMARY KEY (`verifikasi_id`),
                UNIQUE KEY `uk_topik` (`verifikasi_topik_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
            $this->db->query($sql);
        }
    }

    // --- KOREKSI SOAL ---

    function simpan_koreksi($data){
        $data['koreksi_created_at'] = date('Y-m-d H:i:s');
        return $this->db->insert($this->table_koreksi, $data);
    }

    function get_koreksi_by_topik($topik_id){
        return $this->db->where('koreksi_topik_id', $topik_id)
                        ->order_by('koreksi_created_at', 'DESC')
                        ->get($this->table_koreksi);
    }

    function get_koreksi_by_soal($soal_id){
        return $this->db->where('koreksi_soal_id', $soal_id)
                        ->order_by('koreksi_created_at', 'DESC')
                        ->get($this->table_koreksi);
    }

    function get_pending_koreksi($limit = 10){
        $this->db->select('k.*, t.topik_nama, m.modul_nama, s.soal_detail, s.soal_tipe');
        $this->db->from($this->table_koreksi.' k');
        $this->db->join('cbt_topik t', 'k.koreksi_topik_id = t.topik_id', 'left');
        $this->db->join('cbt_modul m', 't.topik_modul_id = m.modul_id', 'left');
        $this->db->join('cbt_soal s', 'k.koreksi_soal_id = s.soal_id', 'left');
        $this->db->where('k.koreksi_status', 'pending');
        $this->db->order_by('k.koreksi_created_at', 'DESC');
        if($limit > 0){
            $this->db->limit($limit);
        }
        return $this->db->get();
    }

    function get_all_koreksi_with_detail(){
        $this->db->select('k.*, t.topik_nama, m.modul_nama, s.soal_detail, s.soal_tipe');
        $this->db->from($this->table_koreksi.' k');
        $this->db->join('cbt_topik t', 'k.koreksi_topik_id = t.topik_id', 'left');
        $this->db->join('cbt_modul m', 't.topik_modul_id = m.modul_id', 'left');
        $this->db->join('cbt_soal s', 'k.koreksi_soal_id = s.soal_id', 'left');
        $this->db->order_by('k.koreksi_status', 'ASC'); // pending first
        $this->db->order_by('k.koreksi_created_at', 'DESC');
        return $this->db->get();
    }

    function count_pending_koreksi(){
        return $this->db->where('koreksi_status', 'pending')->count_all_results($this->table_koreksi);
    }

    function count_koreksi_by_topik($topik_id, $status = null){
        $this->db->where('koreksi_topik_id', $topik_id);
        if(!empty($status)){
            $this->db->where('koreksi_status', $status);
        }
        return $this->db->count_all_results($this->table_koreksi);
    }

    function update_status_koreksi($koreksi_id, $status){
        return $this->db->where('koreksi_id', $koreksi_id)
                        ->update($this->table_koreksi, array(
                            'koreksi_status' => $status,
                            'koreksi_updated_at' => date('Y-m-d H:i:s')
                        ));
    }

    function delete_koreksi($koreksi_id){
        return $this->db->where('koreksi_id', $koreksi_id)->delete($this->table_koreksi);
    }

    // --- VERIFIKASI / TTD TOPIK ---

    function simpan_verifikasi($topik_id, $data){
        $cek = $this->db->where('verifikasi_topik_id', $topik_id)->get($this->table_verifikasi);
        if($cek->num_rows() > 0){
            $data['verifikasi_updated_at'] = date('Y-m-d H:i:s');
            return $this->db->where('verifikasi_topik_id', $topik_id)->update($this->table_verifikasi, $data);
        } else {
            $data['verifikasi_topik_id'] = $topik_id;
            $data['verifikasi_created_at'] = date('Y-m-d H:i:s');
            return $this->db->insert($this->table_verifikasi, $data);
        }
    }

    function get_verifikasi_by_topik($topik_id){
        return $this->db->where('verifikasi_topik_id', $topik_id)->get($this->table_verifikasi);
    }

    function get_all_verifikasi(){
        $this->db->select('v.*, t.topik_nama, m.modul_nama');
        $this->db->from($this->table_verifikasi.' v');
        $this->db->join('cbt_topik t', 'v.verifikasi_topik_id = t.topik_id', 'left');
        $this->db->join('cbt_modul m', 't.topik_modul_id = m.modul_id', 'left');
        $this->db->order_by('v.verifikasi_created_at', 'DESC');
        return $this->db->get();
    }

    function count_verified_topik(){
        return $this->db->where('verifikasi_status', 'sesuai')->count_all_results($this->table_verifikasi);
    }
}
