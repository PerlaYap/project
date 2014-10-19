
<?php 

$branch = $this->session->userdata('branch');
$branchno = $this->session->userdata('branchno');
$centers = $this->db->query("SELECT `CaritasBranch_ControlNo` as BranchCNo, `CaritasCenters_ControlNo` as CenterCNo, `CenterNo` FROM `caritasbranch_has_caritascenters`, `caritascenters` WHERE `CaritasCenters_ControlNo` = `caritascenters`.`ControlNo` and `CaritasBranch_ControlNo` = $branchno ");

date_default_timezone_set('Asia/Manila');


?>
	
			
			<div class="content">
				<br>
				<form action="addnewmemberprocess" method="post" name="addnewmemberprocess" enctype="multipart/form-data" class="basic-grey">
					<h1>Member Personal Information
				        <span>Please fill all the texts in the fields.</span>
				    </h1>
				   
				    <label>
				        <span>Name :</span></label>
				        <input readOnly="True" id="name" type="text" name="fname" placeholder="First Name" style="width: 210px;" value="<?php echo $fname ?>"/>
				        <input readOnly="True" id="name" type="text" name="mname" placeholder="Middle Name" style="width: 150px;" value="<?php echo $mname ?>"/>
				        <input readOnly="True" id="name" type="text" name="lname" placeholder="Last Name" style="width: 175px;" value="<?php echo $lname ?>"/>
				 

				    <label>
				        <span>Caritas Salve Branch :</span> </label>

				        <input type="text" name="branch" style="width:40px;" value="<?php echo $branchno ?>" disabled>
				        <input type="text" name="branchname" style="width:300px;" value="<?php echo $branch ?>" disabled>
				        <input hidden type="text" name="approved" style="width:400px;" value="P" >
				
				        &nbsp &nbsp &nbsp &nbsp&nbsp &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
				        Center No. : 

				        <select required name="centernumber" style="width:53px;">
				    			<option value="" selected="selected"></option>
				 
				    		<?php
				    		foreach ($centers->result() as $row) { 

				    			echo "<option value='".$row->CenterCNo."'>".$row->CenterNo."</option>" ;

				    		 } ?>

			

				    			
				    		
					    </select> 

				    <label>
				        <span>Affiliated Organizations:</span></label>
				        

				        <input id="affiliations" type="text" name="org" style="width: 260px;" />
				        Position :
				        <input id="affiliations" type="text" name="pos" style="width: 188px;" />
				     <input type="button" class="addmore2" value="+" onclick="addOrganization()"/>
				        

				          
				    	<div id="organizations"></div>

				         
					
				   

				    <label>
				        <span>Other Microfinance Institutions :</span>
				        <input id="others" type="text" name="othersmicro" style="width: 550px;" />
				    </label>

				    <label>
				        <span>Home Address :</span>
				        <input required="" id="haddress" type="text" name="haddress" style="width: 550px;" />
				    </label>
				   
				    <label>
				    	<span>Years of Residency :</span> </label>
				        <input required="" id="residency" type="number" name="residency" min='1' style="width:30px;" /> &nbsp&nbsp&nbsp&nbsp
				        
				        Contact Number : 
				        <input required="" id="contact" type="text" name="contact" style="width: 140px;" placeholder="7 or 11-digit number only" /> &nbsp&nbsp&nbsp&nbsp
				    
				    	Educational Attainment :
				        	<select required="" name="educattain" style="width:100px;">
						        <option value="" selected="selected"></option>
						        <option value="Elementary">Elementary</option>
						        <option value="High School">High School</option>
						        <option value="College">College</option>

					        </select>    


				    <label>
				        <span>Birthday :</span> </label>
				        <input readOnly="true" type="text" name="bday" style="width: 210px;" value="<?php echo $bday ?>" > 
					       <!--<select name="month" style="width:80px;" required>
						        <option value="" selected="selected"></option>
						        <option value="01">January</option>
						        <option value="02">February</option>
						        <option value="03">March</option>
						        <option value="04">April</option>
						        <option value="05">May</option>
						        <option value="06">June</option>
						        <option value="07">July</option>
						        <option value="08">August</option>
						        <option value="09">September</option>
						        <option value="10">October</option>
						        <option value="11">November</option>
						        <option value="12">December</option>
					        </select>

					        <select name="day" style="width:50px;" required>
						        <option value="" selected="selected"></option>
						        <?php  for ($i=1; $i < 32 ; $i++) { ?>

							        <?php if ($i<10) { ?>
							        		
							        <option value="<?php echo '0'.$i ?>"><?php echo '0'.$i ?></option>		

							       	<?php } else{ ?>

							       	<option value="<?php echo $i ?>"><?php echo $i ?></option>

							      	<?php } ?>
						      <?php  } ?>
						        
					
						        
					        </select>

					        <select name="year" style="width:80px;" required>
						        <option value="" selected="selected"></option>
						        <?php  $yend =date('Y')-17;
						        		$ystart = $yend-50;
						        for ($y=$ystart; $y < $yend ; $y++) { ?>

							       <option value="<?php echo $y ?>"><?php echo $y ?></option>

						        <?php  } ?>
					        </select>
					       -->
					        &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp

					        Birthplace: 
					        <input id="birthplace" type="text" name="birthplace" style="width: 230px;" required/>
				    

				    <label>
				    	<span> Gender : </span> </label>
				    	<select name="gender" style="width:80px;" required>
				    			<option value="" selected="selected"></option>
						        <option value="Male">Male</option>
						        <option value="Female">Female</option>
					    </select>

					    &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp

				         Civil Status : 
						       <select required name="apple" id="selectMenu" onchange="toggle(this.options[this.options.selectedIndex].value)" style="width:130px;">
										<option value="" selected="selected"></option>
										<option value="Single">Single</option>
										<option value="Married">Married</option>
								</select>
				    	

				        &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp

				        Religion :
				        <input id="religion" required type="text" name="religion" style="width: 155px;" />
				    </label>

				    <label>
				    		<span>
				    		</span>
				    		----------------------------------------------------- MAIN INCOME -----------------------------------------------------

				    </label>

				    <label>
				        <span>Business Type :</span>
				        <input type="text" name="businesstype" id="" style="width: 550px;" required/>
				    </label>

				    <label>
				        <span>Company Name :</span>
				        <input type="text" name="companyname" id="" style="width: 550px;" required/>
				    </label>

				    <label>
				        <span>Contact :</span></label>
				        <input type="text" name="companycontact" id="" style="width: 250px;"/>
				    	&nbsp &nbsp &nbsp

				    	Year Entered in Business: 
				    	<input type="number" name="yearinbusiness" id="" style="width: 135px;" min='1' required/>


				    <!------ HOUSEHOLD -------->
				    <label>
				    		<span>
				    		</span>
				    		------------------------------------------------------ HOUSEHOLD ------------------------------------------------------

				    </label>

				    <div id="household"> 
				    
				    	<label>
					        <span>Name :</span></label>
					        <input id="hhname" type="text" name="hfname" placeholder="First Name" style="width: 207px;" required/>
					        <input id="hhname" type="text" name="hmname" placeholder="Middle Name" style="width: 150px;" required/>
					        <input id="hhname" type="text" name="hlname" placeholder="Last Name" style="width: 176px;" required/>
					    
					    <label>
				        	<span>Relationship :</span> 
				        	<select name="relationship" style="width: 550px; height: 35px;" required>
				        		<option> </option>
				        		<option>Grandparent</option>
				        		<option>Father</option>
				        		<option>Mother</option>
				        		<option>Child</option>
				        		<option>In-Law</option>
				        	</select>
					        <!--<input id="relationship" type="text" name="relationship"  style="width: 560px;"/>-->
					    </label>
					   	<label>
				        	<span>Occupation :</span> 
					        <input id="occupation" type="text" name="occupation"  style="width: 550px;" required/>
					    </label>
					    <label>
				        	<span>Civil Status :</span> </label>
				        	<select name="c_status" id="selectMenu" onchange="toggle(this.options[this.options.selectedIndex].value)" style="width:145px;" required>
										<option value="" selected="selected"></option>
										<option value="Single">Single</option>
										<option value="Married">Married</option>
								</select>
					        <!-- <input id="civilstat" type="text" name="c_status"  style="width: 140px;"/> -->
					        &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
					       
					        Age : 
					        <input id="age" type="text" name="age"  style="width: 150px;" required/>
					      
					       &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
					       
					       Gender : 
				    		<select name="pine" style="width:80px;" required>
				    			<option value="" selected="selected"></option>
						        <option value="male">Male</option>
						        <option value="female">Female</option>
					    </select>

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
				     
						
				    </label> 

				   <label>
				    	<span>Valid ID: </span><br>
						 <input name="file" type="file" required  width="400" height="200"/><br ><br>
						
				    </label>
				    <br><br>
				      <label>
				    	<span>Barangay Clearance: </span><br>
						 <input name="docu" type="file"  required  width="200" height="auto"/><br ><br>
						
				    </label>

				    <br>

			
				    <br><br>
				    <label>
				        <span></span>
				        <input type="submit" class="button" value="Submit" />
				    </label> 
				    </form>
				</form>
		</div>
	
