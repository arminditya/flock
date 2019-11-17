<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class AturMenu extends CI_Controller {
	var $usernameLogin;
    function __construct()
    {
        parent::__construct();
        $this->load->library('Grocery_CRUD');
        $this->load->model('Sisantuy_General_Model','',TRUE);
    }
 
    public function index()
    {		
		if($this->session->userdata('logged_in')){
			if(page_check_authorized('Manage Menu'))
			{
				$session_data = $this->session->userdata('logged_in');
				$this->usernameLogin = $session_data['username'];
                $this->_aturmenu();
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
	
	public function _aturmenu()
    {
		$crud = new grocery_CRUD();
		$crud->set_subject('Manage Menu');
		//$crud->set_theme('datatables');
		$crud->set_table('mst_menu');
        $crud->where('mst_menu.DELETED','0');

        // $crud->set_relation_n_n('FltrMitra', 'digi_targetpromosimitra', 'digi_perusahaan', 'KdPromosi', 'KodeMitra', 'NamaMitra');
        $crud->set_relation_n_n('ROLEMENU', 'trx_role_menu', 'mst_role', 'ID_MENU', 'ID_ROLE', 'NAMA_ROLE');
        
        $crud->unset_clone();
        $crud->unset_read();

		//Kolom yang ditampilkan
        $crud->columns(
            'ID_MENU',
            'NAMA_MENU',
            'ICON',
            'URL',
            'CREATED_BY',
            'CREATED_ON',
            'UPDATED_BY',
            'UPDATED_ON'
        );
        //$this->grocery_crud->fields('Username','NamaUser','Psswd','NIP','KodeMitra','EmailPribadi','EmailKantor','CreatedBy','CreatedOn');
        
        $crud->add_fields(
            'NAMA_MENU',
            'ICON',
            'URL',
            'ROLEMENU'
        );//Fields untuk menambahkan data baru
        $crud->edit_fields(
            'NAMA_MENU',
            'ICON',
            'URL',
            'ROLEMENU'
        );

        $crud->display_as('NAMA_MENU','Menu Name');
        $crud->display_as('ICON','Icon');
        $crud->display_as('URL','URL');
        $crud->display_as('ROLEMENU','Hak Akses');

        //Atur rule
        $crud->set_rules('NAMA_MENU','Menu Name','trim|required');
        $crud->set_rules('ICON','Icon','trim|required');
        $crud->set_rules('URL','URL','trim|required');
        // $crud->set_rules('ROLEMENU','Hak Akses','required');

        $crud->callback_insert(array($this,'_insert_menu'));
        $crud->callback_after_insert(array($this, '_after_insert_menu'));
        $crud->callback_after_update(array($this,'_after_update_menu'));
        $crud->callback_delete(array($this,'_delete_menu'));
        
		$crud->unset_texteditor('Description','Url');
        $output = $crud->render();
        $this-> _outputview($output);        
    }
 
    function _outputview($output = null)
    {
		$data = array(
                'title' => 'Pengaturan Menu',
			   'body' => $output
		  );
		$this->load->helper(array('form','url'));
        $this->template_lib->load('default','content/sisantuyadmin/aturmenu_view',$data);
    }
	
	function _delete_menu($primary_key){
		return $this->db->update('mst_menu',array('DELETED' => '1','UPDATED_BY'=>$this->usernameLogin,'UPDATED_ON'=>$this->getTime()),array('ID_MENU' => $primary_key));
	}
	
	function _insert_menu($post_array){
    //function _after_insert_kategoripromosi($post_array){
        // $post_array['CREATED_BY'] = $this->usernameLogin;//ganti nih
		// $post_array['CREATED_ON'] = $this->getTime();
        // return $this->db->insert('mst_menu',$post_array);
        $menu = array(
            'NAMA_MENU' => $post_array['NAMA_MENU'],
            'ICON' => $post_array['ICON'],
            'URL' => $post_array['URL'],
            'CREATED_BY' => $this->usernameLogin,
            'CREATED_ON' => $this->getTime()
        );
        print_r($menu);
        $insert_menu = $this->db->insert('mst_menu', $menu);

        // Jika query insert berhasil
        if($insert_menu){

            $find_id_menu = $this->Sisantuy_General_Model->find_id_menu($post_array['NAMA_MENU']);
            $id_menu = 0;
            foreach ($find_id_menu as $result_idmenu) {
                $id_menu = $result_idmenu->ID_MENU;
            }

            // Jika id menu ada atau tidak null
            if($id_menu != null){
                foreach ($post_array['ROLEMENU'] as $role) {
                    $data = array(
                        // 'KdTargetPromosiMitra' => $this->Kode_Model->getKdTargetPromosiMitra(),
                        'CREATED_BY' => $this->usernameLogin,
                        'CREATED_ON' => $this->getTime(),
                        'ID_ROLE' => $role,
                        'ID_MENU' => $id_menu
                    );
                    print_r($data);
                    $this->db->insert('trx_role_menu', $data);
                }
            }
            
        } 

        return true;
    }

    // public function _after_insert_menu($post_array, $primary_key)
    // {
    //     print(" masuk sini ");
    //     die(); 
    //     foreach ($post_array['ROLEMENU'] as $role) {
    //         $data = array(
    //             // 'KdTargetPromosiMitra' => $this->Kode_Model->getKdTargetPromosiMitra(),
    //             'CREATED_BY' => $this->usernameLogin,
    //             'CREATED_ON' => $this->getTime(),
    //             'ID_ROLE' => $role,
    //             'ID_MENU' => $primary_key
    //         );
    //         print_r($data);
    //         $this->db->insert('trx_role_menu', $data);
    //     }
    //     return true;
    // }
    
    //function _update_kategoripromosi($post_array){
	function _after_update_menu($post_array,$primary_key){
		// $post_array['UPDATED_BY'] = $this->usernameLogin;
        // $post_array['UPDATED_ON'] = $this->getTime();
        // return $this->db->update('mst_menu',$post_array,array('KdMenu'=>$primary_key));

        // $menu = array(
        //     'NAMA_MENU' => $post_array['NAMA_MENU'],
        //     'ICON' => $post_array['ICON'],
        //     'URL' => $post_array['URL'],
        //     'UPDATED_BY' => $this->usernameLogin,
        //     'UPDATED_ON' => $this->getTime()
        // );
        // print_r($menu);
        // $update_menu = $this->db->insert('mst_menu', $menu);

        $update_menu = $this->Sisantuy_General_Model->update_menu(
            $primary_key,
            $post_array['NAMA_MENU'],
            $post_array['ICON'],
            $post_array['URL'],
            $this->usernameLogin);
        return true;
    }
    
    function getTime()
	{
		$timezone  = 7;
		return gmdate("Y/m/j H:i:s", time() + 3600*($timezone+date("I"))); 
	}
		
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */