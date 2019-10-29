<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Change_Password extends CI_Controller {

	public function index()
	{
		$this->load->view('change_password_view');
	}
	
}
