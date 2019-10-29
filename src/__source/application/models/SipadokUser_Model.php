<?php 
Class SipadokUser_Model extends Ci_Model
{

	function check_default_password($email,$password)
	{
		try{
			$sql = "SELECT NIK,Pswd,PswdDefault,NamaUser,EmailPribadi,EmailKantor,NoHP
					FROM sipadok_user 
					WHERE EmailKantor = ? AND Pswd = ? AND deleted = 0 
					LIMIT 1";
			$query = $this->db->query($sql, array($email, md5($password)));
			
			if($query->num_rows() == 1){
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
	

	function update_password($emailkantor,$password)
	{
		try{
			$sql = "UPDATE sipadok_user SET Pswd = ? WHERE EmailKantor = ? AND Deleted = 0";
			$query = $this->db->query($sql, array(md5($password),$emailkantor));
			
			if($query){
				return $query;
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

	function check_email($emailKantor)
	{
		try{
			$sql = "select count(1) as jumlahEml from sipadok_user where EmailKantor = ? ";
			$query = $this->db->query($sql, array($emailKantor));
			
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

	function getRole()
	{
		try{
			$sql = "select KdRole,NamaRole from digi_role ";
			$query = $this->db->query($sql);
			
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


	function getRoleName($id)
	{
		try{
			$sql = "SELECT KdRole,NamaRole from sipadok_role where KdRole = ? ";
			$query = $this->db->query($sql,array($id));
			
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


	function setRole($NIK,$KdRole,$CreatedBy,$CreatedOn)
	{
		try{
			$sql = "INSERT INTO sipadok_userrole (NIK,KdRole,CreatedBy,CreatedOn) Values (?,?,?,?)";
			$query = $this->db->query($sql,array($NIK,$KdRole,$CreatedBy,$CreatedOn));
			
			if($query){
				return $query;
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

	function setUpdateRole($KdRole,$UpdatedBy,$UpdatedOn,$NIK)
	{
		try{
			$sql = "UPDATE sipadok_userrole SET KdRole = ?, UpdatedBy = ?, UpdatedOn = ? where NIK = ?";
			$query = $this->db->query($sql,array($KdRole,$UpdatedBy,$UpdatedOn,$NIK));
			
			if($query){
				return $query;
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

	function reset_password($username,$pass)
	{
		try{
			$sql = "update digi_user set Psswd = ?, Psswd_default = ? where username = ?";
			$query = $this->db->query($sql,array($pass,$pass,$username));
			
			if($query){
				return $query;
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

	function getMenu($username)
	{
		try{
			$sql = "SELECT sipadok_userrole.NIK,sipadok_rolemenu.KdMenu, sipadok_menu.Icon, sipadok_menu.NamaMenu, sipadok_menu.Url
			FROM sipadok_rolemenu
			INNER JOIN sipadok_userrole ON sipadok_rolemenu.KdRole = sipadok_userrole.KdRole
			INNER JOIN sipadok_menu ON sipadok_rolemenu.KdMenu = sipadok_menu.KdMenu
			WHERE sipadok_userrole.NIK = ? 
			AND sipadok_userrole.Deleted = '0' 
			AND sipadok_rolemenu.Deleted = '0'
			AND sipadok_menu.Deleted = '0'";

			$query = $this->db->query($sql, array($username));
			
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

	function page_check_authorized($NIK,$NamaMenu)
	{
		try{
			$sql = "SELECT NamaMenu FROM sipadok_menu sm
			WHERE NamaMenu IN (
			SELECT NamaMenu FROM sipadok_menu sm
			JOIN sipadok_rolemenu srm on sm.KdMenu = srm.KdMenu
			JOIN sipadok_role sr on srm.KdRole = sr.KdRole
			JOIN sipadok_userrole sur on sr.KdRole = sur.KdRole
			WHERE sm.Deleted = 0
			AND srm.Deleted = 0
			AND sr.Deleted = 0
			AND sur.Deleted = 0
			AND sur.NIK = ?
			AND sm.NamaMenu = ?
			)";

			$query = $this->db->query($sql, array($NIK,$NamaMenu));
			
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


	function getTime()
	{
		$timezone  = 7;
		return gmdate("Y/m/j H:i:s", time() + 3600*($timezone+date("I"))); 
	}

	function getUserDataFromUsername($username)
	{
		try{
			$sql = "SELECT * FROM MST_USER 
					WHERE USERNAME = ? AND Deleted = 0 
					";
			$query = $this->db->query($sql, array($username));
			
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
	
	function login($email,$password)
	{
		try{
			$sql = "SELECT EmailKantor,EmailPribadi,Pswd,PswdDefault,NamaUser,NIK 
					FROM sipadok_user 
					WHERE EmailKantor = ? AND Pswd = ? AND Deleted = 0 
					LIMIT 1";
			$query = $this->db->query($sql, array($email, md5($password)));
			
			if($query->num_rows() == 1){
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
?>