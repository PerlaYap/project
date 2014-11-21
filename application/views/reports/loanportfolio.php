<title>MONTHLY LOAN PORTFOLIO REPORT</title>


<style type="text/css" media="print">
.dontprint{
	display: none;
}
</style>

<link rel="stylesheet" type="text/css" href="<?php echo base_url('Assets/css/reports.css'); ?>">
	
	<?php 

		$user = $this->session->userdata('firstname');
		$datetoday = date('F d, Y');
$userrank = $this->session->userdata('rank');
	$name = $this->session->userdata('firstname');

$getportfolio = $this->db->query("SELECT ControlNo, BranchID, BranchName, TRUNCATE((IFNULL(BegTotalLoan23,0)-IFNULL(Beg23Collection,0)),2) AS BegTotalLoan23, TRUNCATE((IFNULL(BegTotalLoan40,0)-IFNULL(Beg40Collection,0)),2) AS BegTotalLoan40,
TRUNCATE(IFNULL(LoanReleased23,0),2) AS LoanReleased23, TRUNCATE(IFNULL(LoanReleased40,0),2) AS LoanReleased40, TRUNCATE(IFNULL(TotalTarget23,0),2) AS TotalTarget23, TRUNCATE(IFNULL(TotalTarget40,0),2) AS TotalTarget40,
TRUNCATE(IFNULL(Collected23,0),2) AS Collected23, TRUNCATE(IFNULL(Collected40,0),2) AS Collected40
FROM CaritasBranch cb
LEFT JOIN
(SELECT SUM(AmountRequested) AS BegTotalLoan23, CaritasBranch_ControlNo AS BranchControl 
FROM (SELECT ControlNo, AmountRequested, LoanType 
FROM LoanApplication WHERE (Status!='Rejected' AND Status!='Pending' AND Status!='Active') AND DateReleased<=LAST_DAY(DATE_ADD('$date', INTERVAL -1 MONTH)))A
LEFT JOIN LoanApplication_has_Members lhm ON lhm.LoanApplication_ControlNo=A.ControlNo
WHERE LoanType='23-Weeks' GROUP BY  BranchControl, LoanType)BegLoan23Weeks
ON cb.ControlNo=BegLoan23Weeks.BranchControl
LEFT JOIN
(SELECT SUM(AmountRequested) AS BegTotalLoan40, CaritasBranch_ControlNo AS BranchControl 
FROM (SELECT ControlNo, AmountRequested, LoanType 
FROM LoanApplication WHERE (Status!='Rejected' AND Status!='Pending' AND Status!='Active') AND DateReleased<=LAST_DAY(DATE_ADD('$date', INTERVAL -1 MONTH)))A
LEFT JOIN LoanApplication_has_Members lhm ON lhm.LoanApplication_ControlNo=A.ControlNo
WHERE LoanType='40-Weeks' GROUP BY  BranchControl)BegLoan40Weeks
ON cb.ControlNo=BegLoan40Weeks.BranchControl
LEFT JOIN
(SELECT SUM(Amount) AS Beg23Collection, CaritasBranch_ControlNo AS BranchControl, LoanType FROM (SELECT LoanAppControlNo, Amount
FROM Transaction 
WHERE (TransactionType='Loan' OR TransactionType='Past Due') AND DateTime<=LAST_DAY(DATE_ADD('$date', INTERVAL -1 MONTH)))A
LEFT JOIN loanapplication_has_members lhm ON lhm.LoanApplication_ControlNo=A.LoanAppControlNo
LEFT JOIN LoanApplication la ON la.ControlNo=A.LoanAppControlNo
WHERE LoanType='23-Weeks' GROUP BY BranchControl)BegCollection23Weeks
ON cb.ControlNo=BegCollection23Weeks.BranchControl
LEFT JOIN
(SELECT SUM(Amount) AS Beg40Collection, CaritasBranch_ControlNo AS BranchControl, LoanType FROM (SELECT LoanAppControlNo, Amount
FROM Transaction 
WHERE (TransactionType='Loan' OR TransactionType='Past Due') AND DateTime<=LAST_DAY(DATE_ADD('$date', INTERVAL -1 MONTH)))A
LEFT JOIN loanapplication_has_members lhm ON lhm.LoanApplication_ControlNo=A.LoanAppControlNo
LEFT JOIN LoanApplication la ON la.ControlNo=A.LoanAppControlNo
WHERE LoanType='40-Weeks'
GROUP BY BranchControl, LoanType)BegCollection40Weeks
ON cb.ControlNo=BegCollection40Weeks.BranchControl
LEFT JOIN
(SELECT CaritasBranch_ControlNo AS BranchControl, SUM(AmountRequested) AS LoanReleased23 FROM (SELECT ControlNo, AmountRequested, LoanType FROM LoanApplication la
WHERE (MONTH(DateReleased)=MONTH('$date') AND YEAR(DateReleased)=YEAR('$date')) AND (Status!='Pending' AND Status!='Rejected' AND Status!='Active'))la
LEFT JOIN LoanApplication_has_Members lhm ON la.ControlNo=lhm.LoanApplication_ControlNo
WHERE LoanType='23-Weeks' GROUP BY CaritasBranch_ControlNo)LoanReleased23
ON cb.ControlNo=LoanReleased23.BranchControl
LEFT JOIN
(SELECT CaritasBranch_ControlNo AS BranchControl, SUM(AmountRequested) AS LoanReleased40 FROM (SELECT ControlNo, AmountRequested, LoanType FROM LoanApplication la
WHERE (MONTH(DateReleased)=MONTH('$date') AND YEAR(DateReleased)=YEAR('$date')) AND (Status!='Pending' AND Status!='Rejected' AND Status!='Active'))la
LEFT JOIN LoanApplication_has_Members lhm ON la.ControlNo=lhm.LoanApplication_ControlNo
WHERE LoanType='23-Weeks' GROUP BY CaritasBranch_ControlNo)LoanReleased40
ON cb.ControlNo=LoanReleased40.BranchControl
LEFT JOIN
(SELECT CaritasBranch_ControlNo AS BranchControl, SUM(MonthlyPayment) AS TotalTarget23
FROM (SELECT ControlNo, DateReleased, DateEnd, LoanType,
ROUND(((TRUNCATE(DATEDIFF(LAST_DAY(DATE_ADD('$date', INTERVAL 0 MONTH)),DateReleased)/7,0)-TRUNCATE((IF(Month(DateEnd)=Month('$date') AND YEAR(DateEnd)=YEAR('$date'),DATEDIFF(DateEnd,DateReleased)/7,DATEDIFF(LAST_DAY(DATE_ADD('$date', INTERVAL -1 MONTH)),DateReleased)/7)),0))* WeeklyPayment),2) AS MonthlyPayment
FROM 
(SELECT ControlNo, IF(LoanType='23-Weeks',(AmountRequested+Interest)/23, (AmountRequested+Interest)/40) AS WeeklyPayment, LoanType, DateReleased, 
DATE_ADD((IF(LoanType='23-Weeks', DATE_ADD(DateReleased, INTERVAL 161 DAY), DATE_ADD(DateReleased,INTERVAL 280 DAY))), INTERVAL 0 MONTH) AS DateEnd
FROM loanapplication 
WHERE (Status='Current' OR Status='Full Payment') AND 
(CAST(DATE_FORMAT('$date' ,CONCAT(YEAR(DateReleased),'-',MONTH(DateReleased),'-01')) as DATE)<='$date' 
AND '$date'<=LAST_DAY(DATE_ADD((IF(LoanType='23-Weeks', DATE_ADD(DateReleased, INTERVAL 161 DAY), DATE_ADD(DateReleased,INTERVAL 280 DAY))), INTERVAL 0 MONTH))))Alpha)A
LEFT JOIN LoanApplication_has_Members lhm ON lhm.LoanApplication_ControlNo=A.ControlNo
WHERE LoanType='23-Weeks' GROUP BY CaritasBranch_ControlNo)TargetAmount23
ON cb.ControlNo=TargetAmount23.BranchControl
LEFT JOIN
(SELECT CaritasBranch_ControlNo AS BranchControl, SUM(MonthlyPayment) AS TotalTarget40
FROM (SELECT ControlNo, DateReleased, DateEnd, LoanType,
ROUND(((TRUNCATE(DATEDIFF(LAST_DAY(DATE_ADD('$date', INTERVAL 0 MONTH)),DateReleased)/7,0)-TRUNCATE((IF(Month(DateEnd)=Month('$date') AND YEAR(DateEnd)=YEAR('$date'),DATEDIFF(DateEnd,DateReleased)/7,DATEDIFF(LAST_DAY(DATE_ADD('$date', INTERVAL -1 MONTH)),DateReleased)/7)),0))* WeeklyPayment),2) AS MonthlyPayment
FROM 
(SELECT ControlNo, IF(LoanType='23-Weeks',(AmountRequested+Interest)/23, (AmountRequested+Interest)/40) AS WeeklyPayment, LoanType, DateReleased, 
DATE_ADD((IF(LoanType='23-Weeks', DATE_ADD(DateReleased, INTERVAL 161 DAY), DATE_ADD(DateReleased,INTERVAL 280 DAY))), INTERVAL 0 MONTH) AS DateEnd
FROM loanapplication 
WHERE (Status='Current' OR Status='Full Payment') AND 
(CAST(DATE_FORMAT('$date' ,CONCAT(YEAR(DateReleased),'-',MONTH(DateReleased),'-01')) as DATE)<='$date' 
AND '$date'<=LAST_DAY(DATE_ADD((IF(LoanType='23-Weeks', DATE_ADD(DateReleased, INTERVAL 161 DAY), DATE_ADD(DateReleased,INTERVAL 280 DAY))), INTERVAL 0 MONTH))))Alpha)A
LEFT JOIN LoanApplication_has_Members lhm ON lhm.LoanApplication_ControlNo=A.ControlNo
WHERE LoanType='40-Weeks' GROUP BY CaritasBranch_ControlNo)TargetAmount40
ON cb.ControlNo=TargetAmount40.BranchControl
LEFT JOIN
(SELECT CaritasBranch_ControlNo AS BranchControl, SUM(Amount) AS Collected23
FROM (SELECT LoanAppControlNo AS AppControl, SUM(Amount) AS Amount FROM Transaction 
WHERE (TransactionType='Loan' OR TransactionType='Past Due') AND (MONTH(DateTime)=MONTH('$date') AND YEAR(DateTime)=YEAR('$date'))
GROUP BY LoanAppControlNo)A
LEFT JOIN LoanApplication_has_Members lhm ON lhm.LoanApplication_ControlNo=A.AppControl
LEFT JOIN LoanApplication la ON la.ControlNo=A.AppControl
WHERE LoanType='23-Weeks' GROUP BY CaritasBranch_ControlNo)Collected23
ON cb.ControlNo=Collected23.BranchControl
LEFT JOIN
(SELECT CaritasBranch_ControlNo AS BranchControl, SUM(Amount) AS Collected40
FROM (SELECT LoanAppControlNo AS AppControl, SUM(Amount) AS Amount FROM Transaction 
WHERE (TransactionType='Loan' OR TransactionType='Past Due') AND (MONTH(DateTime)=MONTH('$date') AND YEAR(DateTime)=YEAR('$date'))
GROUP BY LoanAppControlNo)A
LEFT JOIN LoanApplication_has_Members lhm ON lhm.LoanApplication_ControlNo=A.AppControl
LEFT JOIN LoanApplication la ON la.ControlNo=A.AppControl
WHERE LoanType='40-Weeks' GROUP BY CaritasBranch_ControlNo)Collected40
ON cb.ControlNo=Collected40.BranchControl
WHERE ControlNo!=1 ORDER BY BranchName"); 

$port=$getportfolio->result();
?>
	<a href="<?php echo site_url('login/homepage'); ?>"> <img src="<?php echo base_url('Assets/images/caritaslogo.png'); ?>" class="caritaslogo"></a>
	
	

	<h3>CARITAS SALVE CREDIT COOPERATIVE <br> MONTHLY LOAN PORTFOLIO REPORT <br> For The Month Of <b>
		<?php echo $monthWord ?> <?php echo $year ?></b></h3>

		<br>
	<table class="misreport" border="1" style="margin-left:auto; margin-right:auto;">
		<tr class="header">
			<td class="label" style="text-align: right;"><b>Branch:</td>
			<?php foreach($port AS $data) { ?>
				<td class="branch"><?php echo $data->BranchName; ?></td>
			<?php } ?>
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
				$totalBeg23=0;
				foreach($port AS $data){ 
					$totalBeg23+=$data->BegTotalLoan23; ?>
					<td class="number"><?php 
					if($data->BegTotalLoan23<0){
						echo "(".number_format(abs($data->BegTotalLoan23),2).")";
					}
					else
						echo number_format($data->BegTotalLoan23,2);
					?>
					</td>
				<?php } ?>
				<?php 
				if($totalBeg23<0){ ?>
					<td class="number"><b>(<?php echo number_format(abs($totalBeg23), 2); ?>)</b></td>
				<?php } else { ?>
					<td class="number"><b><?php echo number_format($totalBeg23, 2); ?></b></td>
				<?php } ?>
			</tr>
			
			<tr>
				<td class="label1">(40 weeks)</td>
				<?php 
					$totalBeg40=0;
					foreach($port AS $data){ 
						$totalBeg40+=$data->BegTotalLoan40;
						if($data->BegTotalLoan40<0){?>
							<td class="number">(<?php echo number_format(abs($data->BegTotalLoan40),2); ?>)</td>
					<?php } else { ?>
							<td class="number"><?php echo number_format($data->BegTotalLoan40,2); ?></td>
				<?php }} ?>

				<?php if($totalBeg40<0){ ?>
					<td class="number"><b>(<?php echo number_format(abs($totalBeg40), 2); ?>)</b></td>
				<?php } else { ?>
					<td class="number"><b><?php echo number_format($totalBeg40, 2); ?></b></td>
				<?php } ?>
			</tr>
			
		<tr>
			<td class="label2">Total Loan Receivable-Beg</td>
			<?php foreach($port AS $data){
				if(($data->BegTotalLoan23 + $data->BegTotalLoan40)<0){ ?>
					<td class="number"><b>(<?php echo number_format(abs($data->BegTotalLoan23 + $data->BegTotalLoan40),2); ?>)</b></td>
				<?php } else { ?>
					<td class="number"><b><?php echo number_format(($data->BegTotalLoan23 + $data->BegTotalLoan40),2); ?></b></td>
				<?php }} ?>

			<?php if(($totalBeg23+$totalBeg40) <0) { ?>
				<td class="number"><b>(<?php echo number_format(abs($totalBeg23+$totalBeg40),2); ?>)</b></td>
			<?php } else { ?>
				<td class="number"><b><?php echo number_format(($totalBeg23+$totalBeg40),2); ?></b></td>
			<?php } ?>
		</tr>

		<tr>
			<td class="label"><b>Loan Releases</b></td>
			<td colspan="15"></td>
		</tr>

		<tr>
			<td class="label1">(23 weeks)</td>
			<?php 
				$totalRelease23=0; 
				foreach($port AS $data){
					$totalRelease23+=$data->LoanReleased23; ?>
						<td class="number"><?php echo number_format($data->LoanReleased23,2); ?></td>
			<?php } ?>

			<td class="number"><b><?php echo number_format($totalRelease23,2); ?></b></td>
		</tr>
			
		<tr>
			<td class="label1">(40 weeks)</td>
			<?php
				$totalRelease40=0;
				foreach($port AS $data){
					$totalRelease40+=$data->LoanReleased40;?>
					<td class="number"><?php echo number_format($data->LoanReleased40,2); ?></td>
			<?php } ?>
			<td class="number"><b><?php echo number_format($totalRelease40,2); ?></b></td>
		</tr>
			
		<tr>
			<td class="label2">Total Loan Release</td>
			<?php foreach($port AS $data){ ?>
				<td class="number"><b><?php echo number_format(($data->LoanReleased23+$data->LoanReleased40),2); ?></b></td>
			<?php } ?>
			<td class="number"><b><?php echo number_format(($totalRelease23+$totalRelease40),2); ?></b></td>
		</tr>

		<tr>
			<td class="label"><b>Target Loan Collection</b></td>
			<td colspan="15"></td>
		</tr>
			
		<tr>
			<td class="label1">(23 weeks)</td>
			<?php 
				$totalTarget23=0;
				foreach($port AS $data){
					$totalTarget23+=$data->TotalTarget23; ?>
					<td class="number"><?php echo number_format($data->TotalTarget23,2); ?></td>
			<?php } ?>
			<td class="number"><b><?php echo number_format($totalTarget23,2); ?></b></td>
		</tr>
			
		<tr>
			<td class="label1">(40 weeks)</td>
			<?php
				$totalTarget40=0;
				foreach($port AS $data){
					$totalTarget40+=$data->TotalTarget40; ?>
					<td class="number"><?php echo number_format($data->TotalTarget40,2); ?></td>
			<?php } ?>
			<td class="number"><b><?php echo number_format($totalTarget40,2); ?></b></td>
		</tr>
			
		<tr>
			<td class="label2">Total Loan Collection</td>
			<?php foreach($port AS $data){ ?>
				<td class="number"><b><?php echo number_format(($data->TotalTarget23+$data->TotalTarget40),2); ?></b></td>
			<?php } ?>
			<td class="number"><b><?php echo number_format(($totalTarget23+$totalTarget40),2); ?></b></td>
		
		</tr>

		<tr>
			<td class="label"><b>Loan Collection</b></td>
			<td colspan="15"></td>
		</tr>

		<tr>
			<td class="label1">(23 weeks)</td>
			<?php
				$totalCollect23=0;
				foreach($port AS $data){
					$totalCollect23+=$data->Collected23; ?>
					<td class="number"><?php echo number_format($data->Collected23,2); ?></td>
				<?php } ?>
			<td class="number"><b><?php echo number_format($totalCollect23,2); ?></b></td>
		</tr>
			
		<tr>
			<td class="label1">(40 weeks)</td>
			<?php
				$totalCollect40=0;
				foreach($port AS $data){
					$totalCollect40+=$data->Collected40; ?>
					<td class="number"><?php echo number_format($data->Collected40,2); ?></td>
			<?php } ?>
			<td class="number"><b><?php echo number_format($totalCollect40,2); ?></b></td>
		</tr>
			
		<tr>
			<td class="label2">Total Loan Collection</td>
			<?php foreach($port AS $data){ ?>
				<td class="number"><b><?php echo number_format(($data->Collected23+$data->Collected40),2); ?></b></td>
			<?php } ?>
			<td class="number"><b><?php echo number_format(($totalCollect23+$totalCollect40),2); ?></b></td>
		</tr>

		<tr>
			<td class="label"><b>Loans Receivable-End</b></td>
			<td colspan="15"></td>
		</tr>

		<tr>
			<td class="label1">(23 weeks)</td>
			<?php
				$totalEnd23=0;
				foreach($port AS $data){
					$totalEnd23+=($data->BegTotalLoan23+$data->LoanReleased23-$data->Collected23); 
					if(($data->BegTotalLoan23+$data->LoanReleased23-$data->Collected23)<0) {?>
						<td class="number">(<?php echo number_format(abs($data->BegTotalLoan23+$data->LoanReleased23-$data->Collected23),2); ?>)</td>
					<?php } else { ?>
						<td class="number"><?php echo number_format(($data->BegTotalLoan23+$data->LoanReleased23-$data->Collected23),2); ?></td>
					<?php }} ?>

					<?php if($totalEnd23<0) {?>
						<td class="number"><b>(<?php echo number_format(abs($totalEnd23),2); ?>)</b></td>
					<?php } else { ?>
						<td class="number"><b><?php echo number_format($totalEnd23,2); ?></b></td>
					<?php } ?>
	
		</tr>
			
		<tr>
			<td class="label1">(40 weeks)</td>
			<?php
				$totalEnd40=0;
				foreach($port AS $data){
					$totalEnd40+=($data->BegTotalLoan40+$data->LoanReleased40-$data->Collected40); 
					if(($data->BegTotalLoan40+$data->LoanReleased40-$data->Collected40)<0) {?>
						<td class="number">(<?php echo number_format(abs($data->BegTotalLoan40+$data->LoanReleased40-$data->Collected40),2); ?>)</td>
					<?php } else { ?>
						<td class="number"><?php echo number_format(($data->BegTotalLoan40+$data->LoanReleased40-$data->Collected40),2); ?></td>
					<?php } ?>
			<?php } ?>
			<?php if ($totalEnd40<0) { ?>
				<td class="number"><b>(<?php echo number_format(abs($totalEnd40),2); ?>)</b></td>
				<?php } else { ?>
				<td class="number"><b><?php echo number_format($totalEnd40,2); ?></b></td>
				<?php } ?>
		</tr>
			
		<tr>
			<td class="label2">Total Loan Receivable-End</td>
			<?php
				foreach($port AS $data){ 
					$temp23=($data->BegTotalLoan23+$data->LoanReleased23-$data->Collected23);
					$temp40=($data->BegTotalLoan40+$data->LoanReleased40-$data->Collected40);
					if(($temp23+$temp40)<0){?>
					<td class="number"><b>(<?php echo number_format(abs($temp23+$temp40),2); ?>)</b></td>
					<?php } else {?>
						<td class="number"><b><?php echo number_format(($temp23+$temp40),2); ?></b></td>
			<?php }} ?>

			<?php if(($totalEnd23+$totalEnd40)<0) { ?>
				<td class="number"><b>(<?php echo number_format(abs($totalEnd23+$totalEnd40),2); ?>)</b></td>
				<?php } else { ?>
				<td class="number"><b><?php echo number_format(($totalEnd23+$totalEnd40),2); ?></b></td>
			<?php } ?>
		</tr>

	</table>

	<br><br><br>
		<!-- <table class="signature" style="margin-left:auto; margin-right:auto;">
			<tr>
				<td class="sigBy">Prepared by:</td>
				<td class="sig"><?php echo $user ?></td>
				<td class="sigBy"> &nbsp&nbsp&nbspDate:</td>
				<td class="sig2"><?php echo $datetoday ?></td>
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
		</table> -->

	<!--	 <table class="signature" style="margin-left:31.5%; margin-right:auto;">
		      <tr>
		        <td class="sigBy">Prepared by:</td>
		      </tr>
		      <tr>
		        <td class="sigName">Marvin Lao*</td>
		      </tr>
		      <tr>
		        <td class="sigPosition">Branch Manager*</td>
		      </tr>
		      <tr>
		        <td class="sigPosition">November 21, 2014*</td>
		      </tr>
		    </table>

		    <table class="signature" style="margin-left: 53%; margin-right:auto; margin-top: -111px;">
		      <tr>
		        <td class="sigBy">Received by:</td>
		      </tr>
		      <tr>
		        <td class="sigName">Name</td>
		      </tr>
		      <tr>
		        <td class="sigPosition"> Position</td>
		      </tr>
		      <tr>
		        <td class="sigPosition">November 21, 2014</td>
		      </tr>
		    </table> -->

		    
    <table style="margin-left: 300px;" >
      <tr>
        <td style="font-size: 13px;"><?php echo $name; ?></td>
      </tr>
        <?php if($userrank=='branchmanager'){?>
      <tr>
        <td class="BM2">Signature Above Printed Name of Branch Manager</td>
      </tr>
      <?php }else{ ?>
      <tr>
        <td class="BM2">Signature Above Printed Name of MIS</td>
      </tr>
      <?php } ?>
      <tr>
        <td style="font-size: 13px;"><?php echo $datetoday ?></td>
      </tr>
      <tr>
        
        <td class="BM2">Date</td>
      </tr>
    </table>

    <table style="margin-left: 750px; margin-top: -132px;" >
      <tr>
        <td style="font-size: 13px;">Ann Evan Echavez</td>
      </tr>
      <tr>
        <td class="BM2">Signature Above Printed Name of General Manager</td>
      </tr>
      <tr>
        <td style="font-size: 13px;"><?php echo $datetoday ?></td>
      </tr>
      <tr>
        <td class="BM2">Date</td>
      </tr>
    </table>

	<br><br>
	<div class='dontprint' style="width: 100%; text-align: center;">
		<button onclick="window.print()">Print</button> 
	</div>