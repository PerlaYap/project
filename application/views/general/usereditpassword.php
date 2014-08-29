<!-- <link rel="stylesheet" type="text/css" href="<?php echo base_url('Assets/css/salveofficer.css'); ?>"> 
	 <script src="<?php echo base_url('Assets/js/salveofficer.js'); ?></script>">
-->
	<link rel="stylesheet" type="text/css" href="../../../Assets/css/salveofficer.css">
	<script src="../../../js/general.js"></script>


<body>

	<div class="content2">
		<h2 class="UserName">
			Lyka Dado
		</h2>

		<div class="underline"></div>

			<p class="userInfo1"> <b>Date Joined: </b> August 29, 2010</p>
			<p class="userInfo"> <b>Position: </b> Salve Officer</p>
			
			<!--<p class="userInfo"> 
				<b>Password: </b> 
				<input type="password" value="password" disabled/> 
				<input type="button" class="changepw" value="Change Password"/>
			</p>-->


		<div id="ChangePassword">

			<p class="PWhdr">CHANGE PASSWORD</p>

			<div class="PWunderline"></div>

			<form>
				<p class="pwInfo1">
					<b>Current Password:</b>
					<input type="password" required/> 
				</p>
				<p class="pwInfo">
					<b>New Password:</b>
					<input type="password" required/> 
				</p>
				<p class="pwInfo">
					<b>Confirm Password:</b>
					<input type="password" required/> 
				</p>

				<br>
				<input type="submit" value="Submit" class="btnPW"/>
				<input type="submit" value="Cancel" class="btnPW1"/>
			</form>

		
		</div>

		<br><br><br>



	</div>

</body>