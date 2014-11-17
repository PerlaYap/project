 <?php 
 	 $username = $this->session->userdata("firstname");
 	 $userrank = $this->session->userdata("rank");
 	 $personnelno = $this->session->userdata("personnelno");
  ?>

 <link rel="stylesheet" type="text/css" href="<?php echo base_url('Assets/css/salveofficer.css'); ?>"> 
	 <script src="<?php echo base_url('Assets/js/salveofficer.js'); ?>"></script>
	 

	 <script type="text/javascript">

	 function cancelfunction () {
	 	var txt;
	 	var r = confirm("Are you sure you want to cancel?");
	 	if (r== true) {
	 		window.location.href="homepage";
	 	}
	 }

	 </script>

	


<body>

	<div class="content2">
		<h2 class="UserName">
			<?php echo $username; ?>
		</h2>

		<div class="underline"></div>

			<p class="userInfo1"> <b>Date Joined: </b> August 29, 2010</p>
			<p class="userInfo"> <b>Position: </b> <?php echo $userrank; ?></p>
			
			<!--<p class="userInfo"> 
				<b>Password: </b> 
				<input type="password" value="password" disabled/> 
				<input type="button" class="changepw" value="Change Password"/>
			</p>-->


		<div id="ChangePassword">

			<p class="PWhdr">CHANGE PASSWORD</p>

			<div class="PWunderline"></div>

			<form action='editpasswordcheck' method='post'>
				<p class="pwInfo1">
					<b>Current Password:</b>
					<input type="password" name ='currentpassword' required/> 
				</p>
				<p class="pwInfo">
					<b>New Password:</b>
					<input type="password" name='newpassword' required/> 
				</p>
				<p class="pwInfo">
					<b>Confirm Password:</b>
					<input type="password" name='confirmpassword' required/> 
				</p>

				<br>
				<input type='hidden' value='<?php echo $personnelno ?>' name="personnelno" />
				<input type="submit" value="Submit"  class="btnPW"/>
				<input type="button" value="Cancel"  onclick="cancelfunction()" class="btnPW1"/>
			</form>

		
		</div>

		<br><br><br>



	</div>

</body>