<title>Daily Collection Sheet</title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('Assets/css/reports.css'); ?>">
	
<!-- 	<link rel="stylesheet" type="text/css" href="../../../Assets/css/reports.css"> -->

<style type="text/css" media="print">
.dontprint{
	display: none;
}


</style>
	
<?php 

 $user = $this->session->userdata('firstname');

$getCollection = $this->db->query("SELECT  CenterNo, SUM(IFNULL(ActualSavings,0)) AS ActualSavings, (COUNT(MemberControl)*50) AS TargetSavings, SUM(IF(TargetPayment23<0, 0, TargetPayment23)) AS TargetPayment23, SUM(IFNULL(ActualPayment23,0)) AS ActualPayment23,
SUM(IF(TargetPayment40<0, 0,TargetPayment40)) AS TargetPayment40, SUM(IFNULL(ActualPayment40,0)) AS ActualPayment40, SUM(IFNULL(Withdrawal,0)) AS Withdrawal, CONCAT(LastName,', ',Firstname,' ',MiddleName) AS PersonnelName
FROM
(SELECT Alpha.MemberControl, Alpha.CenterControl, CenterNo, cc.DayoftheWeek, IFNULL(ActualSavings,0) AS ActualSavings,
IFNULL(ActualPayment23,0) AS ActualPayment23, IFNULL(TargetPayment23,0) AS TargetPayment23, IFNULL(ActualPayment40,0) AS ActualPayment40, IFNULL(TargetPayment40,0) AS TargetPayment40,
IFNULL(Withdrawal,0) AS Withdrawal, IFNULL(Charlie.PersonnelControl,0) AS PersonnelControl
FROM (SELECT MemberControl, CenterControl FROM (SELECT A.ControlNo AS MemberControl, Status FROM (SELECT ControlNo FROM members_has_membersmembershipstatus GROUP BY ControlNo)A
LEFT JOIN (SELECT * fROM (SELECT * FROM members_has_membersmembershipstatus WHERE DateUpdated<'$date' ORDER BY ControlNo ASC, DateUpdated DESC)A GROUP BY ControlNo)B
ON A.ControlNo=B.ControlNo)Alpha
LEFT JOIN 
(SELECT MembersControl, B.CaritasCenters_ControlNo AS CenterControl FROM (SELECT Members_ControlNo AS MembersControl FROM caritascenters_has_members GROUP BY Members_ControlNo)A
LEFT JOIN (SELECT * FROM (SELECT * FROM CaritasCenters_has_Members WHERE DateEntered<='$date' ORDER BY Members_ControlNo ASC, DateEntered DESC)A GROUP BY Members_ControlNo)B
ON A.MembersControl=B.Members_ControlNo)Beta
ON Alpha.MemberControl=Beta.MembersControl
WHERE Status!='Terminated' AND Status!='Terminated Voluntarily')Alpha
LEFT JOIN
(SELECT CenterControl, CaritasBranch_ControlNo AS BranchControl FROM (SELECT CaritasCenters_ControlNo AS CenterControl FROM caritasbranch_has_caritascenters)A
LEFT JOIN (SELECT * FROM (SELECT * FROM caritasbranch_has_caritascenters WHERE Date<'$date' ORDER BY CaritasCenters_ControlNo ASC, Date DESC)A GROUP BY CaritasCenters_ControlNo)B
ON A.CenterControl=B.CaritasCenters_ControlNo)Beta
ON Alpha.CenterControl=Beta.CenterControl
LEFT JOIN CaritasCenters cc ON Alpha.CenterControl=cc.ControlNo
LEFT JOIN (SELECT Members_ControlNo, SUM(Amount) AS ActualSavings, CaritasPersonnel_ControlNo AS PersonnelControl 
FROM Transaction WHERE DateTime='$date' AND TransactionType='Savings' GROUP BY Members_ControlNo)Charlie
ON Alpha.MemberControl=Charlie.Members_ControlNo
LEFT JOIN
(SELECT Members_ControlNo AS MemberControl, CaritasPersonnel_ControlNo AS PersonnelControl, SUM(Amount) AS ActualPayment23 
FROM Transaction trans 
LEFT JOIN LoanApplication la ON trans.LoanAppControlNo=la.ControlNo
WHERE TransactionType='Loan' AND LoanType='23-Weeks' AND DateTime='$date'
GROUP BY Members_ControlNo)Actual23
ON Actual23.MemberControl=Alpha.MemberControl
LEFT JOIN
(SELECT Members_ControlNo AS MemberControl, CaritasPersonnel_ControlNo AS PersonnelControl, SUM(Amount) AS ActualPayment40 
FROM Transaction trans 
LEFT JOIN LoanApplication la ON trans.LoanAppControlNo=la.ControlNo
WHERE TransactionType='Loan' AND LoanType='40-Weeks' AND DateTime='$date'
GROUP BY Members_ControlNo)Actual40
ON Actual40.MemberControl=Alpha.MemberControl
LEFT JOIN
(SELECT Members_ControlNo AS MemberControl, TargetPayment23, DayoftheWeek FROM (SELECT ControlNo,(TRUNCATE((DATEDIFF('$date',DateReleased)+7)/7,0)*WeeklyPayment)-IFNULL(ActualPayment,0) AS TargetPayment23, WeeklyPayment,DayoftheWeek, LoanType
FROM (SELECT * FROM(SELECT ControlNo, (AmountRequested+Interest) AS TotalLoan, DateReleased, DATE_ADD((IF(LoanType='23-Weeks', DATE_ADD(DateReleased, INTERVAL 161 DAY), DATE_ADD(DateReleased,INTERVAL 280 DAY))), INTERVAL 0 MONTH) AS DateEnd,
IF(LoanType='23-Weeks', ROUND((AmountRequested+Interest)/23,2), ROUND((AmountRequested+Interest)/40,2)) AS Weeklypayment,DayoftheWeek, LoanType 
FROM LoanApplication WHERE (Status!='Rejected' AND Status!='Pending'))A WHERE (DateReleased<='$date' AND DateEnd>='$date'))Alpha
LEFT JOIN (SELECT LoanAppControlNo, SUM(Amount) AS ActualPayment 
FROM Transaction WHERE TransactionType='Loan' AND DateTime<'$date' GROUP BY LoanAppControlNo)Beta
ON Beta.LoanAppControlNo=Alpha.ControlNo WHERE LoanType='23-Weeks')A
LEFT JOIN
LoanApplication_has_Members lhm ON A.ControlNo=lhm.LoanApplication_ControlNo)Target23
ON Alpha.MemberControl=Target23.MemberControl
LEFT JOIN
(SELECT Members_ControlNo AS MemberControl, TargetPayment40, DayoftheWeek FROM (SELECT ControlNo,(TRUNCATE((DATEDIFF('$date',DateReleased)+7)/7,0)*WeeklyPayment)-IFNULL(ActualPayment,0) AS TargetPayment40, WeeklyPayment,DayoftheWeek, LoanType
FROM (SELECT * FROM(SELECT ControlNo, (AmountRequested+Interest) AS TotalLoan, DateReleased, DATE_ADD((IF(LoanType='23-Weeks', DATE_ADD(DateReleased, INTERVAL 161 DAY), DATE_ADD(DateReleased,INTERVAL 280 DAY))), INTERVAL 0 MONTH) AS DateEnd,
IF(LoanType='23-Weeks', ROUND((AmountRequested+Interest)/23,2), ROUND((AmountRequested+Interest)/40,2)) AS Weeklypayment,DayoftheWeek, LoanType 
FROM LoanApplication WHERE (Status!='Rejected' AND Status!='Pending'))A WHERE (DateReleased<='$date' AND DateEnd>='$date'))Alpha
LEFT JOIN (SELECT LoanAppControlNo, SUM(Amount) AS ActualPayment 
FROM Transaction WHERE TransactionType='Loan' AND DateTime<'$date' GROUP BY LoanAppControlNo)Beta
ON Beta.LoanAppControlNo=Alpha.ControlNo WHERE LoanType='40-Weeks')A
LEFT JOIN
LoanApplication_has_Members lhm ON A.ControlNo=lhm.LoanApplication_ControlNo)Target40
ON Alpha.MemberControl=Target40.MemberControl
LEFT JOIN
(SELECT Members_ControlNo AS MemberControl, SUM(Amount) AS Withdrawal FROM Transaction 
WHERE TransactionType='Withdrawal' AND DateTime='$date' GROUP BY Members_ControlNo)Withdrawal
ON Alpha.MemberControl=Withdrawal.MemberControl
WHERE BranchControl='$branchno' AND cc.DayoftheWeek='$day')Alpha
LEFT JOIN CaritasPersonnel cp ON Alpha.PersonnelControl=cp.ControlNo
GROUP BY CenterControl");
 ?>

 <?php $branchname=$this->db->query("SELECT BranchName FROM caritasbranch WHERE ControlNo='$branchno'"); 
foreach($branchname->result() as $row){
  $branchName=$row->BranchName;
}
?>
<!-- 	<img src="../../../Assets/images/caritaslogo.png" class="caritaslogo"> -->
<a href="<?php echo site_url('login/homepage'); ?>"> <img src="<?php echo base_url('Assets/images/caritaslogo.png'); ?>" class="caritaslogo"></a>
	<h3>
		CARITAS SALVE CREDIT COOPERATIVE <br> 
		Daily Collection Sheet <br>
		<?php echo $branchName ?> Branch <br> OF
		 <?php echo date('M d,Y', strtotime($date)); ?> (<?php echo $day ?>)

	</h3>

	<br>
	
	<table class="dailycollectionsheet" border="1" style="margin-left:auto; margin-right: auto;">
		<tr class="header">
			<td class="num" rowspan="2"><b>#</b></td>
			<td class="center" rowspan="2"><b>Center No.</b></td>
			<td class="SO" rowspan="2"><b>Name of SO</b></td>
			<td colspan="2" style="height: 30px;"><b>Savings Collection</b></td>
			<td colspan="4" style="height: 30px;"><b>Loan Collection</b></td>
			<td class="total" rowspan="2" style="width: 130px;"><b>Total Collection</b></td>
			<td class="center" rowspan="2" style="width: 130px;"><b>Savings Withdrawals</b></td>
		</tr>

			<tr>
				<td class="sub" style="width: 80px;"><b>Target</b></td>
				<td class="sub" style="width: 80px;"><b>Actual</b></td>
				<td class="sub" style="width: 80px;"><b>Target</b></td>
				<td class="sub" style="width: 100px;"><b>23 Wks</b></td>
				<td class="sub" style="width: 80px;"><b>Target</b></td>
				<td class="sub" style="width: 100px;"><b>40 Wks</b></td>
			</tr>

		<?php $a=1;
		$targetSavings=0;
		$target23=0;
		$target40=0;
		$actualSavings=0;
		$actual23=0;
		$actual40=0;
		$withdrawal=0;
		$totaltotal=0;

		foreach ($getCollection->result() as $row) { 
			$targetSavings+=$row->TargetSavings;
			$target23+=$row->TargetPayment23;
			$target40+=$row->TargetPayment40;
			$actualSavings+=$row->ActualSavings;
			$actual23+=$row->ActualPayment23;
			$actual40+=$row->ActualPayment40;
			$withdrawal+=$row->Withdrawal;
			?>
			<tr class="data">
				<td><?php echo $a ?></td>
				<td><?php echo $row->CenterNo ?></td>
				<td style="text-align:left;"><?php echo $row->PersonnelName ?></td>
				<td><?php echo number_format($row->TargetSavings,2) ?></td>
				<td><?php echo number_format($row->ActualSavings,2) ?></td>
				<td><?php echo number_format($row->TargetPayment23,2) ?></td>
				<td><?php echo number_format($row->ActualPayment23,2) ?></td>
				<td><?php echo number_format($row->TargetPayment40,2) ?></td>
				<td><?php echo number_format($row->ActualPayment40,2) ?></td>
				<?php 
				$totalCollection=0;
				$totalCollection=$row->ActualSavings+$row->ActualPayment23+$row->ActualPayment40; 
				$totaltotal+=$totalCollection;
				?>
				<td><?php echo number_format($totalCollection,2) ?></td>
				<td>(<?php echo number_format($row->Withdrawal,2) ?>)</td>
			</tr>
		<?php $a++; }?>

			<!--double border --><tr><td colspan="11" style="height: 2px; padding:0"></td></tr><!--double border -->
			<tr>
				<td colspan="3" style="text-align: right;"><b>Sub-total : </b></td>
				
				<!--Target (Savings)-->
				<td><?php echo number_format($targetSavings,2) ?></td>

				<!--Actual (Savings)-->
				<td><?php echo number_format($actualSavings,2) ?></td>

				<!--Target (Loan)-->
				<td><?php echo number_format($target23,2) ?></td>

				<!--23 weeks-->
				<td><?php echo number_format($actual23,2) ?></td>

				<!--Target (Loan)-->
				<td><?php echo number_format($target40,2) ?></td>

				<!--40 weeks-->
				<td><?php echo number_format($actual40,2) ?></td>

				<!--Total Collection-->
				<td><?php echo number_format($totaltotal,2) ?></td>

				<!--Savings Withdrawal-->
				<td>(<?php echo number_format($withdrawal,2) ?>)</td>
				
			</tr>

		<tr><td colspan="22" style="height: 2px; padding:0"></td></tr> <!--double border -->
			

			<tr>
				<td colspan="3" style="text-align: right;"><b>Total : </b></td>
				<!--Target (Savings)-->
				<td class="totalDC"></td>

				<!--Actual (Savings)-->
				<td class="totalDC"><?php echo number_format($actualSavings,2) ?></td>

				<!--Target (Loan)-->
				<td class="totalDC"></td>

				<!--23 weeks-->
				<td class="totalDC"><?php echo number_format($actual23,2) ?></td>

				<!--Target (Loan)-->
				<td class="totalDC"></td>

				<!--40 weeks-->
				<td class="totalDC"><?php echo number_format($actual40,2) ?></td>

				<!--Total Collection-->
				<td class="totalDC"><?php echo number_format($totaltotal,2) ?></td>

				<!--Savings Withdrawal-->
				<td class="totalDC"><?php echo number_format($withdrawal,2) ?></td>
				

			</tr>


	</table>

	<br><br>
	<div class="info">


		<br><br><br><br><br><br>

		<!-- <table style="margin-left: 50px;;">
			<tr><td class="BM">Signature of BM</td></tr>
		</table> -->


	</div>
	<br>
	<br><br><br><br><br><br><br><br><br><br>
	<div style="margin-left: 500px; margin-top: -300px;">
	<table class="signature" style="margin-left:auto; margin-right:auto;">
			<tr>
				<td class="sigBy">Prepared by:</td>
				<td class="sig"><?php echo $user ?></td>
				<td class="sigBy"> &nbsp&nbsp&nbspDate:</td>
				<td class="sig2"><?php echo date('F d, Y'); ?></td>
			</tr>
		</table>
		<br>
		<table class="signature"  style="margin-left:auto; margin-right:auto;">
			<tr>
				<td class="sigBy">Received by:</td>
				<td class="sig">&nbsp</td>
				<td class="sigBy"> &nbsp&nbsp&nbspDate:</td>
				<td class="sig2">&nbsp</td>
			</tr>
		</table>
	</div>

	<br><br><br><br><br><br><br><br><br><br><br><br><br><br>
	<div class='dontprint' style="width: 100%; text-align: center;">
		<button onclick="window.print()">Print</button>
	</div>
	