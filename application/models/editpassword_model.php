<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class editpassword_model extends CI_Model{

	function _construct(){

		parent::_construct();
	}

	public function editpwd(){

		// grab the input

		/*echo*/ $current_pw =  $this->security->xss_clean($this->input->post('currentpassword'));
		/*echo "<br>";*/
		/*echo*/ $personnelid =  $this->security->xss_clean($this->input->post('personnelno'));
		/*echo "<br>";*/
		/*echo*/ $new_pw = $this->security->xss_clean($this->input->post('newpassword'));
		/*echo "<br>";*/
		/*echo*/ $confirm_pw = $this->security->xss_clean($this->input->post('confirmpassword'));

		$current = $this->checkcurrentpw($personnelid,$current_pw);

		if ($current == true) {
			/*echo "Correct password entered";*/
			if ($new_pw == $confirm_pw) {
						/*echo "correct new password.";*/
						$this->updatepassword($personnelid, $new_pw);
					$message = "PS";

				}else{
				 	$message = "WCoP";
				}

		}else{
					$message = "WCuP";				
		}

		return $message;

	}

	public function checkcurrentpw($personnelid, $current_pw){

		$result = $this->db->query("SELECT `Password` FROM `users` WHERE `ControlNo` = $personnelid");
		if ($result->num_rows() > 0) {
            $row = $result->row();
            $pwd = $row->Password;
        }
        if ($pwd == $current_pw) {
        	return true;
        }else{
        	return false;
        }
	}

	public function updatepassword($personnelid, $new_pw){
		$this->db->query("UPDATE `microfinance2`.`users` SET `Password` = '$new_pw' WHERE `users`.`ControlNo` = $personnelid;");

	}
}

?>