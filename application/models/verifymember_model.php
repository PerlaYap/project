<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Verifymember_model extends CI_Model{

	public function getverificationinfo(){
		/* $id = $this->security->xss_clean($this->input->post('branchid'));*/
		$firstname = $this->security->xss_clean($this->input->post('firstname'));
		$middlename = $this->security->xss_clean($this->input->post('middlename'));
		$lastname = $this->security->xss_clean($this->input->post('lastname'));
		$month = $this->security->xss_clean($this->input->post('month'));
		$day = $this->security->xss_clean($this->input->post('day'));
		$year = $this->security->xss_clean($this->input->post('year'));

		  //YYYY-MM-DD
		$birthdate = $year."-".$month."-".$day;
		$v_result = $this->checkifexist($firstname, $middlename, $lastname, $birthdate);
		return $v_result->result();

	}

	public function checkifexist($fname, $mname, $lname, $bdate){
		$result = $this->db->query("SELECT *  FROM `membersname`mn 
join `members`m on mn.`ControlNo`= m.`ControlNo`
join (select `CenterNo`,`BranchName`, `Members_ControlNo` from `caritascenters_has_members` cm join `caritascenters`c on cm.CaritasCenters_ControlNo = c.ControlNo join
      (Select `BranchName`, `CaritasCenters_ControlNo` from `caritasbranch` b join `caritasbranch_has_caritascenters` bc on b.ControlNo = bc.CaritasBranch_ControlNo )y on y.CaritasCenters_ControlNo = c.ControlNo
     
     )x on x.Members_ControlNo = m.ControlNo
     join `members_has_membersmembershipstatus`s on s.ControlNo = m.ControlNo
WHERE `FirstName` LIKE '%$fname%' AND `LastName` LIKE '%$lname%' AND `MiddleName` LIKE '%$mname%' and `Birthday` LIKE '$bdate'");
		return $result;

	}

}
?>