<?php 

date_default_timezone_set('Asia/Manila');
$SOpersonnel =$this->session->userdata('personnelno');

		foreach ($profileinfo as $mem) {
			$lastname = $mem->LastName;
			$middlename = $mem->MiddleName;
			$FirstName = $mem->FirstName;
			$memid = $mem->MemberID;
			$mfi = $mem->MFI;
      		$enter = $mem->date;
			$addresshome = $mem->Address;
			$addressdate = $mem->AddressDate;
			$contactno = $mem->ContactNo;
			$bday = $mem->Birthday;
			$bplace = $mem->BirthPlace;
			$gender_id =$mem->GenderID;
			$cstatus = $mem->CivilStatus;
			$religion = $mem->Religion;
			$btype = $mem->BusinessType;
			$companyname = $mem->CompanyName;
			$comcontact = $mem->CompanyContact;
			$yearen = $mem->YearEntered;
			$edu = $mem->EducationalAttainment;
			$loanexpense = $mem->LoanExpense;
			$memcontrol = $mem->ControlNo;
		}

		foreach ($branchcenter as $bc) {
			$branch = $bc->BranchName;
			$center = $bc->CenterNo;
		}
		if (!empty($loaninfo)) {
		foreach ($loaninfo as $loan) {
			$AmountRequested = $loan->AmountRequested;
			$Interest = $loan->Interest;
			$Dateapplied = $loan->DateApplied;
			$dayofweek = $loan->DayoftheWeek;
			$status = $loan->Status;
			$LoanType = $loan->LoanType;
		}
		foreach ($comaker as $cm) {
					$cmlname = $cm->LastName;
					$cmfname = $cm->FirstName;
					$cmmname = $cm->MiddleName;
					$cmaddress = $cm->Address;
					$cmcontact = $cm->ContactNo;
					$cmid = $cm->MemberID;
				}		
		}

		if(!empty($capitalshare)){
		foreach ($capitalshare as $share) {
			if ($share->TotalShare >0) {
				$capital_share = $share->TotalShare.".00";	
			}else{
				$capital_share = "0.0";
			}
			
		}
		}else{
			$capital_share ="0.0";
		}
		
		if (!empty($savings)) {
			foreach ($savings as $save) {
				$savingstot = $save->Savings;
			}
		}

 ?>

<link rel="stylesheet" type="text/css" href="<?php echo base_url('Assets/css/terminate.css'); ?>">

<script type="text/javascript">

	function verify_action(){
		var r = confirm("Are you sure you want to pay through savings?");
		if (r == true) {
				return true;
		}else{
				return false;
		}	
	}

	function cancelfunction () {
	 	
	 	var txt;
	 	var r = confirm("Are you sure you want to cancel?");
	 	if (r== true) {
	 		
	 		window.history.back();
	 	}
	 }

