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

	/**
	 * Menghasilkan token dinamis per 1 jam
	 * @param int $hour_offset (0 = jam ini, -1 = jam sebelumnya, 1 = jam berikutnya)
	 * @return string token 10 karakter
	 */
	function get_qr_token($hour_offset = 0){
		$salt = $this->get_value('cbt_qr_secret_salt', 'ZYACBT_SMK11MARET_SECURE_QR_SALT_2026');
		$time_slot = date('Y-m-d-H', strtotime($hour_offset.' hour'));
		return substr(md5($salt . '_' . $time_slot), 0, 10);
	}

	/**
	 * Validasi token QR siswa (mendukung grace period toleransi jam sebelumnya/berikutnya)
	 * @param string $token
	 * @return bool
	 */
	function is_valid_qr_token($token){
		if(empty($token)) return false;
		$token = trim($token);
		$current = $this->get_qr_token(0);
		$prev = $this->get_qr_token(-1);
		$next = $this->get_qr_token(1);
		return ($token === $current || $token === $prev || $token === $next);
	}

	/**
	 * Mendapatkan sisa detik masa berlaku token QR jam berjalan
	 * @return int detik
	 */
	function get_qr_expires_in(){
		$now = time();
		$end_of_hour = strtotime(date('Y-m-d H:00:00', strtotime('+1 hour')));
		return max(0, $end_of_hour - $now);
	}
}