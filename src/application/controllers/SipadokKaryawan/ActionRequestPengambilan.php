<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class ActionRequestPengambilan extends CI_Controller
{
    public $usernameLogin;
    public $kdtransaksipadok;
    public function __construct()
    {
        parent::__construct();
        //$this->load->model('digi_datapromosi','',TRUE);
        $this->load->library('Grocery_CRUD');
        $this->load->model('SipadokTransaction_Model');
        $this->load->helper('url');
        $this->load->helper(array('form', 'url'));
    }

    public function index()
    {
        if ($this->session->userdata('logged_in')) {
            //Atur hak akses
            $session_data = $this->session->userdata('logged_in');
            $this->usernameLogin = $session_data['username'];

            if (isset($_GET['KdTransaksiPadok'])){
                $this->kdtransaksipadok = $_GET['KdTransaksiPadok'];

                // Kalau status requestnya tidak 0 maka tidak akan bisa masuk ke halaman ini
                $getDataTransaksiPadok = $this->SipadokTransaction_Model->getDataTransaksiPadok($this->kdtransaksipadok);
                $PengambilanStatus = '';
                foreach ($getDataTransaksiPadok as $dt)
                {
                    $PengambilanStatus = $dt->PengambilanStatus;
                }

                if($PengambilanStatus == 0 || $PengambilanStatus == '0'){
                    $this->_requestpengambilan();
                }else{
                    $message = "Permintaan anda sedang diproses";
                    echo "<script LANGUAGE='JavaScript'>
                        window.alert('$message');
                        window.location.href='".base_url()."index.php/SipadokKaryawan/PadokSaya/index';
                        </script>";
                }

                
            }else{
                $message = "Maaf anda tidak memiliki akses atau session telah berakhir.";
                echo "<script LANGUAGE='JavaScript'>
                    window.alert('$message');
                    window.location.href='" . base_url() . "';
                    </script>";
            }

        } else {
            $this->load->view('errors/index');
        }
    }

    public function _requestpengambilan()
    {
        $getDataTransaksiPadokAndDataPadok = $this->SipadokTransaction_Model->getDataTransaksiPadokAndDataPadok($this->kdtransaksipadok);
        $KdDataPadok = '';
        $TglPadokMasuk = '';
        $Penerima = '';
        $Pengirim = '';
        $KdTipePadok = '';
        $KdJasaEkspedisi = '';
        $NamaKurir = '';
        $NomorTelpKurir = '';
        $KdLokasiPadok = '';
        $PengambilanStatus = '';
        $PengambilanRealOn = '';
        $BktTerimaStatus = '';
        $BktTerimaOn = '';
        $DilayaniOlehOa = '';
        foreach ($getDataTransaksiPadokAndDataPadok as $dt)
        {
            $KdDataPadok = $dt->KdDataPadok;
            $TglPadokMasuk = $dt->TglPadokMasuk;
            $Penerima = $dt->Penerima;
            $Pengirim = $dt->Pengirim;
            $KdTipePadok = $dt->KdTipePadok;
            $KdJasaEkspedisi = $dt->KdJasaEkspedisi;
            $NamaKurir = $dt->NamaKurir;
            $NomorTelpKurir = $dt->NomorTelpKurir;
            $KdLokasiPadok = $dt->KdLokasiPadok;
            $PengambilanStatus = $dt->PengambilanStatus;
            $PengambilanRealOn = $dt->PengambilanRealOn;
            $BktTerimaStatus = $dt->BktTerimaStatus;
            $BktTerimaOn = $dt->BktTerimaOn;
            $DilayaniOlehOa = $dt->DilayaniOlehOa;
        }

        // 1. Get nama penerima
        $getNamaPenerima = $this->SipadokTransaction_Model->getNamaPenerima($Penerima);
        $ValuePenerima = '';
        foreach ($getNamaPenerima as $dt)
        {
            $ValuePenerima = $dt->NamaUser;
        }

        // 2. Get nama tipe padok
        $getNamaTipePadok = $this->SipadokTransaction_Model->getNamaTipePadok($KdDataPadok);
        $ValueNamaTipePaket = '';
        foreach ($getNamaTipePadok as $dt)
        {
            $ValueNamaTipePaket = $dt->NamaTipePaket;
        }

        // 3. Get nama jasa ekspedisi
        $getNamaJasaEkspedisi = $this->SipadokTransaction_Model->getNamaJasaEkspedisi($KdDataPadok);
        $ValueNamaJasaEkspedisi = '';
        foreach ($getNamaJasaEkspedisi as $dt)
        {
            $ValueNamaJasaEkspedisi = $dt->NamaJasaEkspedisi;
        }

        // 4. Get nama lokasi padok
        $getNamaLokasiPadok = $this->SipadokTransaction_Model->getNamaLokasiPadok($KdDataPadok);
        $ValueNamaLokasiPadok = '';
        foreach ($getNamaLokasiPadok as $dt)
        {
            $ValueNamaLokasiPadok = $dt->NamaLokasiPadok;
        }

        $value = array(
            'title' => 'Request Pengambilan',
            'header' => 'Request Pengambilan Paket / Dokumen',
            'KdTransaksiPadok' => $this->kdtransaksipadok,
            'KdDataPadok' => $KdDataPadok,
            'TglPadokMasuk' => $TglPadokMasuk,
            'Penerima' => $ValuePenerima,
            'Pengirim' => $Pengirim,
            'KdTipePadok' => $ValueNamaTipePaket,
            'KdJasaEkspedisi' => $ValueNamaJasaEkspedisi,
            'NamaKurir' => $NamaKurir,
            'NomorTelpKurir' => $NomorTelpKurir,
            'KdLokasiPadok' => $ValueNamaLokasiPadok,
            'PengambilanStatus' => $this->stringPengambilanStatus($PengambilanStatus),
            'PengambilanRealOn' => $PengambilanRealOn,
            'BktTerimaStatus' => $this->stringBktTerimaStatus($BktTerimaStatus),
            'BktTerimaOn' => $BktTerimaOn,
            'DilayaniOlehOa' => $DilayaniOlehOa,
            'UpdatedBy' => $this->usernameLogin
        );
        $this->template_lib->load('default', 'content/sipadokkaryawan/actionrequestpengambilan_view', $value);
    }

    public function stringPengambilanStatus($value)
    {
        if ($value == '0') {
            return "<font color='grey'>Belum Diambil</font>";
        } elseif ($value == '1') {
            return "<font color='blue'>Permintaan Pengambilan</font>";
        } elseif ($value == '2') {
            return "<font color='green'>Sudah Diambil</font>";
        } else {
            return "Data Not Valid";
        }
    }

    public function stringBktTerimaStatus($value)
    {
        if ($value == '0') {
            return "<font color='grey'>Belum Diterima</font>";
        } elseif ($value == '1') {
            return "<font color='blue'>Permintaan Persetujuan</font>";
        } elseif ($value == '2') {
            return "<font color='green'>Disetujui</font>";
        }elseif ($value == '3') {
            return "<font color='red'>Ditolak</font>";
        }else {
            return "Data Not Valid";
        }
    }

    public function formatBulanString($value){
        if($value == '1' || $value == '01'){
            return "JANUARI";
        } else if($value == '2' || $value == '02'){
            return "FEBRUARI";
        } else if($value == '3' || $value == '03'){
            return "MARET";
        } else if($value == '4' || $value == '04'){
            return "APRIL";
        } else if($value == '5' || $value == '05'){
            return "MEI";
        } else if($value == '6' || $value == '06'){
            return "JUNI";
        } else if($value == '7' || $value == '07'){
            return "JULI";
        } else if($value == '8' || $value == '08'){
            return "AGUSTUS";
        } else if($value == '9' || $value == '9'){
            return "SEPTEMBER";
        } else if($value == '10'){
            return "OKTOBER";
        } else if($value == '11'){
            return "NOVEMBER";
        } else if($value == '12'){
            return "DESEMBER";
        }
    }

    //--- begin - save action - request pengambilan ---//
    // public function do_save_action(){
    //     $this->db->trans_begin();

    //     $rules = 'trims|htmlentities|strip_tags';
    //     $KdTransaksiPadok = strip_tags($this->input->post('KdTransaksiPadok'));
    //     $PengambilanStatus = strip_tags($this->input->post('PengambilanStatus'));
    //     $TglPengambilanReqTgl = strip_tags($this->input->post('TglPengambilanReqTgl'));
    //     $JamPengambilanReqTgl = strip_tags($this->input->post('JamPengambilanReqTgl'));
    //     $UpdatedBy = strip_tags($this->input->post('UpdatedBy'));
    //     $KodeUnikPengambilan = $this->generateRandomString();

    //     $this->SipadokTransaction_Model->updateRequestPengambilanPadok(
    //         $KdTransaksiPadok, 
    //         $PengambilanStatus, 
    //         $TglPengambilanReqTgl, 
    //         $JamPengambilanReqTgl,
    //         $UpdatedBy,
    //         $KodeUnikPengambilan
    //     );

    //     if ($this->db->trans_status() == false) {
    //         $this->db->trans_rollback();
    //         // return false;
    //         // return base_url()."index.php/SipadokKaryawan/PadokSaya/index";
    //         echo "<script LANGUAGE='JavaScript'>
    //                     window.location.href='".base_url()."index.php/SipadokKaryawan/PadokSaya/index';
    //                     </script>";
    //     } else {
    //         $this->db->trans_commit();
    //         // return true;
    //         // return base_url()."index.php/SipadokKaryawan/PadokSaya/index";
    //         echo "<script LANGUAGE='JavaScript'>
    //                     window.location.href='".base_url()."index.php/SipadokKaryawan/PadokSaya/index';
    //                     </script>";
    //     }
    // }

    public function do_save_action(){
        $this->db->trans_begin();

        $rules = 'trims|htmlentities|strip_tags';
        $KdTransaksiPadok = strip_tags($this->input->post('KdTransaksiPadok'));
        $PengambilanStatus = strip_tags($this->input->post('PengambilanStatus'));
        $TglPengambilanReqTgl = strip_tags($this->input->post('TglPengambilanReqTgl'));
        $JamPengambilanReqTgl = strip_tags($this->input->post('JamPengambilanReqTgl'));
        $UpdatedBy = strip_tags($this->input->post('UpdatedBy'));
        $KodeUnikPengambilan = $this->generateRandomString();

        $this->SipadokTransaction_Model->updateRequestPengambilanPadok(
            $KdTransaksiPadok, 
            $PengambilanStatus, 
            $TglPengambilanReqTgl, 
            $JamPengambilanReqTgl,
            $UpdatedBy,
            $KodeUnikPengambilan
        );

        if ($this->db->trans_status() == false) {
            $this->db->trans_rollback();
            // return false;
            // return base_url()."index.php/SipadokKaryawan/PadokSaya/index";
            echo "<script LANGUAGE='JavaScript'>
                        window.location.href='".base_url()."index.php/SipadokKaryawan/PadokSaya/index';
                        </script>";
        } else {
            $this->db->trans_commit();
            // return true;
            // return base_url()."index.php/SipadokKaryawan/PadokSaya/index";
			
			//tambahan
		
			$getDataTransaksiPadokAndDataPadok = $this->SipadokTransaction_Model->getDataTransaksiPadokAndDataPadok($KdTransaksiPadok);
			$KdDataPadok = '';
			$TglPadokMasuk = '';
			$Penerima = '';
			$Pengirim = '';
			$KdTipePadok = '';
			$KdJasaEkspedisi = '';
			$NamaKurir = '';
			$NomorTelpKurir = '';
			$KdLokasiPadok = '';
			$PengambilanStatus = '';
			$PengambilanRealOn = '';
			$BktTerimaStatus = '';
			$BktTerimaOn = '';
			$DilayaniOlehOa = '';
			foreach ($getDataTransaksiPadokAndDataPadok as $dt)
			{
				$KdDataPadok = $dt->KdDataPadok;
				$TglPadokMasuk = $dt->TglPadokMasuk;
				$Penerima = $dt->Penerima;
				$Pengirim = $dt->Pengirim;
				$KdTipePadok = $dt->KdTipePadok;
				$KdJasaEkspedisi = $dt->KdJasaEkspedisi;
				$NamaKurir = $dt->NamaKurir;
				$NomorTelpKurir = $dt->NomorTelpKurir;
				$KdLokasiPadok = $dt->KdLokasiPadok;
				$PengambilanStatus = $dt->PengambilanStatus;
				$PengambilanRealOn = $dt->PengambilanRealOn;
				$BktTerimaStatus = $dt->BktTerimaStatus;
				$BktTerimaOn = $dt->BktTerimaOn;
				$DilayaniOlehOa = $dt->DilayaniOlehOa;
			}
			
			$getNamaPenerima = $this->SipadokTransaction_Model->getNamaPenerima($Penerima);
			$ValuePenerima = '';
			foreach ($getNamaPenerima as $dt)
			{
				$ValuePenerima = $dt->NamaUser;
			}
			
			$getNamaTipePadok = $this->SipadokTransaction_Model->getNamaTipePadok($KdDataPadok);
			$ValueNamaTipePaket = '';
			foreach ($getNamaTipePadok as $dt)
			{
				$ValueNamaTipePaket = $dt->NamaTipePaket;
			}
			
			$getNamaJasaEkspedisi = $this->SipadokTransaction_Model->getNamaJasaEkspedisi($KdDataPadok);
			$ValueNamaJasaEkspedisi = '';
			foreach ($getNamaJasaEkspedisi as $dt)
			{
				$ValueNamaJasaEkspedisi = $dt->NamaJasaEkspedisi;
			}
			
			$getNamaLokasiPadok = $this->SipadokTransaction_Model->getNamaLokasiPadok($KdDataPadok);
			$ValueNamaLokasiPadok = '';
			foreach ($getNamaLokasiPadok as $dt)
			{
				$ValueNamaLokasiPadok = $dt->NamaLokasiPadok;
			}
			
			$getNamaOA = $this->SipadokTransaction_Model->getNamaPenerima($DilayaniOlehOa);
			$ValueOA = '';
			foreach ($getNamaOA as $dt)
			{
				$ValueOA = $dt->NamaUser;
			}
			
			$getEmailPenerima = $this->SipadokTransaction_Model->getNamaPenerima($Penerima);
			$ValueEmailPenerima = '';
			$ValueEmailPenerima2 = '';
			foreach ($getEmailPenerima as $dt)
			{
				$ValueEmailPenerima = $dt->EmailKantor;
				$ValueEmailPenerima2 = $dt->EmailPribadi;
			}
			
			$subject = 'Informasi Request Pengambilan PADOK';					
			$message = "
				Dear SIPADOK user, <br><br>
				Berikut adalah informasi request pengambilan PADOK anda : <br>
				<html><body>
				<table rules=all style=border-color: #666 cellpadding=10>
				<tr><td><strong>Kode Transaksi :</strong> </td><td>".$KdTransaksiPadok."</td></tr>
				<tr><td><strong>Tanggal Masuk :</strong> </td><td>   ".$TglPadokMasuk."   </td></tr>
				<tr><td><strong>Penerima:</strong> </td><td>   ".$ValuePenerima."   </td></tr>
				<tr><td><strong>Jenis Paket:</strong> </td><td>    ".$ValueNamaTipePaket."   </td></tr>
				<tr><td><strong>Pengirim:</strong> </td><td>    ".$Pengirim."   </td></tr>
				<tr><td><strong>Nama Jasa Ekspedisi:</strong> </td><td>    ".$ValueNamaJasaEkspedisi."   </td></tr>
				<tr><td><strong>Lokasi Paket:</strong> </td><td>    ".$ValueNamaLokasiPadok."   </td></tr>
				<tr><td><strong>Bukti Terima:</strong> </td><td>   ".$BktTerimaOn."   </td></tr>
				<tr><td><strong>Petugas OA:</strong> </td><td>   ".$DilayaniOlehOa."   </td></tr>
				<tr><td><strong>Kode Pengambilan:</strong> </td><td><strong>   ".$KodeUnikPengambilan."   </strong></td></tr>
				</table>
				</body></html>
				<strong>Kode Pengambilan</strong> digunakan untuk untuk mengambil paket / dokumen anda, harap dijaga dan disimpan dengan baik.<br><br>
				regards, <br><br>
				SIPADOK Tokopedia
			";
			 
			$to = $ValueEmailPenerima; //aslinya ini
			//$to = 'majestyeksa@gmail.com'; //buat coba doang
			$listCC = array($ValueEmailPenerima2);
			if(!$this->sendEmail($subject, $message, $to, $listCC))
			{
				$message = "Gagal mengirim email, silahkan coba beberapa saat lagi.";
				echo "<script LANGUAGE='JavaScript'>
					window.alert('$message');
					window.location.href='".base_url()."index.php/SipadokKaryawan/PadokSaya/index';
					</script>";
			}
			else
			{
				$message = "Email notifikasi telah terkirim.";
				echo "<script LANGUAGE='JavaScript'>
					window.alert('$message');
					window.location.href='".base_url()."index.php/SipadokKaryawan/PadokSaya/index';
					</script>";
			}
			//end of tambahan
        }
    }

    public function sendEmail($subject, $message, $to, $listCC)
	{
		$this->load->library('email');
		
		$config = Array(
				'protocol' => 'smtp',
				'smtp_host' => 'smtp.googlemail.com',
				'smtp_port' => 465,
				'smtp_user' => 'sipadok.noreply@gmail.com',
				'smtp_pass' => 'sipadoktokped',
				'mailtype'  => 'html', 
				'charset'   => 'UTF-8'
		);
		$this->email->initialize($config);
		$this->email->set_mailtype("html");
		$this->email->set_newline("\r\n");
		
		$this->email->from('sipadok.noreply@gmail.com', 'SIPADOK TOKOPEDIA');
		$this->email->to($to);
		$this->email->cc($listCC);
		$this->email->subject($subject);
		$this->email->message($message);
		
		if($this->email->send())
		{
			return true;
		}else
		{
			return false;			
		}
	}
    //--- end - save action - request pengambilan ---//

    function generateRandomString($length = 7) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
