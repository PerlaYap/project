
<?php 

	date_default_timezone_set('Asia/Manila');
  
    $datetoday = date('F d, Y');
    $day = date('l');

 $branchno = $this->session->userdata('branchno');
 $userrank = $this->session->userdata('rank');

$center = $this->db->query("SELECT count(cm.Members_ControlNo) as number_of_member, bc.caritascenters_controlno as centercontrol, c.CenterNo FROM caritasbranch_has_caritascenters bc, caritascenters_has_members cm, caritascenters c where bc.caritasbranch_controlno = '$branchno' and bc.caritascenters_controlno = cm.caritascenters_controlno and cm.caritascenters_controlno = c.controlno and c.dayoftheweek = '$day' group by c.CenterNo");

$member = $this->db->query("SELECT count(cm.Members_ControlNo) as Membercount, bc.caritascenters_controlno as center FROM caritasbranch_has_caritascenters bc, caritascenters_has_members cm where bc.caritasbranch_controlno = '$branchno' and bc.caritascenters_controlno = cm.caritascenters_controlno
group by center");

$allmember = $this->db->query("SELECT * FROM `members` ");
$all_mem = $allmember->num_rows();

$allcenter = $this->db->query("SELECT * FROM `caritascenters` ");
$all_ctr = $allcenter->num_rows();

$countm = 0;

foreach ($member->result() as $m){
	$countm +=$m->Membercount;	
}
	$countc =$member->num_rows();

/*
$pd = $this->db->query("SELECT count(cm.Members_ControlNo) as member, c.centerno FROM caritasbranch_has_caritascenters bc, caritascenters c ,caritascenters_has_members cm, members_has_membersmembershipstatus mm where bc.caritasbranch_controlno = '$branchno' and bc.caritascenters_controlno = c.controlno and c.controlno = cm.caritascenters_controlno and cm.Members_ControlNo = mm.controlno and mm.status = 'Past Due'");*/

	
$term = $this->db->query("SELECT m.FirstName, m.LastName, c.centerno, m.ControlNo FROM caritasbranch_has_caritascenters bc, caritascenters c ,caritascenters_has_members cm, members_has_membersmembershipstatus mm, membersname m where bc.caritasbranch_controlno = '$branchno' and bc.caritascenters_controlno = c.controlno and c.controlno = cm.caritascenters_controlno and cm.Members_ControlNo = mm.controlno AND mm.controlno = m.controlno and mm.status = 'Past Due' || 'Dormant Saver'");

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
				<p class="stat"><?php echo $all_ctr ?></p>
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
						<td class="hdrTDctr" style="width: 120px;">CENTER</th>
						<td class="hdrTDmbr" style="width: 100px;"># of PAST DUE</th>
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
							<td class="updatecontent" style="width: 240px;"><a href="javascript:void(0)" onclick="send('<?php echo $t->ControlNo ?>')"><?php echo $t->LastName;  ?>, <?php echo $t->FirstName ?></a></td>
							<td class="updatecontent" style="width: 30px; text-align:center; color:#232222;"><?php echo $t->centerno; ?></td>						
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




		</div>


<!------------------------- IF SO -------------------------------->
<?php endif;?>
	

<!------------------------------- DOUBLE TERMINATION--------------------------------- -->
	<!--	<div class="terminate">
		<img src="<?php //echo base_url('Assets/images/center.png'); ?>" class="calendar">
				<p class="HPheadtxt">Candidates For Termination</p>
				<table>
				
						<td>

							<!-- foreach divide into 5 per ul -->
						
						<?php 


//						foreach ($term->result() as $t){

							 ?>	
								<li class="collecttxt1"><a href=><?php //echo $t->LastName;  ?> <?php //echo $t->FirstName ?></li>
								<?php // } ?> 
								
							
						</td>
						
				</table>
				<br>
			</div>






	<!--		<div class="activedormant">
				<iframe src=" <?php echo base_url('salveofficer/activedormant') ?> " width="900px" height="400px;" frameborder="0" scrolling="no"></iframe>
			</div>
			<div class="targetactual">
				<iframe src=" <?php echo base_url('salveofficer/targetactualcenter') ?> " width="900px" height="400px;" frameborder="0" scrolling="no"></iframe>
			</div>-->



		</div>


	