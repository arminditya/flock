<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class AturDisc extends CI_Controller {
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
			if(page_check_authorized('Atur Discount'))
			{
				$session_data = $this->session->userdata('logged_in');
				$this->usernameLogin = $session_data['username'];
                $this->_aturdisc();
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
	
	public function _aturdisc()
    {
		$crud = new grocery_CRUD();
		$crud->set_subject('Discount');
		$crud->set_table('trx_potongan_harga');
        $crud->where('trx_potongan_harga.DELETED','0');
        $crud->where('trx_potongan_harga.CREATED_BY', $this->usernameLogin);
        
        $crud->unset_clone();
        $crud->unset_read();

        $crud->set_relation('ID_TOUR_PACKAGE','mst_tour_package','JUDUL',array('DELETED' => '0','CREATED_BY' => $this->usernameLogin));

		//Kolom yang ditampilkan
        $crud->columns(
            'ID_POTONGAN_HARGA',
            'ID_TOUR_PACKAGE',
            'PERSEN_POTONGAN',
            'STATUS',
            'CREATED_BY',
            'CREATED_ON',
            'UPDATED_BY',
            'UPDATED_ON'
        );

        //$this->grocery_crud->fields('Username','NamaUser','Psswd','NIP','KodeMitra','EmailPribadi','EmailKantor','CreatedBy','CreatedOn');
        $crud->add_fields(
            'ID_TOUR_PACKAGE',
            'PERSEN_POTONGAN',
            'STATUS'
        );//Fields untuk menambahkan data baru
        $crud->edit_fields(
            'ID_TOUR_PACKAGE',
            'PERSEN_POTONGAN',
            'STATUS'
        );

        $crud->display_as('ID_POTONGAN_HARGA','ID Discount');
        $crud->display_as('ID_TOUR_PACKAGE','Judul Paket');
        $crud->display_as('PERSEN_POTONGAN','Discount (%)');
        $crud->display_as('STATUS','Status Discount');
        $crud->display_as('CREATED_BY','Dibuat Oleh');
        $crud->display_as('CREATED_ON','Dibuat Pada');
        $crud->display_as('UPDATED_BY','Diperbarui Oleh');
        $crud->display_as('UPDATED_ON','Diperbarui Pada');

        //Atur rule
        $crud->set_rules('ID_TOUR_PACKAGE','Judul Paket','trim|required');
        $crud->set_rules('PERSEN_POTONGAN','Discount (%)','trim|required|integer|min_length[1]|max_length[3]');
        $crud->set_rules('STATUS','Status Discount','required');

        $crud->callback_field('STATUS', array($this, '_radiobutton_status'));

        $crud->callback_insert(array($this,'_insert_disc'));
        $crud->callback_after_update(array($this,'_after_update_disc'));
		$crud->callback_delete(array($this,'_delete_disc'));
		$crud->unset_texteditor('Description','Url');
		
        $output = $crud->render();
   
        $this-> _outputview($output);        
    }
 
    function _outputview($output = null)
    {
		$data = array(
                'title' => 'Atur Discount',
			    'body' => $output
		  );
		$this->load->helper(array('form','url'));
        $this->template_lib->load('default','content/sisantuyguide/aturdisc_view',$data);
    }
	
	function _delete_disc($primary_key){
		return $this->db->update('trx_potongan_harga',array('DELETED' => '1','UPDATED_BY'=>$this->usernameLogin,'UPDATED_ON'=>$this->getTime()),array('ID_POTONGAN_HARGA' => $primary_key));
	}
	
	function _insert_disc($post_array){
    
        //-------- Begin - Transaction DB -----------------//
        $this->db->trans_begin();
        //-------- End - Transaction DB -----------------//

        $post_array['ID_POTONGAN_HARGA'] = $this->Sisantuy_KodeGenerator_Model->getIdPotonganHarga();
        $post_array['CREATED_BY'] = $this->usernameLogin;
		$post_array['CREATED_ON'] = $this->getTime();

        $insert_disc =  $this->db->insert('trx_potongan_harga',$post_array);

        //-------- Begin - Transaction DB commit or rollback -----------------//
        if ($this->db->trans_status() == false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
        //-------- End - Transaction DB commit or rollback -----------------//
    }
    
    //function _update_kategoripromosi($post_array){
	function _after_update_disc($post_array,$primary_key){

        //-------- Begin - Transaction DB -----------------//
        $this->db->trans_begin();
        //-------- End - Transaction DB -----------------//

		$post_array['UPDATED_BY'] = $this->usernameLogin;
        $post_array['UPDATED_ON'] = $this->getTime();

        $update_disc = $this->db->update('trx_potongan_harga',$post_array,array('ID_POTONGAN_HARGA'=>$primary_key));

        //-------- Begin - Transaction DB commit or rollback -----------------//
        if ($this->db->trans_status() == false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
        //-------- End - Transaction DB commit or rollback -----------------//
    }
    
    function getTime()
	{
		$timezone  = 7;
		return gmdate("Y/m/j H:i:s", time() + 3600*($timezone+date("I"))); 
    }
    
    public function _radiobutton_status()
    {
        return ' <input type="radio" name="STATUS" value="1" /> Aktif
        <input type="radio" name="STATUS" value="0" /> Tidak Aktif';
    }
		
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */