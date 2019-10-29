<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
 
class PdfFormKlaim extends CI_Controller {
    public function __construct()
        {   
            parent::__construct();
            $this->load->library('Pdf');
            $this->load->model('Form_Klaim_Model');
            $this->load->library('email');
        }


    public function email(){
        $KdFormKlaimEncryp = $this->input->post('KdFormKlaimEncryp');
        $MYNDAIL = $this->input->post('MYNDAIL');
        $emailpemohon = $this->input->post('emailpemohon');
        // $data = $this->Form_Klaim_Model->getDataTampilkanFormKlaim($KdFormKlaimEncryp);
        // $this->generateData($data,$KdFormKlaimEncryp,$MYNDAIL);

        if($MYNDAIL == "true"){
        
            try
            {
                $message = $this->getMessage($KdFormKlaimEncryp);
                $this->email->from('NOREPLY@DAPENASTRA.COM', 'Dana Pensiun Astra');
                $this->email->to( $emailpemohon );
                $this->email->subject('Form Klaim');
                $this->email->message($message);
                
                if(!$this->email->send())
                {
                    echo "Fail";
                }    
            }
            catch(Exception $e)
            {
                log_message( 'error', $e->getMessage() . ' in '.$e->getFile() . ' : '.$e->getLine());
                throw new Exception('Something really gone wrong',0,$e);
            }
        }
        
    }

    
    public function index()
        {
            //--- BEGIN - DEKLARASI VARIABLE ---// 
            $KdFormKlaim = '';
            $KdFormKlaimEncryp = '';
            $bertindaksebagai = '';
            $namapesertaklaim = '';
            $tanggallahir = '';
            $namamitra = '';
            $nip = '';
            $nomorktp = '';
            $npwp = '';
            $telprumah = '';
            $telphp = '';
            $berhentisejak = '';
            $norek = '';
            $anrek = '';
            $namabank = '';
            $namacabang = '';
            $isKpstLebih3Tahun = 0;
            $isUmurLebih45Tahun = 0;
            $dplk = '';
            $asuransijiwa = '';
            $namapemohon = '';
            $emailpemohon = '';
            $d_now = 0;
            $m_now = 0;
            $y_now = 0;
            //--- END - DEKLARASI VARIABLE ---// 
            $MYNDAIL = "null";
            $KdFormKlaimEncryp = $_GET['UZUMYMW'];
            if(isset($_GET['MYNDAIL'])){
                $MYNDAIL = $_GET['MYNDAIL'];
            }
            
            $KdFormKlaimEncryp = str_replace('"', '', $KdFormKlaimEncryp);
            
            // $data['klaim'] = $this->Form_Klaim_Model->getDataTampilkanFormKlaim($KdFormKlaim);
            $data['klaim'] = $this->Form_Klaim_Model->getDataTampilkanFormKlaim($KdFormKlaimEncryp);
            $this->generateData( $data['klaim'],$KdFormKlaimEncryp,$MYNDAIL);

        
            // $this->load->view('content/pdf_generator/cetak_form_klaim', $data);
            
    }   

