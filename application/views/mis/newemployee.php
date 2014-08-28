<!DOCTYPE HTML>
<html>
	<head>
		<TITLE>Caritas Salve MIS</TITLE>
		<link rel="stylesheet" type="text/css" href="../css/mis.css">
		<script src="../js/mis.js"></script>
	</head>

	<body onload="hideAllDivs();">

		<div class="accent">
				<p class="welcome">
					WELCOME! <!------CHANGE------>User &nbsp&nbsp 
					<a href="../login.php" class="welcome">[Sign Out]</a>
				</p>
		</div>

		<br>

		<div class="header">

			<div class ="tab">
				<img src="../images/caritaslogo.png" class="caritaslogo">
			</div>

			<div class="search">
				<form>
					<input type="text" id="" name="" class="search"placeholder="Search..."/><input type="submit" class="searchbtn">
				</form>
			</div>

			<!--menu bar-->
			<div class="navBG"></div>
			
	<!------------- I THINK SA USER FILTER TO'? ---------->
			<?php if($this->session->userdata('rank')=='branchmanager') {
				echo "<li><a href=".site_url('general/membersbybranch').">Branch</a></li>";
			}?>	
	<!------------- I THINK SA USER FILTER TO'? ---------->

			<nav class= "menu">
				<ul>
					<li class="menu"><a href="#" class="menu">ACCOUNTS</a>
						<ul>
							<li><a href="<?php echo site_url('mis/addnewofficer'); ?>">New Officer's Account</a></li>
							<li><a href="<?php echo site_url('mis/newbranch'); ?>">New Branch</a></li>
							<li><a href="<?php echo site_url('branchmanager/newcenter'); ?>">New Center</a></li>
						</ul>
					</li>
					<li class="menu"><a href="#" class="menu">MEMBERSHIP</a>
						<ul>
							<li><a href="<?php echo site_url('salveofficer/addnewmember'); ?>">New Member's Account</a></li>
							<li><a href="<?php echo site_url('branchmanager/approvallist'); ?>">Pending Accounts</a></li>
							<li><a href="<?php echo site_url('salveofficer/approvedaccounts'); ?>">Approved Member Accounts</a></li>
						</ul>
					</li>
					<li class="menu"><a href="#"href class="menu">LOAN</a>
						<ul>
							<li><a href="#">Daily Loan Collection</a></li>
							<li><a href="<?php echo site_url('salveofficer/addnewloan'); ?>">New Loan Application</a></li>
							<li><a href="#">Current Loan Status</a>
								<ul>
									<li><a href="#">Active Loans</a></li>
									<li><a href="#">Past Due Loans</a></li>
								</ul>
							</li>
						</ul>
					</li>
					<li class="menu"><a href="#" class="menu" style="cursor: pointer;">DOWNLOADS</a></li>
					<li class="menu"><a href="#" class="menu" style="cursor: pointer;">REPORTS</a></li>
					<li class="menu"><a href="#" class="menu" style="cursor: pointer;">RECORDS</a></li>
				</ul>
			</nav>
		</div>
			<!--menu bar-->
			<div class="content">
				<br>
				<form action="" method="post" class="basic-grey">
					<h1>New Officer Account
				        <span>Please fill all the texts in the fields.</span>
				    </h1>
	
				    <label>
				        <span>Name :</span></label>
				        <input id="name" type="text" name="name" placeholder="First Name" style="width: 180px;"/>
				        <input id="name" type="text" name="name" placeholder="Middle Name" style="width: 170px;"/>
				        <input id="name" type="text" name="name" placeholder="Last Name" style="width: 175px;"/>
				   

				    <label>
				        <span>Personnel ID :</span> </label>
				        <input id="personnelid" type="text" name="personnelid"/>
				        			    

				    <label>
				        <span>Password :</span> </label>
				        <input id="password" type="password" name="password" style="width: 208px;" />
				        &nbsp&nbsp&nbsp&nbsp&nbsp
				        Confirm Password:
				        <input id="cpassword" type="password" name="cpassword" style="width: 210px;" />

				    <label>
				        <span>Position :</span> </label>
					        <select name="position" style="width:300px;">
						        <option value="" selected="selected"></option>
						        <option value="salveofficer">Salve Officer</option>
						        <option value="branchmanager">Branch Manager</option>
						        <option value="mis">MIS Personnel</option>
					        </select>

					        &nbsp&nbsp&nbsp&nbsp

					        Branch : 
					        <select name="branch" style="width:197px;">
						        <option value="" selected="selected"></option>
						        <option value="sample">Sample</option>
					        </select>


					   <div id="center">  
						    <label>
						        <span>Center(s) :</span></label>
					        	<input id="center" type="text" name="center" style="width:50px;"/>
						</div>

						<label>
							<span></span>
							<input type="button" class="addmore" value="+" onclick="addCenter()"/>
						</label>


				    <br><br>
				     <label>
				        <span></span>
				        <input type="button" class="button" value="Send" />
				    </label>  
				</form>
			<br><br>
		</div>
	</body>
</html>