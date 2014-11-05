<?php $control_no =  $number; 
	$branchno = $this->session->userdata('branchno');
/*if ($number=="") {
	$control_no = '2';
}else{
	$control_no = $number;
}*/


$getMember =$this->db->query("SELECT  mem.ControlNo, MemberID,memname.LastName,memname.FirstName, memname.MiddleName, ContactNo,Birthday,BirthPlace, GenderID, Religion, EducationalAttainment,CivilStatus, MFI,Address,AddressDate, Status, Type,BusinessType,CompanyName,CompanyContact,YearEntered, LoanExpense,Savings, CapitalShare 
                                FROM 
                                Members mem 
                                LEFT JOIN MembersName memname ON mem.ControlNo=memname.ControlNo
                                LEFT JOIN (SELECT ControlNo, Status FROM members_has_membersmembershipstatus ORDER BY DateUpdated DESC LIMIT 1) mhmstatus ON mem.ControlNo=mhmstatus.ControlNo
                                
                                LEFT JOIN (SELECT ControlNo, Type FROM members_has_membertype ORDER BY DateUpdated DESC LIMIT 1) mhmtype ON mem.ControlNo=mhmtype.ControlNo
                                LEFT JOIN MembersContact memcontact ON mem.ControlNo=memcontact.ControlNo
                                LEFT JOIN membersmfi mfi ON mem.ControlNo=mfi.ControlNo
                                LEFT JOIN membersaddress madd ON mem.ControlNo=madd.ControlNo
                                LEFT JOIN sourceofincome soi ON mem.ControlNo=soi.ControlNo
                                WHERE mem.ControlNo='$control_no'");

$getHousehold =$this->db->query("SELECT ControlNo, msmhouse.HouseholdNo, Relationship, Age, GenderID, CivilStatus, A.Name, A.Occupation
                    FROM members_has_membershousehold msmhouse
                    LEFT JOIN 
                    (SELECT memhouse.HouseholdNo AS HouseholdNo, Age, GenderID, CivilStatus,  concat(hname.LastName,', ',hname.FirstName,' ', hname.MiddleName) AS Name, Occupation FROM membershousehold memhouse
                    LEFT JOIN householdname hname ON memhouse.HouseholdNo=hname.HouseholdNo
                    LEFT JOIN householdoccupation hoccu ON memhouse.HouseholdNo=hoccu.HouseholdNo)A ON msmhouse.HouseholdNo=A.HouseholdNo
                    WHERE ControlNo='$control_no'");

$getOrganization =$this->db->query("SELECT * FROM `membersorganization` WHERE `ControlNo`='$control_no' ");

$getbranchandcenter = $this->db->query("SELECT cm.`CaritasCenters_ControlNo`, cc.`CenterNo`, cbc.`CaritasBranch_ControlNo`, b.`BranchName`
FROM `caritascenters_has_members` cm, `caritascenters` cc, `caritasbranch_has_caritascenters` cbc,
`caritasbranch` b
where `Members_ControlNo` = $control_no and cm.`CaritasCenters_ControlNo` = cc.`ControlNo` and
cbc.`CaritasCenters_ControlNo` = cc.`ControlNo` and
b.ControlNo = cbc.`CaritasBranch_ControlNo`");

$getcentersofbranch = $this->db->query("SELECT `CaritasCenters_ControlNo`, `CenterNo` FROM `caritasbranch_has_caritascenters` bc join `caritascenters` c on bc.`CaritasCenters_ControlNo` = c.ControlNo
where `CaritasBranch_ControlNo` =$branchno");

foreach ($getbranchandcenter->result() as $bc) {
	$branch = $bc->BranchName;
	$center = $bc->CenterNo;
}


	

	foreach ($getMember->result() as $mem) {

			$lastname = $mem->LastName;
			$middlename = $mem->MiddleName;
			$FirstName = $mem->FirstName;
			$memid = $mem->MemberID;
			$mfi = $mem->MFI;
			$addresshome = $mem->Address;
			$addressdate = $mem->AddressDate;
			$contactno = $mem->ContactNo;
			$bday = $mem->Birthday;
			$bplace = $mem->BirthPlace;
			$gender_id =$mem->GenderID;
			$cstatus = $mem->CivilStatus;
			$religion = $mem->Religion;
			$btype = $mem->BusinessType;
			$companyname = $mem->CompanyName;
			$comcontact = $mem->CompanyContact;
			$yearen = $mem->YearEntered;
			$edu = $mem->EducationalAttainment;
			$membersid = $mem->MemberID;
			}





?>

<link rel="stylesheet" type="text/css" href="<?php echo base_url('Assets/css/salveofficer.css'); ?>">
<script src="<?php echo base_url('Assets/js/salveofficer.js'); ?>"></script>

			<div class="content">
				<br>
				<form action="editmember" method="post" name="editmember" class="basic-grey">
					<h1>Edit Profile
				       <!--  <span>Contact the Salve Officer in-charge for any information descrepancies.</span> -->
				    </h1>

				    <!-- <label>
				    	<span>Photo :</span>
				        <input type="text" placeholder="for viewing" disabled/>
				    </label>
				    <label>
				    	<span></span>
				    	<input  type="file" name="image" id="file"/>
				    </label> -->
				    <br>
<!-- 
				    <label>
				        <span>SO in-charge :</span>
				        <input id="" type="text" name="" style="width: 562px;"  disabled/>
				    </label> -->
				    <input type='hidden' value='<?php echo $control_no; ?>' name='controlno'/>
				    <label>
				    	
				        <span>Name :</span></label>
				        <input id="name" readonly="true" type="text" name="fname" value="<?php echo $lastname; ?>" style="width: 180px;" />
				        <input id="name" readonly="true" type="text" name="mname" value="<?php echo $FirstName; ?>" style="width: 170px;"  />
				        <input id="name" readonly="true" type="text" name="lname" value="<?php echo $middlename; ?>" style="width: 175px;" />
				    <label>
				    	  <!-- if member has member id already, view it and disable it if wala pa, add memberid -->

				        <!-- <span>Member's ID :</span></label> -->
				        <?php //if (!empty($membersid)) {?>
				        <input id="name" readonly  type="hidden" value="<?php echo $membersid ?>" name=""  style="width: 562px;" />	
				        <?php //} else{?>
				        
				   
				    <label>
				        <span>Center No :</span> </label>
				      
				        <!-- <input id="" disabled type="text" name="centerno" value="<?php echo $center; ?>" style="width: 53px;"/> -->
				        <select style="width: 53px;" name='centerno'>
				        	<?php foreach ($getcentersofbranch->result() as $bc):
				        				$cen = $bc->CenterNo; 
				        				$cen_control = $bc->CaritasCenters_ControlNo;
				        				?>

				        			<?php if ($center == $cen){ ?>
				        					<option selected value='<?php echo $cen_control ?>' ><?php echo $cen ?></option>
				        				<?php } else { ?>
				        					<option value='<?php echo $cen_control ?>'><?php echo $cen ?></option>
				        				<?php } ?>	
				        	<?php endforeach ?>
				        	<option></option>

				        </select>

				        &nbsp &nbsp &nbsp &nbsp
				        
				        Other Microfinance Institutions :</span>
				        <input disabled id="others" value="<?php echo $mfi ?>" type="text" name="others" style="width: 288px;" />

					<?php foreach ($getOrganization->result() as $org) {?>
				    	
				    	<label>
				    	
				        <span>Affiliated Organizations:</span></label>
				        
				        	
				        <input name='orgorig[]'  value="<?php echo $org->Organization; ?>" type="hidden" />
				        <input name='org[]' id="affiliations"  value="<?php echo $org->Organization; ?>" type="text" name="affiliations" style="width: 260px;" />
				        Position :
				        <input  name='pos[]' id="affiliations" value="<?php echo $org->Position; ?>" type="text" name="affiliations" style="width: 188px;"  /> 

				        <?php } ?>
				        <input type="button" class="addmore2" value="+" onclick="addOrganization()"/>
					
				    
				    <div id="organizations"></div>

				    <label>
				    	<span>Educational Attainment: </span> </label>
				        <input disabled id="residency" type="text" value="<?php echo $edu; ?>" name="residency" style="width:562px;"  />
				   
				    <label>
				        <span>Home Address :</span>
				        <input id="haddress" value="<?php echo $addresshome; ?>" type="text" name="haddress" style="width: 562px;"  />
				    </label>
				   
				    <label>
				    	<span>Years of Residency :</span> </label>
				        <input id="residency" type="text" value="<?php echo $addressdate; ?>" name="residency" style="width:250px;"  /> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
				        Contact Number : 
				        <input id="contact" value="<?php echo $contactno ?>" type="text" name="contact" style="width: 165px;"  />
				    
<!-- 
					<label>
				        <span>Provincial Address :</span>
				        <input id="paddress" type="text" name="paddress"  style="width: 562px;" />
				    </label> -->

				    <label>
				        <span>Birthday :</span> </label>
				        <input disabled id="contact" value="<?php echo $bday; ?>"type="text" name="contact" style="width: 210px;"  />
					        &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp

					        Birthplace: 
					        <input value="<?php echo $bplace; ?>" disabled id="birthplace" type="text" name="birthplace" style="width: 242px;"   />
				    

				    <label>
				    	<span> Gender : </span> </label>
				    	<input typ='text' disabled style="width:80px;" value='<?php echo $gender_id; ?>'>
				    	<!-- <select name="gender" style="width:80px;">
				    			<option value="" selected="selected"></option>
						        <option value="male">Male</option>
						        <option value="female">Female</option>
					    </select> -->

					    &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp

				        Civil Status : 
						        <select id="selectMenu" name='civilstatus' onchange="toggle(this.options[this.options.selectedIndex].value)" style="width:130px;">
										<!-- <option value="blank" selected="selected"></option> -->
										<?php if ($cstatus =='single'){ ?>

										<option value="single" selected="selected"> Single </option>
										<option value="married"> Married </option>
										<?php } else{?>
										<option value="single"> Single </option>
										<option value="married" selected='selected'> Married </option>
										<?php } ?>
								</select>
				    	<!--<select name="selectMenu" style="width:130px;" onchange="toggle(this.options[this.options.selectedIndex].value)">
						        <option value="formNumber1">Single</option>
						        <option value="formNumber2">Married</option>
					    </select>-->

				        &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp

				        Religion :
				        <input id="religion" type="text" value="<?php echo $religion; ?>" name="religion" style="width: 168px;" />
				    </label>

				    <label>
				    		<span>
				    		</span>
				    		----------------------------------------------------- MAIN INCOME -----------------------------------------------------

				    </label>

				    <label>
				        <span>Business Type :</span>
				        <input  type="text" name="btype" value='<?php echo $btype; ?>' id="" style="width: 562px;"  />
				    </label>

				    <label>
				        <span>Company Name :</span>
				        <input type="text" value='<?php echo $companyname; ?>' name="companyname" id="" style="width: 562px;" />
				    </label>

				    <label>
				        <span>Contact :</span></label>
				        <input type="text" value='<?php echo $comcontact; ?>' name="comcontact" id="" style="width: 250px;"  />
				    	&nbsp &nbsp &nbsp

				    	Years Entered the Business: 
				    	<input type="text" name="yr_enter" value='<?php echo $yearen; ?>' id="" style="width: 125px;"/>


				    <!------ HOUSEHOLD -------->
				    <label>
				    		<span>
				    		</span>
				    		------------------------------------------------------ HOUSEHOLD ------------------------------------------------------

				    </label>
<?php foreach ($getHousehold->result() as $hos) { ?>
	

				    <div id="household"> 

				    	<input type='hidden' name='householdno[]' value="<?php echo $hos->HouseholdNo; ?>">
				    
				    	<label>
					        <span>Name :</span></label>
					        <input id="hhname" disabled type="text" value="<?php echo $hos->Name;?>" name="hname[]" style="width: 562px;"  />
					       <!--  <input id="hhname" type="text" name="name" style="width: 170px;"  />
					        <input id="hhname" type="text" name="name" style="width: 176px;"  /> -->
					    
					    <label>
				        	<span>Relationship :</span> 
					        <input disabled id="relationship" value="<?php echo $hos->Relationship;?>" type="text" name="relationship[]"  style="width: 560px;"  />
					    </label>
					   	<label>
				        	<span>Occupation :</span> 
					        <input id="occupation" type="text" value="<?php echo $hos->Occupation;?>" name="hoccupy[]"  style="width: 560px;" />
					    </label>
					    <label>
				        	<span>Civil Status :</span> </label>
					       <!--  <input id="civilstat" value="<?php echo $hos-> CivilStatus;?>" type="text" name="name"  style="width: 350px;"  /> -->

					      <select name="hcstat[]" id="selectMenu" onchange="toggle(this.options[this.options.selectedIndex].value)" style="width:350px;">
										<!-- <option value="blank" selected="selected"></option> -->
										<?php if ($hos->CivilStatus =='single'){ ?>

										<option value="Single" selected="selected"> Single </option>
										<option value="Married"> Married </option>
										<?php } else{?>
										<option value="Single"> Single </option>
										<option value="Married" selected='selected'> Married </option>
										<?php } ?>
								</select>
					        &nbsp&nbsp&nbsp
					        Age : 
					        <input id="age" type="text" name="hage[]" value="<?php echo $hos-> Age;?>" style="width: 160px;"  />

					     <label>
					     	<span></span>
					     	------------------------------------------------------------------------------------------------------------------------------
					     </label>

  
					</div>

<?php } //}?>

					<div id="household"></div>

						<label>
							<span></span>
							<input type="button" class="addmore" value="+ MORE" onclick="addHousehold()"/>
						</label>
				    <br>

				   <!--  <label>
				    	<span>Barangay Clearance :</span>
				    	<input id="age" type="text" name="name"  placeholder="for viewing"  disabled/>
				    </label>
				    <label>
				    	<span></span>
				    	<input  type="file" name="image" id="file"/>
				    </label> -->

				    	
				    </label>


				    <br><br>
				   
				        <input type="submit" name="save" class="button22" value="Save Changes" /> &nbsp&nbsp&nbsp 
						<input type="submit" name="cancel" class="button221" value="Cancel" />
				    
				</form>

		</div>
