<?php 
Class SipadokTransaction_Model extends Ci_Model
{

	function initialInsertTransactionPadok($KdTransaksiPadok, $KdDataPadok, $Penerima, $CreatedBy)
	{
		try{
			$sql = "INSERT INTO sipadok_transaksi_padok (
					KdTransaksiPadok,
					KdDataPadok,
					Penerima,
					CreatedBy,
					CreatedOn
					)
					VALUES (?,?,?,?,NOW())";
			$query = $this->db->query($sql, array($KdTransaksiPadok, $KdDataPadok, $Penerima, $CreatedBy));
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

	function getPenerimaLama($KdDataPadok)
	{
		try{
			$sql = "SELECT * FROM sipadok_transaksi_padok WHERE Deleted = 0 AND KdDataPadok = ?";
			$query = $this->db->query($sql, array($KdDataPadok));
			
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

	function getKodeUnikPengambilan($KdTransaksiPadok)
	{
		try{
			$sql = "SELECT * FROM sipadok_transaksi_padok WHERE Deleted = 0 AND KdTransaksiPadok = ?";
			$query = $this->db->query($sql, array($KdTransaksiPadok));
			
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

	function updatePenerimaOnTransactionPadok($Penerima, $UpdatedBy, $KdTransaksiPadok, $KdDataPadok)
	{
		try{
			$sql = "UPDATE sipadok_transaksi_padok SET Penerima = ?, UpdatedBy = ?, UpdatedOn = NOW()
					WHERE Deleted = 0 AND KdTransaksiPadok = ? AND KdDataPadok = ?";
			$query = $this->db->query($sql, array($Penerima, $UpdatedBy, $KdTransaksiPadok, $KdDataPadok));
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

	function updateRequestPengambilanPadok($KdTransaksiPadok,$PengambilanStatus,$TglPengambilanReqTgl,$JamPengambilanReqTgl,$UpdatedBy, $KodeUnikPengambilan)
	{
		try{
			$sql = "UPDATE sipadok_transaksi_padok SET PengambilanStatus = ?, PengambilanReqTgl = ?, PengambilanReqTime = ?, UpdatedBy = ?, UpdatedOn = NOW(), KodeUnikPengambilan = ?
					WHERE Deleted = 0 AND KdTransaksiPadok = ?";
			$query = $this->db->query($sql, array($PengambilanStatus, $TglPengambilanReqTgl, $JamPengambilanReqTgl, $UpdatedBy, $KodeUnikPengambilan ,$KdTransaksiPadok));
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

	function updatePengambilanPadokByOA(
		$PengambilanStatus, 
		$PengambilanRealOn, 
		$DilayaniOlehOa, 
		$BktTerimaStatus,
		$BktTerimaReq,
		$UpdatedBy,
		$KdTransaksiPadok
		)
	{
		try{
			$sql = "UPDATE sipadok_transaksi_padok SET 
					PengambilanStatus = ?, 
					PengambilanRealOn = ?, 
					DilayaniOlehOa = ?, 
					BktTerimaStatus = ?,
					BktTerimaReq = ?,
					UpdatedBy = ?, 
					UpdatedOn = NOW()
					WHERE Deleted = 0 AND KdTransaksiPadok = ?";
			$query = $this->db->query($sql, array(
				$PengambilanStatus, 
				$PengambilanRealOn, 
				$DilayaniOlehOa, 
				$BktTerimaStatus,
				$BktTerimaReq,
				$UpdatedBy,
				$KdTransaksiPadok
			));
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

	function updateAcceptBuktiTerimaPadok($BktTerimaStatus, $BktTerimaOn, $UpdatedBy, $KdTransaksiPadok)
	{
		try{
			$sql = "UPDATE sipadok_transaksi_padok SET 
					BktTerimaStatus = ?,
					BktTerimaOn = ?,
					UpdatedBy = ?, 
					UpdatedOn = NOW()
					WHERE Deleted = 0 AND KdTransaksiPadok = ?";
			$query = $this->db->query($sql, array($BktTerimaStatus, $BktTerimaOn, $UpdatedBy, $KdTransaksiPadok));
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


	function getDataPadok($KdDataPadok)
	{
		try{
			$sql = "SELECT * FROM sipadok_datapadok WHERE Deleted = 0 AND KdDataPadok = ?";
			$query = $this->db->query($sql, array($KdDataPadok));
			
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

	function getDataTransaksiPadok($KdTransaksiPadok)
	{
		try{
			$sql = "SELECT * FROM mti.sipadok_transaksi_padok WHERE Deleted = 0 AND KdTransaksiPadok = ?";
			$query = $this->db->query($sql, array($KdTransaksiPadok));
			
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

	function getDataTransaksiPadokAndDataPadok($KdTransaksiPadok)
	{
		try{
			$sql = "SELECT sdp.KdDataPadok,
			sdp.TglPadokMasuk,
			sdp.Penerima,
			sdp.Pengirim,
			sdp.KdTipePadok,
			sdp.KdJasaEkspedisi,
			sdp.NamaKurir,
			sdp.NomorTelpKurir,
			sdp.KdLokasiPadok,
			stp.PengambilanStatus,
			stp.PengambilanRealOn,
			stp.BktTerimaStatus,
			stp.BktTerimaOn,
			stp.DilayaniOlehOa,
			stp.PengambilanReqTgl,
			stp.PengambilanReqTime
			FROM mti.sipadok_datapadok sdp
			JOIN mti.sipadok_transaksi_padok stp on stp.KdDataPadok = sdp.KdDataPadok
			WHERE sdp.Deleted = 0
			AND stp.Deleted = 0
			AND stp.KdTransaksiPadok = ?";
			$query = $this->db->query($sql, array($KdTransaksiPadok));
			
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

	function getNamaPenerima($NIK)
	{
		try{
			$sql = "SELECT * FROM sipadok_user WHERE Deleted = 0 AND NIK = ?";
			$query = $this->db->query($sql, array($NIK));
			
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

	function getNamaTipePadok($KdDataPadok)
	{
		try{
			$sql = "SELECT sdp.KdDataPadok, sdp.KdTipePadok, stp.KdTipePadok, stp.NamaTipePaket FROM mti.sipadok_datapadok sdp
					JOIN mti.sipadok_tipepadok stp on sdp.KdTipePadok = stp.KdTipePadok
					WHERE sdp.Deleted = 0
					AND stp.Deleted = 0
					AND sdp.KdDataPadok = ?";
			$query = $this->db->query($sql, array($KdDataPadok));
			
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

	function getNamaJasaEkspedisi($KdDataPadok)
	{
		try{
			$sql = "SELECT sdp.KdDataPadok, sdp.KdJasaEkspedisi, sje.KdJasaEkspedisi, sje.NamaJasaEkspedisi FROM mti.sipadok_datapadok sdp
			JOIN mti.sipadok_jasaekspedisi sje on sdp.KdJasaEkspedisi = sje.KdJasaEkspedisi
			WHERE sdp.Deleted = 0
			AND sje.Deleted = 0
			AND sdp.KdDataPadok = ?";
			$query = $this->db->query($sql, array($KdDataPadok));
			
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

	function getNamaLokasiPadok($KdDataPadok)
	{
		try{
			$sql = "SELECT sdp.KdDataPadok, sdp.KdLokasiPadok, sje.KdLokasiPadok, sje.NamaLokasiPadok FROM mti.sipadok_datapadok sdp
			JOIN mti.sipadok_lokasipadok sje on sdp.KdLokasiPadok = sje.KdLokasiPadok
			WHERE sdp.Deleted = 0
			AND sje.Deleted = 0
			AND sdp.KdDataPadok = ?";
			$query = $this->db->query($sql, array($KdDataPadok));
			
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