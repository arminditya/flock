<?php if (!defined('BASEPATH')) exit('Tidak boleh mengakses dengan cara ini!');

	class Data_Verification extends CI_Controller {
		function __construct(){
			parent::__construct();
		}
		
		function index($email,$kdPeserta,$phone){
			if($this->session->userdata('logged_in')){
				$data = array(
					'title' => 'Dashboard',
					'body' => ''
					);
				
				$this->load->helper(array('form','url'));			
				$this->template->load('default','landing_view',$data);
			}
			else
			{
				redirect('login?u='.substr($_SERVER["REQUEST_URI"],stripos($_SERVER["REQUEST_URI"],"index.php/")+10),'refresh');
			}
		}
	}
?>