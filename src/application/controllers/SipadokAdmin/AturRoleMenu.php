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
		$crud->set_table('sipadok_rolemenu');
        $crud->where('sipadok_rolemenu.Deleted','0');
        
        $crud->unset_clone();
        //$crud->unset_read();
        $crud->set_relation('KdMenu','sipadok_menu','NamaMenu',array('Deleted' => '0'));
        $crud->set_relation('KdRole','sipadok_role','NamaRole',array('Deleted' => '0'));

		//Kolom yang ditampilkan
        $crud->columns(
            'KdRole',
            'KdMenu',
            'CreatedBy',
            'CreatedOn',
            'UpdatedBy',
            'UpdatedOn'
        );
        //$this->grocery_crud->fields('Username','NamaUser','Psswd','NIP','KodeMitra','EmailPribadi','EmailKantor','CreatedBy','CreatedOn');
        $crud->add_fields(
            'KdMenu',
            'KdRole'
        );//Fields untuk menambahkan data baru
        $crud->edit_fields(
            'KdMenu',
            'KdRole'
        );

        $crud->display_as('KdMenu','Menu');
        $crud->display_as('KdRole','Role Pengguna');

        //Atur rule
        $crud->set_rules('KdMenu','Menu','trim|required');
        $crud->set_rules('KdRole','Role Pengguna','trim|required');

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
        $this->template_lib->load('default','content/sipadokadmin/aturrolemenu_view',$data);
    }
	
	function _delete_rolemenu($primary_key){
		return $this->db->update('sipadok_rolemenu',array('Deleted' => '1','UpdatedBy'=>$this->usernameLogin,'UpdatedOn'=>$this->getTime()),array('KdRoleMenu' => $primary_key));
	}
	
	function _insert_rolemenu($post_array){
    //function _after_insert_kategoripromosi($post_array){
        $post_array['CreatedBy'] = $this->usernameLogin;//ganti nih
		$post_array['CreatedOn'] = $this->getTime();

        return $this->db->insert('sipadok_rolemenu',$post_array);
    }
    
    //function _update_kategoripromosi($post_array){
	function _after_update_rolemenu($post_array,$primary_key){
		$post_array['UpdatedBy'] = $this->usernameLogin;
        $post_array['UpdatedOn'] = $this->getTime();

        return $this->db->update('sipadok_rolemenu',$post_array,array('KdRoleMenu'=>$primary_key));
    }
    
    function getTime()
	{
		$timezone  = 7;
		return gmdate("Y/m/j H:i:s", time() + 3600*($timezone+date("I"))); 
	}
		
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */