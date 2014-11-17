

<link rel="stylesheet" type="text/css" href="<?php echo base_url('Assets/css/general.css'); ?>">
<script src="<?php echo base_url('Assets/js/general.js'); ?>"></script>



<?php

$userrank = $this->session->userdata("rank");
$branch = $this->session->userdata('branchno');
$control_no = $_GET['name'];
/*$control_no = $name;*/
/*SQL QUERIES*/


$getMember =$this->db->query("SELECT  mem.ControlNo, MemberID,memname.LastName,memname.FirstName, memname.MiddleName, ContactNo,Birthday,BirthPlace, GenderID, Religion, Date(cm.DateEntered) as date, EducationalAttainment,CivilStatus, MFI,Address,AddressDate, Status, Type,BusinessType,CompanyName,CompanyContact,YearEntered, LoanExpense,Savings, CapitalShare 
                                FROM 
                                Members mem 
                                LEFT JOIN MembersName memname ON mem.ControlNo=memname.ControlNo
                                LEFT JOIN (SELECT ControlNo, Status FROM members_has_membersmembershipstatus ORDER BY DateUpdated DESC LIMIT 1) mhmstatus ON mem.ControlNo=mhmstatus.ControlNo
                                
                                LEFT JOIN (SELECT ControlNo, Type FROM members_has_membertype ORDER BY DateUpdated DESC LIMIT 1) mhmtype ON mem.ControlNo=mhmtype.ControlNo
                                LEFT JOIN MembersContact memcontact ON mem.ControlNo=memcontact.ControlNo
                                LEFT JOIN membersmfi mfi ON mem.ControlNo=mfi.ControlNo
                                LEFT JOIN membersaddress madd ON mem.ControlNo=madd.ControlNo
                                LEFT JOIN sourceofincome soi ON mem.ControlNo=soi.ControlNo
                                LEFT JOIN CaritasCenters_has_Members cm ON mem.ControlNo = cm.Members_ControlNo
                                WHERE mem.ControlNo='$control_no'");

$getHousehold =$this->db->query("SELECT ControlNo, msmhouse.HouseholdNo, Relationship, Age, GenderID, CivilStatus, A.Name, A.Occupation
                    FROM members_has_membershousehold msmhouse
                    LEFT JOIN 
                    (SELECT memhouse.HouseholdNo AS HouseholdNo, Age, GenderID, CivilStatus,  concat(hname.LastName,', ',hname.FirstName,' ', hname.MiddleName) AS Name, Occupation FROM membershousehold memhouse
                    LEFT JOIN householdname hname ON memhouse.HouseholdNo=hname.HouseholdNo
                    LEFT JOIN householdoccupation hoccu ON memhouse.HouseholdNo=hoccu.HouseholdNo)A ON msmhouse.HouseholdNo=A.HouseholdNo
                    WHERE ControlNo='$control_no'");

$getOrganization =$this->db->query("SELECT * FROM `membersorganization` WHERE `ControlNo`='$control_no' ");

$getbranchandcenter = $this->db->query("SELECT cm.`CaritasCenters_ControlNo`, cc.`CenterNo`, cbc.`CaritasBranch_ControlNo`, b.`BranchName`
FROM `caritascenters_has_members` cm, `caritascenters` cc, `caritasbranch_has_caritascenters` cbc,
`caritasbranch` b
where `Members_ControlNo` = '$control_no' and cm.`CaritasCenters_ControlNo` = cc.`ControlNo` and
cbc.`CaritasCenters_ControlNo` = cc.`ControlNo` and
b.`ControlNo` = cbc.`CaritasBranch_ControlNo`");

foreach ($getbranchandcenter->result() as $bc) {
	$branch = $bc->BranchName;
	$center = $bc->CenterNo;
}

	foreach ($getMember->result() as $mem) {

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

	$getPic =$this->db->query("SELECT * FROM MembersPicture WHERE ControlNo = '$control_no' ");

	$getDoc =$this->db->query("SELECT * FROM MembersSignature WHERE ControlNo = '$control_no' ");
 ?>

 <?php $getLoanInfo = $this->db->query("SELECT loanapplication_ControlNo AS LoanControl, ApplicationNumber, AmountRequested, Interest, DateApplied, DayoftheWeek, Status, LoanType FROM loanapplication_has_members lhm
LEFT JOIN loanapplication la ON lhm.LoanApplication_ControlNo=la.ControlNo
WHERE lhm.Members_ControlNo='$control_no' and Status='Current'");
 ?>
 
<?php $savings = $this->db->query("SELECT m.savings, mm.status, m.ControlNo FROM  loanapplication_has_members lm, members m, members_has_membersmembershipstatus mm WHERE lm.Members_ControlNo = m.ControlNo AND m.ControlNo = mm.ControlNo AND m.ControlNo = '$control_no' "); 

foreach($savings->result() as $save){


	$actual = $save->savings;
	$status = $save->status;
}

$date = $this->db->query("SELECT TIMESTAMPDIFF(WEEK, NOW(),(SELECT DateEntered FROM CaritasCenters_has_Members cm, Members m WHERE cm.Members_ControlNo='$control_no' AND cm.Members_ControlNo = m.ControlNo)) AS diff");

foreach($date->result() as $dt){

 $diff = $dt->diff;

}

$expected = $diff*50;
?>


 <?php $pastDuePerformance = $this->db->query("SELECT Members_ControlNo AS MemberControl, Count(loanapplication_ControlNo) AS LoanCount, SUM(CapitalShare) AS TotalShare, TotalPastDue,TotalLoanTrans, Percent, PastDue23a, PastDue40a,PastDue23b, PastDue40b, PastDue23c, PastDue40c, PastDue23d, PastDue40d, PastDue23e, PastDue40e
FROM (SELECT * FROM loanapplication_has_members lhm WHERE Members_ControlNo='$control_no') A 
LEFT JOIN LoanApplication la ON la.ControlNo=A.LoanApplication_ControlNo
LEFT JOIN
(SELECT MemberControl,TotalPastDue,TotalLoanTrans, ((TotalPastDue/TotalLoanTrans)*100) AS Percent FROM
(SELECT Members_ControlNo AS MemberControl, Count(ControlNo) AS TotalLoanTrans FROM transaction trans WHERE (transactiontype='Past Due' OR transactiontype='Loan') AND Members_ControlNo='$control_no') A
CROSS JOIN
(SELECT Count(ControlNo) AS TotalPastDue FROM transaction trans WHERE transactiontype='Past Due' AND Members_ControlNo='$control_no') B) C ON C.MemberControl=A.Members_ControlNo
CROSS JOIN
(SELECT Count(ControlNo) AS PastDue23a FROM transaction trans 
RIGHT JOIN (SELECT ControlNo AS LoanControl FROM LoanApplication la WHERE AmountRequested<=4000 AND loantype='23-Weeks') A 
ON A.LoanControl=trans.LoanAppControlNo  WHERE ControlNo IS NOT NULL AND transactiontype='Past Due' AND Members_ControlNo='$control_no')Beta1
CROSS JOIN
(SELECT Count(ControlNo) AS PastDue40a FROM transaction trans 
RIGHT JOIN (SELECT ControlNo AS LoanControl FROM LoanApplication la WHERE AmountRequested<=4000 AND loantype='40-Weeks') A
ON A.LoanControl=trans.LoanAppControlNo  WHERE ControlNo IS NOT NULL AND transactiontype='Past Due' AND Members_ControlNo='$control_no')Charlie1
CROSS JOIN
(SELECT Count(ControlNo) AS PastDue23b FROM transaction trans 
RIGHT JOIN (SELECT ControlNo AS LoanControl FROM LoanApplication la WHERE AmountRequested>4000 AND AmountRequested<=8000 AND loantype='23-Weeks') A 
ON A.LoanControl=trans.LoanAppControlNo  WHERE ControlNo IS NOT NULL AND transactiontype='Past Due' AND Members_ControlNo='$control_no')Beta2
CROSS JOIN
(SELECT Count(ControlNo) AS PastDue40b FROM transaction trans 
RIGHT JOIN (SELECT ControlNo AS LoanControl FROM LoanApplication la WHERE AmountRequested>4000 AND AmountRequested<=8000 AND loantype='40-Weeks') A
ON A.LoanControl=trans.LoanAppControlNo  WHERE ControlNo IS NOT NULL AND transactiontype='Past Due' AND Members_ControlNo='$control_no')Charlie2
CROSS JOIN
(SELECT Count(ControlNo) AS PastDue23c FROM transaction trans 
RIGHT JOIN (SELECT ControlNo AS LoanControl FROM LoanApplication la WHERE AmountRequested>8000 AND AmountRequested<=16000 AND loantype='23-Weeks') A 
ON A.LoanControl=trans.LoanAppControlNo  WHERE ControlNo IS NOT NULL AND transactiontype='Past Due' AND Members_ControlNo='$control_no')Beta3
CROSS JOIN
(SELECT Count(ControlNo) AS PastDue40c FROM transaction trans 
RIGHT JOIN (SELECT ControlNo AS LoanControl FROM LoanApplication la WHERE AmountRequested>8000 AND AmountRequested<=16000 AND loantype='40-Weeks') A
ON A.LoanControl=trans.LoanAppControlNo  WHERE ControlNo IS NOT NULL AND transactiontype='Past Due' AND Members_ControlNo='$control_no')Charlie3
CROSS JOIN
(SELECT Count(ControlNo) AS PastDue23d FROM transaction trans 
RIGHT JOIN (SELECT ControlNo AS LoanControl FROM LoanApplication la WHERE AmountRequested>16000 AND AmountRequested<=32000 AND loantype='23-Weeks') A 
ON A.LoanControl=trans.LoanAppControlNo  WHERE ControlNo IS NOT NULL AND transactiontype='Past Due' AND Members_ControlNo='$control_no')Beta4
CROSS JOIN
(SELECT Count(ControlNo) AS PastDue40d FROM transaction trans 
RIGHT JOIN (SELECT ControlNo AS LoanControl FROM LoanApplication la WHERE AmountRequested>16000 AND AmountRequested<=32000 AND loantype='40-Weeks') A
ON A.LoanControl=trans.LoanAppControlNo  WHERE ControlNo IS NOT NULL AND transactiontype='Past Due' AND Members_ControlNo='$control_no')Charlie4
CROSS JOIN
(SELECT Count(ControlNo) AS PastDue23e FROM transaction trans 
RIGHT JOIN (SELECT ControlNo AS LoanControl FROM LoanApplication la WHERE AmountRequested>32000 AND loantype='23-Weeks') A 
ON A.LoanControl=trans.LoanAppControlNo  WHERE ControlNo IS NOT NULL AND transactiontype='Past Due' AND Members_ControlNo='$control_no')Beta5
CROSS JOIN
(SELECT Count(ControlNo) AS PastDue40e FROM transaction trans 
RIGHT JOIN (SELECT ControlNo AS LoanControl FROM LoanApplication la WHERE AmountRequested>32000 AND loantype='40-Weeks') A
ON A.LoanControl=trans.LoanAppControlNo  WHERE ControlNo IS NOT NULL AND transactiontype='Past Due' AND Members_ControlNo='$control_no')Charlie5");
	
  foreach ($pastDuePerformance->result() as $row) {
	$pdmemberControl = $row->MemberControl;
	$pdloanCount = $row->LoanCount;
  $pdtotalShare=$row->TotalShare;
  $pdtotalPastDue=$row->TotalPastDue;
  $pdtotalLoanTrans=$row->TotalLoanTrans;
  $pdpercent=$row->Percent;
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
}



$loan = $this->db->query("SELECT l.loantype, date(l.datereleased) as DateApproved, l.AmountRequested, l.Interest, m.Savings, m.LoanExpense, sum(t.Amount) as withdraw FROM loanapplication l, loanapplication_has_members lm, members m, transaction t WHERE m.ControlNo = '$control_no' AND m.ControlNo = t.Members_ControlNo AND lm.Members_ControlNo AND lm.LoanApplication_ControlNo = l.ControlNo AND t.transactiontype = 'Withdrawal' ");

foreach($loan->result() as $l){
$type = $l->loantype;
$req = $l->AmountRequested;
$interest = $l->Interest;
$currentsavings = $l->Savings;
$withdraw = $l->withdraw;
$expense= $l->LoanExpense;
$approved = $l->DateApproved;

}

$capital = $pdtotalShare/100;


$active = $req+$interest;
$loancollected = $req+$interest-$expense;


 ?> 



<body>


		<div class="content33">

			<!-------------------->
			<!-------------------->
				<!--------------------------------------------------------------------> 
		
				<div class = "personalinfo">

					<div class="headername"><b><?php echo $lastname  ?></b>, <?php echo $FirstName." ".$middlename ; ?></div>
						<div class="skew"></div>
		      <br>

					<br>

          <form class="basic-grey">
            <h1> <br>Member Information</h1>
           

            <label>
              <span>Member ID:</span>
              <input type="text" disabled value="<?php echo $memid; ?>"/>
            </label>

            <label>
              <span>Home Address:</span>
              <input type="text" disabled value="<?php echo $addresshome; ?>"/>
            </label>

            <label>
              <span>Contact No.:</span>
              <input type="text" disabled value="<?php echo $contactno; ?>"/>
            </label>
            <label>
              <span>Branch:</span>
              <input type="text" disabled value="<?php echo $branch; ?>" style="width: 40%;"/>
              
              &nbsp &nbsp &nbsp &nbsp

              Center: 
              <input type="text" disabled value="<?php echo $center; ?>" style="width: 20.5%"/>
           </label>

           <label>
              <span>Date Entered:</span>
              <input type="text" disabled value="<?php echo $enter; ?>"/>
            </label>

          <h1> <br><br>Past Due Matured Loan Information</h1>

            <label>
              <span>Current Type of Loan:</span>
              <input type="text" disabled value="<?php echo $type; ?>"/>
            </label>

            <label>
              <span>Date Approved:</span>
              <input type="text" disabled value="<?php echo $approved; ?>"/>
            </label>
					
				    <label>
              <span>Active Release: </span>
              <input type="text" disabled value="<?php echo $active; ?>"/>
            </label>

            <label>
              <span>Loan Collected:</span>
              <input type="text" disabled value="<?php echo $loancollected; ?>" style="width: 23%;"/>

              &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp  &nbsp &nbsp &nbsp &nbsp&nbsp &nbsp &nbsp &nbsp&nbsp &nbsp

               Unpaid Balance:
              <input type="text" disabled value="<?php echo $expense; ?>" style="width: 23%;"/>
            </label>

            <label>
              <span>Current Savings:</span>
              <input type="text" disabled value="<?php echo $actual?>" style="width: 23%;"/>

              &nbsp &nbsp &nbsp &nbsp&nbsp &nbsp &nbsp &nbsp&nbsp &nbsp &nbsp &nbsp&nbsp &nbsp

               Savings Withdrawn:
              <input type="text" disabled value="<?php echo $withdraw; ?>" style="width: 23%;"/>
            </label>

            <label>
              <span>No. of Capital Shares:</span>
              <input type="text" disabled value="<?php echo $capital; ?>"/>
            </label>

            <label>
              <span>Capital Shares Worth:</span>
              <input type="text" disabled value="<?php echo $pdtotalShare ?>" style="width: 23%;"/>

     <!--         &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp&nbsp &nbsp &nbsp &nbsp

               Capital Shares Return:
              <input type="text" disabled value="" style="width: 23%;"/>
            </label> -->
         
          <h1><br><br>Household Information:</h1>
      
            <?php foreach ($getHousehold->result() as $house) { ?>

              <label>
                <span>Name:</span>
                <input type="text" disabled value="<?php echo $house->Name; ?>"/>
              </label>
              
              <label>
                <span>Relationship:</span>
                <input type="text" disabled value="<?php echo $house->Relationship; ?>"/>
              </label>

              <label>
                <span>Gender:</span>
                <input type="text" disabled value="<?php echo $house->GenderID; ?>" style="width: 20%;"/>

                &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp

                Age: 
                <input type="text" disabled value="<?php echo $house->Age; ?>" style="width: 10%;"/>
               
                &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp

                Civil Status: 
                <input type="text" disabled value="<?php echo $house->CivilStatus; ?>" style="width: 20.2%;"/>
              </label>

              <label>
                <span>Occupation: </span>
                <input type="text" disabled value="<?php echo $house->Occupation; ?>"/>
              </label>

             
            </form>
            <?php } ?>
				    
				</div>


		

				<!--------------------------------------------------------------------> 
				<br>
		

					
				

			<!-------------------->
			<!---------PERFORMANCE----------->
			<!-------------------->

			

			<div id="divperformance">
					<div class="headername" style="margin-top: -20px;">Over-all Performance</div>
						<div class="skew"></div>
					

					<p class="info00">
            Total Amount of Capital Shares: <b>Php <?php echo $pdtotalShare ?></b> <br>
  				  Loan Cycle: <b><?php echo $pdloanCount ?></b>  <br>
  				  Percentage of Past Due: <b><?php echo $pdpercent."%" ?></b>  <br>
  					Accumulated no. of Past Due: <b><?php echo $pdtotalPastDue." Past Dues Out of ".$pdtotalLoanTrans." Loan Transactions" ?></b>  <br>
          </p>

					<br>
				
					<p style="text-align:center; font-size: 13px; color:#696666; margin-right: 120px;"><b>Number of Past Due in accordance to amount loaned</p>

					<table class="perfass3" >
						<tr class="nohover">
							<th rowspan="2" class="bordr" style="width: 200px" >AMOUNT</th>
							<th colspan ="2" class="bordr">NO. OF PAST DUE</th>
						</tr>

							<tr class="nohover">
								<td class="wk" style="width: 150px"> 23 Week</td>
								<td class="wk" style="width: 150px"> 40 Week</td>
							</tr>
					
						<tr class="hoverthis">
							<td class="sbu">4,000 and Less</td>
							<td class="sbu"> <?php echo $pd23a ?> </td>
							<td class="sbu"> <?php echo $pd40a ?> </td>
						</tr>
						<tr class="hoverthis">
							<td class="sbu">4,001 - 8,000</td>
							<td class="sbu"> <?php echo $pd23b ?> </td>
							<td class="sbu"> <?php echo $pd40b ?> </td>
						</tr>
						<tr class="hoverthis">
							<td class="sbu">8,001 - 16,000</td>
							<td class="sbu"> <?php echo $pd23c ?> </td>
							<td class="sbu"> <?php echo $pd40c ?> </td>
						</tr>
						<tr class="hoverthis">
							<td class="sbu">16,001 - 32,000</td>
							<td class="sbu"> <?php echo $pd23d ?> </td>
							<td class="sbu"> <?php echo $pd40d ?> </td>
						</tr>
						<tr class="hoverthis">
							<td class="sbu">32,001 Above</td>
							<td class="sbu"> <?php echo $pd23e ?> </td>
							<td class="sbu"> <?php echo $pd40e ?> </td>
						</tr>							

					</table>

				    <br>
				    
				    <div class="innerinfo2">
				    	<p>
				    		The Member has a total of <?php echo "Php ".$pdtotalShare ?> as of <?php echo date('F d, Y') ?>. Also, the member shows a <?php echo $pdpercent ?>% of commiting a past due from his overall loans.
				    	</p>
				    </div>

				    	<!-- 	COMMENTS 
				    	<h2 style='color:red'>note here (A BOX PARANG ALERT) -> this box will only appear kung nagaapply ng new loan</h2>-->
		
              <br>
				
				<?php if (!empty($hasloan)) { ?>
				
			   
				

					<div class="headername">Loan Collection as of <?php echo date("Y/m/d") ?> </div>
						<div class="skew"></div>

					<br>
					<?php $this->session->set_userdata('controlno', $control_no); ?>
					<!-- <iframe src="<?php echo base_url('general/loancollectionpiechart') ?>" frameBorder="0" class="frame"></iframe> -->
					
					<br>
			
				<?php } ?>


				<!-- 	<div class="headername">LOAN & SAVINGS PROGRESS</div>
						<div class="subskew"></div>
					<br><br>

						<iframe src="<?php echo base_url('general/loanperformance') ?>" width="900px;" height="600px;" frameBorder="0" scrolling="no"></iframe>
						<br>
						<iframe src="<?php echo base_url('general/savingsperformance') ?>"  width="900px;" height="600px;" frameBorder="0" scrolling="no"></iframe>

								
					</table>

          <br>
          </div> -->

          <!-- <form class="basic-grey">
            <h1>
              <br><br>
              Total Payment: <?php echo $expense; ?>
            </h1>
<?php $dead = date('Y-m-d', strtotime("+14 days"));

$getSO = $this->db->query("SELECT  cb.ControlNo, CONCAT(FirstName, ' ', MiddleName, ' ', LastName) AS Officer  FROM caritasbranch cb, CaritasBranch_has_CaritasPersonnel cp, CaritasPersonnel cl
 where cb.ControlNo='$branch' and 
 cb.ControlNo = cp.CaritasBranch_ControlNo AND cp.CaritasPersonnel_ControlNo = cl.ControlNo
    AND cl.Rank = 'salveofficer' "); 

 ?>
              <label>
                  <span>Deadline before Termination: </span>
                  <input type="text" disabled value="<?php echo $dead; ?>"/>
              </label>

              <label>
                  <span>Date of Payment: </span>
                  <select name="month" style="width:130px;" required>
                    <option value="" selected="selected"></option>
                    <option value="01">January</option>
                    <option value="02">February</option>
                    <option value="03">March</option>
                    <option value="04">April</option>
                    <option value="05">May</option>
                    <option value="06">June</option>
                    <option value="07">July</option>
                    <option value="08">August</option>
                    <option value="09">September</option>
                    <option value="10">October</option>
                    <option value="11">November</option>
                    <option value="12">December</option>
                  </select>

                  <select name="day" style="width:80px;" required>
                    <option value="" selected="selected"></option>
                      <?php  for ($i=1; $i < 32 ; $i++) { ?>

                        <?php if ($i<10) { ?>
                            
                        <option value="<?php echo '0'.$i ?>"><?php echo '0'.$i ?></option>    

                        <?php } else{ ?>

                        <option value="<?php echo $i ?>"><?php echo $i ?></option>

                        <?php } ?>
                      <?php  } ?>
                  </select>

                  <select name="year" style="width:100px;" required>
                    <option value="" selected="selected">2014</option>
                  </select>
              </label>

              <label>


                <span>Salve Officer:</span>
                <?php foreach ($getSO->result() as $so) { ?>
                
                <select>
                  <option value="<?php $so->controlno; ?>"><?php echo $so->Officer;?></option>
                </select>

                 <?php   } ?>
              </label>

              <label>
                <span></span>
                <input type="submit" class="button" value="Paid"/>
              </label>
          </form> -->


		
        <br>

            <?php if ($userrank =="branchmanager") { ?>
              <form action="forceterminate" method="post" style="margin-left:45px;">
                <input type="text" hidden name="number" value="<?php echo $control_no ?>"/>
                <input type="submit" class="deactivatebtn" value="Terminate Account" />
              </form>
            <?php } ?>

            <br>
 
  </div>
</body>

