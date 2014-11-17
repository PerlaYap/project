<link rel="stylesheet" type="text/css" href="<?php echo base_url('Assets/css/salveofficer.css'); ?>">
<script src="<?php echo base_url('Assets/js/branchmanager.js'); ?>"></script>

<!-- <link rel="stylesheet" type="text/css" href="../../../Assets/css/salveofficer.css">
<script src="../../../Assets/js/branchmanager.js"></script> -->



<?php
	$control_no = $number;
	$getMember =$this->db->query("SELECT  mem.ControlNo, MemberID, concat(memname.LastName,', ',memname.FirstName,' ', memname.MiddleName) AS Name,ContactNo,Birthday,BirthPlace, GenderID, Religion, EducationalAttainment,CivilStatus, MFI,Address,AddressDate, Status, Type,BusinessType,CompanyName,CompanyContact,YearEntered, LoanExpense,Savings, CapitalShare, mhmstatus.yearincs, mhmstatus.monthincs
	                                FROM 
	                                Members mem 
	                                LEFT JOIN MembersName memname ON mem.ControlNo=memname.ControlNo
	                                LEFT JOIN (SELECT ControlNo,  year(`DateUpdated`) as yearincs, month(`DateUpdated`) as monthincs, Status FROM members_has_membersmembershipstatus ) mhmstatus ON mem.ControlNo=mhmstatus.ControlNo
	                               
	                                LEFT JOIN (SELECT ControlNo, Type FROM members_has_membertype ORDER BY DateUpdated DESC LIMIT 1) mhmtype ON mem.ControlNo=mhmtype.ControlNo
	                                LEFT JOIN MembersContact memcontact ON mem.ControlNo=memcontact.ControlNo
	                                LEFT JOIN membersmfi mfi ON mem.ControlNo=mfi.ControlNo
	                                LEFT JOIN membersaddress madd ON mem.ControlNo=madd.ControlNo
	                                LEFT JOIN sourceofincome soi ON mem.ControlNo=soi.ControlNo
	                                WHERE mem.ControlNo='$control_no'");

/*SELECT * FROM `members_has_membersmembershipstatus` */

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
			$yearincs = $mem->yearincs;
			$monthincs = $mem->monthincs;
			}
			if ($monthincs <10) {
				$idformat = "CS-0".$monthincs."-".$yearincs."-".$control_no."R";
			}else{
				$idformat = "CS-".$monthincs."-".$yearincs."-".$control_no."R";		
			}

 ?>
		<div class="content">
				<br>
			<form action='addmemberid' method='POST'>
				<div class="basic-grey"><br>
					<h1>MEMBER ID
				        <!-- <span>Enter Member ID to complete membership approval <br></span> -->
				    </h1>

				    <label>
				        <span>Member ID: </span>
				        <input id="" disabled type="text" value='<?php echo $idformat; ?>'  style="width: 562px;"/>
 <input id="" type="hidden" value='<?php echo $idformat; ?>' name="memberid" />
 <input id="" type="hidden" value='<?php echo $control_no; ?>' name="controlno" />
				    </label>

				    <label>
				        <span>Name :</span></label>
				        <input id="name" type="text" name="fname" value="<?php echo $name; ?>" style="width: 562px;" disabled/>
				       
				   
				    <label>
				       	<span>Branch : </span></label>
				        <input id="" type="text" name="" value='<?php echo $branch; ?>' style="width: 200px;" disabled/>

				    <label>
				        <span>Center : </span></label>
				        <input id=""  value='<?php echo $center; ?>' type="text" name="" style="width: 53px;" disabled/>
				   
				    <br><br>
				    <label>
				        <span></span>
					        
						        
								<input type="submit" class="button" value="OK" />
			</form>
					       <!--  <form action='' method='' style="margin-top: -50px; margin-left: 220px;">
						        <input type='hidden' name='controlno' value="">
								<input type="submit" class="button1" value="Back" />
					        </form> -->
				    </label>

				</div>

		<br><br><br>
		</div>
