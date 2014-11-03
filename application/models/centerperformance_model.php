<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Centerperformance_model extends CI_Model{

	public function getperformance(){
		date_default_timezone_set('Asia/Manila');

		$currentmonth = date("m");
		$currentyear = date('Y');
		$datetoday=date('Y-m-d');
		$branch = $this->session->userdata('branchno');

		$q_result = $this->ctrperquery($currentmonth, $currentyear, $branch, $datetoday);

		return $q_result->result();
		/*echo "<br>";
		foreach ($q_result->result() as $q) {
			echo $q->pastdue;
			echo "<br>";
			echo $q->CenterNo;
		}*/

	}
	public function ctrperquery($month, $year, $branchno, $date){

	$pdcount = $this->db->query("SELECT Alpha.CenterControl, Alpha.CenterNo, IFNULL(Loan,0) AS Loan, IFNULL(PastDue,0) AS PastDue 
FROM (SELECT A.CaritasCenters_ControlNo AS CenterControl, CaritasBranch_ControlNo AS BranchControl, CenterNo FROM 
(SELECT CaritasCenters_ControlNo 
FROM caritasbranch_has_caritascenters GROUP BY CaritasCenters_ControlNo ORDER BY CaritasCenters_ControlNo ASC)A
LEFT JOIN (SELECT * FROM 
(SELECT * FROM CaritasBranch_has_CaritasCenters WHERE Date<=LAST_DAY(DATE_ADD('$year-$month-10', INTERVAL 0 MONTH))
ORDER BY CaritasCenters_ControlNo ASC, Date DESC)A GROUP BY CaritasCenters_ControlNo)B
ON A.CaritasCenters_ControlNo=B.CaritasCenters_ControlNo
LEFT JOIN CaritasCenters cc ON cc.ControlNo=A.CaritasCenters_ControlNo
WHERE CaritasBranch_ControlNo='$branchno')Alpha
LEFT JOIN
(SELECT CenterControl, CenterNo, SUM(TransactionType='Loan') AS Loan, SUM(Transactiontype='Past Due') AS PastDue 
FROM (SELECT Members_ControlNo AS MemberControl, Amount, TransactionType FROM Transaction 
WHERE (MONTH(DateTime)='$month' AND YEAR(DateTime)='$year') AND (TransactionType='Loan' OR TransactionType='Past Due'))Alpha
LEFT JOIN
(SELECT MemberControl, Alpha.CenterControl, BranchControl, CenterNo FROM (SELECT MemberControl, CaritasCenters_ControlNo AS CenterControl FROM (SELECT Members_ControlNo AS MemberControl FROM CaritasCenters_has_Members GROUP BY Members_ControlNo ORDER BY Members_ControlNo ASC)A
LEFT JOIN (SELECT * FROM (SELECT * FROM caritascenters_has_members WHERE DateEntered<=LAST_DAY(DATE_ADD('$date', INTERVAL 0 MONTH)) ORDER BY Members_ControlNo ASC, DateEntered DESC)A GROUP BY Members_ControlNo)B
ON A.MemberControl=B.Members_ControlNo)Alpha
LEFT JOIN
(SELECT A.CaritasCenters_ControlNo AS CenterControl, CaritasBranch_ControlNo AS BranchControl, CenterNo FROM 
(SELECT CaritasCenters_ControlNo 
FROM caritasbranch_has_caritascenters GROUP BY CaritasCenters_ControlNo ORDER BY CaritasCenters_ControlNo ASC)A
LEFT JOIN (SELECT * FROM 
(SELECT * FROM CaritasBranch_has_CaritasCenters WHERE Date<=LAST_DAY(DATE_ADD('$date', INTERVAL 0 MONTH))
ORDER BY CaritasCenters_ControlNo ASC, Date DESC)A GROUP BY CaritasCenters_ControlNo)B
ON A.CaritasCenters_ControlNo=B.CaritasCenters_ControlNo
LEFT JOIN CaritasCenters cc ON cc.ControlNo=A.CaritasCenters_ControlNo)Beta
ON Alpha.CenterControl=Beta.CenterControl)Beta
ON Alpha.MemberControl=Beta.MemberControl
WHERE BranchControl='$branchno' GROUP BY CenterControl)Beta
ON Alpha.CenterControl=Beta.CenterControl");
	return $pdcount;

	}

}

?>