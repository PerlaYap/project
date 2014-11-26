<title>Daily Collection Summary</title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('Assets/css/dailycollection.css'); ?>">
<script src="<?php echo base_url('Assets/js/dailycollection.js'); ?>"></script>

<style media="screen">
.noPrint{ display: block; }
.yesPrint{ display: block !important; }
</style>

<style media="print">
.noPrint{ display: none; }
.yesPrint{ display: block !important; }
</style>

<script type="text/javascript">
	

	function send(control_no){

		window.location.href= "editcollection?name="+ control_no;
	} 
</script>

<?php
$user = $this->session->userdata('firstname');
 	$userrank = $this->session->userdata('rank');
	$name = $this->session->userdata('firstname');
	 $datetoday = date('F d, Y');
 		$branchno = $this->session->userdata('branchno');
	$getManager=$this->db->query("SELECT CONCAT(`FirstName`,' ',  `MiddleName`,' ', `LastName`) AS NAME FROM CaritasPersonnel CL 
											JOIN CARITASBRANCH_HAS_CARITASPERSONNEL BP ON CL.CONTROLNO = BP.CARITASPERSONNEL_ControlNo
											JOIN CARITASBRANCH B ON BP.CARITASBRANCH_CONTROLNO = B.CONTROLNO
											
														WHERE CL.RANK = 'BRANCHMANAGER' 
														AND B.ControlNo = $branchno ");
	foreach ($getManager->result() as $row){ 
		$Manager=$row->NAME;
	}

$wordDate=date('M d, Y', strtotime($reportDate));
?>


<?php 
$getDailyCollection = $this->db->query("SELECT Sky.MemberControl, MemberID, Name, IFNULL(ActiveLoan,0) AS ActiveLoan, (IFNULL(ActiveLoan,0)-IFNULL(TotalPaid,0)) AS LoanLeft, 
	IFNULL(Loan.ControlNo,'N/A') AS LoanControl, IFNULL(Loan.Amount,0) AS LoanPayment, IFNULL(PastDue.ControlNo,'N/A') AS PastDueControl, IFNULL(PastDue.Amount,0) AS PastDuePayment, 
	IFNULL(Savings.ControlNo, 'N/A') AS SavingsControl, IFNULL(Savings.Amount,0) AS SavingsPayment, IFNULL(Withdrawal.ControlNo,'N/A') AS WithdrawalControl, IFNULL(Withdrawal.Amount,0) AS WithdrawalPayment
	FROM (SELECT MemberID, Z.MemberControl, concat(LastName,', ',FirstName,' ', MiddleName) AS Name , ActiveLoan FROM (SELECT Members_ControlNo AS MemberControl FROM 
		(SELECT * FROM caritascenters_has_members chm WHERE Date(DateEntered)<='$reportDate' ORDER BY DateEntered DESC) A
		WHERE CaritasCenters_ControlNo='$centerControl' GROUP BY Members_ControlNo)Z
LEFT JOIN (SELECT MemberControl, (AmountRequested +Interest) AS ActiveLoan 
	FROM(SELECT Members_ControlNo AS MemberControl, LoanAppControlNo FROM Transaction WHERE Date(DateTime)='$reportDate' GROUP BY LoanAppControlNo)A
	LEFT JOIN loanapplication la ON la.ControlNo=A.LoanAppControlNo)Y ON Z.MemberControl=Y.MemberControl
LEFT JOIN membersname mn ON mn.ControlNo=Z.MemberControl
LEFT JOIN Members mem ON mem.ControlNo=Z.MemberControl) Sky
LEFT JOIN
(SELECT MemberControl, LoanControl, SUM(Amount) AS TotalPaid FROM (SELECT * FROM transaction trans WHERE TransactionType='Loan' OR TransactionType='Past Due')A
	INNER JOIN (SELECT Members_ControlNo AS MemberControl, LoanAppControlNo AS LoanControl FROM Transaction WHERE Date(DateTime)='$reportDate'
		GROUP BY Members_ControlNo)B ON B.LoanControl=A.LoanAppControlNo
GROUP BY LoanAppControlNo) Paid ON Paid.MemberControl=Sky.MemberControl
LEFT JOIN
(SELECT Alpha.MemberControl, ControlNo, Alpha.TransactionType, IFNULL(Amount,0)AS Amount FROM (SELECT * FROM (SELECT Members_ControlNo AS MemberControl FROM 
	(SELECT * FROM caritascenters_has_members chm WHERE Date(DateEntered)<='$reportDate' ORDER BY DateEntered DESC) A
	WHERE CaritasCenters_ControlNo='$centerControl' GROUP BY Members_ControlNo) B
CROSS JOIN transactiontype) Alpha
LEFT JOIN (SELECT Members_ControlNo AS MemberControl,ControlNo, SUM(Amount) AS Amount, TransactionType FROM (SELECT * FROM Transaction WHERE DateTime='$reportDate')A
	LEFT JOIN (SELECT Members_ControlNo AS MemberControl, CaritasCenters_ControlNo AS CenterControl FROM 
		(SELECT * FROM caritascenters_has_members chm WHERE Date(DateEntered)<='$reportDate' ORDER BY DateEntered DESC) A
		WHERE CaritasCenters_ControlNo='$centerControl' GROUP BY Members_ControlNo) B ON A.Members_ControlNo=B.MemberControl 
GROUP BY Members_ControlNo, transactiontype)Beta ON Alpha.MemberControl=Beta.MemberControl AND Alpha.TransactionType=Beta.TransactionType
WHERE Beta.transactiontype='Loan') Loan ON Sky.MemberControl=Loan.MemberControl
LEFT JOIN
(SELECT Alpha.MemberControl, ControlNo, Alpha.TransactionType, IFNULL(Amount,0)AS Amount FROM (SELECT * FROM (SELECT Members_ControlNo AS MemberControl FROM 
	(SELECT * FROM caritascenters_has_members chm WHERE Date(DateEntered)<='$reportDate' ORDER BY DateEntered DESC) A
	WHERE CaritasCenters_ControlNo='$centerControl' GROUP BY Members_ControlNo) B
CROSS JOIN transactiontype) Alpha
LEFT JOIN (SELECT Members_ControlNo AS MemberControl,ControlNo, SUM(Amount) AS Amount, TransactionType FROM (SELECT * FROM Transaction WHERE DateTime='$reportDate')A
	LEFT JOIN (SELECT Members_ControlNo AS MemberControl, CaritasCenters_ControlNo AS CenterControl FROM 
		(SELECT * FROM caritascenters_has_members chm WHERE Date(DateEntered)<='$reportDate' ORDER BY DateEntered DESC) A
		WHERE CaritasCenters_ControlNo='$centerControl' GROUP BY Members_ControlNo) B ON A.Members_ControlNo=B.MemberControl 
GROUP BY Members_ControlNo, transactiontype)Beta ON Alpha.MemberControl=Beta.MemberControl AND Alpha.TransactionType=Beta.TransactionType
WHERE Beta.transactiontype='Past Due') PastDue ON Sky.MemberControl=PastDue.MemberControl
LEFT JOIN
(SELECT Alpha.MemberControl, ControlNo, Alpha.TransactionType, IFNULL(Amount,0)AS Amount FROM (SELECT * FROM (SELECT Members_ControlNo AS MemberControl FROM 
	(SELECT * FROM caritascenters_has_members chm WHERE Date(DateEntered)<='$reportDate' ORDER BY DateEntered DESC) A
	WHERE CaritasCenters_ControlNo='$centerControl' GROUP BY Members_ControlNo) B
CROSS JOIN transactiontype) Alpha
LEFT JOIN (SELECT Members_ControlNo AS MemberControl,ControlNo, SUM(Amount) AS Amount, TransactionType FROM (SELECT * FROM Transaction WHERE DateTime='$reportDate')A
	LEFT JOIN (SELECT Members_ControlNo AS MemberControl, CaritasCenters_ControlNo AS CenterControl FROM 
		(SELECT * FROM caritascenters_has_members chm WHERE Date(DateEntered)<='$reportDate' ORDER BY DateEntered DESC) A
		WHERE CaritasCenters_ControlNo='$centerControl' GROUP BY Members_ControlNo) B ON A.Members_ControlNo=B.MemberControl 
GROUP BY Members_ControlNo, transactiontype)Beta ON Alpha.MemberControl=Beta.MemberControl AND Alpha.TransactionType=Beta.TransactionType
WHERE Beta.transactiontype='Savings') Savings ON Sky.MemberControl=Savings.MemberControl
LEFT JOIN
(SELECT Alpha.MemberControl, ControlNo, Alpha.TransactionType, IFNULL(Amount,0)AS Amount FROM (SELECT * FROM (SELECT Members_ControlNo AS MemberControl FROM 
	(SELECT * FROM caritascenters_has_members chm WHERE Date(DateEntered)<='$reportDate' ORDER BY DateEntered DESC) A
	WHERE CaritasCenters_ControlNo='$centerControl' GROUP BY Members_ControlNo) B
CROSS JOIN transactiontype) Alpha
LEFT JOIN (SELECT Members_ControlNo AS MemberControl,ControlNo, SUM(Amount) AS Amount, TransactionType FROM (SELECT * FROM Transaction WHERE DateTime='$reportDate')A
	LEFT JOIN (SELECT Members_ControlNo AS MemberControl, CaritasCenters_ControlNo AS CenterControl FROM 
		(SELECT * FROM caritascenters_has_members chm WHERE Date(DateEntered)<='$reportDate' ORDER BY DateEntered DESC) A
		WHERE CaritasCenters_ControlNo='$centerControl' GROUP BY Members_ControlNo) B ON A.Members_ControlNo=B.MemberControl 
GROUP BY Members_ControlNo, transactiontype)Beta ON Alpha.MemberControl=Beta.MemberControl AND Alpha.TransactionType=Beta.TransactionType
WHERE Beta.transactiontype='Withdrawal') Withdrawal ON Sky.MemberControl=Withdrawal.MemberControl");
?>

<?php 
$getTotal = $this->db->query("SELECT IFNULL(SUM(Loan.Amount),0) AS LoanPayment, IFNULL(SUM(PastDue.Amount),0) AS PastDuePayment, IFNULL(SUM(Savings.Amount),0) AS SavingsPayment, IFNULL(SUM(Withdrawal.Amount),0) AS WithdrawalPayment
	FROM (SELECT MemberID, Z.MemberControl, concat(LastName,', ',FirstName,' ', MiddleName) AS Name , ActiveLoan FROM (SELECT Members_ControlNo AS MemberControl FROM 
		(SELECT * FROM caritascenters_has_members chm WHERE Date(DateEntered)<='$reportDate' ORDER BY DateEntered DESC) A
		WHERE CaritasCenters_ControlNo='$centerControl' GROUP BY Members_ControlNo)Z
LEFT JOIN (SELECT MemberControl, (AmountRequested +Interest) AS ActiveLoan 
	FROM(SELECT Members_ControlNo AS MemberControl, LoanAppControlNo FROM Transaction WHERE Date(DateTime)='$reportDate' GROUP BY LoanAppControlNo)A
	LEFT JOIN loanapplication la ON la.ControlNo=A.LoanAppControlNo)Y ON Z.MemberControl=Y.MemberControl
LEFT JOIN membersname mn ON mn.ControlNo=Z.MemberControl
LEFT JOIN Members mem ON mem.ControlNo=Z.MemberControl) Sky
LEFT JOIN
(SELECT MemberControl, LoanControl, SUM(Amount) AS TotalPaid FROM (SELECT * FROM transaction trans WHERE TransactionType='Loan' OR TransactionType='Past Due')A
	INNER JOIN (SELECT Members_ControlNo AS MemberControl, LoanAppControlNo AS LoanControl FROM Transaction WHERE Date(DateTime)='$reportDate'
		GROUP BY Members_ControlNo)B ON B.LoanControl=A.LoanAppControlNo
GROUP BY LoanAppControlNo) Paid ON Paid.MemberControl=Sky.MemberControl
LEFT JOIN
(SELECT Alpha.MemberControl, ControlNo, Alpha.TransactionType, IFNULL(Amount,0)AS Amount FROM (SELECT * FROM (SELECT Members_ControlNo AS MemberControl FROM 
	(SELECT * FROM caritascenters_has_members chm WHERE Date(DateEntered)<='$reportDate' ORDER BY DateEntered DESC) A
	WHERE CaritasCenters_ControlNo='$centerControl' GROUP BY Members_ControlNo) B
CROSS JOIN transactiontype) Alpha
LEFT JOIN (SELECT Members_ControlNo AS MemberControl,ControlNo, SUM(Amount) AS Amount, TransactionType FROM (SELECT * FROM Transaction WHERE DateTime='$reportDate')A
	LEFT JOIN (SELECT Members_ControlNo AS MemberControl, CaritasCenters_ControlNo AS CenterControl FROM 
		(SELECT * FROM caritascenters_has_members chm WHERE Date(DateEntered)<='$reportDate' ORDER BY DateEntered DESC) A
		WHERE CaritasCenters_ControlNo='$centerControl' GROUP BY Members_ControlNo) B ON A.Members_ControlNo=B.MemberControl 
GROUP BY Members_ControlNo, transactiontype)Beta ON Alpha.MemberControl=Beta.MemberControl AND Alpha.TransactionType=Beta.TransactionType
WHERE Beta.transactiontype='Loan') Loan ON Sky.MemberControl=Loan.MemberControl
LEFT JOIN
(SELECT Alpha.MemberControl, ControlNo, Alpha.TransactionType, IFNULL(Amount,0)AS Amount FROM (SELECT * FROM (SELECT Members_ControlNo AS MemberControl FROM 
	(SELECT * FROM caritascenters_has_members chm WHERE Date(DateEntered)<='$reportDate' ORDER BY DateEntered DESC) A
	WHERE CaritasCenters_ControlNo='$centerControl' GROUP BY Members_ControlNo) B
CROSS JOIN transactiontype) Alpha
LEFT JOIN (SELECT Members_ControlNo AS MemberControl,ControlNo, SUM(Amount) AS Amount, TransactionType FROM (SELECT * FROM Transaction WHERE DateTime='$reportDate')A
	LEFT JOIN (SELECT Members_ControlNo AS MemberControl, CaritasCenters_ControlNo AS CenterControl FROM 
		(SELECT * FROM caritascenters_has_members chm WHERE Date(DateEntered)<='$reportDate' ORDER BY DateEntered DESC) A
		WHERE CaritasCenters_ControlNo='$centerControl' GROUP BY Members_ControlNo) B ON A.Members_ControlNo=B.MemberControl 
GROUP BY Members_ControlNo, transactiontype)Beta ON Alpha.MemberControl=Beta.MemberControl AND Alpha.TransactionType=Beta.TransactionType
WHERE Beta.transactiontype='Past Due') PastDue ON Sky.MemberControl=PastDue.MemberControl
LEFT JOIN
(SELECT Alpha.MemberControl, ControlNo, Alpha.TransactionType, IFNULL(Amount,0)AS Amount FROM (SELECT * FROM (SELECT Members_ControlNo AS MemberControl FROM 
	(SELECT * FROM caritascenters_has_members chm WHERE Date(DateEntered)<='$reportDate' ORDER BY DateEntered DESC) A
	WHERE CaritasCenters_ControlNo='$centerControl' GROUP BY Members_ControlNo) B
CROSS JOIN transactiontype) Alpha
LEFT JOIN (SELECT Members_ControlNo AS MemberControl,ControlNo, SUM(Amount) AS Amount, TransactionType FROM (SELECT * FROM Transaction WHERE DateTime='$reportDate')A
	LEFT JOIN (SELECT Members_ControlNo AS MemberControl, CaritasCenters_ControlNo AS CenterControl FROM 
		(SELECT * FROM caritascenters_has_members chm WHERE Date(DateEntered)<='$reportDate' ORDER BY DateEntered DESC) A
		WHERE CaritasCenters_ControlNo='$centerControl' GROUP BY Members_ControlNo) B ON A.Members_ControlNo=B.MemberControl 
GROUP BY Members_ControlNo, transactiontype)Beta ON Alpha.MemberControl=Beta.MemberControl AND Alpha.TransactionType=Beta.TransactionType
WHERE Beta.transactiontype='Savings') Savings ON Sky.MemberControl=Savings.MemberControl
LEFT JOIN
(SELECT Alpha.MemberControl, ControlNo, Alpha.TransactionType, IFNULL(Amount,0)AS Amount FROM (SELECT * FROM (SELECT Members_ControlNo AS MemberControl FROM 
	(SELECT * FROM caritascenters_has_members chm WHERE Date(DateEntered)<='$reportDate' ORDER BY DateEntered DESC) A
	WHERE CaritasCenters_ControlNo='$centerControl' GROUP BY Members_ControlNo) B
CROSS JOIN transactiontype) Alpha
LEFT JOIN (SELECT Members_ControlNo AS MemberControl,ControlNo, SUM(Amount) AS Amount, TransactionType FROM (SELECT * FROM Transaction WHERE DateTime='$reportDate')A
	LEFT JOIN (SELECT Members_ControlNo AS MemberControl, CaritasCenters_ControlNo AS CenterControl FROM 
		(SELECT * FROM caritascenters_has_members chm WHERE Date(DateEntered)<='$reportDate' ORDER BY DateEntered DESC) A
		WHERE CaritasCenters_ControlNo='$centerControl' GROUP BY Members_ControlNo) B ON A.Members_ControlNo=B.MemberControl 
GROUP BY Members_ControlNo, transactiontype)Beta ON Alpha.MemberControl=Beta.MemberControl AND Alpha.TransactionType=Beta.TransactionType
WHERE Beta.transactiontype='Withdrawal') Withdrawal ON Sky.MemberControl=Withdrawal.MemberControl

");

foreach ($getTotal->result() as $row) {
	$LTotal=$row->LoanPayment;
	$PDTotal=$row->PastDuePayment;
	$STotal=$row->SavingsPayment;
	$WTotal=$row->WithdrawalPayment;
}?>

<?php $centerList=$this->db->query("SELECT cb.ControlNo AS BranchControl, cc.ControlNo AS CenterControl, cc.CenterNo FROM caritasbranch_has_caritascenters cbhcc 
	LEFT JOIN caritasbranch cb ON cbhcc.CaritasBranch_ControlNo=cb.ControlNo
	LEFT JOIN caritascenters cc ON cbhcc.CaritasCenters_ControlNo=cc.ControlNo"); 
	?>

	<?php $branchList=$this->db->query(" SELECT cb.ControlNo AS BranchControl, BranchName FROM caritasbranch_has_caritascenters cbhcc 
		LEFT JOIN caritasbranch cb ON cbhcc.CaritasBranch_ControlNo=cb.ControlNo
		GROUP BY BranchControl"); ?>

	<?php $reportPlace=$this->db->query(" SELECT BranchName, CenterNo FROM caritasbranch_has_caritascenters cbhcc
		LEFT JOIN caritasbranch cb ON cbhcc.CaritasBranch_ControlNo=cb.ControlNo
		LEFT JOIN caritascenters cc ON cbhcc.CaritasCenters_ControlNo=cc.ControlNo
		WHERE cb.ControlNo='$branchControl' AND cc.ControlNo='$centerControl'"); 
	foreach ($reportPlace->result() as $row) {
		$nBranch =$row->BranchName;
		$nCenter =$row->CenterNo;
	}?>

	<style type="text/css" media="print">
	    .page
	    {
	     -webkit-transform: rotate(-90deg); -moz-transform:rotate(-90deg);
	     filter:progid:DXImageTransform.Microsoft.BasicImage(rotation=3);
	    }
	</style>

	<script type="text/javascript">

	function send(control_no){
		window.location.href="editcollection?name="+control_no;
	}

	</script>

<body style="background: none;">
	<div class="content" style="background:none;">
		<br>
			<a href="<?php echo site_url('login/homepage'); ?>"> <img src="<?php echo base_url('Assets/images/caritaslogo.png'); ?>" class="caritaslogo2"></a>
			
			<div class="yesPrint">
				<br>
				<h3>

					CARITAS SALVE CREDIT COOPERATIVE <br> 
					Daily Collection Summary <br>
					<?php echo $nBranch; ?> Branch &nbsp
					Center no.  <?php echo $nCenter; ?> <br>
					as of <?php echo $wordDate?>
				</h3>
				<br>

				<TABLE class="loancollection">
					<tr class="headr">
						<td class="DChdr" style="width:100px; background: white; color: black;" >Member ID </td>
						<td class="DChdr"  style="width:270px;background: white; color: black;">Name</td>
						<td class="DChdr2" style="width: 150px; background: white; color: black;">Active Release</td>
						<td class="DChdr2" style="width: 120px; background: white; color: black;">Loan Balance </td>
						<td class="DChdr2" style="width: 100px; background: white; color: black;"  colspan="1">Loan </td>
						<td class="DChdr2" style="width: 100px; background: white; color: black;"  colspan="1">Past Due </td>
						<td class="DChdr2" style="width: 100px; background: white; color: black;"  colspan="1">Savings </td>
						<td class="DChdr2" style="width: 100px; background: white; color: black;"  colspan="1">Withdrawal </td>
					</tr>

					<TR>
					</TR>

					<?php $a=1;
					foreach ($getDailyCollection->result() as $row) { ?>
					<tr class="row">

						<td class="DCcontent"  style="background: white; color: black;"><?php echo $row->MemberID; ?></td>
						<td class="DCcontent" style="background: white; color: black;"><?php echo $row->Name; ?></td>
						<td class="DCcontent2" style="background: white; color: black;"><?php echo number_format($row->ActiveLoan,2); ?></td>
						<td class="DCcontent2" style="background: white; color: black;"><?php echo number_format($row->LoanLeft,2); ?></td>
						<td class="DCcontent2" style="background: white; color: black;"><a href="javascript:void(0)" onclick="send('<?php echo $row->LoanControl ?>')"><?php echo number_format($row->LoanPayment,2); ?></a></td>
						<td class="DCcontent2" style="background: white; color: black;"><a href="javascript:void(0)" onclick="send('<?php echo $row->PastDueControl ?>')"><?php echo number_format($row->PastDuePayment,2); ?></a></td>
						<td class="DCcontent2" style="background: white; color: black;"><a href="javascript:void(0)" onclick="send('<?php echo $row->SavingsControl ?>')"><?php echo number_format($row->SavingsPayment,2) ?></a></td>
						<td class="DCcontent2" style="background: white; color: black;"><a href="javascript:void(0)" onclick="send('<?php echo $row->WithdrawalControl ?>')"><?php echo number_format($row->WithdrawalPayment,2) ?></a></td>
					</tr>
					<?php $a++; }?>

					<tr class="rowtotal">

						<td class="DCtotal" style="text-align:right; background: white; color: black;" colspan="2"><b>TOTAL: &nbsp</b></td>
						<td class="DCtotal2" style="background: white; color: black;"><b></b></td>	
						<td class="DCtotal2" style="background: white; color: black;"><b></b></td>
						<td class="DCtotal2" style="background: white; color: black;"><b><?php echo number_format($LTotal,2) ?> </b></td>
						<td class="DCtotal2" style="background: white; color: black;"><b><?php echo number_format($PDTotal,2) ?> </b></td>
						<td class="DCtotal2" style="background: white; color: black;"><b><?php echo number_format($STotal,2) ?> </b></td>
						<td class="DCtotal2" style="background: white; color: black;"><b><?php echo number_format($WTotal,2) ?> </b></td>

					</tr>


				</TABLE>

				<br><br>
				<!-- <table class="signature" style="margin-left:auto; margin-right:auto;">
					<tr>
						<td class="sigBy">Prepared by:</td>
						<td class="sig">&nbsp<?php echo $user; ?></td>
						<td class="sigBy"> &nbsp&nbsp&nbspDate:</td>
						<td class="sig2"><?php echo $datetoday; ?></td>
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
				</table> -->

		<!--		 <table class="signature" style="margin-left:31.5%; margin-right:auto;">
				      <tr>
				        <td class="sigBy">Prepared by:</td>
				      </tr>
				      <tr>
				        <td class="sigName">Marvin Lao*</td>
				      </tr>
				      <tr>
				        <td class="sigPosition">Branch Manager*</td>
				      </tr>
				      <tr>
				        <td class="sigPosition">November 21, 2014*</td>
				      </tr>
				    </table>

				    <table class="signature" style="margin-left: 53%; margin-right:auto; margin-top: -111px;">
				      <tr>
				        <td class="sigBy">Received by:</td>
				      </tr>
				      <tr>
				        <td class="sigName">Name</td>
				      </tr>
				      <tr>
				        <td class="sigPosition"> Position</td>
				      </tr>
				      <tr>
				        <td class="sigPosition">November 21, 2014</td>
				      </tr>
				    </table>-->

		<table style="margin-left: 140px;" >
			<tr>
				<td class="BM1"style="font-size: 13px;"><?php echo $name; ?></td>
			</tr>
				<?php if($userrank=='branchmanager'){?>
			<tr>
				<td class="BM2">Signature Above Printed Name of <br> Branch Manager</td>
			</tr>
			<?php }else{ ?>
			<tr>
				<td class="BM2">Signature Above Printed Name of <br> Salve Officer</td>
			</tr>
			<?php } ?>
			<tr>
				<td class="BM1" style="font-size: 13px;"><?php echo $datetoday ?></td>
			</tr>
			<tr>
				
				<td class="BM2">Date</td>
			</tr>
		</table>


		<!-- <table style="margin-left: 750px; margin-top: -132px;" >

		<table style="margin-left: 600px; margin-top: -207px;" >

			
			<?php if($userrank=='branchmanager'){?>
			<tr>
				<td class="BM1" style="font-size: 13px;">Marvin Lao</td>
			</tr>
			<tr>
				<td class="BM2">Signature Above Printed Name of MIS</td>
			</tr>
			<?php }else{ ?>
			<tr>
				<td class="BM1" style="font-size: 13px;"><?php echo $Manager; ?></td>
			</tr>
			<tr>
				<td class="BM2">Signature Above Printed Name of Branch Manager</td>
			</tr>
			<?php } ?>
			<tr>
				<td class="BM1" style="font-size: 13px;"><?php echo $datetoday ?></td>
			</tr>
			<tr>
				<td class="BM2">Date</td>
			</tr>
		</table> -->
			</div>
			<br><br>
			<div class="noPrint" style="width: 100%; text-align: center;">
				<button onclick="window.print()">Print</button>
			</div>

		</div>

		</body>