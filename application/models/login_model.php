<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Login_model extends CI_Model{

	function _construct(){

		parent::_construct();
	}
	
	public function validate(){

		//grab user input

		 $username = $this->security->xss_clean($this->input->post('username'));
		 $password = $this->security->xss_clean($this->input->post('password'));	
		$query1 = $this->db->query("Select branch.ControlNo as branchno, branch.BranchName, personnel.ControlNo as personnelno, personnel.FirstName, personnel.MiddleName, personnel.LastName, personnel.Rank, users.Username, users.Password
from caritasbranch branch , caritaspersonnel personnel, caritasbranch_has_caritaspersonnel cp , users
where branch.ControlNo = cp.CaritasBranch_ControlNo AND cp.CaritasPersonnel_ControlNo = personnel.ControlNo AND personnel.ControlNo = users.ControlNo AND users.IsActive = 1 ");

		$q = $query1->result();
		 $size = count($q);
		 $i=0;
		 if ($query1->num_rows()>0) {
		 	while ($i<$size) {
		 		$row = $query1->row_array($i);
		 		if ($row['Username'] == $username && $row['Password']== $password) {

		 $member = $this->db->query("SELECT mm.ControlNo FROM transaction t, members_has_membersmembershipstatus mm WHERE t.Members_ControlNo  = mm.ControlNo AND t.transactiontype = 'Savings'");

		 	foreach ($member->result() as $mem) {
		  		$m = $mem->ControlNo;

		  $dormant = $this->db->query("SELECT TIMESTAMPDIFF(month, (SELECT max(t.DateTime) FROM transaction t WHERE t.Members_ControlNo = '$m' AND t.transactiontype = 'Savings' ), now()) as time ");

		  	foreach ($dormant->result() as $do) {
		  		$d = $do->time;


		  if ($d>=6){

		  		$this->db->query("UPDATE `members_has_membersmembershipstatus` SET `Status` = 'Dormant Saver', `DateUpdated` = now() WHERE `ControlNo` ='$m'");
		  		//$this->addMembershipStatus($m,"Dormant Saver");

		  }else {
		  		$this->db->query("UPDATE `members_has_membersmembershipstatus` SET `Status` = 'Active Saver', `DateUpdated` = now() WHERE `ControlNo` ='$m'");
		  		//$this->addMembershipStatus($m,"Active Saver");
		  }

		  }

		}

	$member2 = $this->db->query("SELECT mm.ControlNo FROM transaction t, members_has_membersmembershipstatus mm WHERE t.Members_ControlNo  = mm.ControlNo AND t.transactiontype = 'Loan'");

		 	foreach ($member2->result() as $mem) {
		  		$m2 = $mem->ControlNo;

		  $pdm = $this->db->query("SELECT TIMESTAMPDIFF(month, (SELECT max(t.DateTime) FROM transaction t WHERE t.Members_ControlNo = '$m2' AND t.transactiontype = 'Loan' ), now()) as time ");

		  	foreach ($pdm->result() as $do) {
		  		$p = $do->time;


		  if ($p>=6){

		  		$this->db->query("UPDATE `members_has_membersmembershipstatus` SET `Status` = 'Past Due', `DateUpdated` = now() WHERE `ControlNo` ='$m2'");
		  		//$this->addMembershipStatus($m,"Past Due");
		  }else {
		  		$this->db->query("UPDATE `members_has_membersmembershipstatus` SET `Status` = 'Borrower', `DateUpdated` = now()WHERE `ControlNo` ='$m2'");
		  		//$this->addMembershipStatus($m,"Borrower");
		  }

		  }

		}
		  		
		  	
	
		 			return $row;

		 		}
		 		$i++;	
		 	}
		 }	 
	}

	public function addMembershipStatus($ControlNo,$Status){
    $this->db->query("INSERT INTO `microfinance2`.`members_has_membersmembershipstatus` (`ControlNo`, `DateUpdated`, `Status`) VALUES ('$ControlNo', now() , '$Status');");
}

}
?>