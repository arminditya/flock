<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class AturMataUang extends CI_Controller {
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
			if(page_check_authorized('Atur Mata Uang'))
			{
				$session_data = $this->session->userdata('logged_in');
				$this->usernameLogin = $session_data['username'];
                $this->_aturmatauang();
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
	
	public function _aturmatauang()
    {
		$crud = new grocery_CRUD();
		$crud->set_subject('Mata Uang');
		$crud->set_table('mst_mata_uang');
        $crud->where('mst_mata_uang.DELETED','0');
        
        $crud->unset_clone();
        $crud->unset_read();

		//Kolom yang ditampilkan
        $crud->columns(
            'ID_MATA_UANG',
            'NAMA_MATA_UANG',
            'SINGKATAN_MATA_UANG',
            'CREATED_BY',
            'CREATED_ON',
            'UPDATED_BY',
            'UPDATED_ON'
        );
        //$this->grocery_crud->fields('Username','NamaUser','Psswd','NIP','KodeMitra','EmailPribadi','EmailKantor','CreatedBy','CreatedOn');
        $crud->add_fields('NAMA_MATA_UANG','SINGKATAN_MATA_UANG');//Fields untuk menambahkan data baru
        $crud->edit_fields('NAMA_MATA_UANG','SINGKATAN_MATA_UANG');

        $crud->display_as('NAMA_MATA_UANG','Nama Mata Uang');
        $crud->display_as('SINGKATAN_MATA_UANG','Singkatan');

        //Atur rule
        $crud->set_rules('NAMA_MATA_UANG','Nama Mata Uang','trim|required');
        $crud->set_rules('SINGKATAN_MATA_UANG','Singkatan','trim|required');

        $crud->callback_insert(array($this,'_insert_matauang'));
        $crud->callback_after_update(array($this,'_after_update_matauang'));
        $crud->callback_delete(array($this,'_delete_matauang'));
        
		$crud->unset_texteditor('Description','Url');
        $output = $crud->render();
        $this-> _outputview($output);        
    }
 
    function _outputview($output = null)
    {
		$data = array(
                'title' => 'Atur Mata Uang',
			    'body' => $output
		  );
		$this->load->helper(array('form','url'));
        //$this->template_lib->load('default','content/promotion/promotion_data_view',$data);
        $this->template_lib->load('default','content/sisantuyadmin/aturmatauang_view',$data);
    }
	
	function _delete_matauang($primary_key){
		return $this->db->update('mst_mata_uang',array('DELETED' => '1','UPDATED_BY'=>$this->usernameLogin,'UPDATED_ON'=>$this->getTime()),array('ID_MATA_UANG' => $primary_key));
	}
	
	function _insert_matauang($post_array){
        $post_array['CREATED_BY'] = $this->usernameLogin;//ganti nih
		$post_array['CREATED_ON'] = $this->getTime();

        return $this->db->insert('mst_mata_uang',$post_array);
    }
    
    //function _update_kategoripromosi($post_array){
	function _after_update_matauang($post_array,$primary_key){
		$post_array['UPDATED_BY'] = $this->usernameLogin;
        $post_array['UPDATED_ON'] = $this->getTime();

        return $this->db->update('mst_mata_uang',$post_array,array('ID_MATA_UANG'=>$primary_key));
    }
    
    function getTime()
	{
		$timezone  = 7;
		return gmdate("Y/m/j H:i:s", time() + 3600*($timezone+date("I"))); 
	}
		
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */