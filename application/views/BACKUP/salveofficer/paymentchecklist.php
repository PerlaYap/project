	<link rel="stylesheet" type="text/css" href="<?php echo base_url('Assets/css/reports.css'); ?>">
	<script src="<?php echo base_url('Assets/js/jquery-1.11.1.js'); ?>"></script>
	<img src="<?php echo base_url('Assets/images/caritaslogo.png'); ?>" class="caritaslogo">
	<!--<link rel="stylesheet" type="text/css" href="../../../Assets/css/reports.css">
	<img src="../../../Assets/images/caritaslogo.png" class="caritaslogo">-->

	<?php $loanInfo=$this->db->query("SELECT loanapplication_ControlNo AS LoanControl, MemberControl, BranchControl, BranchName, CenterNo, Name, ApplicationNumber, AmountRequested, Interest, DateApplied, DateReleased, DayoftheWeek, LoanType, CapitalShare FROM loanapplication_has_members lhmem
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
LEFT JOIN (SELECT ControlNo AS LoanControl, ApplicationNumber, AmountRequested, Interest, DateApplied, DateReleased, DayoftheWeek, LoanType, CapitalShare FROM loanapplication)D
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
 	$dateReleased=$row->DateReleased;
 	$dayoftheWeek=$row->DayoftheWeek;
 	$loanType=$row->LoanType;
 	$capitalShare=$row->CapitalShare;
 }
$activeLoan=$amountRequested+$interest;

$days=array();
$date=$dateReleased;
$next="next ".$dayoftheWeek;

if($loanType=="23-Weeks"){
	for($a=0; $a<23; $a++){
	$days[$a]=date('Y-m-d', strtotime($dayoftheWeek,strtotime($date)));
	$date=$days[$a];
}
}else{
	for($a=0; $a<40; $a++){
	$days[$a]=date('Y-m-d', strtotime($dayoftheWeek,strtotime($date)));
	$date=$days[$a];
}
}
?>

	<h3>CARITAS SALVE CREDIT COOPERATIVE <br> Payment Schedule</h3>

	<br>

	<table class="paymentschedule" border="1">
		<tr>
			<td class="pLabel">Name ehll:</td>
			<td class="pName"><b><?php echo $name ?></b></td>
		</tr>
		<tr>
			<td class="pLabel">Loan Type:</td>
			<td class="pName"><b><?php echo $loanType ?></b></td>
		</tr>
		<tr>
			<td class="pLabel">Active Release:</td>
			<td class="pName"><b><?php echo $activeLoan ?></b></td>
		</tr>
		<tr>
			<td class="pLabel">Date Applied:</td>
			<td class="pName"><b><?php echo $dateApplied ?></b></td>
		</tr>
		<tr>
			<td class="pLabel">Date Released:</td>
			<td class="pName"><b><?php echo $dateReleased ?></b></td>
		</tr>
		<tr>
			<td class="pLabel">Branch:</td>
			<td class="pName"><b><?php echo $branchName ?></b></td>
		</tr>
		<tr>
			<td class="pLabel">Center No:</td>
			<td class="pName"><b><?php echo $centerNo ?></b></td>
		</tr>
		<tr>
			<td class="pLabel">Collection Day:</td>
			<td class="pName"><b><?php echo $dayoftheWeek ?></b></td>
		</tr>
	</table>
	
	<table class="paymentschedule" border="1" style="margin-top: -1px; width:453px;">
		<tr>
			<td class="pLabel" colspan="2" style="border-top-width:0px;text-align: center; height: 40px;"><b>Collection Dates Checklist</b></td>
		</tr>
		<?php foreach ($days as $val) { ?>
		
		<tr class="date">
			<td class="check"></td>			
			<td class="date"><?php echo $val ?></td>
		</tr>
		<?php } ?>
		
	</table>

	<br>
	<div style="width: 100%; text-align: center;">
		<button onclick="window.print()">Print</button>
	</div>

