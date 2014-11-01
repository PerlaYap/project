<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Addbranch_model extends CI_Model{


	function _construct(){

		parent::_construct();
	}

	public function get_branchdetails(){

		//grab input from view

	    $id = $this->security->xss_clean($this->input->post('branchid'));
		$name = $this->security->xss_clean($this->input->post('branchname'));
		$contact  = $this->security->xss_clean($this->input->post('contactno'));

		$address  = $this->security->xss_clean($this->input->post('address'));
		$manager  = $this->security->xss_clean($this->input->post('manager'));
		$officer = $this->security->xss_clean($this->input->post('officer'));
		$officersize = count($officer);


		$this->addCaritasBranch($id, $name);

	
		$control_no = $this->getBranchControlNumber();

		


		//calling the methods to add the input above to database
		
	 // call function 

  	$this->addBranchContact($control_no, $contact);

	$this->addBranchAddress($control_no, $address);

	$this->addbranchmanager($control_no, $manager);

	for ($i=0; $i < $officersize; $i++) { 
			
			$this->addsalveofficer($control_no, $officer[$i]);
		}

	
	$result['branchname'] = $name;
	$result['result'] = true;

	return $result;
    }
	 //adding functions


 
    public function addCaritasBranch($id, $name) {
        $this->db->query("INSERT INTO caritasbranch (BranchID, BranchName) VALUES ('$id','$name')");
    }

	public function addBranchContact($control_no, $contact){
		$this->db->query("INSERT INTO branchcontact (ControlNo,ContactNo) VALUES ('$control_no', '$contact')");
	}

	public function addBranchAddress($control_no, $address){
		$this->db->query("INSERT INTO branchaddress (ControlNo,BranchAddress) VALUES ('$control_no', '$address')");
	}
	public function addbranchmanager($control_no, $manager){
		$this->db->query("INSERT INTO `microfinance2`.`caritasbranch_has_caritaspersonnel` (`CaritasBranch_ControlNo`, `CaritasPersonnel_ControlNo`) VALUES ('$control_no', '$manager')");
	}

	public function addsalveofficer($control_no, $officer){
		$this->db->query("INSERT INTO `microfinance2`.`caritasbranch_has_caritaspersonnel` (`CaritasBranch_ControlNo`, `CaritasPersonnel_ControlNo`) VALUES ('$control_no', '$officer')");
	}


    //Members View
    
    //getting ControlNumber for other tables
    public function getBranchControlNumber() {
        $query = $this->db->query("SELECT ControlNo FROM CaritasBranch ORDER BY ControlNo DESC LIMIT 1 ");

        if ($query->num_rows() > 0) {
            $row = $query->row();
            $controlNo = $row->ControlNo;
            return $controlNo;
        }
    }

    
}
?>