<title>Daily Collection Summary</title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('Assets/css/dailycollection.css'); ?>">
<script src="<?php echo base_url('Assets/js/dailycollection.js'); ?>"></script>

<?php 	$branch = $this->session->userdata('branchno');
	$branchname = $this->session->userdata('branch'); 
	$user = $this->session->userdata('firstname');

	date_default_timezone_set('Asia/Manila');
	$datetoday = date('F d, Y');
	?>


<?php 
$getDailyCollection = $this->db->query("SELECT Sky.MemberControl, MemberID, Name, ActiveLoan, (ActiveLoan-TotalPaid) AS LoanLeft, 
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

<script type="text/javascript">
function getCenterList(){
	var branchControl=parseInt(document.getElementById('branchList').value);
	
	removeOptions(document.getElementById("centers"));
	<?php foreach($centerList->result() as $row){
	echo 'if(branchControl=='.$row->BranchControl.'){';
		echo 'var select = document.getElementById("centers");';
		echo 'select.options[select.options.length] = new Option('.$row->CenterNo.', '.$row->CenterControl.');';
	echo '}';
} ?>

function removeOptions(selectbox){
    var i;
    for(i=selectbox.options.length-1;i>=0;i--)
    {
        selectbox.remove(i);
    }
}
	
}

function send(control_no){
				
				window.location.href= "editcollection?name="+ control_no;
			} 
</script>

<div class="content">
	<form action="getOtherDC" method="post" name="getOtherDC">

		<br><br>
		<p style="text-align:center;">VIEW DAILY LOAN COLLECTION SUMMARY OF:  
			<select id="branchList" name="dcbranchControl" onchange="getCenterList()">
				<option value=" " selected></option>
				<?php if($userrank=='mispersonnel') {?>
								<?php
								foreach ($branchList->result() as $row) { 
									echo "<option value='".$row->BranchControl."'>".$row->BranchName."</option>" ;
								} ?>
								<?php }else{ 
									echo "<option value='".$branch."'>".$branchname."</option>" ;
								 } ?>
			</select> 

			&nbsp &nbsp  

			<select id="centers" name="dccenterControl">
			</select>

		&nbsp &nbsp 
		<span>of Date: </span></label>
		<input type="text" name="reportDate" style="width: 135px;" value="<?php echo $reportDate ?>" readOnly="true"/>
		<input type="submit" value="Go" class="go"/>
	</form>

	<a href="<?php echo site_url('login/homepage'); ?>"> <img src="<?php echo base_url('Assets/images/caritaslogo.png'); ?>" class="caritaslogo2"></a>
	
	<br>
	<h3>

		CARITAS SALVE CREDIT COOPERATIVE <br> 
		Daily Collection Summary <br>
		<?php echo $nBranch; ?> Branch &nbsp
		Center no.  <?php echo $nCenter; ?>
	</h3>


	<TABLE class="loancollection">
			<tr class="headr">
				<td class="DChdr" style="width:100px;" >Member ID </td>
				<td class="DChdr"  style="width:270px;">Name</td>
				<td class="DChdr2" style="width: 150px"  >Active Release</td>
				<td class="DChdr2" style="width: 120px"   >Loan Balance </td>
				<td class="DChdr2" style="width: 100px;"  colspan="1">Loan </td>
				<td class="DChdr2" style="width: 100px;"  colspan="1">Past Due </td>
				<td class="DChdr2" style="width: 100px;"  colspan="1">Savings </td>
				<td class="DChdr2" style="width: 100px;"  colspan="1">Withdrawal </td>
			</tr>

				<TR>
					<!-- <td class="DChdr2" style="width: 100px" >TN</td> -->
					<!-- <td class="DChdr2" style="width: 100px">Payment</td> -->
					<!-- <td class="DChdr2" style="width: 100px">TN</td> -->
					<!-- <td class="DChdr2" style="width: 100px">Payment</td> -->
					<!-- <td class="DChdr2" style="width: 100px">TN</td> -->
					<!-- <td class="DChdr2" style="width: 100px">Payment</td> -->
					<!-- <td class="DChdr2" style="width: 100px">TN</td> -->
					<!-- <td class="DChdr2" style="width: 100px">Payment</td> -->
				</TR>

			<?php $a=1;
			foreach ($getDailyCollection->result() as $row) { ?>
				<tr class="row">
					<!--<td class="DCcontent">111456664</td>
					<td class="DCcontent">Lyka Ellace C. Dado</td>
					<td class="DCcontent2">39</td>
					<td class="DCcontent2">323</td>
					<td class="DCcontent2">23</td>
					<td class="DCcontent2">657</td>
					<td class="DCcontent2">54</td>
					<td class="DCcontent2">54</td>
					<td class="DCcontent2">33</td>
					<td class="DCcontent2">22</td>
					<td class="DCcontent2">22</td>
					<td class="DCcontent2">343</td>-->


					<td class="DCcontent"><?php echo $row->MemberID ?></td>
					<td class="DCcontent"><?php echo $row->Name ?></td>
					<td class="DCcontent2"><?php echo $row->ActiveLoan ?></td>
					<td class="DCcontent2"><?php echo $row->LoanLeft ?></td>
					<!-- <td class="DCcontent2"><?php echo $row->LoanControl ?></td> -->
					<td class="DCcontent2"><a href="javascript:void(0)" onclick="send('<?php echo $row->LoanControl ?>')"><?php echo $row->LoanPayment ?></a></td>
					<!-- <td class="DCcontent2"><?php echo $row->PastDueControl ?></td> -->
					<td class="DCcontent2"><a href="javascript:void(0)" onclick="send('<?php echo $row->PastDueControl ?>')"><?php echo $row->PastDuePayment ?></a></td>
					<!-- <td class="DCcontent2"><?php echo $row->SavingsControl ?></td> -->
					<td class="DCcontent2"><a href="javascript:void(0)" onclick="send('<?php echo $row->SavingsControl ?>')"><?php echo $row->SavingsPayment ?></a></td>
					<!-- <td class="DCcontent2"><?php echo $row->WithdrawalControl ?></td> -->
					<td class="DCcontent2"><a href="javascript:void(0)" onclick="send('<?php echo $row->WithdrawalControl ?>')"><?php echo $row->WithdrawalPayment ?></a></td>
				</tr>
			<?php $a++; }?>

			<tr class="rowtotal">
				
				<td class="DCtotal" style="text-align:right;" colspan="2"><b>TOTAL: &nbsp</b></td>
				<td class="DCtotal2" ><b></b></td>	
				<td class="DCtotal2" ><b></b></td>
				<!-- <td class="DCtotal2" ><b></b></td>	 -->	
				<td class="DCtotal2" ><b><?php echo $LTotal ?> </b></td>
				<!-- <td class="DCtotal2" ><b></b></td>	 -->
				<td class="DCtotal2" ><b><?php echo $PDTotal ?> </b></td>
				<!-- <td class="DCtotal2" ><b></b></td>	 -->
				<td class="DCtotal2" ><b><?php echo $STotal ?> </b></td>
				<!-- <td class="DCtotal2" ><b></b></td>	 -->
				<td class="DCtotal2" ><b><?php echo $WTotal ?> </b></td>

			</tr>


		</TABLE>

		<br><br>
		<table class="signature" style="margin-left:auto; margin-right:auto;">
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
		</table>

		<br><br>
		<div style="width: 100%; text-align: center;">
			<button onclick="window.print()">Print</button>
		</div>

</div>