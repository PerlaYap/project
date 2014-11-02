<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Login_model extends CI_Model{

	function _construct(){

		parent::_construct();
	}
	
	public function validate(){

		//grab user input

		$username = $this->security->xss_clean($this->input->post('username'));
		$password = $this->security->xss_clean($this->input->post('password'));
/*
		$q = $logger->result();
		 $size = count($q);
		 $i=0;
		 if ($logger->num_rows()>0) {
		 	while ($i<$size) {
		 		$row = $logger->row_array($i);
		 		if ($row['Username'] == $username && $row['Password']== $password) { */
		 			$logger=$this->db->query("SELECT branch.ControlNo as branchno, branch.BranchName, personnel.ControlNo as personnelno, personnel.FirstName, personnel.MiddleName, personnel.LastName, personnel.Rank, users.Username, users.Password
		 				FROM caritasbranch branch , caritaspersonnel personnel, caritasbranch_has_caritaspersonnel cp , users
		 				WHERE branch.ControlNo = cp.CaritasBranch_ControlNo AND cp.CaritasPersonnel_ControlNo = personnel.ControlNo AND personnel.ControlNo = users.ControlNo AND users.IsActive = 1 AND Username='$username' AND Password='$password'");
		 			
		 			
		 			if($logger->num_rows()!=0){

		 				$membersLoanChecker=$this->db->query("SELECT mem.ControlNo AS MemberControl, IFNULL(UNO.Status,NULL) AS LoanStatus, DateApplied, DOS.Status AS MembershipStatus, DateUpdated FROM Members mem
		 					LEFT JOIN (SELECT Members_ControlNo, Status, DateApplied 
		 						FROM loanapplication_has_members lhm 
		 						LEFT JOIN LoanApplication la ON lhm.LoanApplication_ControlNo=la.ControlNo
		 						GROUP BY Members_ControlNo ORDER BY Members_ControlNo ASC, DateApplied DESC)UNO
		 				ON UNO.Members_ControlNo=mem.ControlNo
		 				LEFT JOIN 
		 				(SELECT A.ControlNo, UNO.DateUpdated, UNO.Status 
		 					FROM (SELECT ControlNo FROM Members_has_MembersMembershipStatus GROUP BY ControlNo)A
		 					LEFT JOIN (SELECT * FROM (SELECT * FROM members_has_membersmembershipstatus ORDER BY DateUpdated DESC)B GROUP BY ControlNo)UNO 
		 					ON UNO.ControlNo=A.ControlNo ORDER BY ControlNo Asc, DateUpdated DESC) DOS
		 				ON mem.ControlNo=DOS.ControlNo
		 				WHERE Approved='YES'");
		 				
		 				foreach($membersLoanChecker->result() as $data){

		 					if($data->LoanStatus =="Full Payment" || $data->LoanStatus=="NULL"){
		 						$member = $this->db->query("SELECT TIMESTAMPDIFF(month, 
		 							(SELECT DateTime
		 								FROM 
		 								(SELECT * FROM Transaction 
		 									WHERE Members_ControlNo='$data->MemberControl' AND TransactionType='Savings' 
		 									ORDER BY DateTime DESC)UNO 
		 						GROUP BY Members_ControlNo  ), now()) as time ");

		 						foreach($member->result() as $number){
		 							$d=$number->time;
		 						}

		 						if ($d>=6){
		 							if($data->MembershipStatus!="dormant saver")
		 								$this->addMembershipStatus($data->MemberControl,"dormant saver");
		 						}else {
		 							if($data->MembershipStatus!="Active Saver")
		 								$this->addMembershipStatus($data->MemberControl,"Active Saver");
		 						}
		 					}

		 					else{
		 						$member = $this->db->query("SELECT TIMESTAMPDIFF(month, 
		 							(SELECT DateTime
		 								FROM 
		 								(SELECT * FROM Transaction 
		 									WHERE Members_ControlNo='$data->MemberControl' AND (TransactionType='Loan' OR TransactionType='Past Due') AND Amount>0
		 									ORDER BY DateTime DESC)UNO 
		 						GROUP BY Members_ControlNo ), now()) as time ");
		 						
		 						foreach($member->result() as $number){
		 							$d=$number->time;
		 						}

		 						if ($d>=6){
		 							if($data->MembershipStatus!="Past Due")
		 								$this->addMembershipStatus($data->MemberControl,"Past Due");
		 						}else {
		 							if($data->MembershipStatus!="Borrower")
		 								$this->addMembershipStatus($data->MemberControl,"Borrower");
		 						}

		 					}
		 				}

		 			}
		 			return $logger->row_array(0);
		 		}


		 		public function addMembershipStatus($ControlNo,$Status){
		 			$this->db->query("INSERT INTO `microfinance2`.`members_has_membersmembershipstatus` (`ControlNo`, `DateUpdated`, `Status`) VALUES ('$ControlNo', now() , '$Status');");
		 		}

		 	}
		 	?>