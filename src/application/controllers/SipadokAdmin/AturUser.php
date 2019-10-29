<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class AturUser extends CI_Controller {

    var $usernameLogin;
    
    function __construct()
    {
        parent::__construct();
        // $this->load->model('User','',TRUE);
        $this->load->model('SipadokUser_Model','',TRUE);
        //$this->load->library('grocery_crud');
        $this->load->library('Grocery_CRUD');   
        $this->load->library('email');
    }
 
    public function index()
    {		
		if($this->session->userdata('logged_in')){
            //Check apakah nama menu ini dapat diakses oleh user yang login
			if(page_check_authorized('Atur User'))
			{
				$session_data = $this->session->userdata('logged_in');
				$this->usernameLogin = $session_data['username'];
                $this->_aturuser();
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

    public function _aturuser()
    {
		$crud = new grocery_CRUD();
		$crud->set_subject('User');
        $crud->set_table('sipadok_user');
        
        $crud->where('sipadok_user.Deleted','0');
        //$crud->where('digi_kategoripromosi.CreatedBy',$this->usernameLogin);
        //$crud->set_relation('Parent','menu','MenuName',array('deleted' => '0'));
        $crud->unset_clone();
        //$crud->unset_read();
        $crud->set_relation('KdDept','tokped_department','NamaDept',array('Deleted' => '0'));
        $crud->set_relation('KdRole','sipadok_role','NamaRole',array('Deleted' => '0'));
        

		//Kolom yang ditampilkan
        $crud->columns(
            'NIK',
            'NamaUser',
            'JenisKelamin',
            'EmailPribadi',
            'EmailKantor',
            'NoHP',
            'KdDept',
            'KdRole'
        );
        //$this->grocery_crud->fields('Username','NamaUser','Psswd','NIP','KodeMitra','EmailPribadi','EmailKantor','CreatedBy','CreatedOn');
        $crud->add_fields(
            'NIK',
            'NamaUser',
            'JenisKelamin',
            'TglLahir',
            'TglPegawai',
            'EmailPribadi',
            'EmailKantor',
            'NoHP',
            'KdDept',
            'KdRole',
            'Pswd',
            'PswdDefault'
        );//Fields untuk menambahkan data baru
        $crud->edit_fields(
            // 'NIK',
            'NamaUser',
            'JenisKelamin',
            'TglLahir',
            'TglPegawai',
            'KdRole',
            'KdDept',
            'EmailPribadi',
            'EmailKantor',
            'NoHP'
        );
        $crud->field_type('Pswd','invisible');
        $crud->field_type('PswdDefault','invisible');
      
        $crud->display_as('NIK','Nomor Induk Karyawan');
        $crud->display_as('NamaUser','Nama User');
        $crud->display_as('TglLahir','Tanggal Lahir');
        $crud->display_as('TglPegawai','Tanggal Mulai Bekerja');
        $crud->display_as('KdDept','Nama Divisi');
        $crud->display_as('EmailPribadi','Email Pribadi');
        $crud->display_as('EmailKantor','Email Kantor');
        $crud->display_as('NoHP','Nomor Handphone');
        $crud->display_as('KdRole','Role');

        $crud->add_action('Reset password', '', 'mrisAdminDPA/AturUserAdmin/reset_password','glyphicon glyphicon-send');

        //Atur rule
        $crud->set_rules('NIK','Nomor Induk Karyawan','trim|required|min_length[1]|max_length[50]|is_unique[sipadok_user.NIK]');
        $crud->set_rules('NamaUser','Nama User','trim|required|min_length[1]|max_length[190]');
        $crud->set_rules('EmailPribadi','Email Pribadi','trim|required|min_length[1]|max_length[255]|valid_email');
        $crud->set_rules('EmailKantor','Email Kantor','trim|required|min_length[1]|max_length[255]|valid_email');
        $crud->set_rules('KdDept','Nama Divisi','trim|required');
        $crud->set_rules('KdRole','Role','trim|required');
        $crud->set_rules('NoHP','Nomor Handphone','trim|required|numeric');

        $crud->set_read_fields(
            'NIK',
            'NamaUser',
            'JenisKelamin',
            'TglLahir',
            'TglPegawai',
            'KdDept',
            'KdRole',
            'EmailPribadi',
            'EmailKantor',
            'NoHP'
        );

        $crud->field_type('JenisKelamin','dropdown',array(
            'l' => 'LAKI - LAKI', 
            'p' => 'PEREMPUAN'
            )
        );
        // $result = $this->User->getRole();
        // $list = array();
        // foreach($result as $dt)
        // {
        //     $list[$dt->KdRole] = $dt->NamaRole;

        // }
        

        // $crud->field_type('Role','dropdown',$list);
        $crud->callback_before_insert(array($this,'_before_insert_user'));
        $crud->callback_before_update(array($this,'_before_update_user'));

        $crud->callback_after_insert(array($this,'_after_insert_user'));
        $crud->callback_after_update(array($this,'_after_update_user'));
        
		$crud->callback_delete(array($this,'_delete_user'));
        $crud->unset_texteditor('Description','Url');                 
		
        $output = $crud->render();
        // $output->output.=$js;
        $this-> _outputview($output);        
    }

    function _outputview($output = null)
    {
		
		$data = array(
                //'title' => 'Pengaturan Menu',
                'title' => 'Pengaturan User',
			   'body' => $output
		  );
		$this->load->helper(array('form','url'));
        //$this->template_lib->load('default','content/promotion/promotion_data_view',$data);
        $this->template_lib->load('default','content/sipadokadmin/aturuser_view',$data);
    }

    function _before_insert_user($post_array) 
	{
        $arr_insert['NIK'] = $post_array['NIK'];
        $arr_insert['NamaUser'] = strtoupper($post_array['NamaUser']);
        $arr_insert['JenisKelamin'] = $post_array['JenisKelamin'];
        $arr_insert['TglLahir'] = $post_array['TglLahir'];
        $arr_insert['TglPegawai'] = $post_array['TglPegawai'];
        $arr_insert['EmailKantor'] = $post_array['EmailKantor'];
        $arr_insert['EmailPribadi'] = $post_array['EmailPribadi'];
        $arr_insert['NoHP'] = $post_array['NoHP'];
        $arr_insert['KdDept'] = $post_array['KdDept'];
        $arr_insert['KdRole'] = $post_array['KdRole'];

        // print("arr_insert[KdRole] : ".$arr_insert['KdRole']." | post_array[Role]".$post_array['Role']." | ");

        $result = $this->SipadokUser_Model->getRoleName($post_array['KdRole']);
        foreach($result as $dt)
        {
            $RoleName = $dt->NamaRole;
        }

        // print("RoleName : ".$RoleName." | ");
        // print_r($arr_insert);

        $pass = $this->generateRandomString();
        $arr_insert['Pswd'] = md5($pass);
        $arr_insert['PswdDefault'] = md5($pass);

        //$insert_to_userrole = $this->User->setRole($arr_insert['Username'],$post_array['Role'],$this->usernameLogin,$this->getTime());
        $insert_to_userrole = $this->SipadokUser_Model->setRole($arr_insert['NIK'],$post_array['KdRole'],$this->usernameLogin,$this->getTime());
        
        // Bagian send email untuk kirim password default
        // $this->sendMail(
        //     "[SIPADOK TOKOPEDIA] Pembuatan User ".$RoleName, 
        //     $this->getMessageInsert($arr_insert['NamaUser'], $arr_insert['Username'],$RoleName ,$pass),
        //     $post_array['EmailKantor'],
        //     $post_array['EmailPribadi']);

        return $arr_insert;
    }

    function _after_insert_user($post_array,$primary_key)
	{
        $KdRole = '';
        $KdRole = $post_array['KdRole'];
        $KdRoleInt = (int)$KdRole;
        $updateData = array (
			'CreatedBy' => $this->usernameLogin,
            'CreatedOn' => $this->getTime(),
            'KdRole' => $KdRoleInt
        );

		$this->db->update('sipadok_user',$updateData,array('NIK'=>$post_array['NIK']));

    }

    function _before_update_user($post_array,$primary_key) 
	{
        $arr_insert['NIK'] = $primary_key;
        $arr_insert['NamaUser'] = strtoupper($post_array['NamaUser']);
        $arr_insert['JenisKelamin'] = $post_array['JenisKelamin'];
        $arr_insert['TglLahir'] = $post_array['TglLahir'];
        $arr_insert['TglPegawai'] = $post_array['TglPegawai'];
        $arr_insert['EmailKantor'] = $post_array['EmailKantor'];
        $arr_insert['EmailPribadi'] = $post_array['EmailPribadi'];
        $arr_insert['NoHP'] = $post_array['NoHP'];
        $arr_insert['KdDept'] = $post_array['KdDept'];
        $arr_insert['KdRole'] = $post_array['KdRole'];

        print(" || Post Array : ");
        print_r($post_array);
        print(" || ");

        print(" || arr insert : ");
        print_r($arr_insert);
        print(" || ");

        //$insert_to_userrole = $this->User->setUpdateRole($post_array['Role'],$this->usernameLogin,$this->getTime(),$primary_key);
        $update_to_userrole = $this->SipadokUser_Model->setUpdateRole($post_array['KdRole'],$this->usernameLogin,$this->getTime(),$primary_key);

        // Kirim email
        // $this->sendMail(
        //     "[MRIS DPA] Perubahan Data User ".$RoleName, 
        //     $this->getMessageUpdate(
        //         $arr_insert['NamaUser'], 
        //         $arr_insert['Username'],
        //         $this->getTime(),
        //         $arr_insert['NIP'],
        //         $namamitra,
        //         $arr_insert['EmailPribadi'],
        //         $arr_insert['EmailKantor'],
        //         $arr_insert['NoHP'],
        //         $this->usernameLogin),
        //         $post_array['EmailKantor'],
        //         $post_array['EmailPribadi']);

        return $arr_insert;
    }

    function _after_update_user($post_array,$primary_key)
	{
        $KdRole = '';
        $KdRole = $post_array['KdRole'];
        $KdRoleInt = (int)$KdRole;
        $updateData = array (
			'UpdatedBy' => $this->usernameLogin,
            'UpdatedOn' => $this->getTime(),
            'KdRole' => $KdRoleInt
        );

		return $this->db->update('sipadok_user',$updateData,array('NIK'=>$post_array['NIK']));

    }

    function reset_password($username = null)
    {		
       
        $pass = $this->generateRandomString();
        $reset = $this->User->reset_password($username,md5($pass));

        if( $reset )
        {
            $result = $this->User->getRoleFromUsername($username);
            foreach($result as $dt)
            {
                $RoleName = $dt->NamaRole;
                $name = $dt->NamaUser;
                $username = $dt->Username;
                //$email = $dt->EmailKantor;
                $emailkantor = $dt->EmailKantor;
                $emailpribadi = $dt->EmailPribadi;
            }

            if($result)
            {
                //$this->sendMail("Reset Password User".$RoleName,$this->getMessageReset($name, $RoleName ,$pass),$email);
                $this->sendMail("[MRIS] Reset Password User ".$RoleName,$this->getMessageReset($name, $username,$RoleName ,$pass),$emailkantor,$emailpribadi);
            }
            //redirect('AdminDPA/atur_user');
            redirect(base_url('index.php/mrisAdminDPA/AturUserAdmin'));
        }
        
    }
	               
	function _delete_user($primary_key){
               $this->db->update('mris_userrole',array('Deleted' => '1','UpdatedBy'=>$this->usernameLogin,'UpdatedOn'=>$this->getTime()),array('Username' => $primary_key));
        return $this->db->update('mris_user',array('Deleted' => '1','UpdatedBy'=>$this->usernameLogin,'UpdatedOn'=>$this->getTime()),array('Username' => $primary_key));
	}
    
    function getTime()
	{
		$timezone  = 7;
		return gmdate("Y/m/j H:i:s", time() + 3600*($timezone+date("I"))); 
    }
    
    function generateRandomString($length = 7) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    function sendMail($subject,$message,$emailkantor, $emailpribadi)
	{
        $recipientArr = array($emailkantor, $emailpribadi);
		
		$this->email->from('NOREPLY@DAPENASTRA.COM', 'Dana Pensiun Astra');
        //$this->email->to($email);
        $this->email->to($recipientArr);
		$this->email->subject($subject);
        $this->email->message($message);
        
		
		if($this->email->send())
		{
            echo "Sended";
        }

        return true;
    }	

    function getMessageInsert($name,$username,$role,$kode)
	{
        $message = 
        '<!doctype html>
        <html>
        <head>
            <meta name="viewport" content="width=device-width" />
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
            <title>Simple Transactional Email</title>
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
                    <span class="preheader">Verification Email.</span>
                    <table class="main">

                    <!-- START MAIN CONTENT AREA -->
                    <tr>
                        <td class="wrapper">
                        <table border="0" cellpadding="0" cellspacing="0">
                            <tr>
                            <td>
                                <p>Hai '.$name.', selamat bergabung dalam Mitra Relation Integrated System DPA.</p>
                                <p>Berikut adalah username dan password default anda sebagai '.$role.'.</p>
                                <p>Username = <b>'.$username.'</b><p>
                                <p>Password = <b>'.$kode.'</b><p>
                                <p>Gunakan password diatas untuk login pertama kali dan Silahkan lakukan perubahan password untuk menjaga keamanan akun anda</p>
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

    function getMessageUpdate(
        $namauser,
        $username,
        $updateon,
        $nipuser,
        $namamitrauser,
        $emailpribadiuser,
        $emailkantoruser,
        $nohpuser,
        $namaatasan
        )
	{
        $message = 
        '<!doctype html>
        <html>
        <head>
            <meta name="viewport" content="width=device-width" />
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
            <title>Simple Transactional Email</title>
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
                    <span class="preheader">Verification Email.</span>
                    <table class="main">

                    <!-- START MAIN CONTENT AREA -->
                    <tr>
                        <td class="wrapper">
                        <table border="0" cellpadding="0" cellspacing="0">
                            <tr>
                            <td>
                                <p>Hai '.$namauser.', data anda telah diubah pada '.$updateon.'.</p>
                                <p>Berikut adalah data baru anda</p>
                                <p>Username         = <b>'.$username.'</b><p>
                                <p>Nama Lengkap     = <b>'.$namauser.'</b><p>
                                <p>NIP              = <b>'.$nipuser.'</b><p>
                                <p>Nama Perusahaan  = <b>'.$namamitrauser.'</b><p>
                                <p>Email Pribadi    = <b>'.$emailpribadiuser.'</b><p>
                                <p>Email Kantor     = <b>'.$emailkantoruser.'</b><p>
                                <p>Nomor HP         = <b>'.$nohpuser.'</b><p>
                                <p>Apabila data tersebut terdapat ketidaksesuaian, mohon untuk dapat menghubungi Bp/Ibu '.$namaatasan.' agar dapat dilakukan perbaikan.</p>
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

    function getMessageReset($name,$username,$role,$kode)
	{
        $message = 
        '<!doctype html>
        <html>
        <head>
            <meta name="viewport" content="width=device-width" />
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
            <title>Simple Transactional Email</title>
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
                    <span class="preheader">Verification Email.</span>
                    <table class="main">

                    <!-- START MAIN CONTENT AREA -->
                    <tr>
                        <td class="wrapper">
                        <table border="0" cellpadding="0" cellspacing="0">
                            <tr>
                            <td>
                                <p>Hai '.$name.', Password anda telah di-reset</p>
                                <p>Berikut adalah username dan password default anda sebagai '.$role.'.</p>
                                <h2><b>Username = '.$username.'</b><h2>
                                <h2><b>Password = '.$kode.'</b><h2>
                                <p>Gunakan password diatas untuk kembali login dan Silahkan lakukan perubahan password untuk menjaga keamanan akun anda</p>
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

/* End of file main.php */
/* Location: ./application/controllers/main.php */