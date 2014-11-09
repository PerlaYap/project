<title>MIS Monthly Report</title>

<link rel="stylesheet" type="text/css" href="<?php echo base_url('Assets/css/reports.css'); ?>">


<style type="text/css" media="print">
.dontprint{
	display: none;
}


</style>
	<a href="<?php echo site_url('login/homepage'); ?>"> <img src="<?php echo base_url('Assets/images/caritaslogo.png'); ?>" class="caritaslogo"></a>

<h3>CARITAS SALVE CREDIT COOPERATIVE <br> SAVINGS BUILD-UP and PREFERRED SHARE REPORT  <br> For The Month Of <b>
		<?php echo $monthWord ?> <?php echo $year ?></b></h3>
<?php
$user = $this->session->userdata('firstname');
$datetoday = date('F d, Y');

$getInterest =$this->db->query("SELECT FirstTable.BranchControl, IFNULL(Saving,0)-IFNULL(Withdrawal,0) AS PerMonth, FirstTable.Month, FirstTable.Year FROM 
(SELECT SUM(Amount) AS Saving, BranchControl, Month(DateTime) AS Month, Year(DateTime) AS Year FROM 
(SELECT ControlNo, Amount, Members_ControlNo AS MemberControl, DateTime, TransactionType
FROM Transaction 
WHERE TransactionType='Savings' AND DateTime<=LAST_DAY(DATE_ADD('$date', INTERVAL -1 MONTH)))Alpha
LEFT JOIN
(SELECT MemberControl, BranchControl, DateEntered, DateLeft FROM 
(SELECT CaritasBranch_ControlNo AS BranchControl, Members_ControlNo AS MemberControl, DateEntered, DateLeft 
FROM caritascenters_has_members cchm 
LEFT JOIN caritasbranch_has_caritascenters cbhcc 
ON cbhcc.CaritasCenters_ControlNo=cchm.CaritasCenters_ControlNo)A
LEFT JOIN caritasbranch cb ON A.BranchControl=cb.ControlNo)Beta 
ON (Alpha.MemberControl=Beta.MemberControl AND DateEntered<=DateTime<IFNULL(DateLeft,CURDATE()))
WHERE DateTime<=LAST_DAY(DATE_ADD('$date', INTERVAL -1 MONTH))
GROUP BY Month(DateTime),Year(DateTime),BranchControl) FirstTable
LEFT JOIN
(SELECT SUM(Amount) AS Withdrawal, BranchControl, Month(DateTime) AS Month, Year(DateTime) AS Year FROM 
(SELECT ControlNo, Amount, Members_ControlNo AS MemberControl, DateTime, TransactionType
FROM Transaction 
WHERE TransactionType='Withdrawal' AND DateTime<=LAST_DAY(DATE_ADD('$date', INTERVAL -1 MONTH)))Alpha
LEFT JOIN
(SELECT MemberControl, BranchControl, DateEntered, DateLeft FROM 
(SELECT CaritasBranch_ControlNo AS BranchControl, Members_ControlNo AS MemberControl, DateEntered, DateLeft 
FROM caritascenters_has_members cchm 
LEFT JOIN caritasbranch_has_caritascenters cbhcc 
ON cbhcc.CaritasCenters_ControlNo=cchm.CaritasCenters_ControlNo)A
LEFT JOIN caritasbranch cb ON A.BranchControl=cb.ControlNo)Beta 
ON (Alpha.MemberControl=Beta.MemberControl AND DateEntered<=DateTime<IFNULL(DateLeft,CURDATE()))
WHERE DateTime<=LAST_DAY(DATE_ADD('$date', INTERVAL -1 MONTH))
GROUP BY Month(DateTime),Year(DateTime),BranchControl) SecondTable
ON FirstTable.BranchControl=SecondTable.branchControl
ORDER BY FirstTable.Year ASC, FirstTable.Month ASC ")
?>
<?php 

$getSavings = $this->db->query("SELECT ControlNo, BranchName, IFNULL(BegSavings,0) AS BegSaving, IFNULL(CurrentSaving,0) AS CurrentSaving, IFNULL(Withdrawal,0) AS CurrentWithdrawal, IFNULL(BegSavings,0)+IFNULL(CurrentSaving,0)-IFNULL(Withdrawal,0) AS Total FROM
CaritasBranch cb
LEFT JOIN 
(SELECT SUM(PastCollection) AS BegSavings, BranchControl
FROM (SELECT IFNULL(Saving,0)-IFNULL(Withdraw,0) AS PastCollection, Uno.BranchControl, Uno.Month, Uno.Year
FROM (SELECT SUM(Amount) AS Saving, BranchControl, Month(DateTime) AS Month, Year(DateTime) AS Year FROM 
(SELECT ControlNo, Amount, Members_ControlNo AS MemberControl, DateTime, TransactionType
FROM Transaction 
WHERE TransactionType='Savings' AND DateTime<=LAST_DAY(DATE_ADD('$date', INTERVAL -1 MONTH)))Alpha
LEFT JOIN
(SELECT MemberControl, BranchControl, DateEntered, DateLeft FROM 
(SELECT CaritasBranch_ControlNo AS BranchControl, Members_ControlNo AS MemberControl, DateEntered, DateLeft 
FROM caritascenters_has_members cchm 
LEFT JOIN caritasbranch_has_caritascenters cbhcc 
ON cbhcc.CaritasCenters_ControlNo=cchm.CaritasCenters_ControlNo)A
LEFT JOIN caritasbranch cb ON A.BranchControl=cb.ControlNo)Beta 
ON (Alpha.MemberControl=Beta.MemberControl AND DateEntered<=DateTime<IFNULL(DateLeft,CURDATE()))
WHERE DateTime<=LAST_DAY(DATE_ADD('$date', INTERVAL -1 MONTH))
GROUP BY Month(DateTime),Year(DateTime),BranchControl)UNO
LEFT JOIN(SELECT SUM(Amount) AS Withdraw, BranchControl, Month(DateTime) AS Month, Year(DateTime) AS Year FROM 
(SELECT ControlNo, Amount, Members_ControlNo AS MemberControl, DateTime, TransactionType
FROM Transaction 
WHERE TransactionType='Withdrawal' AND DateTime<=LAST_DAY(DATE_ADD('$date', INTERVAL -1 MONTH)))Alpha
LEFT JOIN
(SELECT MemberControl, BranchControl, DateEntered, DateLeft FROM 
(SELECT CaritasBranch_ControlNo AS BranchControl, Members_ControlNo AS MemberControl, DateEntered, DateLeft 
FROM caritascenters_has_members cchm 
LEFT JOIN caritasbranch_has_caritascenters cbhcc 
ON cbhcc.CaritasCenters_ControlNo=cchm.CaritasCenters_ControlNo)A
LEFT JOIN caritasbranch cb ON A.BranchControl=cb.ControlNo)Beta 
ON (Alpha.MemberControl=Beta.MemberControl AND DateEntered<=DateTime<IFNULL(DateLeft,CURDATE()))
WHERE DateTime<=LAST_DAY(DATE_ADD('$date', INTERVAL -1 MONTH))
GROUP BY Month(DateTime),Year(DateTime),BranchControl) DOS ON (UNO.Month=DOS.Month AND UNO.Year=DOS.Year AND Uno.BranchControl=Dos.BranchControl))Alpha
GROUP BY Alpha.BranchControl)BegBal
ON cb.ControlNo=BegBal.BranchControl
LEFT JOIN
(SELECT SUM(Amount) AS CurrentSaving, BranchControl
FROM (SELECT ControlNo, Amount, Members_ControlNo AS MemberControl, DateTime, TransactionType
FROM Transaction 
WHERE TransactionType='Savings' AND (Month(DateTime)='$month' AND Year(DateTime)='$year'))Alpha
LEFT JOIN
(SELECT MemberControl, BranchControl, DateEntered, DateLeft 
FROM (SELECT CaritasBranch_ControlNo AS BranchControl, Members_ControlNo AS MemberControl, DateEntered, DateLeft 
FROM caritascenters_has_members cchm 
LEFT JOIN caritasbranch_has_caritascenters cbhcc 
ON cbhcc.CaritasCenters_ControlNo=cchm.CaritasCenters_ControlNo)A
LEFT JOIN caritasbranch cb ON A.BranchControl=cb.ControlNo)Beta 
ON (Alpha.MemberControl=Beta.MemberControl AND DateEntered<=DateTime<IFNULL(DateLeft,CURDATE()))
WHERE (Month(DateTime)='$month' AND Year(DateTime)='$year')
GROUP BY BranchControl)CurSaving ON CurSaving.BranchControl=cb.ControlNo
LEFT JOIN
(SELECT SUM(Amount) AS Withdrawal, BranchControl
FROM (SELECT ControlNo, Amount, Members_ControlNo AS MemberControl, DateTime, TransactionType
FROM Transaction 
WHERE TransactionType='Withdrawal' AND (Month(DateTime)='$month' AND Year(DateTime)='$year'))Alpha
LEFT JOIN
(SELECT MemberControl, BranchControl, DateEntered, DateLeft 
FROM (SELECT CaritasBranch_ControlNo AS BranchControl, Members_ControlNo AS MemberControl, DateEntered, DateLeft 
FROM caritascenters_has_members cchm 
LEFT JOIN caritasbranch_has_caritascenters cbhcc 
ON cbhcc.CaritasCenters_ControlNo=cchm.CaritasCenters_ControlNo)A
LEFT JOIN caritasbranch cb ON A.BranchControl=cb.ControlNo)Beta 
ON (Alpha.MemberControl=Beta.MemberControl AND DateEntered<=DateTime<IFNULL(DateLeft,CURDATE()))
WHERE (Month(DateTime)='$month' AND Year(DateTime)='$year')
GROUP BY BranchControl)CurWithdrawal ON CurWithdrawal.BranchControl=cb.ControlNo
WHERE ControlNo!=1 ORDER BY BranchName ASC");
?>
<?php

$getCapital =$this->db->query("SELECT ControlNo, cb.BranchName, IFNULL(BegCapital,0) AS BegCapital, IFNULL(TotalCapital,0) AS TotalCapital, IFNULL(ReturnedCapital,0) AS ReturnedCapital
FROM CaritasBranch cb
LEFT JOIN
(SELECT CapitalShare.BranchControl, CapitalShare.BranchName, (IFNULL(CapitalShare,0)-IFNULL(ReturnCapital,0)) AS BegCapital, IFNULL(TotalCapital,0) AS TotalCapital, IFNULL(ReturnedCapital,0) AS ReturnedCapital
FROM (SELECT BranchControl, BranchName, SUM(Amount) AS CapitalShare FROM
(SELECT Members_ControlNo AS MemberControl, Amount, TransactionType, DateTime 
FROM Transaction WHERE TransactionType='Capital Share' AND DateTime<=LAST_DAY(DATE_ADD('$date', INTERVAL -1 MONTH)))Alpha
LEFT JOIN
(SELECT BranchControl, MemberControl, BranchName 
FROM (SELECT A.CaritasCenters_ControlNo AS CenterControl, cchm.Members_ControlNo AS MemberControl 
FROM caritascenters_has_members cchm
LEFT JOIN(SELECT * FROM caritascenters_has_members cchm WHERE DateEntered<=LAST_DAY(DATE_ADD('$date', INTERVAL -1 MONTH)) ORDER BY DateEntered DESC)A
ON A.Members_ControlNo=cchm.Members_ControlNo 
WHERE cchm.DateLeft IS NULL GROUP BY cchm.Members_ControlNo)Alpha
LEFT JOIN
(SELECT cbhcc.CaritasCenters_ControlNo AS CenterControl, A.CaritasBranch_ControlNo AS BranchControl, BranchName
FROM caritasbranch_has_caritascenters cbhcc
LEFT JOIN (SELECT * 
FROM caritasbranch_has_caritascenters cbhcc WHERE Date<=LAST_DAY(DATE_ADD('$date', INTERVAL -1 MONTH)) ORDER BY Date DESC)A
ON A.CaritasCenters_ControlNo=cbhcc.CaritasCenters_ControlNo
LEFT JOIN CaritasBranch cb ON cb.ControlNo=cbhcc.CaritasBranch_ControlNo
GROUP BY cbhcc.CaritasCenters_ControlNo ORDER BY cbhcc.CaritasCenters_ControlNo ASC)Beta
ON Alpha.CenterControl=Beta.CenterControl) Beta ON Alpha.MemberControl=Beta.MemberControl
GROUP BY BranchControl) CapitalShare
LEFT JOIN 
(SELECT BranchControl, BranchName, SUM(Amount) AS ReturnCapital FROM
(SELECT Members_ControlNo AS MemberControl, Amount, TransactionType, DateTime 
FROM Transaction WHERE TransactionType='Capital Share Return' AND DateTime<=LAST_DAY(DATE_ADD('$date', INTERVAL -1 MONTH)))Alpha
LEFT JOIN
(SELECT BranchControl, MemberControl, BranchName 
FROM (SELECT A.CaritasCenters_ControlNo AS CenterControl, cchm.Members_ControlNo AS MemberControl 
FROM caritascenters_has_members cchm
LEFT JOIN(SELECT * FROM caritascenters_has_members cchm WHERE DateEntered<=LAST_DAY(DATE_ADD('$date', INTERVAL -1 MONTH)) ORDER BY DateEntered DESC)A
ON A.Members_ControlNo=cchm.Members_ControlNo 
WHERE cchm.DateLeft IS NULL GROUP BY cchm.Members_ControlNo)Alpha
LEFT JOIN
(SELECT cbhcc.CaritasCenters_ControlNo AS CenterControl, A.CaritasBranch_ControlNo AS BranchControl, BranchName
FROM caritasbranch_has_caritascenters cbhcc
LEFT JOIN (SELECT * 
FROM caritasbranch_has_caritascenters cbhcc WHERE Date<=LAST_DAY(DATE_ADD('$date', INTERVAL -1 MONTH)) ORDER BY Date DESC)A
ON A.CaritasCenters_ControlNo=cbhcc.CaritasCenters_ControlNo
LEFT JOIN CaritasBranch cb ON cb.ControlNo=cbhcc.CaritasBranch_ControlNo
GROUP BY cbhcc.CaritasCenters_ControlNo ORDER BY cbhcc.CaritasCenters_ControlNo ASC)Beta
ON Alpha.CenterControl=Beta.CenterControl) Beta ON Alpha.MemberControl=Beta.MemberControl
GROUP BY BranchControl)ReturnCapital ON CapitalShare.BranchControl=ReturnCapital.BranchControl
LEFT JOIN
(SELECT BranchControl, BranchName, SUM(IFNULL(Amount,0)) AS TotalCapital FROM 
(SELECT Members_ControlNo, Amount 
FROM Transaction WHERE TransactionType='Capital Share' AND MONTH(DateTime)='$month' AND YEAR(DateTime)='$year')UNO
LEFT JOIN
(SELECT BranchControl, MemberControl, BranchName 
FROM (SELECT A.CaritasCenters_ControlNo AS CenterControl, cchm.Members_ControlNo AS MemberControl 
FROM caritascenters_has_members cchm
LEFT JOIN(SELECT * FROM caritascenters_has_members cchm WHERE DateEntered<='$date' ORDER BY DateEntered DESC)A
ON A.Members_ControlNo=cchm.Members_ControlNo 
WHERE cchm.DateLeft IS NULL GROUP BY cchm.Members_ControlNo)Alpha
LEFT JOIN
(SELECT cbhcc.CaritasCenters_ControlNo AS CenterControl, A.CaritasBranch_ControlNo AS BranchControl, BranchName
FROM caritasbranch_has_caritascenters cbhcc
LEFT JOIN (SELECT * 
FROM caritasbranch_has_caritascenters cbhcc WHERE Date<='$date' ORDER BY Date DESC)A
ON A.CaritasCenters_ControlNo=cbhcc.CaritasCenters_ControlNo
LEFT JOIN CaritasBranch cb ON cb.ControlNo=cbhcc.CaritasBranch_ControlNo
GROUP BY cbhcc.CaritasCenters_ControlNo ORDER BY cbhcc.CaritasCenters_ControlNo ASC)Beta
ON Alpha.CenterControl=Beta.CenterControl)DOS ON UNO.Members_ControlNo=DOS.MemberControl
GROUP BY BranchControl)CollectedCapital ON CapitalShare.BranchControl=CollectedCapital.BranchControl
LEFT JOIN
(SELECT BranchControl, BranchName, SUM(IFNULL(Amount,0)) AS ReturnedCapital FROM 
(SELECT Members_ControlNo, Amount 
FROM Transaction WHERE TransactionType='Capital Share Return' AND MONTH(DateTime)='$month' AND YEAR(DateTime)='$year')UNO
LEFT JOIN
(SELECT BranchControl, MemberControl, BranchName 
FROM (SELECT A.CaritasCenters_ControlNo AS CenterControl, cchm.Members_ControlNo AS MemberControl 
FROM caritascenters_has_members cchm
LEFT JOIN(SELECT * FROM caritascenters_has_members cchm WHERE DateEntered<='$date' ORDER BY DateEntered DESC)A
ON A.Members_ControlNo=cchm.Members_ControlNo 
WHERE cchm.DateLeft IS NULL GROUP BY cchm.Members_ControlNo)Alpha
LEFT JOIN
(SELECT cbhcc.CaritasCenters_ControlNo AS CenterControl, A.CaritasBranch_ControlNo AS BranchControl, BranchName
FROM caritasbranch_has_caritascenters cbhcc
LEFT JOIN (SELECT * 
FROM caritasbranch_has_caritascenters cbhcc WHERE Date<='$date' ORDER BY Date DESC)A
ON A.CaritasCenters_ControlNo=cbhcc.CaritasCenters_ControlNo
LEFT JOIN CaritasBranch cb ON cb.ControlNo=cbhcc.CaritasBranch_ControlNo
GROUP BY cbhcc.CaritasCenters_ControlNo ORDER BY cbhcc.CaritasCenters_ControlNo ASC)Beta
ON Alpha.CenterControl=Beta.CenterControl)DOS ON UNO.Members_ControlNo=DOS.MemberControl
GROUP BY BranchControl)ReturnedCapital ON ReturnedCapital.BranchControl=CapitalShare.BranchControl)Sole
ON cb.ControlNo=Sole.BranchControl WHERE ControlNo!='1' ORDER BY BranchName ASC")
?>
	<br>
	<table class="misreport" border="1"  style="margin-left:auto; margin-right:auto;">
		<tr>
			<td class="label"><b>SAVINGS BUILD-UP</b></td>
			<?php foreach ($getSavings->result() as $data){
			echo '<td class="branch">'.$data->BranchName.'</td>';
			} ?>
		</tr>

		<tr>
			<td class="label1">Beginning</td>
			<?php foreach($getSavings->result() as $data){
				echo '<td class="number1">'.number_format($data->BegSaving,2).'</td>';
			} ?>

		</tr>

		<tr>
			<td class="label1">Beginning SBU Int</td>
			<?php 
				foreach($getSavings->result() as $data){
					$money=0;
					foreach($getInterest->result() as $data2){
						if($data2->BranchControl==$data->ControlNo){
							$money+=($data2->PerMonth);
							$money=$money*1.0042;
						}
					}
					echo '<td class="number1">'.number_format(($money-($data->BegSaving)),2).'</td>';
				}
			?>
		</tr>

		<tr>
			<td class="label1">Savings Collection</td>
			<?php foreach ($getSavings->result() as $data) {
			echo '<td class="number1">'.number_format(($data->CurrentSaving),2).'</td>';
		}?>
		</tr>

		<tr>
			<td class="label1">Savings Collection Int</td>
			<?php 
				foreach($getSavings->result() as $data){
					$money=($data->CurrentSaving)*1.0042;
					echo '<td class="number1">'.number_format(($money-$data->CurrentSaving),2).'</td>';
				}
			?>
		</tr>
		
		<tr>
			<td class="label1">Withdrawal</td>
			<?php foreach( $getSavings->result() as $data){
				echo '<td class="number1">('.number_format($data->CurrentWithdrawal,2).')</td>';
			} ?>
	
		</tr>

		<tr>
			<td class="label"><i><b>Total Savings Mobilized</b></i></td>
			<?php foreach( $getSavings->result() as $data){
				$interest1=0;
				$interest2=0;
				foreach ($getInterest->result() as $data2) {
					if($data->ControlNo==$data2->BranchControl){
						$interest1+=$data2->PerMonth;
						$interest1=$interest1*1.0042;
					}
				}

				$interest1-=$data->BegSaving;

				$interest2=($data->CurrentSaving)*1.0042;
				$interest2-=$data->CurrentSaving;

				echo '<td class="number1"><b>'.number_format(($interest1+$interest2+$data->Total),2).'</b></td>';
			} ?>

		</tr>
	</table>

	
	<br>
	<table class="misreport" border="1"  style="margin-left:auto; margin-right:auto;">
		<tr>
			<td class="label">Preferred Share - Beg</td>
			<?php
				foreach ($getCapital->result() as $data3) {
					echo "<td class='number'>".number_format($data3->BegCapital,2)."</td>";
				}
			?>
		</tr>
		<tr>
			<td class="label">Purchased</td>
			<?php
				foreach ($getCapital->result() as $data3) {
					echo "<td class='number'>".number_format($data3->TotalCapital,2)."</td>";
				}
			?>
	
		</tr>
		<tr>
			<td class="label">Returned</td>
			<?php
				foreach ($getCapital->result() as $data3) {
					echo "<td class='number'>(".number_format($data3->ReturnedCapital,2).")</td>";
				}
			?>
	
		</tr>
		
		<tr>
			<td class="label">Preferred Share - End</td>
			<?php
				foreach ($getCapital->result() as $data3) {
					echo "<td class='number'><b>".number_format(($data3->BegCapital + $data3->TotalCapital - $data3->ReturnedCapital),2)."</b></td>";
				}
			?>
	
		</tr>
	</table>
	<br><br><br>
		<table class="signature" style="margin-left:auto; margin-right:auto;">
			<tr>
				<td class="sigBy">Prepared by:</td>
				<td class="sig">&nbsp<?php echo $user; ?></td>
				<td class="sigBy"> &nbsp&nbsp&nbspDate:</td>
				<td class="sig2">&nbsp<?php echo $datetoday; ?></td>
			</tr>
		</table>
		<br>
		<table class="signature"  style="margin-left:auto; margin-right:auto;">
			<tr>
				<td class="sigBy">Received by:</td>
				<td class="sig">&nbsp</td>
				<td class="sigBy"> &nbsp&nbsp&nbspDate:</td>
				<td class="sig2">&nbsp</td>
			</tr>
		</table>
	<br><br>
	<div class="dontprint" style="width: 100%; text-align: center;">
		<button onclick="window.print()">Print</button> 
	</div>