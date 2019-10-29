<?php 
Class User extends Ci_Model
{

	function getMagz()
	{
		try{
			$sql = "select Judul,GambarUtama,Dokumen from digi_majalah_astra where deleted = 0 order by CreatedOn desc";
	
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
	function generate_questions($KdPeserta)
	{
		try{
			$sql1 = "select QuizID FROM 
					(select QuizID from digi_game dg
					where QuizID not in 
					(select dgp.QuizID from digi_game_participants dgp where dgp.KdPeserta = ?)
					and now() BETWEEN dg.StartTime AND dg.EndTime) as HasJoin
					ORDER BY RAND() LIMIT 1;";
					
			$query1 = $this->db->query($sql1,array($KdPeserta));
			$QuizID = -1;

			if($query1->num_rows()==1)
			{
				foreach($query1->result() as $value)
				{
					$QuizID = $value->QuizID;
				}

				$sql = "select dgqp.QuizID, dgc.QuestionID, dgc.Question, 
						dgc.OptionA, dgc.OptionB, dgc.OptionC, dgc.OptionD,
						dgc.Answer,dgc.Status
						from digi_game_quiz_content dgqp
						join digi_game dg
						on dgqp.QuizID = dg.QuizID
						join digi_game_content dgc
						on dgqp.QuestionID = dgc.QuestionID
						where dg.deleted = 0
						and dg.QuizID = ?
						and now() BETWEEN dg.StartTime AND dg.EndTime
						limit 10";

				$query = $this->db->query($sql,array($QuizID));
				
				if($query)
				{
					return $query->result();
				}
				else
				{
					return "false";
				}
			}
			else
			{
				//Tidak ada quiz dalam waktu saat ini atau anda telah menyelesaikan semua quiz yang aktif
				// return false;

				$sql1 = "select QuizID from digi_game_participants dgp where dgp.KdPeserta = ? group by QuizID";
				$query1 = $this->db->query($sql1,array($KdPeserta));
				if($query1->num_rows()>=1)
				{
					return "-2";
				}else{
					return "false";
				}

			}
			// $sql = "select * from digi_game_content where deleted = 0";
			
			}
			catch(Exception $e)
			{
				 throw new Exception( 'Something really gone wrong', 0, $e);
				 log_message( 'error', $e->getMessage( ) . ' in ' . $e->getFile() . ':' . $e->getLine() );
				 return false;
			}
	}

	function deleteOldBirthdayRecord()
	{
		try{
			$sql = "delete from digi_birthday_notif_temp 
					WHERE deleted = 1 and HasSent = 1
					and CreatedOn < DATE_SUB(NOW(), INTERVAL 30 DAY)";
	
				$query = $this->db->query($sql);
				
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

	function hasSentBirthday($time,$KdBirthday)
	{
		try{
			$sql = "update digi_birthday_notif_temp set HasSent = '1', deleted = '1', HasSentOn = ?
					where KdBirthdayNotif = ?";
	
			$query = $this->db->query($sql,array($time,$KdBirthday));
				
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

	function initializeBirthday()
	{
		try{
			$sql = "insert into digi_birthday_notif_temp (KdPeserta,Age,TglLahir,Token,CreatedBy,CreatedOn)
					select p.KdPeserta,
					DATE_FORMAT(now(),'%Y')-DATE_FORMAT(p.TglLahir,'%Y') as Age,
					DATE_FORMAT(p.TglLahir,'%m/%d') as TglLahir,
					UserToken,
					'System',
					NOW()
					from digi_users_mobile dum
					join peserta p
					on dum.KdPeserta = p.KdPeserta
					where DATE_FORMAT(p.TglLahir,'%m/%d') < DATE_FORMAT(NOW(),'%m/%d')";
	
			$query = $this->db->query($sql);
			
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

	function getBirthdayContent()
	{
		try{
			$sql = "select * from digi_birthday_content where deleted = 0";
	
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

	function UpdateBirthdayContent( $notif_title, $notif_desc)
	{
		try{
			$sql = "update digi_birthday_content set NotifTitle = ?, NotifDescription = ?";

			$query = $this->db->query($sql, array( $notif_title, $notif_desc));
				
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

		function getDetailTrackingData($KdPeserta,$Dpa){
			try
           {
            $sql = "select count(KdMenuMobile) as InfoSaldo
			from digi_trackingdpamobile 
			where KdMenuMobile = 'mnInfSaldo'
			and KdPeserta = ?";

            $query = $this->db->query($sql, array($KdPeserta));
                       
				if($query)
				{
					return $query->result();

				}
				else
				{
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
		// =====================UPDATE 25 JULI 2018==================================\\
		function check_email_token($KdPeserta)
		{
			try{
				$sql = "select EmailToken from digi_users_mobile Where KdPeserta = ?";
	
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
		// =====================UPDATE 25 JULI 2018==================================\\

		function register_email_token($token,$KdPeserta)
		{
			try{
				$sql = "update digi_users_mobile set EmailToken = ? Where KdPeserta = ?";
	
				$query = $this->db->query($sql, array($token,$KdPeserta));
				
				if($query){
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
	
				// =====================UPDATE 25 JULI 2018==================================\\

	function getTargetUndangan($KdGrup){
		try{
			$sql = "select NamaGrup from digi_grupundangan where KdGrup = ?";					

			$query = $this->db->query($sql,array($KdGrup));			

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

	function getAdminEmail()
	{
		try{
			$sql = "select NamaUser,EmailKantor, EmailPribadi from digi_user 
					join digi_userrole 
					on digi_user.username = digi_userrole.username
					join digi_perusahaan 
					on digi_user.KodeMitra = digi_perusahaan.KodeMitra 
					where digi_userrole.KdRole = '1'
					and digi_perusahaan.NamaMitra Like 'Dana Pensiun Astra'";
					
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

	
function update_verification_data($unique_code,$unique_code2)
{
	try{
		//here to check if the code 	
		$sql_check = "select md5(CONCAT('091295', KdPeserta, Email )) as 'code'
					  from digi_data_verification
					  where md5(CONCAT('091295', KdPeserta, Email )) = ?";
					  
		$query_check = $this->db->query($sql_check, array($unique_code));
			foreach($query_check->result() as $row)
			{
				$value = $row->code;
				if($value == $unique_code)
				{
					//====================================================UPDATE 30 Juli 2018===========================================================\\
					$sql = "update digi_data_verification set isEmailVerified = '1' where  md5(CONCAT('091295', KdPeserta, Email )) = ?";
					$query = $this->db->query($sql, array($unique_code));
					//====================================================UPDATE 30 Juli 2018===========================================================\\
					if($query)
					{
						$sql2 = "insert INTO dapen_server_peserta (KdPeserta, NmPeserta, NIP, KdUnitUsaha, TglLahir, TglPegawai, TglPeserta, TglBerhenti, Alamat1, Alamat2, Kota, KodePos, KTPAlamat1, KTPAlamat2, KTPKota, KTPKodePos, NoTelp, NoHP, EMAIL, StatusPeserta, StatusPensiun, KdAlasan, KdAlasanBayar, PinSMS_IVR_ENC, PinSMS_IVR, TglJoinSMS_IVR, StatusSMS_IVR, PswdWEB_ENC, PswdWEB, TglJoinWEB, StatusWEB, StatusKlaim, Gaji, PhDP, NPWP, FORM2, NoKTP, DPA, AnRek, KdPensiun, NmBank, NoRek, NoHPGateway, StatusKeluarga, JenisKelamin, NoFaks, newsletter, RT, RW, Kelurahan, Kecamatan, Propinsi, KodeMstrBank)
						SELECT KdPeserta, NmPeserta, NIP, KdUnitUsaha, TglLahir, TglPegawai, TglPeserta, TglBerhenti, Alamat1, Alamat2, Kota, KodePos, KTPAlamat1, KTPAlamat2, KTPKota, KTPKodePos, NoTelp, NoHP, EMAIL, StatusPeserta, StatusPensiun, KdAlasan, KdAlasanBayar, PinSMS_IVR_ENC, PinSMS_IVR, TglJoinSMS_IVR, StatusSMS_IVR, PswdWEB_ENC, PswdWEB, TglJoinWEB, StatusWEB, StatusKlaim, Gaji, PhDP, NPWP, FORM2, NoKTP, DPA, AnRek, KdPensiun, NmBank, NoRek, NoHPGateway, StatusKeluarga, JenisKelamin, NoFaks, newsletter, RT, RW, Kelurahan, Kecamatan, Propinsi, KodeMstrBank FROM peserta 
						WHERE md5(CONCAT('091295', KdPeserta )) = ? AND NOT EXISTS (
							SELECT KdPeserta FROM dapen_server_peserta WHERE md5(CONCAT('091295', KdPeserta )) = ?
						) LIMIT 1 ";
						$query2 = $this->db->query($sql2, array($unique_code2,$unique_code2));				

						if($query2){

							$_email = "select Email from digi_data_verification WHERE md5(CONCAT('091295', KdPeserta )) = ?";
							$query3 = $this->db->query($_email, array($unique_code2));

							foreach($query3->result() as $data)
							{
								$result = $data->Email;
							}

							$sql = "update dapen_server_peserta set Email = ? where md5(CONCAT('091295', KdPeserta )) = ?";
							$query = $this->db->query($sql, array($result,$unique_code2));

							$sql = "update peserta set Email = ? where md5(CONCAT('091295', KdPeserta )) = ?";
							$query = $this->db->query($sql, array($result,$unique_code2));

							if($query)
							{
								return $query;
							}			
						}
						else
						{
							return false;
						}

					}
					else
					{
						return false;
					}
				}
				else
				{
					return false;
				}
			}
	}
	catch(Exception $e)
	{
		 throw new Exception( 'Something really gone wrong', 0, $e);
		 log_message( 'error', $e->getMessage( ) . ' in ' . $e->getFile() . ':' . $e->getLine() );
		 return false;
	}
}

	
	function insert_into_verification_data($KdPeserta,$email_token,$email,$phone_number)
	{
		try{
			$sql = "insert INTO digi_data_verification (KdPeserta, EmailToken,Email,PhoneNumber,CreatedBy,CreatedOn)
			VALUES (?,?,?,?,?,?);";
			$query = $this->db->query($sql, array($KdPeserta,$email_token,$email,$phone_number));
			
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
	
	function login($username,$password)
	{
		try{
			$sql = "select Username,Psswd,NamaUser,NIP,KodeMitra,EmailPribadi,EmailKantor 
					from digi_user 
					WHERE Username = ? AND Psswd = ? AND deleted = 0 
					LIMIT 1";
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

	function check_default_password($username,$password)
	{
		try{
			$sql = "select Username,Psswd,Psswd_default,NamaUser,NIP,KodeMitra,EmailPribadi,EmailKantor 
					from digi_user 
					WHERE Username = ? AND Psswd = ? AND deleted = 0 
					LIMIT 1";
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

	function update_password($username,$password)
	{
		try{
			$sql = "update digi_user set Psswd = ? where username = ?";
			$query = $this->db->query($sql, array(md5($password),$username));
			
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

	function getRoleFromUsername($username)
	{
		try{
			$sql = "select u.Username,u.EmailKantor, u.EmailPribadi, r.NamaRole  
					from digi_user u, digi_userrole ur ,digi_role r
					where ur.KdRole = r.KdRole 
					and ur.Username = u.Username
					and ur.deleted = '0'
					and u.Username = ? ";
					
			$query = $this->db->query($sql,array($username));
			
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
			$sql = "select KdRole,NamaRole from digi_role where KdRole = ? ";
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


	function setRole($username,$KdRole,$CreatedBy,$CreatedOn)
	{
		try{
			$sql = "insert into digi_userrole (Username,KdRole,CreatedBy,CreatedOn) Values (?,?,?,?)";
			$query = $this->db->query($sql,array($username,$KdRole,$CreatedBy,$CreatedOn));
			
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

	function setUpdateRole($KdRole,$CreatedBy,$CreatedOn,$username)
	{
		try{
			$sql = "update digi_userrole set KdRole = ?, UpdatedBy = ?, UpdatedOn = ? where username = ?";
			$query = $this->db->query($sql,array($KdRole,$CreatedBy,$CreatedOn,$username));
			
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
			$sql = "select digi_userrole.username,digi_rolemenu.KdMenu, digi_menu.IconMenu, digi_menu.NamaMenuWeb, digi_menu.UrlMenu
			FROM digi_rolemenu
			INNER JOIN digi_userrole 
			ON digi_rolemenu.KdRole = digi_userrole.KdRole
			INNER JOIN digi_menu
			ON digi_rolemenu.KdMenu = digi_menu.KdMenu
			WHERE digi_userrole.username = ? 
			AND digi_userrole.deleted = '0' 
			AND digi_rolemenu.deleted = '0'
			AND digi_menu.deleted = '0'";

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

	function page_check_authorized($username,$url)
	{
		try{
			$sql = "select digi_userrole.username
			FROM digi_rolemenu
			INNER JOIN digi_userrole 
			ON digi_rolemenu.KdRole = digi_userrole.KdRole
			INNER JOIN digi_menu
			ON digi_rolemenu.KdMenu = digi_menu.KdMenu
			WHERE digi_userrole.username = ? 
      		AND UrlMenu = ?
			AND digi_userrole.deleted = '0' 
			AND digi_rolemenu.deleted = '0'
			AND digi_menu.deleted = '0'";

			$query = $this->db->query($sql, array($username,$url));
			
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

	function register_token($KdPeserta,$token,$device_model)
	{
		try{
			$sql = "insert INTO digi_users_mobile (KdPeserta,UserToken, DeviceModel, CreatedBy, CreatedOn)
			VALUES (?,?,?, 'Firebase','".$this->getTime()."');";

			$query = $this->db->query($sql, array($KdPeserta,$token,$device_model));
			
			if($query){
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

	//function register_kdpeserta($Kdpeserta,$token)
	function register_kdpeserta($Kdpeserta,$unique_id)
	{
		try{
			// $sql = "update digi_users_mobile 
			// SET KdPeserta = ? 
			// WHERE UserToken = ? ";
			$sql = "update digi_users_mobile 
			SET KdPeserta = ? 
			WHERE KdUserMobile = ? ";

			// $query = $this->db->query($sql, array($Kdpeserta,$token));
			$query = $this->db->query($sql, array($Kdpeserta,$unique_id));
			
			if($query){
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

	function getEventNotifCount()
	{
		try{
			$sql = "select count(KdEvent) as value from digi_event where IsApproved = '0' and Deleted = '0'";
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

	function getPromoNotifCount()
	{
		try{
			$sql = "select count(KdPromosi) as value from digi_datapromosi where Status = '0' and Deleted = '0'";
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

	function getTime()
	{
		$timezone  = 7;
		return gmdate("Y/m/j H:i:s", time() + 3600*($timezone+date("I"))); 
	}
	
}
?>