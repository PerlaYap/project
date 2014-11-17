<!DOCTYPE HTML>
<html>
	<head>
		<TITLE>Caritas Salve MIS</TITLE>
		<!--<link rel="stylesheet" type="text/css" href="<?php echo base_url('Assets/css/salveofficer.css'); ?>">
		<script src="<?php echo base_url('Assets/js/salveofficer.js'); ?>">-->
			<link rel="stylesheet" type="text/css" href="../css/salveofficer.css">
			<script type="text/javascript" src="../js/salveofficer.js"></script>
		
	</head>

	<body>

		<div class="accent">
				<p class="welcome">
					WELCOME! <!------CHANGE------>User &nbsp&nbsp 
					<a href="../login.php" class="welcome">[Sign Out]</a>
				</p>
		</div>

		<br>

		<div class="header">

			<div class ="tab">
				<img src="<?php echo base_url('Assets/images/caritaslogo.png'); ?>" class="caritaslogo">
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
				<form action="salveofficer/addnewmemberprocess" method="post" name="addnewmemberprocess" class="basic-grey">
					<h1>Member Account For Approval
				        <span>Contact the Salve Officer in-charge for any information descrepancies.</span>
				    </h1>

				    <label>
				    	<span>Photo :</span>
				        <input type="text" placeholder="for viewing" disabled/>
				    </label>
				    <label>
				    	<span></span>
				    	<input  type="file" name="image" id="file"/>
				    </label>
				    <br>

				    <label>
				        <span>SO in-charge :</span>
				        <input id="" type="text" name="" style="width: 562px;"  disabled/>
				    </label>

				    <label>
				        <span>Name :</span></label>
				        <input id="name" type="text" name="fname" style="width: 180px;" />
				        <input id="name" type="text" name="mname" style="width: 170px;"  />
				        <input id="name" type="text" name="lname" style="width: 175px;" />
				    
				   
				    <label>
				        <span>Center No :</span> </label>
				        <input id="" type="text" name="" style="width: 53px;"/>
				        &nbsp &nbsp &nbsp &nbsp
				        
				        Other Microfinance Institutions :</span>
				        <input id="others" type="text" name="others" style="width: 288px;" />


				    <label>
				        <span>Affiliated Organizations:</span></label>
				        <input id="affiliations" type="text" name="affiliations" style="width: 260px;" />
				        Position :
				        <input id="affiliations" type="text" name="affiliations" style="width: 188px;"  /> <input type="button" class="addmore2" value="+" onclick="addOrganization()"/>
					
				    
				    <div id="organizations"></div>

				   
				    <label>
				        <span>Home Address :</span>
				        <input id="haddress" type="text" name="haddress" style="width: 562px;"  />
				    </label>
				   
				    <label>
				    	<span>Years of Residency :</span> </label>
				        <input id="residency" type="text" name="residency" style="width:250px;"  /> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
				        Contact Number : 
				        <input id="contact" type="text" name="contact" style="width: 165px;"  />
				    

					<label>
				        <span>Provincial Address :</span>
				        <input id="paddress" type="text" name="paddress"  style="width: 562px;" />
				    </label>

				    <label>
				        <span>Birthday :</span> </label>
					        <select name="month" style="width:80px;">
						        <option value="" selected="selected"></option>
						        <option value="january">January</option>
						        <option value="february">February</option>
						        <option value="march">March</option>
						        <option value="april">April</option>
						        <option value="may">May</option>
						        <option value="june">June</option>
						        <option value="july">July</option>
						        <option value="august">August</option>
						        <option value="september">September</option>
						        <option value="october">October</option>
						        <option value="november">November</option>
						        <option value="december">December</option>
					        </select>

					        <select name="day" style="width:50px;">
						        <option value="" selected="selected"></option>
						        <option value="1">1</option>
						        <option value="2">2</option>
						        <option value="3">3</option>
						        
					        </select>

					        <select name="year" style="width:80px;">
						        <option value="" selected="selected"></option>
						        <option value="1990">1990</option>
						        <option value="1991">1991</option>
						        <option value="1992">1992</option>
						        <option value="1993">1993</option>
						        <option value="1994">1994</option>
					        </select>
					       
					        &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp

					        Birthplace: 
					        <input id="birthplace" type="text" name="birthplace" style="width: 242px;"   />
				    

				    <label>
				    	<span> Gender : </span> </label>
				    	<select name="gender" style="width:80px;">
				    			<option value="" selected="selected"></option>
						        <option value="male">Male</option>
						        <option value="female">Female</option>
					    </select>

					    &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp

				        Civil Status : 
						        <select id="selectMenu" onchange="toggle(this.options[this.options.selectedIndex].value)" style="width:130px;">
										<option value="blank" selected="selected"></option>
										<option value="single"> Single </option>
										<option value="married"> Married </option>
								</select>
				    	<!--<select name="selectMenu" style="width:130px;" onchange="toggle(this.options[this.options.selectedIndex].value)">
						        <option value="formNumber1">Single</option>
						        <option value="formNumber2">Married</option>
					    </select>-->

				        &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp

				        Religion :
				        <input id="religion" type="text" name="religion" style="width: 168px;" />
				    </label>

				    <label>
				    		<span>
				    		</span>
				    		----------------------------------------------------- MAIN INCOME -----------------------------------------------------

				    </label>

				    <label>
				        <span>Business Type :</span>
				        <input type="text" name="" id="" style="width: 562px;"  />
				    </label>

				    <label>
				        <span>Company Name :</span>
				        <input type="text" name="" id="" style="width: 562px;" />
				    </label>

				    <label>
				        <span>Contact :</span></label>
				        <input type="text" name="" id="" style="width: 250px;"  />
				    	&nbsp &nbsp &nbsp

				    	Years in the Business: 
				    	<input type="text" name="" id="" style="width: 155px;"/>


				    <!------ HOUSEHOLD -------->
				    <label>
				    		<span>
				    		</span>
				    		------------------------------------------------------ HOUSEHOLD ------------------------------------------------------

				    </label>

				    <div id="household"> 
				    
				    	<label>
					        <span>Name :</span></label>
					        <input id="hhname" type="text" name="name" style="width: 176px;"  />
					        <input id="hhname" type="text" name="name" style="width: 170px;"  />
					        <input id="hhname" type="text" name="name" style="width: 176px;"  />
					    
					    <label>
				        	<span>Relationship :</span> 
					        <input id="relationship" type="text" name="name"  style="width: 560px;"  />
					    </label>
					   	<label>
				        	<span>Occupation :</span> 
					        <input id="occupation" type="text" name="name"  style="width: 560px;" />
					    </label>
					    <label>
				        	<span>Civil Status :</span> </label>
					        <input id="civilstat" type="text" name="name"  style="width: 350px;"  />
					        &nbsp&nbsp&nbsp
					        Age : 
					        <input id="age" type="text" name="name"  style="width: 150px;"  />

					     <label>
					     	<span></span>
					     	------------------------------------------------------------------------------------------------------------------------------
					     </label>

  
					</div>

					<div id="household"></div>

						<label>
							<span></span>
							<input type="button" class="addmore" value="+ MORE" onclick="addHousehold()"/>
						</label>
				    <br>

				    <label>
				    	<span>Barangay Clearance :</span>
				    	<input id="age" type="text" name="name"  placeholder="for viewing"  disabled/>
				    </label>
				    <label>
				    	<span></span>
				    	<input  type="file" name="image" id="file"/>
				    </label>

				    	
				    </label>


				    <br><br>
				     <label>
				        <span></span>
				        <input type="submit" class="button" value="Save Changes" /> &nbsp&nbsp&nbsp <input type="submit" class="button1" value="Cancel" />
				    </label>  
				</form>
		</div>
	</body>
</html>