<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class AturDataPadok extends CI_Controller {
	var $usernameLogin;
    function __construct()
    {
        parent::__construct();
        $this->load->model('SipadokUser_Model','',TRUE);
        $this->load->model('SipadokKode_Model','',TRUE);
        $this->load->library('Grocery_CRUD');
    }
 
    public function index()
    {		
		if($this->session->userdata('logged_in')){
			if(page_check_authorized('Atur Data Padok'))
			{
				$session_data = $this->session->userdata('logged_in');
				$this->usernameLogin = $session_data['username'];
                $this->_aturdatapadok();
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
	
	public function _aturdatapadok()
    {
		$crud = new grocery_CRUD();
		$crud->set_subject('Data Padok');
		$crud->set_table('sipadok_datapadok');
        $crud->where('sipadok_datapadok.Deleted','0');
        $crud->order_by('sipadok_datapadok.KdDataPadok', 'desc');

        $crud->set_relation('Penerima', 'sipadok_user', 'NamaUser', array('Deleted' => '0','KdRole'=>'3'));
        $crud->set_relation('KdTipePadok', 'sipadok_tipepadok', 'NamaTipePaket', array('Deleted' => '0'));
        $crud->set_relation('KdJasaEkspedisi', 'sipadok_jasaekspedisi', 'NamaJasaEkspedisi', array('Deleted' => '0'));
        $crud->set_relation('KdLokasiPadok', 'sipadok_lokasipadok', 'NamaLokasiPadok', array('Deleted' => '0'));
        
        $crud->unset_clone();
        // $crud->unset_read();

		//Kolom yang ditampilkan
        $crud->columns(
            'TglPadokMasuk',
            'Pengirim',
            'Penerima',
            'KdTipePadok',
            'KdJasaEkspedisi',
            'NamaKurir',
            'KdLokasiPadok'
        );
        $crud->add_fields(
            'KdDataPadok',
            'TglPadokMasuk',
            'Penerima',
            'Pengirim',
            'KdTipePadok',
            'KdJasaEkspedisi',
            'NamaKurir',
            'NomorTelpKurir',
            'KdLokasiPadok'
        );//Fields untuk menambahkan data baru
        $crud->edit_fields(
            'TglPadokMasuk',
            'Penerima',
            'Pengirim',
            'KdTipePadok',
            'KdJasaEkspedisi',
            'NamaKurir',
            'NomorTelpKurir',
            'KdLokasiPadok'
        );
        $crud->set_read_fields(
            'TglPadokMasuk',
            'Penerima',
            'Pengirim',
            'KdTipePadok',
            'KdJasaEkspedisi',
            'NamaKurir',
            'NomorTelpKurir',
            'KdLokasiPadok'
        );

        $crud->change_field_type('KdDataPadok', 'invisible');

        // Akan ditampilkan sebagai
        $crud->display_as('KdDataPadok','Kode Data Padok *');
        $crud->display_as('TglPadokMasuk','Tanggal Padok Diterima *');
        $crud->display_as('Penerima','Nama Penerima *');
        $crud->display_as('Pengirim','Nama Pengirim *');
        $crud->display_as('KdTipePadok','Tipe Paket / Dokumen *');
        $crud->display_as('KdJasaEkspedisi','Jasa Ekspedisi *');
        $crud->display_as('NamaKurir','Nama Kurir *');
        $crud->display_as('NomorTelpKurir','Nomor Telp Kurir');
        $crud->display_as('KdLokasiPadok','Lokasi Paket Dokumen *');

        //Atur rule
        $crud->set_rules('TglPadokMasuk','Tanggal Padok Diterima *','trim|required');
        $crud->set_rules('Penerima','Nama Penerima *','trim|required');
        $crud->set_rules('Pengirim','Nama Pengirim *','trim|required|min_length[1]|max_length[150]');
        $crud->set_rules('KdTipePadok','Tipe Paket / Dokumen *','trim|required');
        $crud->set_rules('KdJasaEkspedisi','Jasa Ekspedisi *','trim|required');
        $crud->set_rules('NamaKurir','Nama Kurir *','trim|required|min_length[1]|max_length[150]');
        $crud->set_rules('NomorTelpKurir','Nomor Telp Kurir','trim|numeric');
        $crud->set_rules('KdLokasiPadok','Lokasi Paket Dokumen *','trim|required');

        $crud->callback_before_insert(array($this, '_before_insert_padok'));
        $crud->callback_after_insert(array($this, '_after_insert_padok'));
        $crud->callback_after_update(array($this,'_after_update_padok'));
		$crud->callback_delete(array($this,'_delete_padok'));
		$crud->unset_texteditor('Description','Url');
		
        $output = $crud->render();
   
        $this-> _outputview($output);        
    }
 
    function _outputview($output = null)
    {
		$data = array(
                'title' => 'Atur Data Padok',
			    'body' => $output
		  );
		$this->load->helper(array('form','url'));
        $this->template_lib->load('default','content/sipadokoa/aturdatapadok_view',$data);
    }
	
	function _delete_padok($primary_key){
		return $this->db->update('sipadok_datapadok',array('Deleted' => '1','UpdatedBy'=>$this->usernameLogin,'UpdatedOn'=>$this->getTime()),array('KdDataPadok' => $primary_key));
	}
	
	function _before_insert_padok($post_array) 
	{
        $this->db->trans_begin();

        $post_array['KdDataPadok'] = $this->SipadokKode_Model->getKdDataPadok();
        $post_array['TglPadokMasuk'] = $post_array['TglPadokMasuk'];
        $post_array['Penerima'] = $post_array['Penerima'];
        $post_array['Pengirim'] = strtoupper($post_array['Pengirim']);
        $post_array['KdTipePadok'] = $post_array['KdTipePadok'];
        $post_array['KdJasaEkspedisi'] = $post_array['KdJasaEkspedisi'];
        $post_array['NamaKurir'] = strtoupper($post_array['NamaKurir']);
        $post_array['NomorTelpKurir'] = $post_array['NomorTelpKurir'];
        $post_array['KdLokasiPadok'] = $post_array['KdLokasiPadok'];

        return $post_array;
    }

    // function _after_insert_padok($post_array,$primary_key)
	// {
    //     //--- begin - insert juga nilai ke table transaction ---//
    //     $KdTransaksiPadok = $this->SipadokKode_Model->getKdTransaksiPadok();
    //     $initialInsertTransactionPadok = $this->SipadokTransaction_Model->initialInsertTransactionPadok($KdTransaksiPadok, $post_array['KdDataPadok'], $post_array['Penerima'], $this->usernameLogin);
    //     //--- end - insert juga nilai ke table transaction ---//

    //     $createData = array (
	// 		'CreatedBy' => $this->usernameLogin,
	// 		'CreatedOn' => $this->getTime()
    //     );
        
    //     $this->db->update('sipadok_datapadok',$createData,array('KdDataPadok'=>$post_array['KdDataPadok']));
        
    //     if ($this->db->trans_status() == false) {
    //         $this->db->trans_rollback();
    //         return false;
    //     } else {
    //         $this->db->trans_commit();
    //         return true;
    //     }
    // }

    function _after_insert_padok($post_array,$primary_key)
	{
        //--- begin - insert juga nilai ke table transaction ---//
        $KdTransaksiPadok = $this->SipadokKode_Model->getKdTransaksiPadok();
        $initialInsertTransactionPadok = $this->SipadokTransaction_Model->initialInsertTransactionPadok($KdTransaksiPadok, $post_array['KdDataPadok'], $post_array['Penerima'], $this->usernameLogin);
        //--- end - insert juga nilai ke table transaction ---//

        $createData = array (
			'CreatedBy' => $this->usernameLogin,
			'CreatedOn' => $this->getTime()
        );
        
        $this->db->update('sipadok_datapadok',$createData,array('KdDataPadok'=>$post_array['KdDataPadok']));
        
        if ($this->db->trans_status() == false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
			
			//Send Email
			//tambahan begin
			
			$getPenerima = $this->SipadokTransaction_Model->getKodeUnikPengambilan($KdTransaksiPadok);
			$ValuePenerima = '';
			foreach ($getPenerima as $dt)
			{
				$ValuePenerima = $dt->Penerima;
			}
			
			$getEmailPenerima = $this->SipadokTransaction_Model->getNamaPenerima($ValuePenerima);
			$ValuePenerima = '';
			foreach ($getEmailPenerima as $dt)
			{
				$emailKantor = $dt->EmailKantor;
				$emailPribadi = $dt->EmailPribadi;
			}
			
			$subject = 'Informasi paket datang';					
			$message = "
				Dear SIPADOK user, <br><br>
				Berikut adalah informasi paket anda : <br>
				<html><body>
				<table rules=all style=border-color: #666 cellpadding=10>
				<tr><td><strong>Kode Paket/Dokumen :</strong> </td><td>".$post_array['KdDataPadok']."</td></tr>
				<tr><td><strong>Tanggal Masuk :</strong> </td><td>   ".$post_array['TglPadokMasuk']."   </td></tr>
				<tr><td><strong>Penerima:</strong> </td><td>   ".$post_array['Penerima']."   </td></tr>
				<tr><td><strong>Jenis Paket:</strong> </td><td>    ".$post_array['KdTipePadok']."   </td></tr>
				<tr><td><strong>Jenis Paket:</strong> </td><td>    ".$post_array['KdTipePadok']."   </td></tr>
				<tr><td><strong>Pengirim:</strong> </td><td>    ".$post_array['Pengirim']."   </td></tr>
				<tr><td><strong>Nama Jasa Ekspedisi:</strong> </td><td>    ".$post_array['KdJasaEkspedisi']."   </td></tr>
				<tr><td><strong>Lokasi Paket:</strong> </td><td>    ".$post_array['KdLokasiPadok']."   </td></tr>
				<tr><td><strong>Nama Kurir:</strong> </td><td>   ".$post_array['NamaKurir']."   </td></tr>
				<tr><td><strong>Telp. Kurir:</strong> </td><td>   ".$post_array['NomorTelpKurir']."   </td></tr>
				</table>
				</body></html>
				Paket anda telah sampai di mailing room, silahkan lakukan request pengambilan melalui SIPADOK.<br><br>
				regards, <br><br>
				SIPADOK Tokopedia
			";
			
			$to = $emailKantor; //aslinya ini
			$listCC = array($emailPribadi);
			if(!$this->sendEmail($subject, $message, $to, $listCC))
			{
				$message = "Gagal mengirim email, silahkan coba beberapa saat lagi.";
				echo "<script LANGUAGE='JavaScript'>
					window.alert('$message');
					</script>";
			}
			else
			{
				$message = "Email notifikasi telah terkirim.";
				echo "<script LANGUAGE='JavaScript'>
					window.alert('$message');
					</script>";
			}
			//end of tambahan
			
            return true;
        }
    }
	
	//tambahan begin
	public function sendEmail($subject, $message, $to, $listCC)
	{
		$this->load->library('email');
		
		$config = Array(
				'protocol' => 'smtp',
				'smtp_host' => 'smtp.googlemail.com',
				'smtp_port' => 465,
				'smtp_user' => 'sipadok.noreply@gmail.com',
				'smtp_pass' => 'sipadoktokped',
				'mailtype'  => 'html', 
				'charset'   => 'UTF-8'
		);
		$this->email->initialize($config);
		$this->email->set_mailtype("html");
		$this->email->set_newline("\r\n");
		
		$this->email->from('sipadok.noreply@gmail.com', 'SIPADOK TOKOPEDIA');
		$this->email->to($to);
		$this->email->cc($listCC);
		$this->email->subject($subject);
		$this->email->message($message);
		
		if($this->email->send())
		{
			return true;
		}else
		{
			return false;			
		}
	}
    
    //function _update_kategoripromosi($post_array){
	function _after_update_jasaekspedisi($post_array,$primary_key){

        //--- begin - update data ketika penerimanya berubah---//
        // 1. Ambil penerima lama
        $kdtransaksipadok = '';
        $penerima = '';
        $getPenerimaLama = $this->SipadokTransaction_Model->getPenerimaLama($primary_key);
        foreach ($getPenerimaLama as $data) {
            $kdtransaksipadok = $data->KdTransaksiPadok;
            $penerima = $data->Penerima;
        }
        // 2. Check apakah penerima berubah?
        if($post_array['Penerima'] != $penerima){ //Berubah
            // Update data
            $updatePenerimaOnTransactionPadok = $this->SipadokTransaction_Model->updatePenerimaOnTransactionPadok(
                $post_array['Penerima'], 
                $this->usernameLogin, 
                $kdtransaksipadok, 
                $primary_key);
        }
        //--- end - update data ketika penerimanya berubah---//

		$post_array['UpdatedBy'] = $this->usernameLogin;
        $post_array['UpdatedOn'] = $this->getTime();

        return $this->db->update('sipadok_datapadok',$post_array,array('KdDataPadok'=>$primary_key));
    }
    
    function getTime()
	{
		$timezone  = 7;
		return gmdate("Y/m/j H:i:s", time() + 3600*($timezone+date("I"))); 
	}
		
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */