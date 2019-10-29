<?php
Class Kode_Model extends CI_Model
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

//Untuk counter KdPesertaPromosi
function getKdPesertaPromosi(){
    // $this->db->select('KdPromosi');
    // $this->db->from('digi_datapromosi');
    $result = $this->db->query("SELECT KdPesertaPromosi FROM digi_pesertapromosi ORDER BY KdPesertaPromosi DESC LIMIT 1");
    // $result = $this->db->get();
    $getDateNow = date('ymd');
    $kd="";
    if($result->num_rows()>0)
    {
            foreach($result->result() as $kd)
            {
                
                // echo "kode".$kd->KdPromosi;
                $splitVar_start = substr($kd->KdPesertaPromosi,0,6);
                // echo "splitVar_start = ".$splitVar_start;
                $splitVar_end = substr($kd->KdPesertaPromosi,6,14);
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

//Untuk counter KdTracking
function getKdTracking(){
    // $this->db->select('KdPromosi');
    // $this->db->from('digi_datapromosi');
    $result = $this->db->query("SELECT KdTracking FROM digi_trackingdpamobile ORDER BY KdTracking DESC LIMIT 1");
    // $result = $this->db->get();
    $getDateNow = date('ymd');
    $kd="";
    if($result->num_rows()>0)
    {
            foreach($result->result() as $kd)
            {
                
                // echo "kode".$kd->KdPromosi;
                $splitVar_start = substr($kd->KdTracking,0,6);
                // echo "splitVar_start = ".$splitVar_start;
                $splitVar_end = substr($kd->KdTracking,6,14);
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

//Untuk counter KdTrackingLogin
function getKdTrackingLogin(){
    // $this->db->from('digi_datapromosi');
    $result = $this->db->query("SELECT KdTrackingLogin FROM digi_trackingdpamobile_login ORDER BY KdTrackingLogin DESC LIMIT 1");
    // $result = $this->db->get();
    $getDateNow = date('ymd');
    $kd="";
    if($result->num_rows()>0)
    {
            foreach($result->result() as $kd)
            {
                
                // echo "kode".$kd->KdPromosi;
                $splitVar_start = substr($kd->KdTrackingLogin,0,6);
                // echo "splitVar_start = ".$splitVar_start;
                $splitVar_end = substr($kd->KdTrackingLogin,6,14);
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

//Untuk counter KdLogPromosi
function getKdLogPromosi(){
    // $this->db->from('digi_datapromosi');
    $result = $this->db->query("SELECT KdLogPromosi FROM digi_logpromosi ORDER BY KdLogPromosi DESC LIMIT 1");
    // $result = $this->db->get();
    $getDateNow = date('ymd');
    $kd="";
    if($result->num_rows()>0)
    {
            foreach($result->result() as $kd)
            {
                
                // echo "kode".$kd->KdPromosi;
                $splitVar_start = substr($kd->KdLogPromosi,0,6);
                // echo "splitVar_start = ".$splitVar_start;
                $splitVar_end = substr($kd->KdLogPromosi,6,14);
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

//Untuk counter KdPesertaPromosi
function getKdApprovalPromosi(){
    // $this->db->select('KdPromosi');
    // $this->db->from('digi_datapromosi');
    $result = $this->db->query("SELECT KdApprovalPromosi FROM digi_approvalpromosi ORDER BY KdApprovalPromosi DESC LIMIT 1");
    // $result = $this->db->get();
    $getDateNow = date('ymd');
    $kd="";
    if($result->num_rows()>0)
    {
            foreach($result->result() as $kd)
            {
                
                // echo "kode".$kd->KdPromosi;
                $splitVar_start = substr($kd->KdApprovalPromosi,0,6);
                // echo "splitVar_start = ".$splitVar_start;
                $splitVar_end = substr($kd->KdApprovalPromosi,6,14);
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

//Untuk counter KdLogLogin
function getKdLoginLog(){
    // $this->db->select('KdPromosi');
    // $this->db->from('digi_datapromosi');
    $result = $this->db->query("SELECT KdLoginLog FROM digi_loginlog ORDER BY KdLoginLog DESC LIMIT 1");
    // $result = $this->db->get();
    $getDateNow = date('ymd');
    $kd="";
    if($result->num_rows()>0)
    {
            foreach($result->result() as $kd)
            {
                
                // echo "kode".$kd->KdPromosi;
                $splitVar_start = substr($kd->KdLoginLog,0,6);
                // echo "splitVar_start = ".$splitVar_start;
                $splitVar_end = substr($kd->KdLoginLog,6,14);
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

//Untuk counter KdLogPushPromosi
function getKdLogPushPromosi(){
    $result = $this->db->query("SELECT KdLogPushPromosi FROM digi_log_push_temp_promosi ORDER BY KdLogPushPromosi DESC LIMIT 1");
    $getDateNow = date('ymd');
    $kd="";
    if($result->num_rows()>0)
    {
            foreach($result->result() as $kd)
            {
                
                // echo "kode".$kd->KdPromosi;
                $splitVar_start = substr($kd->KdLogPushPromosi,0,6);
                // echo "splitVar_start = ".$splitVar_start;
                $splitVar_end = substr($kd->KdLogPushPromosi,6,14);
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

//Untuk counter KdMobileNotifTemp
function getKdMobileNotifTemp(){
    $result = $this->db->query("SELECT KdMobileNotifTemp FROM digi_mobile_notif_temp_dihubungi ORDER BY KdMobileNotifTemp DESC LIMIT 1");
    $getDateNow = date('ymd');
    $kd="";
    if($result->num_rows()>0)
    {
            foreach($result->result() as $kd)
            {
                $splitVar_start = substr($kd->KdMobileNotifTemp,0,6);
                $splitVar_end = substr($kd->KdMobileNotifTemp,6,14);
                
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

//--- BEGIN - KD LOG UNTUK PERHITUNGAN DI DPA (INFOSALDO, ESTIMASI, SIMULASI MP DPA1, SIMULASI MP DPA2)---//
//Untuk counter infosaldo
function getKdLogInfoSaldo(){
    $result = $this->db->query("SELECT KdLogInfoSaldo FROM digi_log_infosaldo ORDER BY KdLogInfoSaldo DESC LIMIT 1");
    $getDateNow = date('ymd');
    $kd="";
    if($result->num_rows()>0)
    {
            foreach($result->result() as $kd)
            {
                $splitVar_start = substr($kd->KdLogInfoSaldo,0,6);
                $splitVar_end = substr($kd->KdLogInfoSaldo,6,14);

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

//Untuk counter simulasi mp dpa2
function getKdLogSimulasiMPDPA2(){
    $result = $this->db->query("SELECT KdLogSimulasiDPA2 FROM digi_log_simulasi_dpa2 ORDER BY KdLogSimulasiDPA2 DESC LIMIT 1");
    $getDateNow = date('ymd');
    $kd="";
    if($result->num_rows()>0)
    {
            foreach($result->result() as $kd)
            {
                $splitVar_start = substr($kd->KdLogSimulasiDPA2,0,6);
                $splitVar_end = substr($kd->KdLogSimulasiDPA2,6,14);

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

//--- END - KD LOG UNTUK PERHITUNGAN DI DPA (INFOSALDO, ESTIMASI, SIMULASI MP DPA1, SIMULASI MP DPA2)---//

//Untuk counter target filter mitra
function getKdTargetPromosiMitra(){
    $result = $this->db->query("SELECT KdTargetPromosiMitra FROM digi_targetpromosimitra ORDER BY KdTargetPromosiMitra DESC LIMIT 1");
    $getDateNow = date('ymd');
    $kd="";
    if($result->num_rows()>0)
    {
            foreach($result->result() as $kd)
            {
                $splitVar_start = substr($kd->KdTargetPromosiMitra,0,6);
                $splitVar_end = substr($kd->KdTargetPromosiMitra,6,14);

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

//Untuk counter KdFormKlaim
function getKdFormKlaim(){
    $result = $this->db->query("SELECT KdFormKlaim FROM digi_formklaim ORDER BY KdFormKlaim DESC LIMIT 1");
    $getDateNow = date('ymd');
    $kd="";
    if($result->num_rows()>0)
    {
            foreach($result->result() as $kd)
            {
                $splitVar_start = substr($kd->KdFormKlaim,0,6);
                $splitVar_end = substr($kd->KdFormKlaim,6,14);
                
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

//Untuk counter KdTargetNotifClaim
function getKdTargetNotifClaim(){
    $result = $this->db->query("SELECT KdTargetNotifClaim FROM digi_target_notif_claim ORDER BY KdTargetNotifClaim DESC LIMIT 1");
    $getDateNow = date('ymd');
    $kd="";
    if($result->num_rows()>0)
    {
            foreach($result->result() as $kd)
            {
                $splitVar_start = substr($kd->KdTargetNotifClaim,0,6);
                $splitVar_end = substr($kd->KdTargetNotifClaim,6,14);
                
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

//Untuk counter KdKegiatanPensiunan
function getKdKegiatanPensiunan(){
    $result = $this->db->query("SELECT KdKegiatanPensiunan FROM digi_kegiatan_pensiunan ORDER BY KdKegiatanPensiunan DESC LIMIT 1");
    $getDateNow = date('ymd');
    $kd="";
    if($result->num_rows()>0)
    {
            foreach($result->result() as $kd)
            {
                $splitVar_start = substr($kd->KdKegiatanPensiunan,0,6);
                $splitVar_end = substr($kd->KdKegiatanPensiunan,6,14);
                
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