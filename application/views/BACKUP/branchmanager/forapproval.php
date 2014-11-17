<link rel="stylesheet" type="text/css" href="<?php echo base_url('Assets/css/salveofficer.css'); ?>">
		<script src="<?php echo base_url('Assets/js/salveofficer.js'); ?>"></script>



<?php


	 $control_no = $_GET['name'];
	/*SQL QUERIES*/


	$getMember =$this->db->query("SELECT  mem.ControlNo, MemberID, concat(memname.LastName,', ',memname.FirstName,' ', memname.MiddleName) AS Name,ContactNo,Birthday,BirthPlace, GenderID, Religion, EducationalAttainment,CivilStatus, MFI,Address,AddressDate, Status, Type,BusinessType,CompanyName,CompanyContact,YearEntered, LoanExpense,Savings, CapitalShare 
	                                FROM Members mem 
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


	$getPic =$this->db->query("SELECT * FROM MembersPicture WHERE ControlNo = '$control_no' ");

	$getDoc =$this->db->query("SELECT * FROM MembersSignature WHERE ControlNo = '$control_no' ");

	$getOrganization =$this->db->query("SELECT * FROM `membersorganization` WHERE `ControlNo`='$control_no' ");

	$getbranchandcenter = $this->db->query("SELECT cm.`CaritasCenters_ControlNo`, cc.`CenterNo`, cbc.`CaritasBranch_ControlNo`, b.`BranchName`
	FROM `caritascenters_has_members` cm, `caritascenters` cc, `caritasbranch_has_caritascenters` cbc,
	`caritasbranch` b
	where `Members_ControlNo` = '$control_no' and cm.`CaritasCenters_ControlNo` = cc.`ControlNo` and
	cbc.`CaritasCenters_ControlNo` = cc.`ControlNo` and
	b.`ControlNo` = cbc.`CaritasBranch_ControlNo`");

	foreach ($getbranchandcenter->result() as $bc) {
		$branch = $bc->BranchName;
		$center = $bc->CenterNo;
	}




		foreach ($getMember->result() as $mem) {

			$name = $mem->Name;
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
			$control = $mem->ControlNo;
		
			}

	//	$center=$this->db->query("SELECT c.CenterNo, cm.CaritasCenters_ControlNo FROM CaritasCenters_has_Members cm, CaritasCenters c WHERE cm.Members_ControlNo = '$control' AND c.ControlNo = cm.CaritasCenters_ControlNo ");
 ?>
		
		
	
			<div class="content">
				<br>
				<div class="basic-grey">
					<h1>Member Account For Approval
				        <span>Contact the Salve Officer in-charge for any information descrepancies.</span>
				    </h1>

				    <!-- <label>
				    	<span>Photo :</span>
				        <input id="" type="text" name="" style="width: 562px;" placeholder="image dapat to'"  disabled/>
				    	<input type="file" name="file" id="file"/>
				    </label> -->

				    <!-- <label>
				        <span>SO in-charge :</span>
				        <input id="" type="text" name="" style="width: 562px;"  disabled/>
				    </label> -->

				    <label>
				        <span>Name :</span></label>
				        <input id="name" type="text" name="fname" value="<?php echo $name; ?>" style="width: 562px;" disabled/>
				        <!-- <input id="name" type="text" name="mname" style="width: 170px;"  disabled/>
				        <input id="name" type="text" name="lname" style="width: 175px;"  disabled/> -->
				    
				   
				    <label>
				       	<span>Center No. : </span></label>

				        <input id="centernumber" type="text" name="centernumber" value="<?php echo $center; ?>" style="width: 53px;" disabled/>


						&nbsp &nbsp &nbsp &nbsp
				    	
				    	Other Microfinance Institutions :
				        <input id="others" type="text" value="<?php echo $mfi; ?>" name="others" style="width: 288px;"  disabled/>

				  <label>
				        <span>Affiliated Organizations:</span></label>
				        <?php foreach ($getOrganization->result() as $org) { ?>
				        <input id="affiliations" type="text" name="affiliations" style="width: 302px;" value="<?php echo $org->Organization; ?>" disabled/>
				        Position :
				        <input id="affiliations" value="<?php echo $org->Position; ?>" type="text" name="affiliations" style="width: 188px;"  disabled/> 
				        <label><span></span></label>

				        <?php } ?>
				        
					<br>
				    
				    <!-- <div id="organizations"></div> -->


				    <label>
				        <span>Home Address :</span>
				        <input id="haddress" value="<?php echo $addresshome; ?>" type="text" name="haddress" style="width: 562px;"  disabled/>
				    </label>
				   
				    <label>
				    	<span>Years of Residency :</span> </label>
				        <input id="residency" type="text" value="<?php echo $addressdate; ?>" name="residency" style="width:250px;"  disabled/> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
				        Contact Number : 
				        <input id="contact" value="<?php echo $contactno; ?>" type="text" name="contact" style="width: 165px;"  disabled/>
				    

					<!-- <label>
				        <span>Provincial Address :</span>
				        <input id="paddress" type="text" name="paddress"  style="width: 562px;"  disabled/>
				    </label> -->

				    <label>
				        <span>Birthday :</span> </label>
				        	<input id="month" type="text" value="<?php echo $bday; ?>" name="name" style="width: 200px;"  disabled/>

				        	<!-- <input id="day" type="text" name="name"  style="width: 40px;"  disabled/>
				        	<input id="year" type="text" name="name"  style="width: 61px;"  disabled/> -->
					       
					        &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp

					        Birthplace: 
					        <input id="birthplace" value="<?php echo $bplace; ?>" type="text" name="birthplace" style="width: 225px;"   disabled/>
				    

				    <label>
				    	<span> Gender : </span> </label>
				    	<input id="" value="<?php echo $gender_id; ?>" type="text" name="name"  style="width: 80px;"  disabled/>

					   	&nbsp&nbsp&nbsp

				        Civil Status : 
				        		<input id="" value="<?php echo $cstatus; ?>" type="text" name="name"  style="width: 128px;"  disabled/>
						      

				        &nbsp&nbsp&nbsp&nbsp

				        Religion :
				        <input id="religion" value="<?php echo $religion; ?>" type="text" name="religion" style="width: 166px;" disabled />
				    </label>

				    <label>
				    		<span>
				    		</span>
				    		----------------------------------------------------- MAIN INCOME -----------------------------------------------------

				    </label>

				    <label>
				        <span>Business Type :</span>
				        <input type="text" name="" id="" value="<?php echo $btype; ?>" style="width: 562px;"  disabled/>
				    </label>

				    <label>
				        <span>Company Name :</span>
				        <input type="text" name="" id="" value="<?php echo $companyname; ?>" style="width: 562px;"  disabled/>
				    </label>

				    <label>
				        <span>Contact :</span></label>
				        <input type="text" name="" id="" value="<?php echo $comcontact; ?>" style="width: 226px;"  disabled/>
				    	&nbsp &nbsp &nbsp

				    	Year entered the Business: 				
				    	<input type="text" name="" value="<?php echo $yearen; ?>" id="" style="width: 155px;" disabled/>


				    <!------ HOUSEHOLD -------->
				    <label>
				    		<span>
				    		</span>
				    		------------------------------------------------------ HOUSEHOLD ------------------------------------------------------

				    </label>

				    <?php foreach ($getHousehold->result() as $house) { ?>

				    <div id="household"> 
				    
				    	<label>
					        <span>Name :</span></label>
					        <input id="hhname" type="text" value="<?php echo $house->Name; ?>" name="name" style="width: 562px;"  disabled/>
					        <!-- <input id="hhname" type="text" name="name" style="width: 170px;"  disabled/>
					        <input id="hhname" type="text" name="name" style="width: 176px;"  disabled/> -->
					    
					    <label>
				        	<span>Relationship :</span> 
					        <input id="relationship" type="text" value="<?php echo $house->Relationship; ?>" name="name"  style="width: 560px;"  disabled/>
					    </label>
					   	<label>
				        	<span>Occupation :</span> 
					        <input id="occupation" value="<?php echo $house->Occupation; ?>" type="text" name="name"  style="width: 560px;" disabled/>
					    </label>
					    <label>
				        	<span>Civil Status :</span> </label>
					        <input id="civilstat" value="<?php echo $house->CivilStatus; ?>" type="text" name="name"  style="width: 350px;"  disabled/>
					        &nbsp&nbsp&nbsp
					        Age : 
					        <input id="age" value="<?php echo $house->Age; ?>" type="text" name="name"  style="width: 150px;"  disabled/>

					</div>

					<?php } ?>


  					<label>
				    	<span>Valid ID: </span></label><br>
					
				<?php foreach ($getPic->result() as $pic) { 

			header('Content-Type: image; charset=UTF-8');

					?> 
					<div style="width: 324px; height: 204px">

					<img src="<?php echo base_url($pic->Picture); ?>" class="user"  style="width: 100%;max-height: 100%"> 
				</div>

					<?php } ?>

				    <br><br>

  					<label>
				    	<span>Barangay Clearance: </span></label><br>
					
				<?php foreach ($getDoc->result() as $doc) { 

			header('Content-Type: image; charset=UTF-8');

					?> 
					 <div style="width: 768px; height: 960px">
					<img src="<?php echo base_url($doc->Signature); ?>" class="user" style="width: 100%;max-height: 100%"> 
					</div>
					<?php } ?>

				    <br><br>
				     <label>
				        <span></span>
				     <?php if($this->session->userdata('rank')=='branchmanager') :?>
				        <form action='approvemember' method='post'>
					        <input type='hidden' name='controlno' value='<?php echo $control_no?>'>
							<input type="submit" class="button" value="Approve" />
				        </form>

				        &nbsp&nbsp&nbsp 
				        <form action='reasonforreject' method='post'>
				        	<input type='hidden' name='controlno' value='<?php echo $control_no?>'>
							<input type="submit" class="button1" value="Reject" />
				        </form>
				    <?php endif;?>	
				    <?php if($this->session->userdata('rank')=='salveofficer') :?>
				    	<form action='editprofile' method='post'>
				    		<input type='hidden' name='controlno' value='<?php echo $control_no?>'>
							<input type="submit" class="button" value="Edit Profile" />
				    	</form>
				    <?php endif;?>	

				    </label>  
				</div>
		</div>
