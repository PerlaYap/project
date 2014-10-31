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
WHERE ISNULL(Status) OR Status='Full Payment' OR Status='Rejected' ORDER BY LastName, FirstName ASC");
?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('Assets/css/salveofficer.css'); ?>">
<script src="<?php echo base_url('Assets/js/salveofficer.js'); ?>"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/blitzer/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
<link rel="stylesheet" href="/resources/demos/style.css">

<script>
$(function() {
	$( "#datepicker" ).datepicker({
      changeMonth: true,
      changeYear: true
    });
	$( "#datepicker" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
});
</script>

<div class="content">
	<br>
	<form action="addnewloanprocess" method="post" name="addnewloanprocess" class="basic-grey">
		<h1>New Loan Application
			<span>Please fill all the texts in the fields.</span>
		</h1>

		<label>
			<span>Member:</span></label>
			<select required="true" name='memberid' style="width: 260px;" >
				<option></option>
				<?php foreach ($getmemberid->result() as $memid) {
					echo '<option value="'.$memid->MemberID.'">'.$memid->Name.'</option>';
				} ?>
				
			</select>
			<span>Loan Date :</span></label>
				<input type="text" id="datepicker" style="width:210px;" name="loandate">

							<br>
							<label>
								<span></span>
								<input type="submit" class="button" value="Next" />
								<!------GO TO addnewloan2.php" ------>

							</label>  
						</form>
						<br><Br>
					</div>

					




	
	<div style="margin-top: 370px;">

		<style type="text/css">
			p.footertext{
				color: #a7321a;
				line-height: 15px;
				font-size: 13px;
				text-align: center;
				margin-right: auto;
				margin-left: auto;
				bottom: 0;
			}
		</style>

		<p class="footertext">
			&#169; 2014 Microfinance Information Management System <br>

			<a href="<?php echo site_url('general/gotoaboutus'); ?>">ABOUT US</a> | <a href="<?php echo site_url('general/gotocontactus'); ?>">CONTACT US</a> | <a href="<?php echo site_url('general/gotofaq'); ?>">FAQs</a> | <a href="#">HELP</a>

		</p>

		<br><br>
	</div>
