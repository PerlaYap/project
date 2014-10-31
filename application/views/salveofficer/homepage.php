
<?php 

date_default_timezone_set('Asia/Manila');

$datetoday = date('F d, Y');
$day = date('l');

$branchno = $this->session->userdata('branchno');
$userrank = $this->session->userdata('rank');

$center = $this->db->query("SELECT count(cm.Members_ControlNo) as number_of_member, bc.caritascenters_controlno as centercontrol, c.CenterNo FROM caritasbranch_has_caritascenters bc, caritascenters_has_members cm, caritascenters c where bc.caritasbranch_controlno = '$branchno' and bc.caritascenters_controlno = cm.caritascenters_controlno and cm.caritascenters_controlno = c.controlno and c.dayoftheweek = '$day' group by c.CenterNo");

$member = $this->db->query("SELECT COUNT(Members_ControlNo) AS ActiveMembers FROM 
	(SELECT * FROM Members mem
		LEFT JOIN
		(SELECT Members_ControlNo, CaritasCenters_ControlNo AS CenterControl, BranchControl, BranchName, Status
			FROM (SELECT cchm.Members_ControlNo, A.CaritasCenters_ControlNo FROM CaritasCenters_has_Members cchm
				LEFT JOIN
				(SELECT * FROM CaritasCenters_has_Members WHERE DateLeft IS NULL ORDER BY DateEntered DESC)A
				ON A.Members_ControlNo=cchm.Members_ControlNo GROUP BY Members_ControlNo)Alpha
LEFT JOIN (SELECT CenterControl, BranchControl, BranchName FROM 
	(SELECT cbhcc.CaritasCenters_ControlNo AS CenterControl, A.CaritasBranch_ControlNo AS BranchControl 
		FROM caritasbranch_has_caritascenters cbhcc
		LEFT JOIN (SELECT * FROM caritasbranch_has_caritascenters ORDER BY Date)A
		ON cbhcc.CaritasCenters_ControlNo=A.CaritasCenters_ControlNo GROUP BY A.CaritasCenters_ControlNo)B
LEFT JOIN CaritasBranch cb ON B.BranchControl=cb.ControlNo)Beta
ON Alpha.CaritasCenters_ControlNo=Beta.CenterControl
LEFT JOIN
(SELECT A.ControlNo, Status, DateUpdated 
	FROM (SELECT ControlNo FROM members_has_membersmembershipstatus GROUP BY ControlNo)A
	LEFT JOIN 
	(SELECT * FROM (SELECT * FROM members_has_membersmembershipstatus mhms ORDER BY ControlNo ASC, DateUpdated DESC)A GROUP BY ControlNo)B
	ON B.ControlNo=A.ControlNo) Charlie
ON Alpha.Members_ControlNo=Charlie.ControlNo)Omega 
ON mem.ControlNo=Omega.Members_ControlNo WHERE Approved='YES')Zeta WHERE (Status!='Terminated' OR Status!='Terminated Voluntarily') AND BranchControl='$branchno'");

$allmember = $this->db->query("SELECT * FROM `members` ");
$all_mem = $allmember->num_rows();

$perbranchCenter = $this->db->query("SELECT IFNULL(COUNT(CenterControl),0) AS CenterNo FROM (SELECT CenterControl, BranchControl, BranchName FROM 
	(SELECT cbhcc.CaritasCenters_ControlNo AS CenterControl, A.CaritasBranch_ControlNo AS BranchControl 
		FROM caritasbranch_has_caritascenters cbhcc
		LEFT JOIN (SELECT * FROM caritasbranch_has_caritascenters ORDER BY Date)A
		ON cbhcc.CaritasCenters_ControlNo=A.CaritasCenters_ControlNo GROUP BY A.CaritasCenters_ControlNo)B
LEFT JOIN CaritasBranch cb ON B.BranchControl=cb.ControlNo)Omega WHERE BranchControl='$branchno' ");

$allcenter = $this->db->query("SELECT IFNULL(COUNT(CenterControl),0) AS CenterNo FROM (SELECT CenterControl, BranchControl, BranchName FROM 
	(SELECT cbhcc.CaritasCenters_ControlNo AS CenterControl, A.CaritasBranch_ControlNo AS BranchControl 
		FROM caritasbranch_has_caritascenters cbhcc
		LEFT JOIN (SELECT * FROM caritasbranch_has_caritascenters ORDER BY Date)A
		ON cbhcc.CaritasCenters_ControlNo=A.CaritasCenters_ControlNo GROUP BY A.CaritasCenters_ControlNo)B
LEFT JOIN CaritasBranch cb ON B.BranchControl=cb.ControlNo)Omega");

$countm = 0;
$countc=0;
$allcount=0;

foreach ($member->result() as $m){
	$countm +=$m->ActiveMembers;	
}
foreach($perbranchCenter->result() as $data1){
	$countc =$data1->CenterNo;
}
foreach($allcenter->result() as $data2){
	$allcount=$data2->CenterNo;

}

/*
$pd = $this->db->query("SELECT count(cm.Members_ControlNo) as member, c.centerno FROM caritasbranch_has_caritascenters bc, caritascenters c ,caritascenters_has_members cm, members_has_membersmembershipstatus mm where bc.caritasbranch_controlno = '$branchno' and bc.caritascenters_controlno = c.controlno and c.controlno = cm.caritascenters_controlno and cm.Members_ControlNo = mm.controlno and mm.status = 'Past Due'");*/


$term = $this->db->query("SELECT MemberControl, LastName, FirstName, CenterNo FROM (SELECT MemberControl, Alpha.CenterControl, Beta.BranchControl FROM(SELECT MemberControl, CaritasCenters_ControlNo AS CenterControl FROM (SELECT Members_ControlNo AS MemberControl FROM CaritasCenters_has_Members GROUP BY Members_ControlNo)A
LEFT JOIN (SELECT * FROM (SELECT * FROM caritascenters_has_members ORDER BY DateEntered DESC)A GROUP BY Members_ControlNo)B
ON A.MemberControl=B.Members_ControlNo)Alpha
LEFT JOIN 
(SELECT CenterControl, CaritasBranch_ControlNo AS BranchControl 
FROM (SELECT CaritasCenters_ControlNo AS CenterControl FROM caritasbranch_has_caritascenters GROUP BY CaritasCenters_ControlNo)A
LEFT JOIN (SELECT * FROM (SELECT * FROM caritasbranch_has_caritascenters ORDER BY Date DESC)A GROUP BY CaritasCenters_ControlNo)B 
ON A.CenterControl=B.CaritasCenters_ControlNo)Beta
ON Alpha.CenterControl=Beta.CenterControl
WHERE BranchControl='$branchno')Uno
LEFT JOIN
(SELECT A.ControlNo, Status 
FROM (SELECT ControlNo FROM members_has_membersmembershipstatus GROUP BY ControlNo)A LEFT JOIN 
(SELECT * FROM (SELECT * FROM members_has_membersmembershipstatus mhms ORDER BY ControlNo ASC, DateUpdated DESC)A GROUP BY ControlNo)B
ON B.ControlNo=A.ControlNo)Dos ON Uno.MemberControl=Dos.ControlNo
LEFT JOIN
MembersName mn ON mn.ControlNo=Uno.MemberControl
LEFT JOIN CaritasCenters cc ON cc.ControlNo=Uno.CenterControl
WHERE (Status='Past Due' OR Status='Dormant Saver')
ORDER BY LastName");

