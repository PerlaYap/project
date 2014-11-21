<title>Daily Collection Sheet</title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('Assets/css/reports.css'); ?>">


<style type="text/css" media="print">
.dontprint{
	display: none;
}

</style>

<?php 
	date_default_timezone_set('Asia/Manila');
  
    $datetoday = date('F d, Y');
    $day = date('l');
 	$branchno = $this->session->userdata('branchno');
 	$branch = $this->session->userdata('branch');
 
 	$center = $_GET['center'];
 	$userrank = $this->session->userdata('rank');
	$name2 = $this->session->userdata('firstname');
	

 		$getManager=$this->db->query("SELECT CONCAT(`FirstName`,' ',  `MiddleName`,' ', `LastName`) AS NAME FROM CaritasPersonnel CL 
											JOIN CARITASBRANCH_HAS_CARITASPERSONNEL BP ON CL.CONTROLNO = BP.CARITASPERSONNEL_ControlNo
											JOIN CARITASBRANCH B ON BP.CARITASBRANCH_CONTROLNO = B.CONTROLNO
											
														WHERE CL.RANK = 'BRANCHMANAGER' 
														AND B.ControlNo = $branchno ");
	foreach ($getManager->result() as $row){ 
		$Manager=$row->NAME;
	}

 	$getMember = $this->db->query("SELECT * FROM (SELECT mem.`ControlNo`,CONCAT(`FirstName`,' ',  `MiddleName`,' ', `LastName`)as Name,  `LoanExpense`, `Savings`, `CapitalShare`,`pastdue`,`CaritasCenters_ControlNo` FROM `caritascenters_has_members` cm, `membersname`mem, `members` m WHERE mem.`ControlNo` = cm.`Members_ControlNo` and cm.`Members_ControlNo` = m.`ControlNo`)member join (SELECT `LoanApplication_ControlNo`,`status`, `Members_ControlNo`,`AmountRequested`, `Interest`, `LoanType` FROM `loanapplication_has_members` lhm , `loanapplication` l WHERE lhm.`LoanApplication_ControlNo` = l.`ControlNo`) loan on member.ControlNo = loan.Members_ControlNo where member.`CaritasCenters_ControlNo`= $center and `status`='Current' order by Name");
 	$hasmember = $getMember->result();
 

 ?>
	
<!-- <link rel="stylesheet" type="text/css" href="../../../Assets/css/reports.css"> -->

	
<!-- 	<img src="../../../Assets/images/caritaslogo.png" class="caritaslogo"> -->
<a href="<?php echo site_url('login/homepage'); ?>"> <img src="<?php echo base_url('Assets/images/caritaslogo.png'); ?>" class="caritaslogo"></a>
	<h3>CARITAS SALVE CREDIT COOPERATIVE <br> Daily Collection Sheet</h3>

	<br>

	
		<p style="font-size:14px; margin-left:225px;">
			Name of Branch: <b> <?php echo $branch; ?> </b>		<br>
			Center No. : <b><?php echo $_GET['name'];?></b>  			<br>
			<?php if($userrank=='branchmanager'){?>
			Branch Manager: <b><?php echo $name2; ?></b>		<br>
			<?php } else { ?>
			Salve Officer: <b><?php echo $name2; ?></b>		<br>
			<?php }?>
			Day: <b><?php echo $datetoday." (".$day.")" ?></b>
		</p>

		<?php if (!empty($hasmember)) { ?>
			
		<table class="individualDC" border="2" style="margin-left:auto; margin-right:auto;">
			<tr>
				<td rowspan="2" class="hdrDC">#</td>
				<td rowspan="2" class="hdrDC">MEMBER NAME</td>
				<td colspan="4" class="hdrDC">LOAN</td>
				<td colspan="2" class="hdrDC">SAVINGS</td>
				<td rowspan="2" class="hdrDC">WITHDRAWAL</td>
			</tr>
			<tr>
				<td class="hdrDC">Active Release</td>
				<td class="hdrDC">Past Due</td>
				<td class="hdrDC">Amount to Collect</td>
				<td class="hdrDC">Additional Collection</td>

				<td class="hdrDC">Savings Build-Up</td>
				<td class="hdrDC">Savings Collection</td>
			</tr>
			<?php 
					$num = 0;
					foreach ($hasmember as $mem) { 

					$num+=1;
					$name = $mem->Name;
					$activerelease =$mem->AmountRequested + $mem->Interest;
					$pastdue =$mem->pastdue;

					$loantype = $mem->LoanType;
						if ($loantype =='23-Weeks') {
							$amounttopay = $activerelease/23;
						}else if ($loantype =='40-Weeks') {
								$amounttopay = $activerelease/40;
						}

					$savings = $mem->Savings;
							 

			?>
				
			
			<tr>
				<td class="collectDC" rowspan="2"><?php echo $num; ?>.</td>
				<td class="collectDC2" rowspan="2"><?php echo $name; ?></td>
				<td class="collectDC" rowspan="2"><?php echo number_format($activerelease,2); ?></td>
				<td class="collectDC" rowspan="2"><?php echo number_format($pastdue,2); ?></td>
				<td class="collectDC" rowspan="2"><input type="checkbox" name="" value=""><?php echo number_format($amounttopay,2); ?></td>
				<td class="collectDC" rowspan="2"></td>
				<td class="collectDC" rowspan="2"><?php echo number_format($savings,2) ?></td>
				<td class="collectDC"><input type="checkbox" name="" value="">50.00</td>
				<td class="collectDC" rowspan="2"></td>
			</tr>
				<tr>
					<td class="collectDC3">Additional: <br></td>
				</tr>

			<?php } ?>

		</table>
		

		<br><br><br>

	<table style="margin-left: 300px;" >
			<tr>
				<td style="font-size: 13px;"><?php echo $name2; ?></td>
			</tr>
				<?php if($userrank=='branchmanager'){?>
			<tr>
				<td class="BM2">Signature Above Printed Name of Branch Manager</td>
			</tr>
			<?php }else{ ?>
			<tr>
				<td class="BM2">Signature Above Printed Name of Salve Officer</td>
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
			
			<?php if($userrank=='branchmanager'){?>
			<tr>
				<td style="font-size: 13px;">Marvin Lao</td>
			</tr>
			<tr>
				<td class="BM2">Signature Above Printed Name of MIS</td>
			</tr>
			<?php }else{ ?>
			<tr>
				<td style="font-size: 13px;"><?php echo $Manager ?></td>
			</tr>
			<tr>
				<td class="BM2">Signature Above Printed Name of Branch Manager</td>
			</tr>
			<?php } ?>
			<tr>
				<td style="font-size: 13px;"><?php echo $datetoday ?></td>
			</tr>
			<tr>
				<td class="BM2">Date</td>
			</tr>
		</table>


	</div>




	<br>
	<div class='dontprint' style="width: 100%; text-align: center;">
		<button onclick="window.print()">Print</button>
	</div>
	<?php } else{ ?>
			No Member Found.
	<?php } ?>