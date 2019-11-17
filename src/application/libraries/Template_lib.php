<?php

class Template_lib {
    
    var $template_data = array();

    public function __construct()
	{
        $this->CI =& get_instance();
        $this->CI->load->model('User','',TRUE);
        $this->CI->load->model('SipadokUser_Model','',TRUE);
        $this->CI->load->model('SisantuyUser_Model','',TRUE);
        // $this->CI->load->model('Grup','',TRUE);
    }
    
    public function set($name, $value)
    {
        $this->template_data[$name] = $value;
    }

    public function load($template = '', $view = '', $view_data = array(), $return = false)
    {
        $session_data = $this->CI->session->userdata('logged_in');
        // $result = $this->CI->User->getMenu($session_data['username']);   
        // $result = $this->CI->SipadokUser_Model->getMenu($session_data['username']);   
        $result = $this->CI->SisantuyUser_Model->getMenu($session_data['username']);   
        // $grupMenu = $this->CI->Grup->check_event_authorized_user($session_data['username']);

        // $event_notif_count = $this->CI->User->getEventNotifCount(); 
        //     foreach($event_notif_count as $value)
        //     {
        //         $event_notif_count = $value->value;
        //         if($event_notif_count=='0'){
        //             $event_notif_count = "";
        //         }
        //     }  

        // $promo_notif_count = $this->CI->User->getPromoNotifCount(); 
        //     foreach($promo_notif_count as $value)
        //     {
        //         $promo_notif_count = $value->value;
        //         if($promo_notif_count=='0'){
        //             $promo_notif_count = "";
        //         }
        //     }    

        //     if($grupMenu)
        //     {
        //     $this->set('grupList', $grupMenu);
        //     }

        

        //we need to return the value of event which not being approved yet
        // $this->set('event_notif_count', $event_notif_count);
          //we need to return the value of promo which not being approved yet
        // $this->set('promo_notif_count', $promo_notif_count);

        $this->set('menus', $result);
        $this->set('contents', $this->CI->load->view($view, $view_data,true));
        return $this->CI->load->view("templates/".$template, $this->template_data, $return);
    }

}