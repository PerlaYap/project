title>MIS Monthly Report</title>

<link rel="stylesheet" type="text/css" href="<?php echo base_url('Assets/css/reports.css'); ?>">
	
	<?php //$month = $_POST['month'];
			//$year = $_POST['year'];

			$month = 8;
			$year = 2014;

			$prev = $year-1;
			$prev2 = $year-2;

			if ($month == 1){
				$yue = 'January';
				$month=13;
				$year=-1;
			} else if ($month == 2){
				$yue = 'February';
			} else if ($month == 3){
				$yue = 'March';
			} else if ($month == 4){
				$yue = 'April';
			} else if ($month == 5){
				$yue = 'May';
			} else if ($month == 6){
				$yue = 'June';
			} else if ($month == 7){
				$yue = 'July';
			} else if ($month == 8){
				$yue = 'August';
			} else if ($month == 9){
				$yue = 'September';
			} else if ($month == 10){
				$yue = 'October';
			} else if ($month == 11){
				$yue = 'November';
			} else{
				$yue = 'December';
			}


$getbranch = $this->db->query("SELECT b.branchname, b.ControlNo FROM caritasbranch b
	Order by b.branchname"); ?>
	<a href="<?php echo site_url('login/homepage'); ?>"> <img src="<?php echo base_url('Assets/images/caritaslogo.png'); ?>" class="caritaslogo"></a>
	
	<!-- <img src="<?php // echo base_url ('Assets/images/caritaslogo.png'); ?>" class="caritaslogo"> -->
	<h3>CARITAS SALVE CREDIT COOPERATIVE <br> MIS REPORT <br> For The Month Of <b>
		<?php echo $yue ?> <?php echo $year ?></b></h3>
<?php

$getInterest =$this->db->query("SELECT FirstTable.BranchControl, Saving-Withdrawal AS PerMonth, FirstTable.Month, FirstTable.Year FROM 
(SELECT SUM(Amount) AS Saving, BranchControl, Month(DateTime) AS Month, Year(DateTime) AS Year FROM 
(SELECT ControlNo, Amount, Members_ControlNo AS MemberControl, DateTime, TransactionType
FROM Transaction 
WHERE TransactionType='Savings' AND (Month(DateTime)<'$month' AND Year(DateTime)<='$year'))Alpha
LEFT JOIN
(SELECT MemberControl, BranchControl, DateEntered, DateLeft FROM 
(SELECT CaritasBranch_ControlNo AS BranchControl, Members_ControlNo AS MemberControl, DateEntered, DateLeft 
FROM caritascenters_has_members cchm 
LEFT JOIN caritasbranch_has_caritascenters cbhcc 
ON cbhcc.CaritasCenters_ControlNo=cchm.CaritasCenters_ControlNo)A
LEFT JOIN caritasbranch cb ON A.BranchControl=cb.ControlNo)Beta 
ON (Alpha.MemberControl=Beta.MemberControl AND DateEntered<=DateTime<IFNULL(DateLeft,CURDATE()))
WHERE Month(DateTime)<'$month' AND Year(DateTime)<='$year'
GROUP BY Month(DateTime),Year(DateTime),BranchControl) FirstTable
LEFT JOIN
(SELECT SUM(Amount) AS Withdrawal, BranchControl, Month(DateTime) AS Month, Year(DateTime) AS Year FROM 
(SELECT ControlNo, Amount, Members_ControlNo AS MemberControl, DateTime, TransactionType
FROM Transaction 
WHERE TransactionType='Withdrawal' AND (Month(DateTime)<'$month' AND Year(DateTime)<='$year'))Alpha
LEFT JOIN
(SELECT MemberControl, BranchControl, DateEntered, DateLeft FROM 
(SELECT CaritasBranch_ControlNo AS BranchControl, Members_ControlNo AS MemberControl, DateEntered, DateLeft 
FROM caritascenters_has_members cchm 
LEFT JOIN caritasbranch_has_caritascenters cbhcc 
ON cbhcc.CaritasCenters_ControlNo=cchm.CaritasCenters_ControlNo)A
LEFT JOIN caritasbranch cb ON A.BranchControl=cb.ControlNo)Beta 
ON (Alpha.MemberControl=Beta.MemberControl AND DateEntered<=DateTime<IFNULL(DateLeft,CURDATE()))
WHERE Month(DateTime)<'$month' AND Year(DateTime)<='$year'
GROUP BY Month(DateTime),Year(DateTime),BranchControl) SecondTable
ON FirstTable.BranchControl=SecondTable.branchControl
ORDER BY (FirstTable.Month && FirstTable.Year)")
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
WHERE TransactionType='Savings' AND (Month(DateTime)<'$month' AND Year(DateTime)<='$year'))Alpha
LEFT JOIN
(SELECT MemberControl, BranchControl, DateEntered, DateLeft FROM 
(SELECT CaritasBranch_ControlNo AS BranchControl, Members_ControlNo AS MemberControl, DateEntered, DateLeft 
FROM caritascenters_has_members cchm 
LEFT JOIN caritasbranch_has_caritascenters cbhcc 
ON cbhcc.CaritasCenters_ControlNo=cchm.CaritasCenters_ControlNo)A
LEFT JOIN caritasbranch cb ON A.BranchControl=cb.ControlNo)Beta 
ON (Alpha.MemberControl=Beta.MemberControl AND DateEntered<=DateTime<IFNULL(DateLeft,CURDATE()))
WHERE Month(DateTime)<'$month' AND Year(DateTime)<='$year'
GROUP BY Month(DateTime),Year(DateTime),BranchControl)UNO
LEFT JOIN(SELECT SUM(Amount) AS Withdraw, BranchControl, Month(DateTime) AS Month, Year(DateTime) AS Year FROM 
(SELECT ControlNo, Amount, Members_ControlNo AS MemberControl, DateTime, TransactionType
FROM Transaction 
WHERE TransactionType='Withdrawal' AND (Month(DateTime)<'$month' AND Year(DateTime)<='$year'))Alpha
LEFT JOIN
(SELECT MemberControl, BranchControl, DateEntered, DateLeft FROM 
(SELECT CaritasBranch_ControlNo AS BranchControl, Members_ControlNo AS MemberControl, DateEntered, DateLeft 
FROM caritascenters_has_members cchm 
LEFT JOIN caritasbranch_has_caritascenters cbhcc 
ON cbhcc.CaritasCenters_ControlNo=cchm.CaritasCenters_ControlNo)A
LEFT JOIN caritasbranch cb ON A.BranchControl=cb.ControlNo)Beta 
ON (Alpha.MemberControl=Beta.MemberControl AND DateEntered<=DateTime<IFNULL(DateLeft,CURDATE()))
WHERE Month(DateTime)<'$month' AND Year(DateTime)<='$year'
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
WHERE Month(DateTime)='$month' AND Year(DateTime)='$year'
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
WHERE Month(DateTime)='$month' AND Year(DateTime)='$year'
GROUP BY BranchControl)CurWithdrawal ON CurWithdrawal.BranchControl=cb.ControlNo
WHERE ControlNo!=1");
?>
	<br>
	<table class="misreport" border="1">
		<tr>
			<td class="label"><b>SAVINGS BUILD-UP</b></td>
			<?php foreach ($getSavings->result() as $data){
			echo '<td>'.$data->BranchName.'</td>';
			} ?>
		</tr>

		<tr>
			<td class="label1">Beginning</td>
			<?php foreach($getSavings->result() as $data){
				echo '<td class="number1">'.$data->BegSaving.'</td>';
			} ?>

		</tr>

		<tr>
			<td class="label1">Beginning SBU Int</td>
			<?php 
				foreach($getSavings->result() as $data){
					$money=0;
					foreach($getInterest->result() as $data2){
						if($data2->BranchControl==$data->ControlNo){
							$money+=$data2->PerMonth;
							$money=$money*1.503;
						}
					}
					echo '<td class="number1">'.($money-$data->BegSaving).'</td>';
				}
			?>
		</tr>

		<tr>
			<td class="label1">Savings Collection</td>
			<?php foreach ($getSavings->result() as $data) {
			echo '<td class="number1">'.$data->CurrentSaving.'</td>';
		}?>
		</tr>

		<tr>
			<td class="label1">Savings Collection Int</td>
			<?php 
				foreach($getSavings->result() as $data){
					$money=($data->CurrentSaving)*1.503;
					echo '<td class="number1">'.($money-$data->CurrentSaving).'</td>';
				}
			?>
		</tr>
		
		<tr>
			<td class="label1">Withdrawal</td>
			<?php foreach( $getSavings->result() as $data){
				echo '<td class="number1">('.$data->CurrentWithdrawal.')</td>';
			} ?>
	
		</tr>
		<!--<tr>
			<td class="label1">Returns</td>
			<td class="number1"></td>

		</tr>-->
		<tr>
			<td class="label"><i><b>Total Savings Mobilized</b></i></td>
			<?php foreach( $getSavings->result() as $data){
				$interest1=0;
				$interest2=0;
				foreach ($getInterest->result() as $data2) {
					if($data->ControlNo==$data2->BranchControl){
						$interest1+=$data2->PerMonth;
						$interest1=$interest1*1.503;
					}
				}

				$interest1-=$data->BegSaving;

				$interest2=($data->CurrentSaving)*1.503;
				$interest2-=$data->CurrentSaving;

				echo '<td class="number1">'.($interest1+$interest2+$data->Total).'</td>';
			} ?>

		</tr>
		<!--<tr>
			<td class="label"><b>Dormant (Inactive)</b></td>
			<td class="number1"></td>
	
		</tr>
		<tr>
			<td class="label">&nbsp&nbsp&nbsp&nbspReturn-Dormant</td>
			<td class="number1"></td>
		
		</tr>
		<tr>
			<td class="label"><b>Dormant - End</b></td>
			<td class="number1"></td>
	
		</tr>
		<tr>
			<td class="label"><b>Total Savings</b></td>
			<td class="number2"></td>
	
		</tr>
