<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class AturRoleMenu extends CI_Controller {
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
			if(page_check_authorized('Atur Role - Menu'))
			{
				$session_data = $this->session->userdata('logged_in');
				$this->usernameLogin = $session_data['username'];
                $this->_aturrolemenu();
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
	
	public function _aturrolemenu()
    {
		$crud = new grocery_CRUD();
		$crud->set_subject('Role-Menu');
		//$crud->set_theme('datatables');
		$crud->set_table('trx_role_menu');
        $crud->where('trx_role_menu.DELETED','0');
        
        $crud->unset_clone();
        //$crud->unset_read();
        $crud->set_relation('ID_MENU','mst_menu','NAMA_MENU',array('DELETED' => '0'));
        $crud->set_relation('ID_ROLE','mst_role','NAMA_ROLE',array('DELETED' => '0'));

		//Kolom yang ditampilkan
        $crud->columns(
            'ID_ROLE_MENU',
            'ID_MENU',
            'ID_ROLE',
            'CREATED_BY',
            'CREATED_ON',
            'UPDATED_BY',
            'UPDATED_ON'
        );
        //$this->grocery_crud->fields('Username','NamaUser','Psswd','NIP','KodeMitra','EmailPribadi','EmailKantor','CreatedBy','CreatedOn');
        $crud->add_fields(
            'ID_MENU',
            'ID_ROLE'
        );//Fields untuk menambahkan data baru
        $crud->edit_fields(
            'ID_MENU',
            'ID_ROLE'
        );

        $crud->display_as('ID_MENU','Menu *');
        $crud->display_as('ID_ROLE','Role Pengguna *');

        //Atur rule
        $crud->set_rules('ID_MENU','Menu *','trim|required');
        $crud->set_rules('ID_ROLE','Role Pengguna *','trim|required');

        $crud->callback_insert(array($this,'_insert_rolemenu'));
        $crud->callback_after_update(array($this,'_after_update_rolemenu'));
		$crud->callback_delete(array($this,'_delete_rolemenu'));
        
        $crud->unset_texteditor('Description','Url');
        $output = $crud->render();
        $this-> _outputview($output);        
    }
 
    function _outputview($output = null)
    {
		$data = array(
                'title' => 'Atur Role-Menu',
			   'body' => $output
		  );
		$this->load->helper(array('form','url'));
        $this->template_lib->load('default','content/sisantuyadmin/aturrolemenu_view',$data);
    }
	
	function _delete_rolemenu($primary_key){
		return $this->db->update('trx_role_menu',array('DELETED' => '1','UPDATED_BY'=>$this->usernameLogin,'UPDATED_ON'=>$this->getTime()),array('ID_ROLE_MENU' => $primary_key));
	}
	
	function _insert_rolemenu($post_array){
    //function _after_insert_kategoripromosi($post_array){
        $post_array['CREATED_BY'] = $this->usernameLogin;//ganti nih
		$post_array['CREATED_ON'] = $this->getTime();

        return $this->db->insert('trx_role_menu',$post_array);
    }
    
    //function _update_kategoripromosi($post_array){
	function _after_update_rolemenu($post_array,$primary_key){
		$post_array['UPDATED_BY'] = $this->usernameLogin;
        $post_array['UPDATED_ON'] = $this->getTime();

        return $this->db->update('trx_role_menu',$post_array,array('ID_ROLE_MENU'=>$primary_key));
    }
    
    function getTime()
	{
		$timezone  = 7;
		return gmdate("Y/m/j H:i:s", time() + 3600*($timezone+date("I"))); 
	}
		
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */