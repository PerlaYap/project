<!DOCTYPE HTML>
<html>
	<head>
		<TITLE>Caritas Salve MIS</TITLE>
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('Assets/css/salveofficer.css'); ?>">
		<script src="<?php echo base_url('Assets/js/salveofficer.js'); ?>">
			</script>
	</head>

	<body>

		<div class="accent">
				<p class="welcome">
					WELCOME! <?php echo $this->session->userdata('firstname'); ?> &nbsp&nbsp 
					<a href="<?php echo site_url('login'); ?>" class="welcome">[Sign Out]</a>
				</p>


		</div>
			<br>
		<div class="header">

			<div class="tab">
				<a href="<?php echo site_url('login/homepage'); ?>"> <img src="<?php echo base_url('Assets/images/caritaslogo.png'); ?>" class="caritaslogo"></a>
			</div>


			<div class="search">
				<form action="search" method="post" name="search" >

					<select name="keyword" class="search" onchange="changeSearch(this.value)" hidden   >
						
						<option value="name" hidden selected>Center</option> 
					</select>
					
					<input type="text" name="searchvalue" class="search" placeholder="Search..."/>
					<input type="submit" name="submit" value = ""class="searchbtn">
					
					<!--  class="searchbtn" -->
				</div>

				</form>
			
		
		