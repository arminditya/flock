<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class AturDepartment extends CI_Controller {
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
			if(page_check_authorized('Atur Divisi'))
			{
				$session_data = $this->session->userdata('logged_in');
				$this->usernameLogin = $session_data['username'];
                $this->_aturdepartment();
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
	
	public function _aturdepartment()
    {
		$crud = new grocery_CRUD();
		$crud->set_subject('Divisi');
		//$crud->set_theme('datatables');
		$crud->set_table('tokped_department');
        $crud->where('tokped_department.Deleted','0');
        //$crud->where('digi_kategoripromosi.CreatedBy',$this->usernameLogin);
        //$crud->set_relation('Parent','menu','MenuName',array('deleted' => '0'));
        $crud->unset_clone();
        $crud->unset_read();

		//Kolom yang ditampilkan
        $crud->columns(
            // 'KdRole',
            'SignDept',
            'NamaDept',
            'CreatedBy',
            'CreatedOn',
            'UpdatedBy',
            'UpdatedOn'
        );
        //$this->grocery_crud->fields('Username','NamaUser','Psswd','NIP','KodeMitra','EmailPribadi','EmailKantor','CreatedBy','CreatedOn');
        $crud->add_fields('SignDept','NamaDept');//Fields untuk menambahkan data baru
        $crud->edit_fields('SignDept','NamaDept');

        $crud->display_as('SignDept','Kode Divisi');
        $crud->display_as('NamaDept','Nama Divisi');

        //Atur rule
        $crud->set_rules('SignDept','Kode Divisi','trim|required');
        $crud->set_rules('NamaDept','Nama Divisi','trim|required');

        $crud->callback_insert(array($this,'_insert_department'));
        $crud->callback_after_update(array($this,'_after_update_department'));
		$crud->callback_delete(array($this,'_delete_department'));
		$crud->unset_texteditor('Description','Url');
		
        $output = $crud->render();
   
        $this-> _outputview($output);        
    }
 
    function _outputview($output = null)
    {
		$data = array(
                //'title' => 'Pengaturan Menu',
                'title' => 'Atur Divisi',
			   'body' => $output
		  );
		$this->load->helper(array('form','url'));
        //$this->template_lib->load('default','content/promotion/promotion_data_view',$data);
        $this->template_lib->load('default','content/sipadokadmin/aturdepartment_view',$data);
    }
	
	function _delete_department($primary_key){
		return $this->db->update('tokped_department',array('Deleted' => '1','UpdatedBy'=>$this->usernameLogin,'UpdatedOn'=>$this->getTime()),array('KdDept' => $primary_key));
	}
	
	function _insert_department($post_array){
        $post_array['NamaDept'] = strtoupper($post_array['NamaDept']);
        $post_array['CreatedBy'] = $this->usernameLogin;//ganti nih
		$post_array['CreatedOn'] = $this->getTime();

        return $this->db->insert('tokped_department',$post_array);
    }
    
    //function _update_kategoripromosi($post_array){
	function _after_update_department($post_array,$primary_key){
        $post_array['NamaDept'] = strtoupper($post_array['NamaDept']);
		$post_array['UpdatedBy'] = $this->usernameLogin;
        $post_array['UpdatedOn'] = $this->getTime();

        return $this->db->update('tokped_department',$post_array,array('KdDept'=>$primary_key));
    }
    
    function getTime()
	{
		$timezone  = 7;
		return gmdate("Y/m/j H:i:s", time() + 3600*($timezone+date("I"))); 
	}
		
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */