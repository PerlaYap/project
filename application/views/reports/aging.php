<style type="text/css" media="print">
  .dontprint{
    display: none;
  }

  @page { 
    size: portrait;
    margin: 1 in;
  }
</style>	

<?php
date_default_timezone_set('Asia/Manila');
$branchno=$this->session->userdata('branchno');
$user = $this->session->userdata('firstname');
$datetoday = date('F d, Y');
$name = $this->session->userdata('firstname');
$userrank = $this->session->userdata('rank');


$branchName=$this->db->query("SELECT BranchName FROM CaritasBranch WHERE ControlNo='$branchno'");
foreach($branchName->result() AS $branch){
	$branchname=$branch->BranchName;
}

if($userrank=='mispersonnel'){
$pastDue=$this->db->query("SELECT BranchName, Name, CenterNo, WeeklyPayment, TotalPastDue, DaysPast, Address, ContactNo FROM (SELECT ControlNo, WeeklyPayment, DateReleased, DateEnd, 
IF(ROUND(TRUNCATE(DATEDIFF(NOW(),DateReleased)/7,0)*WeeklyPayment,2)>IFNULL(Amount,0), IF(ROUND(TRUNCATE(DATEDIFF(NOW(),DateReleased)/7,0)*WeeklyPayment,2)<TotalRelease,ROUND(TRUNCATE(DATEDIFF(NOW(),DateReleased)/7,0)*WeeklyPayment,2), TotalRelease)-IFNULL(Amount,0), 0) AS TotalPastDue,
IF(ROUND(TRUNCATE(DATEDIFF(NOW(),DateReleased)/7,0)*WeeklyPayment,2)>IFNULL(Amount,0), TRUNCATE(DATEDIFF(NOW(),IFNULL(MaxDate,DateReleased))/7,0),0) AS DaysPast
FROM (SELECT ControlNo, IF(LoanType='23-Weeks',(AmountRequested+Interest)/23, (AmountRequested+Interest)/40) AS WeeklyPayment, LoanType, DateReleased,
DATE_ADD((IF(LoanType='23-Weeks', DATE_ADD(DateReleased, INTERVAL 161 DAY), DATE_ADD(DateReleased,INTERVAL 280 DAY))), INTERVAL 0 MONTH) AS DateEnd, (AmountRequested+Interest) AS TotalRelease
FROM loanapplication
WHERE (Status='Current' OR Status='Full Payment') AND
(CAST(DATE_FORMAT(NOW() ,CONCAT(YEAR(DateReleased),'-',MONTH(DateReleased),'-01')) as DATE)<=NOW()
AND NOW()<=LAST_DAY(DATE_ADD((IF(LoanType='23-Weeks', DATE_ADD(DateReleased, INTERVAL 161 DAY), DATE_ADD(DateReleased,INTERVAL 280 DAY))), INTERVAL 0 MONTH))))Alpha
LEFT JOIN (SELECT LoanAppControlNo, SUM(AMOUNT) AS Amount, MAX(DateTime) AS MaxDate FROM Transaction WHERE TransactionType='Loan' GROUP BY LoanAppControlNo)Beta
ON Alpha.ControlNo=Beta.LoanAppControlNo)Alpha
LEFT JOIN 
(SELECT BranchName, loanapplication_ControlNo AS LoanControl, CenterControl,CONCAT(LastName,', ',FirstName,' ',MiddleName) AS Name, Address, ContactNo, CaritasBranch_ControlNo
FROM loanapplication_has_members lhm
LEFT JOIN Members mem ON lhm.Members_ControlNo=mem.ControlNo
LEFT JOIN membersname mn ON mn.ControlNo=lhm.Members_ControlNo
LEFT JOIN membersaddress ma ON ma.ControlNo=lhm.Members_ControlNo
LEFT JOIN memberscontact mc ON mc.ControlNo=lhm.Members_ControlNo
LEFT JOIN (SELECT A.Members_ControlNo AS MembersControl, CaritasCenters_ControlNo AS CenterControl FROM (SELECT Members_ControlNo FROM caritascenters_has_members GROUP BY Members_ControlNo)A
LEFT JOIN (SELECT * FROM (SELECT * FROM CaritasCenters_has_Members ORDER BY Members_ControlNo ASC, DateEntered DESC)A GROUP BY Members_ControlNo)B
ON A.Members_ControlNo=B.Members_ControlNo) cchm ON cchm.MembersControl=lhm.Members_ControlNo
LEFT JOIN CaritasBranch cb ON cb.ControlNo=lhm.CaritasBranch_ControlNo)Beta
ON Beta.LoanControl=Alpha.ControlNo
LEFT JOIN CaritasCenters cc ON cc.ControlNo=Beta.CenterControl
WHERE TotalPastDue>0 ORDER BY Name ASC");
}
else{
$pastDue=$this->db->query("SELECT BranchName, Name, CenterNo, WeeklyPayment, TotalPastDue, DaysPast, Address, ContactNo FROM (SELECT ControlNo, WeeklyPayment, DateReleased, DateEnd, 
IF(ROUND(TRUNCATE(DATEDIFF(NOW(),DateReleased)/7,0)*WeeklyPayment,2)>IFNULL(Amount,0), IF(ROUND(TRUNCATE(DATEDIFF(NOW(),DateReleased)/7,0)*WeeklyPayment,2)<TotalRelease,ROUND(TRUNCATE(DATEDIFF(NOW(),DateReleased)/7,0)*WeeklyPayment,2), TotalRelease)-IFNULL(Amount,0), 0) AS TotalPastDue,
IF(ROUND(TRUNCATE(DATEDIFF(NOW(),DateReleased)/7,0)*WeeklyPayment,2)>IFNULL(Amount,0), TRUNCATE(DATEDIFF(NOW(),IFNULL(MaxDate,DateReleased))/7,0),0) AS DaysPast
FROM (SELECT ControlNo, IF(LoanType='23-Weeks',(AmountRequested+Interest)/23, (AmountRequested+Interest)/40) AS WeeklyPayment, LoanType, DateReleased,
DATE_ADD((IF(LoanType='23-Weeks', DATE_ADD(DateReleased, INTERVAL 161 DAY), DATE_ADD(DateReleased,INTERVAL 280 DAY))), INTERVAL 0 MONTH) AS DateEnd, (AmountRequested+Interest) AS TotalRelease
FROM loanapplication
WHERE (Status='Current' OR Status='Full Payment') AND
(CAST(DATE_FORMAT(NOW() ,CONCAT(YEAR(DateReleased),'-',MONTH(DateReleased),'-01')) as DATE)<=NOW()
AND NOW()<=LAST_DAY(DATE_ADD((IF(LoanType='23-Weeks', DATE_ADD(DateReleased, INTERVAL 161 DAY), DATE_ADD(DateReleased,INTERVAL 280 DAY))), INTERVAL 0 MONTH))))Alpha
LEFT JOIN (SELECT LoanAppControlNo, SUM(AMOUNT) AS Amount, MAX(DateTime) AS MaxDate FROM Transaction WHERE TransactionType='Loan' GROUP BY LoanAppControlNo)Beta
ON Alpha.ControlNo=Beta.LoanAppControlNo)Alpha
LEFT JOIN 
(SELECT BranchName, loanapplication_ControlNo AS LoanControl, CenterControl,CONCAT(LastName,', ',FirstName,' ',MiddleName) AS Name, Address, ContactNo, CaritasBranch_ControlNo
FROM loanapplication_has_members lhm
LEFT JOIN Members mem ON lhm.Members_ControlNo=mem.ControlNo
LEFT JOIN membersname mn ON mn.ControlNo=lhm.Members_ControlNo
LEFT JOIN membersaddress ma ON ma.ControlNo=lhm.Members_ControlNo
LEFT JOIN memberscontact mc ON mc.ControlNo=lhm.Members_ControlNo
LEFT JOIN (SELECT A.Members_ControlNo AS MembersControl, CaritasCenters_ControlNo AS CenterControl FROM (SELECT Members_ControlNo FROM caritascenters_has_members GROUP BY Members_ControlNo)A
LEFT JOIN (SELECT * FROM (SELECT * FROM CaritasCenters_has_Members ORDER BY Members_ControlNo ASC, DateEntered DESC)A GROUP BY Members_ControlNo)B
ON A.Members_ControlNo=B.Members_ControlNo) cchm ON cchm.MembersControl=lhm.Members_ControlNo
LEFT JOIN CaritasBranch cb ON cb.ControlNo=lhm.CaritasBranch_ControlNo)Beta
ON Beta.LoanControl=Alpha.ControlNo
LEFT JOIN CaritasCenters cc ON cc.ControlNo=Beta.CenterControl
WHERE CaritasBranch_ControlNo='$branchno' AND TotalPastDue>0 ORDER BY Name ASC");
}
?>

