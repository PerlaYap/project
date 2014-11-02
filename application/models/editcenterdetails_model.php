<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');





class Editcenterdetails_model extends CI_Model{


	function _construct(){

		parent::_construct();
	}


	public function setdetails(){


		$control_no = $this->security->xss_clean($this->input->post('control'));
		$number = $this->security->xss_clean($this->input->post('number'));
		$contact  = $this->security->xss_clean($this->input->post('contact'));

		$address  = $this->security->xss_clean($this->input->post('address'));
		$day  = $this->security->xss_clean($this->input->post('day'));
	
		

  			$this->updateCaritasCenters($control_no, $number, $day);
  			
  			$this->updateCenterContact($control_no, $contact);

			$this->updateCenterAddress($control_no, $address);

			

		//	$this->updatecaritascenters_has_members($control_no, $coordinator);
	

$coordinator = $this->db->query("SELECT CONCAT(m.FirstName,' ', m.MiddleName, ' ', m.LastName) AS Name, m.ControlNo AS Control
				 FROM membersname m, CaritasCenters_has_Coordinator cc, CaritasBranch_has_CaritasCenters bc
				WHERE m.ControlNo = cc.Members_ControlNo AND cc.CaritasCenters_ControlNo = '$control_no' AND 
				cc.CaritasCenters_ControlNo = bc.CaritasCenters_ControlNo ");

foreach ($coordinator->result() as $coo) {
	$preselected = $coo->Name;

}		

$coordinator  = $this->security->xss_clean($this->input->post('coordinator'));

if (!empty($preselected)){ 

			$this->updateCaritasCenters_has_Coordinator($control_no, $coordinator);  
} else {

	$this->addCaritasCenters_has_Coordinator($control_no, $coordinator);  
}
			
			$result['result'] = true;
			$result['centerno'] = $number;


			return $result;


     }

	public function updatecaritascenters($control_no, $number, $day){
		$this->db->query("UPDATE `caritascenters` SET `CenterNo` ='$number', `DayoftheWeek` = '$day'
		WHERE `ControlNo` ='$control_no';");
	}
	
	public function updatecentercontact($control_no, $contact){
		$this->db->query("UPDATE `centercontact` SET `ContactNo` ='$contact'
		WHERE `ControlNo` ='$control_no';");
	}
	public function updatecenteraddress($control_no, $address){
		$this->db->query("UPDATE `centeraddress` SET `CenterAddress`='$address' WHERE `ControlNo`='$control_no';");
	}
	
 //   public function updatecaritascenters_has_members($control_no, $coordinator){
//		$this->db->query("UPDATE `caritascenters_has_members` SET `Members_ControlNo` = '$coordinator' 
//			WHERE `CaritasCenters_ControlNo`='$control_no';");
//	}   
	
	public function addCaritasCenters_has_Coordinator($control_no, $coordinator){
		$this->db->query("INSERT INTO CaritasCenters_has_Coordinator(`CaritasCenters_ControlNo`, `Members_ControlNo`) 
		VALUES ('$control_no', '$coordinator');");
	}  

	public function updateCaritasCenters_has_Coordinator($control_no, $coordinator){
		$this->db->query("UPDATE `CaritasCenters_has_Coordinator` SET `Members_ControlNo` = '$coordinator' 
		WHERE `CaritasCenters_ControlNo` = '$control_no';");
	}  

}



?>
