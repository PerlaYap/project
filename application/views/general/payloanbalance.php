<?php 
		date_default_timezone_set('Asia/Manila');
		$SOpersonnel =$this->session->userdata('personnelno');

		if (!empty($savings)) {
			foreach ($savings as $save) {
				$savingstot = $save->Savings;
			}
		}
 ?>

<link rel="stylesheet" type="text/css" href="<?php echo base_url('Assets/css/terminate.css'); ?>">

<script type="text/javascript">

	 function cancelfunction (controlno) {
	 	
	 	var txt;
	 	var r = confirm("Are you sure you want to cancel?");
	 	if (r== true) {
	 		/*window.location.href="profiles?name="+controlno;*/
	 		window.history.back();
	 	}
	 }

	 </script>

<br><br>
			<div class="basic-grey">
					
				<?php if ($paymenttype =='Cash Payment') { ?>
					
				<h1 style="text-align:center; color:#b7351b; border-top: 3px solid #f9f8f8; border-bottom:0">

						<br>
						CASH PAYMENT
						<br>

					</h1>
					<form action="payloanbalance_2" method='post'>
						<input type='hidden' name='controlno' value='<?php echo $controlno ?>'>
						<input type='hidden' name='datetoday' value='<?php echo date("Y-m-j"); ?>'>
						<input type ='hidden' name='sopersonnel' value='<?php echo $SOpersonnel; ?>'/>
						<label>
					        <span>Loan Balance :</span></label>
					        <input id="name" type="text" name='loanbalance' value="<?php echo $loanbalance ?>" style="width: 562px;" readonly=true/>

					    <label>
					        <span>Payment Received :</span></label>
					        <input id="name" type="number" min='1' max='<?php echo $loanbalance ?>' name="paymentrecieved" required value="" style="width: 562px;"/>

					        <br>
					    <input type="submit" value="Submit"/>
					    <input type="button" onclick="cancelfunction(<?php echo $controlno ?>)" value="Cancel"/>
					    </form>
						
				<br>

				<br><br><br><br><br>
				<?php } else if ($paymenttype == 'Savings') { ?>
					
				<?php if ($savingstot >= $loanbalance) { ?>
				
					<h1 style="text-align:center; color:#b7351b; border-top: 3px solid #f9f8f8; border-bottom:0">

						<br>
						SUCCESSFULLY PAID REMAINING BALANCE THROUGH SAVINGS! 
						<br>

					</h1>
						
						<label>
					        <span>Savings :</span></label>
					        <input id="name" type="text" name="fname" value="<?php echo $savingstot ?>" style="width: 562px;" disabled/>

					    <label>
					        <span>Loan Balance :</span></label>
					        <input id="name" type="text" name="loanbalance" value="<?php echo $loanbalance ?>" style="width: 562px;" disabled/>

					    <label>
					        <span>Current Savings :</span></label>
					        <input id="name" type="text" name="fname" value="<?php echo $savingstot-$loanbalance ?>" style="width: 562px; color:#b7351b; font-weight:bold;" disabled/>
					        <br><br>
					    <input type='submit' value='OK'>

						<br><br>
					
				<br><br><br>

				<br><br><br><br><br>
				<?php } elseif ($savingstot<$loanbalance) { ?>
					
					<h1 style="text-align:center; color:#b7351b; border-top: 3px solid #f9f8f8; border-bottom:0">

						<br>
						Insufficient Savings!
						<br>

					</h1>
						
						<label>
					        <span>Savings :</span></label>
					        <input id="name" type="text" name="fname" value="<?php echo $savingstot ?>" style="width: 562px;" disabled/>

					    <label>
					        <span>Loan Balance :</span></label>
					        <input id="name" type="text" name="fname" value="<?php echo $loanbalance ?>" style="width: 562px;" disabled/>

					    <label>
					        <span>Remaining Loan Balance :</span></label>
					        <input id="name" type="text" name="fname" value="<?php echo $loanbalance-$savingstot ?>" style="width: 562px; color:#b7351b; font-weight:bold;" disabled/>

						<br><br>

						<input type="button" value="Pay Remaining Balance"/>
						<input type="button" value="Cancel"/>
					
				<br><br><br>
<!------------------------------------------------------------------------>
<!------------------------------------------------------------------------>
<!------------------------------------------------------------------------>
<!------------------------------------------------------------------------>
<!------------------------------------------------------------------------>
				<br><br><br><br><br>
				<?php } ?>
				<?php } ?>
					<h1 style="text-align:center; color:#b7351b; border-top: 3px solid #f9f8f8; border-bottom:0">

						<br>
							Payment Received! <br>
							@Member's account has now been terminated.
						<br><br>

						<input type="button" value="Ok"/>
					</h1>
						
					
<!------------------------------------------------------------------------>



		    </div>

