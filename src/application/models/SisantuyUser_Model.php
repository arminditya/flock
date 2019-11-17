<?php
Class SisantuyUser_Model extends Ci_Model
{
	# purpose: Untuk memeriksa apakah password yang dipakai untuk login adalah password default
	function check_default_password($username,$password)
	{
		try{
			$sql = 'SELECT 
					"USERNAME",
					"PSSWD_DEFAULT",
					"PSSWD"
					FROM trx_user_password 
					WHERE "USERNAME" = ?
					AND "PSSWD" = ?
					AND "DELETED" = 0
					LIMIT 1';
			$query = $this->db->query($sql, array($username, md5($password)));
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
	
	// function purpose = Untuk update password ke database
	function update_password($username,$new_password)
	{
		try{
			$sql = "UPDATE TRX_USER_PASSWORD SET PSSWD = ? WHERE USERNAME = ? AND Deleted = 0";
			$query = $this->db->query($sql, array(md5($new_password),$username));
			
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

	/* 
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
	*/

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
			$sql = "SELECT TRX_USER_ROLE.USERNAME,TRX_ROLE_MENU.ID_MENU, MST_MENU.ICON, MST_MENU.NAMA_MENU, MST_MENU.URL
			FROM TRX_ROLE_MENU
			INNER JOIN TRX_USER_ROLE ON TRX_ROLE_MENU.ID_ROLE = TRX_USER_ROLE.ID_ROLE
			INNER JOIN MST_MENU ON TRX_ROLE_MENU.ID_MENU = MST_MENU.ID_MENU
			WHERE TRX_USER_ROLE.USERNAME = ? 
			AND TRX_USER_ROLE.DELETED = '0' 
			AND TRX_ROLE_MENU.DELETED = '0'
			AND MST_MENU.DELETED = '0'
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

	/*
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
	*/

	function page_check_authorized($username,$NamaMenu)
	{
		try{
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

			$query = $this->db->query($sql, array($username,$NamaMenu));
			
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

	/* Milik SIPADOK
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
	*/


	function getTime()
	{
		$timezone  = 7;
		return gmdate("Y/m/j H:i:s", time() + 3600*($timezone+date("I"))); 
	}

	function getUserDataFormEmail($emailkantor)
	{
		try{
			$sql = "SELECT * FROM sipadok_user 
					WHERE EmailKantor = ? AND Deleted = 0 
					";
			$query = $this->db->query($sql, array($emailkantor));
			
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
	
	# purpose: Untuk login
	function login($username,$password)
	{
		try{
			$sql = 'SELECT 
					MSUS."USERNAME",
					MSUS."NAMA",
					MSUS."EMAIL",
					MSUS."NO_HP",
					TRUP."PSSWD"
					FROM mst_user MSUS
					JOIN trx_user_password TRUP ON TRUP."USERNAME" = MSUS."USERNAME"
					WHERE MSUS."USERNAME" = ?
					AND TRUP."PSSWD" = ?
					AND MSUS."DELETED" = 0
					AND TRUP."DELETED" = 0
					ORDER BY "USERNAME" LIMIT 1';
			$query = $this->db->query($sql, array($username, md5($password)));
			
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

	function getUserDataFromUsername($username)
	{
		try{
			$sql = 'SELECT * FROM mst_user 
					WHERE "USERNAME" = ? AND "DELETED" = 0';
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

	// function purpose = Mengambil data dari user yang login
	function getUserLoginData($username)
	{
		try{
			$sql = "SELECT 
					MSUS.USERNAME,
					MSUS.NAMA,
					MSUS.EMAIL,
					MSUS.NO_HP,
					TRUR.ID_ROLE,
					MSRO.NAMA_ROLE
					FROM MST_USER MSUS
					JOIN TRX_USER_ROLE TRUR ON TRUR.USERNAME = MSUS.USERNAME
					JOIN MST_ROLE MSRO ON MSRO.ID_ROLE = TRUR.ID_ROLE
					WHERE MSUS.USERNAME = ?
					AND MSUS.DELETED = 0
					AND TRUR.DELETED = 0
					AND MSRO.DELETED = 0 
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

	function saveLogModel($KdLogLogin, $username, $email, $ipaddr)
	{
		try{
			$sql = "INSERT INTO TRX_LOG_LOGIN (ID_LOG_LOGIN, USERNAME, EMAIL, DATETIME_LOGIN, IP_LOGIN)
			values (?,?,?,NOW(),?)";
			$query = $this->db->query($sql, array($KdLogLogin, $username, $email, $ipaddr));
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
}
?>