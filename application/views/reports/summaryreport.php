<title>Summary Report</title>

<?php 

date_default_timezone_set('Asia/Manila');
$datetoday = date('F d, Y');

$user = $this->session->userdata('firstname');


$loanInfo=$this->db->query("SELECT loanapplication_ControlNo AS LoanControl, MemberControl, BranchControl, BranchName, CenterNo, Name, ApplicationNumber, AmountRequested, Interest, DateApplied, DayoftheWeek, LoanType, CapitalShare FROM loanapplication_has_members lhmem
LEFT JOIN (SELECT CenterNo, Members_ControlNo AS MemberControl, concat(LastName,', ',FirstName,' ', MiddleName) AS Name
FROM caritascenters_has_members cchmem
LEFT JOIN membersname mn ON cchmem.Members_ControlNo=mn.ControlNo
LEFT JOIN caritascenters cc ON cc.ControlNo=cchmem.CaritasCenters_ControlNo
WHERE ISNULL(DateLeft)) B ON B.MemberControl=lhmem.Members_ControlNo
LEFT JOIN (SELECT CaritasBranch_ControlNo AS BranchControl, BranchName FROM caritasbranch_has_caritascenters cbhcc
INNER JOIN (SELECT CaritasCenters_ControlNo AS CenterControl, MAX(Date) AS LatestDate 
FROM caritasbranch_has_caritascenters cbhcc GROUP BY CaritasCenters_ControlNo) A
ON A.CenterControl=cbhcc.CaritasCenters_ControlNo AND A.LatestDate=cbhcc.Date
LEFT JOIN caritasbranch cb ON cbhcc.CaritasBranch_ControlNo=cb.ControlNo GROUP BY BranchControl) C
ON C.BranchControl=lhmem.CaritasBranch_ControlNo
LEFT JOIN (SELECT ControlNo AS LoanControl, ApplicationNumber, AmountRequested, Interest, DateApplied, DayoftheWeek, LoanType, CapitalShare FROM loanapplication)D
ON D.LoanControl=lhmem.LoanApplication_ControlNo
WHERE loanapplication_ControlNo='$loanControl'");
 foreach ($loanInfo->result() as $row) {
 	$loanControl=$row->LoanControl;
 	$memberControl=$row->MemberControl;
 	$branchControl=$row->BranchControl;
 	$branchName=$row->BranchName;
 	$centerNo=$row->CenterNo;
 	$name=$row->Name;
 	$applicationNumber=$row->ApplicationNumber;
 	$amountRequested=$row->AmountRequested;
 	$interest=$row->Interest;
 	$dateApplied=$row->DateApplied;
 	$dayoftheWeek=$row->DayoftheWeek;
 	$loanType=$row->LoanType;
 	$capitalShare=$row->CapitalShare;
 }
$activeLoan=$amountRequested+$interest;
$serviceCharge=($amountRequested * 0.02);
$totalPayment=$amountRequested-$serviceCharge-$capitalShare;

if($loanType=="23-Weeks")
	$dailyCollection=$activeLoan/23;
else
	$dailyCollection=$activeLoan/40;


?>
			<link rel="stylesheet" type="text/css" href="<?php echo base_url('Assets/css/salveofficer.css'); ?>">
			<script src="<?php echo base_url('Assets/js/general.js'); ?>"></script>
			<script src="<?php echo base_url('Assets/js/salveofficer.js'); ?>"></script>

			<!--<link rel="stylesheet" type="text/css" href="../../../Assets/css/salveofficer.css">-->
		
			<div class="content">
				<br>
				<form class="basic-grey">
					<h1><br>Release Summary
				        <span> <br></span>
				    </h1>

				    <label>
				    	<span>Name :</span> 
				    	<?php echo '<input type="text" style="width:560px;" value="'.$name.'" readOnly="true"/>'; ?>
				    </label>

				    <label>
				    	<span>Branch :</span>   </label>
				    	<input type="text" style="width:200px;" value="<?php echo $branchName ?>" readOnly="true"/>
				    
				    	&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
				    	Center :
				    	<input type="text" style="width:102px;" value="<?php echo $centerNo ?>" readOnly="true"/>
				  	
				  	<label>
				    	<span>Loan Application No. :</span>   </label>
				    	<input type="text" style="width:250px;" value="<?php echo $applicationNumber ?>" readOnly="true"/>
				    
				    	&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
				    	Date of Application :
				    	<input type="text" style="width:113px;" value="<?php echo $dateApplied ?>" readOnly="true"/>
				    
				    <label>
				    	<span>Loan Type :</span> 
				    	<input type="text" style="width:557px;" value="<?php echo $loanType ?>" readOnly="true"/>
				    </label>

				    <label>
				    	<span>Amount :</span>   </label>
				    												<!-- echo number_format("1000000",2)."<br>"; -->
				    	<input type="text" style="width:200px;" value="<?php echo number_format($amountRequested,2) ?>" readOnly="true"/>
				    
				    	&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
				    	
				    	Interest :
				    	<input type="text" style="width:200px;" value="<?php echo number_format($interest,2) ?>" readOnly="true"/>

				    <label>
				    	<span>Amount Receivable (Weekly) :</span> 
				    	<input type="text" style="width:557px;" value="<?php echo number_format($dailyCollection,2) ?>" readOnly="true"/>
				    </label>

				    <label>
				    	<span>Capital Share :</span>   </label>
				    	<input type="text" style="width:200px;" value="<?php echo number_format($capitalShare,2) ?>" readOnly="true"/>
				    
				    	&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
				    	Service Charge :
				    	<input type="text" style="width:200px;" value="<?php echo number_format($serviceCharge,2) ?>" readOnly="true"/>

				    <label>
				    	<span></span>
				    	<?php echo '<h2 style="text-align:right; margin-right: 100px;">TOTAL AMOUNT TO BE RELEASED: P'.number_format($totalPayment,2).'</h2>'; ?>
				    </label>
				    <br>
				</form>
				    <br>
				     <label>
				        <span></span>


				    <form action="releaseLoan" method="post" name="releaseLoan" class="basic-grey" style="margin-top: -30px;">
				        <input type='hidden' name='loanID' value='<?php echo $loanControl ?>'>
				        <input type='hidden' name='memberID' value=" <?php echo $memberControl; ?> ">
				        <input type='hidden' name='activerelease' value=" <?php echo $activeLoan; ?> " >
				        <input type='hidden' name='capitalshare' value=" <?php echo $capitalShare; ?> " >
				        <input type='hidden' name='sonumber' value=" <?php echo $this->session->userdata('personnelno'); ?> " >
				        <input type='hidden' name='totalpayment' value='<?php echo $totalPayment ?>' >
				        <input type="submit" class="button" value="Release" style="margin-left: 300px;" />
				       
				    </form>
				    <form action='approvedloans' method='post' class="basic-grey" style="height: 10px; padding: 0; width: 860px; margin-top: -10px;">
					     		<div>
					     			<input type="submit" value="Back to List" class="button1" style="margin-left: 450px; margin-top:-50px;"/>
					     		</div>
					     	</form>
				    </label>  
				
				
				<br><Br>
		</div>
		<br>
<!--		<table class="signature" style="margin-left:auto; margin-right:auto; margin-top: 800px;">
			<tr>
				<td class="sigBy">Prepared by:</td>
				<td class="sig"><?php echo $user ?></td>
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
	</div> -->