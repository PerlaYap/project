<title>New User Report</title>

<link rel="stylesheet" type="text/css" href="<?php echo base_url('Assets/css/reports.css'); ?>">


<style type="text/css" media="print">
.dontprint{
	display: none;
}

</style>


<a href="<?php echo site_url('login/homepage'); ?>"> <img src="<?php echo base_url('Assets/images/caritaslogo.png'); ?>" class="caritaslogo"></a>

<br><br><br>
	<div style="margin-left:auto; margin-right:auto; text-align:center;">

		Welcome <?php echo $user['Name']?> (<?php echo $user['position']?>)! Your account has been activated. <br><b>Please change your password after logging in for the first time.</b> <br><br>

		
		Username:  <b> <?php echo $user['username'] ?></b>
		<br>
		Tentative Password:  <b><?php echo $user['password'] ?></b>
		<br>
		

		<br>
		


	</div>

	<br><br>
	<div class='dontprint' style="width: 100%; text-align: center;">
		<button onclick="window.print()">Print</button>
	</div>




