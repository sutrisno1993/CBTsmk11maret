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
	 * Menghasilkan token dinamis per 12 jam (Shift 00:00 - 12:00 dan 12:00 - 24:00)
	 * @param int $slot_offset (0 = slot 12-jam ini, -1 = slot sebelumnya, 1 = slot berikutnya)
	 * @return string token 10 karakter
	 */
	function get_qr_token($slot_offset = 0){
		$salt = $this->get_value('cbt_qr_secret_salt', 'ZYACBT_SMK11MARET_SECURE_QR_SALT_2026');
		$current_time = time() + ($slot_offset * 43200);
		$slot_hour = (intval(date('H', $current_time)) < 12) ? '00' : '12';
		$time_slot = date('Y-m-d-', $current_time) . $slot_hour;
		return substr(md5($salt . '_' . $time_slot), 0, 10);
	}

	/**
	 * Validasi token QR siswa (mendukung toleransi slot sebelumnya & berikutnya)
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
	 * Mendapatkan sisa detik masa berlaku token QR slot 12-jam berjalan
	 * @return int detik
	 */
	function get_qr_expires_in(){
		$now = time();
		$hour = intval(date('H'));
		if($hour < 12){
			$end_of_slot = strtotime(date('Y-m-d 12:00:00'));
		}else{
			$end_of_slot = strtotime(date('Y-m-d 00:00:00', strtotime('+1 day')));
		}
		return max(0, $end_of_slot - $now);
	}

	/**
	 * Mendapatkan waktu berakhir slot 12-jam berjalan dalam string jam WIB
	 * @return string
	 */
	function get_qr_valid_until(){
		$hour = intval(date('H'));
		if($hour < 12){
			return '12:00:00 WIB (Siang)';
		}else{
			return '24:00:00 WIB (Malam)';
		}
	}

	/**
	 * Cek apakah IP client termasuk jaringan lokal/WiFi sekolah (Bypass)
	 */
	function check_ip_bypass($client_ip, $ip_bypass_str = null){
		if($ip_bypass_str === null){
			$ip_bypass_str = $this->get_value('cbt_sekolah_ip_bypass', '192.168., 10., 172.16., 127.0.0.1');
		}
		if(empty($ip_bypass_str) || empty($client_ip)){
			return false;
		}
		$list = explode(',', $ip_bypass_str);
		foreach($list as $ip_entry){
			$ip_entry = trim($ip_entry);
			if(!empty($ip_entry)){
				if(strpos($client_ip, $ip_entry) === 0 || $client_ip === $ip_entry){
					return true;
				}
			}
		}
		return false;
	}
}