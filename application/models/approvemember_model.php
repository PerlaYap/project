<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Approvemember_model extends CI_Model{

	function _construct(){

		parent::_construct();
	}

	public function getcontrolno(){
		$controlno = $this->security->xss_clean($this->input->post('controlno'));

		return $controlno;
	}

	public function approve(){

		$controlno = $this->getcontrolno();
		/*$controlno = $this->security->xss_clean($this->input->post('controlno'));*/
		//Sql statement for updating application status -> Approved
		$query = $this->db->query("UPDATE `microfinance2`.`members` SET `Approved` = 'YES' WHERE `members`.`ControlNo` = $controlno;");
		$this->addMembersStatus($controlno);
		if($query){
			return "True";
		}else{
			return "False";
		}

	}
	

	public function addmemberid(){

		$controlno = $this->getcontrolno();
		$memberid = $this->security->xss_clean($this->input->post('memberid'));

		$query = $this->db->query("UPDATE `microfinance2`.`members` SET `MemberID` = '$memberid' WHERE `members`.`ControlNo` = $controlno;");
		if($query){
			return "True";
		}else{
			return "False";
		}


	}

	public function addMembersStatus($controlNo) {
		$this->db->query("INSERT INTO members_has_membersmembershipstatus(`ControlNo`, `DateUpdated`, `Status`) VALUES ('$controlNo', NOW(), 'Active')");
	}
}
?>