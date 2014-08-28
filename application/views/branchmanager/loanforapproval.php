<!DOCTYPE HTML>


<link rel="stylesheet" type="text/css" href="<?php echo base_url('Assets/css/salveofficer.css'); ?>">
<script src="<?php echo base_url('Assets/js/general.js'); ?>"></script>
<script src="<?php echo base_url('Assets/js/jquery-1.11.1.js'); ?>"></script>

<?php $lid = $_GET['name']; 
$branchNo=$this->session->userdata('branchno');
$userrank = $this->session->userdata('rank');
?>


<?php $memberinfo=$this->db->query("SELECT LoanApplication_ControlNo AS LoanControl, lhm.Members_ControlNo AS MemberControl, MemberID, FirstName, MiddleName, LastName, BranchName, CenterNo
FROM loanapplication_has_members lhm
LEFT JOIN membersname mn ON mn.ControlNo=lhm.Members_ControlNo
LEFT JOIN
(SELECT CenterNo, BranchName, B.CenterControl, Members_ControlNo AS MemberControl FROM (SELECT * FROM caritascenters_has_members WHERE ISNULL(DateLeft))cchm
INNER JOIN (SELECT CenterControl, BranchControl, BranchName FROM (SELECT CaritasBranch_ControlNo AS BranchControl, CaritasCenters_ControlNo AS CenterControl, MAX(Date)
FROM (SELECT * FROM caritasbranch_has_caritascenters ORDER BY Date DESC)A GROUP BY CenterControl) A LEFT JOIN CaritasBranch cb ON cb.ControlNo=A.BranchControl WHERE BranchControl='$branchNo') B ON B.CenterControl=cchm.CaritasCenters_ControlNo
LEFT JOIN CaritasCenters cc ON cc.ControlNo=cchm.CaritasCenters_ControlNo) B ON B.MemberControl=lhm.Members_ControlNo
LEFT JOIN members mem ON mem.ControlNo=lhm.Members_ControlNo
WHERE LoanApplication_ControlNo=$lid LIMIT 1 "); 


foreach ($memberinfo->result() as $row) {
	$loanControl=$row->LoanControl;
	$firstName=$row->FirstName;
	$lastName=$row->LastName;
	$middleName=$row->MiddleName;
	$branchName=$row->BranchName;
	$centerNo=$row->CenterNo;
	$memberID=$row->MemberID;
	$memberControl=$row->MemberControl;
}
?>

<?php $loanbusiness=$this->db->query("SELECT lb.ControlNo, lb.BusinessName FROM loanbusiness_has_loanapplication lhl 
RIGHT JOIN (SELECT LoanApplication_ControlNo AS ControlNo FROM loanapplication_has_members lhm WHERE Members_ControlNo=(SELECT ControlNo FROM Members WHERE MemberID='$memberID')) A ON A.ControlNo=lhl.LoanApplication_ControlNo
LEFT JOIN loanbusiness lb ON lhl.LoanBusiness_ControlNo=lb.ControlNo GROUP BY BusinessName"); ?>

<?php $householdlist=$this->db->query("SELECT mhm.HouseholdNo, concat(hn.LastName,', ',hn.FirstName,' ', hn.MiddleName) AS Name
FROM members_has_membershousehold mhm 
LEFT JOIN householdname hn ON  mhm.HouseholdNo=hn.HouseholdNo
RIGHT JOIN (SELECT ControlNo FROM members mem WHERE mem.MemberID='$memberID')A ON A.ControlNo=mhm.ControlNo"); ?>

<?php $loanInfo=$this->db->query("SELECT ControlNo, ApplicationNumber, AmountRequested, Interest, DateApplied, DayoftheWeek, LoanType, Status, CapitalShare, IFNULL(A.ISubtotal,0) AS ISubtotal, IFNULL(B.FSubtotal,0) AS FSubtotal, IFNULL(C.BSubtotal,0) AS BSubtotal 
FROM loanapplication la
LEFT JOIN (SELECT loanapplication_ControlNo AS LoanControl, sum(Amount) AS ISubtotal FROM loanapplication_has_incometype GROUP BY LoanControl) A ON A.LoanControl=la.ControlNo
LEFT JOIN (SELECT loanapplication_ControlNo AS LoanControl, sum(Amount) AS FSubtotal FROM loanapplication_has_familyexpensetype GROUP BY LoanControl) B ON B.LoanControl=la.ControlNo
LEFT JOIN (SELECT loanapplication_ControlNo AS LoanControl, sum(Amount) AS BSubtotal FROM loanapplication_has_businessexpensetype GROUP BY LoanControl) C ON C.LoanControl=la.ControlNo
WHERE ControlNo=$lid"); 

foreach ($loanInfo->result() as $row) {
	$loanControl=$row->ControlNo;
	$applicationNumber=$row->ApplicationNumber;
	$amountRequested=$row->AmountRequested;
	$interest=$row->Interest;
	$dateApplied=$row->DateApplied;
	$dayoftheWeek=$row->DayoftheWeek;
	$loanType=$row->LoanType;
	$status=$row->Status;
	$capitalShare=$row->CapitalShare;
	$ISubtotal=$row->ISubtotal;
	$FSubtotal=$row->FSubtotal;
	$BSubtotal=$row->BSubtotal;
	$ITotal=$ISubtotal;
	$ETotal=$FSubtotal+$BSubtotal;
	$activerelease = $amountRequested + $interest;
}
?>

<?php $businessInfo=$this->db->query("SELECT A.ControlNo, BusinessName, BusinessType, Year, Month, Day, ContactNo, Address FROM loanbusiness_has_loanapplication lbhla
LEFT JOIN (SELECT lb.ControlNo, BusinessName, BusinessType, extract(Year FROM DateEstablished) AS Year, extract(Month FROM DateEstablished) AS Month,extract(Day FROM DateEstablished) AS Day, Address, ContactNo 
FROM loanbusiness lb 
LEFT JOIN businessaddress ba ON lb.ControlNo=ba.ControlNo
LEFT JOIN businesscontact bc ON lb.ControlNo=bc.ControlNo) A ON lbhla.LoanBusiness_ControlNo=A.ControlNo
WHERE LoanApplication_ControlNo='$lid'"); 

foreach ($businessInfo->result() as $row) {
	$businessControl=$row->ControlNo;
	$businessName=$row->BusinessName;
	$businessType=$row->BusinessType;
	$year=$row->Year;
	$month=$row->Month;
	$day=$row->Day;
	$businessContact=$row->ContactNo;
	$businessAddress=$row->Address;
}
?>

<?php $materials=$this->db->query("SELECT Material, Quantity, UnitPrice FROM loanbusiness_has_loanapplication WHERE LoanApplication_ControlNo='$lid'"); 
?>

<?php $noncomaker=$this->db->query("SELECT nmcm.MembersHousehold_HouseholdNo AS HouseholdControl, FirstName, MiddleName, LastName, CivilStatus, GenderID, Age, Occupation, Relationship
FROM nonmember_comaker nmcm 
LEFT JOIN membershousehold mh ON nmcm.MembersHousehold_HouseholdNo=mh.HouseholdNo
LEFT JOIN householdname hn ON nmcm.MembersHousehold_HouseholdNo=hn.HouseholdNo
LEFT JOIN householdoccupation ho ON nmcm.MembersHousehold_HouseholdNo=ho.HouseholdNo
LEFT JOIN members_has_membershousehold mhmh ON mhmh.HouseholdNo=nmcm.MembersHousehold_HouseholdNo
WHERE LoanApplication_ControlNo=$lid"); 

foreach ($noncomaker->result() as $row) {
	$householdControl=$row->HouseholdControl;
	$cfirstName=$row->FirstName;
	$cmiddleName=$row->MiddleName;
	$clastName=$row->LastName;
	$civilStatus=$row->CivilStatus;
	$gender=$row->GenderID;
	$age=$row->Age;
	$occupation=$row->Occupation;
	$crelationship=$row->Relationship;
}
?>

<?php $memcomaker=$this->db->query("SELECT MemberID, Relationship FROM member_comaker mc LEFT JOIN Members mem ON mc.Members_ControlNo=mem.ControlNo WHERE LoanApplication_ControlNo=$lid"); 

foreach ($memcomaker->result() as $row) {
	$memComakerID=$row->MemberID;
	$mrelationship=$row->Relationship;
}
?>

<?php $lastLoan=$this->db->query("SELECT Alpha.ControlNo AS LoanControl, (AmountRequested+Interest) AS TotalPayment, SUM(Beta.Amount) AS PastDue, SUM(Charlie.Amount) AS Payment FROM (SELECT ControlNo, AmountRequested, Interest, DateApplied, Members_ControlNo FROM (SELECT * FROM(SELECT * FROM LoanApplication la LEFT JOIN loanapplication_has_members lhm ON lhm.LoanApplication_ControlNo=la.ControlNo
WHERE Status='Full Payment' ORDER BY Members_ControlNo, DateApplied DESC)A GROUP BY Members_ControlNo)B WHERE Members_ControlNo=$memberControl)Alpha 
LEFT JOIN (SELECT * FROM Transaction trans WHERE transactiontype='Past Due')Beta ON Beta.LoanAppControlNo=Alpha.ControlNo
LEFT JOIN (SELECT * FROM Transaction trans WHERE transactiontype='Loan')Charlie ON Charlie.LoanAppControlNo=Alpha.ControlNo
WHERE Beta.ControlNo IS NOT NULL OR Charlie.ControlNo IS NOT NULL"); 
foreach ($lastLoan->result() as $row) {
	$loanControl=$row->LoanControl;
}
?>

<?php $businessExpense=$this->db->query("SELECT BusinessExpenseType_ExpenseType AS ExpenseType, Amount FROM loanapplication_has_businessexpensetype WHERE loanapplication_ControlNo='$lid'"); ?>

<?php $familyExpense=$this->db->query("SELECT FamilyExpenseType_ExpenseType AS ExpenseType, Amount FROM loanapplication_has_familyexpensetype WHERE loanapplication_ControlNo='$lid'"); ?>

<?php $sourceIncome=$this->db->query("SELECT IncomeType_IncomeType AS IncomeType, Amount FROM loanapplication_has_incometype WHERE loanapplication_ControlNo='$lid'"); ?>

<?php $pastDuePerformance = $this->db->query("SELECT Members_ControlNo AS MemberControl, Count(loanapplication_ControlNo) AS LoanCount, SUM(CapitalShare) AS TotalShare, TotalPastDue,TotalLoanTrans, Percent, PastDue23a, PastDue40a, PastDue23b, PastDue40b, PastDue23c, PastDue40c, PastDue23d, PastDue40d, PastDue23e, PastDue40e,
IFNULL(ROUND((((PastDue23a+PastDue40a)/TotalTransa)*100),2),0) AS Percenta,IFNULL(ROUND((((PastDue23b+PastDue40b)/TotalTransb)*100),2),0) AS Percentb, IFNULL(ROUND((((PastDue23c+PastDue40c)/TotalTransc)*100),2),0) AS Percentc, IFNULL(ROUND((((PastDue23d+PastDue40d)/TotalTransd)*100),2),0) AS Percentd, IFNULL(ROUND((((PastDue23e+PastDue40e)/TotalTranse)*100),2),0) AS Percente
FROM (SELECT * FROM loanapplication_has_members lhm WHERE Members_ControlNo='$memberControl') A 
LEFT JOIN LoanApplication la ON la.ControlNo=A.LoanApplication_ControlNo
LEFT JOIN
(SELECT MemberControl,TotalPastDue,TotalLoanTrans, ROUND(((TotalPastDue/TotalLoanTrans)*100),2) AS Percent FROM
(SELECT Members_ControlNo AS MemberControl, Count(ControlNo) AS TotalLoanTrans FROM transaction trans WHERE (transactiontype='Past Due' OR transactiontype='Loan') AND Members_ControlNo='$memberControl') A
CROSS JOIN
(SELECT Count(ControlNo) AS TotalPastDue FROM transaction trans WHERE transactiontype='Past Due' AND Members_ControlNo='$memberControl') B) C ON C.MemberControl=A.Members_ControlNo
CROSS JOIN
(SELECT Count(ControlNo) AS PastDue23a FROM transaction trans 
RIGHT JOIN (SELECT ControlNo AS LoanControl FROM LoanApplication la WHERE AmountRequested<=4000 AND loantype='23-Weeks') A 
ON A.LoanControl=trans.LoanAppControlNo  WHERE ControlNo IS NOT NULL AND transactiontype='Past Due' AND Members_ControlNo='$memberControl')Beta1
CROSS JOIN
(SELECT Count(ControlNo) AS PastDue40a FROM transaction trans 
RIGHT JOIN (SELECT ControlNo AS LoanControl FROM LoanApplication la WHERE AmountRequested<=4000 AND loantype='40-Weeks') A
ON A.LoanControl=trans.LoanAppControlNo  WHERE ControlNo IS NOT NULL AND transactiontype='Past Due' AND Members_ControlNo='$memberControl')Charlie1
CROSS JOIN
(SELECT Count(ControlNo) AS TotalTransa FROM transaction trans 
RIGHT JOIN (SELECT ControlNo AS LoanControl FROM LoanApplication la WHERE AmountRequested<=4000 AND (loantype='40-Weeks' OR loantype='23-Weeks')) A
ON A.LoanControl=trans.LoanAppControlNo  WHERE ControlNo IS NOT NULL AND (transactiontype='Past Due' OR transactiontype='Loan') AND Members_ControlNo='$memberControl') Delta1
CROSS JOIN
(SELECT Count(ControlNo) AS PastDue23b FROM transaction trans 
RIGHT JOIN (SELECT ControlNo AS LoanControl FROM LoanApplication la WHERE AmountRequested>4000 AND AmountRequested<=8000 AND loantype='23-Weeks') A 
ON A.LoanControl=trans.LoanAppControlNo  WHERE ControlNo IS NOT NULL AND transactiontype='Past Due' AND Members_ControlNo='$memberControl')Beta2
CROSS JOIN
(SELECT Count(ControlNo) AS PastDue40b FROM transaction trans 
RIGHT JOIN (SELECT ControlNo AS LoanControl FROM LoanApplication la WHERE AmountRequested>4000 AND AmountRequested<=8000 AND loantype='40-Weeks') A
ON A.LoanControl=trans.LoanAppControlNo  WHERE ControlNo IS NOT NULL AND transactiontype='Past Due' AND Members_ControlNo='$memberControl')Charlie2
CROSS JOIN
(SELECT Count(ControlNo) AS TotalTransb FROM transaction trans 
RIGHT JOIN (SELECT ControlNo AS LoanControl FROM LoanApplication la WHERE AmountRequested>4000 AND AmountRequested<=8000 AND (loantype='40-Weeks' OR loantype='23-Weeks')) A
ON A.LoanControl=trans.LoanAppControlNo  WHERE ControlNo IS NOT NULL AND (transactiontype='Past Due' OR transactiontype='Loan') AND Members_ControlNo='$memberControl') Delta2
CROSS JOIN
(SELECT Count(ControlNo) AS PastDue23c FROM transaction trans 
RIGHT JOIN (SELECT ControlNo AS LoanControl FROM LoanApplication la WHERE AmountRequested>8000 AND AmountRequested<=16000 AND loantype='23-Weeks') A 
ON A.LoanControl=trans.LoanAppControlNo  WHERE ControlNo IS NOT NULL AND transactiontype='Past Due' AND Members_ControlNo='$memberControl')Beta3
CROSS JOIN
(SELECT Count(ControlNo) AS PastDue40c FROM transaction trans 
RIGHT JOIN (SELECT ControlNo AS LoanControl FROM LoanApplication la WHERE AmountRequested>8000 AND AmountRequested<=16000 AND loantype='40-Weeks') A
ON A.LoanControl=trans.LoanAppControlNo  WHERE ControlNo IS NOT NULL AND transactiontype='Past Due' AND Members_ControlNo='$memberControl')Charlie3
CROSS JOIN
(SELECT Count(ControlNo) AS TotalTransc FROM transaction trans 
RIGHT JOIN (SELECT ControlNo AS LoanControl FROM LoanApplication la WHERE AmountRequested>8000 AND AmountRequested<=16000 AND (loantype='40-Weeks' OR loantype='23-Weeks')) A
ON A.LoanControl=trans.LoanAppControlNo  WHERE ControlNo IS NOT NULL AND (transactiontype='Past Due' OR transactiontype='Loan') AND Members_ControlNo='$memberControl') Delta3
CROSS JOIN
(SELECT Count(ControlNo) AS PastDue23d FROM transaction trans 
RIGHT JOIN (SELECT ControlNo AS LoanControl FROM LoanApplication la WHERE AmountRequested>16000 AND AmountRequested<=32000 AND loantype='23-Weeks') A 
ON A.LoanControl=trans.LoanAppControlNo  WHERE ControlNo IS NOT NULL AND transactiontype='Past Due' AND Members_ControlNo='$memberControl')Beta4
CROSS JOIN
(SELECT Count(ControlNo) AS PastDue40d FROM transaction trans 
RIGHT JOIN (SELECT ControlNo AS LoanControl FROM LoanApplication la WHERE AmountRequested>16000 AND AmountRequested<=32000 AND loantype='40-Weeks') A
ON A.LoanControl=trans.LoanAppControlNo  WHERE ControlNo IS NOT NULL AND transactiontype='Past Due' AND Members_ControlNo='$memberControl')Charlie4
CROSS JOIN
(SELECT Count(ControlNo) AS TotalTransd FROM transaction trans 
RIGHT JOIN (SELECT ControlNo AS LoanControl FROM LoanApplication la WHERE AmountRequested>16000 AND AmountRequested<=32000 AND (loantype='40-Weeks' OR loantype='23-Weeks')) A
ON A.LoanControl=trans.LoanAppControlNo  WHERE ControlNo IS NOT NULL AND (transactiontype='Past Due' OR transactiontype='Loan') AND Members_ControlNo='$memberControl') Delta4
CROSS JOIN
(SELECT Count(ControlNo) AS PastDue23e FROM transaction trans 
RIGHT JOIN (SELECT ControlNo AS LoanControl FROM LoanApplication la WHERE AmountRequested>32000 AND loantype='23-Weeks') A 
ON A.LoanControl=trans.LoanAppControlNo  WHERE ControlNo IS NOT NULL AND transactiontype='Past Due' AND Members_ControlNo='$memberControl')Beta5
CROSS JOIN
(SELECT Count(ControlNo) AS PastDue40e FROM transaction trans 
RIGHT JOIN (SELECT ControlNo AS LoanControl FROM LoanApplication la WHERE AmountRequested>32000 AND loantype='40-Weeks') A
ON A.LoanControl=trans.LoanAppControlNo  WHERE ControlNo IS NOT NULL AND transactiontype='Past Due' AND Members_ControlNo='$memberControl')Charlie5
CROSS JOIN
(SELECT Count(ControlNo) AS TotalTranse FROM transaction trans 
RIGHT JOIN (SELECT ControlNo AS LoanControl FROM LoanApplication la WHERE AmountRequested>32000 AND (loantype='40-Weeks' OR loantype='23-Weeks')) A
ON A.LoanControl=trans.LoanAppControlNo  WHERE ControlNo IS NOT NULL AND (transactiontype='Past Due' OR transactiontype='Loan') AND Members_ControlNo='$memberControl') Delta5");
	
  foreach ($pastDuePerformance->result() as $row) {
	$pdmemberControl = $row->MemberControl;
	$pdloanCount = $row->LoanCount;
  $pdtotalShare=$row->TotalShare;
  $pdtotalPastDue=$row->TotalPastDue;
  $pdtotalLoanTrans=$row->TotalLoanTrans;
  $pdpercent=$row->Percent;
  if (empty($pdpercent)) {
    $pdpercent = 0;
  }
  $pd23a=$row->PastDue23a;
  $pd23b=$row->PastDue23b;
  $pd23c=$row->PastDue23c;
  $pd23d=$row->PastDue23d;
  $pd23e=$row->PastDue23e;
  $pd40a=$row->PastDue40a;
  $pd40b=$row->PastDue40b;
  $pd40c=$row->PastDue40c;
  $pd40d=$row->PastDue40d;
  $pd40e=$row->PastDue40e;
  $pdpercenta=$row->Percenta;
  $pdpercentb=$row->Percentb;
  $pdpercentc=$row->Percentc;
  $pdpercentd=$row->Percentd;
  $pdpercente=$row->Percente;

}
 ?>
<script type="text/javascript">
window.onload = function() {

	$("#capitalshare").val('<?php echo $capitalShare ?>');
	$("#loanType").val('<?php echo $loanType ?>');
	$("#dayoftheWeek").val('<?php echo $dayoftheWeek ?>');
	$("#businessDrop").val('<?php echo $businessControl ?>');
	$("#establishMonth").val('<?php echo $month ?>');
	$("#establishDay").val('<?php echo $day ?>');
	$("#establishYear").val('<?php echo $year ?>');
	$("#comakerDrop").val('<?php echo $householdControl ?>');
	$("#genderDrop").val('<?php echo $gender ?>');
	$("#civilDrop").val('<?php echo $civilStatus ?>');

}
</script>

<body onload="TabLoanApprov();">
	<div class="content2">

		<div class="tabs">
			<input type="button" value="Loan Information" class="profile" onclick="TabLoanApprov()" id="loanapp"/>
			<input type="button" value="Member Performance" class="performance" onclick="TabLoanPerf()" id="loanperf"/>	
		</div>


		<div class="line">
		</div>


		<div id="ApplicationContent">
			<br><br><br>

			<div class="basic-grey">
				<h1>New Loan Application
					<span>Please fill all the texts in the fields.</span>
				</h1>

				<label>
					<span>
					</span>
					-------------------------------------------------  MEMBER INFORMATION  -------------------------------------------------
				</label>

				<label>
					<span>Name :</span></label>
					<input  id="name" type="text" disabled="true" style="width: 180px;" value="<?php echo $firstName ?>"/>
					<input  id="name" type="text" disabled="true" style="width: 170px;" value="<?php echo $middleName ?>"/>
					<input  id="name" type="text" disabled="true" style="width: 175px;" value="<?php echo $lastName ?>"/>


					<label>
						<span>Member ID :</span> </label>

						<input type="text" disabled="true" name="memberid" style="width:260px;" value="<?php echo $memberID ?>" >

						&nbsp &nbsp 
						Loan Date  :  
						<input type="text" disabled="true" name="loandate" style="width:207px;" value="<?php echo $dateApplied ?>" >

						<label>
							<span>Caritas Salve Branch :</span> </label>

							<input type="text" disabled="true" name="branch" style="width:400px;" value="<?php echo $branchName ?>">

							&nbsp &nbsp &nbsp &nbsp
							Center No. :  
							<input type="text" disabled="true" style="width:53px;" value="<?php echo $centerNo ?>" >


							<label>
								<span>
								</span>
								-------------------------------------------------  LOAN INFORMATION  -------------------------------------------------

							</label>

							<label>
								<span>Loan Application No. :</span> 
								<input disabled="true" type="text" id="application" name="appnumber" style="width: 210px;" value="<?php echo $applicationNumber?>"/>
								Amount of Shares :
								<select id="capitalshare" name="capitalshare" style="width:210px;" disabled/>
								<option value="100" selected="selected">100</option>
								<option value="200">200</option>
								<option value="300">300</option>
								<option value="400">400</option>
								<option value="500">500</option>
							</select>
						</label>  

						<label>
							<span>Amount Requested :</span></label>
							<input type="text" disabled="true" id="amountRequested" name="amountreq" style="width: 210px;" placeholder="Pesos" value="<?php echo $amountRequested ?>" />				        &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
							Interest Amount :
							<input type="text" disabled="true" id="interest" name="interest" style="width: 210px;" placeholder="%" value="<?php echo $interest ?>"/>

							<label>
								<span>Loan Type :</span></label>
								<select id="loanType" name="loantype" disabled="true" style="width:220px;">
									<option value="" selected="selected"></option>
									<option value="23-Weeks">23-weeks</option>
									<option value="40-Weeks">40-weeks</option>
								</select>

								&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
								Day of Payment :
								<select id="dayoftheWeek" name="paymentday" disabled="true" style="width:220px;">
									<option value="" selected="selected"></option>
									<option value="Monday">Monday</option>
									<option value="Tuesday">Tuesday</option>
									<option value="Wednesday">Wednesday</option>
									<option value="Thursday">Thursday</option>
									<option value="Friday">Friday</option>
								</select> 

								<label>
									<span>
									</span>
									----------------------------------------------  BUSINESS INFORMATION  ----------------------------------------------

								</label>

								<label>
									<span>Business :</span>
									<select  style="width:572px;" disabled="true" name="loanbusiness" id="businessDrop" onchange="showBusiness(this.value)">
										<option value=" "></option>
										<option value="newbusiness">New Business</option>
										<?php
										foreach ($loanbusiness->result() as $row) { 
											echo "<option value='".$row->ControlNo."'>".$row->BusinessName."</option>" ;
										} ?>
									</select>
								</label>




								<div id="newbusiness">
									<label>
										<span>Name :</span> 
										<input disabled="true" id="businessName" type="text" name="businessname" style="width:562px;" value="<?php echo $businessName ?>" /> 
									</label>

									<label>
										<span>Type :</span> </label>
										<input disabled="true" id="business" type="text" name="type" style="width:220px;" value="<?php echo $businessType ?>"/> 

										&nbsp&nbsp
										Date Established :

										<select disabled="true" id="establishMonth" name="month" style="width:85px">
											<option>Month</option>
											<option value="1">January</option>
											<option value="2">February</option>
											<option value="3">March</option>
											<option value="4">April</option>
											<option value="5">May</option>
											<option value="6">June</option>
											<option value="7">July</option>
											<option value="8">August</option>
											<option value="9">September</option>
											<option value="10">October</option>
											<option value="11">November</option>
											<option value="12">December</option>
										</select>
									</select>
									<select disabled="true" id="establishDay" name="day" style="width:55px">
										<option>Day</option>
										<?php  for ($i=1; $i < 32 ; $i++) { ?>
										<?php if ($i<10) { ?>
										<option value="<?php echo $i ?>"><?php echo '0'.$i ?></option>		
										<?php } else{ ?>
										<option value="<?php echo $i ?>"><?php echo $i ?></option>]
										<?php } ?>
										<?php  } ?> 
									</select>
									<select disabled="true" id="establishYear" name="year" style="width:67px">
										<option>Year</option>
										<?php  for ($y=1900; $y < 2000 ; $y++) { ?>
										<option value="<?php echo $y ?>"><?php echo $y ?></option>
										<?php  } ?>
									</select>


									<label>
										<span>Address :</span> 
										<input disabled="true" id="businessAddress" type="text" name="businessaddress" style="width:562px;" value="<?php echo $businessAddress ?>" /> 
									</label>

									<label>
										<span>Contact :</span> 
										<input disabled="true" id="businessContact" type="text" name="contact" style="width:562px;" value="<?php echo $businessContact ?>" /> 
									</label>
								</div>




								<label>
									<span>
									</span>
									------------------------------------------------  MATERIAL INVENTORY  -----------------------------------------------

								</label>

								<?php foreach ($materials->result() as $result) { ?>
								<label>
									<span>Name :</span></label>
									<input type="text" name="materials" id="material" style="width: 250px;" value="<?php echo $result->Material ?>" />

									&nbsp&nbsp&nbsp
									Qty :
									<input type="text" name="quantity" id="material" style="width: 26px;" value="<?php echo $result->Quantity ?>"/>

									&nbsp&nbsp&nbsp
									Unit Price :
									<input type="text" name="unitprice" id="material" style="width: 80px;" value="<?php echo $result->UnitPrice ?>"/> &nbsp&nbsp 

									<input type="button" class="addmore2" value="+" onclick="addMaterial()"/>
									<?php	} ?>

									<div id="inventory"></div>

								</label>				    

								<label>
									<span>
									</span>
									---------------------------------------------  CO-MAKER INFORMATION  ---------------------------------------------

								</label>

								<label>
									<span>Co-Maker :</span>
									<select  disabled="true" id="comakerDrop" name="comaker" style="width:572px;" onchange="showCoMaker(this.value)" >
										<option value=" " selected=""></option>
										<?php
										foreach ($householdlist->result() as $row) { 
											echo "<option value='".$row->HouseholdNo."'>".$row->Name."</option>" ;
										} ?>
										<option value="newhousehold">New Household</option>
									</select>
								</label>


								<div id="newhousehold">
									<label>
										<span>Name :</span> 
										<input id="fnHousehold" disabled="true" type="text" name="hfname" placeholder="First Name" style="width: 176px;" value="<?php echo $cfirstName ?>"/>
										<input id="mnHousehold" disabled="true" type="text" name="hmname" placeholder="Middle Name" style="width: 170px;" value="<?php echo $cmiddleName ?>"/>
										<input id="lnHousehold" disabled="true" type="text" name="hlname" placeholder="Last Name" style="width: 176px;" value="<?php echo $clastName ?>"/>
									</label>
									<label>
										<span>Relationship :</span> 
										<input id="household" disabled="true" type="text" name="hrelation" style="width:400px;" value="<?php echo $crelationship ?>"/> 
										&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
										Gender : 
										<select disabled="true" id="genderDrop" name="hgender" style="width:80px;">
											<option value=""></option>
											<option value="Male">Male</option>
											<option value="Female">Female</option>
										</select>
									</label>
									<label>
										<span>Occupation :</span> </label>
										<input disabled="true" id="household" type="text" name="hoccupation" style="width:233px;" value="<?php echo $occupation ?>" /> 

										&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
										Age :
										<input disabled="true" id="household" type="text" name="hage" style="width:70px;" value="<?php echo $age ?>" /> 

										&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
										Civil Status : 
										<select  id="civilDrop" disabled="true" name="hcivil" style="width:80px;">
											<option value=""></option>
											<option value="Single">Single</option>
											<option value="Married">Married</option>
										</select>

									</div>


									<label>
										<span>
										</span>
										------------------------------------------- MEMBER CO-MAKER INFORMATION  -----------------------------------

									</label>

									<label>
										<span>Co-Maker ID :</span> 
										<input id="memComakerID" disabled="true" type="text" name="mcomakerid" style="width:562px;" value="<?php echo $memComakerID ?>"/> 
									</label>

									<label>
										<span>Relationship :</span> 
										<input id="memComakerRelationship" disabled="true" type="text" name="mrelationship" style="width:562px;" value="<?php echo $mrelationship ?>"/> 
									</label>
<!--
					<label>
				    	<span>Valid ID :</span>
				    	<input type="file" name="file" id="file" multiple/>
				    </label>

				    <label>
				    	<span>Barangay Clearance :</span>
				    	<input type="file" name="file" id="file" multiple/>
				    </label>
				-->
				<br><br>








				<h1 style="border-top: 1px solid #DADADA; padding-top: 15px;" >Credit Investigation
					<span></span>
				</h1>

				<table class="creditinvestigation" border="1">
					<tr class="hdrrr">
						<td class="CIheader">SOURCE OF INCOME</td>
						<td class="CIheader2">DAILY INCOME</td>
					</tr>

					<?php foreach($sourceIncome->result() as $row){ ?>
					<tr class="hoverthis">
						<td class="CIdetail"><?php echo $row->IncomeType ?></td>
						<td class="CIdetail2"><?php echo $row->Amount ?></td>
					</tr>
					<?php }?>
					<tr class="hoverthis">
						<td class="CItotal">Sub-total</td>
						<td class="CItotal2"><?php echo $ISubtotal ?></td>
					</tr>

				</table>

				<br>

				<table class="creditinvestigation" border="1">
					<tr class="hdrrr">
						<td class="CIheader">FAMILY EXPENSE</td>
						<td class="CIheader2">DAILY EXPENSE</td>
					</tr>

					<?php foreach($businessExpense->result() as $row) { ?>
					<tr class="hoverthis">
						<td class="CIdetail"><?php echo $row->ExpenseType ?></td>
						<td class="CIdetail2"><?php echo $row->Amount ?></td>
					</tr>
					<?php } ?>

					<tr class="hoverthis">
						<td class="CItotal">Sub-total</td>
						<td class="CItotal2"><?php echo $FSubtotal ?></td>
					</tr>

				</table>

				<br>

				<table class="creditinvestigation" border="1">
					<tr class="hdrrr">
						<td class="CIheader">BUSINESS EXPENSE</td>
						<td class="CIheader2">DAILY EXPENSE</td>
					</tr>

					<?php foreach ($familyExpense->result() as $row) { ?>
					<tr class="hoverthis">
						<td class="CIdetail"><?php echo $row->ExpenseType ?></td>
						<td class="CIdetail2"><?php echo $row->Amount ?></td>
					</tr>
					<?php } ?>

					<tr class="hoverthis">
						<td class="CItotal">Sub-total</td>
						<td class="CItotal2"><?php echo $BSubtotal ?></td>
					</tr>

				</table>
				<br>
				<table class="creditinvestigation" border="1">
					<tr class="hoverthis">
						<td class="CItotal">Total Income</td>
						<td class="CItotal2"><?php echo $ITotal ?></td>
					</tr>

					<tr class="hoverthis">
						<td class="CItotal">Total Expense</td>
						<td class="CItotal2"><?php echo $ETotal ?></td>
					</tr>

				</table>

				<br><br><br><br>
				<label>
					<span></span>
					<?php if($status=='Pending'){ ?>
					<?php if($this->session->userdata('rank')=='branchmanager'){ ?>
					<form action='approveloan' method='post'>
						<div class="movesubmit">
							<input type='hidden' name='loanID' value='<?php echo $lid?>'>
							<input type="submit" class="button" value="Approve" />
						</div>
					</form>
					<form action='reasonrejectloan' method='post'>
						<div class="movereject">
							<input type='hidden' name='loanID' value='<?php echo $lid?>'>
							<input type="submit" class="button1" value="Reject" />
						</div>
					</form>
				       <?php }else if($this->session->userdata('rank')=='salveofficer'){ ?>
				        	<!--<form action='editloan' method='post'>
				    		<input type='hidden' name='loanID' value='<?php echo $lid?>'>
							<input type="submit" class="button" value="Edit Application" />
						</form>-->
						<?php }} else if($status=='Active'){?>	
						<?php if($this->session->userdata('rank')=='branchmanager'|| $this->session->userdata('rank')=='salveofficer'){?>
						<form action='printsummary' method='post'>
							<div class="movesubmit">
								<input type='hidden' name='loanID' value='<?php echo $lid?>'>
								<input type="submit" class="button" value="Release" style="margin-left:-290px; margin-top:0px;"/>
							</div>
						</form>
						<form action='approvedloans' method='post'>
							<div>
								<input type="submit" value="Back to List" class="button1" style="margin-left:270px; margin-top:-30px;"/>
							</div>
						</form>

						<?php }}else if($status=='Current' || $status=='Full Payment'){?>
						<?php if($this->session->userdata('rank')=='branchmanager'|| $this->session->userdata('rank')=='salveofficer'){?>
						<form action='showSummary' method='post'>
							<div class="movesubmit">
								<input type='hidden' name='loanID' value='<?php echo $lid?>'>
								<input type="submit" class="button" value="Release" />
							</div>
						</form>
						<?php if($userrank=='branchmanager') :?>
						<form action='showPayment' method='post'>
							<div>

								<input type='hidden' name='loanID' value='<?php echo $lid?>'>
								<input type="submit" class="button" value="Release" />
							</div>
						</form>
					<?php endif;?>
					<form action='approvedloans' method='post'>
						<div>
							<input type="submit" value="Back to List" />
						</div>
					</form>
					<?php }} ?>	

				</label>  
				<br><br><br><br><br><br><br><br>
			</div>

		</div>

		<div id="MemberPerformance">
			<br><br>
			<div class = "personalinfo">

				<div class="headername">Over-all Performance</div>
				<div class="skew"></div>
				<br>

				<br>
				<p class="info">Total Amount of Capital Shares: <b>Php <?php echo $pdtotalShare ?></b> </p>
				<p class="info">Loan Cycle: <b><?php echo $pdloanCount ?></b> </p>
				<p class="info">Overall Percentage of Past Due: <b><?php echo $pdpercent."% " ?>
					<?php 
					if($pdloanCount>3){
						if($pdpercent<=5) echo "EXCELLENT MEMBER";
						else if($pdpercent <=10 AND $pdpercent>5) echo "Very Good Member";
						else if($pdpercent<=20 AND $pdpercent>10) echo "Good Member";
						else echo "Poor Member";}
						else
							echo "EXCELLENT MEMBER";
						?>

					</b> </p>
					<p class="info">Accumulated no. of Past Due: <b><?php echo $pdtotalPastDue." Past Dues Out of ".$pdtotalLoanTrans." Loan Transactions" ?></b> </p>

					<br>

					<p style="text-align:center; font-size: 13px; color:#696666; margin-right: 50px;"><b>Number of Past Due in accordance to amount loaned</p>

					<table class="perfass3">
						<tr class="nohover">
							<th rowspan="2" class="bordr" style="width: 200px" >AMOUNT</th>
							<th colspan ="2" class="bordr">NO. OF PAST DUE</th>
							<th rowspan="2" class="bordr" style="width: 200px" >Past Due <br> Percent</th>
						</tr>

						<tr class="nohover">
							<td class="wk" style="width: 150px"> 23 Week</td>
							<td class="wk" style="width: 150px"> 40 Week</td>
						</tr>

						<tr class="hoverthis">
							<td class="sbu">4,000 and Less</td>
							<td class="sbu"> <?php echo $pd23a ?> </td>
							<td class="sbu"> <?php echo $pd40a ?> </td>
							<td class="sbu"> <?php echo $pdpercenta ?>%</td>
						</tr>
						<tr class="hoverthis">
							<td class="sbu">4,001 - 8,000</td>
							<td class="sbu"> <?php echo $pd23b ?> </td>
							<td class="sbu"> <?php echo $pd40b ?> </td>
							<td class="sbu"> <?php echo $pdpercentb ?>%</td>
						</tr>
						<tr class="hoverthis">
							<td class="sbu">8,001 - 16,000</td>
							<td class="sbu"> <?php echo $pd23c ?> </td>
							<td class="sbu"> <?php echo $pd40c ?> </td>
							<td class="sbu"> <?php echo $pdpercentc ?>%</td>
						</tr>
						<tr class="hoverthis">
							<td class="sbu">16,001 - 32,000</td>
							<td class="sbu"> <?php echo $pd23d ?> </td>
							<td class="sbu"> <?php echo $pd40d ?> </td>
							<td class="sbu"> <?php echo $pdpercentd ?>%</td>
						</tr>
						<tr class="hoverthis">
							<td class="sbu">32,001 Above</td>
							<td class="sbu"> <?php echo $pd23e ?> </td>
							<td class="sbu"> <?php echo $pd40e ?> </td>
							<td class="sbu"> <?php echo $pdpercente ?>%</td>
						</tr>							

					</table>

					<br><br>

					<div class="innerinfo">
						<p>
							The Member has a total of <?php echo "Php ".$pdtotalShare ?> worth share as of <?php echo date('F d, Y') ?>. Also, the member shows a <?php echo $pdpercent ?>% of commiting a past due from his overall loans.
						</p>
					</div>
				</div>
				<?php if ($loanControl!=NULL) { ?>
				<div class = "personalinfo">

					<div class="headername">Loan Collection Of Loan Number <?php echo $loanControl ?> </div>
					<div class="skew"></div>

					<br>
					<?php $this->session->set_userdata('controlno', $memberControl); ?>
					<?php $this->session->set_userdata('request', 2); ?>
					<iframe src="<?php echo base_url('general/loancollectionpiechart') ?>"  frameBorder="0" class="frame"></iframe>
					
					<br>
				</div>

				<?php } ?>
				<div class = "personalinfo">

					<div class="subheadername">Overview</div>
					<div class="subskew"></div>
					<br>

					<br>
					<p class="info">Insert note here..</p>


					<br>
				</div>


				<div class = "personalinfo">

					<div class="headername">Savings Summary As Of <?php echo date("Y/m/d") ?></div>
					<div class="subskew"></div>
					<br>
<?php $savings = $this->db->query("SELECT m.savings, m.ControlNo FROM  loanapplication_has_members lm, members m WHERE lm.loanapplication_controlno = '$lid' AND lm.Members_ControlNo = m.ControlNo "); 

foreach($savings->result() as $save){

	$actual = $save->savings;
	$control_no = $save->ControlNo;

}

$date = $this->db->query("SELECT TIMESTAMPDIFF(WEEK,(SELECT DateEntered FROM CaritasCenters_has_Members cm, Members m WHERE cm.Members_ControlNo='$control_no' AND cm.Members_ControlNo = m.ControlNo),NOW()) AS diff");

foreach($date->result() as $dt){

 $diff = $dt->diff;

}

$expected = $diff*50;
?>


				
						<p class="info00">Actual Amount of Savings: P<b> <?php echo $actual;?></b></p>
						<p class="info00">Expected Amount of Savings: P<b> <?php echo $expected;?></b></p>
						
						<br>




						<div class="innerinfo">
							<p class="info01">
								<?php 
								if(!$actual ==0){
								if ($actual < $expected){
									$kulang = $expected-$actual;
									echo 'You need to save P'.$kulang.'more! ';

								} else{

									echo ' The savings deposited in the account of the member has met 
									the expected amount of savings! ';
								}
							}
								?>

					


							</p>
						</div>
					</div>
				</div>
				<br><br><br><br><br><br>
			</div>

			<br><br><br><br><br><br><br><br><br><br>