<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Branchpastdue_model extends CI_Model{

	public function getbranchpastdue(){
		date_default_timezone_set('Asia/Manila');

		$currentmonth = date("m");
		$currentyear = date('Y');
		$datetoday=date('Y-m-d');

		$q_result = $this->branchpastdue($currentmonth, $currentyear,$datetoday);
	/*	foreach ($q_result as $key) {
			echo $key->pdnum."<br>";
			echo $key->BranchName."<br>";
		}*/
		return $q_result;
		
	}

	public function branchpastdue($month, $year, $date){

		$query_result= $this->db->query("SELECT ControlNo, BranchID, BranchName, IFNULL(Loan,0) AS Loan, IFNULL(PastDue,0) AS PastDue FROM CaritasBranch Alpha
LEFT JOIN 
(SELECT BranchControl, SUM(TransactionType='Loan') AS Loan, SUM(TransactionType='Past Due') AS PastDue
FROM (SELECT A.CaritasCenters_ControlNo AS CenterControl, CaritasBranch_ControlNo AS BranchControl
FROM (SELECT CaritasCenters_ControlNo 
FROM caritasbranch_has_caritascenters GROUP BY CaritasCenters_ControlNo ORDER BY CaritasCenters_ControlNo ASC)A
LEFT JOIN (SELECT * FROM 
(SELECT * FROM CaritasBranch_has_CaritasCenters WHERE Date<=LAST_DAY(DATE_ADD('$date', INTERVAL 0 MONTH))
ORDER BY CaritasCenters_ControlNo ASC, Date DESC)A GROUP BY CaritasCenters_ControlNo)B
ON A.CaritasCenters_ControlNo=B.CaritasCenters_ControlNo)Alpha
LEFT JOIN CaritasCenters cc ON cc.ControlNo=Alpha.CenterControl
LEFT JOIN 
(SELECT Alpha.MemberControl, TransactionType, CenterControl FROM (SELECT Members_ControlNo AS MemberControl, transactionType 
FROM Transaction WHERE (MONTH(DateTime)='$month' AND YEAR(DateTime)='$year') AND (Transactiontype='Loan' OR TransactionType='Past Due'))Alpha
LEFT JOIN
(SELECT A.Members_ControlNo AS MemberControl, CaritasCenters_ControlNo AS CenterControl FROM (SELECT Members_ControlNo FROM caritascenters_has_members GROUP BY Members_ControlNo)A
LEFT JOIN (SELECT * FROM 
(SELECT * FROM caritascenters_has_members WHERE DateEntered<=LAST_DAY(DATE_ADD('$date', INTERVAL 0 MONTH)) 
ORDER BY Members_ControlNo ASC, DateEntered DESC)A GROUP BY Members_ControlNo)B
ON A.Members_ControlNo=B.Members_Controlno)Beta
ON Alpha.MemberControl=Beta.MemberControl)D ON Alpha.CenterControl=D.CenterControl
GROUP BY BranchControl)Beta
ON Alpha.ControlNo=Beta.BranchControl WHERE ControlNo!='1'");

		return $query_result->result();
	}


}


?>