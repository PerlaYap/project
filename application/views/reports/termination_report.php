<TITLE>TERMINATION REPORT</TITLE>

<style type="text/css" media="print">
.dontprint{
	display: none;
}

</style>

<?php 
	date_default_timezone_set('Asia/Manila');
	$datetoday = date('F d, Y');
	$branch = $this->session->userdata('branch');
	$user = $this->session->userdata('firstname');

	foreach ($data as $d) {
		$name = $d->Name;
		$dateentered = $d->DateEntered;
		$tot_capital = $d->totcapitalshare;
		$savings = $d->savings;
		$Recievable = $tot_capital + $savings;
		$status = $d->status;
		$term_date = $d->StatusUpdateDate;
	}
 ?>

TERMINATION REPORT  <br>
<?php echo $branch ?> Branch
<br><br><br>

Name: <?php echo $name ?>
<br>
Date joined: <?php echo $dateentered ?> 
<br>
Date Terminated: <?php echo $term_date ?>
<br>
<br>
Total Capital Share: <?php echo number_format($tot_capital,2) ?>
<br>
<br>
Total Savings: <?php echo number_format($savings,2) ?>
<br>
<!-- make emphasize on this -->
Amount Recievable: <?php echo number_format($Recievable,2) ?>
<br>
<br>
<br>


Approved by:    <?php echo $branch ?>                      Date: <?php echo $datetoday ?>
<br>
Recieved by:    <?php echo $name ?>                      Date:	


<br><br><br>




<div class='dontprint' style="width: 100%; text-align: center;">
		<button onclick="window.print()">Print</button> 

	</div>



