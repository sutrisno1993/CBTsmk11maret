<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* ZYA CBT
* Achmad Lutfi
* achmdlutfi@gmail.com
* achmadlutfi.wordpress.com
*/
class Cbt_topik_model extends CI_Model{
	public $table = 'cbt_topik';
	
	function __construct(){
		parent::__construct();
		// Auto migration kolom topik_tipe ('panitia' / 'uh') dan topik_user_id jika belum ada
		if(!$this->db->field_exists('topik_tipe', $this->table)){
			$this->load->dbforge();
			$fields = array(
				'topik_tipe' => array(
					'type' => 'VARCHAR',
					'constraint' => '20',
					'default' => 'panitia',
					'null' => FALSE
				),
				'topik_user_id' => array(
					'type' => 'INT',
					'constraint' => 11,
					'default' => 0,
					'null' => FALSE
				)
			);
			$this->dbforge->add_column($this->table, $fields);
		}
	}
	
    function save($data){
        $this->db->insert($this->table, $data);
    }
    
    function delete($kolom, $isi){
        $this->db->where($kolom, $isi)
                 ->delete($this->table);
    }
    
    function update($kolom, $isi, $data){
        $this->db->where($kolom, $isi)
                 ->update($this->table, $data);
    }

    function count_all(){
        $this->db->select('COUNT(*) AS hasil')
                 ->from($this->table);
        return $this->db->get();
    }
    
    function count_by_kolom($kolom, $isi){
        $this->db->select('COUNT(*) AS hasil')
                 ->where($kolom, $isi)
                 ->from($this->table);
        return $this->db->get();
    }

    function count_by_topik_modul($topik, $modul){
        $this->db->select('COUNT(*) AS hasil')
                 ->where('(topik_modul_id='.$modul.' AND topik_nama="'.$topik.'")')
                 ->from($this->table);
        return $this->db->get();
    }
	
	function get_by_kolom($kolom, $isi){
        $this->db->where($kolom, $isi)
                 ->from($this->table);
        return $this->db->get();
    }

    function get_by_kolom_join_modul($kolom, $isi){
        $this->db->select('cbt_topik.*, cbt_modul.*')
                 ->join('cbt_modul', 'cbt_topik.topik_modul_id = cbt_modul.modul_id')
                 ->from($this->table)
                 ->where($kolom, $isi);
        return $this->db->get();
    }

    function get_all(){
        $this->db->from($this->table)
                 ->order_by('topik_id', 'ASC');
        return $this->db->get();
    }
	
	function get_by_kolom_limit($kolom, $isi, $limit){
        $this->db->where($kolom, $isi)
                 ->from($this->table)
				 ->limit($limit);
        return $this->db->get();
    }
	
	function get_datatable($start, $rows, $kolom, $isi, $modul){
		$this->db->where('('.$kolom.' LIKE "%'.$isi.'%" AND topik_modul_id='.$modul.')')
                 ->from($this->table)
				 ->order_by($kolom, 'ASC')
                 ->limit($rows, $start);
        return $this->db->get();
	}
    
    function get_datatable_count($kolom, $isi, $modul){
		$this->db->select('COUNT(*) AS hasil')
                 ->where('('.$kolom.' LIKE "%'.$isi.'%" AND topik_modul_id='.$modul.')')
                 ->from($this->table);
        return $this->db->get();
	}

	function get_by_tipe_user($topik_tipe, $user_id = null, $modul_id = null){
		$this->db->select('cbt_topik.*, cbt_modul.*')
				 ->join('cbt_modul', 'cbt_topik.topik_modul_id = cbt_modul.modul_id')
				 ->from($this->table)
				 ->where('topik_tipe', $topik_tipe);
		if(!empty($user_id)){
			$this->db->where('topik_user_id', $user_id);
		}
		if(!empty($modul_id)){
			$this->db->where('topik_modul_id', $modul_id);
		}
		$this->db->order_by('topik_nama', 'ASC');
		return $this->db->get();
	}

	function get_datatable_guru($start, $rows, $kolom, $isi, $modul, $user_id){
		$this->db->where('('.$kolom.' LIKE "%'.$isi.'%" AND topik_modul_id='.$modul.' AND topik_tipe="uh" AND topik_user_id='.$user_id.')')
                 ->from($this->table)
				 ->order_by($kolom, 'ASC')
                 ->limit($rows, $start);
        return $this->db->get();
	}
    
    function get_datatable_guru_count($kolom, $isi, $modul, $user_id){
		$this->db->select('COUNT(*) AS hasil')
                 ->where('('.$kolom.' LIKE "%'.$isi.'%" AND topik_modul_id='.$modul.' AND topik_tipe="uh" AND topik_user_id='.$user_id.')')
                 ->from($this->table);
        return $this->db->get();
	}
}