<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*sheila nagshsissdsfdsf*/
class Addnewofficer_model extends CI_Model{


	function _construct(){

		parent::_construct();
	}

	public function get_officerdetails(){

		//grab input

		 //$username = $this->security->xss_clean($this->input->post('username'));

	    $firstname = $this->security->xss_clean($this->input->post('fname'));
		$middlename = $this->security->xss_clean($this->input->post('mname'));
		$lastname  = $this->security->xss_clean($this->input->post('lname'));

		$username  = $this->security->xss_clean($this->input->post('username'));
		$password  = $this->security->xss_clean($this->input->post('password'));
	

		$position  = $this->security->xss_clean($this->input->post('position'));
		$active  = $this->security->xss_clean($this->input->post('active'));
		

	
  	$this->addCaritasPersonnel($firstname, $middlename, $lastname, $position, $username );
        
	$control_no =   $this->getOfficersControlNumber();
    $this->addUsers($control_no,$username, $password, $active);


    
return true;
    }
	 //adding functions


 
    public function addCaritasPersonnel($firstname, $middlename, $lastname, $position, $username ) {
        $this->db->query("INSERT INTO caritaspersonnel (FirstName, MiddleName, LastName, Rank, PersonnelID) VALUES ('$firstname', '$middlename', '$lastname', '$position', '$username')");
    }

	public function addUsers($control_no, $username, $password, $active){
		$this->db->query("INSERT INTO users (ControlNo, Username, Password, IsActive) VALUES ('$control_no', '$username', '$password', '$active')");
	}



    //Members View
    
    //getting ControlNumber for other tables
    public function getOfficersControlNumber() {
        $query = $this->db->query("SELECT ControlNo FROM CaritasPersonnel ORDER BY ControlNo DESC LIMIT 1 ");

        if ($query->num_rows() > 0) {
            $row = $query->row();
            $controlNo = $row->ControlNo;
            return $controlNo;
        }
    }

    
}
?>