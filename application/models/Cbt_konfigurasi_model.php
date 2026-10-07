<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cbt_konfigurasi_model extends CI_Model{
	public $table = 'cbt_konfigurasi';
	
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
	
	function get_by_kolom($kolom, $isi){
        $this->db->where($kolom, $isi)
                 ->from($this->table);
        return $this->db->get();
    }
	
	function get_by_kolom_limit($kolom, $isi, $limit){
        $this->db->where($kolom, $isi)
                 ->from($this->table)
				 ->limit($limit);
        return $this->db->get();
    }

	function get_value($kode, $default = ''){
		$query = $this->get_by_kolom_limit('konfigurasi_kode', $kode, 1);
		if($query->num_rows() > 0){
			$val = $query->row()->konfigurasi_isi;
			return ($val !== null && $val !== '') ? $val : $default;
		}
		return $default;
	}

	function set_value($kode, $isi){
		if($this->count_by_kolom('konfigurasi_kode', $kode)->row()->hasil == 0){
			$this->save(array(
				'konfigurasi_kode' => $kode,
				'konfigurasi_isi' => $isi
			));
		}else{
			$this->update('konfigurasi_kode', $kode, array('konfigurasi_isi' => $isi));
		}
	}
}