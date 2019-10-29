<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pengaturan extends CI_Controller
{
    public $usernameLogin;
    
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper(array('form', 'url'));
		$this->load->library('Grocery_CRUD');
    }

    public function index()
    {
        if($this->session->userdata('logged_in')){
			if(page_check_authorized('Pengaturan'))
			{
				$session_data = $this->session->userdata('logged_in');
				$this->usernameLogin = $session_data['username'];
                $this->_pengaturan();
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

    public function _pengaturan()
    {
		$crud = new grocery_CRUD();
		$crud->set_subject('Pengaturan');
		$crud->set_table('sipadok_user');
        $crud->where('sipadok_user.Deleted','0');
        $crud->unset_clone();
        $crud->unset_read();
        
		//kolom yang ditampilkan
        $crud->columns(
            'NamaUser',
            'EmailKantor'
        );
		
        $crud->edit_fields('Pswd');
		
        $crud->display_as('Pswd','Password');
        //Atur rule
        $crud->set_rules('Pswd','Password','trim|required');
		
        $crud->callback_after_update(array($this,'_after_update_password'));
		
		$crud->unset_texteditor('Description','Url');
        $output = $crud->render();
        $this-> change_password($output);
    }
	
	function check_database($password)
    {
        // $username = $this->input->post('username');
        $session_data = $this->session->userdata('logged_in');
		$email = $session_data['emailkantor'];
		
        $result = $this->SipadokUser_Model->login($email, $password);

        $change_password = $this->SipadokUser_Model->check_default_password($email, $password);

        if($change_password)
        {
            foreach($change_password as $row)
            {
                $pass = $row->Pswd;
                $pass_default = $row->PswdDefault;
            }

            if($pass == $pass_default)
            {
                //redirect('change_password');
                redirect(base_url('index.php/Change_Password'));
            }
            else
            {
                if($result)
                {
                $sess_array = array();
                // print_r($result);
                // die;
                    foreach($result as $row)
                    {
                    
                    $sess_array = array(
                        'nik' => $row->NIK,
                        'username' => $row->NIK,//Email kantor juga dianggap sebagai username
                        'namauser' => $row->NamaUser,
                        'emailkantor' => $row->EmailKantor,
                        'emailpribadi' => $row->EmailPribadi
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

	function change_password($output = null)
    {
		$session_data = $this->session->userdata('logged_in');
		
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('CurrentPassword', 'Password', 'required|callback_check_old_password');
        $this->form_validation->set_rules('NewPassword', 'Password', 'required');
        $this->form_validation->set_rules('ConfNewPassword', 'Password', 'required');
		
		$email = $session_data['emailkantor'];
		
        if($this->form_validation->run() == false)
        {
            $data = array(
                'title' => 'Pengaturan Password',
				'body' => $output
				);
			$this->load->helper(array('form','url'));
			$this->template_lib->load('default', 'content/sipadokall/pengaturan_view', $data);
        }
        else
        {
            $message = "Ubah password sukses, silahkan login kembali dengan password baru anda.";
                echo "<script LANGUAGE='JavaScript'>
                    window.alert('$message');
                    window.location.href='".base_url()."';
                    </script>";
        } 
    }
	
	function check_old_password($old_password)
    {
		$session_data = $this->session->userdata('logged_in');
		$email = $session_data['emailkantor'];
		
        $new_password = $this->input->post('NewPassword');
        $renew_password = $this->input->post('ConfNewPassword');

		$result = $this->SipadokUser_Model->login($email, $old_password);
		if($result)
		{
            if($old_password == $new_password)
            {
                $message = "Password baru harus berbeda dengan password lama";
				echo "<script LANGUAGE='JavaScript'>
					window.alert('$message');
					</script>";
				return false;
            }
            else
            {
                if($new_password == $renew_password)
			    {
				    $update_password = $this->SipadokUser_Model->update_password($email, $new_password);
				    if( $update_password )
                    {
                        $message = "Sukses ubah password.";
				        echo "<script LANGUAGE='JavaScript'>
					        window.alert('$message');
					        </script>";
					    return true;
				    }
                    else
                    {
					    $message = "Error update password, silahkan coba beberapa saat lagi.";
				        echo "<script LANGUAGE='JavaScript'>
					        window.alert('$message');
					        </script>";
					    return false;
				    }
			    }
			    else
			    {
				    $message = "Kolom password baru dan konfirmasi password baru harus sama";
                    echo "<script LANGUAGE='JavaScript'>
                        window.alert('$message');
                        </script>";
				    return false;
			    }
            }	
		}
        else
        {
			$message = "Password user anda salah.";
			echo "<script LANGUAGE='JavaScript'>
				window.alert('$message');
				</script>";
			return false;
		}
    }
	
	function getTime()
	{
		$timezone  = 7;
		return gmdate("Y/m/j H:i:s", time() + 3600*($timezone+date("I"))); 
	}
    

}
