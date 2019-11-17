<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class VerifyLogin extends CI_Controller {

    function __construct()
    {
      parent::__construct();
    //   $this->load->model('User','',TRUE);
    //   $this->load->model('SipadokUser_Model','',TRUE);
    //   $this->load->model('Kode_Model');
    //   $this->load->model('SipadokKode_Model');
      $this->load->model('SipadokLogLogin_Model');
      $this->load->model('Sisantuy_Register_Model');
      $this->load->model('SisantuyUser_Model');
      $this->load->model('Sisantuy_KodeGenerator_Model');
    }

	public function index()
	{
        $this->load->library('form_validation');

        $this->form_validation->set_rules('username', 'Username', 'required');
        // $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required|callback_check_database');
        
        $username = $this->input->post('username');

        
        $urlTujuan = $this->input->post('url');
        // print(" | URL tujuan = ".$urlTujuan." | ");
        if($urlTujuan == ''){
           $urlTujuan = 'home';
        }
        // print(" | URL tujuan = ".$urlTujuan." | ");
        // die();
        // print(base_url());
        // die();

        if($this->form_validation->run() == false){
            //Field validation failed.  User redirected to login page
            $data = array(
                'urlTujuan' => $urlTujuan
            );
            $this->load->view('login_view',$data);
        }
        else
        {
            // $this->load->view('home_view');

            $this->saveLog($username);
            //redirect('home');
            
            //Edited by GGW
            // redirect($urlTujuan, 'refresh');
            redirect(base_url('index.php/'.$urlTujuan)); 
        }
    }

    function check_database($password)
    {
        $username = $this->input->post('username');
        // $email = $this->input->post('email');
        
        $result = $this->SisantuyUser_Model->login($username, $password);
        // var_dump($result);
        // die();
        $change_password = $this->SisantuyUser_Model->check_default_password($username, $password);

        if($change_password){
            $pass = "";
            $pass_default = "";

            foreach($change_password as $row){
                $pass = $row->PSSWD;
                $pass_default = $row->PSSWD_DEFAULT;
            }

            // print(" Password Default = ".$pass);
            // print(" Password = ".$pass_default);

            if($pass == $pass_default){
                redirect(base_url('index.php/Change_Password'));
            }

            else
            {
                if($result){
                $sess_array = array();
                    foreach($result as $row)
                    {
                    
                    $sess_array = array(
                        'username' => $row->USERNAME,
                        'nama' => $row->NAMA,
                        'email' => $row->EMAIL,
                        'no_hp' => $row->NO_HP
                    );
                    }
                     $this->session->set_userdata('logged_in', $sess_array);
                     return true;
                }
                else
                {
                    $this->form_validation->set_message('check_database', 'Invalid Username or password!');
                    return false;
                }
            }
        }else{
                    $this->form_validation->set_message('check_database', 'Invalid Username or password!');
                    return false;
        }
    }

    // function purpose = Untuk ganti password
    function change_password()
    {
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('username', 'Username', 'required');
        // $this->form_validation->set_rules('old_password', 'Password', 'required|callback_check_old_password');
        $this->form_validation->set_rules('old_password', 'Old Password', 'required');
        $this->form_validation->set_rules('new_password', 'New Password', 'required');
        $this->form_validation->set_rules('renew_password', 'Re-New Password', 'required');

        $username = $this->input->post('username');
        $old_password = $this->input->post('old_password');
        $new_password = $this->input->post('new_password');
        $renew_password = $this->input->post('renew_password');

        $this->check_old_password($username,$old_password,$new_password,$renew_password);

        if($this->form_validation->run() == false)
        {
            $this->load->view('change_password_view');
        }
        else
        {
            //redirect('login');
            //redirect('login');
            redirect(base_url('index.php/login'));
        }
    }

    // function purpose = Untuk checking password lama
    function check_old_password($username,$old_password,$new_password,$renew_password)
    {
        // Jika new_password == renew_password
        if($new_password == $renew_password){
            $result = $this->SisantuyUser_Model->login($username, $old_password);
            if($result){
                $update_password = $this->SisantuyUser_Model->update_password($username, $new_password);
                if( $update_password ){
                    return true;
                }else{
                    $this->form_validation->set_message('check_old_password', 'Error change password');
                    return false;
                }
            }else{
                $this->form_validation->set_message('check_old_password', 'Invalid Username or password!');
                return false;
            }

        }else{
            $this->form_validation->set_message('check_old_password', 'Your new password does not match!');
            return false;
        }

    }
	
	function forgot_password()
	{		
		$this->load->library('form_validation');
        $this->form_validation->set_rules('email', 'Email', 'required');
		
		$email = $this->input->post('email');
		$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';		
		$new_password = substr(str_shuffle($permitted_chars), 0, 8);
		
		$check_email = $this->SipadokUser_Model->check_email($email);
		foreach($check_email as $counter)
		{
			$jmlEmail = $counter->jumlahEml;
		}
		
		if(($jmlEmail) and ($jmlEmail > 0))
		{
			$update_password = $this->SipadokUser_Model->update_password($email, $new_password);
		
			if( $update_password )
			{
				$subject = 'Reset Password SIPADOK';
				$message = 'Dear SIPADOK user, <br><br>
							Berikut adalah password SIPADOK anda <strong>'.$new_password.'</strong> <br>
							Segera ubah password anda untuk keamanan. <br>
							Regards, <br><br><br>
							Admin SIPADOK';
				$to = $email;
				$listCC = array();
				//$listCC = array('majestyeksa@gmail.com', 'anggitsuryagumilang@gmail.com');
				if($this->sendEmail($subject, $message, $to, $listCC))
				{
					$message = "Cek email untuk mendapatkan password baru anda.";
                echo "<script LANGUAGE='JavaScript'>
                    window.alert('$message');
                    window.location.href='".base_url()."';
                    </script>";
					return true;
				}
				else
				{
					$message = "Gagal mengirim email, silahkan coba beberapa saat lagi.";
                echo "<script LANGUAGE='JavaScript'>
                    window.alert('$message');
                    window.location.href='".base_url()."';
                    </script>";
					return false;
				}
			}
			else
			{
				$message = "Gagal update data password, silahkan coba beberapa saat lagi.";
                echo "<script LANGUAGE='JavaScript'>
                    window.alert('$message');
                    window.location.href='".base_url()."';
                    </script>";
				return false;
			}
		}
		else
		{
			$message = "Maaf, email anda tidak terdaftar.";
                echo "<script LANGUAGE='JavaScript'>
                    window.alert('$message');
                    window.location.href='".base_url()."';
                    </script>";
			return false;
		}
    }
    
    // function purpose = Menambahkan user baru
    function createUser(){
        // Ambil nilai dari view
        $username = $this->input->post('username');
        $nama = $this->input->post('nama');
        $jenis_kelamin = $this->input->post('jenis_kelamin');
        $no_hp = $this->input->post('no_hp');
        $email = $this->input->post('email');
        $d_lahir = $this->input->post('d_lahir');
        $m_lahir = $this->input->post('m_lahir');
        $y_lahir = $this->input->post('y_lahir');
        $role = $this->input->post('role');
        $password = $this->input->post('password');
        $repassword = $this->input->post('repassword');

        // Data diolah untuk dipersiapkan di save
        $tgl_lahir = $y_lahir."-".$m_lahir."-".$d_lahir;
        $created_by = $username;

        // Periksa apakah username sudah pernah ada dalam database atau belum
        $username_on_db = "";
        $checkusername = $this->Sisantuy_Register_Model->checkUsernameExist($username);
        foreach ($checkusername as $data) {
            $username_on_db = $data->USERNAME;
        }
        // Jika username sudah pernah ada di db
        if($username == $username_on_db){
            $message = "Maaf, Username sudah dipakai.";
            echo "<script LANGUAGE='JavaScript'>
                window.alert('$message');
                window.location.href='" . base_url() . "index.php/Register';
                </script>";
        }

        // Jika password dan re-password berbeda
        if($password != $repassword){
            $message = "Maaf, password dan re-password berbeda.";
            echo "<script LANGUAGE='JavaScript'>
                window.alert('$message');
                window.location.href='" . base_url() . "index.php/Register';
                </script>";
        }
        
        // Jika semua baik-baik saja, maka save data ke database
        $insertUser = $this->Sisantuy_Register_Model->insertUser(
            $username,
            $nama,
            $jenis_kelamin,
            $no_hp,
            $email,
            $tgl_lahir,
            $created_by
        );
        $insertUserPassword = $this->Sisantuy_Register_Model->insertUserPassword(
            $username,
            $password,
            $password,
            $created_by
        );
        $iduserrole = $this->Sisantuy_KodeGenerator_Model->getIdUserRole();
        $insertUserRole = $this->Sisantuy_Register_Model->insertUserRole($iduserrole,$username,$role,$username);

        return $this->load->view('login_view');

    }

    // function purpose = Menyimpan log login
    function saveLog($username){
        //Get IP address
        $ipaddr = $this->get_client_ip_env();

        //Get login time
        $login_time = $this->getTime();

        //Get data user by email
        $data_user = $this->SisantuyUser_Model->getUserDataFromUsername($username);
        foreach($data_user as $dt)
        {
            $username = $dt->USERNAME;
            $email = $dt->EMAIL;
        }

        $KdLogLogin = $this->Sisantuy_KodeGenerator_Model->getKdLoginLog();
        $saveLog = $this->SisantuyUser_Model->saveLogModel($KdLogLogin, $username, $email, $ipaddr);
        return $saveLog;
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
	
    function getTime()
	{
		$timezone  = 7;
		return gmdate("Y/m/j H:i:s", time() + 3600*($timezone+date("I"))); 
    }
    
    // Function to get the client ip address
    function get_client_ip_env() {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
     
        return $ipaddress;
    }

    function get_client_ip_server() {
        $ipaddress = '';
        if ($_SERVER['HTTP_CLIENT_IP'])
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if($_SERVER['HTTP_X_FORWARDED_FOR'])
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if($_SERVER['HTTP_X_FORWARDED'])
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if($_SERVER['HTTP_FORWARDED_FOR'])
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if($_SERVER['HTTP_FORWARDED'])
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if($_SERVER['REMOTE_ADDR'])
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
     
        return $ipaddress;
    }

}
