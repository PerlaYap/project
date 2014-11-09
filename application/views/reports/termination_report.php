

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
		$comment = $d->Comment;
	}
 ?>

 <?php if ($status == 'Terminated'): ?>
 	<TITLE>TERMINATION REPORT</TITLE>
 <?php endif ?>
 <?php if ($status =='Terminated Voluntarily'): ?>
 	<TITLE>WITHDRAWAL REPORT</TITLE>
 <?php endif ?>
 	<div style="margin-left: auto;margin-right:auto; text-align:center;">
		<a href="<?php echo site_url('login/homepage'); ?>" > 
			<img src="<?php echo base_url('Assets/images/caritaslogo.png'); ?>" style="width: 150px; height: auto;" >
		</a>
		
		<h3 style="margin-left:auto;margin-right:auto; font-family: Optima, Segoe, "Segoe UI", Candara, Calibri, Arial, sans-serif;">
			CARITAS SALVE CREDIT COOPERATIVE <br> 

			 <?php if ($status == 'Terminated'): ?>
				 	Termination Report
				 <?php endif ?>
			 <?php if ($status =='Terminated Voluntarily'): ?>
				 	Withdrawal Report
				 <?php endif ?> <br>
			<?php echo $branch ?> Branch
		</h3>
	</div>

<link rel="stylesheet" type="text/css" href="<?php echo base_url('Assets/css/terminate.css'); ?>">

<div class="basic-grey" style="background:none;">
	<label>
		<span>Name :</span></label>
		<input id="name" type="text" name="fname" value="<?php echo $name ?>" style="width: 630px; background:none;" disabled/>
				  
	<label>
		<span>Date Joined :</span></label>
		<input id="name" type="text" name="fname" value="<?php echo $dateentered ?> " style="width: 630px; background:none;" disabled/>  

	<label>
		<span>Date Terminated :</span></label>
		<input id="name" type="text" name="fname" value="<?php echo $term_date ?> " style="width: 630px; background:none;" disabled/>  

	<label>
		<span>Reason for Termination :</span></label>
		<input id="name" type="text" name="fname" value="<?php echo $comment ?>" style="width: 630px; background:none;" disabled/> 


	<label>
		<span>Total Capital Share :</span></label>
		<input id="name" type="text" name="fname" value="<?php echo number_format($tot_capital,2) ?>" style="width: 630px; background:none;" disabled/> 

	<label>
		<span>Total Savings :</span></label>
		<input id="name" type="text" name="fname" value="<?php echo number_format($savings,2) ?>" style="width: 630px;background:none;" disabled/>  

	<label>
		<span>Amount Receivable: :</span></label>
		<input id="name" type="text" name="fname" value="<?php echo number_format($Recievable,2) ?>" style="width: 630px; background:none; font-weight:bold; color:#821818" disabled/> 

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



