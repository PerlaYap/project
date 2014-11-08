<TITLE>TERMINATION REPORT</TITLE>

<style type="text/css" media="print">
.dontprint{
	display: none;
	}
@page { 
    size: portrait;
    margin: 0.5in;
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
 	<div style="margin-left: auto;margin-right:auto; text-align:center;">
		<a href="<?php echo site_url('login/homepage'); ?>" > 
			<img src="<?php echo base_url('Assets/images/caritaslogo.png'); ?>" style="width: 150px; height: auto;" >
		</a>
		
		<h4 style="margin-left:auto;margin-right:auto; font-family: Optima, Segoe, "Segoe UI", Candara, Calibri, Arial, sans-serif;">
			CARITAS SALVE CREDIT COOPERATIVE <br> 
			Termination Report <br>
			<?php echo $branch ?> Branch
		</h4>
	</div>

<link rel="stylesheet" type="text/css" href="<?php echo base_url('Assets/css/terminate.css'); ?>">

<div class="basic-grey">
	<label>
		<span>Name :</span></label>
		<input id="name" type="text" name="fname" value="<?php echo $name ?>" style="width: 562px;" disabled/>
				  
	<label>
		<span>Date Joined :</span></label>
		<input id="name" type="text" name="fname" value="<?php echo $dateentered ?> " style="width: 562px;" disabled/>  

	<label>
		<span>Date Terminated :</span></label>
		<input id="name" type="text" name="fname" value="<?php echo $term_date ?> " style="width: 562px;" disabled/>  

	<label>
		<span>Total Capital Share :</span></label>
		<input id="name" type="text" name="fname" value="<?php echo number_format($tot_capital,2) ?>" style="width: 562px;" disabled/> 

	<label>
		<span>Total Savings :</span></label>
		<input id="name" type="text" name="fname" value="<?php echo number_format($savings,2) ?>" style="width: 562px;" disabled/>  

	<label>
		<span>Amount Receivable: :</span></label>
		<input id="name" type="text" name="fname" value="<?php echo number_format($Recievable,2) ?>" style="width: 562px; font-weight:bold; color:#821818" disabled/> 

</div>

<br><br>

<table class="signature" style="margin-left:auto; margin-right:auto;">
			<tr>
				<td class="sigBy">Approved by:</td>
				<td class="sig" style="width: 200px;">&nbsp <?php echo $user ?></td>
				<td class="sigBy"> &nbsp&nbsp&nbspDate:</td>
				<td class="sig2" style="width: 150px;">&nbsp<?php echo $datetoday; ?></td>
			</tr>
		</table>
		<br>
		<table class="signature"  style="margin-left:auto; margin-right:auto;">
			<tr>
				<td class="sigBy">Received by:</td>
				<td class="sig" style="width: 200px;">&nbsp <?php echo $name ?>    </td>
				<td class="sigBy"> &nbsp&nbsp&nbspDate:</td>
				<td class="sig2" style="width: 150px;">&nbsp</td>
			</tr>
		</table>



<!-- Approved by:    <?php echo $user ?>                      Date: <?php echo $datetoday ?>
<br>
Recieved by:    <?php echo $name ?>                      Date:	 -->


<br><br><br>




<div class='dontprint' style="width: 100%; text-align: center;">
		<button onclick="window.print()">Print</button> 

	</div>



