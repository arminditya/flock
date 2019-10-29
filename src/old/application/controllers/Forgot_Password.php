<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Forgot_Password extends CI_Controller {

	public function index()
	{
		$this->load->view('forgot_password_view');
	}
}