    function generateData($klaim,$KdFormKlaimEncryp,$MYNDAIL= null){

    try
    {
        $pdf = new Pdf('L', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetTitle('Form Klaim DPA');
        // $pdf->SetHeaderMargin(10);
        // $pdf->SetTopMargin(10);
        $pdf->setFooterMargin(20);
        $pdf->SetAutoPageBreak(false);
        $pdf->SetAuthor('Dana Pensiun Astra');
        $pdf->SetDisplayMode('real', 'default');

        //$pdf->AddPage();
        $pdf->AddPage('L', 'A4');
        // $pdf->Cell(0, 0, 'A4 LANDSCAPE', 1, 1, 'C');
        //$pdf->Cell(0, 15, '<< TCPDF Example 003 >>', 0, false, 'C', 0, '', 0, false, 'M', 'M');

        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        $pdf->SetFont('helvetica', '', 9);

        //$image_file = define ('K_PATH_IMAGES', '/images/');;
        //$PDF_HEADER_LOGO = $tcpdf->Image('@' . $img);//any image file. check correct path.
        $PDF_HEADER_LOGO = "";
        $PDF_HEADER_LOGO_WIDTH = "40";
        $PDF_HEADER_TITLE = "This is my Title";
        $PDF_HEADER_STRING = "This is Header Part";
        $pdf->SetHeaderData($PDF_HEADER_LOGO, $PDF_HEADER_LOGO_WIDTH, $PDF_HEADER_TITLE, $PDF_HEADER_STRING);


        $KdFormKlaim = '';
        $bertindaksebagai = '';
        $kdpesertaklaim = '';
        $namapesertaklaim = '';
        $tanggallahir = '';
        $namamitra = '';
        $nip = '';
        $nomorktp = '';
        $npwp = '';
        $telprumah = '';
        $telphp = '';
        $berhentisejak = '';
        $norek = '';
        $anrek = '';
        $namabank = '';
        $namacabang = '';
        $isKpstLebih3Tahun = 0;
        $isUmurLebih45Tahun = 0;
        $dplk = '-';
        $asuransijiwa = '-';
        $namapemohon = '';
        $emailpemohon = '';
        
        $d_now = 0;
        $m_now = 0;
        $y_now = 0;

        foreach ($klaim as $data) {
            $bertindaksebagai = $data->bertindaksebagai;
            $kdpesertaklaim = $data->kdpesertaklaim;
            $namapesertaklaim = $data->namapesertaklaim;
            $tanggallahir = $data->tanggallahir;
            $namamitra = $data->namamitra;
            $nip = $data->nip;
            $nomorktp = $data->nomorktp;
            $npwp = $data->npwp;
            $telprumah = $data->telprumah;
            $telphp = $data->telphp;
            $berhentisejak = $data->berhentisejak;
            $norek = $data->norek;
            $anrek = $data->anrek;
            $namabank = $data->namabank;
            $namacabang = $data->namacabang;
            $isKpstLebih3Tahun = $data->isKpstLebih3Tahun;
            $isUmurLebih45Tahun = $data->isUmurLebih45Tahun;
            $dplk = $data->dplk;
            $asuransijiwa = $data->asuransijiwa;
            $namapemohon = $data->namapemohon;
            $emailpemohon = $data->emailpemohon;
            $d_now = $data->d_now;
            $m_now = $data->m_now;
            $y_now = $data->y_now;

            if ($m_now == '1') {
                $m_string_now = "Januari";
            } else if ($m_now == '2') {
                $m_string_now = "Februari";
            } else if ($m_now == '3') {
                $m_string_now = "Maret";
            } else if ($m_now == '4') {
                $m_string_now = "April";
            } else if ($m_now == '5') {
                $m_string_now = "Mei";
            } else if ($m_now == '6') {
                $m_string_now = "Juni";
            } else if ($m_now == '7') {
                $m_string_now = "Juli";
            } else if ($m_now == '8') {
                $m_string_now = "Agustus";
            } else if ($m_now == '9') {
                $m_string_now = "September";
            } else if ($m_now == '10') {
                $m_string_now = "Oktober";
            } else if ($m_now == '11') {
                $m_string_now = "November";
            } else if ($m_now == '12') {
                $m_string_now = "Desember";
            } else {
                $m_string_now = " ";
            }

            $date = $d_now . " - " . $m_string_now . " - " . $y_now;
        }

        $html = '

            <div id="wrapper">	

                <div id="body">

                <table border="0">
                    <tbody>
                        <tr>

                            <td width="200px"><img src="assets/images/side_formklaim2.png"/></td>

                            <td width="580px">
                            
                                <table border="0">
                                    <tbody>
                                        <tr>
                                            <td><img src="assets/images/header_formklaim2.png"/></td>
                                        </tr>
                                    </tbody>
                                </table>
                
                                    <table border="0">
                                        <tbody>
                                            <tr>
                                                <td width="350px">Saya yang bertanda tangan di bawah ini, bertindak sebagai:</td>
                                                <td width="200px" align="right">Nomor Peserta DPA :  <strong>'.$kdpesertaklaim.'</strong></td>
                                            </tr>
                                            <tr>
                                                <td width="350px"><strong>'.$bertindaksebagai.'</strong></td>
                                                <td width="200px"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                            
                                    <table border="0">
                                        <tbody>
                                            <tr>
                                                <td width="550px"></td>
                                            </tr>
                                            <tr>
                                                <td width="550px">Dengan ini mengajukan Klaim Manfaat Pensiun atas kepesertaan dari : </td>
                                            </tr>
                                        </tbody>
                                    </table>
                            
                                    
                                    <table border="0">
                                        <tbody>
                            
                                            <tr>
                                                <td width="130px">Nama Perusahaan</td>
                                                <td width="10px">: </td>
                                                <td width="200px"><strong>'.$namamitra.'</strong></td>    
                                                <td width="200px"></td>
                                            </tr>
                                            
                                            <tr>
                                                <td width="130px">Nama Peserta (sesuai KTP)</td>
                                                <td width="10px">: </td>
                                                <td width="200px"><strong>'.$namapesertaklaim.'</strong></td>    
                                                <td width="200px" align="left"><em>Wajib melampirkan fotocopy KTP</em></td>
                                            </tr>
                            
                                            <tr>
                                                <td width="130px">Tgl Lahir</td>
                                                <td width="10px">: </td>
                                                <td width="200px"><strong>'.$tanggallahir.'</strong></td>    
                                                <td width="200px" align="right"></td>
                                            </tr>
                            
                                            <tr>
                                                <td width="130px">Nama Perusahaan</td>
                                                <td width="10px">: </td>
                                                <td width="200px"><strong>'.$namamitra.'</strong></td>    
                                                <td width="200px" align="right"></td>
                                            </tr>
                            
                                            <tr>
                                                <td width="130px">Nomor Induk Karyawan</td>
                                                <td width="10px">: </td>
                                                <td width="200px"><strong>'.$nip.'</strong></td>    
                                                <td width="200px" align="left">Nomor KTP : <strong>'.$nomorktp.'</strong></td>
                                            </tr>
                            
                                            <tr>
                                                <td width="130px">NPWP</td>
                                                <td width="10px">: </td>
                                                <td width="200px"><strong>'.$npwp.'</strong></td>    
                                                <td width="200px" align="right"></td>
                                            </tr>
                            
                                            <tr>
                                                <td width="130px">Telepon Aktif (Rumah & HP)</td>
                                                <td width="10px">: </td>
                                                <td width="200px"> (1) <strong>'.$telprumah.'</strong></td>    
                                                <td width="200px" align="left"> (2) <strong>'.$telphp.'</strong></td>
                                            </tr>
                            
                                            <tr>
                                                <td width="130px">Berhenti Sejak</td>
                                                <td width="10px">: </td>
                                                <td width="200px"><strong>'.$berhentisejak.'</strong></td>    
                                                <td width="200px" align="left"></td>
                                            </tr>
                            
                                        </tbody>
                                    </table>
                            
                                    <table border="0">
                                        <tbody>
                                            <tr>
                                                <td width="580px"></td>
                                            </tr>
                                            <tr>
                                                <td width="580px">Mohon untuk dibayarkan Manfaat Pensiun saya, sesuai dengan ketentuan Dana Pensiun Astra melalui rekening berikut: </td>
                                            </tr>
                                        </tbody>
                                    </table>
                            
                                    <table border="0">
                                        <tbody>
                            
                                            <tr>
                                                <td width="130px">Nomor Rekening</td>
                                                <td width="10px">: </td>
                                                <td width="200px"><strong>'.$norek.'</strong></td>    
                                                <td width="200px"></td>
                                            </tr>
                            
                                            <tr>
                                                <td width="130px">Nama Pemilik Rekening</td>
                                                <td width="10px">: </td>
                                                <td width="200px"><strong>'.$anrek.'</strong></td>    
                                                <td width="200px"></td>
                                            </tr>
                            
                                            <tr>
                                                <td width="130px">Nama Bank</td>
                                                <td width="10px">: </td>
                                                <td width="200px"><strong>'.$namabank.'</strong></td>    
                                                <td width="200px" align="left">Cabang : <strong>'.$namacabang.'</strong></td>
                                            </tr>
                            
                                        </tbody>
                                    </table>
                            
                                    <table border="0">
                                        <tbody>
                                            <tr>
                                                <td width="550px"></td>
                                            </tr>
                                            <tr>
                                                <td width="550px">Jika masa kepesertaan lebih dari 3 tahun dan saat ini belum mencapai usia 45 tahun, mohon Manfaat Pensiun saya dialihkan ke: </td>
                                            </tr>
                                            <tr>
                                                <td width="550px">DPLK* : <strong>'.$dplk.'</strong></td>
                                            </tr>
                                            <tr>
                                                <td width="550px">(Bagi Peserta DPA 2 yang memiliki masa kepesertaan lebih dari 3 tahun dan telah mencapai usia 45 tahun, serta 80% Manfaat Pensiun melebihi Rp. 500.000.000, maka mengisi pilihan di bawah ini)</td>
                                            </tr>
                                            <tr>
                                                <td width="550px">Saya mohon 80% dari Manfaat Pensiun saya dibelikan produk Anuitas pilihan saya dari perusahaan Asuransi Jiwa sebagai berikut:</td>
                                            </tr>
                                            <tr>
                                                <td width="550px">Asuransi Jiwa* : <strong>'.$asuransijiwa.'</strong></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    
                                    <table border="0">
                                        <tbody>
                                            <tr>
                                                <td width="550px"></td>
                                            </tr>
                                            <tr>
                                                <td width="550px" align="right"> ................... , '.$date.'</td>
                                            </tr>
                                        </tbody>
                                    </table>
                            
                                    <table border="0">
                                        <tbody>
                                            <tr>
                                                <td width="200px" align="center">Pemohon</td>
                                                <td width="150px"> </td>
                                                <td width="200px" align="center">Mengetahui</td>    
                                            </tr>
                                            <tr>
                                                <td height="50px" align="center"></td>
                                                <td height="50px"> </td>
                                                <td height="50px" align="center"></td>    
                                            </tr>
                                            <tr>
                                                <td width="200px" align="center"><strong>'.$namapemohon.'</strong></td>
                                                <td width="150px"> </td>
                                                <td width="200px" align="center">Tanda Tangan dan Cap Perusahaan</td>   
                                            </tr>
                                            
                                            <tr>
                                                <td width="200px" align="center"><font size="6">Nama Jelas dan Tanda Tangan</font></td>
                                                <td width="150px"> </td>
                                                <td width="200px" align="center"><font size="6">Tidak perlu tanda tangan HRD jika sudah tidak bekerja di perusahaan</font></td>   
                                            </tr>
                                        </tbody>
                                    </table>
                            
                                    <table border="0">
                                        <tbody>
                                            <tr>
                                                <td width="550px"></td>
                                            </tr>
                                            <tr>
                                                <td width="550px" align="left"><font size="7">*) Informasi tentang DPLK dan Asuransi Jiwa yang ada dalam daftar OJK (Otoritas Jasa Keuangan) dapat dilihat pada web www.dapenastra.com</font></td>
                                            </tr>
                                        </tbody>
                                    </table>
                            
                            </td>

                        </tr>
                    </tbody>
                </table>
                    
                </div>

                
                
            </div>

        ';

        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->lastPage();
        $namafileoutput = "formklaim_".$kdpesertaklaim.".pdf";
        $resultPDF = $pdf->Output($namafileoutput, 'D');
        echo $resultPDF;

        }
    catch(Exception $e)
    {
        log_message( 'error', $e->getMessage() . ' in '.$e->getFile() . ' : '.$e->getLine());
        throw new Exception('Something really gone wrong',0,$e);
    }   
   
    
    }

   


