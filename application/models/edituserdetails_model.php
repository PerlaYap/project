<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Edituserdetails_model extends CI_Model{


	function _construct(){

		parent::_construct();
	}


	public function setdetails(){

	
			$controlno = $this->security->xss_clean($this->input->post('controlno'));

			$firstname = $this->security->xss_clean($this->input->post('fname'));
			$middlename = $this->security->xss_clean($this->input->post('mname'));
			$lastname  = $this->security->xss_clean($this->input->post('lname'));

			$username  = $this->security->xss_clean($this->input->post('username'));
			$password  = $this->security->xss_clean($this->input->post('password'));
	

			$position  = $this->security->xss_clean($this->input->post('position'));
			$active  = $this->security->xss_clean($this->input->post('active'));
			
		
			 	
			$this->updatecaritaspersonnel($controlno, $firstname, $middlename, $lastname, $position, $username);
			$this->updateusers($controlno, $username, $password, $active);

			
			return true;
     }
    public function changeposition(){
			$controlno = $this->security->xss_clean($this->input->post('controlno'));
			$position  = $this->security->xss_clean($this->input->post('position'));

			$this->updateposition($controlno, $position);
     }
    public function updateposition($controlno, $position){
     	$this->db->query("UPDATE `caritaspersonnel` SET `Rank`='$position'	WHERE `ControlNo`='$controlno';");
     }

     public  function disableuser(){
     		$controlno = $this->security->xss_clean($this->input->post('controlno'));
     		$this->db->query("UPDATE `users` SET`IsActive` = '0'
			WHERE `ControlNo`='$controlno';");
     }
     public  function enableuser(){
     		$controlno = $this->security->xss_clean($this->input->post('controlno'));
     		$this->db->query("UPDATE `users` SET`IsActive` = '1'
			WHERE `ControlNo`='$controlno';");
     }
	
	public function updatecaritaspersonnel($controlno, $firstname, $middlename, $lastname, $position, $username){
		$this->db->query("UPDATE `caritaspersonnel` SET `FirstName` = '$firstname', `MiddleName` = '$middlename',
		`LastName` = '$lastname', `Rank`='$position', `PersonnelID` = '$username'
		WHERE `ControlNo`='$controlno';");
	 }

    public function updateusers($controlno, $username, $password, $active){
		$this->db->query("UPDATE `users` SET `Username` = '$username', `IsActive` = '$active'
			WHERE `ControlNo`='$controlno';");
	 }

	public function resetpassword(){
			 $controlno = $this->security->xss_clean($this->input->post('controlno'));

			 $firstname = $this->security->xss_clean($this->input->post('fname'));
			 $middlename = $this->security->xss_clean($this->input->post('mname'));
			 $lastname  = $this->security->xss_clean($this->input->post('lname'));
			 $position  = $this->security->xss_clean($this->input->post('position'));
			 $username  = $this->security->xss_clean($this->input->post('username'));

			 $password = $this->generateRandStr(10);


			$this->db->query("UPDATE `microfinance2`.`users` SET `Password` = '$password' WHERE `users`.`ControlNo` = $controlno;");

			if ($position=='salveofficer') {
			$position_1 = "Salve Officer";
		}elseif ($position=='branchmanager') {
			$position_1 ="Branch Manager";
		}elseif ($position=='mispersonnel') {
			$position_1="MIS Personnel";
		}

			$details['Name'] = $firstname." ".$middlename." ".$lastname;
			$details['position'] = $position_1;
			$details['username'] = $username;
			$details['password'] = $password;

			return $details;



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
    
    


}



?>




