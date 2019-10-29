<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class AturMenu extends CI_Controller {
	var $usernameLogin;
    function __construct()
    {
        parent::__construct();
		//$this->load->model('digi_datapromosi','',TRUE);
		//$this->load->library('grocery_crud');
        $this->load->library('Grocery_CRUD');
    }
 
    public function index()
    {		
		if($this->session->userdata('logged_in')){
			if(page_check_authorized('Atur Menu'))
			{
				$session_data = $this->session->userdata('logged_in');
				$this->usernameLogin = $session_data['username'];
                $this->_aturmenu();
			}else{
                $message = "Maaf, anda tidak memiliki akses pada halaman ini.";
                echo "<script LANGUAGE='JavaScript'>
                    window.alert('$message');
                    window.location.href='".base_url()."';
                    </script>";
            }
		}else{
            redirect('Login?url='.substr($_SERVER["REQUEST_URI"],stripos($_SERVER["REQUEST_URI"],"index.php/")+10),'refresh');
		}
    }
	
	public function _aturmenu()
    {
		$crud = new grocery_CRUD();
		$crud->set_subject('Menu');
		//$crud->set_theme('datatables');
		$crud->set_table('sipadok_menu');
        $crud->where('sipadok_menu.Deleted','0');
        //$crud->where('digi_kategoripromosi.CreatedBy',$this->usernameLogin);
        //$crud->set_relation('Parent','menu','MenuName',array('deleted' => '0'));
        $crud->unset_clone();
        $crud->unset_read();

		//Kolom yang ditampilkan
        $crud->columns(
            // 'KdRole',
            'NamaMenu',
            'Icon',
            'Url',
            'CreatedBy',
            'CreatedOn',
            'UpdatedBy',
            'UpdatedOn'
        );
        //$this->grocery_crud->fields('Username','NamaUser','Psswd','NIP','KodeMitra','EmailPribadi','EmailKantor','CreatedBy','CreatedOn');
        $crud->add_fields('NamaMenu','Icon','Url');//Fields untuk menambahkan data baru
        $crud->edit_fields('NamaMenu','Icon','Url');

        $crud->display_as('NamaMenu','Nama Menu');
        $crud->display_as('Icon','Icon Menu');
        $crud->display_as('Url','URL Menu');

        //Atur rule
        $crud->set_rules('NamaMenu','Nama Menu','trim|required');
        $crud->set_rules('IconMenu','Icon Menu','trim|required');
        $crud->set_rules('UrlMenu','URL Menu','trim|required');

        $crud->callback_insert(array($this,'_insert_menu'));
        $crud->callback_after_update(array($this,'_after_update_menu'));
		$crud->callback_delete(array($this,'_delete_menu'));
		$crud->unset_texteditor('Description','Url');
		
        $output = $crud->render();
   
        $this-> _outputview($output);        
    }
 
    function _outputview($output = null)
    {
		$data = array(
                'title' => 'Pengaturan Menu',
			   'body' => $output
		  );
		$this->load->helper(array('form','url'));
        //$this->template_lib->load('default','content/promotion/promotion_data_view',$data);
        $this->template_lib->load('default','content/sipadokadmin/aturmenu_view',$data);
    }
	
	function _delete_menu($primary_key){
		return $this->db->update('sipadok_menu',array('Deleted' => '1','UpdatedBy'=>$this->usernameLogin,'UpdatedOn'=>$this->getTime()),array('KdMenu' => $primary_key));
	}
	
	function _insert_menu($post_array){
    //function _after_insert_kategoripromosi($post_array){
        $post_array['CreatedBy'] = $this->usernameLogin;//ganti nih
		$post_array['CreatedOn'] = $this->getTime();

        return $this->db->insert('sipadok_menu',$post_array);
    }
    
    //function _update_kategoripromosi($post_array){
	function _after_update_menu($post_array,$primary_key){
		$post_array['UpdatedBy'] = $this->usernameLogin;
        $post_array['UpdatedOn'] = $this->getTime();

        return $this->db->update('sipadok_menu',$post_array,array('KdMenu'=>$primary_key));
    }
    
    function getTime()
	{
		$timezone  = 7;
		return gmdate("Y/m/j H:i:s", time() + 3600*($timezone+date("I"))); 
	}
		
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */