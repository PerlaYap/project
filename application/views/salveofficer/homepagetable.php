<style type="text/css">
table{
	border-collapse: collapse;
}

.header{
	padding: 10px;
	font-weight: bold;
	font-size: 12px;
	color: black;
	text-align: center;
	width: 100px;
}

.data{
	padding: 10px;
	font-size: 12px;
	color: black;
	text-align: center;
}


</style>
<?php
$datetoday = date('F d, Y');
$day = date('l');
$currentmonth = strtoupper(date("F"));
$currentyear = date('Y');

$month = array("January","February","March","April","May","June","July","August","September","October","November","December");



?>

<< ACCOUNT PERFORMANCE >>
<table border=1>

	<tr>
		<td class="header" colspan="4"><?php echo "Year ".$currentyear; ?></td>
	</tr>

	<tr>
		<td class="header" style="width: 150px;"> Month </td>
		<td class="header"> Active </td>
		<td class="header"> Past Due Mature </td>
		<td class="header"> Dormant Saver</td>
	</tr>

	<?php
	for($a=0; $a<12; $a++){
		$date=$currentyear."-".($a+1)."-"."01";
		$active = $this->db->query("SELECT COUNT(A.ControlNo) AS NoActive  FROM (SELECT ControlNo FROM Members_has_MembersMembershipStatus GROUP BY ControlNo)A
			LEFT JOIN (SELECT * FROM (SELECT * FROM Members_has_MembersMembershipStatus WHERE DateUpdated<=LAST_DAY(DATE_ADD('$date', INTERVAL 0 MONTH)) ORDER BY ControlNo ASC, DateUpdated DESC)B GROUP BY ControlNo)C
			ON A.ControlNo=C.ControlNo WHERE (Status!='Terminated' AND Status!='Terminated Voluntarily' AND Status!='Past Due' AND Status!='dormant saver')");
		$past = $this->db->query("SELECT COUNT(A.ControlNo) AS NoActive  FROM (SELECT ControlNo FROM Members_has_MembersMembershipStatus GROUP BY ControlNo)A
			LEFT JOIN (SELECT * FROM (SELECT * FROM Members_has_MembersMembershipStatus WHERE DateUpdated<=LAST_DAY(DATE_ADD('$date', INTERVAL 0 MONTH))  ORDER BY ControlNo ASC, DateUpdated DESC)B GROUP BY ControlNo)C
			ON A.ControlNo=C.ControlNo WHERE (Status!='Terminated' AND Status!='Terminated Voluntarily') AND Status='Past Due'");
		$dormant = $this->db->query("SELECT COUNT(A.ControlNo) AS NoActive  FROM (SELECT ControlNo FROM Members_has_MembersMembershipStatus GROUP BY ControlNo)A
			LEFT JOIN (SELECT * FROM (SELECT * FROM Members_has_MembersMembershipStatus WHERE DateUpdated<=LAST_DAY(DATE_ADD('$date', INTERVAL 0 MONTH)) ORDER BY ControlNo ASC, DateUpdated DESC)B GROUP BY ControlNo)C
			ON A.ControlNo=C.ControlNo WHERE (Status!='Terminated' AND Status!='Terminated Voluntarily') AND Status='dormant saver'");
		
		foreach($active->result() as $data){
			$count=$data->NoActive;
		}
		foreach($past->result() as $data1){
			$count1=$data1->NoActive;
		}
		foreach($dormant->result() as $data2){
			$count2=$data2->NoActive;
		}
		?>
		<tr>
			<td class="data"><?php echo $month[$a]; ?></td>
			<td class="data"><?php echo $count; ?></td>
			<td class="data"><?php echo $count1; ?></td>
			<td class="data"><?php echo $count2; ?></td>

		</tr>

		<?php }
		?>
	</table>



	<< CENTER PERFORMANCE >>
	<?php
	$branchno = $this->session->userdata('branchno');
	
	$targetactual = $this->db->query("SELECT BigOne.CenterControl, CenterNo, Target, Actual FROM 
		(SELECT CenterControl, CenterNo, IFNULL(SUM(MonthlyPayment),0) AS Target FROM (SELECT MemberControl, Alpha.CenterControl, BranchControl, CenterNo FROM (SELECT A.Members_ControlNo AS MemberControl, CaritasCenters_ControlNo AS CenterControl FROM (SELECT Members_ControlNo FROM caritascenters_has_members GROUP BY Members_ControlNo ORDER BY Members_ControlNo ASC)A
			LEFT JOIN (SELECT * FROM (SELECT * FROM caritascenters_has_members WHERE DateEntered<LAST_DAY(DATE_ADD(NOW(), INTERVAL 0 MONTH)) ORDER BY Members_ControlNo ASC, DateEntered DESC)A GROUP BY Members_ControlNo)B
			ON A.Members_ControlNo=B.Members_ControlNo)Alpha
LEFT JOIN
(SELECT A.CaritasCenters_ControlNo AS CenterControl, B.CaritasBranch_ControlNo AS BranchControl FROM (SELECT CaritasCenters_ControlNo FROM caritasbranch_has_caritascenters GROUP BY CaritasCenters_ControlNo)A
	LEFT JOIN (SELECT * FROM (SELECT * FROM caritasbranch_has_caritascenters WHERE Date<LAST_DAY(DATE_ADD(NOW(), INTERVAL 0 MONTH)) ORDER BY CaritasCenters_ControlNo ASC, Date DESC)A GROUP BY CaritasCenters_ControlNo)B
	ON A.CaritasCenters_ControlNo=B.CaritasCenters_ControlNo)Beta
ON Alpha.CenterControl=Beta.CenterControl
LEFT JOIN CaritasCenters cc ON cc.ControlNo=Alpha.CenterControl)Alpha
LEFT JOIN
(SELECT ControlNo, DateReleased, DateEnd,
	ROUND(((TRUNCATE(DATEDIFF(LAST_DAY(DATE_ADD(NOW(), INTERVAL 0 MONTH)),DateReleased)/7,0)-TRUNCATE((IF(Month(DateEnd)=Month(NOW()) AND YEAR(DateEnd)=YEAR(NOW()),DATEDIFF(DateEnd,DateReleased)/7,DATEDIFF(LAST_DAY(DATE_ADD(NOW(), INTERVAL -1 MONTH)),DateReleased)/7)),0))* WeeklyPayment),2) AS MonthlyPayment,
	Members_ControlNo
	FROM 
	(SELECT ControlNo, IF(LoanType='23-Weeks',(AmountRequested+Interest)/23, (AmountRequested+Interest)/40) AS WeeklyPayment, LoanType, DateReleased, 
		DATE_ADD((IF(LoanType='23-Weeks', DATE_ADD(DateReleased, INTERVAL 161 DAY), DATE_ADD(DateReleased,INTERVAL 280 DAY))), INTERVAL 0 MONTH) AS DateEnd
		FROM loanapplication 
		WHERE (Status='Current' OR Status='Full Payment') AND 
		(CAST(DATE_FORMAT(NOW() ,CONCAT(YEAR(DateReleased),'-',MONTH(DateReleased),'-01')) as DATE)<=NOW() 
			AND NOW()<=LAST_DAY(DATE_ADD((IF(LoanType='23-Weeks', DATE_ADD(DateReleased, INTERVAL 161 DAY), DATE_ADD(DateReleased,INTERVAL 280 DAY))), INTERVAL 0 MONTH))))Alpha
LEFT JOIN loanapplication_has_members lhm ON lhm.LoanApplication_ControlNo=Alpha.ControlNo)Beta
ON Alpha.MemberControl=Beta.Members_ControlNo
WHERE BranchControl='$branchno' GROUP BY CenterControl)BigOne
LEFT JOIN
(SELECT CenterControl, IFNULL(SUM(Amount),0) AS Actual FROM (SELECT MemberControl, Alpha.CenterControl, BranchControl FROM (SELECT A.Members_ControlNo AS MemberControl, CaritasCenters_ControlNo AS CenterControl FROM (SELECT Members_ControlNo FROM caritascenters_has_members GROUP BY Members_ControlNo ORDER BY Members_ControlNo ASC)A
	LEFT JOIN (SELECT * FROM (SELECT * FROM caritascenters_has_members WHERE DateEntered<LAST_DAY(DATE_ADD(NOW(), INTERVAL 0 MONTH)) ORDER BY Members_ControlNo ASC, DateEntered DESC)A GROUP BY Members_ControlNo)B
	ON A.Members_ControlNo=B.Members_ControlNo)Alpha
LEFT JOIN
(SELECT A.CaritasCenters_ControlNo AS CenterControl, B.CaritasBranch_ControlNo AS BranchControl FROM (SELECT CaritasCenters_ControlNo FROM caritasbranch_has_caritascenters GROUP BY CaritasCenters_ControlNo)A
	LEFT JOIN (SELECT * FROM (SELECT * FROM caritasbranch_has_caritascenters WHERE Date<LAST_DAY(DATE_ADD(NOW(), INTERVAL 0 MONTH)) ORDER BY CaritasCenters_ControlNo ASC, Date DESC)A GROUP BY CaritasCenters_ControlNo)B
	ON A.CaritasCenters_ControlNo=B.CaritasCenters_ControlNo)Beta
ON Alpha.CenterControl=Beta.CenterControl
LEFT JOIN CaritasCenters cc ON cc.ControlNo=Alpha.CenterControl)Alpha
LEFT JOIN
(SELECT Members_ControlNo AS MemberControl, SUM(Amount) AS Amount 
	FROM Transaction WHERE (TransactionType='Loan' OR TransactionType='Past Due') 
	AND (MONTH(DateTime)=MONTH(NOW()) AND YEAR(DateTime)=YEAR(NOW())) GROUP BY Members_ControlNo)Beta
ON Alpha.MemberControl=Beta.MemberControl WHERE BranchControl='$branchno' GROUP BY CenterControl)BigTwo
ON BigOne.CenterControl=BigTwo.CenterControl");
?>

<table border=1>
	<tr>
		<td class="header" style="width: 150px;"> Center </td>
		<td class="header"> Target </td>
		<td class="header"> Actual </td>
	</tr>

	<?php
	foreach($targetactual->result() AS $data){ ?>
	<tr>
		<td class="data"><?php echo $data->CenterNo ?></td>
		<td class="data"><?php echo $data->Target ?></td>
		<td class="data"><?php echo $data->Actual ?></td>

	</tr>

	<?php } ?>
</table>
