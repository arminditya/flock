<?php 
Class Logout_Model extends Ci_Model
{

	//Fungsi untuk update KdPeserta menjadi null saat logout
	function getKdUserMobile($UserToken)
	{
		try{
			$sql = "select KdUserMobile FROM digi_users_mobile
			where UserToken = ?";

			$query = $this->db->query($sql, array($UserToken));
			
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

	//Fungsi untuk update KdPeserta menjadi null saat logout
	function updateKdPeserta($KdUserMobile)
	{
		try{
			$sql = "update digi_users_mobile
			set KdPeserta = null
			where KdUserMobile = ?";

			$query = $this->db->query($sql, array($KdUserMobile));
			
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