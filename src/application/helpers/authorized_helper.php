<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Fungsi untuk mengecek apakah user berhak atas page tertentu.
 *
 *
 * @author William <william.djong@gmail.com>
 *
 * @param int $kodeMenu - KodeMenu yang dilakukan pengecekan
 * @return true false
 */
 
 if (!function_exists('check_authorized'))
{
	function check_authorized_add_participans($KdMenu) {
		try{
			$ci=& get_instance();
			$ci->load->model('user','',TRUE);
			$session_data = $ci->session->userdata('logged_in');
			$username = $session_data['username'];

			$sql = "select KdGrup from digi_grupundangan where CreatedBy = ? AND KdGrup = ? ";

			$query = $ci->db->query($sql, array($username, $KdMenu));
			
			if($query){
				return $query->result();
			}else{
				return false;
			}
		}
		catch(Exception $e)
		{
		 throw new Exception( 'Something really gone wrong', 0, $e);
		 log_message( 'error', $e->getMessage( ) . ' in ' . $e->getFile() . ':' . $e->getLine() );
		 return false;
		}
	}
	
	function check_authorizedByName($MenuName)
	{
		try{
			$ci=& get_instance();
			$ci->load->model('user','',TRUE);
			$session_data = $ci->session->userdata('logged_in');
			if($session_data['koderole'] != "1"){
				$MenuNameAccess = $ci->user->getMenuNameAccess();
				if(!in_array($MenuName,$MenuNameAccess))
				{
					redirect('notauthorized','refresh');					
				}
			}
			
			return true;
		}
		catch(Exception $e)
		{
		 throw new Exception( 'Something really gone wrong', 0, $e);
		 log_message( 'error', $e->getMessage( ) . ' in ' . $e->getFile() . ':' . $e->getLine() );
		 return false;
		}
	}

	function page_check_authorized($NamaMenu)
	{
		try{
			$ci=& get_instance();
			// $ci->load->model('user','',TRUE);
			$ci->load->model('SisantuyUser_Model','',TRUE);
			$session_data = $ci->session->userdata('logged_in');
			$username = $session_data['username'];
			
			$sql = "SELECT NAMA_MENU FROM MST_MENU sm
			WHERE NAMA_MENU IN (
				SELECT NAMA_MENU FROM MST_MENU sm
				JOIN TRX_ROLE_MENU srm on sm.ID_MENU = srm.ID_MENU
				JOIN MST_ROLE sr on srm.ID_ROLE = sr.ID_ROLE
				JOIN TRX_USER_ROLE sur on sr.ID_ROLE = sur.ID_ROLE
				WHERE sm.DELETED = 0
				AND srm.DELETED = 0
				AND sr.DELETED = 0
				AND sur.DELETED = 0
				AND sur.USERNAME = ?
				AND sm.NAMA_MENU = ?
			)";

			$query = $ci->db->query($sql, array($username,$NamaMenu));
			
			if($query){
				return $query->result();
			}else{
				return false;
			}
		}
		catch(Exception $e)
		{
			 throw new Exception( 'Something really gone wrong', 0, $e);
			 log_message( 'error', $e->getMessage( ) . ' in ' . $e->getFile() . ':' . $e->getLine() );
			 return false;
		}
	}
}