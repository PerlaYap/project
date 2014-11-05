<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Editprofiledetails_model extends CI_Model{


	function _construct(){

		parent::_construct();
	}


	public function setdetails(){

		if(isset($_POST['save'])){
   			
   			/*get name*/
   			$fname = $this->security->xss_clean($this->input->post('fname'));
   			$mname = $this->security->xss_clean($this->input->post('mname'));
   			$lname = $this->security->xss_clean($this->input->post('lname'));
   			$membername = $fname." ".$mname." ".$lname;

   			$centerno = $this->security->xss_clean($this->input->post('centerno'));


			/*getting inputs from user*/
			$controlno = $this->security->xss_clean($this->input->post('controlno'));
			$homeaddress = $this->security->xss_clean($this->input->post('haddress'));
			$yr_residency = $this->security->xss_clean($this->input->post('residency'));
			$contact_no = $this->security->xss_clean($this->input->post('contact'));
			$cstatus = $this->security->xss_clean($this->input->post('civilstatus'));
			$religion = $this->security->xss_clean($this->input->post('religion'));
			$btype = $this->security->xss_clean($this->input->post('btype'));
			$companyname = $this->security->xss_clean($this->input->post('companyname'));
			$comcontact = $this->security->xss_clean($this->input->post('comcontact'));
			$yr_enter = $this->security->xss_clean($this->input->post('yr_enter'));
			$memberid = $this->security->xss_clean($this->input->post('memberid'));

			$org = $this->security->xss_clean($this->input->post('org'));
			$pos = $this->security->xss_clean($this->input->post('pos'));
			$orgorig = $this->security->xss_clean($this->input->post('orgorig'));

			/*Add more organization*/
			$organization = $this->security->xss_clean($this->input->post('organization'));
        	$position = $this->security->xss_clean($this->input->post('position'));

        	/*Household*/
			$hholdno = $this->security->xss_clean($this->input->post('householdno'));
			$hoccupy = $this->security->xss_clean($this->input->post('hoccupy'));
			$hcstat = $this->security->xss_clean($this->input->post('hcstat'));
			$hage = $this->security->xss_clean($this->input->post('hage'));

			/*Add more household*/
			 $H_fname =  $this->security->xss_clean($this->input->post('hfname_1'));
	        $H_mname =  $this->security->xss_clean($this->input->post('hmname_1'));
	        $H_lname =  $this->security->xss_clean($this->input->post('hlname_1'));
	        $h_relation =  $this->security->xss_clean($this->input->post('relation'));
	        $h_occupy =  $this->security->xss_clean($this->input->post('occupy'));
	        $h_c_stat =  $this->security->xss_clean($this->input->post('c_stat'));
	        $h_age_1 =  $this->security->xss_clean($this->input->post('age_1'));
	        $h_gender_1 =  $this->security->xss_clean($this->input->post('genders'));

	        if (!empty($hholdno)) {
	        
	        $hsize = count($hholdno);

			for ($h=0; $h < $hsize ; $h++) { 
				$this->updatehousehold($hholdno[$h], $hage[$h], $hcstat[$h] ,$hoccupy[$h]);
				}
	        }
	        if (!empty($centerno)) {
	        	$this->updatecenterno($centerno, $controlno);
	        }

			

			if (!empty($H_fname) && !empty($H_mname) && !empty($H_lname)) {

		    $arrsize = count($H_fname);
		    for ($size=0; $size < $arrsize ; $size++) { 
		        
		     $this->addHousehold($h_age_1[$size], $h_gender_1[$size], $h_c_stat[$size]);
		     $householdno = $this->getHouseholdControlNo();
		     $this->addMembersHasHousehold($controlno, $householdno, $h_relation[$size]); 
		     $this->addHouseholdOccupation($householdno, $h_occupy[$size]);
		     $this->addHouseholdName($householdno, $H_fname[$size], $H_mname[$size], $H_lname[$size]);
		    }



}

			 	$size = count($org);

			 	if (!empty($org) && !empty($pos) ) {
			 		
			 		for ($i=0; $i <$size ; $i++) { 

						if($org[$i]=="" && $pos[$i]==""){
						// if the org is empty, will delete it from the db
							$this->deleteorganization($controlno, $orgorig[$i]);
						}else{
							$this->updateorganization($controlno, $org[$i], $orgorig[$i], $pos[$i]);	
						}
					}
			 	}
			

			 if (!empty($organization) && !empty($position)) {

           		$arraysize = count($organization);
           		for ($size=0; $size < $arraysize ; $size++) {    
            		$this->addMembersOrganization($controlno, $organization[$size], $position[$size]);
          			}
                
	        }else{
        	}

			$this->updatemembers($controlno, $religion, $cstatus);
			$this->updatemembersaddress($controlno, $homeaddress, $yr_residency);
			$this->updatecontactno($controlno, $contact_no);
			$this->updatebusiness($controlno, $btype, $companyname, $yr_enter, $comcontact);
			if (!empty($memberid)) {
	        	
	        //	$this->updatememberid($memberid, $controlno);
	        }
	        $result['result'] = true;
	        $result['name'] = $membername;
			return $result;


       }elseif (isset($_POST['cancel'])) {
       	//echo "canceled";
       //	echo "<script type='text/javascript'>alert('Are you sure you want to cancel?')</script>";
       		return false;
       }

	}

	public function updatecenterno($centerno, $membercontrol){
		$query = $this->db->query("SELECT * FROM `caritascenters_has_members` where Members_ControlNo = $membercontrol");
		foreach ($query->result()	 as $d) {
			$dated = $d->DateEntered;
			$oldcenter = $d->CaritasCenters_ControlNo;
		}

		$this->db->query("UPDATE `microfinance2`.`caritascenters_has_members` SET `CaritasCenters_ControlNo` = '$centerno' WHERE `caritascenters_has_members`.`CaritasCenters_ControlNo` = $oldcenter AND `caritascenters_has_members`.`Members_ControlNo` = $membercontrol and `DateEntered`= '$dated' ");
	}

	public function updatemembers($controlno, $religion, $cstatus){
		$this->db->query("UPDATE `members` SET 
							`Religion`='$religion',
							`CivilStatus`='$cstatus'
							WHERE `ControlNo` = '$controlno'");

	}

	public function updatememberid($memberid, $controlno){
		$this->db->query("UPDATE `microfinance2`.`members` SET `MemberID` = '$memberid' WHERE `members`.`ControlNo` = $controlno;");
	}
	public function updatemembersaddress($controlno, $address, $addressdate){
		$this->db->query("UPDATE `membersaddress` SET `Address`='$address',`AddressDate`='$addressdate'
		WHERE `ControlNo`='$controlno';");
	}
	public function updatecontactno($controlno, $contact){
		$this->db->query("UPDATE `memberscontact` SET `ContactNo`='$contact' WHERE `ControlNo`='$controlno';");
	}
	public function updatebusiness($controlno, $btype, $cname, $cyear, $ccontact){
		$this->db->query("UPDATE `sourceofincome` SET `BusinessType`='$btype',`CompanyName`='$cname',`CompanyContact`='$ccontact',`YearEntered`='$cyear' WHERE `ControlNo`='$controlno'");
	}

	public function updateorganization($controlno, $org, $orgorig, $pos){
		$this->db->query("UPDATE `membersorganization` SET `Organization`='$org',`Position`='$pos' WHERE `ControlNo`=$controlno AND `Organization`='$orgorig'");
	}
	public function deleteorganization ($controlno, $orgorig){
		$this->db->query("DELETE FROM `microfinance2`.`membersorganization` WHERE `membersorganization`.`ControlNo` = $controlno AND `membersorganization`.`Organization` ='$orgorig'");
		/**/
	}
	public function addMembersOrganization($controlNo, $membersOrg, $position) {
        $this->db->query("INSERT INTO membersorganization (`ControlNo`, `Organization`, `Position`) VALUES ('$controlNo', '$membersOrg', '$position')");
    }
    public function updatehousehold($householdno, $age, $cstat, $occupation){
    	/*update age and civilstatus*/
    	$this->db->query("UPDATE `microfinance2`.`membershousehold` SET `Age` = '$age',`CivilStatus`='$cstat' WHERE `membershousehold`.`HouseholdNo` = $householdno;");
 
    	/*update occupation*/
    	$this->db->query("UPDATE `microfinance2`.`householdoccupation` SET `Occupation` = '$occupation' WHERE `householdoccupation`.`HouseholdNo` = $householdno;");
    	
    }
     //---------------------------------HOUSEHOLD MEMBER ADDING FUNCTIONS---------------------

    public function addHousehold($age, $gender, $status) {
        $this->db->query("INSERT INTO `membershousehold`(`Age`, `GenderID`, `CivilStatus`) VALUES ('$age', '$gender', '$status')");
    }

    public function addHouseholdOccupation($controlNo, $occupation) {
        $this->db->query("INSERT INTO `householdoccupation` (`HouseholdNo`, `Occupation`) VALUES ('$controlNo', '$occupation')");
    }

    public function addHouseholdName($controlNo, $firstName, $middleName, $lastName) {
        $this->db->query("INSERT INTO `householdname` (`HouseholdNo`, `FirstName`, `MiddleName`, `LastName`) VALUES ('$controlNo', '$firstName', '$middleName', '$lastName')");
    }

    public function addMembersHasHousehold($membersControlNo, $householdNo, $relationship) {
        $this->db->query("INSERT INTO `members_has_membershousehold` (`ControlNo`, `HouseholdNo`, `Relationship`) VALUES ('$membersControlNo', '$householdNo', '$relationship')");



        
    }
    
    
    //get Household Member Control Number

  public function getHouseholdControlNo() {

 $query = $this->db->query("SELECT HouseholdNo FROM membershousehold ORDER BY HouseholdNo DESC LIMIT 1 ");
        

        if ($query->num_rows() > 0) {
            $row = $query->row();
            $householdcontrolNo = $row->HouseholdNo;
            return $householdcontrolNo;
        }
            }


}


?>




