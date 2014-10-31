<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Editbranchdetails_model extends CI_Model{


	function _construct(){

		parent::_construct();
	}


	public function setdetails(){

	
   
	
	
			$control_no = $this->security->xss_clean($this->input->post('branchcontrol'));
			$id  = $this->security->xss_clean($this->input->post('id'));
			$contact  = $this->security->xss_clean($this->input->post('contact'));

			$address  = $this->security->xss_clean($this->input->post('address'));
			$manager  = $this->security->xss_clean($this->input->post('manager'));
			$officer  = $this->security->xss_clean($this->input->post('officer'));
			$officersize = count($officer);
		
			 
			$this->updateCaritasBranch($control_no, $id);

  			$this->updateBranchContact($control_no, $contact);

			$this->updateBranchAddress($control_no, $address);
		
			$this->deleteAllOfficer($control_no);

			$this->addOfficer($control_no, $manager);

			 $officersize;

			for ($i=0; $i < $officersize; $i++) { 
			$this->addOfficer($control_no, $officer[$i]);
		}

			
			return true;


     }

	public function updatecaritasbranch($control_no, $id){
		$this->db->query("UPDATE `caritasbranch` SET `BranchID` ='$id'
		WHERE `ControlNo` ='$control_no'");
	}

	public function updatebranchcontact($control_no, $contact){
		$this->db->query("UPDATE `branchcontact` SET `ContactNo` ='$contact'
		WHERE `ControlNo` ='$control_no'");
	}
	public function updatebranchaddress($control_no, $address){
		$this->db->query("UPDATE `branchaddress` SET `BranchAddress`='$address' WHERE `ControlNo`='$control_no'");
	}

	 public function updatemanager($control_no, $manager){
		$this->db->query("UPDATE `caritasbranch_has_caritaspersonnel` SET `CaritasPersonnel_ControlNo` = '$manager' 
			WHERE `CaritasBranch_ControlNo`='$control_no'");
	} 
	
    public function addOfficer($branchControl, $officer){
		$this->db->query("INSERT INTO `microfinance2`.`caritasbranch_has_caritaspersonnel` (`CaritasBranch_ControlNo`, `CaritasPersonnel_ControlNo`) VALUES ('$branchControl', '$officer');
");
	}   

	public function deleteAllOfficer($branchControl){
		$this->db->query("DELETE FROM `microfinance2`.`caritasbranch_has_caritaspersonnel` WHERE `CaritasBranch_ControlNo`='$branchControl';");
	}   

	

	

				}

?>




