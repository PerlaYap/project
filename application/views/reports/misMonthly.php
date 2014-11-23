<title>MONTHLY ACCOUNT REPORT</title>


<style type="text/css" media="print">
.dontprint{
	display: none;
}
</style>

<link rel="stylesheet" type="text/css" href="<?php echo base_url('Assets/css/reports.css'); ?>">
	
<?php
$user = $this->session->userdata('firstname');
$today = date('F d, Y');
	$userrank = $this->session->userdata('rank');
	$name = $this->session->userdata('firstname');
	 $datetoday = date('F d, Y');

$misAccount =$this->db->query("SELECT ControlNo AS BranchControl, BranchName, IFNULL(NoMembers,0) AS BegMembers, IFNULL(NewMembers,0) AS NewMembers, IFNULL(TerminatedMembers,0) AS TerminatedMembers,
IFNULL(ActiveMembers,0) AS ActiveMembers, IFNULL(TotalDormant,0) AS TotalDormant, IFNULL(TotalDanger,0) AS TotalPastDue,
IFNULL(LoanNo23,0) AS ActiveLoans23, IFNULL(LoanNo40,0) AS ActiveLoan40, IFNULL(FinishLoans,0) AS FinishedLoans, IFNULL(SaverNo,0) AS NoSavers, IFNULL(CenterCount,0) AS CenterCount
FROM caritasbranch cb
LEFT JOIN
(SELECT BranchControl, COUNT(MembersControl) AS NoMembers 
FROM (SELECT A.ControlNo AS MembersControl, C.Status
FROM (SELECT ControlNo FROM members_has_membersmembershipstatus GROUP BY ControlNo ORDER BY ControlNo)A
LEFT JOIN
(SELECT * FROM (SELECT * FROM members_has_membersmembershipstatus mhms 
WHERE DateUpdated<=LAST_DAY(DATE_ADD('$datetoday', INTERVAL -1 MONTH)) ORDER BY DateUpdated DESC)B GROUP BY ControlNo)C
ON A.ControlNo=C.ControlNo)Alpha
LEFT JOIN
(SELECT Members_ControlNo, BranchControl
FROM (SELECT cchm.Members_ControlNo, A.CaritasCenters_ControlNo,A.DateEntered FROM CaritasCenters_has_Members cchm
LEFT JOIN
(SELECT * FROM CaritasCenters_has_Members WHERE DateEntered<=LAST_DAY(DATE_ADD('$datetoday', INTERVAL -1 MONTH)) ORDER BY DateEntered DESC)A
ON A.Members_ControlNo=cchm.Members_ControlNo GROUP BY Members_ControlNo)Alpha
LEFT JOIN (SELECT CenterControl, BranchControl, BranchName FROM 
(SELECT cbhcc.CaritasCenters_ControlNo AS CenterControl, A.CaritasBranch_ControlNo AS BranchControl 
FROM caritasbranch_has_caritascenters cbhcc
LEFT JOIN (SELECT * FROM caritasbranch_has_caritascenters 
WHERE Date<=LAST_DAY(DATE_ADD('$datetoday', INTERVAL -1 MONTH)) ORDER BY Date)A
ON cbhcc.CaritasCenters_ControlNo=A.CaritasCenters_ControlNo GROUP BY A.CaritasCenters_ControlNo)B
LEFT JOIN CaritasBranch cb ON B.BranchControl=cb.ControlNo)Beta
ON Alpha.CaritasCenters_ControlNo=Beta.CenterControl) Beta
ON Alpha.MembersControl=Beta.Members_ControlNo WHERE (Status!='Terminated' AND Status!='Terminated Voluntarily') GROUP BY BranchControl)Alpha
ON cb.ControlNo=Alpha.BranchControl
LEFT JOIN
(SELECT BranchControl, COUNT(MembersControl) AS NewMembers 
FROM (SELECT A.ControlNo AS MembersControl, C.Status
FROM (SELECT ControlNo FROM members_has_membersmembershipstatus GROUP BY ControlNo ORDER BY ControlNo)A
LEFT JOIN
(SELECT * FROM (SELECT * FROM members_has_membersmembershipstatus mhms 
WHERE (MONTH(DateUpdated)='11' AND YEAR(DateUpdated)='2014') AND Status='Active' ORDER BY DateUpdated DESC)B GROUP BY ControlNo)C
ON A.ControlNo=C.ControlNo)Alpha
LEFT JOIN
(SELECT Members_ControlNo, BranchControl
FROM (SELECT cchm.Members_ControlNo, A.CaritasCenters_ControlNo,A.DateEntered FROM CaritasCenters_has_Members cchm
LEFT JOIN
(SELECT * FROM CaritasCenters_has_Members WHERE DateEntered<=LAST_DAY(DATE_ADD('$datetoday', INTERVAL 0 MONTH)) ORDER BY DateEntered DESC)A
ON A.Members_ControlNo=cchm.Members_ControlNo GROUP BY Members_ControlNo)Alpha
LEFT JOIN (SELECT CenterControl, BranchControl, BranchName FROM 
(SELECT cbhcc.CaritasCenters_ControlNo AS CenterControl, A.CaritasBranch_ControlNo AS BranchControl 
FROM caritasbranch_has_caritascenters cbhcc
LEFT JOIN (SELECT * FROM caritasbranch_has_caritascenters 
WHERE Date<=LAST_DAY(DATE_ADD('$datetoday', INTERVAL 0 MONTH)) ORDER BY Date)A
ON cbhcc.CaritasCenters_ControlNo=A.CaritasCenters_ControlNo GROUP BY A.CaritasCenters_ControlNo)B
LEFT JOIN CaritasBranch cb ON B.BranchControl=cb.ControlNo)Beta
ON Alpha.CaritasCenters_ControlNo=Beta.CenterControl) Beta
ON Alpha.MembersControl=Beta.Members_ControlNo WHERE (Status!='Terminated' AND Status!='Terminated Voluntarily') GROUP BY BranchControl) Beta
ON Beta.BranchControl=cb.ControlNo
LEFT JOIN
(SELECT BranchControl, COUNT(MembersControl) AS TerminatedMembers 
FROM (SELECT A.ControlNo AS MembersControl, C.Status
FROM (SELECT ControlNo FROM members_has_membersmembershipstatus GROUP BY ControlNo ORDER BY ControlNo)A
LEFT JOIN
(SELECT * FROM (SELECT * FROM members_has_membersmembershipstatus mhms 
WHERE (MONTH(DateUpdated)='11' AND YEAR(DateUpdated)='2014') AND (Status='Terminated' OR Status='Terminated Voluntarily') ORDER BY DateUpdated DESC)B GROUP BY ControlNo)C
ON A.ControlNo=C.ControlNo)Alpha
LEFT JOIN
(SELECT Members_ControlNo, BranchControl
FROM (SELECT cchm.Members_ControlNo, A.CaritasCenters_ControlNo,A.DateEntered FROM CaritasCenters_has_Members cchm
LEFT JOIN
(SELECT * FROM CaritasCenters_has_Members WHERE DateEntered<=LAST_DAY(DATE_ADD('$datetoday', INTERVAL 0 MONTH)) ORDER BY DateEntered DESC)A
ON A.Members_ControlNo=cchm.Members_ControlNo GROUP BY Members_ControlNo)Alpha
LEFT JOIN (SELECT CenterControl, BranchControl, BranchName FROM 
(SELECT cbhcc.CaritasCenters_ControlNo AS CenterControl, A.CaritasBranch_ControlNo AS BranchControl 
FROM caritasbranch_has_caritascenters cbhcc
LEFT JOIN (SELECT * FROM caritasbranch_has_caritascenters 
WHERE Date<=LAST_DAY(DATE_ADD('$datetoday', INTERVAL 0 MONTH)) ORDER BY Date)A
ON cbhcc.CaritasCenters_ControlNo=A.CaritasCenters_ControlNo GROUP BY A.CaritasCenters_ControlNo)B
LEFT JOIN CaritasBranch cb ON B.BranchControl=cb.ControlNo)Beta
ON Alpha.CaritasCenters_ControlNo=Beta.CenterControl) Beta
ON Alpha.MembersControl=Beta.Members_ControlNo WHERE Alpha.Status IS NOT NULL GROUP BY BranchControl) Charlie
ON Charlie.BranchControl=cb.ControlNo
LEFT JOIN
(SELECT BranchControl, COUNT(MembersControl) AS ActiveMembers 
FROM (SELECT A.ControlNo AS MembersControl, C.Status
FROM (SELECT ControlNo FROM members_has_membersmembershipstatus GROUP BY ControlNo ORDER BY ControlNo)A
LEFT JOIN
(SELECT * FROM (SELECT * FROM members_has_membersmembershipstatus mhms 
WHERE DateUpdated<=LAST_DAY(DATE_ADD('$datetoday', INTERVAL 0 MONTH)) ORDER BY DateUpdated DESC)B GROUP BY ControlNo)C
ON A.ControlNo=C.ControlNo)Alpha
LEFT JOIN
(SELECT Members_ControlNo, BranchControl
FROM (SELECT cchm.Members_ControlNo, A.CaritasCenters_ControlNo,A.DateEntered FROM CaritasCenters_has_Members cchm
LEFT JOIN
(SELECT * FROM CaritasCenters_has_Members WHERE DateEntered<=LAST_DAY(DATE_ADD('$datetoday', INTERVAL 0 MONTH)) ORDER BY DateEntered DESC)A
ON A.Members_ControlNo=cchm.Members_ControlNo GROUP BY Members_ControlNo)Alpha
LEFT JOIN (SELECT CenterControl, BranchControl, BranchName FROM 
(SELECT cbhcc.CaritasCenters_ControlNo AS CenterControl, A.CaritasBranch_ControlNo AS BranchControl 
FROM caritasbranch_has_caritascenters cbhcc
LEFT JOIN (SELECT * FROM caritasbranch_has_caritascenters 
WHERE Date<=LAST_DAY(DATE_ADD('$datetoday', INTERVAL 0 MONTH)) ORDER BY Date)A
ON cbhcc.CaritasCenters_ControlNo=A.CaritasCenters_ControlNo GROUP BY A.CaritasCenters_ControlNo)B
LEFT JOIN CaritasBranch cb ON B.BranchControl=cb.ControlNo)Beta
ON Alpha.CaritasCenters_ControlNo=Beta.CenterControl) Beta
ON Alpha.MembersControl=Beta.Members_ControlNo WHERE Alpha.Status IS NOT NULL AND (Status='Active Saver' OR Status='Active' OR Status='Borrower') 
GROUP BY BranchControl) Delta
ON Delta.BranchControl=cb.ControlNo
LEFT JOIN
(SELECT BranchControl, COUNT(MembersControl) AS TotalDormant 
FROM (SELECT A.ControlNo AS MembersControl, C.Status
FROM (SELECT ControlNo FROM members_has_membersmembershipstatus GROUP BY ControlNo ORDER BY ControlNo)A
LEFT JOIN
(SELECT * FROM (SELECT * FROM members_has_membersmembershipstatus mhms 
WHERE DateUpdated<=LAST_DAY(DATE_ADD('$datetoday', INTERVAL 0 MONTH)) ORDER BY DateUpdated DESC)B GROUP BY ControlNo)C
ON A.ControlNo=C.ControlNo)Alpha
LEFT JOIN
(SELECT Members_ControlNo, BranchControl
FROM (SELECT cchm.Members_ControlNo, A.CaritasCenters_ControlNo,A.DateEntered FROM CaritasCenters_has_Members cchm
LEFT JOIN
(SELECT * FROM CaritasCenters_has_Members WHERE DateEntered<=LAST_DAY(DATE_ADD('$datetoday', INTERVAL 0 MONTH)) ORDER BY DateEntered DESC)A
ON A.Members_ControlNo=cchm.Members_ControlNo GROUP BY Members_ControlNo)Alpha
LEFT JOIN (SELECT CenterControl, BranchControl, BranchName FROM 
(SELECT cbhcc.CaritasCenters_ControlNo AS CenterControl, A.CaritasBranch_ControlNo AS BranchControl 
FROM caritasbranch_has_caritascenters cbhcc
LEFT JOIN (SELECT * FROM caritasbranch_has_caritascenters 
WHERE Date<=LAST_DAY(DATE_ADD('$datetoday', INTERVAL 0 MONTH)) ORDER BY Date)A
ON cbhcc.CaritasCenters_ControlNo=A.CaritasCenters_ControlNo GROUP BY A.CaritasCenters_ControlNo)B
LEFT JOIN CaritasBranch cb ON B.BranchControl=cb.ControlNo)Beta
ON Alpha.CaritasCenters_ControlNo=Beta.CenterControl) Beta
ON Alpha.MembersControl=Beta.Members_ControlNo WHERE Alpha.Status IS NOT NULL AND (Alpha.Status='dormant saver')
GROUP BY BranchControl) Echo
ON Echo.BranchControl=cb.ControlNo
LEFT JOIN
(SELECT COUNT(ControlNo) AS LoanNo23, CaritasBranch_ControlNo AS BranchControl
FROM (SELECT ControlNo, Status
FROM LoanApplication
WHERE Status!='Pending' AND Status!='Rejected' AND LoanType='23-Weeks' AND DateApplied<=LAST_DAY(DATE_ADD('$datetoday', INTERVAL 0 MONTH)))Alpha
LEFT JOIN
(SELECT LoanApplication_ControlNo, CaritasBranch_ControlNo 
FROM loanapplication_has_members) Beta
ON Alpha.ControlNo=Beta.LoanApplication_ControlNo GROUP BY CaritasBranch_ControlNo)Foxtrot
ON cb.ControlNo=Foxtrot.BranchControl
LEFT JOIN
(SELECT COUNT(ControlNo) AS LoanNo40, CaritasBranch_ControlNo AS BranchControl
FROM (SELECT ControlNo, Status
FROM LoanApplication
WHERE Status!='Pending' AND Status!='Rejected' AND LoanType='40-Weeks' AND DateApplied<=LAST_DAY(DATE_ADD('$datetoday', INTERVAL 0 MONTH)))Alpha
LEFT JOIN
(SELECT LoanApplication_ControlNo, CaritasBranch_ControlNo 
FROM loanapplication_has_members) Beta
ON Alpha.ControlNo=Beta.LoanApplication_ControlNo GROUP BY CaritasBranch_ControlNo)Golf
ON cb.ControlNo=Golf.BranchControl
LEFT JOIN
(SELECT COUNT(ControlNo) AS FinishLoans, BranchControl
FROM (SELECT ControlNo, CaritasBranch_ControlNo AS BranchControl
FROM (SELECT ControlNo, DateTime FROM
(SELECT ControlNo FROM LoanApplication WHERE Status='Full Payment')Alpha
LEFT JOIN
(SELECT LoanAppControlNo AS LoanControl, DateTime
FROM (SELECT LoanAppControlNo, DateTime, TransactionType 
FROM Transaction WHERE TransactionType='Loan' ORDER BY LoanAppControlNo ASC, DateTime DESC)A
GROUP BY LoanAppControlNo)Beta
ON Alpha.ControlNo=Beta.LoanControl)Alpha
LEFT JOIN
(SELECT LoanApplication_ControlNo, CaritasBranch_ControlNo FROM loanapplication_has_members)Beta
ON Alpha.ControlNo=Beta.LoanApplication_ControlNo
WHERE MONTH(DateTime)='11' AND YEAR(DateTime)='2014')Alpha
GROUP BY BranchControl)Hotel
ON cb.ControlNo=Hotel.BranchControl
LEFT JOIN
(SELECT BranchControl, COUNT(MembersControl) AS TotalDanger 
FROM (SELECT A.ControlNo AS MembersControl, C.Status
FROM (SELECT ControlNo FROM members_has_membersmembershipstatus GROUP BY ControlNo ORDER BY ControlNo)A
LEFT JOIN
(SELECT * FROM (SELECT * FROM members_has_membersmembershipstatus mhms 
WHERE DateUpdated<=LAST_DAY(DATE_ADD('$datetoday', INTERVAL 0 MONTH)) ORDER BY DateUpdated DESC)B GROUP BY ControlNo)C
ON A.ControlNo=C.ControlNo)Alpha
LEFT JOIN
(SELECT Members_ControlNo, BranchControl
FROM (SELECT cchm.Members_ControlNo, A.CaritasCenters_ControlNo,A.DateEntered FROM CaritasCenters_has_Members cchm
LEFT JOIN
(SELECT * FROM CaritasCenters_has_Members WHERE DateEntered<=LAST_DAY(DATE_ADD('$datetoday', INTERVAL 0 MONTH)) ORDER BY DateEntered DESC)A
ON A.Members_ControlNo=cchm.Members_ControlNo GROUP BY Members_ControlNo)Alpha
LEFT JOIN (SELECT CenterControl, BranchControl, BranchName FROM 
(SELECT cbhcc.CaritasCenters_ControlNo AS CenterControl, A.CaritasBranch_ControlNo AS BranchControl 
FROM caritasbranch_has_caritascenters cbhcc
LEFT JOIN (SELECT * FROM caritasbranch_has_caritascenters 
WHERE Date<=LAST_DAY(DATE_ADD('$datetoday', INTERVAL 0 MONTH)) ORDER BY Date)A
ON cbhcc.CaritasCenters_ControlNo=A.CaritasCenters_ControlNo GROUP BY A.CaritasCenters_ControlNo)B
LEFT JOIN CaritasBranch cb ON B.BranchControl=cb.ControlNo)Beta
ON Alpha.CaritasCenters_ControlNo=Beta.CenterControl) Beta
ON Alpha.MembersControl=Beta.Members_ControlNo WHERE Alpha.Status IS NOT NULL AND (Alpha.Status='Past Due')
GROUP BY BranchControl) India
ON India.BranchControl=cb.ControlNo
LEFT JOIN
(SELECT BranchControl, COUNT(MembersControl) AS SaverNo 
FROM (SELECT A.ControlNo AS MembersControl, C.Status
FROM (SELECT ControlNo FROM members_has_membersmembershipstatus GROUP BY ControlNo ORDER BY ControlNo)A
LEFT JOIN
(SELECT * FROM (SELECT * FROM members_has_membersmembershipstatus mhms 
WHERE DateUpdated<=LAST_DAY(DATE_ADD('$datetoday', INTERVAL 0 MONTH)) ORDER BY DateUpdated DESC)B GROUP BY ControlNo)C
ON A.ControlNo=C.ControlNo)Alpha
LEFT JOIN
(SELECT Members_ControlNo, BranchControl
FROM (SELECT cchm.Members_ControlNo, A.CaritasCenters_ControlNo,A.DateEntered FROM CaritasCenters_has_Members cchm
LEFT JOIN
(SELECT * FROM CaritasCenters_has_Members WHERE DateEntered<=LAST_DAY(DATE_ADD('$datetoday', INTERVAL 0 MONTH)) ORDER BY DateEntered DESC)A
ON A.Members_ControlNo=cchm.Members_ControlNo GROUP BY Members_ControlNo)Alpha
LEFT JOIN (SELECT CenterControl, BranchControl, BranchName FROM 
(SELECT cbhcc.CaritasCenters_ControlNo AS CenterControl, A.CaritasBranch_ControlNo AS BranchControl 
FROM caritasbranch_has_caritascenters cbhcc
LEFT JOIN (SELECT * FROM caritasbranch_has_caritascenters 
WHERE Date<=LAST_DAY(DATE_ADD('$datetoday', INTERVAL 0 MONTH)) ORDER BY Date)A
ON cbhcc.CaritasCenters_ControlNo=A.CaritasCenters_ControlNo GROUP BY A.CaritasCenters_ControlNo)B
LEFT JOIN CaritasBranch cb ON B.BranchControl=cb.ControlNo)Beta
ON Alpha.CaritasCenters_ControlNo=Beta.CenterControl) Beta
ON Alpha.MembersControl=Beta.Members_ControlNo WHERE Alpha.Status IS NOT NULL AND (Status='Active Saver') 
GROUP BY BranchControl) Juliet
ON Juliet.BranchControl=cb.ControlNo
LEFT JOIN
(SELECT COUNT(A.CenterControl) AS CenterCount, CaritasBranch_ControlNo AS BranchControl 
FROM (SELECT CaritasCenters_ControlNo AS CenterControl 
FROM caritasbranch_has_caritascenters cbhcc GROUP BY CaritasCenters_ControlNo)A
LEFT JOIN (SELECT * FROM (SELECT * FROM caritasbranch_has_caritascenters 
WHERE Date<=LAST_DAY(DATE_ADD('$datetoday', INTERVAL 0 MONTH)) 
ORDER BY CaritasCenters_ControlNo ASC, Date DESC)A GROUP BY CaritasCenters_ControlNo)B
ON A.CenterControl=B.CaritasCenters_ControlNo GROUP BY CaritasBranch_ControlNo) Kilo
ON Kilo.BranchControl=cb.ControlNo WHERE cb.ControlNo!='1' ORDER BY BranchName ASC")
?>

	<a href="<?php echo site_url('login/homepage'); ?>"> <img src="<?php echo base_url('Assets/images/caritaslogo.png'); ?>" class="caritaslogo"></a>
	
	<!-- <img src="<?php // echo base_url ('Assets/images/caritaslogo.png'); ?>" class="caritaslogo"> -->
	<h3>CARITAS SALVE CREDIT COOPERATIVE <br> MONTHLY ACCOUNT REPORT <br> For The Month Of <b>
		<?php echo $monthWord ?> <?php echo $year ?></b></h3>

	<br>
	<table class="misreport" border="1" style="margin-left:auto; margin-right:auto;">

		<tr class="header">
			<td class="label"><b>Branch:</td>
			<?php
				foreach($misAccount->result() as $data){
					echo '<td class="branch">'.$data->BranchName.'</td>';
				}
			?>
			<td class="branch">Total</td>
		</tr>

		<tr>
			<td class="label"><b>OUTREACH</b></td>
			<td colspan="15"> </td>
		</tr>

		<tr>
			<td class="label">Beginning</td>
			<?php
				$total1=0;

				foreach($misAccount->result() as $data1){
					$total1+=$data1->BegMembers;
					echo '<td class="number">'.$data1->BegMembers.'</td>';
				}

				echo '<td class="number"><b>'.$total1.'</b></td>';
			?>
		</tr>

		<tr>
			<td class="label">New</td>
			<?php
				$total2=0;

				foreach($misAccount->result() as $data1){
					$total2+=$data1->NewMembers;
					echo '<td class="number">'.$data1->NewMembers.'</td>';
				}

				echo '<td class="number"><b>'.$total2.'</b></td>';
			?>
		</tr>

		<tr>
			<td class="label">Drop-out</td>
			<?php
				$total3=0;

				foreach($misAccount->result() as $data1){
					$total3+=$data1->TerminatedMembers;
					echo '<td class="number">('.$data1->TerminatedMembers.')</td>';
				}

				echo '<td class="number"><b>('.$total3.')</b></td>';
			?>
		</tr>

		<tr>
			<td class="label">Total Outreach</td>
			<?php
				foreach($misAccount->result() as $data1){
					$temp=0;
					$temp=$data1->BegMembers+$data1->NewMembers-$data1->TerminatedMembers;
					echo '<td class="number"><b>'.$temp.'</b></td>';
				}

				echo '<td class="number"><strong>'.($total1+$total2-$total3).'</strong></td>';
			?>
		</tr>

		<tr>
			<td class="label"><b>Members Breakdown</b></td>
			<td colspan="15"> </td>
		</tr>

		<tr>
			<td class="label">Active Members</td>
			<?php
				$total4=0;

				foreach($misAccount->result() as $data1){
					$total4+=$data1->ActiveMembers;
					echo '<td class="number">'.$data1->ActiveMembers.'</td>';
				}

				echo '<td class="number"><b>'.$total4.'</b></td>';
			?>
		</tr>

		<tr>
			<td class="label">Dormant Members</td>
			<?php
				$total5=0;

				foreach($misAccount->result() as $data1){
					$total5+=$data1->TotalDormant;
					echo '<td class="number">'.$data1->TotalDormant.'</td>';
				}

				echo '<td class="number"><b>'.$total5.'</b></td>';
			?>
		</tr>

		<tr>
			<td class="label">Past Due Members</td>
			<?php
				$total6=0;

				foreach($misAccount->result() as $data1){
					$total6+=$data1->TotalPastDue;
					echo '<td class="number">'.$data1->TotalPastDue.'</td>';
				}

				echo '<td class="number"><b>'.$total6.'</b></td>';
			?>
		</tr>

		<tr>
			<td class="label"><b>No. of Borrower</b></td>
			<td colspan="15"></td>
		</tr>

			<tr>
				<td class="label">&nbsp&nbsp&nbsp (23 weeks)</td>
				<?php
				$total7=0;

				foreach($misAccount->result() as $data1){
					$total7+=$data1->ActiveLoans23;
					echo '<td class="number">'.$data1->ActiveLoans23.'</td>';
				}

				echo '<td class="number"><b>'.$total7.'</b></td>';
			?>
			</tr>

			

			<tr>
			<td class="label">&nbsp&nbsp&nbsp (40 weeks)</td>
			<?php
				$total8=0;

				foreach($misAccount->result() as $data1){
					$total8+=$data1->ActiveLoan40;
					echo '<td class="number">'.$data1->ActiveLoan40.'</td>';
				}

				echo '<td class="number"><b>'.$total8.'</b></td>';
			?>
		</tr>

		<tr>
			<td class="label">Total No. of Borrowers</td>
			<?php
				foreach($misAccount->result() as $data1){
					$temp1=0;
					$temp1+=$data1->ActiveLoans23+$data1->ActiveLoan40;
					echo '<td class="number"><b>'.$temp1.'</b></td>';
				}

				echo '<td class="number"><b>'.($total7+$total8).'</b></td>';
			?>
		</tr>

		<tr>
			<td class="label"><b>Others</b></td>
			<td colspan="15"></td>
		</tr>

		<tr>
			<td class="label">No. of Savers</td>
			<?php
				$total9=0;

				foreach($misAccount->result() as $data1){
					$total9+=$data1->NoSavers;
					echo '<td class="number">'.$data1->NoSavers.'</td>';
				}

				echo '<td class="number"><b>'.$total9.'</b></td>';
			?>
		</tr>

		<tr>
			<td class="label">No. of Centers</td>
			<?php
				$total10=0;

				foreach($misAccount->result() as $data1){
					$total10+=$data1->CenterCount;
					echo '<td class="number">'.$data1->CenterCount.'</td>';
				}

				echo '<td class="number"><b>'.$total10.'</b></td>';
			?>
		</tr>
		
	</table>

	<br><br>
		<!-- <table class="signature" style="margin-left:auto; margin-right:auto;">
			<tr>
				<td class="sigBy">Prepared by:</td>
				<td class="sig">&nbsp<?php echo $user; ?></td>
				<td class="sigBy"> &nbsp&nbsp&nbspDate:</td>
				<td class="sig2">&nbsp<?php echo $today; ?></td>
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
		    </table>
	-->

	<table style="margin-left: 140px;" >
      <tr>
        <td class="BM1" style="font-size: 13px;"><?php echo $name; ?></td>
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
        <td class="BM1" style="font-size: 13px;"><?php echo $datetoday ?></td>
      </tr>
      <tr>
        
        <td class="BM2">Date</td>
      </tr>
    </table>

    <table style="margin-left: 600px; margin-top: -207px;" >
      <tr>
        <td class="BM1" style="font-size: 13px;">Ann Evan Echavez</td>
      </tr>
      <tr>
        <td class="BM2">Signature Above Printed Name of General Manager</td>
      </tr>
      <tr>
        <td class="BM1" style="font-size: 13px;"><?php echo $datetoday ?></td>
      </tr>
      <tr>
        <td class="BM2">Date</td>
      </tr>
    </table>
	
	<br><br>
	<div class='dontprint' style="width: 100%; text-align: center;">
		<button onclick="window.print()">Print</button> 
	</div>
