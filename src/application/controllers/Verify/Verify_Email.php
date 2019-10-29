<?php if (!defined('BASEPATH')) exit('Tidak boleh mengakses dengan cara ini!');
	
	class Verify_Email extends CI_Controller {
        
	function __construct()
	{
	    parent::__construct();
	    $this->load->model('Grup','',TRUE);
	    $this->load->library('Grocery_CRUD');
		$this->load->library('email');
		$this->load->model('User','',TRUE);
	}
        
	function generate($unique_code = null,$unique_code2 = null)
	{
		$personal = $this->User->update_verification_data($unique_code,$unique_code2);  
		if($personal)
		{
			$this->load->view('verification/on_process');
		}
		else
		{
			$this->load->view('verification/failed');
		}
		
    }
        
	}
?>