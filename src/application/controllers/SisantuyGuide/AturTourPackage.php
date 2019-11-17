<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class AturTourPackage extends CI_Controller {
	var $usernameLogin;
    function __construct()
    {
        parent::__construct();
		$this->load->model('Sisantuy_KodeGenerator_Model','',TRUE);
		$this->load->model('Sisantuy_General_Model','',TRUE);
		//$this->load->library('grocery_crud');
        $this->load->library('Grocery_CRUD');

    }
 
    public function index()
    {		
		if($this->session->userdata('logged_in')){
			if(page_check_authorized('Manage Tour Package'))
			{
				$session_data = $this->session->userdata('logged_in');
				$this->usernameLogin = $session_data['username'];
                $this->_aturtourpackage();
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
	
	public function _aturtourpackage()
    {
		$crud = new grocery_CRUD();
		$crud->set_subject('Tour Package');
		// $crud->set_table('MST_TOUR_PACKAGE');
        // $crud->where('MST_TOUR_PACKAGE.DELETED','0');
        // $crud->order_by('MST_TOUR_PACKAGE.CREATED_ON', 'desc');
        $crud->set_table('mst_tour_package');
        $crud->where('mst_tour_package.DELETED','0');
        $crud->where('mst_tour_package.CREATED_BY', $this->usernameLogin);
        $crud->order_by('mst_tour_package.ID_TOUR_PACKAGE', 'desc');

        // SET RELATION KE PROVINSI
        // $crud->set_relation('ID_PROVINSI','MST_PROVINSI','NAMA_PROVINSI',array('DELETED' => '0'));
        $crud->set_relation('ID_PROVINSI','mst_provinsi','NAMA_PROVINSI',array('DELETED' => '0'));
        // SET RELATION KE KOTA KAB
        // $crud->set_relation('ID_KOTA_KAB','MST_KOTA_KAB','NAMA_KOTA_KAB',array('DELETED' => '0'));
        $crud->set_relation('ID_KOTA_KAB','mst_kota_kab','NAMA_KOTA_KAB',array('DELETED' => '0'));
        // SET RELATION KE MATA UANG
        // $crud->set_relation('ID_MATA_UANG','MST_MATA_UANG','NAMA_MATA_UANG',array('DELETED' => '0'));
        $crud->set_relation('ID_MATA_UANG','mst_mata_uang','SINGKATAN_MATA_UANG',array('DELETED' => '0'));

        $crud->unset_clone();

        $crud->unset_fields(
            'ID_TOUR_PACKAGE',
            'DELETED',
            'CREATED_BY',
            'CREATED_ON',
            'UPDATED_BY',
            'UPDATED_ON'
        );

		// COLUMNS
        $crud->columns(
            'JUDUL',
            'ID_PROVINSI',
            'ID_KOTA_KAB',
            'GAMBAR1',
            'ID_MATA_UANG',
            'HARGA_PAKET',
            'APPROVAL_STATUS',
            'CREATED_ON'
        );

        // ADD
        $crud->add_fields(
            'ID_TOUR_PACKAGE',
            'JUDUL',
            'ID_PROVINSI',
            'ID_KOTA_KAB',
            'GAMBAR1',
            'GAMBAR2',
            'PRODUCT_DESCRIPTION',
            'TOUR_ITINERARY',
            'SERVICES',
            'ID_MATA_UANG',
            'HARGA_PAKET',
            // 'APPROVAL_STATUS',
            // 'APPROVED_BY',
            // 'APPROVED_ON',
            'CREATED_BY',
            'CREATED_ON'
        );//Fields untuk menambahkan data baru

        // EDIT
        $crud->edit_fields(
            'JUDUL',
            'ID_PROVINSI',
            'ID_KOTA_KAB',
            'GAMBAR1',
            'GAMBAR2',
            'PRODUCT_DESCRIPTION',
            'TOUR_ITINERARY',
            'SERVICES',
            'ID_MATA_UANG',
            'HARGA_PAKET'
            // 'APPROVAL_STATUS'
        );

        // MEMBUAT FIELD JADI INVISIBLE
        $crud->change_field_type('ID_TOUR_PACKAGE', 'invisible');
        $crud->change_field_type('APPROVED_BY', 'invisible');
        $crud->change_field_type('APPROVED_ON', 'invisible');
        $crud->change_field_type('CREATED_BY', 'invisible');
        $crud->change_field_type('CREATED_ON', 'invisible');
       
        // DISPLAY AS
        $crud->display_as('JUDUL','Package Title');
        $crud->display_as('ID_PROVINSI','Province');
        $crud->display_as('ID_KOTA_KAB','City');
        $crud->display_as('GAMBAR1','Picture 1');
        $crud->display_as('GAMBAR2','Picture 2');
        $crud->display_as('PRODUCT_DESCRIPTION','Product Description');
        $crud->display_as('TOUR_ITINERARY','Tour Itinerary');
        $crud->display_as('SERVICES','Services');
        $crud->display_as('ID_MATA_UANG','Currency');
        $crud->display_as('HARGA_PAKET','Package Price');
        $crud->display_as('APPROVAL_STATUS','Approval Status');
        $crud->display_as('APPROVED_BY','Approval By');
        $crud->display_as('APPROVED_ON','Approval On');


        // UPLOAD IMAGES
        $crud->set_field_upload('GAMBAR1', 'assets/uploads/files/tourpackage');
        $crud->set_field_upload('GAMBAR2', 'assets/uploads/files/tourpackage');

        // CALLBACK FIELD
        $crud->callback_field('APPROVAL_STATUS', array($this, '_callback_field_approvalstatus'));
        // $crud->callback_field('APPROVED_BY', array($this, '_callback_field_approvedby'));
        // $crud->callback_field('APPROVED_ON', array($this, '_callback_field_approvedon'));

        // CALLBACK COLUMN
        $crud->callback_column('APPROVAL_STATUS', array($this, '_callback_column_approvalstatus'));

        // ATUR ROLE
        $crud->set_rules('JUDUL','Package Title','trim|required');
        $crud->set_rules('ID_PROVINSI','Province','trim|required');
        $crud->set_rules('ID_KOTA_KAB','City','trim|required');
        $crud->set_rules('GAMBAR1','Picture 1','trim|required');
        $crud->set_rules('GAMBAR2','Picture 2','trim|required');
        $crud->set_rules('PRODUCT_DESCRIPTION','Product Description','trim|required');
        $crud->set_rules('TOUR_ITINERARY','Tour Itinerary','trim|required');
        $crud->set_rules('SERVICES','Services','trim|required');
        $crud->set_rules('ID_MATA_UANG','Currency','trim|required');
        $crud->set_rules('HARGA_PAKET','Package Price','trim|required|integer');
        // $crud->set_rules('APPROVAL_STATUS','Approval Status');

        //Atur rule
        // $crud->set_rules('NamaRole','Nama Role','trim|required');

        $crud->callback_before_insert(array($this, '_before_insert_tour'));
        $crud->callback_after_insert(array($this, '_after_insert_tour'));
        // $crud->callback_insert(array($this,'_insert_role'));
        $crud->callback_after_update(array($this,'_after_update_tour'));
        $crud->callback_delete(array($this,'_delete_role'));
        
		$crud->unset_texteditor('Description','Url');
        $output = $crud->render();
        $this-> _outputview($output);        
    }
 
    function _outputview($output = null)
    {
		$data = array(
                'title' => 'Manage Tour Package',
			    'body' => $output
		  );
		$this->load->helper(array('form','url'));
        //$this->template_lib->load('default','content/promotion/promotion_data_view',$data);
        $this->template_lib->load('default','content/sisantuyguide/aturtourpackage_view',$data);
    }
	
	function _delete_role($primary_key){

        //-------- Begin - Transaction DB -----------------//
        $this->db->trans_begin();
        //-------- End - Transaction DB -----------------//

        // //-------- Begin - Hapus Discount -----------------//
        // // Check di trx_potongan_harga apakah paket ini ada potongan harganya, jika ada deactived
        // $check_is_exist_disc = $this->Sisantuy_General_Model->find_id_potongan($primary_key);
        // print_r($check_is_exist_disc);
        // $IdPotonganHarga = "";
        // foreach ($check_is_exist_disc as $datadisc) {
        //     print(" [ Masuk ke foreach potongan; ");
        //     $IdPotonganHarga = $datadisc->ID_POTONGAN_HARGA;
        //     print(" IdPotonganHarga = ".$IdPotonganHarga."; ");

        //     // Jika IdPotonganHarga ada (not null) deactive satupersatu
        //     if($IdPotonganHarga =! NULL || $IdPotonganHarga =! ""){
        //         print(" IdPotonganHarga NOT NULL ");
        //         $delete_disc = $this->Sisantuy_General_Model->delete_discount($IdPotonganHarga,$this->usernameLogin);
        //         // $delete_disc = $this->db->update('trx_potongan_harga',array(
        //         //     'DELETED' => '1',
        //         //     'UPDATED_BY'=>$this->usernameLogin,
        //         //     'UPDATED_ON'=>$this->getTime()),
        //         //     array('ID_POTONGAN_HARGA' => $IdPotonganHarga));
        //         print(" Udah di delete ");
        //     }else{
        //         print(" IdPotonganHarga NOT NULL ");
        //     }
        // }
        // //-------- End - Hapus Discount -----------------//

        // //-------- Begin - Hapus di table harga -----------------//
        // // Check di trx_potongan_harga apakah paket ini ada potongan harganya, jika ada deactived
        // $check_is_exist_harga = $this->Sisantuy_General_Model->find_id_tour_harga($primary_key);
        // $IdTourHarga = "";
        // foreach ($check_is_exist_harga as $dataharga) {
        //     $IdTourHarga = $dataharga->ID_TOUR_HARGA;

        //     // Jika IdPotonganHarga ada (not null) deactive satupersatu
        //     if($IdTourHarga =! NULL || $IdTourHarga =! ""){
        //         $delete_harga = $this->Sisantuy_General_Model->delete_tour_harga($IdTourHarga,$this->usernameLogin);
        //         // $delete_harga = $this->db->update('trx_tour_harga',array(
        //         //     'DELETED' => '1',
        //         //     'UPDATED_BY'=>$this->usernameLogin,
        //         //     'UPDATED_ON'=>$this->getTime()),
        //         //     array('ID_TOUR_HARGA' => $IdTourHarga));
        //     }
        // }
        // //-------- End - Hapus di table harga -----------------//

        // die();

        $delete_disc = $this->Sisantuy_General_Model->delete_discount_by_idtour($primary_key,$this->usernameLogin);
        $delete_harga = $this->Sisantuy_General_Model->delete_tour_harga_by_idtour($primary_key,$this->usernameLogin);

        $delete_tour = $this->db->update('mst_tour_package',array(
            'DELETED' => '1',
            'UPDATED_BY'=>$this->usernameLogin,
            'UPDATED_ON'=>$this->getTime()),
            array('ID_TOUR_PACKAGE' => $primary_key));
    
    
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
    
    public function _before_insert_tour($post_array)
    {

        //-------- Begin - Transaction DB -----------------//
        $this->db->trans_begin();
        //-------- End - Transaction DB -----------------//

        $post_array['ID_TOUR_PACKAGE'] = $this->Sisantuy_KodeGenerator_Model->getIdTourPackage();
        $post_array['CREATED_BY'] = $this->usernameLogin;
        $post_array['CREATED_ON'] = $this->getTime();
        
        return $post_array;
    }

	public function _after_insert_tour($post_array, $primary_key)
    {


        // $post_array['CreatedBy'] = $this->usernameLogin;//ganti nih
		// $post_array['CreatedOn'] = $this->getTime();

        // return $this->db->insert('sipadok_role',$post_array);

        //-------- Begin - Atur nilai dari variable-variable yang dibutuhkan -----------------//
        $idtourharga = $this->Sisantuy_KodeGenerator_Model->getIdTourHarga();
        $idtourpackage = $post_array['ID_TOUR_PACKAGE'];
        $idmatauang = $post_array['ID_MATA_UANG'];
        $hargapaket = $post_array['HARGA_PAKET'];
        $createdby = $this->usernameLogin;
        //-------- End - Atur nilai dari variable-variable yang dibutuhkan -----------------//

        //-------- Begin - Perhitungan pajak -----------------//
        $JenisFeePPN = "";
        $NamaFeePPN = "";
        $PresentasePPN = 0;
        $JenisFeeAdmin = "";
        $NamaFeeAdmin = "";
        $PresentaseAdmin = 0;

        // 1. Get tax PPN
        $jenisfee = "PPN";
        $find_ppn = $this->Sisantuy_General_Model->find_fee($jenisfee);
        foreach ($find_ppn as $data_ppn) {
            $JenisFeePPN = $data_ppn->JENIS_FEE;
            $NamaFeePPN = $data_ppn->NAMA_FEE;
            $PresentasePPN = $data_ppn->PERSENTASE;
        }

        // 2. Get Admin fee
        $jenisfee = "FADM";
        $find_adm = $this->Sisantuy_General_Model->find_fee($jenisfee);
        foreach ($find_adm as $data_adm) {
            $JenisFeeAdm = $data_adm->JENIS_FEE;
            $NamaFeeAdm = $data_adm->NAMA_FEE;
            $PresentaseAdm = $data_adm->PERSENTASE;
        }

        // 3. Perhitungan biaya admin dan pajak ppn
        $ppn = $hargapaket * ($PresentasePPN/100);
        $adminfee = $hargapaket * ($PresentaseAdm/100);
        //-------- End - Perhitungan pajak -----------------//

        //-------- Begin - Insert harga tour package -----------------//
        $insertHargaTour = $this->Sisantuy_General_Model->insert_harga_tour(
            $idtourharga,$idtourpackage,$idmatauang,$hargapaket,$ppn,$adminfee,$createdby
        );
        //-------- End - Insert harga tour package -----------------//

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
    
	function _after_update_tour($post_array,$primary_key){

        //-------- Begin - Transaction DB -----------------//
        $this->db->trans_begin();
        //-------- End - Transaction DB -----------------//

        //-------- Begin - Update data ke MST_TOUR_PACKAGE -----------------//
		$post_array['UpdatedBy'] = $this->usernameLogin;
        $post_array['UpdatedOn'] = $this->getTime();
        $update_tour =  $this->db->update('mst_tour_package',$post_array,array('ID_TOUR_PACKAGE'=>$primary_key));
        //-------- End - Update data ke MST_TOUR_PACKAGE -----------------//

        //-------- Begin - Apabila terjadi update maka harga akan diinsert lagi ke TRX_TOUR_HARGA -----------------//
        $idtourharga = $this->Sisantuy_KodeGenerator_Model->getIdTourHarga();
        $idtourpackage = $primary_key;
        $idmatauang = $post_array['ID_MATA_UANG'];
        $hargapaket = $post_array['HARGA_PAKET'];
        $createdby = $this->usernameLogin;
        //-------- End - Apabila terjadi update maka harga akan diinsert lagi ke TRX_TOUR_HARGA -----------------//

        //-------- Begin - Perhitungan pajak -----------------//
        $JenisFeePPN = "";
        $NamaFeePPN = "";
        $PresentasePPN = 0;
        $JenisFeeAdmin = "";
        $NamaFeeAdmin = "";
        $PresentaseAdmin = 0;

        // 1. Get tax PPN
        $jenisfee = "PPN";
        $find_ppn = $this->Sisantuy_General_Model->find_fee($jenisfee);
        foreach ($find_ppn as $data_ppn) {
            $JenisFeePPN = $data_ppn->JENIS_FEE;
            $NamaFeePPN = $data_ppn->NAMA_FEE;
            $PresentasePPN = $data_ppn->PERSENTASE;
        }

        // 2. Get Admin fee
        $jenisfee = "FADM";
        $find_adm = $this->Sisantuy_General_Model->find_fee($jenisfee);
        foreach ($find_adm as $data_adm) {
            $JenisFeeAdm = $data_adm->JENIS_FEE;
            $NamaFeeAdm = $data_adm->NAMA_FEE;
            $PresentaseAdm = $data_adm->PERSENTASE;
        }

        // 3. Perhitungan biaya admin dan pajak ppn
        $ppn = $hargapaket * ($PresentasePPN/100);
        $adminfee = $hargapaket * ($PresentaseAdm/100);
        //-------- End - Perhitungan pajak -----------------//

        //-------- Begin - Insert harga tour package -----------------//
        $insertHargaTour = $this->Sisantuy_General_Model->insert_harga_tour(
            $idtourharga,$idtourpackage,$idmatauang,$hargapaket,$ppn,$adminfee,$createdby
        );
        //-------- End - Insert harga tour package -----------------//

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

    public function _callback_field_approvalstatus($value, $primary_key = null)
    {
        if ($value == '0') {
            return "Belum Disetujui";
        } elseif ($value == '1') {
            return "Disetujui";
        } else {
            return "Data Not Valid";
        }
    }

    public function _callback_column_approvalstatus($value, $row)
    {
        if ($value == '0') {
            return "Belum Disetujui";
        } elseif ($value == '1') {
            return "Disetujui";
        } else {
            return "Data Not Valid";
        }
    }
    
    function getTime()
	{
		$timezone  = 7;
		return gmdate("Y/m/j H:i:s", time() + 3600*($timezone+date("I"))); 
	}
		
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */