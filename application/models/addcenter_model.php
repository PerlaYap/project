<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Addcenter_model extends CI_Model{


	function _construct(){

		parent::_construct();
	}

	public function get_centerdetails(){

		//grab input
		
	
	
		
		$branch = $this->security->xss_clean($this->input->post('branch'));
		$branchname = $this->security->xss_clean($this->input->post('branchname'));

		$centerno = $this->security->xss_clean($this->input->post('centerno'));
	
		
		$contact  = $this->security->xss_clean($this->input->post('contactno'));
		$address  = $this->security->xss_clean($this->input->post('address'));
		$day = $this->security->xss_clean($this->input->post('day'));
	
	//	$coordinator= $this->security->xss_clean($this->input->post('coordinator'));
 
  		
  //this function should be called first before getting the controlnumber of center because you need to create center and let the system generate the controlnumber

  	$this->addCaritasCenters($centerno, $day);

 	$control_no = $this->getCenterControlNumber();

  	$this->addCenterContact($control_no, $contact);

	$this->addCenterAddress($control_no, $address);
	 
	$this->updatecaritasbranch($control_no, $branchname);

	$this->addCaritasBranch_has_CaritasCenters($branch, $control_no);  

//	$this->addCaritasCenters_has_Coordinator($control_no, $coordinator);  


return true;
    }
	 //adding functions


 
    public function addCaritasCenters($centerno, $day) {
        $this->db->query("INSERT INTO CaritasCenters (`CenterNo`, `DayoftheWeek`) VALUES ('$centerno', '$day')");
    }

	public function addCenterContact($control_no, $contact){
		$this->db->query("INSERT INTO CenterContact (`ControlNo`,`ContactNo`) VALUES ('$control_no', '$contact')");
	}

	public function addCenterAddress($control_no, $address){
		$this->db->query("INSERT INTO CenterAddress(`ControlNo`,`CenterAddress`) VALUES ('$control_no', '$address')");
	}
	
	public function updatecaritasbranch($control_no, $branchname){
		$this->db->query("UPDATE `caritasbranch` SET `BranchName` ='$branchname'
		WHERE `ControlNo` ='$control_no'");
	}

	public function addCaritasBranch_has_CaritasCenters($branch, $control_no){
		$this->db->query("INSERT INTO CaritasBranch_Has_CaritasCenters (`CaritasBranch_ControlNo`, `CaritasCenters_ControlNo`,`Date`) VALUES ('$branch', '$control_no', NOW())");
	}

//	public function addCaritasCenters_has_Coordinator($control_no, $coordinator){
//		$this->db->query("INSERT INTO CaritasCenters_Has_Coordinator (`CaritasCenters_ControlNo`, `Members_ControlNo`) VALUES ('$control_no', '$coordinator')");
//	}

    //Members View
    
    //getting ControlNumber for other tables
    
    public function getCenterControlNumber() {
        $query = $this->db->query("SELECT ControlNo FROM CaritasCenters ORDER BY ControlNo DESC LIMIT 1 ");

        if ($query->num_rows() > 0) {
            $row = $query->row();
            $controlNo = $row->ControlNo;
            return $controlNo;
        }
    }
    
    

   
}

?>