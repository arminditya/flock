<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    var $data = array();
    var $usernameLogin;

    function __construct()
    {
      parent::__construct();
    //   $this->load->model('User','',TRUE);
      // $this->load->model('SipadokUser_Model','',TRUE);
      $this->load->model('SisantuyUser_Model','',TRUE);
    }

  
    public function index()
    {
          if($this->session->userdata('logged_in'))
          {   
              $session_data = $this->session->userdata('logged_in');
              $this->usernameLogin = $session_data['username'];//nik
              //$this->_namaMitra($this->usernameLogin);
  
              // $nik = $this->usernameLogin;
  
              $data = $this->SisantuyUser_Model->getUserLoginData($this->usernameLogin);
              var_dump($data);
              // die();
              foreach ($data as $row) {
                  $username = $row->USERNAME;
                  $nama = $row->NAMA;
                  $email = $row->EMAIL;
                  $no_hp = $row->NO_HP;
                  $namarole = $row->NAMA_ROLE;
              }
  
              $data = array(
                  //'title' => 'Pengaturan Menu',
                  'title' => 'Home',
                  'username' => $username,
                  'namauser' => $nama,
                  'email' => $email,
                  'namarole' => $namarole
            );
  
              //$this->data ['title'] = "Home";
              //$this->data ['namamitra'] = $namamitra;
              //$this->template_lib->load('default','content/dashboard',$this->data);
              $this->template_lib->load('default','content/dashboard',$data);
          }else
          {
              $this->load->view('errors/index');
          }
          
      }
      
  
      function logout()
      {
          $this->session->unset_userdata('logged_in');
          session_destroy();
          //redirect('login','refresh');
          //redirect(base_url('index.php/Login','refresh'));
          redirect(base_url('index.php/Login'));
      }

  // Kodingan punya SIPADOK
	// public function index()
	// {
  //       if($this->session->userdata('logged_in'))
  //       {   
  //           $session_data = $this->session->userdata('logged_in');
  //           $this->usernameLogin = $session_data['username'];//nik
  //           //$this->_namaMitra($this->usernameLogin);

  //           $nik = $this->usernameLogin;

  //           $data = $this->db->query("SELECT * FROM mti.sipadok_user WHERE Deleted = 0 AND NIK = ?",array($nik));
  //           $emailkantor = 0;
  //           $namauser = 0;
  //           foreach ($data->result() as $row)
  //           {
  //             $emailkantor = $row->EmailKantor;
  //             $namauser = $row->NamaUser;
  //           }

  //           $data = array(
  //               //'title' => 'Pengaturan Menu',
  //               'title' => 'Home',
  //               'nik' => $nik,
  //               'namauser' => $namauser,
  //               'emailkantor' => $emailkantor
  //         );

  //           //$this->data ['title'] = "Home";
  //           //$this->data ['namamitra'] = $namamitra;
  //           //$this->template_lib->load('default','content/dashboard',$this->data);
  //           $this->template_lib->load('default','content/dashboard',$data);
  //       }else
  //       {
  //           $this->load->view('errors/index');
  //       }
        
  //   }
    

  //   function logout()
  //   {
  //       $this->session->unset_userdata('logged_in');
  //       session_destroy();
  //       //redirect('login','refresh');
  //       //redirect(base_url('index.php/Login','refresh'));
  //       redirect(base_url('index.php/Login'));
  //   }

    
	
}

