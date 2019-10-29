<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {

	public function index()
	{
		// $this->load->view('forgot_password_view');
		$this->load->view('register_view');
	}
}