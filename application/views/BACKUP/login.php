<!DOCTYPE HTML>
<html>
	<head>
		<TITLE>Caritas Salve MIS</TITLE>

		<link rel="stylesheet" type="text/css" href="<?php echo base_url('Assets/css/login.css'); ?> ">
			
	</head>

	<body>

		<div class="header">
		<br>
			<div class ="tab">
				<img src="<?php echo base_url('Assets/images/caritaslogo.png'); ?>" class="caritaslogo">
			</div>

		</div>
		<br><br>
		<div class="loginform">
			<form action='login/process' method='post' name='process' class="login">
				<input type="text" name='username' placeholder="Username" required="" id="username" />
				<input type="password" name='password' placeholder="Password" required="" id="password" />
				<input type="submit" value="Log in" />
			</form>

		</div>
		
		
			
		
	</body>

</html>