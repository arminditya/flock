<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class PadokSaya extends CI_Controller {
	var $usernameLogin;
    function __construct()
    {
        parent::__construct();
        $this->load->model('SipadokUser_Model','',TRUE);
        $this->load->model('SipadokKode_Model','',TRUE);
        $this->load->library('Grocery_CRUD');
    }
 
    public function index()
    {		
		if($this->session->userdata('logged_in')){
			if(page_check_authorized('Padok Saya'))
			{
				$session_data = $this->session->userdata('logged_in');
				$this->usernameLogin = $session_data['username'];
                $this->_padoksaya();
			}else{
                $message = "Maaf, anda tidak memiliki akses pada halaman ini.";
                echo "<script LANGUAGE='JavaScript'>
                    window.alert('$message');
                    window.location.href='".base_url()."';
                    </script>";
            }
		}else{
            redirect('Login?url='.substr($_SERVER["REQUEST_URI"],stripos($_SERVER["REQUEST_URI"],"index.php/")+10),'refresh');
		}
    }
	
	public function _padoksaya()
    {
		$crud = new grocery_CRUD();
		$crud->set_subject('Padok Saya');
		$crud->set_table('sipadok_transaksi_padok');
        $crud->where('sipadok_transaksi_padok.Deleted','0');
        $crud->where('sipadok_transaksi_padok.Penerima',$this->usernameLogin);
        $crud->order_by('sipadok_transaksi_padok.KdDataPadok', 'desc');

        // $crud->set_relation('Penerima', 'sipadok_user', 'NamaUser', array('Deleted' => '0','KdRole'=>'3'));
        // $crud->set_relation('KdTipePadok', 'sipadok_tipepadok', 'NamaTipePaket', array('Deleted' => '0'));
        // $crud->set_relation('KdJasaEkspedisi', 'sipadok_jasaekspedisi', 'NamaJasaEkspedisi', array('Deleted' => '0'));
        // $crud->set_relation('KdLokasiPadok', 'sipadok_lokasipadok', 'NamaLokasiPadok', array('Deleted' => '0'));
        
        $crud->unset_clone();
        $crud->unset_add();
        $crud->unset_read();
        $crud->unset_edit();
        $crud->unset_delete();

		//Kolom yang ditampilkan
        $crud->columns(
            // 'Proses',
            // 'KdTransaksiPadok',
            // 'KdDataPadok',
            'TglPadokMasuk',
            'Penerima',
            'Pengirim',
            'KdTipePadok',
            'KdJasaEkspedisi',
            'KdLokasiPadok',
            'PengambilanStatus',
            'BktTerimaStatus'
            // 'PengambilanReqTgl',
            // 'PengambilanRealOn'
        );

        $crud->change_field_type('KdDataPadok', 'invisible');

        // Akan ditampilkan sebagai
        $crud->display_as('Proses','Proses');
        $crud->display_as('KdTransaksiPadok','Kode Transaksi');
        $crud->display_as('KdDataPadok','Kode Data Padok');
        $crud->display_as('Penerima','Nama Penerima');
        $crud->display_as('PengambilanReqTgl','Tanggal Request Pengambilan');
        $crud->display_as('PengambilanStatus','Status Pengambilan');
        $crud->display_as('PengambilanRealOn','Diambil Pada');
        $crud->display_as('DilayaniOlehOa','Dilayani Oleh');
        $crud->display_as('BktTerimaReq','Tanggal Request Bukti Terima');
        $crud->display_as('BktTerimaStatus','Status Bukti Terima');
        $crud->display_as('BktTerimaOn','Bukti Terima Diterima Pada');

        $crud->display_as('Pengirim','Nama Pengirim');
        $crud->display_as('TglPadokMasuk','Tgl Paket/Dokumen Masuk');
        $crud->display_as('KdTipePadok','Tipe');
        $crud->display_as('KdJasaEkspedisi','Jasa Ekspedisi');
        $crud->display_as('KdLokasiPadok','Lokasi');

        //--- begin - callback column ---//
        // $crud->callback_column('Proses', array($this, '_callback_column_Proses'));
        $crud->callback_column('PengambilanStatus', array($this, '_callback_column_PengambilanStatus'));
        $crud->callback_column('BktTerimaStatus', array($this, '_callback_column_BktTerimaStatus'));
        $crud->callback_column('Penerima', array($this, '_callback_column_Penerima'));
        $crud->callback_column('Pengirim', array($this, '_callback_column_Pengirim'));
        $crud->callback_column('TglPadokMasuk', array($this, '_callback_column_TglPadokMasuk'));
        $crud->callback_column('KdTipePadok', array($this, '_callback_column_KdTipePadok'));
        $crud->callback_column('KdJasaEkspedisi', array($this, '_callback_column_KdJasaEkspedisi'));
        $crud->callback_column('KdLokasiPadok', array($this, '_callback_column_KdLokasiPadok'));
        //--- end - callback column ---//

        //--- begin - add action ---//
       
        
        $crud->add_action('Read', '', 'demo/action_more','fa fa-search',array($this,'read_detail'));
        $crud->add_action('Accept Bukti Terima', '', 'demo/action_more','fa fa-check-square-o',array($this,'action_accept'));
        $crud->add_action('Request Ambil', '', 'demo/action_more','fa fa-hand-grab-o',array($this,'action_request'));
        //--- end - add action ---//

        //Atur rule
        // $crud->set_rules('TglPadokMasuk','Tanggal Padok Diterima *','trim|required');
        // $crud->set_rules('Penerima','Nama Penerima *','trim|required');
        // $crud->set_rules('Pengirim','Nama Pengirim *','trim|required|min_length[1]|max_length[150]');
        // $crud->set_rules('KdTipePadok','Tipe Paket / Dokumen *','trim|required');
        // $crud->set_rules('KdJasaEkspedisi','Jasa Ekspedisi *','trim|required');
        // $crud->set_rules('NamaKurir','Nama Kurir *','trim|required|min_length[1]|max_length[150]');
        // $crud->set_rules('NomorTelpKurir','Nomor Telp Kurir','trim|numeric');
        // $crud->set_rules('KdLokasiPadok','Lokasi Paket Dokumen *','trim|required');

		$crud->unset_texteditor('Description','Url');
		
        $output = $crud->render();
   
        $this-> _outputview($output);        
    }
 
    function _outputview($output = null)
    {
		$data = array(
                'title' => 'Padok Saya',
			    'body' => $output
		  );
		$this->load->helper(array('form','url'));
        $this->template_lib->load('default','content/sipadokkaryawan/padoksaya_view',$data);
    }
	
    
    function getTime()
	{
		$timezone  = 7;
		return gmdate("Y/m/j H:i:s", time() + 3600*($timezone+date("I"))); 
    }

    //--- begin - custom action ---//
    public function action_request($primary_key , $row)
    {
        return base_url()."index.php/SipadokKaryawan/ActionRequestPengambilan/index?KdTransaksiPadok=".$primary_key;
    }
    public function action_accept($primary_key , $row)
    {
        return base_url()."index.php/SipadokKaryawan/ActionAcceptBuktiTerima/index?KdTransaksiPadok=".$primary_key;
    }
    public function read_detail($primary_key , $row)
    {
        return base_url()."index.php/SipadokAll/ReadDetailTransaksi/index?KdTransaksiPadok=".$primary_key;
    }
    //--- end - custom action ---//
    
    //--- begin - callback column ---//
    public function _callback_column_PengambilanStatus($value, $row)
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
    public function _callback_column_BktTerimaStatus($value, $row)
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
    // public function _callback_column_Proses($value, $row)
    // {
    //     $getDataTransaksiPadok = $this->SipadokTransaction_Model->getDataTransaksiPadok($value);
    //     $PengambilanStatus = '';
    //     $BktTerimaStatus = '';
    //     foreach ($getDataTransaksiPadok as $dt)
    //     {
    //         $PengambilanStatus = $dt->PengambilanStatus;
    //         $BktTerimaStatus = $dt->BktTerimaStatus;
    //     }

    //     if($PengambilanStatus = '2' && $BktTerimaStatus = '2'){
    //         return "<font color='grey'>CLOSED</font>";
    //     }else{
    //         return "<font color='green'>OPEN</font>";
    //     }
    // }
    public function _callback_column_Penerima($value, $row)
    {
        $getNamaPenerima = $this->SipadokTransaction_Model->getNamaPenerima($value);
        $Penerima = '';
        foreach ($getNamaPenerima as $dt)
        {
            $Penerima = $dt->NamaUser;
        }
        return $Penerima;
    }
    public function _callback_column_Pengirim($value, $row)
    {
        $getDataPadok = $this->SipadokTransaction_Model->getDataPadok($row->KdDataPadok);
        $Pengirim = '';
        foreach ($getDataPadok as $dt)
        {
            $Pengirim = $dt->Pengirim;
        }
        return $Pengirim;
    }
    public function _callback_column_TglPadokMasuk($value, $row)
    {
        $getDataPadok = $this->SipadokTransaction_Model->getDataPadok($row->KdDataPadok);
        $TglPadokMasuk = '';
        foreach ($getDataPadok as $dt)
        {
            $TglPadokMasuk = $dt->TglPadokMasuk;
        }
        return $TglPadokMasuk;
    }
    public function _callback_column_KdTipePadok($value, $row)
    {
        $getNamaTipePadok = $this->SipadokTransaction_Model->getNamaTipePadok($row->KdDataPadok);
        $NamaTipePaket = '';
        foreach ($getNamaTipePadok as $dt)
        {
            $NamaTipePaket = $dt->NamaTipePaket;
        }
        return $NamaTipePaket;
    }
    public function _callback_column_KdJasaEkspedisi($value, $row)
    {
        $getNamaJasaEkspedisi = $this->SipadokTransaction_Model->getNamaJasaEkspedisi($row->KdDataPadok);
        $NamaJasaEkspedisi = '';
        foreach ($getNamaJasaEkspedisi as $dt)
        {
            $NamaJasaEkspedisi = $dt->NamaJasaEkspedisi;
        }
        return $NamaJasaEkspedisi;
    }
    public function _callback_column_KdLokasiPadok($value, $row)
    {
        $getNamaLokasiPadok = $this->SipadokTransaction_Model->getNamaLokasiPadok($row->KdDataPadok);
        $NamaLokasiPadok = '';
        foreach ($getNamaLokasiPadok as $dt)
        {
            $NamaLokasiPadok = $dt->NamaLokasiPadok;
        }
        return $NamaLokasiPadok;
    }
    //--- end - callback column ---//
		
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */