<title>MONTHLY ACCOUNT REPORT</title>

<link rel="stylesheet" type="text/css" href="<?php echo base_url('Assets/css/reports.css'); ?>">
	
	<?php //$month = $_POST['month'];
			//$year = $_POST['year'];

			$month = 7;
			$year = 2014;

			$prev = $year-1;
			$prev2 = $year-2;

			if ($month == 1){
				$yue = 'January';
				$month=13;
				$year=-1;
			} else if ($month == 2){
				$yue = 'February';
			} else if ($month == 3){
				$yue = 'March';
			} else if ($month == 4){
				$yue = 'April';
			} else if ($month == 5){
				$yue = 'May';
			} else if ($month == 6){
				$yue = 'June';
			} else if ($month == 7){
				$yue = 'July';
			} else if ($month == 8){
				$yue = 'August';
			} else if ($month == 9){
				$yue = 'September';
			} else if ($month == 10){
				$yue = 'October';
			} else if ($month == 11){
				$yue = 'November';
			} else{
				$yue = 'December';
			}


$getbranch = $this->db->query("SELECT b.branchname, b.ControlNo FROM caritasbranch b
	Order by b.branchname"); ?>
	<a href="<?php echo site_url('login/homepage'); ?>"> <img src="<?php echo base_url('Assets/images/caritaslogo.png'); ?>" class="caritaslogo"></a>
	
	<!-- <img src="<?php // echo base_url ('Assets/images/caritaslogo.png'); ?>" class="caritaslogo"> -->
	<h3>CARITAS SALVE CREDIT COOPERATIVE <br> MONTHLY ACCOUNT REPORT <br> For The Month Of <b>
		<?php echo $yue ?> <?php echo $year ?></b></h3>

	<br>
	<table class="misreport" border="1">

<?php 
$getbranch = $this->db->query("SELECT b.branchname, b.ControlNo FROM caritasbranch b
	Order by b.branchname"); 
	


	?>

	
	
		<tr class="header">
			<td class="label"><b>Branch:</td>
		<?php	foreach ($getbranch->result() as $br) { ?>
				<td class="branch"> <?php echo $br->branchname; ?> </td>
		<?php }?>
				<td class="branch">Total</td>


		<tr>
			<td class="label"><b>OUTREACH</b></td>
			<td colspan="15"> </td>
		</tr>

		<tr>
			<td class="label">Beginning</td>
			<?php $totalbeg =0;
			foreach ($getbranch->result() as $br) { 

				$control = $br->ControlNo;

				$Beg = $this->db->query("SELECT COUNT(mm.ControlNo)AS beg, month(mm.DateUpdated), year(mm.DateUpdated)
				FROM CaritasBranch_has_CaritasCenters bc, CaritasCenters_Has_Members cm, Members_has_membersmembershipstatus mm, loanapplication l
				 WHERE  bc.CaritasCenters_ControlNo = cm.CaritasCenters_ControlNo AND cm.Members_ControlNo = mm.ControlNo AND
				 mm.ControlNo = l.ControlNo AND
				 bc.CaritasBranch_ControlNo = '$control' AND month(mm.DateUpdated)<'$month' AND year(mm.DateUpdated) <= '$year'
				 AND (mm.Status = 'Active Saver' or  mm.Status = 'Borrower')");	
				
				foreach ($Beg->result() as $key) {
					$g = $key->beg;
				
?>
			<td class="number"> <?php echo $g;  ?> </td>

		<?php  $totalbeg +=$g; } ?>

		<?php } ?>
		<td class="number"><?php echo $totalbeg; ?></td> 
		</tr>
		<tr>
			<td class="label">New</td>
			<?php 
					$totalnew = 0;
	foreach ($getbranch->result() as $br) { 

				$control = $br->ControlNo;
	$New = $this->db->query("SELECT COUNT(mm.ControlNo)AS new, month(mm.DateUpdated), year(mm.DateUpdated)
	FROM CaritasBranch_has_CaritasCenters bc, CaritasCenters_Has_Members cm, Members_has_membersmembershipstatus mm, loanapplication l
	 WHERE  bc.CaritasCenters_ControlNo = cm.CaritasCenters_ControlNo AND cm.Members_ControlNo = mm.ControlNo AND
	 mm.ControlNo = l.ControlNo AND
	 bc.CaritasBranch_ControlNo = '$control' AND month(mm.DateUpdated)='$month' AND year(mm.DateUpdated) = '$year'
	 AND mm.Status = 'Active Saver' || 'Borrower'");			

	foreach ($New->result() as $n){
	
	$new = $n->new;

	?>

			<td class="number"><?php echo $new; ?></td>
	
	<?php  $totalnew +=$new; 

} 
}

?>
	<td class="number"><?php echo $totalnew; ?></td>
		</tr>

		<tr>
			<td class="label">Drop-out</td>
			<?php 
					
	$totaldrop = 0;

	foreach ($getbranch->result() as $br) { 
		$control = $br->ControlNo;


	$Drop = $this->db->query("SELECT COUNT(mm.ControlNo)AS dropout, month(mm.DateUpdated), year(mm.DateUpdated)
	FROM CaritasBranch_has_CaritasCenters bc, CaritasCenters_Has_Members cm, Members_has_membersmembershipstatus mm, loanapplication l
	 WHERE  bc.CaritasCenters_ControlNo = cm.CaritasCenters_ControlNo AND cm.Members_ControlNo = mm.ControlNo AND
	 mm.ControlNo = l.ControlNo AND
	 bc.CaritasBranch_ControlNo = '$control' AND month(mm.DateUpdated)='$month' AND year(mm.DateUpdated) = '$year'
	 AND mm.Status = 'Terminated' || 'Terminated Voluntarily'");			

	foreach ($Drop->result() as $dp){

	$drop = $dp->dropout;

	?>
			<td class="number"><?php echo $drop; ?></td>

<?php  $totaldrop +=$drop; 
} 
}

?>	

	<td class="number"><?php echo $totaldrop; ?></td>
		</tr>

		<tr>
			<td class="label">Active Members</td>
			<?php 
		$totalactive = 0;
	
		foreach ($getbranch->result() as $br) { 
		$control = $br->ControlNo;

$Beg = $this->db->query("SELECT COUNT(mm.ControlNo)AS beg, month(mm.DateUpdated), year(mm.DateUpdated)
				FROM CaritasBranch_has_CaritasCenters bc, CaritasCenters_Has_Members cm, Members_has_membersmembershipstatus mm, loanapplication l
				 WHERE  bc.CaritasCenters_ControlNo = cm.CaritasCenters_ControlNo AND cm.Members_ControlNo = mm.ControlNo AND
				 mm.ControlNo = l.ControlNo AND
				 bc.CaritasBranch_ControlNo = '$control' AND month(mm.DateUpdated)<'$month' AND year(mm.DateUpdated) <= '$year'
				 AND (mm.Status = 'Active Saver' or  mm.Status = 'Borrower')");	
				
				
$New = $this->db->query("SELECT COUNT(mm.ControlNo)AS new, month(mm.DateUpdated), year(mm.DateUpdated)
	FROM CaritasBranch_has_CaritasCenters bc, CaritasCenters_Has_Members cm, Members_has_membersmembershipstatus mm, loanapplication l
	 WHERE  bc.CaritasCenters_ControlNo = cm.CaritasCenters_ControlNo AND cm.Members_ControlNo = mm.ControlNo AND
	 mm.ControlNo = l.ControlNo AND
	 bc.CaritasBranch_ControlNo = '$control' AND month(mm.DateUpdated)='$month' AND year(mm.DateUpdated) = '$year'
	 AND mm.Status = 'Active Saver' || 'Borrower'");			

	
	$Drop = $this->db->query("SELECT COUNT(mm.ControlNo)AS dropout, month(mm.DateUpdated), year(mm.DateUpdated)
	FROM CaritasBranch_has_CaritasCenters bc, CaritasCenters_Has_Members cm, Members_has_membersmembershipstatus mm, loanapplication l
	 WHERE  bc.CaritasCenters_ControlNo = cm.CaritasCenters_ControlNo AND cm.Members_ControlNo = mm.ControlNo AND
	 mm.ControlNo = l.ControlNo AND
	 bc.CaritasBranch_ControlNo = '$control' AND month(mm.DateUpdated)='$month' AND year(mm.DateUpdated) = '$year'
	 AND mm.Status = 'Terminated' || 'Terminated Voluntarily'");			

	foreach ($New->result() as $n){
		$new = $n->new;
	foreach ($Drop->result() as $dp){
		$drop = $dp->dropout;
	foreach ($Beg->result() as $key) {
		$g = $key->beg;



		$active = $g+$new-$drop;
	
	?>

			<td class="number"><?php echo $active; ?></td>
		<?php   $totalactive +=$active; 
} } } }

?>	

	<td class="number"><?php echo $totalactive; ?></td>
		</tr>

		<tr>
			<td class="label" rowspan="2">Dormant-Beg<br>Return</td>

			<?php 
		$totaldorm = 0;
	
		foreach ($getbranch->result() as $br) { 
		$control = $br->ControlNo;		

	$dorm = $this->db->query("SELECT COUNT(mm.ControlNo)AS dorm, month(mm.DateUpdated), year(mm.DateUpdated)
	FROM CaritasBranch_has_CaritasCenters bc, CaritasCenters_Has_Members cm, Members_has_membersmembershipstatus mm, loanapplication l
	 WHERE  bc.CaritasCenters_ControlNo = cm.CaritasCenters_ControlNo AND cm.Members_ControlNo = mm.ControlNo AND
	 mm.ControlNo = l.ControlNo AND
	 bc.CaritasBranch_ControlNo = '$control' AND month(mm.DateUpdated)<'$month' AND year(mm.DateUpdated)<= '$year'
	 AND mm.Status = 'Dormant Saver'");			

	foreach ($dorm->result() as $dr){
		$dorm = $dr->dorm;
	?>	
	

			<td class="number"><?php echo $dorm; ?></td>
		<?php 
		$totaldorm +=$dorm; 

	}
}
	
	?> 
	<td class="number"><?php echo $totaldorm; ?></td>
		</tr>
			<tr class="return">
				<?php 
					
			$totalreturn = 0;
	
		foreach ($getbranch->result() as $br) { 
		$control = $br->ControlNo;	

	$return = $this->db->query("SELECT COUNT(mm.ControlNo)AS Active, month(mm.DateUpdated), year(mm.DateUpdated)
	FROM CaritasBranch_has_CaritasCenters bc, CaritasCenters_Has_Members cm, Members_has_membersmembershipstatus mm, loanapplication l
	 WHERE  bc.CaritasCenters_ControlNo = cm.CaritasCenters_ControlNo AND cm.Members_ControlNo = mm.ControlNo AND
	 mm.ControlNo = l.ControlNo AND
	 bc.CaritasBranch_ControlNo = '$control' AND month(mm.DateUpdated)='$month' AND year(mm.DateUpdated)= '$year'
	 AND mm.Status = 'Active Saver'");			

	foreach ($return->result() as $ac){

	$ret = $ac->Active;
	?>

				<td class="number"><?php echo $ret; ?></td>
		<?php 
		$totalreturn +=$ret; 

	}
}
	
	?> <td class="number"><?php echo $totalreturn; ?></td>
			</tr>

		<tr>
			<td class="label">Inactive Members</td>

			<?php 
					
			$totalinactive = 0;
	
		foreach ($getbranch->result() as $br) { 
		$control = $br->ControlNo;	

	$return = $this->db->query("SELECT COUNT(mm.ControlNo)AS Active, month(mm.DateUpdated), year(mm.DateUpdated)
	FROM CaritasBranch_has_CaritasCenters bc, CaritasCenters_Has_Members cm, Members_has_membersmembershipstatus mm, loanapplication l
	 WHERE  bc.CaritasCenters_ControlNo = cm.CaritasCenters_ControlNo AND cm.Members_ControlNo = mm.ControlNo AND
	 mm.ControlNo = l.ControlNo AND
	 bc.CaritasBranch_ControlNo = '$control' AND month(mm.DateUpdated)='$month' AND year(mm.DateUpdated)= '$year'
	 AND mm.Status = 'Active Saver'");			

	$dorm = $this->db->query("SELECT COUNT(mm.ControlNo)AS dorm, month(mm.DateUpdated), year(mm.DateUpdated)
	FROM CaritasBranch_has_CaritasCenters bc, CaritasCenters_Has_Members cm, Members_has_membersmembershipstatus mm, loanapplication l
	 WHERE  bc.CaritasCenters_ControlNo = cm.CaritasCenters_ControlNo AND cm.Members_ControlNo = mm.ControlNo AND
	 mm.ControlNo = l.ControlNo AND
	 bc.CaritasBranch_ControlNo = '$control' AND month(mm.DateUpdated)<'$month' AND year(mm.DateUpdated)<= '$year'
	 AND mm.Status = 'Dormant Saver'");			

	foreach ($dorm->result() as $dr){
		$dorm = $dr->dorm;
	foreach ($return->result() as $ac){

	$ret = $ac->Active;

	$inactive = $dorm-$ret;
	?>
			<td class="number"><?php echo $inactive;  ?></td>
	<?php   $totalactive +=$active; 
} } } 

?>	<td class="number"><?php echo $totalinactive;  ?></td>
		</tr>

		<tr>
			<td class="label">Total Outreach</td>
			<?php 
					
			$totaloutreach = 0;
	
		foreach ($getbranch->result() as $br) { 
		$control = $br->ControlNo;	

	$return = $this->db->query("SELECT COUNT(mm.ControlNo)AS Active, month(mm.DateUpdated), year(mm.DateUpdated)
	FROM CaritasBranch_has_CaritasCenters bc, CaritasCenters_Has_Members cm, Members_has_membersmembershipstatus mm, loanapplication l
	 WHERE  bc.CaritasCenters_ControlNo = cm.CaritasCenters_ControlNo AND cm.Members_ControlNo = mm.ControlNo AND
	 mm.ControlNo = l.ControlNo AND
	 bc.CaritasBranch_ControlNo = '$control' AND month(mm.DateUpdated)='$month' AND year(mm.DateUpdated)= '$year'
	 AND mm.Status = 'Active Saver'");			

	$dorm = $this->db->query("SELECT COUNT(mm.ControlNo)AS dorm, month(mm.DateUpdated), year(mm.DateUpdated)
	FROM CaritasBranch_has_CaritasCenters bc, CaritasCenters_Has_Members cm, Members_has_membersmembershipstatus mm, loanapplication l
	 WHERE  bc.CaritasCenters_ControlNo = cm.CaritasCenters_ControlNo AND cm.Members_ControlNo = mm.ControlNo AND
	 mm.ControlNo = l.ControlNo AND
	 bc.CaritasBranch_ControlNo = '$control' AND month(mm.DateUpdated)<'$month' AND year(mm.DateUpdated)<= '$year'
	 AND mm.Status = 'Dormant Saver'");	
	 $Beg = $this->db->query("SELECT COUNT(mm.ControlNo)AS beg, month(mm.DateUpdated), year(mm.DateUpdated)
				FROM CaritasBranch_has_CaritasCenters bc, CaritasCenters_Has_Members cm, Members_has_membersmembershipstatus mm, loanapplication l
				 WHERE  bc.CaritasCenters_ControlNo = cm.CaritasCenters_ControlNo AND cm.Members_ControlNo = mm.ControlNo AND
				 mm.ControlNo = l.ControlNo AND
				 bc.CaritasBranch_ControlNo = '$control' AND month(mm.DateUpdated)<'$month' AND year(mm.DateUpdated) <= '$year'
				 AND (mm.Status = 'Active Saver' or  mm.Status = 'Borrower')");	
				
				
$New = $this->db->query("SELECT COUNT(mm.ControlNo)AS new, month(mm.DateUpdated), year(mm.DateUpdated)
	FROM CaritasBranch_has_CaritasCenters bc, CaritasCenters_Has_Members cm, Members_has_membersmembershipstatus mm, loanapplication l
	 WHERE  bc.CaritasCenters_ControlNo = cm.CaritasCenters_ControlNo AND cm.Members_ControlNo = mm.ControlNo AND
	 mm.ControlNo = l.ControlNo AND
	 bc.CaritasBranch_ControlNo = '$control' AND month(mm.DateUpdated)='$month' AND year(mm.DateUpdated) = '$year'
	 AND mm.Status = 'Active Saver' || 'Borrower'");			

	
	$Drop = $this->db->query("SELECT COUNT(mm.ControlNo)AS dropout, month(mm.DateUpdated), year(mm.DateUpdated)
	FROM CaritasBranch_has_CaritasCenters bc, CaritasCenters_Has_Members cm, Members_has_membersmembershipstatus mm, loanapplication l
	 WHERE  bc.CaritasCenters_ControlNo = cm.CaritasCenters_ControlNo AND cm.Members_ControlNo = mm.ControlNo AND
	 mm.ControlNo = l.ControlNo AND
	 bc.CaritasBranch_ControlNo = '$control' AND month(mm.DateUpdated)='$month' AND year(mm.DateUpdated) = '$year'
	 AND mm.Status = 'Terminated' || 'Terminated Voluntarily'");			

	foreach ($New->result() as $n){
		$new = $n->new;
	foreach ($Drop->result() as $dp){
		$drop = $dp->dropout;
	foreach ($Beg->result() as $key) {
		$g = $key->beg;		

	foreach ($dorm->result() as $dr){
		$dorm = $dr->dorm;
	foreach ($return->result() as $ac){

	$ret = $ac->Active;

$outreach = ($g+$new-$drop)+($dorm-$ret);
	?>
			<td class="number"><?php echo $outreach;  ?></td>
	<?php   $totaloutreach +=$outreach; 
} } } 
} } } 


?>	<td class="number"><?php echo $totaloutreach;  ?></td>
		
		</tr>

		<tr>
			<td class="label">No. of Borrower</td>
			<td colspan="15"></td>
		</tr>

			<tr>
				<td class="label">&nbsp&nbsp&nbsp (23 weeks)</td>

				<?php 
	$totalbr = 0;
	
		foreach ($getbranch->result() as $br) { 
		$control = $br->ControlNo;	

	$brcount = $this->db->query("SELECT COUNT(mm.ControlNo)AS Borrower, month(mm.DateUpdated), year(mm.DateUpdated)
	FROM CaritasBranch_has_CaritasCenters bc, CaritasCenters_Has_Members cm, Members_has_membersmembershipstatus mm, loanapplication l
	 WHERE  bc.CaritasCenters_ControlNo = cm.CaritasCenters_ControlNo AND cm.Members_ControlNo = mm.ControlNo AND
	 mm.ControlNo = l.ControlNo AND
	 bc.CaritasBranch_ControlNo = '$control' AND month(mm.DateUpdated)<='$month' AND year(mm.DateUpdated)<= '$year'
	 AND mm.Status = 'Borrower' AND l.loantype = '23-Weeks'");			

	foreach ($brcount->result() as $br){


	$br = $br->Borrower;
	?>

				<td class="number"><?php echo $br;  ?></td>
	<?php   $totalbr +=$br; 
} } 

?>	<td class="number"><?php echo $totalbr;  ?></td>
			
			</tr>

			

			<tr>
				<td class="label">&nbsp&nbsp&nbsp (40 weeks)</td>
				<?php 
				
		$totalbw = 0;
	
		foreach ($getbranch->result() as $br) { 
		$control = $br->ControlNo;	

	$bwcount = $this->db->query("SELECT COUNT(mm.ControlNo)AS Borrower, month(mm.DateUpdated), year(mm.DateUpdated)
	FROM CaritasBranch_has_CaritasCenters bc, CaritasCenters_Has_Members cm, Members_has_membersmembershipstatus mm, loanapplication l
	 WHERE  bc.CaritasCenters_ControlNo = cm.CaritasCenters_ControlNo AND cm.Members_ControlNo = mm.ControlNo AND
	 mm.ControlNo = l.ControlNo AND
	 bc.CaritasBranch_ControlNo = '$control' AND month(mm.DateUpdated)<='$month' AND year(mm.DateUpdated)<= '$year'
	 AND mm.Status = 'Borrower' AND l.loantype = '40-Weeks'");			

	foreach ($bwcount->result() as $bw){
	
	$bw = $bw->Borrower;
	?>

				<td class="number"><?php echo $bw;  ?></td>
	<?php   $totalbw +=$bw; 
} } 

?>	<td class="number"><?php echo $totalbw;  ?></td>

			
			</tr>

			
		<tr>
			<td class="label">Total No. of Borrower</td>
			<?php 
				
		$totalbow = 0;
	
		foreach ($getbranch->result() as $br) { 
		$control = $br->ControlNo;	

	$bwcount = $this->db->query("SELECT COUNT(mm.ControlNo)AS Borrower, month(mm.DateUpdated), year(mm.DateUpdated)
	FROM CaritasBranch_has_CaritasCenters bc, CaritasCenters_Has_Members cm, Members_has_membersmembershipstatus mm, loanapplication l
	 WHERE  bc.CaritasCenters_ControlNo = cm.CaritasCenters_ControlNo AND cm.Members_ControlNo = mm.ControlNo AND
	 mm.ControlNo = l.ControlNo AND
	 bc.CaritasBranch_ControlNo = '$control' AND month(mm.DateUpdated)<='$month' AND year(mm.DateUpdated)<= '$year'
	 AND mm.Status = 'Borrower' AND l.loantype = '40-Weeks'");			

	$brcount = $this->db->query("SELECT COUNT(mm.ControlNo)AS Borrower, month(mm.DateUpdated), year(mm.DateUpdated)
	FROM CaritasBranch_has_CaritasCenters bc, CaritasCenters_Has_Members cm, Members_has_membersmembershipstatus mm, loanapplication l
	 WHERE  bc.CaritasCenters_ControlNo = cm.CaritasCenters_ControlNo AND cm.Members_ControlNo = mm.ControlNo AND
	 mm.ControlNo = l.ControlNo AND
	 bc.CaritasBranch_ControlNo = '$control' AND month(mm.DateUpdated)<='$month' AND year(mm.DateUpdated)<= '$year'
	 AND mm.Status = 'Borrower' AND l.loantype = '23-Weeks'");			

	foreach ($brcount->result() as $br){
	$br = $br->Borrower;

	foreach ($bwcount->result() as $bw){
	
	$bw = $bw->Borrower;

		$totalB = $br+$bw;
	?>
			<td class="number"><?php echo $totalB;  ?></td>
	<?php   $totalbow +=$totalB; 
} } }

?>	<td class="number"><?php echo $totalbow;  ?></td>
		
		</tr>

		<tr>
			<td class="label">No. of Savers</td>
			<?php 
					
		$totalsave = 0;
	
		foreach ($getbranch->result() as $br) { 
		$control = $br->ControlNo;	

	$savercount = $this->db->query("SELECT COUNT(mm.ControlNo)AS Saver, month(mm.DateUpdated), year(mm.DateUpdated)
	FROM CaritasBranch_has_CaritasCenters bc, CaritasCenters_Has_Members cm, Members_has_membersmembershipstatus mm
	 WHERE  bc.CaritasCenters_ControlNo = cm.CaritasCenters_ControlNo AND cm.Members_ControlNo = mm.ControlNo AND
	 bc.CaritasBranch_ControlNo = '$control' AND month(mm.DateUpdated)<='$month' AND year(mm.DateUpdated)<= '$year'
	 AND mm.Status = 'Active Saver'");			

	foreach ($savercount->result() as $st){
		$save =  $st->Saver;
	
	?>
		<td class="number"><?php echo $save;  ?></td>
	<?php   $totalsave +=$save; 
} } 

?>	<td class="number"><?php echo $totalsave;  ?></td>
			
		</tr>

		<tr>
			<td class="label">No. of Centers</td>
	
<?php
	$totalcenter = 0;
	
		foreach ($getbranch->result() as $br) { 
		$control = $br->ControlNo;
	$centercount = $this->db->query("SELECT COUNT(c.CenterNo)AS Center, b.ControlNo, month(bc.Date),
	year(bc.Date)
	FROM caritasbranch b, CaritasBranch_has_CaritasCenters bc, caritascenters c WHERE  b.ControlNo = '$control'
	AND b.ControlNo = bc.CaritasBranch_ControlNo AND bc.CaritasCenters_ControlNo = c.ControlNo
	AND month(bc.Date)<='$month' AND year(bc.Date)<= '$year'");

				foreach ($centercount->result() as $ct){ 
					$center  = $ct->Center; 
					?>

			<td class="number"><?php echo $center;  ?></td>
	<?php   $totalcenter +=$center; 
} } 

?>	<td class="number"><?php echo $totalcenter;  ?></td>
	
		
		</tr>
		
	</table>

	<br>
<!--
	<table class="misreport" border="1">
		<tr>
			<td class="label">PDM-No. of PD (2013)</td>
			<td class="number1"></td>
		
		</tr>
		<tr>
			<td class="label">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp'(2012)</td>
			<td class="number1"></td>
		
		</tr>
		<tr>
			<td class="label">Total No. of PDM</td>
			<td class="number1"></td>
	
		</tr>
	</table>
-->

	
		<table class="signature" style="margin-left:auto; margin-right:auto;">
			<tr>
				<td class="sigBy">Prepared by:</td>
				<td class="sig">&nbsp</td>
				<td class="sigBy"> &nbsp&nbsp&nbspDate:</td>
				<td class="sig2">&nbsp</td>
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
