<?php 
Class SipadokLogLogin_Model extends Ci_Model
{

	function saveLogModel($KdLogLogin, $NIK, $NamaUser, $EmailKantor, $ipaddr, $login_time)
	{
		try{
			$sql = "INSERT INTO sipadok_log_login (KdLogLogin, NIK, NamaUser, EmailKantor, IpAddr, LoginTime)
			values (?,?,?,?,?,?)";
			$query = $this->db->query($sql, array($KdLogLogin, $NIK, $NamaUser, $EmailKantor, $ipaddr, $login_time));
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