<?php 
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


			<div class="basic-grey">
					<h1>Member Voluntary Termination
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

						<br>
						PLEASE SETTLE THE REMAINING LOAN BALANCE <br>
						<b>Php <?php echo $loanexpense ?> .00</b> <br><br>
						<form action='payloanbalance' method='post'>
							<input type='hidden' name='controlno' value='<?php echo $memcontrol ?>'>
							<input type ='hidden' name='loanbalance' value='<?php echo $loanexpense ?>'>
						<input type="submit" name='paymenttype' value="Cash Payment"/>
						<input type="submit" name='paymenttype' value="Savings"/>
						</form>
						<br><br>
					</h1>
				<br><br><br>

				 <?php } else{ ?>
				 		NO CURRENT LOAN
					<?php } ?>

		    </div>

