<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class AturFee extends CI_Controller {
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
			if(page_check_authorized('Manage Fee'))
			{
				$session_data = $this->session->userdata('logged_in');
				$this->usernameLogin = $session_data['username'];
                $this->_aturfee();
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
	
	public function _aturfee()
    {
		$crud = new grocery_CRUD();
		$crud->set_subject('Fee');
		$crud->set_table('mst_fee');
        $crud->where('mst_fee.DELETED','0');
        
        $crud->unset_clone();
        $crud->unset_read();

		//Kolom yang ditampilkan
        $crud->columns(
            'ID_FEE',
            'JENIS_FEE',
            'NAMA_FEE',
            'PERSENTASE',
            'CREATED_BY',
            'CREATED_ON',
            'UPDATED_BY',
            'UPDATED_ON'
        );
        //$this->grocery_crud->fields('Username','NamaUser','Psswd','NIP','KodeMitra','EmailPribadi','EmailKantor','CreatedBy','CreatedOn');
        $crud->add_fields(
            'JENIS_FEE',
            'NAMA_FEE',
            'PERSENTASE'
        );//Fields untuk menambahkan data baru
        $crud->edit_fields(
            'JENIS_FEE',
            'NAMA_FEE',
            'PERSENTASE'
        );

        $crud->display_as('JENIS_FEE','Jenis Fee *');
        $crud->display_as('NAMA_FEE','Nama Fee *');
        $crud->display_as('PERSENTASE','Persentase (%) *');

        //Atur rule
        $crud->set_rules('JENIS_FEE','Jenis Fee *','trim|required');
        $crud->set_rules('NAMA_FEE','Nama Fee *','trim|required');
        $crud->set_rules('PERSENTASE','Persentase (%) *','trim|required|integer');

        $crud->callback_insert(array($this,'_insert_fee'));
        $crud->callback_after_update(array($this,'_after_update_fee'));
        $crud->callback_delete(array($this,'_delete_fee'));
        
		$crud->unset_texteditor('Description','Url');
        $output = $crud->render();
        $this-> _outputview($output);        
    }
 
    function _outputview($output = null)
    {
		$data = array(
                'title' => 'Manage Tax',
			    'body' => $output
		  );
		$this->load->helper(array('form','url'));
        //$this->template_lib->load('default','content/promotion/promotion_data_view',$data);
        $this->template_lib->load('default','content/sisantuyadmin/aturfee_view',$data);
    }
	
	function _delete_fee($primary_key){
		return $this->db->update('mst_fee',array('DELETED' => '1','UPDATED_BY'=>$this->usernameLogin,'UPDATED_ON'=>$this->getTime()),array('ID_FEE' => $primary_key));
	}
	
	function _insert_fee($post_array){
        $post_array['CREATED_BY'] = $this->usernameLogin;//ganti nih
		$post_array['CREATED_ON'] = $this->getTime();

        return $this->db->insert('mst_fee',$post_array);
    }
    
	function _after_update_fee($post_array,$primary_key){
		$post_array['UPDATED_BY'] = $this->usernameLogin;
        $post_array['UPDATED_ON'] = $this->getTime();

        return $this->db->update('mst_fee',$post_array,array('ID_FEE'=>$primary_key));
    }
    
    function getTime()
	{
		$timezone  = 7;
		return gmdate("Y/m/j H:i:s", time() + 3600*($timezone+date("I"))); 
	}
		
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */