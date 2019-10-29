<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class AturTipePadok extends CI_Controller {
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
			if(page_check_authorized('Atur Tipe Padok'))
			{
				$session_data = $this->session->userdata('logged_in');
				$this->usernameLogin = $session_data['username'];
                $this->_aturtipepadok();
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
	
	public function _aturtipepadok()
    {
		$crud = new grocery_CRUD();
		$crud->set_subject('Tipe Padok');
		$crud->set_table('sipadok_tipepadok');
        $crud->where('sipadok_tipepadok.Deleted','0');
        
        $crud->unset_clone();
        $crud->unset_read();

		//Kolom yang ditampilkan
        $crud->columns('NamaTipePaket');
        $crud->add_fields('NamaTipePaket');//Fields untuk menambahkan data baru
        $crud->edit_fields('NamaTipePaket');

        $crud->display_as('NamaTipePaket','Nama Tipe');

        //Atur rule
        $crud->set_rules('NamaTipePaket','Nama Tipe','trim|required|min_length[1]|max_length[50]');

        $crud->callback_insert(array($this,'_insert_padok'));
        $crud->callback_after_update(array($this,'_after_update_padok'));
		$crud->callback_delete(array($this,'_delete_padok'));
		$crud->unset_texteditor('Description','Url');
		
        $output = $crud->render();
   
        $this-> _outputview($output);        
    }
 
    function _outputview($output = null)
    {
		$data = array(
                'title' => 'Atur Tipe Padok',
			    'body' => $output
		  );
		$this->load->helper(array('form','url'));
        $this->template_lib->load('default','content/sipadokoa/aturtipepadok_view',$data);
    }
	
	function _delete_padok($primary_key){
		return $this->db->update('sipadok_tipepadok',array('Deleted' => '1','UpdatedBy'=>$this->usernameLogin,'UpdatedOn'=>$this->getTime()),array('KdTipePadok' => $primary_key));
	}
	
	function _insert_padok($post_array){
    //function _after_insert_kategoripromosi($post_array){
        $post_array['CreatedBy'] = $this->usernameLogin;//ganti nih
		$post_array['CreatedOn'] = $this->getTime();

        return $this->db->insert('sipadok_tipepadok',$post_array);
    }
    
    //function _update_kategoripromosi($post_array){
	function _after_update_padok($post_array,$primary_key){
		$post_array['UpdatedBy'] = $this->usernameLogin;
        $post_array['UpdatedOn'] = $this->getTime();

        return $this->db->update('sipadok_tipepadok',$post_array,array('KdTipePadok'=>$primary_key));
    }
    
    function getTime()
	{
		$timezone  = 7;
		return gmdate("Y/m/j H:i:s", time() + 3600*($timezone+date("I"))); 
	}
		
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */