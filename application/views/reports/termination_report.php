

<style type="text/css" media="print">
.dontprint{
	display: none;
	}
@page { 
    size: portrait;
    margin: 1in;
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
 	<TITLE>TERMINATION SUMMARY</TITLE>
 <?php endif ?>
 <?php if ($status =='Terminated Voluntarily'): ?>
 	<TITLE>WITHDRAWAL SUMMARY</TITLE>
 <?php endif ?>
 	<div style="margin-left: auto;margin-right:auto; text-align:center;">
		<a href="<?php echo site_url('login/homepage'); ?>" > 
			<img src="<?php echo base_url('Assets/images/caritaslogo.png'); ?>" style="width: 150px; height: auto;" >
		</a>
		
		<h3 style="margin-left:auto;margin-right:auto; font-family: Optima, Segoe, "Segoe UI", Candara, Calibri, Arial, sans-serif;">
			CARITAS SALVE CREDIT COOPERATIVE <br> 

			<!--  <?php if ($status == 'Terminated'): ?>
				 	Termination Summary
				 <?php endif ?>
			 <?php if ($status =='Terminated Voluntarily'): ?>
				 	Withdrawal Summary
				 <?php endif ?> <br> -->
			<?php echo $branch ?> Branch
		</h3>
	</div>

<link rel="stylesheet" type="text/css" href="<?php echo base_url('Assets/css/terminate.css'); ?>">

<br><br>




<div style="margin-left: auto; margin-right: auto; width: 750px; font-size: 13px; line-height: 15px; ">

	<br>
	2014 November 25 <br>
	<br>
	<br>
	Member Address Line 1<br>
	Member Address Line 2<br>
	Member Address Line 3<br>
	<br>
	<br>
	<br>
	<br>
	Dear <?php echo $name ?>:<br>
	<br><br>

	<!----------- IF TERMINATED ------------>
		This is to notify that we have elected to terminate your membership; which, in accordance with the terms and provisions of the contract, is effective <u>two weeks after the above date</u>.<br>
	<!----------- IF TERMINATED ------------>
	

	<!----------- IF WITHDRAWN ------------>
		This is to notify that we have withdrawn your membership due to the reason of: <?php echo $comment ?>. <br>
	<!----------- IF WITHDRAWN ------------>


	<br>
	The following information will indicate the assets that you may receive after your "termination/withdrawal".</br>
	<br>
		<p style="margin-left: 50px; font-size:13spx;line-height: 20px;">
			<b>Name: </b><?php echo $name ?> <br>
			<b>Date Joined: </b><?php echo $dateentered ?><br>
			<b>Date "Terminated/Withdrawn": </b><?php echo $term_date ?> <br>
			<b>Reason for Termination: </b><?php echo $comment ?> <br>
			<b>Total Capital Share: </b>Php <?php echo number_format($tot_capital,2) ?>
		</p>

	<br>
	Should you have any concerns regarding the claim of your possible assets, contact us at (02)522-0011 or visit our branch office on Budget Lane Shopping Center, No. 88, Provincial Rd.<br>
	<br>
	<br>
	<br>
	Sincerely, 
	<br>
	<br>

		<table >
	      <tr>
	        <td class="BM1">NAME OF BM</td>
	      </tr>
	      <tr>
	        <td class="BM2">Signature Above Printed Name of <br>Branch Manager</td>
	      </tr>
	    </table>










</div>





<br><br><br>



<div class='dontprint' style="width: 100%; text-align: center;">
		<button onclick="window.print()">Print</button> 

	</div>





























	<!-- <div class="basic-grey" style="margin-left: auto; margin-right: auto; width: 500px; background:none; ">
		<label>
			<span>Name :</span></label>
			<input id="name" type="text" name="fname" value="<?php echo $name ?>" style="width: 200px; background:none;" disabled/>
					  
		<label>
			<span>Date Joined :</span></label>
			<input id="name" type="text" name="fname" value="<?php echo $dateentered ?> " style="width: 200px; background:none;" disabled/>  

		<label>
			<span>Date Terminated :</span></label>
			<input id="name" type="text" name="fname" value="<?php echo $term_date ?> " style="width: 200px; background:none;" disabled/>  

		<label>
			<span>Reason for Termination :</span></label>
			<input id="name" type="text" name="fname" value="<?php echo $comment ?>" style="width: 200px; background:none;" disabled/> 


		<label>
			<span>Total Capital Share :</span></label>
			<input id="name" type="text" name="fname" value="Php <?php echo number_format($tot_capital,2) ?>" style="width: 200px; background:none;" disabled/> 

	<?php if ($status=='Terminated Voluntarily'): ?>
		
		<label>
			<span>Total Savings :</span></label>
			<input id="name" type="text" name="fname" value="Php <?php echo number_format($savings,2) ?>" style="width: 200px;background:none;" disabled/>  

		<label>
			<span>Amount Receivable: :</span></label>
			<input id="name" type="text" name="fname" value="Php <?php echo number_format($Recievable,2) ?>" style="width: 200px; background:none; font-weight:bold; color:#821818" disabled/> 

		<?php endif ?>

	</div> -->



