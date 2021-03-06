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


</style>



	<?php
	$branchno = $this->session->userdata('branchno');
	
	$targetactual = $this->db->query("SELECT BigOne.CenterControl, CenterNo, Target, Actual FROM 
		(SELECT CenterControl, CenterNo, IFNULL(SUM(MonthlyPayment),0) AS Target FROM (SELECT MemberControl, Alpha.CenterControl, BranchControl, CenterNo FROM (SELECT A.Members_ControlNo AS MemberControl, CaritasCenters_ControlNo AS CenterControl FROM (SELECT Members_ControlNo FROM caritascenters_has_members GROUP BY Members_ControlNo ORDER BY Members_ControlNo ASC)A
			LEFT JOIN (SELECT * FROM (SELECT * FROM caritascenters_has_members WHERE DateEntered<LAST_DAY(DATE_ADD(NOW(), INTERVAL 0 MONTH)) ORDER BY Members_ControlNo ASC, DateEntered DESC)A GROUP BY Members_ControlNo)B
			ON A.Members_ControlNo=B.Members_ControlNo)Alpha
LEFT JOIN
(SELECT A.CaritasCenters_ControlNo AS CenterControl, B.CaritasBranch_ControlNo AS BranchControl FROM (SELECT CaritasCenters_ControlNo FROM caritasbranch_has_caritascenters GROUP BY CaritasCenters_ControlNo)A
	LEFT JOIN (SELECT * FROM (SELECT * FROM caritasbranch_has_caritascenters WHERE Date<LAST_DAY(DATE_ADD(NOW(), INTERVAL 0 MONTH)) ORDER BY CaritasCenters_ControlNo ASC, Date DESC)A GROUP BY CaritasCenters_ControlNo)B
	ON A.CaritasCenters_ControlNo=B.CaritasCenters_ControlNo)Beta
ON Alpha.CenterControl=Beta.CenterControl
LEFT JOIN CaritasCenters cc ON cc.ControlNo=Alpha.CenterControl)Alpha
LEFT JOIN
(SELECT ControlNo, DateReleased, DateEnd,
	ROUND(((TRUNCATE(DATEDIFF(LAST_DAY(DATE_ADD(NOW(), INTERVAL 0 MONTH)),DateReleased)/7,0)-TRUNCATE((IF(Month(DateEnd)=Month(NOW()) AND YEAR(DateEnd)=YEAR(NOW()),DATEDIFF(DateEnd,DateReleased)/7,DATEDIFF(LAST_DAY(DATE_ADD(NOW(), INTERVAL -1 MONTH)),DateReleased)/7)),0))* WeeklyPayment),2) AS MonthlyPayment,
	Members_ControlNo
	FROM 
	(SELECT ControlNo, IF(LoanType='23-Weeks',(AmountRequested+Interest)/23, (AmountRequested+Interest)/40) AS WeeklyPayment, LoanType, DateReleased, 
		DATE_ADD((IF(LoanType='23-Weeks', DATE_ADD(DateReleased, INTERVAL 161 DAY), DATE_ADD(DateReleased,INTERVAL 280 DAY))), INTERVAL 0 MONTH) AS DateEnd
		FROM loanapplication 
		WHERE (Status='Current' OR Status='Full Payment') AND 
		(CAST(DATE_FORMAT(NOW() ,CONCAT(YEAR(DateReleased),'-',MONTH(DateReleased),'-01')) as DATE)<=NOW() 
			AND NOW()<=LAST_DAY(DATE_ADD((IF(LoanType='23-Weeks', DATE_ADD(DateReleased, INTERVAL 161 DAY), DATE_ADD(DateReleased,INTERVAL 280 DAY))), INTERVAL 0 MONTH))))Alpha
LEFT JOIN loanapplication_has_members lhm ON lhm.LoanApplication_ControlNo=Alpha.ControlNo)Beta
ON Alpha.MemberControl=Beta.Members_ControlNo
WHERE BranchControl='$branchno' GROUP BY CenterControl)BigOne
LEFT JOIN
(SELECT CenterControl, IFNULL(SUM(Amount),0) AS Actual FROM (SELECT MemberControl, Alpha.CenterControl, BranchControl FROM (SELECT A.Members_ControlNo AS MemberControl, CaritasCenters_ControlNo AS CenterControl FROM (SELECT Members_ControlNo FROM caritascenters_has_members GROUP BY Members_ControlNo ORDER BY Members_ControlNo ASC)A
	LEFT JOIN (SELECT * FROM (SELECT * FROM caritascenters_has_members WHERE DateEntered<LAST_DAY(DATE_ADD(NOW(), INTERVAL 0 MONTH)) ORDER BY Members_ControlNo ASC, DateEntered DESC)A GROUP BY Members_ControlNo)B
	ON A.Members_ControlNo=B.Members_ControlNo)Alpha
LEFT JOIN
(SELECT A.CaritasCenters_ControlNo AS CenterControl, B.CaritasBranch_ControlNo AS BranchControl FROM (SELECT CaritasCenters_ControlNo FROM caritasbranch_has_caritascenters GROUP BY CaritasCenters_ControlNo)A
	LEFT JOIN (SELECT * FROM (SELECT * FROM caritasbranch_has_caritascenters WHERE Date<LAST_DAY(DATE_ADD(NOW(), INTERVAL 0 MONTH)) ORDER BY CaritasCenters_ControlNo ASC, Date DESC)A GROUP BY CaritasCenters_ControlNo)B
	ON A.CaritasCenters_ControlNo=B.CaritasCenters_ControlNo)Beta
ON Alpha.CenterControl=Beta.CenterControl
LEFT JOIN CaritasCenters cc ON cc.ControlNo=Alpha.CenterControl)Alpha
LEFT JOIN
(SELECT Members_ControlNo AS MemberControl, SUM(Amount) AS Amount 
	FROM Transaction WHERE (TransactionType='Loan' OR TransactionType='Past Due') 
	AND (MONTH(DateTime)=MONTH(NOW()) AND YEAR(DateTime)=YEAR(NOW())) GROUP BY Members_ControlNo)Beta
ON Alpha.MemberControl=Beta.MemberControl WHERE BranchControl='$branchno' GROUP BY CenterControl)BigTwo
ON BigOne.CenterControl=BigTwo.CenterControl");
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
			Comparison of Center Performance
		</h3>


<br>


<table border=1 style="margin-left:auto; margin-right:auto;">
	<tr>
		<td class="header" style="width: 150px;"> Center </td>
		<td class="header"> Target </td>
		<td class="header"> Actual </td>
	</tr>

	<?php
	foreach($targetactual->result() AS $data){ ?>
	<tr>
		<td class="data"><?php echo $data->CenterNo ?></td>
		<td class="data"><?php echo $data->Target ?></td>
		<td class="data"><?php echo $data->Actual ?></td>

	</tr>

	<?php } ?>
</table>

<br>
<br>
<br>

<div class='dontprint' style="width: 100%; text-align: center;">
	<button onclick="window.print()">Print</button> 
</div>