<title>Past Due Matured Accounts</title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('Assets/css/reports.css'); ?>"> 



	<a href="<?php echo site_url('login/homepage'); ?>"> <img src="<?php echo base_url('Assets/images/caritaslogo.png'); ?>" class="caritaslogo"></a>
	
	<h3>
		CARITAS SALVE CREDIT COOPERATIVE <br> 
		Aging Report 
		<?php 	if($userrank!='mispersonnel'){
					echo "of ".$branchname." Branch" ?><br>
				<?php } ?>
		As of <?php echo $datetoday ?>
	</h3>
	<br>


	<table border="1" style="border-collapse: collapse; margin-left: auto; margin-right: auto;">
		<tr>
			<td class="pastdue" width="10px"><b>#</b></td>
			<td class="pastdue" width="200px" style="text-align: left;"><b>NAME</b></td>
			<?php if($userrank=='mispersonnel'){?>
			<td class="pastdue" width="20px"><b>BRANCH</b></td>
			<td class="pastdue" width="10px"><b>CENTER NO</b></td>
			<?php }else{ ?>
			<td class="pastdue" width="10px"><b>CENTER NO</b></td>
			<?php } ?>
			<td class="pastdue" width="120px"><b>WEEKLY PAYMENT</b></td>
			<td class="pastdue" width="120px"><b>WEEKS PAST DUE</b></td>
			<td class="pastdue" width="120px"><b>TOTAL PAST DUE</b></td>
			<td class="pastdue" width="150px;"><b>CONTACT NO.</b></td>
			<td class="pastdue" width="300px;"><b>ADDRESS</b></td>
		</tr>
		<?php 
		$a=1;
		foreach($pastDue->result() AS $data){ ?>
		<tr>
			<td class="pastdue"><?php echo $a ?></td>
			<td class="pastdue" style="text-align: left;"><?php echo $data->Name ?></td>
			<?php if($userrank=='mispersonnel'){?>
		
			<td class="pastdue"><?php echo $data->BranchName ?></td>
			<td class="pastdue"><?php echo $data->CenterNo ?></td>
			<?php }else{ ?>
			<td class="pastdue"><?php echo $data->CenterNo ?></td>
			<?php } ?>
			<td class="pastdue"><?php echo number_format($data->WeeklyPayment,2) ?></td>
			<td class="pastdue"><?php echo $data->DaysPast ?></td>
			<td class="pastdue"><?php echo number_format($data->TotalPastDue,2) ?></td>
			<td class="pastdue"><?php echo $data->ContactNo ?></td>
			<td class="pastdue"><?php echo $data->Address ?></td>
		</tr>
		<?php $a++; } ?>		
	</table>

	<br><br>
	<br><br>
	<br><br>
