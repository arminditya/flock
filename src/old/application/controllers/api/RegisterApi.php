<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class RegisterApi extends REST_Controller {

    function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->database();
        // $this->load->model('Kode_Model');
        $this->load->model('Sisantuy_Register_Model');
    }

    function index_post() {

        //Parameter wajib untuk keamanan
        $isApi = $this->input->post('isApi');
        
        // Data user
        $username = $this->input->post('username');
        $nama = $this->input->post('nama'); 
        $jenis_kelamin = $this->input->post('jenis_kelamin');
        $no_hp = $this->input->post('no_hp');
        $email = $this->input->post('email');
        $d_lahir = $this->input->post('d_lahir');
        $m_lahir = $this->input->post('m_lahir');
        $y_lahir = $this->input->post('y_lahir');

        if($isApi == '1'){
           
            $doCreateUser = $this->Sisantuy_Register_Model->createUser(
                $username,
                $nama,
                $jenis_kelamin,
                $no_hp,
                $email,
                $d_lahir,
                $m_lahir,
                $y_lahir
            );
           
        }else{
            echo 'Please access this feature via SISANTUY WEB APPS.';
        }

    }

    //Masukan function selanjutnya disini
}
?>