    function getMessage($KdFormKlaimEncryp)
	{
        $message =  
            '<!doctype html>
            <html>
            <head>
                <meta name="viewport" content="width=device-width" />
                <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
                <title>Form Klaim</title>
                <style type="text/css">
    .form-style-2{
        max-width: 500px;
        padding: 20px 12px 10px 20px;
        font: 13px Arial, Helvetica, sans-serif;
    }
    .form-style-2-heading{
        font-weight: bold;
        font-style: italic;
        border-bottom: 2px solid #ddd;
        margin-bottom: 20px;
        font-size: 15px;
        padding-bottom: 3px;
    }
    .form-style-2 label{
        display: block;
        margin: 0px 0px 15px 0px;
    }
    .form-style-2 label > span{
        width: 100px;
        font-weight: bold;
        float: left;
        padding-top: 8px;
        padding-right: 5px;
    }
    .form-style-2 span.required{
        color:red;
    }
    .form-style-2 .tel-number-field{
        width: 40px;
        text-align: center;
    }
    .form-style-2 input.input-field, .form-style-2 .select-field{
        width: 48%; 
    }
    .form-style-2 input.input-field, 
    .form-style-2 .tel-number-field, 
    .form-style-2 .textarea-field, 
     .form-style-2 .select-field{
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        border: 1px solid #C2C2C2;
        box-shadow: 1px 1px 4px #EBEBEB;
        -moz-box-shadow: 1px 1px 4px #EBEBEB;
        -webkit-box-shadow: 1px 1px 4px #EBEBEB;
        border-radius: 3px;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        padding: 7px;
        outline: none;
    }
    .form-style-2 .input-field:focus, 
    .form-style-2 .tel-number-field:focus, 
    .form-style-2 .textarea-field:focus,  
    .form-style-2 .select-field:focus{
        border: 1px solid #0C0;
    }
    .form-style-2 .textarea-field{
        height:100px;
        width: 55%;
    }
    .form-style-2 input[type=submit],
    .form-style-2 input[type=button]{
        border: none;
        padding: 8px 15px 8px 15px;
        background: #FF8500;
        color: #fff;
        box-shadow: 1px 1px 4px #DADADA;
        -moz-box-shadow: 1px 1px 4px #DADADA;
        -webkit-box-shadow: 1px 1px 4px #DADADA;
        border-radius: 3px;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
    }
    .form-style-2 input[type=submit]:hover,
    .form-style-2 input[type=button]:hover{
        background: #EA7B00;
        color: #fff;
    }
    </style>
                <style>
                /* -------------------------------------
                    GLOBAL RESETS
                ------------------------------------- */
                img {
                    border: none;
                    -ms-interpolation-mode: bicubic;
                    max-width: 100%; }
                body {
                    background-color: #f6f6f6;
                    font-family: sans-serif;
                    -webkit-font-smoothing: antialiased;
                    font-size: 14px;
                    line-height: 1.4;
                    margin: 0;
                    padding: 0;
                    -ms-text-size-adjust: 100%;
                    -webkit-text-size-adjust: 100%; }
                table {
                    border-collapse: separate;
                    mso-table-lspace: 0pt;
                    mso-table-rspace: 0pt;
                    width: 100%; }
                    table td {
                    font-family: sans-serif;
                    font-size: 14px;
                    vertical-align: top; }
                /* -------------------------------------
                    BODY & CONTAINER
                ------------------------------------- */
                .body {
                    background-color: #f6f6f6;
                    width: 100%; }
                /* Set a max-width, and make it display as block so it will automatically stretch to that width, but will also shrink down on a phone or something */
                .container {
                    display: block;
                    Margin: 0 auto !important;
                    /* makes it centered */
                    max-width: 580px;
                    padding: 10px;
                    width: 580px; }
                /* This should also be a block element, so that it will fill 100% of the .container */
                .content {
                    box-sizing: border-box;
                    display: block;
                    Margin: 0 auto;
                    max-width: 580px;
                    padding: 10px; }
                /* -------------------------------------
                    HEADER, FOOTER, MAIN
                ------------------------------------- */
                .main {
                    background: #ffffff;
                    border-radius: 3px;
                    width: 100%; }
                .wrapper {
                    box-sizing: border-box;
                    padding: 20px; }
                .content-block {
                    padding-bottom: 10px;
                    padding-top: 10px;
                }
                .footer {
                    clear: both;
                    Margin-top: 10px;
                    text-align: center;
                    width: 100%; }
                    .footer td,
                    .footer p,
                    .footer span,
                    .footer a {
                    color: #999999;
                    font-size: 12px;
                    text-align: center; }
                /* -------------------------------------
                    TYPOGRAPHY
                ------------------------------------- */
                h1,
                h2,
                h3,
                h4 {
                    color: #000000;
                    font-family: sans-serif;
                    font-weight: 400;
                    line-height: 1.4;
                    margin: 0;
                    Margin-bottom: 30px; }
                h1 {
                    font-size: 35px;
                    font-weight: 300;
                    text-align: center;
                    text-transform: capitalize; }
                p,
                ul,
                ol {
                    font-family: sans-serif;
                    font-size: 14px;
                    font-weight: normal;
                    margin: 0;
                    Margin-bottom: 15px; }
                    p li,
                    ul li,
                    ol li {
                    list-style-position: inside;
                    margin-left: 5px; }
                a {
                    color: #3498db;
                    text-decoration: underline; }
                /* -------------------------------------
                    BUTTONS
                ------------------------------------- */
                .btn {
                    box-sizing: border-box;
                    width: 100%; }
                    .btn > tbody > tr > td {
                    padding-bottom: 15px; }
                    .btn table {
                    width: auto; }
                    .btn table td {
                    background-color: #ffffff;
                    border-radius: 5px;
                    text-align: center; }
                    .btn a {
                    background-color: #ffffff;
                    border: solid 1px #3498db;
                    border-radius: 5px;
                    box-sizing: border-box;
                    color: #3498db;
                    cursor: pointer;
                    display: inline-block;
                    font-size: 14px;
                    font-weight: bold;
                    margin: 0;
                    padding: 12px 25px;
                    text-decoration: none;
                    text-transform: capitalize; }
                .btn-primary table td {
                    background-color: #3498db; }
                .btn-primary a {
                    background-color: #3498db;
                    border-color: #3498db;
                    color: #ffffff; }
                /* -------------------------------------
                    OTHER STYLES THAT MIGHT BE USEFUL
                ------------------------------------- */
                .last {
                    margin-bottom: 0; }
                .first {
                    margin-top: 0; }
                .align-center {
                    text-align: center; }
                .align-right {
                    text-align: right; }
                .align-left {
                    text-align: left; }
                .clear {
                    clear: both; }
                .mt0 {
                    margin-top: 0; }
                .mb0 {
                    margin-bottom: 0; }
                .preheader {
                    color: transparent;
                    display: none;
                    height: 0;
                    max-height: 0;
                    max-width: 0;
                    opacity: 0;
                    overflow: hidden;
                    mso-hide: all;
                    visibility: hidden;
                    width: 0; }
                .powered-by a {
                    text-decoration: none; }
                hr {
                    border: 0;
                    border-bottom: 1px solid #f6f6f6;
                    Margin: 20px 0; }
                /* -------------------------------------
                    RESPONSIVE AND MOBILE FRIENDLY STYLES
                ------------------------------------- */
                @media only screen and (max-width: 620px) {
                    table[class=body] h1 {
                    font-size: 28px !important;
                    margin-bottom: 10px !important; }
                    table[class=body] p,
                    table[class=body] ul,
                    table[class=body] ol,
                    table[class=body] td,
                    table[class=body] span,
                    table[class=body] a {
                    font-size: 16px !important; }
                    table[class=body] .wrapper,
                    table[class=body] .article {
                    padding: 10px !important; }
                    table[class=body] .content {
                    padding: 0 !important; }
                    table[class=body] .container {
                    padding: 0 !important;
                    width: 100% !important; }
                    table[class=body] .main {
                    border-left-width: 0 !important;
                    border-radius: 0 !important;
                    border-right-width: 0 !important; }
                    table[class=body] .btn table {
                    width: 100% !important; }
                    table[class=body] .btn a {
                    width: 100% !important; }
                    table[class=body] .img-responsive {
                    height: auto !important;
                    max-width: 100% !important;
                    width: auto !important; }}
                /* -------------------------------------
                    PRESERVE THESE STYLES IN THE HEAD
                ------------------------------------- */
                @media all {
                    .ExternalClass {
                    width: 100%; }
                    .ExternalClass,
                    .ExternalClass p,
                    .ExternalClass span,
                    .ExternalClass font,
                    .ExternalClass td,
                    .ExternalClass div {
                    line-height: 100%; }
                    .apple-link a {
                    color: inherit !important;
                    font-family: inherit !important;
                    font-size: inherit !important;
                    font-weight: inherit !important;
                    line-height: inherit !important;
                    text-decoration: none !important; }
                    .btn-primary table td:hover {
                    background-color: #34495e !important; }
                    .btn-primary a:hover {
                    background-color: #34495e !important;
                    border-color: #34495e !important; } }
                </style>
            </head>
            <body class="">
                <table border="0" cellpadding="0" cellspacing="0" class="body">
                <tr>
                    <td>&nbsp;</td>
                    <td class="container">
                    <div class="content">
    
                        <!-- START CENTERED WHITE CONTAINER -->
                        <span class="preheader">Form Klaim</span>
                        <table class="main">
    
                        <!-- START MAIN CONTENT AREA -->
                        <tr>
                            <td class="wrapper">
                            <table border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                <td>
                                    <p>Silahkan unduh Form Klaim anda dengan meng-klik tombol dibawah ini.</p>
                                    <table border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">
                                    <tbody>
                                        <tr>
                                        <td align="left">
                                            <table border="0" cellpadding="0" cellspacing="0">
                                            <tbody>
                                                <tr>
                                                <td> <a href="'.base_url().'index.php/PdfGenerator/PdfFormKlaim?UZUMYMW='.$KdFormKlaimEncryp.'&MYNDAIL=Ndsnov" target="_blank">Download Form</a> </td>
                                                </tr>
                                            </tbody>
                                            </table>
                                        </td>
                                        </tr>
                                    </tbody>
                                    </table>
                                    
                                    <p>Terima Kasih.</p>
                                </td>
                                </tr>
                            </table>
                            </td>
                        </tr>
    
                        <!-- END MAIN CONTENT AREA -->
                        </table>
    
                        <!-- START FOOTER -->
                        <div class="footer">
                        <table border="0" cellpadding="0" cellspacing="0">
                            <tr>
                            <td class="content-block">
                            </td>
                            </tr>
                            <tr>
                            <td class="content-block powered-by">
                            &copy;Dana Pensiun Astra Mobile Apps
                            </td>
                            </tr>
                        </table>
                        </div>
                        <!-- END FOOTER -->
    
                    <!-- END CENTERED WHITE CONTAINER -->
                    </div>
                    </td>
                    <td>&nbsp;</td>
                </tr>
                </table>
            </body>
            
    
            </html>  
        ';
        return $message;
	}
}

?>