-->
	</table>

	
	<br>
	<table class="misreport" border="1">
		<tr>
			<td class="label">Preferred Share - Beg</td>
			<?php
	$totalshare = 0;
	
		foreach ($getbranch->result() as $br) { 
		$control = $br->ControlNo;

	$share = $this->db->query("SELECT  b.ControlNo, month(t.DateTime), year(t.DateTime), t.TransactionType, sum(t.Amount) AS Amount
	FROM caritasbranch b, CaritasBranch_has_CaritasCenters bc, CaritasCenters_Has_Members cm, members m,transaction t, loanapplication_has_members lm, loanapplication l WHERE  b.ControlNo = '$control'
	AND b.ControlNo = bc.CaritasBranch_ControlNo AND bc.CaritasCenters_ControlNo = cm.CaritasCenters_ControlNo AND cm.Members_ControlNo = m.ControlNo AND m.ControlNo = t.members_controlno AND t.Members_ControlNo = lm.Members_ControlNo AND lm.loanapplication_ControlNo = l.ControlNo 
	AND month(t.DateTime)<'$month' AND year(t.DateTime)<= '$year' AND t.TransactionType = 'Capital Share'  ");

				foreach ($share->result() as $se){ 
					$sha  = $se->Amount; 

					if ($sha==null){
						$sha = 0;
					}
					?>

			<td class="number"><?php echo $sha;  ?></td>
	<?php   $totalshare +=$sha; 
} } 

?>	<td class="number"><?php echo $totalshare;  ?></td>
		
		</tr>
		<tr>
			<td class="label">Purchased</td>
			<?php
	$totalshare2 = 0;
	
		foreach ($getbranch->result() as $br) { 
		$control = $br->ControlNo;

	$share2 = $this->db->query("SELECT  b.ControlNo, month(t.DateTime), year(t.DateTime), t.TransactionType, sum(t.Amount) AS Amount
	FROM caritasbranch b, CaritasBranch_has_CaritasCenters bc, CaritasCenters_Has_Members cm, members m,transaction t, loanapplication_has_members lm, loanapplication l WHERE  b.ControlNo = '$control'
	AND b.ControlNo = bc.CaritasBranch_ControlNo AND bc.CaritasCenters_ControlNo = cm.CaritasCenters_ControlNo AND cm.Members_ControlNo = m.ControlNo AND m.ControlNo = t.members_controlno AND t.Members_ControlNo = lm.Members_ControlNo AND lm.loanapplication_ControlNo = l.ControlNo 
	AND month(t.DateTime)='$month' AND year(t.DateTime)= '$year' AND t.TransactionType = 'Capital Share'  ");

				foreach ($share2->result() as $se){ 
					$sha2  = $se->Amount; 

					if ($sha2==null){
						$sha2 = 0;
					}
					?>

			<td class="number"><?php echo $sha2;  ?></td>
	<?php   $totalshare2 +=$sha2; 
} } 

?>	<td class="number"><?php echo $totalshare2;  ?></td>
	
		</tr>
		<tr>
			<td class="label">Returned</td>
			<?php
	$totalshare3 = 0;
	
		foreach ($getbranch->result() as $br) { 
		$control = $br->ControlNo;

	$share3 = $this->db->query("SELECT  b.ControlNo, month(t.DateTime), year(t.DateTime), t.TransactionType, sum(t.Amount) AS Amount
	FROM caritasbranch b, CaritasBranch_has_CaritasCenters bc, CaritasCenters_Has_Members cm, members m,transaction t, loanapplication_has_members lm, loanapplication l WHERE  b.ControlNo = '$control'
	AND b.ControlNo = bc.CaritasBranch_ControlNo AND bc.CaritasCenters_ControlNo = cm.CaritasCenters_ControlNo AND cm.Members_ControlNo = m.ControlNo AND m.ControlNo = t.members_controlno AND t.Members_ControlNo = lm.Members_ControlNo AND lm.loanapplication_ControlNo = l.ControlNo 
	AND month(t.DateTime)='$month' AND year(t.DateTime)= '$year' AND t.TransactionType = 'Capital Share Return'  ");

				foreach ($share3->result() as $se){ 
					$sha3  = $se->Amount; 

					if ($sha3==null){
						$sha3 = 0;
					}
					?>

			<td class="number"><?php echo $sha3;  ?></td>
	<?php   $totalshare3 +=$sha3; 
} } 

?>	<td class="number"><?php echo $totalshare3;  ?></td>
	
		</tr>
		
		<tr>
			<td class="label">Preferred Share - End</td>
			<?php
	$totalshare4 = 0;
	
		foreach ($getbranch->result() as $br) { 
		$control = $br->ControlNo;

	$share3 = $this->db->query("SELECT  b.ControlNo, month(t.DateTime), year(t.DateTime), t.TransactionType, sum(t.Amount) AS Amount
	FROM caritasbranch b, CaritasBranch_has_CaritasCenters bc, CaritasCenters_Has_Members cm, members m,transaction t, loanapplication_has_members lm, loanapplication l WHERE  b.ControlNo = '$control'
	AND b.ControlNo = bc.CaritasBranch_ControlNo AND bc.CaritasCenters_ControlNo = cm.CaritasCenters_ControlNo AND cm.Members_ControlNo = m.ControlNo AND m.ControlNo = t.members_controlno AND t.Members_ControlNo = lm.Members_ControlNo AND lm.loanapplication_ControlNo = l.ControlNo 
	AND month(t.DateTime)='$month' AND year(t.DateTime)= '$year' AND t.TransactionType = 'Capital Share Return'  ");

$share2 = $this->db->query("SELECT  b.ControlNo, month(t.DateTime), year(t.DateTime), t.TransactionType, sum(t.Amount) AS Amount
	FROM caritasbranch b, CaritasBranch_has_CaritasCenters bc, CaritasCenters_Has_Members cm, members m,transaction t, loanapplication_has_members lm, loanapplication l WHERE  b.ControlNo = '$control'
	AND b.ControlNo = bc.CaritasBranch_ControlNo AND bc.CaritasCenters_ControlNo = cm.CaritasCenters_ControlNo AND cm.Members_ControlNo = m.ControlNo AND m.ControlNo = t.members_controlno AND t.Members_ControlNo = lm.Members_ControlNo AND lm.loanapplication_ControlNo = l.ControlNo 
	AND month(t.DateTime)='$month' AND year(t.DateTime)= '$year' AND t.TransactionType = 'Capital Share'  ");

$share = $this->db->query("SELECT  b.ControlNo, month(t.DateTime), year(t.DateTime), t.TransactionType, sum(t.Amount) AS Amount
	FROM caritasbranch b, CaritasBranch_has_CaritasCenters bc, CaritasCenters_Has_Members cm, members m,transaction t, loanapplication_has_members lm, loanapplication l WHERE  b.ControlNo = '$control'
	AND b.ControlNo = bc.CaritasBranch_ControlNo AND bc.CaritasCenters_ControlNo = cm.CaritasCenters_ControlNo AND cm.Members_ControlNo = m.ControlNo AND m.ControlNo = t.members_controlno AND t.Members_ControlNo = lm.Members_ControlNo AND lm.loanapplication_ControlNo = l.ControlNo 
	AND month(t.DateTime)<'$month' AND year(t.DateTime)<= '$year' AND t.TransactionType = 'Capital Share'  ");

				foreach ($share->result() as $se){ 
					$sha  = $se->Amount; 

					if ($sha==null){
						$sha = 0;
					}
				foreach ($share2->result() as $se){ 
					$sha2  = $se->Amount; 

					if ($sha2==null){
						$sha2 = 0;
					}
				foreach ($share3->result() as $se){ 
					$sha3  = $se->Amount; 

					if ($sha3==null){
						$sha3 = 0;
					}

					$sha4 = $sha+$sha2+$sha3;
					?>

			<td class="number"><?php echo $sha4;  ?></td>
	<?php   $totalshare4 +=$sha4; 
} } } }

?>	<td class="number"><?php echo $totalshare4;  ?></td>
	
		</tr>
	</table>
	<br>
		<table class="signature" style="margin-left:auto; margin-right:auto;">
			<tr>
				<td class="sigBy">Prepared by:</td>
				<td class="sig">&nbsp</td>
				<td class="sigBy"> &nbsp&nbsp&nbspDate:</td>
				<td class="sig2">&nbsp</td>
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
	<div style="width: 100%; text-align: center;">
		<button onclick="window.print()">Print</button> 
	</div>