<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class ReadDetailTransaksi extends CI_Controller
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
                $this->_readdetailtransaksi();
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

    public function _readdetailtransaksi()
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

        // 5. Get nama OA
        $getNamaOA = $this->SipadokTransaction_Model->getNamaPenerima($DilayaniOlehOa);
        $ValueNamaOA = '';
        foreach ($getNamaOA as $dt)
        {
            $ValueNamaOA = $dt->NamaUser;
        }

        $value = array(
            'title' => 'Detail Transaksi',
            'header' => 'Lihat Detail',
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
            'DilayaniOlehOa' => $ValueNamaOA
        );
        $this->template_lib->load('default', 'content/sipadokall/readdetailtransaksi_view', $value);
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

}
