<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class editpassword_model extends CI_Model{

	function _construct(){

		parent::_construct();
	}

	public function editpwd(){

		// grab the input

		echo $current_pw =  $this->security->xss_clean($this->input->post('currentpassword'));
		echo "<br>";
		echo $personnelid =  $this->security->xss_clean($this->input->post('personnelno'));
		echo "<br>";
		echo $new_pw = $this->security->xss_clean($this->input->post('newpassword'));
		echo "<br>";
		echo $confirm_pw = $this->security->xss_clean($this->input->post('confirmpassword'));

		$this->checkcurrentpw($personnelid,$current_pw);

	}

	public function checkcurrentpw($personnelid, $current_pw){



	}
}

?>