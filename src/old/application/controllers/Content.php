<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Content extends CI_Controller {
    var $data = array();
    function __construct()
    {
      parent::__construct();
      $this->load->model('User','',TRUE);
      //$this->load->library('grocery_CRUD');
      $this->load->library('Grocery_CRUD');
    }

    public function _example_output($output = null)
	{
		$this->load->view('content/event_view',(array)$output);
    }
    
    public function employees_management()
	{
			$crud = new grocery_CRUD();

			$crud->set_table('digi_user');
			$output = $crud->render();
			$this->_example_output($output);
	}
    
    public function get_content($page = null)
	{
		if($page == 'promotion_data'){
			$this->PromotionData();
		}else if($page == 'participants'){
			$this->Participants();
		}else if($page == 'promotion_statistics'){
			$this->PromotionStatistics();
		}else if($page == 'create_event'){
			$this->CreateEvent();
		}else if($page == 'event'){
			$this->Event();
		}else if($page == 'set_poin'){
			$this->SetPoin();
		}else if($page == 'set_promotion'){
			$this->SetPromotion();
		}else if($page == 'set_event'){
			$this->SetEvent();
		}else{
            $this->load->view('errors/index');
        } 
    }

    private function PromotionData()
    {
        $username = $this->session->userdata['logged_in']['username'];
        $authorized = $this->User->page_check_authorized($username,'promotion_data');  
            if($authorized)
            {
		        $this->template_lib->load('templates/default','content/promotion/promotion_data_view',$this->data);
            }
            else
            {
                $this->load->view('errors/index');
            }
    }

    private function PromotionStatistics()
    {

        $username = $this->session->userdata['logged_in']['username'];
        $authorized = $this->User->page_check_authorized($username,'promotion_statistics');     
            if($authorized)
            {
                $this->template_lib->load('templates/default','content/promotion/promotion_statistics_view',$this->data);
            }
            else
            {
                $this->load->view('errors/index');
            }
    }

    private function Participants()
    {
        $username = $this->session->userdata['logged_in']['username'];   
        $authorized = $this->User->page_check_authorized($username,'participants');      
            if($authorized)
            { 
                $this->template_lib->load('templates/default','content/promotion/participants_view',$this->data);
            }
            else
            {
                $this->load->view('errors/index');
            }

    }

    private function SetPoin()
    {
        $username = $this->session->userdata['logged_in']['username'];   
        $authorized = $this->User->page_check_authorized($username,'set_poin');       
            if($authorized)
            {
             
                $this->template_lib->load('templates/default','content/admin/set_poin_view',$this->data);
            }
            else
            {
                $this->load->view('errors/index');
            }
    }

    private function SetPromotion()
    {
        $username = $this->session->userdata['logged_in']['username'];  
        $authorized = $this->User->page_check_authorized($username,'set_promotion');        
            if($authorized)
            {
                $this->template_lib->load('templates/default','content/admin/set_promotion_view',$this->data);
            }
            else
            {
                $this->load->view('errors/index');
            }   

    }

    private function SetEvent()
    {
        $username = $this->session->userdata['logged_in']['username'];
        $authorized = $this->User->page_check_authorized($username,'set_event');  
         
            if($authorized)
            {
                $this->template_lib->load('templates/default','content/admin/set_event_view',$this->data);
            }
            else
            {
                $this->load->view('errors/index');
            }       
    }

    
    
    private function CreateEvent()
	{
            $username = $this->session->userdata['logged_in']['username'];
            $authorized = $this->User->page_check_authorized($username,'create_event');  
             
                if($authorized)
                {
		            $this->template_lib->load('templates/default','content/event/create_event_view',$this->data);
                }
                else
                {
                    $this->load->view('errors/index');
                }
    }
    
    private function Event()
	{
        $username = $this->session->userdata['logged_in']['username'];
        $authorized = $this->User->page_check_authorized($username,'event');   
        
            if( $authorized)
            {
            $crud = new grocery_CRUD();
            $crud->set_theme('datatables'); 
            $crud->set_table('digi_event');
            $crud->set_subject('Event');
            $crud->columns('Judul','TanggalMulai','TanggalSelesai','EmailNotification','StatusEvent');
            $crud->display_as('Judul','Judul Event');
            $crud->display_as('TanggalMulai','Tanggal Mulai (hh:mm)');
            $crud->display_as('TanggalSelesai','Tanggal Selesai (hh:mm)');
            $crud->display_as('EmailNotification','Tanggal Selesai (hh:mm)');
            $crud->display_as('StatusEvent','Status Event');
            $output = $crud->render();

            $this->data = $output;
             
            $this->template_lib->load('templates/default','content/event/event_view',$this->data);
            }
            else
            {
                $this->load->view('errors/index');
            }
    }
}