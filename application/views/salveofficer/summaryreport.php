
<?php $loanInfo=$this->db->query("SELECT loanapplication_ControlNo AS LoanControl, MemberControl, BranchControl, BranchName, CenterNo, Name, ApplicationNumber, AmountRequested, Interest, DateApplied, DayoftheWeek, LoanType FROM loanapplication_has_members lhmem
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
LEFT JOIN (SELECT ControlNo AS LoanControl, ApplicationNumber, AmountRequested, Interest, DateApplied, DayoftheWeek, LoanType FROM loanapplication)D
ON D.LoanControl=lhmem.LoanApplication_ControlNo
WHERE loanapplication_ControlNo='$appControl'");
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
 }
$activeLoan=$amountRequested+$interest;
$serviceCharge=($amountRequested * 0.02);
$totalPayment=$activeLoan+$serviceCharge;

if($loanType=="23-Weeks")
	$dailyCollection=$activeLoan/23;
else
	$dailyCollection=$activeLoan/40;


?>
			<!--<link rel="stylesheet" type="text/css" href="<?php echo base_url('Assets/css/salveofficer.css'); ?>">
			<script src="<?php echo base_url('Assets/js/salveofficer.js'); ?>"></script>-->

			<link rel="stylesheet" type="text/css" href="../../../Assets/css/salveofficer.css">
		
			<div class="content">
				<br>
				<form action="addnewloanprocess" method="post" name="addnewloanprocess" class="basic-grey">
					<h1><br>Summary Report
				        <span> <br></span>
				    </h1>

				    <label>
				    	<span>Name :</span> 
				    	<input type="text" style="width:560px;" value="<?php echo $name ?>" disabled/>
				    </label>

				    <label>
				    	<span>Branch :</span>   </label>
				    	<input type="text" style="width:200px;" value="<?php echo $branchName ?>" disabled/>
				    
				    	&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
				    	Center :
				    	<input type="text" style="width:102px;" value="<?php echo $centerNo ?>" disabled/>
				  	
				  	<label>
				    	<span>Loan Application No. :</span>   </label>
				    	<input type="text" style="width:250px;" value="<?php echo $applicationNumber ?>" disabled/>
				    
				    	&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
				    	Date of Application :
				    	<input type="text" style="width:113px;" value="<?php echo $dateApplied ?>" disabled/>
				    
				    <label>
				    	<span>Loan Type :</span> 
				    	<input type="text" style="width:560px;" value="<?php echo $loanType ?>" disabled/>
				    </label>

				    <label>
				    	<span>Amount :</span>   </label>
				    	<input type="text" style="width:200px;" value="<?php echo $amountRequested ?>" disabled/>
				    
				    	&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
				    	Interest :
				    	<input type="text" style="width:200px;" value="<?php echo $interest ?>" disabled/>

				    <label>
				    	<span>Amount Receivable (Weekly) :</span> 
				    	<input type="text" style="width:560px;" value="<?php echo $dailyCollection ?>" disabled/>
				    </label>

				    <label>
				    	<span>Capital Share :</span>   </label>
				    	<input type="text" style="width:200px;" disabled/>
				    
				    	&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
				    	Service Charge :
				    	<input type="text" style="width:200px;" value="<?php echo $serviceCharge ?>" disabled/>

				    <label>
				    	<span></span>
				    	<?php echo '<h2 style="text-align:right; margin-right: 100px;">TOTAL AMOUNT TO BE RELEASED:'.$totalPayment.'</h2>'; ?>
				    </label>

				    <br>
				     <label>
				        <span></span>
				        <input type="submit" class="button" value="Released" />
				        <!------GO TO addnewloan2.php" ------>
				        
				    </label>  
				</form>
				<br><Br>
		</div>
		