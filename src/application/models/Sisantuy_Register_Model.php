<?php 
Class Sisantuy_Register_Model extends Ci_Model
{

	//--- begin - create user ---//
	function createUser($KdPeserta)
	{
		try{
			$sql = "SELECT NmPeserta FROM peserta WHERE KdPeserta = ?";
			$query = $this->db->query($sql, array($KdPeserta));
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
	//--- end - create user ---//

	function checkUsernameExist($username)
	{
		try{
			$sql = "SELECT USERNAME FROM MST_USER WHERE USERNAME = ?";
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

	// function purpose = Menambahkan user
	function insertUser(
		$username,
		$nama,
		$jenis_kelamin,
		$no_hp,
		$email,
		$tgl_lahir,
		$created_by
		)
	{
		try{
			$sql = "INSERT INTO MST_USER
			(USERNAME, NAMA, JENIS_KELAMIN, NO_HP, EMAIL, TGL_LAHIR, CREATED_BY, CREATED_ON)
			VALUES
			(?, ?, ?, ?, ?, ?, ?, NOW()) ";
			$query = $this->db->query($sql, array(
				$username,
				$nama,
				$jenis_kelamin,
				$no_hp,
				$email,
				$tgl_lahir,
				$created_by
			));
			if($query){
				// return $query->result();
				return true;
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

	// function purpose = Menambahkan password pengguna
	function insertUserPassword(
		$username,
		$psswd_default,
		$psswd,
		$created_by
		)
	{
		try{
			$sql = "INSERT INTO TRX_USER_PASSWORD
			(USERNAME, PSSWD_DEFAULT, PSSWD, CREATED_BY, CREATED_ON)
			VALUES
			(?, md5(?), md5(?), ?, NOW()) ";
			$query = $this->db->query($sql, array(
				$username,
				$psswd_default,
				$psswd,
				$created_by
			));
			if($query){
				// return $query->result();
				return true;
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