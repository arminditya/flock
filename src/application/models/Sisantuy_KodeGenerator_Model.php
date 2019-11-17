<?php
Class Sisantuy_KodeGenerator_Model extends CI_Model
{

function insert($data){
    $this->db->insert($data);
}
function update($data){
    $this->db->update($data);
}

//Untuk counter KdPromosi
function getKdPromosi(){
    // $this->db->select('KdPromosi');
    // $this->db->from('digi_datapromosi');
    $result = $this->db->query("SELECT KdPromosi FROM digi_datapromosi ORDER BY KdPromosi DESC LIMIT 1");
    // $result = $this->db->get();
    $getDateNow = date('ymd');
    $kd="";
    if($result->num_rows()>0)
    {
            foreach($result->result() as $kd)
            {
                
                // echo "kode".$kd->KdPromosi;
                $splitVar_start = substr($kd->KdPromosi,0,6);
                // echo "splitVar_start = ".$splitVar_start;
                $splitVar_end = substr($kd->KdPromosi,6,14);
                // echo "splitVar_end = ".$splitVar_end;
                
                if($getDateNow == $splitVar_start)
                {
                    $tmp = ((int)$splitVar_end)+1;
                    $count = str_pad($tmp,9,"0",STR_PAD_LEFT);
                    $kd = "$splitVar_start"."$count";
                    // echo "jika tanggal sekarang sama".$kd;
                    
                    
                }
                else
                {
                    $kd = "$getDateNow"."000000001";
                    // echo "jika tanggal sekarang beda".$kd;
                    
                }
            }    
    }
    else
    {
        $kd = "$getDateNow"."000000001";
        // echo "jika tidak ada record".$kd;
        
    }
    return $kd;    
}

// function purpose = Mengambil id log login
function getKdLoginLog(){
    $result = $this->db->query("SELECT ID_LOG_LOGIN FROM TRX_LOG_LOGIN ORDER BY ID_LOG_LOGIN DESC LIMIT 1");
    $getDateNow = date('ymd');
    $kd="";
    if($result->num_rows()>0)
    {
            foreach($result->result() as $kd)
            {
                $splitVar_start = substr($kd->ID_LOG_LOGIN,0,6);
                $splitVar_end = substr($kd->ID_LOG_LOGIN,6,14);
                
                if($getDateNow == $splitVar_start)
                {
                    $tmp = ((int)$splitVar_end)+1;
                    $count = str_pad($tmp,9,"0",STR_PAD_LEFT);
                    $kd = "$splitVar_start"."$count";
                }
                else
                {
                    $kd = "$getDateNow"."000000001";
                }
            }    
    }
    else
    {
        $kd = "$getDateNow"."000000001";
    }
    return $kd;    
}

// function purpose = Mengambil id user role
function getIdUserRole(){
    $result = $this->db->query("SELECT ID_USER_ROLE FROM TRX_USER_ROLE ORDER BY ID_USER_ROLE DESC LIMIT 1");
    $getDateNow = date('ymd');
    $kd="";
    if($result->num_rows()>0)
    {
            foreach($result->result() as $kd)
            {
                $splitVar_start = substr($kd->ID_USER_ROLE,0,6);
                $splitVar_end = substr($kd->ID_USER_ROLE,6,14);
                
                if($getDateNow == $splitVar_start)
                {
                    $tmp = ((int)$splitVar_end)+1;
                    $count = str_pad($tmp,9,"0",STR_PAD_LEFT);
                    $kd = "$splitVar_start"."$count";
                }
                else
                {
                    $kd = "$getDateNow"."000000001";
                }
            }    
    }
    else
    {
        $kd = "$getDateNow"."000000001";
    }
    return $kd;    
}

// function purpose = membuat ID_TOUR_HARGA
function getIdTourHarga(){
    $result = $this->db->query("SELECT ID_TOUR_HARGA FROM trx_tour_harga ORDER BY ID_TOUR_HARGA DESC LIMIT 1");
    $getDateNow = date('ymd');
    $kd="";
    if($result->num_rows()>0)
    {
            foreach($result->result() as $kd)
            {
                $splitVar_start = substr($kd->ID_TOUR_HARGA,0,6);
                $splitVar_end = substr($kd->ID_TOUR_HARGA,6,14);
                
                if($getDateNow == $splitVar_start)
                {
                    $tmp = ((int)$splitVar_end)+1;
                    $count = str_pad($tmp,9,"0",STR_PAD_LEFT);
                    $kd = "$splitVar_start"."$count";
                }
                else
                {
                    $kd = "$getDateNow"."000000001";
                }
            }    
    }
    else
    {
        $kd = "$getDateNow"."000000001";
    }
    return $kd;    
}

// function purpose = membuat ID_TOUR_PACKAGE
function getIdTourPackage(){
    $result = $this->db->query("SELECT ID_TOUR_PACKAGE FROM mst_tour_package ORDER BY ID_TOUR_PACKAGE DESC LIMIT 1");
    $getDateNow = date('ymd');
    $kd="";
    if($result->num_rows()>0)
    {
            foreach($result->result() as $kd)
            {
                $splitVar_start = substr($kd->ID_TOUR_PACKAGE,0,6);
                $splitVar_end = substr($kd->ID_TOUR_PACKAGE,6,14);
                
                if($getDateNow == $splitVar_start)
                {
                    $tmp = ((int)$splitVar_end)+1;
                    $count = str_pad($tmp,9,"0",STR_PAD_LEFT);
                    $kd = "$splitVar_start"."$count";
                }
                else
                {
                    $kd = "$getDateNow"."000000001";
                }
            }    
    }
    else
    {
        $kd = "$getDateNow"."000000001";
    }
    return $kd;    
}

// function purpose = membuat ID_POTONGAN_HARGA
function getIdPotonganHarga(){
    $result = $this->db->query("SELECT ID_POTONGAN_HARGA FROM trx_potongan_harga ORDER BY ID_POTONGAN_HARGA DESC LIMIT 1");
    $getDateNow = date('ymd');
    $kd="";
    if($result->num_rows()>0)
    {
            foreach($result->result() as $kd)
            {
                $splitVar_start = substr($kd->ID_POTONGAN_HARGA,0,6);
                $splitVar_end = substr($kd->ID_POTONGAN_HARGA,6,14);
                
                if($getDateNow == $splitVar_start)
                {
                    $tmp = ((int)$splitVar_end)+1;
                    $count = str_pad($tmp,9,"0",STR_PAD_LEFT);
                    $kd = "$splitVar_start"."$count";
                }
                else
                {
                    $kd = "$getDateNow"."000000001";
                }
            }    
    }
    else
    {
        $kd = "$getDateNow"."000000001";
    }
    return $kd;    
}


}