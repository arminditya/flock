<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Email_Notification extends CI_Controller {
    
    function __construct()
    {
        parent::__construct();
		$this->load->model('Participans','',TRUE);
		//$this->load->library('grocery_crud');
		$this->load->library('Grocery_CRUD');
    }

    public function index()
    {		
		

		$subject = "Agenda Baru Telah Dibuat";
		$message = "
			<html><body>
			<table rules=all style=border-color: #666 cellpadding=10>
			<tr style='background: #eee'><td><strong>Agenda:</strong> </td><td>   Meeting Internal IT   </td></tr>
			<tr><td><strong>Dilaksanakan Pada:</strong> </td><td>   25 Mei 2018 Pukul 09.00 WIB   </td></tr>
			<tr><td><strong>Hingga:</strong> </td><td>   25 Mei 2018 Pukul 11.00 WIB   </td></tr>
			<tr><td><strong>Deskripsi:</strong> </td><td>    Meeting Internal IT   </td></tr>
			<tr><td><strong>Lokasi:</strong> </td><td>   Dana Pensiun Astra   </td></tr>
			<tr><td><strong>Status:</strong> </td><td>   Terjadwal   </td></tr>
			</table>
			</body></html>
		";

		$this->load->library('email');
		$this->email->from('NOREPLY@DAPENASTRA.COM', 'Dana Pensiun Astra');
		$this->email->to('holiyandahusada@gmail.com');
		$this->email->subject($subject);
		$this->email->message($message);
		
		if($this->email->send())
		{
			echo "Succesfully Sended On ". $this->getTime();
		}else
		{
			echo "Fail";			
		}
		

		

	}

	function getMessage()
	{	
		$judul = "Judul";

			$message = '<html><body>';
			$message .= '<table rules="all" style="border-color: #666;" cellpadding="10">';
			$message .= "<tr style='background: #eee;'><td><strong>Agenda:</strong> </td><td>" . "$judul ". "</td></tr>";
			$message .= "<tr><td><strong>Dilaksanakan Pada:</strong> </td><td>" . $judul . "</td></tr>";
			$message .= "<tr><td><strong>Hingga:</strong> </td><td>" . $judul . "</td></tr>";
			$message .= "<tr><td><strong>Deskripsi:</strong> </td><td>" . $judul . "</td></tr>";
			$message .= "<tr><td><strong>Lokasi:</strong> </td><td>" . $judul . "</td></tr>";
			$message .= "<tr><td><strong>Status:</strong> </td><td>" . $judul . "</td></tr>";
			$message .= "</table>";
			$message .= "</body></html>";

			return $message;
	}

	function getTime(){
		$timezone  = 7;
		return gmdate("Y/m/j H:i:s", time() + 3600*($timezone+date("I"))); 
	}

}