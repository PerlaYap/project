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
		}

		foreach ($branchcenter as $bc) {
			$branch = $bc->BranchName;
			$center = $bc->CenterNo;
		}

		foreach ($loaninfo as $loan) {
			# code...
		}

 ?>


Report for printing <br><br><br>
PERSONAL INFORMATION <br><br>
Name: <?php echo $lastname.",".$FirstName." ".$middlename; ?>
<br>
Member ID: <?php echo $memid;?>
<br>
Home Address: <?php echo $addresshome; ?>
<br>
Contact Number: <?php echo $contactno; ?>
<br>
Branch: <?php echo $branch; ?>
<br>
Center: <?php echo $center; ?>
<br>
Date Entered: <?php echo $enter; ?>

<br><br><br>


CURRENT LOAN INFORMATION
<br><br>
Date Loan:
<br>
Loan Type:
<br>
Active Loan Release:
<br>
Loan Collected:
<br>
Remaining Balance:
<br><br>

	if wala current loan:   "NO CURRENT LOAN"

<br><br>
<!-- only shown if may current loan (BELOW) -->
Co-MAKER INFORMATION
<br>
Name:
<br>
Member ID:
<br>
Home Address:
<br>
Contact Number:
<br><br>
<!-- only shown if may current loan (ABOVE) -->

SAVINGS, WITHDRAWAL & CAPITAL SHARE
<br><br>
Current Savings:
<br>
Savings Withdrawn:
<br>
Number of Capital Shares:
<br>
Capital Shares worth:
<br><br><br>





if may loan pa,  
	"Please settle the remaining loan balance before termination."
	have option: Pay remaining balance    Use Savings to pay   Cancel

		if savings insufficient
			"Savings Insufficient to pay remaining balance."

			Current Savings:
			Less: Loan Balance:
			Remaining Loan Balance:  

				option:  Pay remaining balance      Cancel

				if Cancel
					"Please settle the remaining loan balance before termination."
				else
					Loan Balance:
					Payment Recieved:

					Submit      cancel

					Submit " You can no longer make changes after submitting this form. Are you sure you want to submit?"
						ok - successfully paid remaining loan.


		else
			"Successfully paid loan through savings."

			Current Savings:
			Less: Loan Balance:
			Total Savings Left:


	PAY REMAINING BALANCE:

		Loan Balance:
		Payment Recieved:

		Submit Cancel

		Submit " You can no longer make changes after submitting this form. Are you sure you want to submit?"
			ok - successfully paid remaining loan.


IF NO LOAN BALANCE:
are you sure you want to terminate this person?
	ok    cancel

IF OK
	NAME:
	Member ID:

RETURNING BALANCE
	Savings:
	Capital Share:

	TOTAL AMOUNT: 


	BM Signature: BM				 Date:
	Recieved By: the member          Date:
	Issued By: SO/ person created the report  Date:

	Released      Cancel