<!--	<table style="margin-left: 270px;" >

			<tr>
				<td class="BM1" style="font-size: 13px;"><?php echo $user ?></td>
			</tr>
			<tr>
				<td class="BM2">Signature Above Printed Name of POSITION</td>
			</tr>
			
			<tr>
				<td class="BM1" style="font-size: 13px;"><?php echo $datetoday ?></td>
			</tr>
			<tr>
				
				<td class="BM2">Date</td>
			</tr>
		</table>

	<table style="margin-left: 720px; margin-top: -207px;" >
			
			<tr>
				<td class="BM1" style="font-size: 13px;"></td>
			</tr>
			<tr>
				<td class="BM2">Signature Above Printed Name of POSITION</td>
			</tr>
			
			<tr>
				<td class="BM1" style="font-size: 13px;"><?php echo $datetoday ?></td>
			</tr>
			<tr>
				<td class="BM2">Date</td>
			</tr>
		</table> -->

		  <table style="margin-left: 270px;" >
        <tr>
          <td class="BM1" style="font-size: 13px;"><?php echo $name; ?></td>
        </tr>
          <?php if($userrank=='branchmanager'){?>
        <tr>
          <td class="BM2">Signature Above Printed Name of <br> Branch Manager</td>
        </tr>
        <?php }else{ ?>
        <tr>
          <td class="BM2">Signature Above Printed Name of <br> MIS</td>
        </tr>
        <?php } ?>
        <tr>
          <td class="BM1" style="font-size: 13px;"><?php echo $datetoday ?></td>
        </tr>
        <tr>
          
          <td class="BM2">Date</td>
        </tr>
      </table>

      <table style="margin-left: 720px; margin-top: -207px;" >
        <tr>
          <td class="BM1" style="font-size: 13px;">Ann Evan Echavez</td>
        </tr>
        <tr>
          <td class="BM2">Signature Above Printed Name of <br> General Manager</td>
        </tr>
        <tr>
          <td class="BM1" style="font-size: 13px;"><?php echo $datetoday ?></td>
        </tr>
        <tr>
          <td class="BM2">Date</td>
        </tr>
      </table>
    <br>


		<br><br><br>
			<div class='dontprint' style="width: 100%; text-align: center;">
				<button onclick="window.print()">Print</button>
			</div>

		<br><br><br>

	