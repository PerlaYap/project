<style type="text/css" media="print">
.dontprint{
	display: none;
	}
@page { 
    size: portrait;
    margin: 0.5in;
  }
</style>

<style type="text/css">
	table{
		border-collapse: collapse;
	}

	.header{
		padding: 10px;
		font-weight: bold;
		font-size: 12px;
		color: black;
		text-align: center;
		width: 100px;
	}

	.data{
		padding: 10px;
		font-size: 12px;
		color: black;
		text-align: center;
	}

.BM2{
	border-top-style: solid;
	border-top-width: 1px;
	border-top-color: black;
	height: 50px;
	width: 270px;
	vertical-align: text-top;
	color: black;
	text-align: center;
	padding:0;
}

.BM1{
	font-weight: bold;
	height: 50px;
	width: 270px;
	color:black;
	vertical-align: bottom;
	text-align: center;
}

</style>



<?php

$userrank = $this->session->userdata('rank');
	$branchno = $this->session->userdata('branchno');
	$name = $this->session->userdata('firstname');
	$branchno = $this->session->userdata('branchno');
$getManager=$this->db->query("SELECT CONCAT(`FirstName`,' ',  `MiddleName`,' ', `LastName`) AS NAME FROM CaritasPersonnel CL 
											JOIN CARITASBRANCH_HAS_CARITASPERSONNEL BP ON CL.CONTROLNO = BP.CARITASPERSONNEL_ControlNo
											JOIN CARITASBRANCH B ON BP.CARITASBRANCH_CONTROLNO = B.CONTROLNO
											
														WHERE CL.RANK = 'BRANCHMANAGER' 
														AND B.ControlNo = $branchno ");
	foreach ($getManager->result() as $row){ 
		$Manager=$row->NAME;
	}
	 $datetoday = date('F d, Y');
$day = date('l');
$currentmonth = strtoupper(date("F"));
$currentyear = date('Y');

$collection=$this->db->query("SELECT CenterNo, SUM(Target) AS Target, SUM(IF(CurrentAmount<Target, CurrentAmount, Target)) AS ActualReceive, SUM(IF(Collection-Target-LastAmount<0, 0, IF(CurrentAmount<=Target,0, IF(CurrentAmount>=Collection-LastAmount, Collection-Target-LastAmount, CurrentAmount-Target)))) AS PastDue,
SUM(IF(CurrentAmount+LastAmount<Collection,0, CurrentAmount+LastAmount-Collection)) AS Advance  FROM
(SELECT CurrentTotal.ControlNo, TRUNCATE(WeeklyPayment*TodayMonth,2) AS Collection, MonthlyPayment AS Target, TRUNCATE(IFNULL(LastAmount,0),2) AS LastAmount,
TRUNCATE(IFNULL(CurrentAmount,0),2) AS CurrentAmount
FROM (SELECT ControlNo, WeeklyPayment, IF(LoanType='23-Weeks',IF(TRUNCATE(DATEDIFF(LAST_DAY(DATE_ADD(NOW(), INTERVAL 0 MONTH)),DateReleased)/7,0)>23,23,TRUNCATE(DATEDIFF(LAST_DAY(DATE_ADD(NOW(), INTERVAL 0 MONTH)),DateReleased)/7,0)), IF(TRUNCATE(DATEDIFF(LAST_DAY(DATE_ADD(NOW(), INTERVAL 0 MONTH)),DateReleased)/7,0)>40,40,TRUNCATE(DATEDIFF(LAST_DAY(DATE_ADD(NOW(), INTERVAL 0 MONTH)),DateReleased)/7,0))) AS TodayMonth
FROM (SELECT ControlNo, DateReleased, DateEnd, LoanType, WeeklyPayment, 
ROUND(((TRUNCATE(DATEDIFF(LAST_DAY(DATE_ADD(NOW(), INTERVAL 0 MONTH)),DateReleased)/7,0)-TRUNCATE((IF(Month(DateEnd)=Month(NOW()) AND YEAR(DateEnd)=YEAR(NOW()),DATEDIFF(DateEnd,DateReleased)/7,DATEDIFF(LAST_DAY(DATE_ADD(NOW(), INTERVAL -1 MONTH)),DateReleased)/7)),0))* WeeklyPayment),2) AS MonthlyPayment
FROM 
(SELECT (AmountRequested+Interest) AS ActiveLoan, ControlNo, IF(LoanType='23-Weeks',(AmountRequested+Interest)/23, (AmountRequested+Interest)/40) AS WeeklyPayment, LoanType, DateReleased, 
DATE_ADD((IF(LoanType='23-Weeks', DATE_ADD(DateReleased, INTERVAL 161 DAY), DATE_ADD(DateReleased,INTERVAL 280 DAY))), INTERVAL 0 MONTH) AS DateEnd
FROM loanapplication 
WHERE (Status='Current' OR Status='Full Payment') AND 
(CAST(DATE_FORMAT(NOW() ,CONCAT(YEAR(DateReleased),'-',MONTH(DateReleased),'-01')) as DATE)<=NOW() 
AND NOW()<=LAST_DAY(DATE_ADD((IF(LoanType='23-Weeks', DATE_ADD(DateReleased, INTERVAL 161 DAY), DATE_ADD(DateReleased,INTERVAL 280 DAY))), INTERVAL 0 MONTH))))Alpha)Alpha)CurrentTotal
LEFT JOIN
(SELECT ControlNo,
ROUND(((TRUNCATE(DATEDIFF(LAST_DAY(DATE_ADD(NOW(), INTERVAL 0 MONTH)),DateReleased)/7,0)-TRUNCATE((IF(Month(DateEnd)=Month(NOW()) AND YEAR(DateEnd)=YEAR(NOW()),DATEDIFF(DateEnd,DateReleased)/7,DATEDIFF(LAST_DAY(DATE_ADD(NOW(), INTERVAL -1 MONTH)),DateReleased)/7)),0))* WeeklyPayment),2) AS MonthlyPayment
FROM 
(SELECT ControlNo, IF(LoanType='23-Weeks',(AmountRequested+Interest)/23, (AmountRequested+Interest)/40) AS WeeklyPayment, LoanType, DateReleased, 
DATE_ADD((IF(LoanType='23-Weeks', DATE_ADD(DateReleased, INTERVAL 161 DAY), DATE_ADD(DateReleased,INTERVAL 280 DAY))), INTERVAL 0 MONTH) AS DateEnd
FROM loanapplication 
WHERE (Status='Current' OR Status='Full Payment') AND 
(CAST(DATE_FORMAT(NOW() ,CONCAT(YEAR(DateReleased),'-',MONTH(DateReleased),'-01')) as DATE)<=NOW() 
AND NOW()<=LAST_DAY(DATE_ADD((IF(LoanType='23-Weeks', DATE_ADD(DateReleased, INTERVAL 161 DAY), DATE_ADD(DateReleased,INTERVAL 280 DAY))), INTERVAL 0 MONTH))))Alpha)TargetCollection
ON CurrentTotal.ControlNo=TargetCollection.ControlNo
LEFT JOIN
(SELECT LoanAppControlNo, SUM(Amount) AS LastAmount FROM Transaction 
WHERE TransactionType='Loan' AND DateTime<=LAST_DAY(DATE_ADD(NOW(), INTERVAL -1 MONTH)) GROUP BY LoanAppControlNo)LastCollection
ON CurrentTotal.ControlNo=LastCollection.LoanAppControlNo
LEFT JOIN 
(SELECT LoanAppControlNo, SUM(Amount) AS CurrentAmount FROM Transaction 
WHERE TransactionType='Loan' AND MONTH(DateTime)=MONTH(NOW()) AND YEAR(DateTime)=YEAR(NOW())
GROUP BY LoanAppControlNo)CurrentCollection
ON CurrentTotal.ControlNo=CurrentCollection.LoanAppControlNo)Alpha
LEFT JOIN (SELECT LoanApplication_ControlNo AS LoanControl, CaritasBranch_ControlNo AS BranchControl, CenterNo FROM loanapplication_has_members lhm
LEFT JOIN
(SELECT A.Members_ControlNo, CenterNo FROM (SELECT Members_ControlNo FROM caritascenters_has_members GROUP BY Members_ControlNo)A
LEFT JOIN (SELECT * FROM (SELECT * FROM caritascenters_has_members ORDER BY Members_ControlNo ASC, DateEntered DESC)A GROUP BY Members_ControlNo)B
ON A.Members_ControlNo=B.Members_ControlNo
LEFT JOIN caritascenters cc ON B.CaritasCenters_ControlNo=cc.ControlNo)cc
ON lhm.Members_ControlNo=cc.Members_ControlNo)Beta
ON Alpha.ControlNo=Beta.LoanControl WHERE BranchControl='$branchno' GROUP BY CenterNo");
?>


<style type="text/css">
	img.caritaslogo{
		display: block;
		margin-left: auto;
		margin-right: auto;
		width: 170px;
		height: auto;
	}

	h3{
		text-align: center;
		font-size: 14px;
		margin-left:auto;
		margin-right:auto; 
		margin-top: -3px;
		font-family: Times New Roman;
		line-height: 15px;
	}	
</style>


		<a href="<?php echo site_url('login/homepage'); ?>" > 
			<img src="<?php echo base_url('Assets/images/caritaslogo.png'); ?>"  class="caritaslogo" >
		</a>
		
		<h3>
			CARITAS SALVE CREDIT COOPERATIVE <br>
			Comparison of Center Collection Performance <br>
			As of <?php echo date('F d, Y'); ?>

		</h3>


<br>


<table border=1 style="margin-left:auto; margin-right:auto;">
	<tr>
		<td class="header" style="width: 150px;"> Center </td>
		<td class="header"> Target </td>
		<td class="header"> On-Time </td>
		<td class="header"> Past Due </td>
		<td class="header"> Advance </td>
	</tr>

	<?php
	foreach($collection->result() AS $data){ ?>
	<tr>
		<td class="data"><?php echo $data->CenterNo ?></td>
		<td class="data"><?php echo number_format($data->Target,2) ?></td>
		<td class="data"><?php echo number_format($data->ActualReceive,2) ?></td>
		<td class="data"><?php echo number_format($data->PastDue,2) ?></td>
		<td class="data"><?php echo number_format($data->Advance,2) ?></td>

	</tr>

	<?php } ?>
</table>

<br>
<br>
<br>
<table style="margin-left: 50px;" >
			<tr>
				<td class="BM1" style="font-size: 13px;"><?php echo $name; ?></td>
			</tr>
				<?php if($userrank=='branchmanager'){?>
			<tr>
				<td class="BM2">Signature Above Printed Name of <BR> Branch Manager</td>
			</tr>
			<?php }else{ ?>
			<tr>
				<td class="BM2">Signature Above Printed Name of <BR> Salve Officer</td>
			</tr>
			<?php } ?>
			<tr>
				<td class="BM1" style="font-size: 13px;"><?php echo $datetoday ?></td>
			</tr>
			<tr>
				
				<td class="BM2">Date</td>
			</tr>
		</table>

	<table style="margin-left: 380px; margin-top: -200px;" >
			
			<?php if($userrank=='branchmanager'){?>
			<tr>
				<td  class="BM1" style="font-size: 13px;">Marvin Lao</td>
			</tr>
			<tr>
				<td class="BM2">Signature Above Printed Name of <BR> MIS</td>
			</tr>
			<?php }else{ ?>
			<tr>
				<td class="BM1" style="font-size: 13px;"><?php echo $Manager ?></td>
			</tr>
			<tr>
				<td class="BM2">Signature Above Printed Name of <BR> Branch Manager</td>
			</tr>
			<?php } ?>
			<tr>
				<td class="BM1" style="font-size: 13px;"><?php echo $datetoday ?></td>
			</tr>
			<tr>
				<td class="BM2">Date</td>
			</tr>
		</table>


<div class='dontprint' style="width: 100%; text-align: center;">
	<button onclick="window.print()">Print</button> 
</div>