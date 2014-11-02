<title>Daily Collection Sheet</title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('Assets/css/reports.css'); ?>">
	
<!-- 	<link rel="stylesheet" type="text/css" href="../../../Assets/css/reports.css"> -->

<style type="text/css" media="print">
.dontprint{
	display: none;
}


</style>
	
<?php 
 $branch = $this->session->userdata('branchno');
 $user = $this->session->userdata('firstname');
$date=date('Y-m-d');
$getCollection = $this->db->query("SELECT CenterNo, concat(LastName,', ',FirstName,' ', MiddleName) AS Name , (MemberCount * 50) AS TargetSavings,  TotalSavings AS ActualSaving, 
IFNULL(Delta.Collection,0) AS Target23, Total23Loan, IFNULL(Echo.Collection,0) AS Target40, Total40Loan, SUM(TotalSavings+Total23Loan+Total40Loan) AS TotalCollected, TotalWithdrawal
FROM (SELECT  CenterControl, CaritasPersonnel_ControlNo AS PersonnelControl, SUM(Amount) AS TotalSavings, Count(Members_ControlNo) AS MemberCount FROM transaction trans 
LEFT JOIN (SELECT CaritasCenters_ControlNo AS CenterControl, Members_ControlNo AS MemberControl FROM 
(SELECT * FROM caritascenters_has_members chm WHERE Date(DateEntered)<='$date' ORDER BY DateEntered DESC) A
GROUP BY Members_ControlNo)B ON trans.Members_ControlNo=B.MemberControl
WHERE Date(DateTime)='$date' AND TransactionType='Savings' GROUP BY CenterControl, CaritasPersonnel_ControlNo)Alpha
LEFT JOIN
(SELECT  CenterControl, CaritasPersonnel_ControlNo AS PersonnelControl, SUM(Amount) AS Total23Loan FROM transaction trans 
LEFT JOIN (SELECT * FROM loanapplication_has_members lhm 
LEFT JOIN LoanApplication la ON lhm.LoanApplication_ControlNo=la.ControlNo 
LEFT JOIN (SELECT CaritasCenters_ControlNo AS CenterControl, Members_ControlNo AS MemberControl FROM 
(SELECT * FROM caritascenters_has_members chm WHERE Date(DateEntered)<='$date' ORDER BY DateEntered DESC) A
GROUP BY Members_ControlNo)B ON lhm.Members_ControlNo=B.MemberControl
WHERE Status!='Rejected')A ON trans.LoanAppControlNo=A.ControlNo 
WHERE Date(DateTime)='$date' AND (TransactionType='Loan' OR TransactionType='Past Due') AND LoanType='23-Weeks' 
GROUP BY CenterControl, CaritasPersonnel_ControlNo, LoanType) Beta
ON Alpha.CenterControl=Beta.CenterControl AND Alpha.PersonnelControl=Beta.PersonnelControl
LEFT JOIN
(SELECT  CenterControl, CaritasPersonnel_ControlNo AS PersonnelControl, SUM(Amount) AS Total40Loan FROM transaction trans 
LEFT JOIN (SELECT * FROM loanapplication_has_members lhm 
LEFT JOIN LoanApplication la ON lhm.LoanApplication_ControlNo=la.ControlNo 
LEFT JOIN (SELECT CaritasCenters_ControlNo AS CenterControl, Members_ControlNo AS MemberControl FROM 
(SELECT * FROM caritascenters_has_members chm WHERE Date(DateEntered)<='$date' ORDER BY DateEntered DESC) A
GROUP BY Members_ControlNo)B ON lhm.Members_ControlNo=B.MemberControl
WHERE Status!='Rejected')A ON trans.LoanAppControlNo=A.ControlNo 
WHERE Date(DateTime)='$date' AND (TransactionType='Loan' OR TransactionType='Past Due') AND LoanType='40-Weeks' 
GROUP BY CenterControl, CaritasPersonnel_ControlNo, LoanType) Charlie
ON Alpha.CenterControl=Charlie.CenterControl AND Alpha.PersonnelControl=Charlie.PersonnelControl
LEFT JOIN
(SELECT CaritasCenters_ControlNo AS CenterControl, SUM((ActiveRelease+IFNULL(pastdue,0))) AS Collection FROM 
(SELECT Members_ControlNo AS MemberControl, ROUND(((AmountRequested+Interest)/23),2) AS ActiveRelease FROM (SELECT * FROM LoanApplication la WHERE Status='Current' AND LoanType='23-Weeks')A 
LEFT JOIN LoanApplication_has_Members lhm ON lhm.LoanApplication_ControlNo=A.ControlNo)B
LEFT JOIN Members mem ON B.MemberControl=mem.ControlNo
LEFT JOIN caritascenters_has_members cchm ON cchm.Members_ControlNo=B.MemberControl
GROUP BY CaritasCenters_ControlNo) Delta ON Alpha.CenterControl=Delta.CenterControl
LEFT JOIN
(SELECT CaritasCenters_ControlNo AS CenterControl, SUM((ActiveRelease+IFNULL(pastdue,0))) AS Collection FROM 
(SELECT Members_ControlNo AS MemberControl, ROUND(((AmountRequested+Interest)/40),2) AS ActiveRelease FROM (SELECT * FROM LoanApplication la WHERE Status='Current' AND LoanType='40-Weeks')A 
LEFT JOIN LoanApplication_has_Members lhm ON lhm.LoanApplication_ControlNo=A.ControlNo)B
LEFT JOIN Members mem ON B.MemberControl=mem.ControlNo
LEFT JOIN caritascenters_has_members cchm ON cchm.Members_ControlNo=B.MemberControl
GROUP BY CaritasCenters_ControlNo) Echo ON Alpha.CenterControl=Echo.CenterControl
LEFT JOIN
(SELECT  CenterControl, CaritasPersonnel_ControlNo AS PersonnelControl, SUM(Amount) AS TotalWithdrawal FROM transaction trans 
LEFT JOIN (SELECT CaritasCenters_ControlNo AS CenterControl, Members_ControlNo AS MemberControl FROM 
(SELECT * FROM caritascenters_has_members chm WHERE Date(DateEntered)<='$date' ORDER BY DateEntered DESC) A
GROUP BY Members_ControlNo)B ON trans.Members_ControlNo=B.MemberControl
WHERE Date(DateTime)='$date' AND TransactionType='Withdrawal' GROUP BY CenterControl, CaritasPersonnel_ControlNo) Fox
ON Alpha.CenterControl=Fox.CenterControl AND Alpha.PersonnelControl=Fox.PersonnelControl
LEFT JOIN caritaspersonnel cp ON Alpha.PersonnelControl=cp.ControlNo
LEFT JOIN caritasCenters cc ON cc.ControlNo=Alpha.CenterControl ORDER BY CenterNo");
 ?>

 <?php $branchname=$this->db->query("SELECT BranchName FROM caritasbranch WHERE ControlNo='$branch'"); 
foreach($branchname->result() as $row){
  $branchName=$row->BranchName;
}

$extra=strtotime($date);
$day = date('l', $extra);
?>
<!-- 	<img src="../../../Assets/images/caritaslogo.png" class="caritaslogo"> -->
<a href="<?php echo site_url('login/homepage'); ?>"> <img src="<?php echo base_url('Assets/images/caritaslogo.png'); ?>" class="caritaslogo"></a>
	<h3>
		CARITAS SALVE CREDIT COOPERATIVE <br> 
		Daily Collection Sheet <br>
		<?php echo $branchName ?> Branch <br>
		 <?php echo date('M d,Y', strtotime($date)); ?> (<?php echo $day ?>)

	</h3>

	<br>

	<!--	<p style="font-size:13px;">
			Name of Branch: <b> ---- </b> 

			&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp

			Day:<b>---</b> 

			&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp

			Date: <b></b>
		</p>
	-->

	
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
		foreach ($getCollection->result() as $row) { ?>
			<tr class="data">
				<td><?php echo $a ?></td>
				<td><?php echo $row->CenterNo ?></td>
				<td style="text-align:left;"><?php echo $row->Name ?></td>
				<td><?php echo $row->TargetSavings ?></td>
				<td><?php echo $row->ActualSaving ?></td>
				<td><?php echo $row->Target23 ?></td>
				<td><?php echo $row->Total23Loan ?></td>
				<td><?php echo $row->Target40 ?></td>
				<td><?php echo $row->Total40Loan ?></td>
				<td><?php echo $row->TotalCollected ?></td>
				<td><?php echo $row->TotalWithdrawal ?></td>
			</tr>
		<?php $a++; }?>

			<!--double border --><tr><td colspan="11" style="height: 2px; padding:0"></td></tr><!--double border -->
			<tr>
				<td colspan="3" style="text-align: right;"><b>Sub-total : </b></td>
				
				<!--Target (Savings)-->
				<td></td>

				<!--Actual (Savings)-->
				<td> </td>

				<!--Target (Loan)-->
				<td></td>

				<!--23 weeks-->
				<td></td>

				<!--Target (Loan)-->
				<td></td>

				<!--40 weeks-->
				<td></td>

				<!--Total Collection-->
				<td></td>

				<!--Savings Withdrawal-->
				<td></td>
				
			</tr>

		<tr><td colspan="22" style="height: 2px; padding:0"></td></tr> <!--double border -->
			

			<tr>
				<td colspan="3" style="text-align: right;"><b>Total : </b></td>
				<!--Target (Savings)-->
				<td class="totalDC"></td>

				<!--Actual (Savings)-->
				<td class="totalDC"> </td>

				<!--Target (Loan)-->
				<td class="totalDC"></td>

				<!--23 weeks-->
				<td class="totalDC"></td>

				<!--Target (Loan)-->
				<td class="totalDC"></td>

				<!--40 weeks-->
				<td class="totalDC"></td>

				<!--Total Collection-->
				<td class="totalDC"></td>

				<!--Savings Withdrawal-->
				<td class="totalDC"></td>
				

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
				<td class="sig2"><?php echo date('F d, Y', strtotime($date)); ?></td>
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
	
		<!--<table class="dailycollectionsheet" border="1">
			<tr>
				<td colspan="3"><b>RECEIPTS</b></td>
			</tr>

			<tr>
				<td class="num">1</td>
				<td class="SO" style="text-align: left;">Opening balance</td>
				<td style="width: 90px; text-align: left;"> </td>
			</tr>
			<tr>
				<td class="num">2</td>
				<td class="SO" style="text-align: left;">Savings collection</td>
				<td style="width: 90px; text-align: left;"> </td>
			</tr>
			<tr>
				<td class="num">3</td>
				<td class="SO" style="text-align: left;">Loan collection</td>
				<td style="width: 90px; text-align: left;"> </td>
			</tr>
			<tr>
				<td class="num">4</td>
				<td class="SO" style="text-align: left;">MF/SC</td>
				<td style="width: 90px; text-align: left;"> </td>
			</tr>
			<tr>
				<td class="num">5</td>
				<td class="SO" style="text-align: left;">LI/MRF</td>
				<td style="width: 90px; text-align: left;"> </td>
			</tr>
			<tr>
				<td class="num">6</td>
				<td class="SO" style="text-align: left;">PS</td>
				<td style="width: 90px; text-align: left;"> </td>
			</tr>
			<tr>
				<td class="num">7</td>
				<td class="SO" style="text-align: left;">Others</td>
				<td style="width: 90px; text-align: left;"> </td>
			</tr>
			<tr>
				<td class="num">8</td>
				<td class="SO" style="text-align: left;">Bank withdrawal</td>
				<td style="width: 90px; text-align: left;"> </td>
			</tr>
			<tr><td colspan="3" style="height: 2px; padding:0;"></td></tr>
			<tr>
				<td colspan="2" style="text-align: left; font-weight:bold;"><b>Total Receipts</b></td>
				<td></td>
			</tr>
		</table>

		<br><br>

	<div class="miniTables">
		<table class="dailycollectionsheet" border="1">
			<tr>
				<td colspan="3"><b>PAYMENTS</b></td>
			</tr>

			<tr>
				<td class="num">1</td>
				<td class="SO" style="text-align: left;">Loan release</td>
				<td style="width: 90px; text-align: left;"> </td>
			</tr>
			<tr>
				<td class="num">2</td>
				<td class="SO" style="text-align: left;">Savings withdrawals</td>
				<td style="width: 90px; text-align: left;"> </td>
			</tr>
			<tr>
				<td class="num">3</td>
				<td class="SO" style="text-align: left;">Savings return</td>
				<td style="width: 90px; text-align: left;"> </td>
			</tr>
			<tr>
				<td class="num">4</td>
				<td class="SO" style="text-align: left;">PS return</td>
				<td style="width: 90px; text-align: left;"> </td>
			</tr>
			<tr>
				<td class="num">5</td>
				<td class="SO" style="text-align: left;">Mngt. Expenses</td>
				<td style="width: 90px; text-align: left;"> </td>
			</tr>
			<tr>
				<td class="num">6</td>
				<td class="SO" style="text-align: left;">Other payments</td>
				<td style="width: 90px; text-align: left;"> </td>
			</tr>
			<tr>
				<td class="num">7</td>
				<td class="SO" style="text-align: left;">Bank deposits</td>
				<td style="width: 90px; text-align: left;"> </td>
			</tr>

			<tr><td colspan="3" style="height: 2px; padding:0;"></td></tr>
			<tr>
				<td colspan="2" style="text-align: left; font-weight:bold;"><b>Total Payments</b></td>
				<td></td>
			</tr>
			<tr><td colspan="3" style="height: 2px; padding:0;"></td></tr>
			<tr>
				<td colspan="2" style="text-align: left; font-weight:bold;"><b>Closing Balanc</b></td>
				<td></td>
			</tr>
		</table>
	</div>-->

	