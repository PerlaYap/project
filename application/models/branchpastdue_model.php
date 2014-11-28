<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Branchpastdue_model extends CI_Model{

	public function getbranchpastdue($dateTime){
		date_default_timezone_set('Asia/Manila');

		$date=date('Y-m-d',$dateTime);

		$q_result = $this->branchpastdue($date);
	
		return $q_result;
		
	}

	public function branchpastdue($date){

		$query_result= $this->db->query("SELECT BranchName, SUM(Target) AS Target, SUM(IF(CurrentAmount<Target, CurrentAmount, Target)) AS ActualReceive, SUM(IF(Collection-Target-LastAmount<0, 0, IF(CurrentAmount<=Target,0, IF(CurrentAmount>=Collection-LastAmount, Collection-Target-LastAmount, CurrentAmount-Target)))) AS PastDue,
SUM(IF(CurrentAmount+LastAmount<Collection,0, CurrentAmount+LastAmount-Collection)) AS Advance  FROM
(SELECT CurrentTotal.ControlNo, TRUNCATE(WeeklyPayment*TodayMonth,2) AS Collection, MonthlyPayment AS Target, TRUNCATE(IFNULL(LastAmount,0),2) AS LastAmount,
TRUNCATE(IFNULL(CurrentAmount,0),2) AS CurrentAmount
FROM (SELECT ControlNo, WeeklyPayment, IF(LoanType='23-Weeks',IF(TRUNCATE(DATEDIFF(LAST_DAY(DATE_ADD('$date', INTERVAL 0 MONTH)),DateReleased)/7,0)>23,23,TRUNCATE(DATEDIFF(LAST_DAY(DATE_ADD('$date', INTERVAL 0 MONTH)),DateReleased)/7,0)), IF(TRUNCATE(DATEDIFF(LAST_DAY(DATE_ADD('$date', INTERVAL 0 MONTH)),DateReleased)/7,0)>40,40,TRUNCATE(DATEDIFF(LAST_DAY(DATE_ADD('$date', INTERVAL 0 MONTH)),DateReleased)/7,0))) AS TodayMonth
FROM (SELECT ControlNo, DateReleased, DateEnd, LoanType, WeeklyPayment, 
ROUND(((TRUNCATE(DATEDIFF(LAST_DAY(DATE_ADD('$date', INTERVAL 0 MONTH)),DateReleased)/7,0)-TRUNCATE((IF(Month(DateEnd)=Month('$date') AND YEAR(DateEnd)=YEAR('$date'),DATEDIFF(DateEnd,DateReleased)/7,DATEDIFF(LAST_DAY(DATE_ADD('$date', INTERVAL -1 MONTH)),DateReleased)/7)),0))* WeeklyPayment),2) AS MonthlyPayment
FROM 
(SELECT (AmountRequested+Interest) AS ActiveLoan, ControlNo, IF(LoanType='23-Weeks',(AmountRequested+Interest)/23, (AmountRequested+Interest)/40) AS WeeklyPayment, LoanType, DateReleased, 
DATE_ADD((IF(LoanType='23-Weeks', DATE_ADD(DateReleased, INTERVAL 161 DAY), DATE_ADD(DateReleased,INTERVAL 280 DAY))), INTERVAL 0 MONTH) AS DateEnd
FROM loanapplication 
WHERE (Status='Current' OR Status='Full Payment') AND 
(CAST(DATE_FORMAT('$date' ,CONCAT(YEAR(DateReleased),'-',MONTH(DateReleased),'-01')) as DATE)<='$date' 
AND '$date'<=LAST_DAY(DATE_ADD((IF(LoanType='23-Weeks', DATE_ADD(DateReleased, INTERVAL 161 DAY), DATE_ADD(DateReleased,INTERVAL 280 DAY))), INTERVAL 0 MONTH))))Alpha)Alpha)CurrentTotal
LEFT JOIN
(SELECT ControlNo,
ROUND(((TRUNCATE(DATEDIFF(LAST_DAY(DATE_ADD('$date', INTERVAL 0 MONTH)),DateReleased)/7,0)-TRUNCATE((IF(Month(DateEnd)=Month('$date') AND YEAR(DateEnd)=YEAR('$date'),DATEDIFF(DateEnd,DateReleased)/7,DATEDIFF(LAST_DAY(DATE_ADD('$date', INTERVAL -1 MONTH)),DateReleased)/7)),0))* WeeklyPayment),2) AS MonthlyPayment
FROM 
(SELECT ControlNo, IF(LoanType='23-Weeks',(AmountRequested+Interest)/23, (AmountRequested+Interest)/40) AS WeeklyPayment, LoanType, DateReleased, 
DATE_ADD((IF(LoanType='23-Weeks', DATE_ADD(DateReleased, INTERVAL 161 DAY), DATE_ADD(DateReleased,INTERVAL 280 DAY))), INTERVAL 0 MONTH) AS DateEnd
FROM loanapplication 
WHERE (Status='Current' OR Status='Full Payment') AND 
(CAST(DATE_FORMAT('$date' ,CONCAT(YEAR(DateReleased),'-',MONTH(DateReleased),'-01')) as DATE)<='$date' 
AND '$date'<=LAST_DAY(DATE_ADD((IF(LoanType='23-Weeks', DATE_ADD(DateReleased, INTERVAL 161 DAY), DATE_ADD(DateReleased,INTERVAL 280 DAY))), INTERVAL 0 MONTH))))Alpha)TargetCollection
ON CurrentTotal.ControlNo=TargetCollection.ControlNo
LEFT JOIN
(SELECT LoanAppControlNo, SUM(Amount) AS LastAmount FROM Transaction 
WHERE TransactionType='Loan' AND DateTime<=LAST_DAY(DATE_ADD('$date', INTERVAL -1 MONTH)) GROUP BY LoanAppControlNo)LastCollection
ON CurrentTotal.ControlNo=LastCollection.LoanAppControlNo
LEFT JOIN 
(SELECT LoanAppControlNo, SUM(Amount) AS CurrentAmount FROM Transaction 
WHERE TransactionType='Loan' AND MONTH(DateTime)=MONTH('$date') AND YEAR(DateTime)=YEAR('$date')
GROUP BY LoanAppControlNo)CurrentCollection
ON CurrentTotal.ControlNo=CurrentCollection.LoanAppControlNo)Alpha
LEFT JOIN (SELECT LoanApplication_ControlNo AS LoanControl, CaritasBranch_ControlNo AS BranchControl, CenterNo FROM loanapplication_has_members lhm
LEFT JOIN
(SELECT A.Members_ControlNo, CenterNo FROM (SELECT Members_ControlNo FROM caritascenters_has_members GROUP BY Members_ControlNo)A
LEFT JOIN (SELECT * FROM (SELECT * FROM caritascenters_has_members ORDER BY Members_ControlNo ASC, DateEntered DESC)A GROUP BY Members_ControlNo)B
ON A.Members_ControlNo=B.Members_ControlNo
LEFT JOIN caritascenters cc ON B.CaritasCenters_ControlNo=cc.ControlNo)cc
ON lhm.Members_ControlNo=cc.Members_ControlNo)Beta
ON Alpha.ControlNo=Beta.LoanControl 
LEFT JOIN caritasbranch cb ON cb.ControlNo=Beta.BranchControl
GROUP BY BranchControl ORDER BY BranchName ASC");

		return $query_result->result();
	}


}


?>