</script>
			<br><br>
			<a href="<?php echo site_url('login/homepage'); ?>"> <img src="<?php echo base_url('Assets/images/caritaslogo.png'); ?>" class="caritaslogo"></a>

			<h3>
				CARITAS SALVE CREDIT COOPERATIVE <br> 

				<?php if ($type =='force'): ?>
							Membership Termination
					<?php endif ?>
					<?php if ($type == 'voluntary'): ?>
						Membership Withdrawal
					<?php endif ?>

				<!-- Membership Withdrawal --> <br> 
			</h3>

			<div class="basic-grey">
					<h1> <?php if ($type =='force'): ?>
							Member Termination
					<?php endif ?>
					<?php if ($type == 'voluntary'): ?>
						Member Withdrawal
					<?php endif ?>
						
				        <span>Review member information so as to avoid descrepancies.</span>
				    </h1>

				    <label>
				        <span>Name :</span></label>
				        <input id="name" type="text" name="fname" value="<?php echo $lastname.", ".$FirstName." ".$middlename; ?>" style="width: 562px;" disabled/>

				    <label>
				        <span>Member ID :</span></label>
				        <input id="name" type="text" name="fname" value="<?php echo $memid;?>" style="width: 562px;" disabled/>
				    
				    <label>
				        <span>Branch :</span></label>
				        <input id="name" type="text" name="fname" value="<?php echo $branch; ?>" style="width: 150px;" disabled/>

				        &nbsp&nbsp&nbsp&nbsp&nbsp
				        Center :
				        <input id="name" type="text" name="fname" value="<?php echo $center; ?>" style="width: 40px;" disabled/>

				        &nbsp&nbsp&nbsp&nbsp&nbsp
				        Date Entered :
				        <input id="name" type="text" name="fname" value="<?php echo $enter; ?>" style="width: 183px;" disabled/>

				    <label>
				        <span>Home Address :</span></label>
				        <input id="name" type="text" name="fname" value="<?php echo $enter; ?>" style="width: 562px;" disabled/>

				    <label>
				        <span>Contact No. :</span></label>
				        <input id="name" type="text" name="fname" value="<?php echo $contactno; ?>" style="width: 562px;" disabled/>

				<br><br><br>
				<h1>Savings & Capital Share</h1>

				 	<label>
				        <span>Current Savings :</span></label>
				        <input id="name" type="text" name="fname" value="<?php echo $savingstot.".00" ?>" style="width: 562px; font-weight: bold;" disabled/>

				   <!--  <label>
				        <span>Savings Withdrawn :</span></label>
				        <input id="name" type="text" name="fname" value="" style="width: 562px;" disabled/> -->

				    <label>
				        <span>No. of Capital Shares :</span></label>
				        <input id="name" type="text" name="fname" value="<?php echo $capital_share/100; ?>" style="width: 100px;" disabled/>

				        &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
				    	Capital Shares Worth :
				        <input id="name" type="text" name="fname" value="<?php echo $capital_share ?>" style="width: 297px; font-weight: bold;" disabled/>

				<br><br><br>

				<h1> Loan Information</h1>

				<?php if (!empty($loaninfo)){ ?>
				 	<label>
				        <span>Date of Loan :</span></label>
				        <input id="name" type="text" name="fname" value="<?php echo $Dateapplied; ?>" style="width: 562px;" disabled/>

				    <label>
				        <span>Loan Type :</span></label>
				        <input id="name" type="text" name="fname" value="<?php echo $LoanType; ?>" style="width: 562px;" disabled/>

				    <label>
				        <span>Active Loan Release :</span></label>
				        <input id="name" type="text" name="fname" value="<?php echo $AmountRequested+$Interest; ?>" style="width: 562px;" disabled/>

				    <label>
				        <span>Loan Collected :</span></label>
				        <input id="name" type="text" name="fname" value=" <?php echo ($AmountRequested+$Interest) - $loanexpense; ?>" style="width: 562px;" disabled/>

				    <label>
				        <span>Remaining Balance :</span></label>
				        <input id="name" type="text" name="fname" value="<?php echo $loanexpense;?>" style="width: 562px; color:#b7351b;" disabled/>



				<br><br><br>
				<h1> Co-Maker Information</h1>

				 	<label>
				        <span>Name :</span></label>
				        <input id="name" type="text" name="fname" value="<?php echo $cmlname.", ".$cmfname." ".$cmmname; ?>" style="width: 562px;" disabled/>

				    <label>
				        <span>Member ID :</span></label>
				        <input id="name" type="text" name="fname" value="<?php echo $cmid; ?>" style="width: 562px;" disabled/>

				    <label>
				        <span>Home Address :</span></label>
				        <input id="name" type="text" name="fname" value="<?php echo $cmaddress; ?>" style="width: 562px;" disabled/>

				    <label>
				        <span>Contact No. :</span></label>
				        <input id="name" type="text" name="fname" value="<?php echo $cmcontact; ?>" style="width: 562px;" disabled/>


				<br><br><br><br><br>

<!------------------------------------------------------------------------>
<!------------------------------------------------------------------------>
<!------------------------------------------------------------------------>
<!------------------------------------------------------------------------>
					<h1 style="text-align:center; color:#b7351b; border-top: 3px solid #f9f8f8;">
												<?php if ($type =="force") { ?>
							<br>REMAINING LOAN BALANCE<br>
						<?php }else{ ?>
						<br>
						PLEASE SETTLE THE REMAINING LOAN BALANCE <br>
						
							<?php } ?>
						<b>Php <?php echo $loanexpense ?> .00</b> <br><br>
							<?php if ($type=='voluntary'): ?>
						<form action='payloanbalance' method='post' id='myform'>
							<input type='hidden' name='controlno' value='<?php echo $memcontrol ?>'>
							<input type ='hidden' name='loanbalance' value='<?php echo $loanexpense ?>'>
							<input type='hidden' name='datetoday' value='<?php echo date("Y-m-j") ?>'>
							<input type ='hidden' name='sopersonnel' value='<?php echo $SOpersonnel; ?>'/>
						<input type="submit" name='paymenttype' value="Cash Payment"  class="button" style="margin-left:auto; margin-right:auto" />
						<input type="submit" name='paymenttype' onclick=" return verify_action()" value="Savings" class="button" style="width:140px;"/>
						</form>
						<?php endif ?>

						<?php if ($type=="force"): ?>
							<form action='terminatenow' method='post'>
				 			<input type='hidden' name='controlno' value='<?php echo $memcontrol ?>'>
				 			<input type='submit' value ='Terminate Membership' name='withdraw' class="button" style="margin-left: -200px;">
				 			<input type='button' value='Cancel' onclick='cancelfunction()' class="button1" style="margin-left:10px; margin-top: 0; width: 150px;">
				 		</form>
						<?php endif ?>
						<br><br>
					</h1>
				<br><br><br>

				 <?php } else{ ?>
				 		<h1 style="text-align:center; color:#b7351b; border-top: 3px solid #f9f8f8;">
				 			<br>
				 			--- No current loan ---
				 		</h1>
				 		<br><br>

				 		<form action='terminatenow' method='post'>
				 			<input type='hidden' name='controlno' value='<?php echo $memcontrol ?>'>
				 			<?php if ($type=='force'): ?>
				 				<input type='submit' value ='Terminate Membership' name='withdraw' class="button" style="margin-left: 250px;">
				 			<?php endif ?>
				 			<?php if ($type=='voluntary'): ?>
				 				<input type='submit' value ='Withdraw Membership' name='withdraw' class="button" style="margin-left: 250px;">
				 			<?php endif ?>
				 			
				 			<input type='button' value='Cancel' onclick='cancelfunction()' class="button1" style="margin-left:10px; margin-top: 0; width: 150px;">
				 		</form>
				 		<br><br>

					<?php } ?>

		    </div>

