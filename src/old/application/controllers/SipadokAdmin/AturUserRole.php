<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class AturUserRole extends CI_Controller {
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
			if(page_check_authorized('Atur User - Role'))
			{
				$session_data = $this->session->userdata('logged_in');
				$this->usernameLogin = $session_data['username'];
                $this->_aturuserrole();
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
	
	public function _aturuserrole()
    {
		$crud = new grocery_CRUD();
		$crud->set_subject('User-Role');
		$crud->set_table('sipadok_userrole');
        $crud->where('sipadok_userrole.Deleted','0');
        
        $crud->unset_clone();
        //$crud->unset_read();
        //$crud->set_relation('KodeMitra','mitra','NamaMitra',array('deleted' => '0'));
        $crud->set_relation('NIK','sipadok_user','NamaUser',array('Deleted' => '0'));
        $crud->set_relation('KdRole','sipadok_role','NamaRole',array('Deleted' => '0'));

		//Kolom yang ditampilkan
        $crud->columns(
            'NIK',
            'KdRole',
            'CreatedBy',
            'CreatedOn',
            'UpdatedBy',
            'UpdatedOn'
        );
        //$this->grocery_crud->fields('Username','NamaUser','Psswd','NIP','KodeMitra','EmailPribadi','EmailKantor','CreatedBy','CreatedOn');
        $crud->add_fields(
            'NIK',
            'KdRole'
        );//Fields untuk menambahkan data baru
        $crud->edit_fields(
            'NIK',
            'KdRole'
        );

        $crud->display_as('NIK','Nama Pengguna');
        $crud->display_as('KdRole','Role Pengguna');

        //Atur rule
        $crud->set_rules('NIK','Nama Pengguna','trim|required');
        $crud->set_rules('KdRole','Role Pengguna','trim|required');

        $crud->callback_insert(array($this,'_insert_userrole'));
        $crud->callback_after_update(array($this,'_after_update_userrole'));
		$crud->callback_delete(array($this,'_delete_userrole'));
		$crud->unset_texteditor('Description','Url');
		
        $output = $crud->render();
   
        $this-> _outputview($output);        
    }
 
    function _outputview($output = null)
    {
		$data = array(
                //'title' => 'Pengaturan Menu',
                'title' => 'Pengaturan User-Role',
			   'body' => $output
		  );
		$this->load->helper(array('form','url'));
        $this->template_lib->load('default','content/sipadokadmin/aturuserrole_view',$data);
    }
	
	function _delete_userrole($primary_key){
		return $this->db->update('sipadok_userrole',array('Deleted' => '1','UpdatedBy'=>$this->usernameLogin,'UpdatedOn'=>$this->getTime()),array('KdUserRole' => $primary_key));
	}
	
	function _insert_userrole($post_array){
    //function _after_insert_kategoripromosi($post_array){
        $post_array['CreatedBy'] = $this->usernameLogin;//ganti nih
		$post_array['CreatedOn'] = $this->getTime();

        return $this->db->insert('sipadok_userrole',$post_array);
    }
    
    //function _update_kategoripromosi($post_array){
	function _after_update_userrole($post_array,$primary_key){
		$post_array['UpdatedBy'] = $this->usernameLogin;
        $post_array['UpdatedOn'] = $this->getTime();

        return $this->db->update('sipadok_userrole',$post_array,array('KdUserRole'=>$primary_key));
    }
    
    function getTime()
	{
		$timezone  = 7;
		return gmdate("Y/m/j H:i:s", time() + 3600*($timezone+date("I"))); 
	}
		
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */