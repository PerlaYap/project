
<link rel="stylesheet" type="text/css" href="<?php echo base_url('Assets/css/branchmanager.css'); ?>">
<script src="<?php echo base_url('Assets/js/general.js') ?>"></script>

<?php
$branchNo=$this->session->userdata('branchno');

$getLoanInfo =$this->db->query("SELECT Charlie.MemberControl, loanapplication_ControlNo AS LoanControl, ApplicationNumber, DateApplied, AmountRequested, loantype, concat(LastName,', ',FirstName,' ', MiddleName) AS Name ,BranchName, CenterNo, Percent, LoanCount
FROM (SELECT * FROM (SELECT * FROM loanapplication_has_members lhm RIGHT JOIN (SELECT BranchControl, CenterNo, B.CenterControl, Members_ControlNo AS MemberControl FROM (SELECT * FROM caritascenters_has_members WHERE ISNULL(DateLeft))cchm
INNER JOIN (SELECT CenterControl, BranchControl FROM (SELECT CaritasBranch_ControlNo AS BranchControl, CaritasCenters_ControlNo AS CenterControl, MAX(Date)
FROM (SELECT * FROM caritasbranch_has_caritascenters ORDER BY Date DESC)A GROUP BY CenterControl) A WHERE BranchControl='$branchNo') B ON B.CenterControl=cchm.CaritasCenters_ControlNo
LEFT JOIN CaritasCenters cc ON cc.ControlNo=cchm.CaritasCenters_ControlNo) Alpha ON Alpha.MemberControl=lhm.Members_ControlNo) Beta 
LEFT JOIN loanapplication la ON la.ControlNo=Beta.LoanApplication_ControlNo)Charlie
LEFT JOIN CaritasBranch cb ON cb.ControlNo=Charlie.BranchControl
LEFT JOIN membersname mn ON mn.ControlNo=Charlie.MemberControl
LEFT JOIN
(SELECT A.MemberControl, IFNULL(ROUND(((TotalPastDue/TotalLoanTrans)*100),2),0) AS Percent FROM
(SELECT Members_ControlNo AS MemberControl, Count(ControlNo) AS TotalLoanTrans 
FROM transaction trans WHERE (transactiontype='Past Due' OR transactiontype='Loan') GROUP BY Members_ControlNo)A
LEFT JOIN
(SELECT Members_ControlNo AS MemberControl, Count(ControlNo) AS TotalPastDue FROM transaction trans WHERE transactiontype='Past Due' GROUP BY Members_ControlNo) B
ON A.MemberControl=B.MemberControl)Delta ON Charlie.MemberControl=Delta.MemberControl
LEFT JOIN 
(SELECT Members_ControlNo AS MemberControl, Count(loanapplication_ControlNo) AS LoanCount FROM loanapplication_has_members lhm INNER JOIN loanapplication la ON lhm.LoanApplication_ControlNo=la.ControlNo 
WHERE Status='Full Payment' GROUP BY Members_ControlNo) Echo ON Echo.MemberControl=Charlie.MemberControl
WHERE Status='Pending' ORDER BY LoanCount, Percent");
 ?> 
 
<?php
$getLoanDates =$this->db->query("SELECT DateApplied FROM (SELECT loanapplication_ControlNo AS LoanControl FROM loanapplication_has_members lhm RIGHT JOIN (SELECT BranchControl, CenterNo, B.CenterControl, Members_ControlNo AS MemberControl FROM (SELECT * FROM caritascenters_has_members WHERE ISNULL(DateLeft))cchm
INNER JOIN (SELECT CenterControl, BranchControl FROM (SELECT CaritasBranch_ControlNo AS BranchControl, CaritasCenters_ControlNo AS CenterControl, MAX(Date)
FROM (SELECT * FROM caritasbranch_has_caritascenters ORDER BY Date DESC)A GROUP BY CenterControl) A WHERE BranchControl='$branchNo') B ON B.CenterControl=cchm.CaritasCenters_ControlNo
LEFT JOIN CaritasCenters cc ON cc.ControlNo=cchm.CaritasCenters_ControlNo) Alpha ON Alpha.MemberControl=lhm.Members_ControlNo)Beta
LEFT JOIN LoanApplication la ON la.ControlNo=Beta.LoanControl
WHERE STATUS='Pending' GROUP BY DateApplied");
 ?>

		<script type="text/javascript">

			function send(control_no){
				window.location.href= "forloanapprovals?name="+ control_no;
			}

		</script>
		
	


		<div class="content3">
			<br>
			<h1>Loan Application(s) For Approval</h1>
			<br>
			<?php if (!empty($getLoanInfo->result())) { ?>
				

			<?php foreach ($getLoanDates->result() as $date) { ?>
			<div class="subheadername"><?php echo $date->DateApplied; ?></div>
			<div class="shadow"></div>
			<div class="subskew"></div>

			<div class="grid grid-pad">

					


					<?php foreach ($getLoanInfo->result() as $result) {?>
						<?php if($result->DateApplied == $date->DateApplied) { ?>
						<div class="col-1-4">

									<div class="content1">
										<div class="red-accent"></div>
										<?php
											if($result->Percent<20){
												?>
												<img src="<?php echo base_url('Assets/images/star.png'); ?>" class="star">
												<?php } ?>		
										<br>

										<p class="col-name"><?php echo $result->Name; ?></p>
										<p class="col-branch"><b>Application No. :</b> <?php echo $result->ApplicationNumber; ?></p>
										<p class="col-branch"><b>Amount:</b> <?php echo $result->AmountRequested; ?> Php</p>
										<p class="col-branch"> <b><?php echo $result->loantype; ?></b></p>
										<a href="javascript:void(0)" onclick="send('<?php echo $result->LoanControl ?>')"class='col-button1'>View Application </a>
										<br><br><br><br><br><br><br>
									</div>
						</div> 
						<?php } ?>
								
					<?php } ?> 
				
				
				
				
				</div>
				<?php } ?> 
	<?php } else { ?>

	<p class="noresultfound"><br>- No Pending Loan Application/s - <br><br> </p>
	<?php } ?>

			</div>

			
		</div>
		<br><br>
