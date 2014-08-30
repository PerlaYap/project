<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Addnewmember_model extends CI_Model{


	function _construct(){

		parent::_construct();
	}

	public function get_memberdetails(){

		//grab input

		 //$username = $this->security->xss_clean($this->input->post('username'));

	    $firstname = $this->security->xss_clean($this->input->post('fname'));
		$middlename = $this->security->xss_clean($this->input->post('mname'));
		$lastname  = $this->security->xss_clean($this->input->post('lname'));
        $memberid  = $this->security->xss_clean($this->input->post('memberid'));
        $approved  = $this->security->xss_clean($this->input->post('approved'));
		$centerno = $this->security->xss_clean($this->input->post('centernumber'));

		$home_address = $this->security->xss_clean($this->input->post('haddress'));
		$year_of_residency = $this->security->xss_clean($this->input->post('residency'));
		$contact_number = $this->security->xss_clean($this->input->post('contact'));
        $education = $this->security->xss_clean($this->input->post('educattain'));
		$provincial_address = $this->security->xss_clean($this->input->post('paddress'));

            //YYYY-MM-DD
        $birthdate = $this->security->xss_clean($this->input->post('bday'));

		$birth_place = $this->security->xss_clean($this->input->post('birthplace'));

		$gender = $this->security->xss_clean($this->input->post('gender'));
		$civil_status = $this->security->xss_clean($this->input->post('apple'));
		$religion = $this->security->xss_clean($this->input->post('religion'));

        $organization_1 = $this->security->xss_clean($this->input->post('org'));
        $position_1 = $this->security->xss_clean($this->input->post('pos'));

        /*JS*/
        $organization = $this->security->xss_clean($this->input->post('organization'));
        $position = $this->security->xss_clean($this->input->post('position'));
    
        $other_microfinance =  $this->security->xss_clean($this->input->post('othersmicro'));


        //MAIN SOURCE OF INCOME

        $BusinessType =  $this->security->xss_clean($this->input->post('businesstype'));
        $CompanyName =  $this->security->xss_clean($this->input->post('companyname'));
        $CompanyContact =  $this->security->xss_clean($this->input->post('companycontact'));
        $YearInBusiness =  $this->security->xss_clean($this->input->post('yearinbusiness'));





        
		//HOUSEHOLD MEMBER

            //first household member
        $H_fname_1 =  $this->security->xss_clean($this->input->post('hfname'));
        $H_mname_1 =  $this->security->xss_clean($this->input->post('hmname'));
        $H_lname_1 =  $this->security->xss_clean($this->input->post('hlname'));

        $h_relationship =  $this->security->xss_clean($this->input->post('relationship'));
        $h_occupation =  $this->security->xss_clean($this->input->post('occupation'));
        $h_c_status =  $this->security->xss_clean($this->input->post('c_status'));
        $h_age =  $this->security->xss_clean($this->input->post('age'));
        $h_gender = $this->security->xss_clean($this->input->post('pine'));

            //succeeding household member

        $H_fname =  $this->security->xss_clean($this->input->post('hfname_1'));
        $H_mname =  $this->security->xss_clean($this->input->post('hmname_1'));
        $H_lname =  $this->security->xss_clean($this->input->post('hlname_1'));
        $h_relation =  $this->security->xss_clean($this->input->post('relation'));
        $h_occupy =  $this->security->xss_clean($this->input->post('occupy'));
        $h_c_stat =  $this->security->xss_clean($this->input->post('c_stat'));
        $h_age_1 =  $this->security->xss_clean($this->input->post('age_1'));
        $h_gender_1 =  $this->security->xss_clean($this->input->post('genders'));


 
 $this->addMembers($approved, $birthdate,$memberid, $birth_place,$gender,$religion,$education,$civil_status);

 echo  $control_no =   $this->getMembersControlNumber();


$name  = $_FILES['file']['name'];

$tmp_name =$_FILES['file']['tmp_name'];


if (isset($name)){

    if(!empty($name)){

        $location = "ids/$name";
    
        move_uploaded_file($tmp_name, $location);

        $this->db->query("INSERT INTO memberspicture (`ControlNo`, `Picture`) VALUES ('$control_no', '$location')");
    
        echo 'Uploaded!';
    
        
      } else{
        echo 'Select Another One';
      }
} else{
    echo 'Nothing happened';
}


$dname  = $_FILES['docu']['name'];

$dtmp_name =$_FILES['docu']['tmp_name'];


if (isset($dname)){

    if(!empty($dname)){

        $dlocation = "signatures/$dname";
    
        move_uploaded_file($dtmp_name, $dlocation);

        $this->db->query("INSERT INTO MembersSignature (`ControlNo`, `Signature`) VALUES ('$control_no', '$dlocation')");
    
        echo 'Uploaded!';
    
        
      } else{
        echo 'Select Another One';
      }
} else{
    echo 'Nothing happened';
}


  $this->addMembersName($control_no,$firstname, $lastname, $middlename);
        

    $this->addMemberType($control_no, "Associate Member"); 

    $this->addMembersStatus($control_no,"Active");

  $this->addMembersAddress($control_no, $home_address, $year_of_residency,"Home Address");
    //address, year. type

   $this->addMembersMFI($control_no, $other_microfinance);

    $this->addMembersOrganization($control_no, $organization_1, $position_1);

    //MORE ORGANIZATION TO BE ADDED --USING ADD MORE BUTTON
        if (!empty($organization) && !empty($position)) {

            //echo "here array";
            
           $arraysize = count($organization);
           for ($size=0; $size < $arraysize ; $size++) { 
               
              /* echo $organization[$size];
               echo $position[$size];*/
                 
            $this->addMembersOrganization($control_no, $organization[$size], $position[$size]);


          }
                
        }else{
            //echo "Empty";
        }

    $this->addMembersContact($control_no,$contact_number);
    $this->addMemberCenter($control_no, $centerno);
    $this->addSourceIncome($control_no, $BusinessType, $CompanyName, $CompanyContact, $YearInBusiness);
    


/*------------------HOUSEHOLD------------------------------------------*/

            /*FIRST ENTRY*/
   $this->addHousehold($h_age, $h_gender, $h_c_status);
     $householdno = $this->getHouseholdControlNo();
     $this->addMembersHasHousehold($control_no, $householdno, $h_relationship);
     $this->addHouseholdOccupation($householdno, $h_occupation);
     $this->addHouseholdName($householdno, $H_fname_1, $H_mname_1, $H_lname_1);


            /*SECOND ENTRY*/

if (!empty($H_fname) && !empty($H_mname) && !empty($H_lname)) {

    $arrsize = count($H_fname);
    for ($size=0; $size < $arrsize ; $size++) { 
        
    $this->addHousehold($h_age_1[$size], $h_gender_1[$size], $h_c_stat[$size]);
     $householdno = $this->getHouseholdControlNo();
     $this->addMembersHasHousehold($control_no, $householdno, $h_relation[$size]);
     $this->addHouseholdOccupation($householdno, $h_occupy[$size]);
     $this->addHouseholdName($householdno, $H_fname[$size], $H_mname[$size], $H_lname[$size]);
    }


    
}

    
return true;
    }
	 //adding functions


    public function addMembers( $approved, $bday, $mid,$birthPlace, $gender, $religion, $education, $status) {

        $this->db->query("INSERT INTO members (`Approved`,`Birthday`,`MemberID`,`BirthPlace`, `GenderID`, `Religion`, `EducationalAttainment`, `CivilStatus` ) VALUES ( '$approved', '$bday','$mid', '$birthPlace', '$gender', '$religion', '$education', '$status')");
    }

    public function addMembersName($controlNo,$firstName, $lastName, $middleName) {
        $this->db->query("INSERT INTO membersname (ControlNo,FirstName, LastName, MiddleName) VALUES ('$controlNo','$firstName','$lastName','$middleName')");
    }

    public function addMemberType($controlNo, $type) {
        $this->db->query("INSERT INTO members_has_membertype (`ControlNo`, `Type`) VALUES ('$controlNo', '$type')");
    }

    public function addMembershasMembers($membersmembers) {
        $this->db->insert_batch('Members_has_Members', $membersmembers);
    }

    public function addMembersStatus($controlNo, $status) {
        $this->db->query("INSERT INTO members_has_membersmembershipstatus(`ControlNo`, `DateUpdated`, `Status`) VALUES ('$controlNo', NOW(), '$status')");
        /*INSERT INTO `microfinance2`.`members_has_membersmembershipstatus` (`ControlNo`, `DateUpdated`, `Status`) VALUES ('16', NOW(), 'Active');*/
    }

    public function addMembersAddress($controlNo, $address, $year, $type) {
        $this->db->query("INSERT INTO membersaddress (`ControlNo`, `Address`, `AddressDate`, `AddressType`) VALUES ('$controlNo', '$address','$year', '$type')");
    }

    public function addMembersMFI($controlNo, $mfi) {
        $this->db->query("INSERT INTO membersmfi (`ControlNo`, `MFI`) VALUES ('$controlNo', '$mfi')");
    }

    public function addMembersOrganization($controlNo, $membersOrg, $position) {
        $this->db->query("INSERT INTO membersorganization (`ControlNo`, `Organization`, `Position`) VALUES ('$controlNo', '$membersOrg', '$position')");
    }

    public function addMembersPicture($controlNo, $membersPic) {
        $this->db->query("INSERT INTO memberspicture (`ControlNo`,`Picture`) VALUES ('$controlNo','$membersPic')");
    }

    public function addMembersSigniture($controlNo, $membersSign) {
        $this->db->query("INSERT INTO memberssigniture (`ControlNo`,`Signiture`) VALUES ('$controlNo','$membersSign')");
    }

    public function addMembersContact($controlNo, $contact) {
        $this->db->query("INSERT INTO memberscontact (`ControlNo`, `ContactNo`) VALUES ('$controlNo', '$contact')");
    }

    public function addMemberCenter($controlNo, $centerNo) {
        $this->db->query("INSERT INTO `microfinance2`.`caritascenters_has_members` (`CaritasCenters_ControlNo`, `Members_ControlNo`, `DateEntered`, `DateLeft`) VALUES ('$centerNo', '$controlNo', NOW(), NULL);");

       
    }

    public function addSourceIncome($controlNo, $type, $companyName, $companyContact, $yearEntered) {
        $this->db->query("INSERT INTO sourceofincome (`ControlNo`, `BusinessType`, `CompanyName`, `CompanyContact`, `YearEntered`) VALUES ('$controlNo', '$type', '$companyName', '$companyContact', '$yearEntered')");
    }

    //Members View
    
    //getting ControlNumber for other tables
    public function getMembersControlNumber() {
        $query = $this->db->query("SELECT ControlNo FROM Members ORDER BY ControlNo DESC LIMIT 1 ");

        if ($query->num_rows() > 0) {
            $row = $query->row();
            $controlNo = $row->ControlNo;
            return $controlNo;
        }
    }

    //Getting Data
    public function getMembers($memberID) {
        $getMember = $db->query("SELECT  mem.ControlNo, Picture, MemberID, concat(memname.LastName,', ',memname.FirstName,' ', memname.MiddleName) AS Name,ContactNo, BirthPlace, GenderID, Religion, EducationalAttainment,CivilStatus, MFI, Status, Type, Signiture, LoanExpense,Savings, CapitalShare 
                                FROM 
                                Members mem 
                                LEFT JOIN MembersName memname ON mem.ControlNo=memname.ControlNo
                                LEFT JOIN (SELECT ControlNo, Status FROM members_has_membersmembershipstatus ORDER BY DateUpdated DESC LIMIT 1) mhmstatus ON mem.ControlNo=mhmstatus.ControlNo
                                LEFT JOIN MembersPicture mempic ON mem.ControlNo=mempic.ControlNo
                                LEFT JOIN MembersSigniture memsign ON mem.ControlNo=memsign.ControlNo
                                LEFT JOIN (SELECT ControlNo, Type FROM members_has_membertype ORDER BY DateUpdated DESC LIMIT 1) mhmtype ON mem.ControlNo=mhmtype.ControlNo
                                LEFT JOIN MembersContact memcontact ON mem.ControlNo=memcontact.ControlNo
                                LEFT JOIN membersmfi mfi ON mem.ControlNo=mfi.ControlNo
                                WHERE mem.MemberID='$memberID'");
        return $getMember;
    }

    public function getMembersAddress($memberID, $addressType) {
        $getMemberAddress = $db->query("SELECT Address, AddressDate, AddressType FROM MembersAddress memadd
                                    RIGHT JOIN Members mem ON memadd.ControlNo=mem.ControlNo
                                    WHERE MemberID=$memberID AND AddressType=$addressType");

        return $getMemberAddress;
    }

    public function getMemberOrganization($memberID)
    {
        $getMemberOrg=$db->query("SELECT Organization, Position
FROM MembersOrganization memorg 
RIGHT JOIN (SELECT ControlNo FROM Members mem WHERE mem.MemberID='$memberID) A ON memorg.ControlNo=A.ControlNo");
        
        return $getMemberOrg;
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