<?php 
Class Sisantuy_General_Model extends Ci_Model
{
    # purpose: untuk mendapatkan ID_MENU
    function find_id_menu($namamenu)
	{
		try{
			$sql = 'SELECT 
					"ID_MENU"
					FROM mst_menu 
					WHERE "NAMA_MENU" = ?
					AND "DELETED" = 0
					ORDER BY "ID_MENU" DESC';
			$query = $this->db->query($sql, array($namamenu));
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
    
    # purpose: untuk update data menu
    function update_menu($id_menu,$nama_menu,$icon,$url,$updatedby)
	{
		try{
			$sql = 'UPDATE mst_menu
                    SET 
                    "NAMA_MENU" = ?, 
                    "ICON" = ?,
                    "URL" = ?,
                    "UPDATED_BY" = ?,
                    "UPDATED_ON" = NOW()
                    WHERE "ID_MENU" = ?
                    AND "DELETED" = 0';
			$query = $this->db->query($sql, array($nama_menu, $icon, $url, $updatedby, $id_menu));
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
    
    // function purpose = mencari ID_POTONGAN_HARGA berdasarkan ID_TOUR_PACKAGE
    function find_id_potongan($id_tour_package)
	{
		try{
			$sql = "SELECT 
					ID_POTONGAN_HARGA
					FROM trx_potongan_harga 
					WHERE ID_TOUR_PACKAGE = ?
					AND DELETED = 0
					ORDER BY ID_POTONGAN_HARGA DESC
					";
			$query = $this->db->query($sql, array($id_tour_package));
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

	// function purpose = mencari ID_TOUR_HARGA berdasarkan ID_TOUR_PACKAGE
    function find_id_tour_harga($id_tour_package)
	{
		try{
			$sql = "SELECT 
					ID_TOUR_HARGA
					FROM trx_tour_harga 
					WHERE ID_TOUR_PACKAGE = ?
					AND DELETED = 0
					ORDER BY ID_TOUR_HARGA DESC
					";
			$query = $this->db->query($sql, array($id_tour_package));
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
	
	// function purpose = insert data harga paket ke trx_tour_harga
    function insert_harga_tour($idtourharga,$idtourpackage,$idmatauang,$hargapaket,$ppn,$adminfee,$createdby)
	{
		try{
			$sql = "INSERT INTO trx_tour_harga
					(ID_TOUR_HARGA, ID_TOUR_PACKAGE, ID_MATA_UANG, HARGA_PAKET, PPN, BIAYA_SISANTUY, CREATED_BY, CREATED_ON)
					VALUES
					(?,?,?,?,?,?,?,NOW())
					";
			$query = $this->db->query($sql, array($idtourharga,$idtourpackage,$idmatauang,$hargapaket,$ppn,$adminfee,$createdby));
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
	
	// function purpose = mencari besaran fee berdasarkan jenis fee
    function find_fee($jenisfee)
	{
		try{
			$sql = "SELECT 
					JENIS_FEE,
					NAMA_FEE,
					PERSENTASE
					FROM mst_fee 
					WHERE JENIS_FEE = ?
					AND DELETED = 0
					";
			$query = $this->db->query($sql, array($jenisfee));
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

	// function purpose = delete discount
    function delete_discount($idpotonganharga,$updatedby)
	{
		try{
			$sql = "UPDATE trx_potongan_harga
					SET 
					DELETED = 1, 
					STATUS = 0,
					UPDATED_BY = ?,
					UPDATED_ON = NOW()
					WHERE ID_POTONGAN_HARGA=?
					";
			$query = $this->db->query($sql, array($updatedby,$idpotonganharga));
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

	// function purpose = delete tour harga
    function delete_tour_harga($idtourharga,$updatedby)
	{
		try{
			$sql = "UPDATE trx_tour_harga
					SET 
					DELETED = 1,
					UPDATED_BY = ?,
					UPDATED_ON = NOW()
					WHERE ID_TOUR_HARGA = ?
					";
			$query = $this->db->query($sql, array($updatedby,$idtourharga));
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

	// function purpose = delete discount
    function delete_discount_by_idtour($idtourpackage,$updatedby)
	{
		try{
			$sql = "UPDATE trx_potongan_harga
					SET 
					DELETED = 1, 
					STATUS = 0,
					UPDATED_BY = ?,
					UPDATED_ON = NOW()
					WHERE ID_TOUR_PACKAGE=?
					";
			$query = $this->db->query($sql, array($updatedby,$idtourpackage));
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

	// function purpose = delete tour harga
    function delete_tour_harga_by_idtour($idtourpackage,$updatedby)
	{
		try{
			$sql = "UPDATE trx_tour_harga
					SET 
					DELETED = 1,
					UPDATED_BY = ?,
					UPDATED_ON = NOW()
					WHERE ID_TOUR_PACKAGE = ?
					";
			$query = $this->db->query($sql, array($updatedby,$idtourpackage));
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