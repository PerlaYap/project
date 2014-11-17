<link rel="stylesheet" type="text/css" href="<?php echo base_url('Assets/css/branchmanager.css'); ?>">
		<script src="<?php echo base_url('Assets/js/general.js') ?>"></script>

		<script type="text/javascript">

			function send(control_no){
				window.location.href= "forapprovals?name="+ control_no;
			}

		</script>
		<div class="content">
			<h1>Recently Approved Accounts</h1>
			<div class="grid grid-pad">


				<!--<?php //foreach ($getMember->result() as $result) {?>-->
				<div class="col-1-4">
					<div class="content1">
						<div class="red-accent"></div>
						<br>
						<p class="col-lastname"><?php //echo $result->Name; ?></p>
						<p class="col-branch">Paco - 33</p>
						<a href="javascript:void(0)" onclick=""class='col-button'>View Profile</a>
						<br><br><br>
<!-- 						<p class="daysago">Approved 3 days ago</p> -->
					</div>
				</div> 
				<?php //} ?>

			</div>

		</div>