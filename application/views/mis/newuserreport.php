<title>New User Report</title>

<link rel="stylesheet" type="text/css" href="<?php echo base_url('Assets/css/reports.css'); ?>">

<a href="<?php echo site_url('login/homepage'); ?>"> <img src="<?php echo base_url('Assets/images/caritaslogo.png'); ?>" class="caritaslogo"></a>

	Name: <?php echo $user['Name'] ?>
	<br>
	Position: <?php echo $user['position'] ?>
	<br>
	<!-- Pls make emphasize -->
	Username: <?php echo $user['username'] ?>
	<br>
	Tentative Password: <?php echo $user['password'] ?>
	<br>
	<!-- Pls make emphasize like bold, larger font, font color -->

	<br>
	Note: Please  change your password after logging in for the first time.


	<div style="width: 100%; text-align: center;">
		<button onclick="window.print()">Print</button>
	</div>




