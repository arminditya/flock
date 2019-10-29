<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class AturJasaEkspedisi extends CI_Controller {
	var $usernameLogin;
    function __construct()
    {
        parent::__construct();
		
        $this->load->library('Grocery_CRUD');
    }
 
    public function index()
    {		
		if($this->session->userdata('logged_in')){
			if(page_check_authorized('Atur Jasa Ekspedisi'))
			{
				$session_data = $this->session->userdata('logged_in');
				$this->usernameLogin = $session_data['username'];
                $this->_aturjasaekspedisi();
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
	
	public function _aturjasaekspedisi()
    {
		$crud = new grocery_CRUD();
		$crud->set_subject('Jasa Ekspedisi');
		$crud->set_table('sipadok_jasaekspedisi');
        $crud->where('sipadok_jasaekspedisi.Deleted','0');
        
        $crud->unset_clone();
        // $crud->unset_read();

		//Kolom yang ditampilkan
        $crud->columns(
            'NamaJasaEkspedisi',
            'NoTelp',
            'Email'
        );
        $crud->add_fields(
            'NamaJasaEkspedisi',
            'NoTelp',
            'Email'
        );//Fields untuk menambahkan data baru
        $crud->edit_fields(
            'NamaJasaEkspedisi',
            'NoTelp',
            'Email'
        );

        $crud->display_as('NamaJasaEkspedisi','Jasa Ekspedisi');
        $crud->display_as('NoTelp','Nomor Telpon');
        $crud->display_as('Email','Email');

        //Atur rule
        $crud->set_rules('NamaJasaEkspedisi','Jasa Ekspedisi','trim|required|min_length[1]|max_length[150]');
        $crud->set_rules('NoTelp','Nomor Telpon','trim|required|numeric');
        $crud->set_rules('Email','Email','trim|required|min_length[1]|max_length[255]|valid_email');

        $crud->callback_insert(array($this,'_insert_jasaekspedisi'));
        $crud->callback_after_update(array($this,'_after_update_jasaekspedisi'));
		$crud->callback_delete(array($this,'_delete_jasaekspedisi'));
		$crud->unset_texteditor('Description','Url');
		
        $output = $crud->render();
   
        $this-> _outputview($output);        
    }
 
    function _outputview($output = null)
    {
		$data = array(
                'title' => 'Atur Jasa Ekspedisi',
			    'body' => $output
		  );
		$this->load->helper(array('form','url'));
        $this->template_lib->load('default','content/sipadokoa/aturjasaekspedisi_view',$data);
    }
	
	function _delete_jasaekspedisi($primary_key){
		return $this->db->update('sipadok_jasaekspedisi',array('Deleted' => '1','UpdatedBy'=>$this->usernameLogin,'UpdatedOn'=>$this->getTime()),array('KdJasaEkspedisi' => $primary_key));
	}
	
	function _insert_jasaekspedisi($post_array){
    //function _after_insert_kategoripromosi($post_array){
        $post_array['CreatedBy'] = $this->usernameLogin;//ganti nih
		$post_array['CreatedOn'] = $this->getTime();

        return $this->db->insert('sipadok_jasaekspedisi',$post_array);
    }
    
    //function _update_kategoripromosi($post_array){
	function _after_update_jasaekspedisi($post_array,$primary_key){
		$post_array['UpdatedBy'] = $this->usernameLogin;
        $post_array['UpdatedOn'] = $this->getTime();

        return $this->db->update('sipadok_jasaekspedisi',$post_array,array('KdJasaEkspedisi'=>$primary_key));
    }
    
    function getTime()
	{
		$timezone  = 7;
		return gmdate("Y/m/j H:i:s", time() + 3600*($timezone+date("I"))); 
	}
		
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */