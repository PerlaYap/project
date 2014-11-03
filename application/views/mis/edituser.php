<script type="text/javascript">

	 function cancelfunction () {
	 	var txt;
	 	var r = confirm("Are you sure you want to cancel?");
	 	if (r== true) {
	 		window.location.href="listofusers";
	 	}
	 }
	 function resetpassword(){
	 	var r = confirm("Are you sure you want to reset the password?");
	 	if (r==true) {
	 		document.getElementById("resetform").submit();
	 	}
	 	
	 }

	 </script>

<?php 
$control_no = $_GET['name'];

$getOfficer = $this->db->query("SELECT p.`ControlNo`, `FirstName`, `MiddleName`, `LastName`, `Rank`, `PersonnelID`,`IsActive` FROM `caritaspersonnel` p join `users` u on p.ControlNo = u.ControlNo WHERE p.ControlNo =$control_no");
		

	
	foreach ($getOfficer->result() as $off) {
		$fname = $off->FirstName;
		$mname = $off->MiddleName;
		$lname = $off->LastName;
		$username = $off->PersonnelID;
		$rank = $off->Rank;
	}

?>

<div class="content">
				<br>
				<form action="edituser" method="post" name="edituser" class="basic-grey">
					<h1>Edit User
				      
				    </h1>
	
					 <label>
				        <span>Control Number:</span></label>
						 <input type='text' name='controlno' readonly value="<?php echo $control_no; ?>">

				    <label>
				        <span>Name :</span></label>
				        
				        <input id="name" readonly type="text" name="fname" value="<?php echo $fname ?>" style="width: 140px;"  />
				        <input id="name" readonly type="text" name="mname" value="<?php echo $mname ?>" style="width: 160px;" />
				    	<input id="name" readonly type="text" name="lname" value="<?php echo $lname ?>" style="width: 170px;" />
				   

				    <label>
				        <span>Personnel ID :</span> </label>
				        <input id="personnelid" type="text" name="username" readonly='true' value="<?php echo $username  ?>" />
				        	
				       <!-- <label>
				        <span>Password :</span> </label>
				        <input id="password" type="password" name="password"  value="<?php echo $off->Password; ?>" /> -->		    

				    <label>
				        <span>Position :</span> </label>
					     <select name="position" id="position" style="width:350px;">
						     <?php if ($rank =='salveofficer'){ ?>

										<option value="salveofficer" selected="selected"> Salve Officer </option>
										<option value="branchmanager"> Branch Manager </option>
										<option value="mispersonnel"> MIS Personnel </option>
										<?php } else if($rank =='branchmanager'){?>
										<option value="salveofficer"> Salve Officer </option>
										<option value="branchmanager" selected='selected'> Branch Manager </option>
										<option value="mispersonnel"> MIS Personnel </option>
										<?php } else{?>
										<option value="salveofficer"> Salve Officer </option>
										<option value="branchmanager" > Branch Manager </option>
										<option value="mispersonnel" selected='selected'> MIS Personnel </option>
										<?php } ?>
					
								</select>

				    <br><br>
				     <label>
				        <span></span>

				        
				        <br>
				        <span></span>


				        <style type="text/css">

				        	.disableUser, .enableUser{
				        		width: 35px;
				        		height: 35px;
				        		position: absolute;
				        		margin-top: -281px;
				        		margin-left: 700px;
				        		margin-right: auto;
				        		background: transparent;
				        		border: 2px solid #e94747;
				        		border-radius: 5px;
				        		color: #e94747;
				        		font-size: 14px;
				        		cursor: pointer;
				        	}

				        		.disableUser:hover, .enableUser:hover{
				        			border: 3px solid #e94747;
				        			font-weight: bold;
				        			cursor: pointer;
				        		}

				        		.enableUser:hover{
				        			border: 3px solid #34c169;
				        		}

				        	.enableUser{
				        		color: #2ead5e;
				        		border: 2px solid #34c169;
				        	}

				        	.resetPW{
				        		border: 0;
				        		font-size: 12px;
				        		color: #777978;
				        		background: transparent;
				        		cursor: pointer;
				        		position: absolute;
				        		margin-top: -160px;
				        		margin-left: 735px;				        	
				        	}


				        </style>

				       <div style="position: absolute; margin-top: 85px; margin-left: -30px;">
				    			<?php    if ($off->IsActive==1) { ?>
	
											<!-- <input type='hidden' name='active' value='0'> -->

										<input type='submit' name='subs' value='X' class='disableUser'/>
										
							<?php			}else{ ?> 
											
											<!-- <input type='hidden' name='active' value='1'> -->
										<input type='submit' name='subs' value='&#10004' class='enableUser'/>
									
								<?php		} ?>
						</div> 		 



				    <input type="submit" name='subs' class="button" value="Save" style="width: 105px; margin-left: 355px;" />
				    <input type='button' name='cancel'  onclick="cancelfunction()" value="Cancel" class="button1" style="margin-top: 0px;margin-left: 5px;">    
				    
				    </label>  
				</form>

				        <form id="resetform" action='resetpassword' method='post'>
				        <input type='hidden' name='controlno'  value="<?php echo $control_no; ?>">
				        <input id="name"  type="hidden" name="fname" value="<?php echo $fname ?>" style="width: 170px;"  />
				        <input id="name"  type="hidden" name="mname" value="<?php echo $mname ?>" style="width: 175px;" />
				    	<input id="name"  type="hidden" name="lname" value="<?php echo $lname ?>" style="width: 180px;" />
				    	<input id="personnelid" type="hidden" name="username" value="<?php echo $username  ?>" />
				    	<input type="hidden" name='position' value='<?php echo $rank ?>' />





				        <!------------- RESET PASSWORD BUTTON (FOR LYKA) -------------->
				        <input type='button' onclick='resetpassword()' value='Reset Password' class="resetPW">
				        </form>
			<br><br><br><br>
		</div>
	</body>
</html>