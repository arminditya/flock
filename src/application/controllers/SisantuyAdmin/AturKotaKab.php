<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class AturKotaKab extends CI_Controller {
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
			if(page_check_authorized('Atur Kota-Kabupaten'))
			{
				$session_data = $this->session->userdata('logged_in');
				$this->usernameLogin = $session_data['username'];
                $this->_aturkotakab();
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
	
	public function _aturkotakab()
    {
		$crud = new grocery_CRUD();
		$crud->set_subject('Kota-Kabupaten');
		$crud->set_table('mst_kota_kab');
        $crud->where('mst_kota_kab.DELETED','0');
        $crud->order_by('mst_kota_kab.ID_PROVINSI', 'desc');

        $crud->set_relation('ID_PROVINSI','mst_provinsi','NAMA_PROVINSI',array('DELETED' => '0'));
        
        $crud->unset_clone();
        $crud->unset_read();

		//Kolom yang ditampilkan
        $crud->columns(
            // 'ID_KOTA_KAB',
            'ID_PROVINSI',
            'NAMA_KOTA_KAB',
            'CREATED_BY',
            'CREATED_ON',
            'UPDATED_BY',
            'UPDATED_ON'
        );
        //$this->grocery_crud->fields('Username','NamaUser','Psswd','NIP','KodeMitra','EmailPribadi','EmailKantor','CreatedBy','CreatedOn');
        $crud->add_fields('ID_PROVINSI','NAMA_KOTA_KAB');//Fields untuk menambahkan data baru
        $crud->edit_fields('ID_PROVINSI','NAMA_KOTA_KAB');

        $crud->display_as('ID_PROVINSI','Provinsi');
        $crud->display_as('NAMA_KOTA_KAB','Nama Kota - Kabupaten');

        //Atur rule
        $crud->set_rules('ID_PROVINSI','Provinsi','trim|required');
        $crud->set_rules('NAMA_KOTA_KAB','Nama Kota - Kabupaten','trim|required');

        $crud->callback_insert(array($this,'_insert_kotakab'));
        $crud->callback_after_update(array($this,'_after_update_kotakab'));
        $crud->callback_delete(array($this,'_delete_kotakab'));
        
		$crud->unset_texteditor('Description','Url');
        $output = $crud->render();
        $this-> _outputview($output);        
    }
 
    function _outputview($output = null)
    {
		$data = array(
                'title' => 'Atur Kota - Kabupaten',
			    'body' => $output
		  );
		$this->load->helper(array('form','url'));
        $this->template_lib->load('default','content/sisantuyadmin/aturkotakab_view',$data);
    }
	
	function _delete_kotakab($primary_key){
		return $this->db->update('mst_kota_kab',array('DELETED' => '1','UPDATED_BY'=>$this->usernameLogin,'UPDATED_ON'=>$this->getTime()),array('ID_KOTA_KAB' => $primary_key));
	}
	
	function _insert_kotakab($post_array){
        $post_array['CREATED_BY'] = $this->usernameLogin;//ganti nih
		$post_array['CREATED_ON'] = $this->getTime();

        return $this->db->insert('mst_kota_kab',$post_array);
    }
    
	function _after_update_kotakab($post_array,$primary_key){
		$post_array['UPDATED_BY'] = $this->usernameLogin;
        $post_array['UPDATED_ON'] = $this->getTime();

        return $this->db->update('mst_kota_kab',$post_array,array('ID_KOTA_KAB'=>$primary_key));
    }
    
    function getTime()
	{
		$timezone  = 7;
		return gmdate("Y/m/j H:i:s", time() + 3600*($timezone+date("I"))); 
	}
		
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */