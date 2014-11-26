	
<style type="text/css" media="print">
.dontprint{
	display: none;
}

	 @page { 
    size: portrait;
    margin: 0.5in;
  }
</style>




	<link rel="stylesheet" type="text/css" href="<?php echo base_url('Assets/css/reports.css'); ?>">
	<script src="<?php echo base_url('Assets/js/jquery-1.11.1.js'); ?>"></script>

	<!-- <img src="<?php //echo base_url('Assets/images/caritaslogo.png'); ?>" class="caritaslogo">-->
	<a href="<?php echo site_url('login/homepage'); ?>"> <img src="<?php echo base_url('Assets/images/caritaslogo.png'); ?>" class="caritaslogo"></a>
	<!--<link rel="stylesheet" type="text/css" href="../../../Assets/css/reports.css">
	<img src="../../../Assets/images/caritaslogo.png" class="caritaslogo">-->
	<?php 

	date_default_timezone_set('Asia/Manila');
	$datetoday = date('F d, Y');

	$user = $this->session->userdata('firstname');
	$userrank = $this->session->userdata('rank');
	$branchno = $this->session->userdata('branchno');
	$name2 = $this->session->userdata('firstname');
	$branchno = $this->session->userdata('branchno');
$getManager=$this->db->query("SELECT CONCAT(`FirstName`,' ',  `MiddleName`,' ', `LastName`) AS NAME FROM CaritasPersonnel CL 
											JOIN CARITASBRANCH_HAS_CARITASPERSONNEL BP ON CL.CONTROLNO = BP.CARITASPERSONNEL_ControlNo
											JOIN CARITASBRANCH B ON BP.CARITASBRANCH_CONTROLNO = B.CONTROLNO
											
														WHERE CL.RANK = 'BRANCHMANAGER' 
														AND B.ControlNo = $branchno ");



	$loanInfo=$this->db->query("SELECT loanapplication_ControlNo AS LoanControl, MemberControl, BranchControl, BranchName, CenterNo, Name, ApplicationNumber, AmountRequested, Interest, DateApplied, DateReleased, DayoftheWeek, LoanType, CapitalShare FROM loanapplication_has_members lhmem
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
$serviceCharge=($amountRequested * 0.02);
$totalPayment=$amountRequested-$serviceCharge-$capitalShare;

$days=array();
$date=$dateReleased;
$next="next ".$dayoftheWeek;

 $dateApplied=date('F d, Y', strtotime($dateApplied));
 $dateReleased=date('F d, Y', strtotime($dateReleased));

if($loanType=="23-Weeks")
	$dailyCollection=$activeLoan/23;
else
	$dailyCollection=$activeLoan/40;

if($loanType=="23-Weeks"){
	for($a=0; $a<23; $a++){
	$days[$a]=date('F d, Y', strtotime($next,strtotime($date)));
	$date=$days[$a];
}
}else{
	for($a=0; $a<40; $a++){
	$days[$a]=date('F d, Y', strtotime($next,strtotime($date)));
	$date=$days[$a];
}
}

if($loanType=="23-Weeks")
	$dailyCollection=$activeLoan/23;
else
	$dailyCollection=$activeLoan/40;
?>

	<h3>CARITAS SALVE CREDIT COOPERATIVE <br> Payment Schedule</h3>

	<br>

	<table class="paymentschedule" border="1">
		<tr>
			<td class="pLabel">Name:</td>
			<td class="pName"><b><?php echo $name ?></b></td>
		</tr>
		<tr>
			<td class="pLabel">Loan Duration:</td>
			<td class="pName"><b><?php echo $loanType ?></b></td>
		</tr>
		<tr>
			<td class="pLabel">Loan Amount:</td>
			<td class="pName"><b>Php <?php echo number_format($amountRequested,2) ?></b></td>
		</tr>
		<tr>
			<td class="pLabel">Loan Interest:</td>
			<td class="pName"><b>Php <?php echo number_format($interest,2) ?></b></td>
		</tr>
		<tr>
			<td class="pLabel">Amount Released:</td>
			<td class="pName"><b><?php echo number_format($totalPayment,2)?></b></td>
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
			<td class="pLabel">Amount Recieved:</td>
			<td class="pName"><b>Php <?php echo number_format($totalPayment,2) ?></b></td>
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
		<tr>
			<td class="pLabel">Collection Amount per Week:</td>
			<td class="pName"><b>Php <?php echo number_format($dailyCollection,2) ?></b></td>
		</tr>
	</table>
	
	<table class="paymentschedule" border="1" style="margin-top: -1px; width:453px;">
		<tr>
			<td class="pLabel" colspan="6" style="border-top-width:0px;text-align: center; height: 40px;"><b>Collection Dates Checklist</b></td>
		</tr>
		
		<?php if($loanType=="23-Weeks"){
			$len = count($days)+1;
		}else{
			$len = count($days);
		}
			
			for ($k=0; $k < $len/2 ; $k++) {  ?>
		<tr class="date">
			<td class="check"></td>			
			<td class="date"><?php echo $days[$k] ?>	<td><?php echo number_format($dailyCollection,2); ?> </td></td>
		
			<td class="check"></td>			
			<td class="date"><?php  if ($loanType=='23-Weeks') {	
			 							if (($len/2+$k) < $len-1) {
											 echo $days[$len/2+$k]; ?>

											 <td><?php echo number_format($dailyCollection,2); ?> </td>
										<?php	}else{
												echo " "; }
									}else{
										echo $days[$len/2+$k]; ?>
			<td><?php echo number_format($dailyCollection,2); ?> </td>
								<?php	} ?></td>
			
			
		</tr>

		<?php } ?>
		<?php //} ?>
		
	</table>

	<br>
	
		<!-- <table class="signature" style="margin-left:auto; margin-right:auto;">
			<tr>
				<td class="sigBy">Prepared by:</td>
				<td class="sig"><?php echo $user; ?></td>
				<td class="sigBy"> &nbsp&nbsp&nbspDate:</td>
				<td class="sig2"><?php echo $datetoday; ?></td>
			</tr>
		</table>
		<br>
		<table class="signature"  style="margin-left:auto; margin-right:auto;">
			<tr>
				<td class="sigBy">Received by:</td>
				<td class="sig"><?php echo $name ?></td>
				<td class="sigBy"> &nbsp&nbsp&nbspDate:</td>
				<td class="sig2">&nbsp</td>
			</tr>
		</table> -->



		 <table class="signature" style="margin-left:31.5%; margin-right:auto;">
		      <tr>
		        <td class="sigBy">Prepared by:</td>
		      </tr>
		      <tr>
		        <td class="sigName"><u> &nbsp&nbsp<?php echo $user ?>&nbsp&nbsp</u></td>
		      </tr>
		      <tr>
		        <td class="sigPosition">Branch Manager</td>
		      </tr>
		      <tr>
		        <td class="sigPosition"><?php echo $datetoday ?></td>
		      </tr>
		    </table>

		    <table class="signature" style="margin-left: 53%; margin-right:auto; margin-top: -111px;">
		      <tr>
		        <td class="sigBy">Received by:</td>
		      </tr>
		      <tr>
		        <td class="sigName"><u>&nbsp&nbsp<?php echo $name ?>&nbsp&nbsp</u></td>
		      </tr>
		      <tr>
		        <td class="sigPosition"> Member</td>
		      </tr>
		      <tr>
		        <td class="sigPosition"><?php echo $datetoday ?></td>
		      </tr>
		    </table>
<!-- 
		 <table style="margin-left: 140px;" >
	      <tr>
	        <td class="BM1" style="font-size: 13px;"><?php echo $name2; ?></td>
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
	      </tr> -->
	    </table>

	<!--    <table style="margin-left: 600px; margin-top: -207px;" >
	      <tr>
	        <td class="BM1" style="font-size: 13px;">Ann Evan Echavez</td>
	      </tr>
	      <tr>
	        <td class="BM2">Signature Above Printed Name of <br> General Manager</td>
	      </tr>
	      <tr>
	        <td class="BM1" style="font-size: 13px;"><?php echo $datetoday ?></td>
	      </tr>
	      <tr>
	        <td class="BM2">Date</td>
	      </tr>
	    </table>-->

	    	<!-- <table style="margin-left: 600px; margin-top: -207px;" >
			
			<?php if($userrank=='branchmanager'){?>
			<tr>
				<td class="BM1"style="font-size: 13px;">Marvin Lao</td>
			</tr>
			<tr>
				<td class="BM2">Signature Above Printed Name of MIS</td>
			</tr>
			<?php }else{ ?>
			<tr>
				<td class="BM1"style="font-size: 13px;"><?php echo $Manager; ?></td>
			</tr>
			<tr>
				<td class="BM2">Signature Above Printed Name of Branch Manager</td>
			</tr>
			<?php } ?>
			<tr>
				<td class="BM1"style="font-size: 13px;"><?php echo $datetoday ?></td>
			</tr>
			<tr>
				<td class="BM2">Date</td>
			</tr>
		</table>
 -->

	<br><br>
	<div style="width: 100%; text-align: center;">
		<button onclick="window.print()" class="dontprint">Print</button>
		<!-- <button onclick="">Back</button> -->
	</div>

