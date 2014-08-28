<title>MONTHLY LOAN PORTFOLIO REPORT</title>

<link rel="stylesheet" type="text/css" href="<?php echo base_url('Assets/css/reports.css'); ?>">
	
	<?php //$month = $_POST['month'];
			//$year = $_POST['year'];

			$month = 7;
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

	<h3>CARITAS SALVE CREDIT COOPERATIVE <br> MONTHLY LOAN PORTFOLIO REPORT <br> For The Month Of <b>
		<?php echo $yue ?> <?php echo $year ?></b></h3>

		<br>
	<table class="misreport" border="1">
		<tr class="header">
			<td class="label"><b>Branch:</td>
		<?php	foreach ($getbranch->result() as $br) { ?>
				<td class="branch"> <?php echo $br->branchname; ?> </td>
		<?php }?>
				<td class="branch">Total</td>

		<tr>
			<td class="label"><b>LOAN PORTFOLIO</b></td>
			<td colspan="15"></td>
		</tr>

		<tr>
			<td class="label"><b>Beginning Balance</b></td>
			<td colspan="16"></td>
		</tr>
			<tr>
				<td class="label1">(23 weeks)</td>
				<?php
	$totalbalance = 0;
	
		foreach ($getbranch->result() as $br) { 
		$control = $br->ControlNo;

	$beg = $this->db->query("SELECT sum(l.AmountRequested) as Amount, sum(l.Interest) as Interest, sum(m.LoanExpense) as Expense, b.ControlNo, month(l.DateApplied), year(l.DateApplied)
	FROM caritasbranch b, CaritasBranch_has_CaritasCenters bc, CaritasCenters_Has_Members cm, members m, loanapplication_has_members lm, loanapplication l WHERE  b.ControlNo = '$control'
	AND b.ControlNo = bc.CaritasBranch_ControlNo AND bc.CaritasCenters_ControlNo = cm.CaritasCenters_ControlNo AND cm.Members_ControlNo = m.ControlNo AND m.ControlNo = lm.Members_ControlNo AND lm.loanapplication_ControlNo = l.ControlNo AND l.loantype = '23-Weeks'
	");

	$beg2 = $this->db->query("SELECT  b.ControlNo, month(t.DateTime), year(t.DateTime), t.TransactionType, sum(t.Amount) AS Amount
	FROM caritasbranch b, CaritasBranch_has_CaritasCenters bc, CaritasCenters_Has_Members cm, members m,transaction t, loanapplication_has_members lm, loanapplication l WHERE  b.ControlNo = '$control'
	AND b.ControlNo = bc.CaritasBranch_ControlNo AND bc.CaritasCenters_ControlNo = cm.CaritasCenters_ControlNo AND cm.Members_ControlNo = m.ControlNo AND m.ControlNo = t.members_controlno AND t.Members_ControlNo = lm.Members_ControlNo AND lm.loanapplication_ControlNo = l.ControlNo AND l.loantype = '23-Weeks'
	 AND (t.TransactionType = 'Loan' or t.TransactionType = 'Past Due') ");

				foreach ($beg->result() as $tl){ 
					$amount  = $tl->Amount; 
					$interest = $tl->Interest;
					$expense = $tl->Expense;

					$collection = $amount+$interest-$expense;

					
					foreach ($beg2->result() as $tt){ 
					$amt  = $tt->Amount; 
			
					

					$balance = $collection-$amt;

					if ($balance==null){
						$balance = 0;
					}
					?>
			<td class="number"><?php echo $balance;  ?></td>
	<?php   $totalbalance +=$balance; 
} } 
}
?>	<td class="number"><?php echo $totalbalance;  ?></td>
			</tr>
			
			<tr>
				<td class="label1">(40 weeks)</td>
				<?php
	$totalbalance2 = 0;
	
		foreach ($getbranch->result() as $br) { 
		$control = $br->ControlNo;

	$beg3 = $this->db->query("SELECT sum(l.AmountRequested) as Amount, sum(l.Interest) as Interest, sum(m.LoanExpense) as Expense, b.ControlNo, month(l.DateApplied), year(l.DateApplied)
	FROM caritasbranch b, CaritasBranch_has_CaritasCenters bc, CaritasCenters_Has_Members cm, members m, loanapplication_has_members lm, loanapplication l WHERE  b.ControlNo = '$control'
	AND b.ControlNo = bc.CaritasBranch_ControlNo AND bc.CaritasCenters_ControlNo = cm.CaritasCenters_ControlNo AND cm.Members_ControlNo = m.ControlNo AND m.ControlNo = lm.Members_ControlNo AND lm.loanapplication_ControlNo = l.ControlNo AND l.loantype = '40-Weeks'
	AND month(l.DateApplied)='$month' AND year(l.DateApplied)= '$year'");

	$beg4 = $this->db->query("SELECT  b.ControlNo, month(t.DateTime), year(t.DateTime), t.TransactionType, sum(t.Amount) AS Amount
	FROM caritasbranch b, CaritasBranch_has_CaritasCenters bc, CaritasCenters_Has_Members cm, members m,transaction t, loanapplication_has_members lm, loanapplication l WHERE  b.ControlNo = '$control'
	AND b.ControlNo = bc.CaritasBranch_ControlNo AND bc.CaritasCenters_ControlNo = cm.CaritasCenters_ControlNo AND cm.Members_ControlNo = m.ControlNo AND m.ControlNo = t.members_controlno AND t.Members_ControlNo = lm.Members_ControlNo AND lm.loanapplication_ControlNo = l.ControlNo AND l.loantype = '40-Weeks'
	AND month(t.DateTime)='$month' AND year(t.DateTime)= '$year' AND (t.TransactionType = 'Loan' or t.TransactionType = 'Past Due') ");

				foreach ($beg3->result() as $tl){ 
					$amount  = $tl->Amount; 
					$interest = $tl->Interest;
					$expense = $tl->Expense;

					$collection = $amount+$interest-$expense;

					
					foreach ($beg4->result() as $tt){ 
					$amt  = $tt->Amount; 
			
					

					$balance2 = $collection-$amt;

					if ($balance2==null){
						$balance2 = 0;
					}
					?>
			<td class="number"><?php echo $balance2;  ?></td>
	<?php   $totalbalance2 +=$balance2; 
} } 
}
?>	<td class="number"><?php echo $totalbalance2;  ?></td>
			
			</tr>
			
		<tr>
			<td class="label2">Total Loan Receivable-Beg</td>
			<?php
	$totalbala = 0;
	
		foreach ($getbranch->result() as $br) { 
		$control = $br->ControlNo;

	$beg = $this->db->query("SELECT sum(l.AmountRequested) as Amount, sum(l.Interest) as Interest, sum(m.LoanExpense) as Expense, b.ControlNo, month(l.DateApplied), year(l.DateApplied)
	FROM caritasbranch b, CaritasBranch_has_CaritasCenters bc, CaritasCenters_Has_Members cm, members m, loanapplication_has_members lm, loanapplication l WHERE  b.ControlNo = '$control'
	AND b.ControlNo = bc.CaritasBranch_ControlNo AND bc.CaritasCenters_ControlNo = cm.CaritasCenters_ControlNo AND cm.Members_ControlNo = m.ControlNo AND m.ControlNo = lm.Members_ControlNo AND lm.loanapplication_ControlNo = l.ControlNo AND l.loantype = '23-Weeks'
	AND month(l.DateApplied)='$month' AND year(l.DateApplied)= '$year'");

	$beg2 = $this->db->query("SELECT  b.ControlNo, month(t.DateTime), year(t.DateTime), t.TransactionType, sum(t.Amount) AS Amount
	FROM caritasbranch b, CaritasBranch_has_CaritasCenters bc, CaritasCenters_Has_Members cm, members m,transaction t, loanapplication_has_members lm, loanapplication l WHERE  b.ControlNo = '$control'
	AND b.ControlNo = bc.CaritasBranch_ControlNo AND bc.CaritasCenters_ControlNo = cm.CaritasCenters_ControlNo AND cm.Members_ControlNo = m.ControlNo AND m.ControlNo = t.members_controlno AND t.Members_ControlNo = lm.Members_ControlNo AND lm.loanapplication_ControlNo = l.ControlNo AND l.loantype = '23-Weeks'
	AND month(t.DateTime)='$month' AND year(t.DateTime)= '$year' AND (t.TransactionType = 'Loan' or t.TransactionType = 'Past Due') ");

	$beg3 = $this->db->query("SELECT sum(l.AmountRequested) as Amount, sum(l.Interest) as Interest, sum(m.LoanExpense) as Expense, b.ControlNo, month(l.DateApplied), year(l.DateApplied)
	FROM caritasbranch b, CaritasBranch_has_CaritasCenters bc, CaritasCenters_Has_Members cm, members m, loanapplication_has_members lm, loanapplication l WHERE  b.ControlNo = '$control'
	AND b.ControlNo = bc.CaritasBranch_ControlNo AND bc.CaritasCenters_ControlNo = cm.CaritasCenters_ControlNo AND cm.Members_ControlNo = m.ControlNo AND m.ControlNo = lm.Members_ControlNo AND lm.loanapplication_ControlNo = l.ControlNo AND l.loantype = '40-Weeks'
	AND month(l.DateApplied)='$month' AND year(l.DateApplied)= '$year'");

	$beg4 = $this->db->query("SELECT  b.ControlNo, month(t.DateTime), year(t.DateTime), t.TransactionType, sum(t.Amount) AS Amount
	FROM caritasbranch b, CaritasBranch_has_CaritasCenters bc, CaritasCenters_Has_Members cm, members m,transaction t, loanapplication_has_members lm, loanapplication l WHERE  b.ControlNo = '$control'
	AND b.ControlNo = bc.CaritasBranch_ControlNo AND bc.CaritasCenters_ControlNo = cm.CaritasCenters_ControlNo AND cm.Members_ControlNo = m.ControlNo AND m.ControlNo = t.members_controlno AND t.Members_ControlNo = lm.Members_ControlNo AND lm.loanapplication_ControlNo = l.ControlNo AND l.loantype = '40-Weeks'
	AND month(t.DateTime)='$month' AND year(t.DateTime)= '$year' AND (t.TransactionType = 'Loan' or t.TransactionType = 'Past Due') ");

				foreach ($beg3->result() as $tl){ 
					$amount  = $tl->Amount; 
					$interest = $tl->Interest;
					$expense = $tl->Expense;

					$collection = $amount+$interest-$expense;

					
					foreach ($beg4->result() as $tt){ 
					$amt  = $tt->Amount; 
			

					$balance2 = $collection-$amt;

					if ($balance2==null){
						$balance2 = 0;
					}

				foreach ($beg->result() as $tl){ 
					$amount  = $tl->Amount; 
					$interest = $tl->Interest;
					$expense = $tl->Expense;

					$collection = $amount+$interest-$expense;

					
					foreach ($beg2->result() as $tt){ 
					$amt  = $tt->Amount; 
			
					

					$balance = $collection-$amt;

					if ($balance==null){
						$balance = 0;
					}

					$totalbal = $balance+$balance2;
					?>
	
	<td class="number"><?php echo $totalbal;  ?></td>
	<?php   $totalbala +=$totalbal; 
} } } } }

?>	<td class="number"><?php echo $totalbala;  ?></td>
		</tr>
		<tr>
			<td class="label"><b>Loan Releases</b></td>
			<td colspan="15"></td>
		</tr>
			<<tr>
				<td class="label1">(23 weeks)</td>
				<?php
	$totalrelease = 0;
	
		foreach ($getbranch->result() as $br) { 
		$control = $br->ControlNo;

	$release = $this->db->query("SELECT sum(l.AmountRequested) as Amount, b.ControlNo, month(l.DateApplied), year(l.DateApplied)
	FROM caritasbranch b, CaritasBranch_has_CaritasCenters bc, CaritasCenters_Has_Members cm, loanapplication_has_members lm, loanapplication l WHERE  b.ControlNo = '$control'
	AND b.ControlNo = bc.CaritasBranch_ControlNo AND bc.CaritasCenters_ControlNo = cm.CaritasCenters_ControlNo AND cm.Members_ControlNo = lm.Members_ControlNo AND lm.loanapplication_ControlNo = l.ControlNo AND l.loantype = '23-Weeks'
	AND month(l.DateApplied)='$month' AND year(l.DateApplied)= '$year' AND l.Status = 'Active'");

				foreach ($release->result() as $rl){ 
					$rel  = $rl->Amount; 

					if ($rel==null){
						$rel = 0;
					}
					?>

			<td class="number"><?php echo $rel;  ?></td>
	<?php   $totalrelease +=$rel; 
} } 

?>	<td class="number"><?php echo $totalrelease;  ?></td>
			
				
			</tr>
			
			
			<tr>
				<td class="label1">(40 weeks)</td>
				<?php
	$totalrelease2 = 0;
	
		foreach ($getbranch->result() as $br) { 
		$control = $br->ControlNo;

	$release2 = $this->db->query("SELECT sum(l.AmountRequested) as Amount, b.ControlNo, month(l.DateApplied), year(l.DateApplied)
	FROM caritasbranch b, CaritasBranch_has_CaritasCenters bc, CaritasCenters_Has_Members cm, loanapplication_has_members lm, loanapplication l WHERE  b.ControlNo = '$control'
	AND b.ControlNo = bc.CaritasBranch_ControlNo AND bc.CaritasCenters_ControlNo = cm.CaritasCenters_ControlNo AND cm.Members_ControlNo = lm.Members_ControlNo AND lm.loanapplication_ControlNo = l.ControlNo AND l.loantype = '40-Weeks'
	AND month(l.DateApplied)='$month' AND year(l.DateApplied)= '$year' AND l.Status = 'Active'");

				foreach ($release2->result() as $rl){ 
					$rel2  = $rl->Amount; 

					if ($rel2==null){
						$rel2 = 0;
					}
					?>

			<td class="number"><?php echo $rel2;  ?></td>
	<?php   $totalrelease2 +=$rel2; 
} } 

?>	<td class="number"><?php echo $totalrelease2;  ?></td>
			
			</tr>
			
		<tr>
			<td class="label2">Total Loan Release</td>
			<?php
	$totalrel = 0;
	
		foreach ($getbranch->result() as $br) { 
		$control = $br->ControlNo;

	$release = $this->db->query("SELECT sum(l.AmountRequested) as Amount, b.ControlNo, month(l.DateApplied), year(l.DateApplied)
	FROM caritasbranch b, CaritasBranch_has_CaritasCenters bc, CaritasCenters_Has_Members cm, loanapplication_has_members lm, loanapplication l WHERE  b.ControlNo = '$control'
	AND b.ControlNo = bc.CaritasBranch_ControlNo AND bc.CaritasCenters_ControlNo = cm.CaritasCenters_ControlNo AND cm.Members_ControlNo = lm.Members_ControlNo AND lm.loanapplication_ControlNo = l.ControlNo AND l.loantype = '23-Weeks'
	AND month(l.DateApplied)='$month' AND year(l.DateApplied)= '$year' AND l.Status = 'Active'");


	$release2 = $this->db->query("SELECT sum(l.AmountRequested) as Amount, b.ControlNo, month(l.DateApplied), year(l.DateApplied)
	FROM caritasbranch b, CaritasBranch_has_CaritasCenters bc, CaritasCenters_Has_Members cm, loanapplication_has_members lm, loanapplication l WHERE  b.ControlNo = '$control'
	AND b.ControlNo = bc.CaritasBranch_ControlNo AND bc.CaritasCenters_ControlNo = cm.CaritasCenters_ControlNo AND cm.Members_ControlNo = lm.Members_ControlNo AND lm.loanapplication_ControlNo = l.ControlNo AND l.loantype = '40-Weeks'
	AND month(l.DateApplied)='$month' AND year(l.DateApplied)= '$year' AND l.Status = 'Active'");

				foreach ($release2->result() as $rl){ 
					$rel2  = $rl->Amount; 

					if ($rel2==null){
						$rel2 = 0;
					}
				foreach ($release->result() as $rl){ 
					$rel  = $rl->Amount; 

					if ($rel==null){
						$rel = 0;
					}

					$lease = $rel+$rel2;
					?>

			<td class="number"><?php echo $lease;  ?></td>
	<?php   $totalrel +=$lease; 
} } } 

?>	<td class="number"><?php echo $totalrel;  ?></td>
		
		</tr>

		<tr>
			<td class="label"><b>Target Loan Collection</b></td>
			<td colspan="15"></td>
		</tr>
			<tr>
				<td class="label1">(23 weeks)</td>
				<?php
	$totaltarget = 0;
	
		foreach ($getbranch->result() as $br) { 
		$control = $br->ControlNo;

	$target = $this->db->query("SELECT sum(l.AmountRequested) as Amount, sum(l.Interest) as Interest, sum(m.LoanExpense) as Expense, b.ControlNo, month(l.DateApplied), year(l.DateApplied), sum(cm.Members_ControlNo) as member
	FROM caritasbranch b, CaritasBranch_has_CaritasCenters bc, CaritasCenters_Has_Members cm, members m, loanapplication_has_members lm, loanapplication l WHERE  b.ControlNo = '$control'
	AND b.ControlNo = bc.CaritasBranch_ControlNo AND bc.CaritasCenters_ControlNo = cm.CaritasCenters_ControlNo AND cm.Members_ControlNo = m.ControlNo AND m.ControlNo = lm.Members_ControlNo AND lm.loanapplication_ControlNo = l.ControlNo AND l.loantype = '23-Weeks'
	AND month(l.DateApplied)='$month' AND year(l.DateApplied)= '$year'");

	

				foreach ($target->result() as $tl){ 
					$amount  = $tl->Amount; 
					$interest = $tl->Interest;
					$expense = $tl->Expense;
					$member = $tl->member;
					
					$x = ($amount+$interest)/23;

					if ($x>0){
					$y = $expense/$x;

					if ($y>=4){
						$fine = $x*4;
					} else if ($y==3){
						$fine = $x*3;
					} else if ($y==2){
						$fine = $x*2;
					} else {
						$fine = $x*1;
					}

					$count = $fine*$member;

					if ($count==null){
						$count = 0;
					}

				} else {
					$count = 0;
				}
					
					
					

					
					?>
			<td class="number"><?php echo $count;  ?></td>
	<?php   $totaltarget +=$count; 
} } 

?>	<td class="number"><?php echo $totaltarget;  ?></td>
	
			
		
			</tr>
			
			<tr>
				<td class="label1">(40 weeks)</td>
				<?php
	$totaltarget2 = 0;
	
		foreach ($getbranch->result() as $br) { 
		$control = $br->ControlNo;

	$target2 = $this->db->query("SELECT sum(l.AmountRequested) as Amount, sum(l.Interest) as Interest, sum(m.LoanExpense) as Expense, b.ControlNo, month(l.DateApplied), year(l.DateApplied), sum(cm.Members_ControlNo) as member
	FROM caritasbranch b, CaritasBranch_has_CaritasCenters bc, CaritasCenters_Has_Members cm, members m, loanapplication_has_members lm, loanapplication l WHERE  b.ControlNo = '$control'
	AND b.ControlNo = bc.CaritasBranch_ControlNo AND bc.CaritasCenters_ControlNo = cm.CaritasCenters_ControlNo AND cm.Members_ControlNo = m.ControlNo AND m.ControlNo = lm.Members_ControlNo AND lm.loanapplication_ControlNo = l.ControlNo AND l.loantype = '40-Weeks'
	AND month(l.DateApplied)='$month' AND year(l.DateApplied)= '$year'");

	

				foreach ($target2->result() as $tl){ 
					$amount  = $tl->Amount; 
					$interest = $tl->Interest;
					$expense = $tl->Expense;
					$member = $tl->member;
					
					$x = ($amount+$interest)/40;

					if ($x>0){
					$y = $expense/$x;

					if ($y>=4){
						$fine = $x*4;
					} else if ($y==3){
						$fine = $x*3;
					} else if ($y==2){
						$fine = $x*2;
					} else {
						$fine = $x*1;
					}

					$count2 = $fine*$member;

					if ($count2==null){
						$count2 = 0;
					}

				} else {
					$count2 = 0;
				}
					
					
					

					
					?>
			<td class="number"><?php echo $count2;  ?></td>
	<?php   $totaltarget2 +=$count2; 
} } 

?>	<td class="number"><?php echo $totaltarget2;  ?></td>
				
			</tr>
			
		<tr>
			<td class="label2">Total Loan Collection</td>
			<?php
	$totaltarget3 = 0;
	
		foreach ($getbranch->result() as $br) { 
		$control = $br->ControlNo;

	$target2 = $this->db->query("SELECT sum(l.AmountRequested) as Amount, sum(l.Interest) as Interest, sum(m.LoanExpense) as Expense, b.ControlNo, month(l.DateApplied), year(l.DateApplied), sum(cm.Members_ControlNo) as member
	FROM caritasbranch b, CaritasBranch_has_CaritasCenters bc, CaritasCenters_Has_Members cm, members m, loanapplication_has_members lm, loanapplication l WHERE  b.ControlNo = '$control'
	AND b.ControlNo = bc.CaritasBranch_ControlNo AND bc.CaritasCenters_ControlNo = cm.CaritasCenters_ControlNo AND cm.Members_ControlNo = m.ControlNo AND m.ControlNo = lm.Members_ControlNo AND lm.loanapplication_ControlNo = l.ControlNo AND l.loantype = '40-Weeks'
	AND month(l.DateApplied)='$month' AND year(l.DateApplied)= '$year'");

	$target = $this->db->query("SELECT sum(l.AmountRequested) as Amount, sum(l.Interest) as Interest, sum(m.LoanExpense) as Expense, b.ControlNo, month(l.DateApplied), year(l.DateApplied), sum(cm.Members_ControlNo) as member
	FROM caritasbranch b, CaritasBranch_has_CaritasCenters bc, CaritasCenters_Has_Members cm, members m, loanapplication_has_members lm, loanapplication l WHERE  b.ControlNo = '$control'
	AND b.ControlNo = bc.CaritasBranch_ControlNo AND bc.CaritasCenters_ControlNo = cm.CaritasCenters_ControlNo AND cm.Members_ControlNo = m.ControlNo AND m.ControlNo = lm.Members_ControlNo AND lm.loanapplication_ControlNo = l.ControlNo AND l.loantype = '23-Weeks'
	AND month(l.DateApplied)='$month' AND year(l.DateApplied)= '$year'");

	

				foreach ($target->result() as $tl){ 
					$amount  = $tl->Amount; 
					$interest = $tl->Interest;
					$expense = $tl->Expense;
					$member = $tl->member;
					
					$x = ($amount+$interest)/23;

					if ($x>0){
					$y = $expense/$x;

					if ($y>=4){
						$fine = $x*4;
					} else if ($y==3){
						$fine = $x*3;
					} else if ($y==2){
						$fine = $x*2;
					} else {
						$fine = $x*1;
					}

					$count = $fine*$member;

					if ($count==null){
						$count = 0;
					}

				} else {
					$count = 0;
				}
	

				foreach ($target2->result() as $tl){ 
					$amount  = $tl->Amount; 
					$interest = $tl->Interest;
					$expense = $tl->Expense;
					$member = $tl->member;
					
					$x = ($amount+$interest)/40;

					if ($x>0){
					$y = $expense/$x;

					if ($y>=4){
						$fine = $x*4;
					} else if ($y==3){
						$fine = $x*3;
					} else if ($y==2){
						$fine = $x*2;
					} else {
						$fine = $x*1;
					}

					$count2 = $fine*$member;

					if ($count2==null){
						$count2 = 0;
					}

				} else {
					$count2 = 0;
				}
					
					
					$count3 = $count +$count2;

					
					?>
			<td class="number"><?php echo $count3;  ?></td>
	<?php   $totaltarget3 +=$count3; 
} } }

?>	<td class="number"><?php echo $totaltarget3;  ?></td>
		
		</tr>

		<tr>
			<td class="label"><b>Loan Collection</b></td>
			<td colspan="15"></td>
		</tr>
			<tr>
				<td class="label1">(23 weeks)</td>
				<?php
	$totalcollect = 0;
	
		foreach ($getbranch->result() as $br) { 
		$control = $br->ControlNo;

	$collect = $this->db->query("SELECT sum(l.AmountRequested) as Amount, sum(l.Interest) as Interest, sum(m.LoanExpense) as Expense, b.ControlNo, month(l.DateApplied), year(l.DateApplied)
	FROM caritasbranch b, CaritasBranch_has_CaritasCenters bc, CaritasCenters_Has_Members cm, members m, loanapplication_has_members lm, loanapplication l WHERE  b.ControlNo = '$control'
	AND b.ControlNo = bc.CaritasBranch_ControlNo AND bc.CaritasCenters_ControlNo = cm.CaritasCenters_ControlNo AND cm.Members_ControlNo = m.ControlNo AND m.ControlNo = lm.Members_ControlNo AND lm.loanapplication_ControlNo = l.ControlNo AND l.loantype = '23-Weeks'
	AND month(l.DateApplied)='$month' AND year(l.DateApplied)= '$year'");

				foreach ($collect->result() as $cl){ 
					$amount  = $cl->Amount; 
					$interest = $cl->Interest;
					$expense = $cl->Expense;

					$collection = $amount+$interest-$expense;

					if ($collection==null){
						$collection = 0;
					}
					?>
			
			<td class="number"><?php echo $collection;  ?></td>
	<?php   $totalcollect +=$collection; 
 } } 

?>	<td class="number"><?php echo $totalcollect;  ?></td>
		
			
			</tr>
			
			<tr>
				<td class="label1">(40 weeks)</td>
				<?php
	$totalcollect2 = 0;
	
		foreach ($getbranch->result() as $br) { 
		$control = $br->ControlNo;

	$collect2 = $this->db->query("SELECT sum(l.AmountRequested) as Amount, sum(l.Interest) as Interest, sum(m.LoanExpense) as Expense, b.ControlNo, month(l.DateApplied), year(l.DateApplied)
	FROM caritasbranch b, CaritasBranch_has_CaritasCenters bc, CaritasCenters_Has_Members cm, members m, loanapplication_has_members lm, loanapplication l WHERE  b.ControlNo = '$control'
	AND b.ControlNo = bc.CaritasBranch_ControlNo AND bc.CaritasCenters_ControlNo = cm.CaritasCenters_ControlNo AND cm.Members_ControlNo = m.ControlNo AND m.ControlNo = lm.Members_ControlNo AND lm.loanapplication_ControlNo = l.ControlNo AND l.loantype = '40-Weeks'
	AND month(l.DateApplied)='$month' AND year(l.DateApplied)= '$year'");

				foreach ($collect2->result() as $cl){ 
					$amount  = $cl->Amount; 
					$interest = $cl->Interest;
					$expense = $cl->Expense;

					$collection2 = $amount+$interest-$expense;

					if ($collection2==null){
						$collection2 = 0;
					}
					?>
			
			<td class="number"><?php echo $collection2;  ?></td>
	<?php   $totalcollect2 +=$collection2; 
 } } 

?>	<td class="number"><?php echo $totalcollect2;  ?></td>
			
			</tr>
			
		<tr>
			<td class="label2">Total Loan Collection</td>
			<?php
	$totalcollect3 = 0;
	
		foreach ($getbranch->result() as $br) { 
		$control = $br->ControlNo;

	$collect = $this->db->query("SELECT sum(l.AmountRequested) as Amount, sum(l.Interest) as Interest, sum(m.LoanExpense) as Expense, b.ControlNo, month(l.DateApplied), year(l.DateApplied)
	FROM caritasbranch b, CaritasBranch_has_CaritasCenters bc, CaritasCenters_Has_Members cm, members m, loanapplication_has_members lm, loanapplication l WHERE  b.ControlNo = '$control'
	AND b.ControlNo = bc.CaritasBranch_ControlNo AND bc.CaritasCenters_ControlNo = cm.CaritasCenters_ControlNo AND cm.Members_ControlNo = m.ControlNo AND m.ControlNo = lm.Members_ControlNo AND lm.loanapplication_ControlNo = l.ControlNo AND l.loantype = '23-Weeks'
	AND month(l.DateApplied)='$month' AND year(l.DateApplied)= '$year'");


	$collect2 = $this->db->query("SELECT sum(l.AmountRequested) as Amount, sum(l.Interest) as Interest, sum(m.LoanExpense) as Expense, b.ControlNo, month(l.DateApplied), year(l.DateApplied)
	FROM caritasbranch b, CaritasBranch_has_CaritasCenters bc, CaritasCenters_Has_Members cm, members m, loanapplication_has_members lm, loanapplication l WHERE  b.ControlNo = '$control'
	AND b.ControlNo = bc.CaritasBranch_ControlNo AND bc.CaritasCenters_ControlNo = cm.CaritasCenters_ControlNo AND cm.Members_ControlNo = m.ControlNo AND m.ControlNo = lm.Members_ControlNo AND lm.loanapplication_ControlNo = l.ControlNo AND l.loantype = '40-Weeks'
	AND month(l.DateApplied)='$month' AND year(l.DateApplied)= '$year'");

				foreach ($collect2->result() as $cl){ 
					$amount  = $cl->Amount; 
					$interest = $cl->Interest;
					$expense = $cl->Expense;

					$collection2 = $amount+$interest-$expense;

					if ($collection2==null){
						$collection2 = 0;
					}

				foreach ($collect->result() as $cl){ 
					$amount  = $cl->Amount; 
					$interest = $cl->Interest;
					$expense = $cl->Expense;

					$collection = $amount+$interest-$expense;

					if ($collection==null){
						$collection = 0;
					}

					$collection3 = $collection+$collection2;

					?>
			
			<td class="number"><?php echo $collection3;  ?></td>
	<?php   $totalcollect3 +=$collection3; 
 } } }

?>	<td class="number"><?php echo $totalcollect3;  ?></td>
		
		</tr>
		<tr>
			<td class="label"><b>Loans Receivable-End</b></td>
			<td colspan="15"></td>
		</tr>
			<tr>
				<td class="label1">(23 weeks)</td>
				<?php
	$totalreceive = 0;
	
		foreach ($getbranch->result() as $br) { 
		$control = $br->ControlNo;

	$receive = $this->db->query("SELECT sum(m.LoanExpense) as Amount, b.ControlNo
	FROM caritasbranch b, CaritasBranch_has_CaritasCenters bc, CaritasCenters_Has_Members cm, members m, loanapplication_has_members lm, loanapplication l WHERE  b.ControlNo = '$control'
	AND b.ControlNo = bc.CaritasBranch_ControlNo AND bc.CaritasCenters_ControlNo = cm.CaritasCenters_ControlNo AND cm.Members_ControlNo = m.ControlNo AND m.ControlNo = lm.Members_ControlNo AND lm.loanapplication_ControlNo = l.ControlNo AND l.loantype = '23-Weeks'");

				foreach ($receive->result() as $rl){ 
					$rec  = $rl->Amount; 

					if ($rec==null){
						$rec = 0;
					}
					?>

			<td class="number"><?php echo $rec;  ?></td>
	<?php   $totalreceive +=$rec; 
} } 

?>	<td class="number"><?php echo $totalreceive;  ?></td>
	
			</tr>
			
			<tr>
				<td class="label1">(40 weeks)</td>
				<?php
	$totalreceive2 = 0;
	
		foreach ($getbranch->result() as $br) { 
		$control = $br->ControlNo;

	$receive2 = $this->db->query("SELECT sum(m.LoanExpense) as Amount, b.ControlNo
	FROM caritasbranch b, CaritasBranch_has_CaritasCenters bc, CaritasCenters_Has_Members cm, members m, loanapplication_has_members lm, loanapplication l WHERE  b.ControlNo = '$control'
	AND b.ControlNo = bc.CaritasBranch_ControlNo AND bc.CaritasCenters_ControlNo = cm.CaritasCenters_ControlNo AND cm.Members_ControlNo = m.ControlNo AND m.ControlNo = lm.Members_ControlNo AND lm.loanapplication_ControlNo = l.ControlNo AND l.loantype = '40-Weeks'");

				foreach ($receive2->result() as $rl){ 
					$rec2  = $rl->Amount; 

					if ($rec2==null){
						$rec2 = 0;
					}
					?>

			<td class="number"><?php echo $rec2;  ?></td>
	<?php   $totalreceive2 +=$rec2; 
} } 

?>	<td class="number"><?php echo $totalreceive2;  ?></td>
		
			</tr>
			
		<tr>
			<td class="label2">Total Loan Receivable-End</td>
			
		<?php
	$totalrece = 0;
	
		foreach ($getbranch->result() as $br) { 
		$control = $br->ControlNo;

	$receive2 = $this->db->query("SELECT sum(m.LoanExpense) as Amount, b.ControlNo
	FROM caritasbranch b, CaritasBranch_has_CaritasCenters bc, CaritasCenters_Has_Members cm, members m, loanapplication_has_members lm, loanapplication l WHERE  b.ControlNo = '$control'
	AND b.ControlNo = bc.CaritasBranch_ControlNo AND bc.CaritasCenters_ControlNo = cm.CaritasCenters_ControlNo AND cm.Members_ControlNo = m.ControlNo AND m.ControlNo = lm.Members_ControlNo AND lm.loanapplication_ControlNo = l.ControlNo AND l.loantype = '40-Weeks'");

	$receive = $this->db->query("SELECT sum(m.LoanExpense) as Amount, b.ControlNo
	FROM caritasbranch b, CaritasBranch_has_CaritasCenters bc, CaritasCenters_Has_Members cm, members m, loanapplication_has_members lm, loanapplication l WHERE  b.ControlNo = '$control'
	AND b.ControlNo = bc.CaritasBranch_ControlNo AND bc.CaritasCenters_ControlNo = cm.CaritasCenters_ControlNo AND cm.Members_ControlNo = m.ControlNo AND m.ControlNo = lm.Members_ControlNo AND lm.loanapplication_ControlNo = l.ControlNo AND l.loantype = '23-Weeks'");

				foreach ($receive->result() as $rl){ 
					$rec  = $rl->Amount; 

					if ($rec==null){
						$rec = 0;
					}
				foreach ($receive2->result() as $rl){ 
					$rec2  = $rl->Amount; 

					if ($rec2==null){
						$rec2 = 0;
					}

					$totalrec = $rec+$rec2;
					?>

								<td class="number"><?php echo $totalrec;  ?></td>
	<?php   $totalrece +=$totalrec; 
} } }

?>	<td class="number"><?php echo $totalrece;  ?></td>
		
		
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