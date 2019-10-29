<?php
Class SipadokKode_Model extends CI_Model
{

function insert($data){
    $this->db->insert($data);
}
function update($data){
    $this->db->update($data);
}

//Untuk counter KdLogLogin
function getKdLoginLog(){
    // $this->db->select('KdPromosi');
    // $this->db->from('digi_datapromosi');
    $result = $this->db->query("SELECT KdLogLogin FROM sipadok_log_login ORDER BY KdLogLogin DESC LIMIT 1");
    // $result = $this->db->get();
    $getDateNow = date('ymd');
    $kd="";
    if($result->num_rows()>0)
    {
            foreach($result->result() as $kd)
            {
                // echo "kode".$kd->KdPromosi;
                $splitVar_start = substr($kd->KdLogLogin,0,6);
                // echo "splitVar_start = ".$splitVar_start;
                $splitVar_end = substr($kd->KdLogLogin,6,14);
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

//Untuk counter KdDataPadok
function getKdDataPadok(){
    // $this->db->select('KdPromosi');
    // $this->db->from('digi_datapromosi');
    $result = $this->db->query("SELECT KdDataPadok FROM sipadok_datapadok ORDER BY KdDataPadok DESC LIMIT 1");
    // $result = $this->db->get();
    $getDateNow = date('ymd');
    $kd="";
    if($result->num_rows()>0)
    {
            foreach($result->result() as $kd)
            {
                $splitVar_start = substr($kd->KdDataPadok,0,6);
                $splitVar_end = substr($kd->KdDataPadok,6,14);
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

//Untuk counter KdDataPadok
function getKdTransaksiPadok(){
    $result = $this->db->query("SELECT KdTransaksiPadok FROM sipadok_transaksi_padok ORDER BY KdTransaksiPadok DESC LIMIT 1");
    // $result = $this->db->get();
    $getDateNow = date('ymd');
    $kd="";
    if($result->num_rows()>0)
    {
            foreach($result->result() as $kd)
            {
                $splitVar_start = substr($kd->KdTransaksiPadok,0,6);
                $splitVar_end = substr($kd->KdTransaksiPadok,6,14);
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


}