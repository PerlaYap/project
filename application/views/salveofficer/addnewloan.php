<?php 
$branchno = $this->session->userdata('branchno');
date_default_timezone_set('Asia/Manila');

$getmemberid=$this->db->query("SELECT MemberID, concat(LastName,', ',FirstName,' ', MiddleName) AS Name FROM (SELECT MemberControl FROM (SELECT mhms.ControlNo
FROM members_has_membersmembershipstatus mhms
INNER JOIN ( SELECT MAX(DateUpdated) as LatestDate, ControlNo
FROM members_has_membersmembershipstatus GROUP BY ControlNo) C
ON mhms.ControlNo=C.ControlNo AND mhms.DateUpdated=C.LatestDate
WHERE Status!='Terminated') D
INNER JOIN
(SELECT Members_ControlNo AS MemberControl FROM caritascenters_has_members cchm
INNER JOIN (SELECT CenterControl FROM (SELECT CaritasBranch_ControlNo AS BranchControl, CaritasCenters_ControlNo AS CenterControl, MAX(Date)
FROM (SELECT * FROM caritasbranch_has_caritascenters ORDER BY Date DESC)A GROUP BY CenterControl) A WHERE BranchControl='$branchno') B ON B.CenterControl=cchm.CaritasCenters_ControlNo
WHERE ISNULL(DateLeft)) E ON E.MemberControl=D.ControlNo) Alpha
LEFT JOIN 
(SELECT LoanControl, Members_ControlNo AS MemberControl, DateApplied, Status
FROM loanapplication_has_members lhm INNER JOIN (SELECT ControlNo AS LoanControl, DateApplied, Status FROM loanapplication la ORDER BY DateApplied DESC, LoanControl DESC)A ON A.LoanControl=lhm.LoanApplication_ControlNo
GROUP BY MemberControl) Beta
ON Alpha.MemberControl=Beta.MemberControl
LEFT JOIN MembersName mn ON mn.ControlNo=Alpha.MemberControl
LEFT JOIN Members mem ON mem.ControlNo=Alpha.MemberControl
WHERE ISNULL(Status) OR Status='Full Payment' OR Status='Rejected' ORDER BY MemberID ASC");
?>
			<link rel="stylesheet" type="text/css" href="<?php echo base_url('Assets/css/salveofficer.css'); ?>">
			<script src="<?php echo base_url('Assets/js/salveofficer.js'); ?>"></script>
		
			<div class="content">
				<br>
				<form action="addnewloanprocess" method="post" name="addnewloanprocess" class="basic-grey">
					<h1>New Loan Application
				        <span>Please fill all the texts in the fields.</span>
				    </h1>

				    <label>
				        <span>Member ID :</span></label>
				        <select required="true" name='memberid' style="width: 260px;" >
				        	<option></option>
				        	<?php foreach ($getmemberid->result() as $memid) {
				        		echo '<option value="'.$memid->MemberID.'">'.$memid->MemberID.'|'.$memid->Name.'</option>';
				        	 } ?>
				        	
				        </select>
				        <span>Loan Date :</span></label>
				        <select required="true" name="month" style="width:80px;">
						        <option></option>

			<?php $currentmonth = date('F', strtotime("now"));
					$i=0;
					if ($currentmonth =='January') {
						$i=12;
					}elseif ($currentmonth =='February') {
						$i=11;
					}elseif ($currentmonth =='March') {
						$i=10;
					}elseif ($currentmonth =='April') {
						$i=9;
					}elseif ($currentmonth == 'May') {
						$i=8;
					}elseif ($currentmonth =='June') {
						$i=7;
					}elseif ($currentmonth =='July') {
						$i=6;
					}elseif ($currentmonth == 'August') {
						$i=5;
					}elseif ($currentmonth =='September') {
						$i=4;
					}elseif ($currentmonth =='October') {
						$i=3;
					}elseif ($currentmonth =='November') {
						$i =2;
					}elseif ($currentmonth =='December') {
						$i =1;
					}


					for ($m=0; $m < $i ; $m++) { ?>

				<option value="<?php  echo date('n', strtotime("+ $m month")); ?>"><?php  echo date('F', strtotime("+ $m month")); ?></option>


			<?php } ?>

					        </select>

					        <select required="true" name="day" style="width:50px;">
						        <option></option>
						        <?php  for ($i=1; $i < 32 ; $i++) { ?>
							        <?php if ($i<10) { ?>
							        <option value="<?php echo '0'.$i ?>"><?php echo '0'.$i ?></option>		
							       	<?php } else{ ?>
							       	<option value="<?php echo $i ?>"><?php echo $i ?></option>
							      	<?php } ?>
						      <?php  } ?>
					        </select>

					        <select required="true" name="year" style="width:80px;">
						        
						       
						  
						        <?php  $yend =date('Y');
						        		$ystart = date('Y')-1;
						       // for ($y=$ystart; $y <=$yend; $y++) { ?>
							       <option value="<?php echo $yend ?>"><?php echo $yend ?></option>
						        <?php // } ?>
					        </select>
				    
				    <br>
				     <label>
				        <span></span>
				        <input type="submit" class="button" value="Next" />
				        <!------GO TO addnewloan2.php" ------>
				        
				    </label>  
				</form>
				<br><Br>
		</div>
		