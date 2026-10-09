<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Users_model extends CI_Model{	
    function save($data){
        $this->db->insert('user', $data);
    }
    
    function delete($username){
        $this->db->where('username', $username)
                 ->delete('user');
    }
    
    function update($data, $username){
        $this->db->where('username', $username)
                 ->update('user', $data);
    }
    
    function get_user_by_id($id){
        $this->db->where('id', $id)
                 ->from('user')
                 ->limit(1);
        return $this->db->get();
    }

    function get_user_by_username($username){
        $this->db->where('username', $username)
                 ->from('user')
                 ->limit(1);
        return $this->db->get();
    }
	
	function get_login_info($username){
		$this->db->where('username',$username);
		$this->db->limit(1);
		$query = $this->db->get('user');
		return ($query->num_rows() > 0) ? $query->row() : FALSE;
	}
    
    /**
     * Change Password
     * 
     */ 
    function change_password($username, $password){
        $this->db->where('username', $username);
        $this->db->update('user', array('password' => sha1($password)));
	}
    
    function get_user_count($username, $password){
        $this->db->where('username', $username)
                 ->where('password', sha1($password))
                 ->from('user');
        return $this->db->count_all_results();	
	}
    
    function get_user_count_by_level($level){
        $this->db->select('COUNT(*) AS hasil')
                 ->where('level', $level)
                 ->from('user');
        return $this->db->get();
    }

    function init_guru_role(){
        $cek_level = $this->db->where('level', 'guru')->get('user_level');
        if($cek_level->num_rows() == 0){
            $this->db->insert('user_level', array(
                'level' => 'guru',
                'keterangan' => 'Guru Mata Pelajaran'
            ));
        }

        // Daftarkan kode_menu 'guru-ulangan' ke tabel user_menu terlebih dahulu
        // agar tidak terkena Foreign Key Constraint Error 1452 pada user_akses
        $cek_menu = $this->db->where('kode_menu', 'guru-ulangan')->get('user_menu');
        if($cek_menu->num_rows() == 0){
            $this->db->insert('user_menu', array(
                'tipe' => 1,
                'parent' => 'tes',
                'kode_menu' => 'guru-ulangan',
                'nama_menu' => 'Ulangan Harian',
                'url' => 'manager/guru_ulangan',
                'icon' => 'fa fa-pencil-square-o',
                'urutan' => 0
            ));
        }

        // Reset akses untuk level guru agar menu tersinkronisasi
        $this->db->where('level', 'guru')->delete('user_akses');

        // Hak akses guru
        $guru_menus = array(
            'guru-ulangan',
            'tes-qr-akses',
            'modul-topik',
            'modul-daftar',
            'modul-soal',
            'modul-import-word',
            'tes-tambah',
            'tes-daftar',
            'tes-token',
            'tes-evaluasi',
            'tes-hasil'
        );

        foreach($guru_menus as $menu){
            $this->db->insert('user_akses', array(
                'level' => 'guru',
                'kode_menu' => $menu,
                'add' => 1,
                'edit' => 1
            ));
        }
    }
    
    /*
	 * mendapatkan hak akses suatu menu
	 */
	function cek_akses($kode_menu, $level){
        if($kode_menu == 'tes-qr-akses'){
            $cek_m = $this->db->where('kode_menu', 'tes-qr-akses')->get('user_menu');
            if($cek_m->num_rows() == 0){
                $this->db->insert('user_menu', array(
                    'tipe' => 1,
                    'parent' => 'tes',
                    'kode_menu' => 'tes-qr-akses',
                    'nama_menu' => 'QR Akses Siswa (Data Mandiri)',
                    'url' => 'manager/tes_qr_akses',
                    'icon' => 'fa fa-qrcode',
                    'urutan' => 6
                ));
            }
            $cek_a = $this->db->where('level', $level)->where('kode_menu', 'tes-qr-akses')->get('user_akses');
            if($cek_a->num_rows() == 0){
                $this->db->insert('user_akses', array(
                    'level' => $level,
                    'kode_menu' => 'tes-qr-akses',
                    'add' => 1,
                    'edit' => 1
                ));
            }
            return 1;
        }

        if($kode_menu == 'modul-mapel' || $kode_menu == 'modul'){
            $cek_m = $this->db->where('kode_menu', 'modul-mapel')->get('user_menu');
            if($cek_m->num_rows() == 0){
                $this->db->insert('user_menu', array(
                    'tipe' => 1,
                    'parent' => 'modul',
                    'kode_menu' => 'modul-mapel',
                    'nama_menu' => 'Mata Pelajaran (Modul)',
                    'url' => 'manager/modul_mapel',
                    'icon' => 'fa fa-book',
                    'urutan' => 0
                ));
            }
            if($level == 'admin'){
                $cek_a = $this->db->where('level', 'admin')->where('kode_menu', 'modul-mapel')->get('user_akses');
                if($cek_a->num_rows() == 0){
                    $this->db->insert('user_akses', array(
                        'level' => 'admin',
                        'kode_menu' => 'modul-mapel',
                        'add' => 1,
                        'edit' => 1
                    ));
                }
            }
        }

        if($level == 'guru'){
            // Pastikan jika menu baru ditambahkan, role guru otomatis tersinkron
            $cek = $this->db->where('level', 'guru')->where('kode_menu', 'tes-qr-akses')->get('user_akses');
            if($cek->num_rows() == 0){
                $this->init_guru_role();
            }
        }
		$sql='SELECT COUNT(*) AS hasil FROM user_akses WHERE user_akses.kode_menu="'.$kode_menu.'" AND user_akses.level="'.$level.'"';
		$hasil=$this->db->query($sql)->row()->hasil;

		return $hasil;
	}
    
    /*
	 * mendapatkan hak akses crud menu
	 */
	function cek_akses_crud($kode_menu, $level, $tipe){
        if($tipe==0){
            $sql='SELECT COUNT(*) AS hasil FROM user_akses WHERE user_akses.kode_menu="'.$kode_menu.'" AND user_akses.level="'.$level.'" AND user_akses.add=1';
        }else{
            $sql='SELECT COUNT(*) AS hasil FROM user_akses WHERE user_akses.kode_menu="'.$kode_menu.'" AND user_akses.level="'.$level.'" AND user_akses.edit=1';
        }
		$hasil=$this->db->query($sql)->row()->hasil;

		return $hasil;
	}
    
    function get_all_user($start, $rows, $search){
        $this->db->where('(username LIKE "%'.$search.'%" OR nama LIKE "%'.$search.'%")')
                 ->where('username !=','admin')
                 ->from('user')
                 ->limit($rows, $start);    
        
        return $this->db->get();
    }
    
    function get_all_user_count($search){
        $this->db->select('COUNT(*) AS hasil')
                 ->like('user.username', $search)
                 ->or_like('user.nama', $search)
                 ->where('user.username !=','admin')
                 ->from('user');
        return $this->db->get();
    }
    
    function get_parent_menu($child_menu){
        $sql = 'SELECT `user_menu`.`parent` FROM user_menu WHERE `user_menu`.`kode_menu`="'.$child_menu.'"';
        $query = $this->db->query($sql);
        if($query->num_rows()>0){
            $hasil = $query->row()->parent;
        }else{
            $hasil = 'KOSONG';
        }
        return $hasil;
        
    }
    
    function get_menu_detail($kode_menu){
        $sql = 'SELECT `user_menu`.* FROM user_menu WHERE `user_menu`.`kode_menu`="'.$kode_menu.'" LIMIT 1';
        return $this->db->query($sql);
    }
    
    /**
     * Mendapatkan menu dashboard secara dynamic 
     */ 
    function get_menu($kode_menu, $level){
        // Tampilan navigasi khusus Guru yang SUPER SEDERHANA (Hanya Menu Utama yang Jelas)
        if($level == 'guru'){
            $dash_active = ($kode_menu == 'dashboard' || $kode_menu == 'KOSONG') ? 'active' : '';
            $bank_soal_active = ($kode_menu == 'modul-daftar' && $this->uri->segment(3) != 'panitia') || $kode_menu == 'modul-soal' || $kode_menu == 'modul-import-word' || $kode_menu == 'modul-topik' ? 'active' : '';
            $uh_active = ($kode_menu == 'guru-ulangan' || $kode_menu == 'tes-tambah' || $kode_menu == 'tes-daftar' || $kode_menu == 'tes-token') ? 'active' : '';
            $panitia_active = ($kode_menu == 'modul-daftar' && $this->uri->segment(3) == 'panitia') ? 'active' : '';
            $qr_active = ($kode_menu == 'tes-qr-akses') ? 'active' : '';
            $hasil_active = ($kode_menu == 'tes-hasil' || $kode_menu == 'tes-evaluasi') ? 'active' : '';

            $menu = '
                <li class="header" style="color: #b8c7ce; font-size: 11px; text-transform: uppercase; padding: 12px 15px 6px 15px; letter-spacing: 0.5px;">PORTAL GURU & PENGAWAS</li>
                <li class="'.$dash_active.'">
                    <a href="'.site_url('manager/dashboard').'">
                        <i class="fa fa-dashboard text-aqua"></i> <span>Dashboard Utama</span>
                    </a>
                </li>
                <li class="'.$qr_active.'">
                    <a href="'.site_url('manager/tes_qr_akses').'">
                        <i class="fa fa-qrcode text-purple"></i> <span>QR Akses Kuota Siswa</span>
                    </a>
                </li>
                <li class="'.$bank_soal_active.'">
                    <a href="'.site_url('manager/modul_daftar').'">
                        <i class="fa fa-book text-green"></i> <span>Bank Soal UH (Buat / Upload)</span>
                    </a>
                </li>
                <li class="'.$uh_active.'">
                    <a href="'.site_url('manager/guru_ulangan').'">
                        <i class="fa fa-play-circle text-orange"></i> <span>Jalankan Ulangan Harian</span>
                    </a>
                </li>
                <li class="'.$panitia_active.'">
                    <a href="'.site_url('manager/modul_daftar/index/panitia').'">
                        <i class="fa fa-eye text-yellow"></i> <span>Preview Soal Panitia (SAS)</span>
                    </a>
                </li>
                <li class="'.$hasil_active.'">
                    <a href="'.site_url('manager/tes_hasil').'">
                        <i class="fa fa-bar-chart text-red"></i> <span>Hasil & Export Excel</span>
                    </a>
                </li>
            ';
            return $menu;
        }

        $this->db->select('user_menu.parent')
                 ->where('(user_akses.level="'.$level.'")')
				 ->join('user_menu', 'user_akses.kode_menu = user_menu.kode_menu')
                 ->from('user_akses')
				 ->group_by('user_menu.parent');
		$result = $this->db->get()->result();
		
		// mendapatkan array menu
		$data_menu = array();
		foreach($result as $temp){
			$data_menu[] = $temp->parent;
		}
		
		$this->db->where_in('kode_menu', $data_menu)
                 ->from('user_menu')
				 ->order_by('urutan', 'ASC');
		$result = $this->db->get();
        $parent_kode_menu = $this->get_parent_menu($kode_menu);
        
        $menu = '';
        
        if($result->num_rows()>0){
			// mencari menu berdasarkan menu parent yang didapat
            foreach ($result->result() as $temp){
                $parent_active='';
                if($temp->kode_menu==$parent_kode_menu){
					$parent_active=' active ';
    			}
                
                $sql_child = 'SELECT user_menu.* FROM `user_akses` INNER JOIN `user_level` ON (`user_akses`.`level` = `user_level`.`level`) 
                    INNER JOIN `user_menu` ON (`user_akses`.`kode_menu` = `user_menu`.`kode_menu`) WHERE user_akses.`level`="'.$level.'" 
                    AND user_menu.`tipe`=1 AND user_menu.parent="'.$temp->kode_menu.'" ORDER BY user_menu.`urutan` ASC';
                $result_child = $this->db->query($sql_child);
                
                $menu_child = '';
                $menu_child_count = 0;
                if($result_child->num_rows()>0){
                    $menu_child = $menu_child.'<ul class="treeview-menu">';
                    foreach ($result_child->result() as $child){
                        $child_active='';
                        if($kode_menu==$child->kode_menu){
                            $child_active='active';
                        }
                        $menu_child = $menu_child.'
                            <li class="'.$child_active.'"><a href="'.site_url().'/'.$child->url.'"><i class="fa fa-circle-o"></i> '.$child->nama_menu.'</a></li>
                        ';
                        
                        $menu_child_count++;
                    }
                    $menu_child = $menu_child.'</ul>';
                }
                
                $menu = $menu.'
                    <li class="treeview '.$parent_active.'">
                        <a href="'.site_url().'/'.$temp->url.'">
        					<i class="'.$temp->icon.'"></i>
        					<span>'.$temp->nama_menu.'</span>';
                if($menu_child_count>0){
                    $menu = $menu.'<i class="fa fa-angle-left pull-right"></i>';
                }
                
                $menu = $menu.'</a>';
                
                $menu = $menu.'
                    '.$menu_child;
                
                $menu = $menu.'</li>';
            }
        }
        
        return $menu;
    }
}