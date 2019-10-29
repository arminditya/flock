<?php if (!defined('BASEPATH')) exit('Tidak boleh mengakses dengan cara ini!');
	
	class Success extends CI_Controller {
        
	function __construct()
	{
	    parent::__construct();
	    $this->load->model('Grup','',TRUE);
	    $this->load->library('Grocery_CRUD');
	    $this->load->library('email');
	}
        
	function index()
	{
		$this->load->view('verification/success');
        }
        
	}
?>