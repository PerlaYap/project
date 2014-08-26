
<link rel="stylesheet" type="text/css" href="<?php echo base_url('Assets/css/salveofficer.css'); ?>">
<script src="<?php echo base_url('Assets/js/salveofficer.js'); ?>"></script>
<style media="screen">
  .noPrint{ display: block; }
  .yesPrint{ display: block !important; }
</style>

<style media="print">
  .noPrint{ display: none; }
  .yesPrint{ display: block !important; }
</style>
&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp

<?php
	
	$userrank = $this->session->userdata('rank');
	$branch = $this->session->userdata('branchno');


	$pendinglist = $this->db->query("SELECT m.ControlNo
		FROM  CaritasBranch b, CaritasBranch_has_CaritasCenters cc, CaritasCenters_has_Members c, Members m 
		WHERE b.ControlNo = '$branch' AND b.ControlNo = cc.CaritasBranch_ControlNo AND cc.CaritasCenters_ControlNo = c.CaritasCenters_ControlNo
		AND c.Members_ControlNo = m.ControlNo AND m.ControlNo IN (SELECT ControlNo FROM Members WHERE Approved = 'P') group by m.ControlNo ");


	 $pending = count($pendinglist);

	$rejectedlist = $this->db->query("SELECT m.ControlNo
		FROM  CaritasBranch b, CaritasBranch_has_CaritasCenters cc, CaritasCenters_has_Members c, Members m 
		WHERE b.ControlNo = '$branch' AND b.ControlNo = cc.CaritasBranch_ControlNo AND cc.CaritasCenters_ControlNo = c.CaritasCenters_ControlNo
		AND c.Members_ControlNo = m.ControlNo AND m.ControlNo IN (SELECT ControlNo FROM Members WHERE Approved = 'NO') group by m.ControlNo  ");


	 $rejected = count($rejectedlist);

	$approvedlist = $this->db->query("SELECT m.ControlNo
		FROM  CaritasBranch b, CaritasBranch_has_CaritasCenters cc, CaritasCenters_has_Members c, Members m 
		WHERE b.ControlNo = '$branch' AND b.ControlNo = cc.CaritasBranch_ControlNo AND cc.CaritasCenters_ControlNo = c.CaritasCenters_ControlNo
		AND c.Members_ControlNo = m.ControlNo AND m.ControlNo IN (SELECT ControlNo FROM Members WHERE Approved = 'YES') group by m.ControlNo ");

	$loanpendinglist = $this->db->query("SELECT A.ControlNo AS LoanControl, ApplicationNumber, DateApplied, AmountRequested, loantype, concat(LastName,', ',FirstName,' ', MiddleName) AS Name ,BranchName, CenterNo
FROM loanapplication_has_members lhm 
RIGHT JOIN (SELECT ControlNo, ApplicationNumber, AmountRequested, DateApplied, LoanType FROM loanapplication WHERE Status='Pending' ORDER BY DateApplied ASC)A ON lhm.LoanApplication_ControlNo=A.ControlNo
LEFT JOIN MembersName mn ON lhm.Members_ControlNo=mn.ControlNo
LEFT JOIN (SELECT Members_ControlNo, cc.CenterNo FROM caritascenters_has_members cchmem LEFT JOIN caritascenters cc ON cchmem.CaritasCenters_ControlNo=cc.ControlNo WHERE DateLeft IS NULL) B ON lhm.Members_ControlNo=B.Members_ControlNo
LEFT JOIN caritasbranch cb ON lhm.CaritasBranch_ControlNo=cb.ControlNo
WHERE lhm.CaritasBranch_ControlNo= '$branch' ");

	$loanapprovedlist = $this->db->query("SELECT A.ControlNo AS LoanControl, ApplicationNumber, DateApplied, AmountRequested, loantype, concat(LastName,', ',FirstName,' ', MiddleName) AS Name ,BranchName, CenterNo
FROM loanapplication_has_members lhm 
RIGHT JOIN (SELECT ControlNo, ApplicationNumber, AmountRequested, DateApplied, LoanType FROM loanapplication WHERE Status='Active' ORDER BY DateApplied ASC)A ON lhm.LoanApplication_ControlNo=A.ControlNo
LEFT JOIN MembersName mn ON lhm.Members_ControlNo=mn.ControlNo
LEFT JOIN (SELECT Members_ControlNo, cc.CenterNo FROM caritascenters_has_members cchmem LEFT JOIN caritascenters cc ON cchmem.CaritasCenters_ControlNo=cc.ControlNo WHERE DateLeft IS NULL) B ON lhm.Members_ControlNo=B.Members_ControlNo
LEFT JOIN caritasbranch cb ON lhm.CaritasBranch_ControlNo=cb.ControlNo
WHERE lhm.CaritasBranch_ControlNo= '$branch'");


	$pending = $pendinglist->num_rows();
	$rejected = $rejectedlist->num_rows();
	$approved = $approvedlist->num_rows(); 

	$loanpending = $loanpendinglist->num_rows(); 
	$loanapproved = $loanapprovedlist->num_rows();


?>


			

			<div class="navBG"></div>

			<nav class= "menu">
				<ul>
				<!------- IF MIS YUNG NAKASIGN IN ------>
				<?php if($userrank=='mispersonnel') :?>
					<li class="menu"><a href="#" class="menu">ACCOUNTS</a>
						<ul>
						
							<li><a href="<?php echo site_url('mis/newbranch'); ?>">New Branch</a></li>
							<li><a href="<?php echo site_url('mis/listofbranches'); ?>">List of Branches</a></li>
								<li><a href="<?php echo site_url('mis/addnewofficer'); ?>">New User</a></li>
							<li><a href="<?php echo site_url('mis/listofusers'); ?>">List of Users</a></li>
						</ul>
					</li>
				<?php endif;?>	
				

				<!------ IF BM YUNG NAKASIGN IN  ------>
				<?php if($userrank=='branchmanager') :?>
					<li class="menu"><a href="#" class="menu">ACCOUNTS</a>
						<ul>
							<li><a href="<?php echo site_url('branchmanager/newcenter'); ?>">New Center</a></li>
							<li><a href="<?php echo site_url('branchmanager/listofcenters'); ?>">List of Centers</a></li>
				
							
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
							<?php endif;

						
					?>
						
							<!-- <li><a href="<?php echo site_url('salveofficer/capitalshare'); ?>">Member's Capital Share</a></li> -->
						<!--	<li><a href="<?php // echo site_url('salveofficer/violations'); ?>">Violation</a></li> --> 
							<li><a href="<?php echo site_url('salveofficer/directory'); ?>">Member's Directory</a></li>


						</ul>

					</li>

					<?php if($userrank=='branchmanager' || $userrank=='salveofficer') :?>
					<li class="menu"><a href="#"href class="menu">LOAN

						<?php 
							if ($userrank=='branchmanager' && (!$loanpending==0 || !$loanapproved== 0)) { ?>
							<div class="loannotification">
								<?php echo $loanpending+$loanapproved; ?>	</div>

							<?php	} else{ ?>
							<div class="loannotification">
								<?php echo $loanapproved; ?>	</div>

							<?php }?>
					 	</a>
						

						<ul>

							<?php if($userrank=='branchmanager') :?>
								<li><a href="<?php echo site_url('loanapplication/forloanapprovallist'); ?>">Pending Loan Application
								<?php if (!$loanpending == 0) { ?>
									<div class="loansubnotif"><?php echo $loanpending; ?></div>
									<?php } ?>
						</a></li>

							<?php endif;?>
							<?php if($userrank!='mispersonnel') :?>
							<!-- <li><a href="#" style="cursor: default;">Loan Application Status</a> -->
								<!-- <ul> -->
									<li><a href="<?php echo site_url('loanapplication/approvedloans'); ?>">Approved Loan 

										<div class="loansubnotif"><?php echo $loanapproved ?></div></a></li>
									<!-- <li><a href="<?php echo site_url('loanapplication/loanrejected'); ?>">Rejected Loan</a></li> -->
								<!-- </ul> -->

							</li>
							<?php endif;?>
							<?php if($userrank=='salveofficer') :?>
							<li><a href="<?php echo site_url('loanapplication/addnewloan'); ?>">New Loan Application</a></li>
							
							<li><a href="<?php echo site_url('dailycollection/collection'); ?>">Daily Collection</a>
								<ul>
									<li><a href="<?php echo site_url('dailycollection/editcollection'); ?>">Edit Collection</a></li>
									<li><a href="<?php echo site_url('dailycollection/individualcollection'); ?>">Individual Collection</a></li>
								</ul>
							</li>
							<?php endif;?>
							<!-- <li><a href="#">Current Loan Status</a>
								<ul>
									<li><a href="#">Active Loans</a></li>
									<li><a href="#">Past Due Loans</a></li>
								</ul>
							</li> -->

						</ul>
					</li>
				<?php endif; ?>
					<?php if($userrank=='salveofficer' || $userrank=='branchmanager') :?>
					<li class="menu"><a href="<?php echo site_url('downloads/downloadlist'); ?>" class="menu" style="cursor: pointer;">DOWNLOADS</a></li>
					<?php endif; ?>
					<li class="menu"><a href="<?php echo site_url('reports/reportList'); ?>" class="menu" style="cursor: pointer;">REPORTS</a>
						<ul>
							
							<!-- <li><a href="<?php echo site_url('reports/monthlycollection'); ?>">Monthly Collection</a></li> -->
							<!-- <li><a href="<?php echo site_url('reports/portfolioatrisk'); ?>">Portfolio At Risk</a></li> -->
							<!-- <li><a href="<?php echo site_url('reports/revenueandcost'); ?>">Revenue and Financial Costs</a></li> -->
							<?php if($userrank=='salveofficer') :?>
							<li><a href="<?php echo site_url('reports/dailycollectionsheet'); ?>">Daily Collection Sheet</a></li>
							<?php endif;?>
							<?php if($userrank=='branchmanager') :?>
							<li><a href="<?php echo site_url('reports/sbuandloan'); ?>">Savings Build-Up and Loan Report</a></li>
							<!-- <li><a href="<?php //echo site_url('reports/summaryreport'); ?>">Summary Report</a></li> -->
							<li><a href="<?php echo site_url('reports/dailycollectionsheet'); ?>">Daily Collection Sheet</a></li>
							<li><a href="<?php echo site_url('reports/centerperformance'); ?>">Collection Performance of Centers</a></li>
							<li><a href="<?php echo site_url('reports/borrowerandsaver'); ?>">Borrower vs Saver</a></li>
							<?php endif;?>
							<?php if($userrank=='mispersonnel') :?>
							<li><a href="<?php echo site_url('reports/branchpastdue'); ?>">Collection Performance of Branches</a></li>
							<!-- <li><a href="<?php // echo site_url('reports/dcsummary'); ?>">Daily Collection Summary</a></li> -->
							<li><a href="<?php echo site_url('reports/mismonthly'); ?>">Monthly Account Report</a></li>
							<li><a href="<?php echo site_url('reports/loanportfolio'); ?>">Monthly Loan Portfolio Report</a></li>
							<li><a href="<?php echo site_url('reports/pdmmonthly'); ?>">Monthly Past Due Mature Report</a></li>
							<li><a href="<?php echo site_url('reports/sbushares'); ?>">Monthly Savings Build-Up and Capital Shares Report</a></li>
							<?php endif;?>
						</ul>
					</li>
					
					

					<li class="menu"><a href="<?php echo site_url('records/recordlist'); ?>" class="menu" style="cursor: pointer;">RECORDS</a></li>
				</ul>
			</nav>
			<!--menu bar-->



<body>
		