/*FOR UPDATES*/
$pendinglist = $this->db->query("SELECT m.ControlNo
	FROM  CaritasBranch b, CaritasBranch_has_CaritasCenters cc, CaritasCenters_has_Members c, Members m 
	WHERE b.ControlNo = '$branchno' AND b.ControlNo = cc.CaritasBranch_ControlNo AND cc.CaritasCenters_ControlNo = c.CaritasCenters_ControlNo
	AND c.Members_ControlNo = m.ControlNo AND m.ControlNo IN (SELECT ControlNo FROM Members WHERE Approved = 'P') group by m.ControlNo ");
$rejectedlist = $this->db->query("SELECT m.ControlNo
	FROM  CaritasBranch b, CaritasBranch_has_CaritasCenters cc, CaritasCenters_has_Members c, Members m 
	WHERE b.ControlNo = '$branchno' AND b.ControlNo = cc.CaritasBranch_ControlNo AND cc.CaritasCenters_ControlNo = c.CaritasCenters_ControlNo
	AND c.Members_ControlNo = m.ControlNo AND m.ControlNo IN (SELECT ControlNo FROM Members WHERE Approved = 'NO') group by m.ControlNo  ");
$loanpendinglist = $this->db->query("SELECT A.ControlNo AS LoanControl, ApplicationNumber, DateApplied, AmountRequested, loantype, concat(LastName,', ',FirstName,' ', MiddleName) AS Name ,BranchName, CenterNo
	FROM loanapplication_has_members lhm 
	RIGHT JOIN (SELECT ControlNo, ApplicationNumber, AmountRequested, DateApplied, LoanType FROM loanapplication WHERE Status='Pending' ORDER BY DateApplied ASC)A ON lhm.LoanApplication_ControlNo=A.ControlNo
	LEFT JOIN MembersName mn ON lhm.Members_ControlNo=mn.ControlNo
	LEFT JOIN (SELECT Members_ControlNo, cc.CenterNo FROM caritascenters_has_members cchmem LEFT JOIN caritascenters cc ON cchmem.CaritasCenters_ControlNo=cc.ControlNo WHERE DateLeft IS NULL) B ON lhm.Members_ControlNo=B.Members_ControlNo
	LEFT JOIN caritasbranch cb ON lhm.CaritasBranch_ControlNo=cb.ControlNo
	WHERE lhm.CaritasBranch_ControlNo= '$branchno' ");

$loanapprovedlist = $this->db->query("SELECT A.ControlNo AS LoanControl, ApplicationNumber, DateApplied, AmountRequested, loantype, concat(LastName,', ',FirstName,' ', MiddleName) AS Name ,BranchName, CenterNo
	FROM loanapplication_has_members lhm 
	RIGHT JOIN (SELECT ControlNo, ApplicationNumber, AmountRequested, DateApplied, LoanType FROM loanapplication WHERE Status='Active' ORDER BY DateApplied ASC)A ON lhm.LoanApplication_ControlNo=A.ControlNo
	LEFT JOIN MembersName mn ON lhm.Members_ControlNo=mn.ControlNo
	LEFT JOIN (SELECT Members_ControlNo, cc.CenterNo FROM caritascenters_has_members cchmem LEFT JOIN caritascenters cc ON cchmem.CaritasCenters_ControlNo=cc.ControlNo WHERE DateLeft IS NULL) B ON lhm.Members_ControlNo=B.Members_ControlNo
	LEFT JOIN caritasbranch cb ON lhm.CaritasBranch_ControlNo=cb.ControlNo
	WHERE lhm.CaritasBranch_ControlNo= '$branchno'");

$pending = $pendinglist->num_rows();
$rejected = $rejectedlist->num_rows();


$loanpending = $loanpendinglist->num_rows(); 
$loanapproved = $loanapprovedlist->num_rows();

/*END FOR UPDATES*/

?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('Assets/css/salveofficer.css'); ?>">
<script src="<?php echo base_url('Assets/js/salveofficer.js'); ?>">
</script>

<script type="text/javascript">

function send(control_no){
	
	window.location.href= "terminate?name="+ control_no;
} 

function gotocenter(x){
	/*alert("Row index is: " + x);*/
	window.open("pastduemember?name="+x,'Past Due Member','scrollbars=1, width=1500px, height=1000px');
}
function gotopendingmember(){
	window.location.href="<?php echo site_url('branchmanager/approvallist'); ?>";
}
function gotorejectedmember(){
	window.location.href="<?php echo site_url('branchmanager/rejectedaccounts'); ?>";
}
function gotoloanforapproval(){
	window.location.href="<?php echo site_url('loanapplication/forloanapprovallist'); ?>";
}
function gotoapprovedloan(){
	window.location.href="<?php echo site_url('loanapplication/approvedloans'); ?>";
}

</script>
<div id="salveofficerhomepage">

	<div class="HPtoday">
		<img src="<?php echo base_url('Assets/images/calendar.png'); ?>" class="calendar">
		<p class="HPheadtxt">TODAY</p>
		<p class="today"> <?php echo $datetoday; ?> </p>
		<p class="today1"><?php echo $day; ?></p>
	</div>
	<?php if($userrank!='mispersonnel') :?>
	<div class="centertocollect">
		<img src="<?php echo base_url('Assets/images/center.png'); ?>" class="calendar">
		<p class="HPheadtxt">CENTERS FOR TODAY</p>
		<table>
			
			<td>

				<!-- foreach divide into 5 per ul -->
				<ul class="collecttxt">

					<?php if (!empty($center->result())) {
						foreach ($center->result() as $c){
							$center = $c->CenterNo; ?>	
							<li class="collecttxt1"><?php echo $center;  ?></li>
							<?php  } }else{ ?>
							<li class="collecttxt1">No center for today.</li>
							<?php } ?> 
							
						</ul>
					</td>
				</table>
	</div>
		<?php endif;?>

		<div class="statnumber">
					<?php if($userrank!='mispersonnel') :?>
					<p class="stat"><?php echo $countm ?></p>
				<?php endif;?>
				<?php if($userrank=='mispersonnel') :?>
				<p class="stat"><?php echo $all_mem ?></p>
			<?php endif;?>
			<p class="stat1">Members</p>
			<p class="stat2">Updated last <?php echo $datetoday; ?></p>
		</div>

<div class="statnumberBranch">
		<?php if($userrank!='mispersonnel') :?>
		<p class="stat"><?php echo $countc ?></p>
	<?php endif;?>
	<?php if($userrank=='mispersonnel') :?>
		<p class="stat"><?php echo $allcount ?></p>
	<?php endif;?>
	<p class="stat1">Centers</p>
	<p class="stat2">Updated last <?php echo $datetoday; ?></p>
</div>



<?php if($userrank!='mispersonnel') :?>
	<div class="pastdue" style=" overflow:auto; " >
				<?php /*echo "Officer name: ".$this->session->userdata('firstname')."<br>";
				echo "Branch:  ".$this->session->userdata('branch')."<br>";
				echo "Branch No:   ".$this->session->userdata('branchno')."<br>"; 
				echo "personnelno: ".$this->session->userdata('personnelno')."<br>";
				echo "Rank: ".$this->session->userdata('rank');*/?>

				<?php 
				/*	$datelastweek=array();*/
				$dayoftheWeek= $day;
				$date = $datetoday;
				$next="last ".$dayoftheWeek;
				$datelastweek=date('Y-m-d', strtotime($next,strtotime($date)));
				$date=$datelastweek;

				$pastduecount = $this->db->query("SELECT centercontrol,CenterNo, DateTime,TransactionType, count(CenterNo)as NumPastDue from (SELECT cm.Members_ControlNo as member, bc.caritascenters_controlno as centercontrol, c.CenterNo FROM caritasbranch_has_caritascenters bc, caritascenters_has_members cm, caritascenters c where bc.caritasbranch_controlno = '$branchno' and bc.caritascenters_controlno = cm.caritascenters_controlno and cm.caritascenters_controlno = c.controlno) s left join `transaction` t on t.Members_ControlNo = s.member where DateTime ='$datelastweek' and TransactionType='Past Due' group by CenterNo");
				$pdcount = $pastduecount->result();
				$pdtotal = 0;
				
				?>

				<img src="<?php echo base_url('Assets/images/pastdue.png'); ?>" class="calendar">
				<p class="HPheadtxt">&nbsp PAST DUE LAST WEEK</p>
				<!-- <p class="HPheadtxt3">&nbsp&nbsp&nbsp&nbsp<?php echo $datelastweek ?></p> -->

				<?php if (!empty($pdcount)) { ?>
				<table style="margin-top:10px; margin-left:auto; margin-right: auto;">
					<tr>
						<td class="hdrTDctr" style="width: 120px;">CENTER</td>
						<td class="hdrTDmbr" style="width: 100px;"># of PAST DUE</td>
					</tr>
							<?php foreach ( $pdcount as $p) {
								$centerno = $p->CenterNo;
								$centercontrolno = $p->centercontrol;
								$numpd = $p->NumPastDue;
								$pdtotal +=$numpd;
								?>
					<tr onclick="gotocenter(<?php echo $centercontrolno; ?>)"  class="updaterow" >
						<td class="TDctr" style="cursor:pointer;"><?php echo $centerno ?></td>
						<td class="TDmbr" style="cursor:pointer;"><?php echo $numpd ?></td>
					</tr>
									<?php } ?>
					<tr>
						<td class="TDtotal">Total:</td>
						<td class="TDtotal2"><?php echo $pdtotal ?></b></td>
					</tr>
				</table>
								<?php } else{ ?>
					<p style="text-align: center; margin-top: 50px;">- No Past Due -</p>
								
								<?php } ?>
					<br>
	</div>

							<div class="update" style="overflow:auto;">
								<img src="<?php echo base_url('Assets/images/update.png'); ?>" class="update">
								<p class="HPheadtxt2">  UPDATES</p>
								<p class="HPheadtxt3">  As of <?php echo $datetoday; ?></p>

								
								
								<?php if (!$pending==0 || !$rejected==0 || !$loanpending==0 || !$loanapproved ==0) { 
									?>
									
									
									<table style="margin-right: auto; margin-top:30px; border-collapse: collapse;">
										
										<!-- <tr onclick="gotocenter(<?php echo $centercontrolno; ?>)"  class="updaterow" > -->
										<tr class="updaterow" onclick="gotopendingmember();" >
											<td class="updatecontent" style="width: 30px;"> 01.</td>
											<td class="updatecontent" style="width: 240px;"><a href="#"><?php echo $pending ?> Pending Membership Application</a></td>
										</tr>
										<tr class="updaterow" onclick="gotorejectedmember();">
											<td class="updatecontent" style="width: 30px;"> 02.</td>
											<td class="updatecontent" style="width: 240px;"><a href="#"><?php echo $rejected ?> Rejected Membership Application</a></td>
										</tr>
										<tr class="updaterow" onclick="gotoloanforapproval();">
											<td class="updatecontent" style="width: 30px;"> 03.</td>
											<td class="updatecontent" style="width: 240px;"><a href="#"><?php echo $loanpending ?> Loan Application subject for approval</a></td>
										</tr>
										<tr class="updaterow" onclick="gotoapprovedloan();">
											<td class="updatecontent" style="width: 30px;"> 04.</td>
											<td class="updatecontent" style="width: 240px;"><a href="#"><?php echo $loanapproved ?> Loan Application Ready to be Release</a></td>
										</tr>
										
									</table>
									<?php }else{ ?>
									<!---IF WALANG CONTENT---->

									<p style="text-align: center; margin-top: 50px;">- No Updates(s) -</p>

									<!---IF WALANG CONTENT---->
									<?php }  ?>


									<br>
								</div>
							<?php endif;?>


							<?php if($userrank=='branchmanager') :?>	
							<!------------------------- IF BM -------------------------------------->

							<div class="activedormant2">
								<iframe src=" <?php echo base_url('salveofficer/activedormant') ?> " width="600px" height="400px;" frameborder="0" scrolling="no"></iframe>
							</div>

							<div class="targetactual2">
								<iframe src=" <?php echo base_url('salveofficer/targetactualcenter') ?> " width="900px" height="400px;" frameborder="0" scrolling="no"></iframe>
							</div>

							<div class="terminate" style="overflow:auto;">
								<img src="<?php echo base_url('Assets/images/terminate.png'); ?>" class="terminate">
								<p class="HPheadtxt02">  FOR TERMINATION</p>
								<p class="HPheadtxt03">  <?php echo $datetoday; ?></p>

								
								



								<table style="margin-right: auto; margin-top:30px; border-collapse: collapse;">
									
									
									<?php 
									$number=0; ?>

									
									<?php if(!empty($term->result())){ ?>
									<tr class="updaterow">
										<td class="updatecontent" style="width: 30px;color:#232222;"><b>#</b></td>
										<td class="updatecontent" style="width: 100px;"><b>NAME</b></td>
										<td class="updatecontent" style="width: 50px;color:#232222;"><b>CENTER</b></td>						
									</tr>

									<?php	foreach ($term->result() as $t){

										$number+=1;  ?>


										<tr class="updaterow">
											<td class="updatecontent" style="width: 30px; color:#232222;"> <?php echo $number; ?></td>
											<td class="updatecontent" style="width: 240px;"><a href="javascript:void(0)" onclick="send('<?php echo $t->MemberControl ?>')"><?php echo $t->LastName;  ?>, <?php echo $t->FirstName ?></a></td>
											<td class="updatecontent" style="width: 30px; text-align:center; color:#232222;"><?php echo $t->CenterNo; ?></td>						
										</tr>

										<?php } ?>

										<?php } else { 	
											
											?>	
											<!---IF WALANG CONTENT---->

											<p style="text-align: center; margin-top: 50px;">- No Account(s) for Termination -</p>

											<!---IF WALANG CONTENT---->
											
											
											

											<?php }  ?> 
										</table>

										<br>
								</div>
									<!------------------------- IF BM -------------------------------------->
								<?php endif;?>
								<?php if($userrank=='salveofficer') :?>
								<!------------------------- IF SO -------------------------------->
								<div class="activedormant">
									<iframe src=" <?php echo base_url('salveofficer/activedormant') ?> " width="900px" height="400px;" frameborder="0" scrolling="no"></iframe>
								</div>



								<div class="targetactual">
									<iframe src=" <?php echo base_url('salveofficer/targetactualcenter') ?> " width="900px" height="400px;" frameborder="0" scrolling="no"></iframe>
								</div>




						

							<!------------------------- IF SO -------------------------------->
						<?php endif;?>
						
							
							<?php 


							?>	
							<li class="collecttxt1"><a href=><?php //echo $t->LastName;  ?> <?php //echo $t->FirstName ?></a></li>
							<?php // } ?> 
							
							
						</td>
						
					</table>
					<br>




	
	<div style="margin-top: 1350px;">

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
			<a href="<?php echo site_url('general/gotoaboutus'); ?>">ABOUT US</a> | <a href="<?php echo site_url('general/gotocontactus'); ?>">CONTACT US</a> | <a href="<?php echo site_url('general/gotofaq'); ?>">FAQs</a>
		</p>

		<br><br>
	</div>



</div>



		