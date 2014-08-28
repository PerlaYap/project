<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Centerperformance_model extends CI_Model{

	public function getperformance(){
		date_default_timezone_set('Asia/Manila');

		$currentmonth = date("m");
		$currentyear = date('Y');
		$branch = $this->session->userdata('branchno');

		$q_result = $this->ctrperquery($currentmonth, $currentyear, $branch);

		return $q_result->result();
		/*echo "<br>";
		foreach ($q_result->result() as $q) {
			echo $q->pastdue;
			echo "<br>";
			echo $q->CenterNo;
		}*/

	}
	public function ctrperquery($currentmonth, $currentyear, $branchno){

	$pdcount = $this->db->query("SELECT loan.CenterNo, pastdue, loan FROM (SELECT  count(t.`TransactionType`) as pastdue ,m.CenterNo FROM `transaction` t 
				join (SELECT cm.`CaritasCenters_ControlNo`, cm.`Members_ControlNo`, c.CenterNo, bc.CaritasBranch_ControlNo as branch FROM `caritascenters_has_members` cm
				join `caritascenters` c on c.ControlNo = cm.`CaritasCenters_ControlNo`
				join `caritasbranch_has_caritascenters`bc
				on bc.CaritasCenters_ControlNo = c.ControlNo) m
				on t.`Members_ControlNo` = m.`Members_ControlNo`
				where t.`TransactionType` = 'Past Due' and month(t.`DateTime`)='$currentmonth' and year(t.DateTime)='$currentyear' and m.branch = '$branchno' group by m.CenterNo)pd
                join (SELECT  count(t.`TransactionType`) as loan ,m.CenterNo FROM `transaction` t 
				join (SELECT cm.`CaritasCenters_ControlNo`, cm.`Members_ControlNo`, c.CenterNo, bc.CaritasBranch_ControlNo as branch FROM `caritascenters_has_members` cm
				join `caritascenters` c on c.ControlNo = cm.`CaritasCenters_ControlNo`
				join `caritasbranch_has_caritascenters`bc
				on bc.CaritasCenters_ControlNo = c.ControlNo) m
				on t.`Members_ControlNo` = m.`Members_ControlNo`
				where t.`TransactionType` = 'Loan' and month(t.`DateTime`)='$currentmonth' and year(t.DateTime)='$currentyear' and m.branch = '$branchno' group by m.CenterNo)loan
                on pd.CenterNo = loan.CenterNo");
	return $pdcount;

	}

}

?>