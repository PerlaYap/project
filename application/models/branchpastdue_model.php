<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Branchpastdue_model extends CI_Model{

	public function getbranchpastdue(){
		date_default_timezone_set('Asia/Manila');

		$currentmonth = date("m");
		$currentyear = date('Y');

		$q_result = $this->branchpastdue($currentmonth, $currentyear);
	/*	foreach ($q_result as $key) {
			echo $key->pdnum."<br>";
			echo $key->BranchName."<br>";
		}*/
		return $q_result;
		
	}

	public function branchpastdue($currentmonth, $currentyear){

		$query_result= $this->db->query("SELECT loan.BranchName, pdnum, loan FROM (SELECT count(t.`TransactionType`)as pdnum, b.BranchName FROM `transaction` t join 
		`loanapplication_has_members`lhm on lhm.LoanApplication_ControlNo = t.`LoanAppControlNo` join
		`caritasbranch` b on lhm.CaritasBranch_ControlNo = b.ControlNo 
		where t.`TransactionType`='Past Due' and
		month(t.DateTime)=$currentmonth and year(t.DateTime)= $currentyear
		group by b.branchname)pd
        join(SELECT count(t.`TransactionType`)as loan, b.BranchName FROM `transaction` t join 
		`loanapplication_has_members`lhm on lhm.LoanApplication_ControlNo = t.`LoanAppControlNo` join
		`caritasbranch` b on lhm.CaritasBranch_ControlNo = b.ControlNo 
		where t.`TransactionType`='Loan' and
		month(t.DateTime)=$currentmonth and year(t.DateTime)= $currentyear
		group by b.branchname)loan
        on loan.BranchName = pd.BranchName");

		return $query_result->result();
	}


}


?>