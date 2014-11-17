
<link rel="stylesheet" type="text/css" href="<?php echo base_url('Assets/css/salveofficer.css'); ?>">
<script src="<?php echo base_url('Assets/js/salveofficer.js'); ?>"></script>

&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp

<?php
	
	$userrank = $this->session->userdata('rank');
	$branch = $this->session->userdata('branchno');


	$pendinglist = $this->db->query("SELECT m.ControlNo
		FROM  CaritasBranch b, CaritasBranch_has_CaritasCenters cc, CaritasCenters_has_Members c, Members m 
		WHERE b.ControlNo = '$branch' AND b.ControlNo = cc.CaritasBranch_ControlNo AND cc.CaritasCenters_ControlNo = c.CaritasCenters_ControlNo
		AND c.Members_ControlNo = m.ControlNo AND m.ControlNo IN (SELECT ControlNo FROM Members WHERE Approved = 'P') ");



	$rejectedlist = $this->db->query("SELECT m.ControlNo
		FROM  CaritasBranch b, CaritasBranch_has_CaritasCenters cc, CaritasCenters_has_Members c, Members m 
		WHERE b.ControlNo = '$branch' AND b.ControlNo = cc.CaritasBranch_ControlNo AND cc.CaritasCenters_ControlNo = c.CaritasCenters_ControlNo
		AND c.Members_ControlNo = m.ControlNo AND m.ControlNo IN (SELECT ControlNo FROM Members WHERE Approved = 'NO') ");



	$approvedlist = $this->db->query("SELECT m.ControlNo
		FROM  CaritasBranch b, CaritasBranch_has_CaritasCenters cc, CaritasCenters_has_Members c, Members m 
		WHERE b.ControlNo = '$branch' AND b.ControlNo = cc.CaritasBranch_ControlNo AND cc.CaritasCenters_ControlNo = c.CaritasCenters_ControlNo
		AND c.Members_ControlNo = m.ControlNo AND m.ControlNo IN (SELECT ControlNo FROM Members WHERE Approved = 'YES') ");

	


/*	$pendinglist = $this->db->query("SELECT `Approved` AS pending FROM `members` WHERE `Approved`='P'");
	$rejectedlist = $this->db->query("SELECT `Approved` AS pending FROM `members` WHERE `Approved`='NO'");
	$approvedlist = $this->db->query("SELECT `Approved` AS pending FROM `members` WHERE `Approved`='YES'"); */

	/*----------------------NEED for REVISION------------------*/
	$loanpendinglist = $this->db->query("SELECT Status FROM LoanApplication WHERE Status='Pending'"); 
	/*----------------------NEED for REVISION------------------*/

	$pending = $pendinglist->num_rows();
	$rejected = $rejectedlist->num_rows();
	$approved = $approvedlist->num_rows(); 
	$loanpending = $loanpendinglist->num_rows(); 
 ?>

			

			<div class="navBG"></div>

			<nav class= "menu">
				<ul>
				<!------- IF MIS YUNG NAKASIGN IN ------>
				<?php if($userrank=='mispersonnel') :?>
					<li class="menu"><a href="#" class="menu">ACCOUNTS</a>
						<ul>
						
							<li><a href="<?php echo site_url('mis/newbranch'); ?>">New Branch</a></li>
							<li><a href="<?php echo site_url('mis/listofbranches'); ?>">All Branches</a></li>
								<li><a href="<?php echo site_url('mis/addnewofficer'); ?>">New Officer</a></li>
							<li><a href="<?php echo site_url('mis/listofusers'); ?>">All Officers</a></li>
						</ul>
					</li>
				<?php endif;?>	
				

				<!------ IF BM YUNG NAKASIGN IN  ------>
				<?php if($userrank=='branchmanager') :?>
					<li class="menu"><a href="#" class="menu">ACCOUNTS</a>
						<ul>
							<li><a href="<?php echo site_url('branchmanager/newcenter'); ?>">New Center</a></li>
							<li><a href="<?php echo site_url('branchmanager/listofcenters'); ?>">All Centers</a></li>
							
						</ul>
					</li>
				<?php endif;?>	
																<!-- put some style to this echo -->
					
					<li class="menu"><a href="#" class="menu">MEMBERSHIP 
						
						
							<?php 
									$pendingandreject =  $pending+$rejected;
							if ($userrank=='branchmanager' && !$pending==0) { ?>
							<div class="notification">
								<?php echo $pending; ?>	</div>
							<?php	}
								
								elseif ($userrank=='salveofficer' && !$pendingandreject==0) { ?>
								<div class="notification">
									<?php echo $pendingandreject; ?>
									</div>
						<?php		}

					 		?>
					 	</a>
						

						<ul>
							<?php if($userrank=='salveofficer') :?>
							<li><a href="<?php echo site_url('salveofficer/addnewmember'); ?>">New Member's Account</a></li>
							<?php endif;?>
							
							<?php if($userrank=='branchmanager') :?>
								<!-- put some style also here -->
								<li><a href="<?php echo site_url('branchmanager/approvallist'); ?>">Pending Membership Application 
									<?php if (!$pending == 0) { ?>
									<div class="subnotif"><?php echo $pending; ?></div>
									<?php } ?>
								</a></li>
							<?php endif;?>
							
							<?php if($userrank=='salveofficer') :?>
								<li><a href="#">Application Status 
									<?php if (!$pendingandreject == 0) { ?>
									<div class="subnotif"><?php echo $pendingandreject; ?></div>
									<?php } ?>
								</a>
									<ul>
										<li><a href="<?php echo site_url('branchmanager/approvallist'); ?>">Pending  
											<?php if (!$pending == 0) { ?>
											<div class="subnotif"><?php echo $pending; ?></div>
											<?php } ?>
										</a></li>
									
										<li><a href="<?php echo site_url('branchmanager/rejectedaccounts'); ?>">Rejected 
											<?php if (!$rejected == 0) { ?>
											<div class="subnotif"><?php echo $rejected; ?></div>
											<?php } ?>
										</a></li>
									</ul>
								</li>
							<?php endif;?>
						
							<li><a href="<?php echo site_url('salveofficer/capitalshare'); ?>">Member's Capital Share</a></li>
							<li><a href="<?php echo site_url('salveofficer/violations'); ?>">Violation</a></li>


						</ul>

					</li>


					<li class="menu"><a href="#"href class="menu">LOAN

						<?php 
							if ($userrank=='branchmanager' && !$loanpending==0) { ?>
							<div class="loannotification">
								<?php echo $loanpending; ?>	</div>
							<?php	}?>
					 	</a>
						

						<ul>

							<?php if($userrank=='branchmanager') :?>
								<li><a href="<?php echo site_url('branchmanager/forloanapprovallist'); ?>">Pending Loan Application
								<?php if (!$loanpending == 0) { ?>
									<div class="loansubnotif"><?php echo $loanpending; ?></div>
									<?php } ?>
						</a></li>
							<?php endif;?>

							<li><a href="<?php echo site_url('dailycollection/collection'); ?>">Daily Loan Collection</a></li>
							<li><a href="<?php echo site_url('salveofficer/addnewloan'); ?>">New Loan Application</a></li>
							
							<li><a href="#">Current Loan Status</a>
								<ul>
									<li><a href="#">Active Loans</a></li>
									<li><a href="#">Past Due Loans</a></li>
								</ul>
							</li>

						</ul>
					</li>

					<li class="menu"><a href="<?php echo site_url('downloads/list'); ?>" class="menu" style="cursor: pointer;">DOWNLOADS</a></li>
					<li class="menu"><a href="<?php echo site_url('reports/reportList'); ?>" class="menu" style="cursor: pointer;">REPORTS</a></li>
					<li class="menu"><a href="<?php echo site_url('records/list'); ?>" class="menu" style="cursor: pointer;">RECORDS</a></li>
				</ul>
			</nav>
			<!--menu bar-->



<body>
		