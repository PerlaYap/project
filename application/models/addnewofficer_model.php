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
		$position  = $this->security->xss_clean($this->input->post('position'));

		if ($position=='salveofficer') {
			$position_1 = "Salve Officer";
		}elseif ($position=='branchmanager') {
			$position_1 ="Branch Manager";
		}elseif ($position=='mispersonnel') {
			$position_1="MIS Personnel";
		}

		$active='1';

		if (!empty($firstname) && !empty($lastname)) {

			$firstname = ucfirst($firstname);
			$middlename = ucfirst($middlename);
			$lastname = ucfirst($lastname);

			 $fname_initial = substr($firstname,0,1);
			 $lname_initial = substr($lastname,0,1);
			 $rannum = rand(10000,99999);

			  $username = $fname_initial.$lname_initial.$rannum;
			  
			  $password = $this->generateRandStr(10);

			 $details["Name"] = $firstname." ".$middlename." ".$lastname;
			 $details["position"] = $position_1;
			 $details["username"] = $username;
			 $details["password"] = $password;
		
			$this->addCaritasPersonnel($firstname, $middlename, $lastname, $position, $username );
        
			$control_no =   $this->getOfficersControlNumber();
    			$this->addUsers($control_no,$username, $password, $active);
				return $details;
		}else{
			return false;
		}


		
			
			
			
  	


    

    }
    public function generateRandStr($length){ 
      $randstr = ""; 
      for($i=0; $i<$length; $i++){ 
         $randnum = mt_rand(0,61); 
         if($randnum < 10){ 
            $randstr .= chr($randnum+48); 
         }else if($randnum < 36){ 
            $randstr .= chr($randnum+55); 
         }else{ 
            $randstr .= chr($randnum+61); 
         } 
      } 
      return $randstr; 
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