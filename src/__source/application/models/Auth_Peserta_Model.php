<?php 
Class Auth_Peserta_Model extends Ci_Model
{

	public function checkIdentityMobile($identity, $password)
	{
		if (empty($identity) || empty($password))
		{
			//$this->set_error('login_unsuccessful');
			//return FALSE;
			$auth_status = 'false';
			return $auth_status;
		}
		
		$query1 = $this->db->query("SELECT `KdPeserta` as kd_peserta, `NmPeserta`, `PswdWEB_ENC`, `PswdWEB` FROM (`peserta`) WHERE `KdPeserta` = '".$identity."' LIMIT 1");
		$query2 = $this->db->query("SELECT `KodeMitra` as kd_peserta,`NamaMitra` as NmPeserta, `PswdWEB_ENC`, `PswdWEB` FROM (`digi_perusahaan`) WHERE `KodeMitra` = '".$identity."' LIMIT 1");

		// echo $this->db->last_query();
		// die();
		$query = ($query1->num_rows()) ? $query1 : $query2;
		                  
		if ($query->num_rows() === 1)
		{
			$user = $query->row();

			// $password = $this->hash_password_db($user->id, $password);

			// if ($password === TRUE)
			//if (md5($password) == $user->PswdWEB_ENC)
			if ($password == $user->PswdWEB_ENC)
			{
				//echo 'Success';
				//return TRUE;
				$auth_status = 'true';
				return $auth_status;
			// } else if($password != $user->PswdWEB_ENC){
			// 	$auth_status = 'false';
			// 	return $auth_status;
			}
		}	
		
		// =====================UPDATE 25 JULI 2018==================================\\
		else
		{	
				try
				{
					$sql = "select EmailToken from digi_users_mobile Where KdPeserta = ?";
		
					$query = $this->db->query($sql, array($identity));
					
					if($query){

						foreach($query->result() as $token)
						{
							$email_token = $token->EmailToken;
						}

						if($email_token==$password)
						{
							$auth_status = 'true';
							return $auth_status;
						}
						else
						{
							$auth_status = 'false';
							return $auth_status;	
						}
					}
					else
					{
						return  'false';
					}
				}
				catch(Exception $e)
				{
					 throw new Exception( 'Something really gone wrong', 0, $e);
					 log_message( 'error', $e->getMessage( ) . ' in ' . $e->getFile() . ':' . $e->getLine() );
					 return 'false';
				}

			
				// $real_token = substr($password,4);
				// $payload = $client->verifyIdToken(substr($password,4));
				// if ($payload) {
				// 	//return TRUE;
				// 	$auth_status = 'true';
				// 	return $auth_status;
				// } else {
				// 	//return FALSE;	
				// 	$auth_status = 'false';
				// 	return $auth_status;			
				// }
		}
		// else
		// {
		// 	$auth_status = 'false';
		// 	return $auth_status;
		// }

		//Hash something anyway, just to take up time
		//$this->hash_password($password);
		//$this->set_error('login_unsuccessful');

		//return FALSE;

				// =====================UPDATE 25 JULI 2018==================================\\
	
	
		}
	
	public function checkIdentityMobileGoogle($UserToken){
		try{
			$sql = "select KdPeserta FROM digi_users_mobile
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

	public function getPwd($KdPeserta, $UserToken){
		try{
			$sql = "select PswdWEB_ENC as PwdEnc, PswdWEB as Pwd FROM peserta p
			join
			digi_users_mobile dum on dum.KdPeserta = p.KdPeserta
			where 
			p.KdPeserta = ?
			and
			dum.UserToken = ?";

			$query = $this->db->query($sql, array($KdPeserta, $UserToken));
			
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

	public function getPwdEnc($KdPeserta, $UserToken){
		try{
			$sql = "select PswdWEB_ENC as PwdEnc FROM peserta p
			join
			digi_users_mobile dum on dum.KdPeserta = p.KdPeserta
			where 
			p.KdPeserta = ?
			and
			dum.UserToken = ?";

			$query = $this->db->query($sql, array($KdPeserta, $UserToken));
			
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

	public function getPwdNonEnc($KdPeserta, $UserToken){
		try{
			$sql = "select PswdWEB as Pwd FROM peserta p
			join
			digi_users_mobile dum on dum.KdPeserta = p.KdPeserta
			where 
			p.KdPeserta = ?
			and
			dum.UserToken = ?";

			$query = $this->db->query($sql, array($KdPeserta, $UserToken));
			
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


	//----------- AUTH FOR MITRA KHUSUS ----------//
	public function getSecretCode($KdPesertaPromosi){
		try{
			$sql = "select dpp.KdPesertaPromosi, dpp.CreatedBy, dp.SecretCode FROM digi_pesertapromosi dpp
			join digi_user du on du.Username = dpp.CreatedBy
			join digi_perusahaan dp on dp.KodeMitra = du.KodeMitra
			where dpp.KdPesertaPromosi = ?";

			$query = $this->db->query($sql, array($KdPesertaPromosi));
			
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
?>