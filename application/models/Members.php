<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Members
 *
 * @author albert
 */
class Members extends CI_Model {

//put your code here
    function __construct() {
        parent::__construct();
    }

    //adding functions
    public function addMembers($bday, $birthPlace, $gender, $religion, $education, $status) {

        $db->$query("INSERT INTO members (`Birthday`, `BirthPlace`, `GenderID`, `Religion`, `EducationalAttainment`, `CivilStatus`) VALUES ('$bday', '$birthPlace', '$gender', '$religion', '$education', '$status')");
    }

    public function addMembersName($firstName, $lastName, $middleName) {
        $db->query("INSERT INTO membersname (FirstName, LastName, MiddleName) VALUES ('$firstName','$lastName' '$middleName')");
    }

    public function addMemberType($controlNo, $type, $date) {
        $db->$query("INSERT INTO members_has_membertype (`ControlNo`, `Type`, `DateUpdated`) VALUES ('$controlNo', '$type', '$date')");
    }

    public function addMembershasMembers($membersmembers) {
        $this->db->insert_batch('Members_has_Members', $membersmembers);
    }

    public function addMembersStatus($controlNo, $date, $status) {
        $db->query("INSERT INTO members_has_membersmembershipstatus(`ControlNo`, `DateUpdated`, `Status`) VALUES ('$controlNo', '$date', '$status')");
    }

    public function addMembersAddress($controlNo, $address, $year, $type) {
        $db->query("INSERT INTO membersaddress (`ControlNo`, `Address`, `AddressDate`, `AddressType`) VALUES ('$controlNo', '$address','$year', '$type')");
    }

    public function addMembersMFI($controlNo, $mfi) {
        $db->query("INSERT INTO membersmfi (`ControlNo`, `MFI`) VALUES ('$controlNo', '$mfi')");
    }

    public function addMembersOrganization($controlNo, $membersOrg, $position) {
        $db->query("INSERT INTO memebersorganizations (`ControlNo`, `Organanization`, `Position`) VALUES ('$controlNo', '$membersOrg', '$position')");
    }

    public function addMembersPicture($controlNo, $membersPic) {
        $db->query("INSERT INTO memberspicture (`ControlNo`,`Picture`) VALUES ('$controlNo','$membersPic)");
    }

    public function addMembersSigniture($controlNo, $membersSign) {
        $db->query("INSERT INTO memberssigniture (`ControlNo`,`Signiture`) VALUES ('$controlNo','$membersSign)");
    }

    public function addMembersContact($controlNo, $contact) {
        $db->query("INSERT INTO memberscontact (`ControlNo`, `ContactNo`) VALUES ('$controlNo', '$contact')");
    }

    public function addMemberCenter($controlNo, $centerNo, $date) {
        $db->query("INSERT INTO caritascenters_has_members (`CaritasCenters_ControlNo`, `Members_ControlNo`, `DateEntered`) VALUES ('$centerNo', '$controlNo', '$date')");
    }

    public function addSourceIncome($controlNo, $type, $companyName, $companyContact, $yearEntered) {
        $db->query("INSERT INTO sourceofincome (`ControlNo`, `BusinessType`, `CompanyName`, `CompanyContact`, `YearEntered`) VALUES ('$controlNo', '$type', '$companyName', '$companyContact', '$yearEntered')");
    }

    //Memebers View
    //getting ControlNumber for other tables
    public function getMembersControlNumber() {
        $getMemberControlNo = $db->query("SELECT ControlNo FROM Members ORDER BY ControlNo DESC LIMIT 1 ");
        
        return $getMemberControlNo;
        }
  

    //Getting Data
    public function getMembers($memberID) {
        $getMember = $db->query("SELECT  mem.ControlNo, Picture, MemberID, concat(memname.LastName,', ',memname.FirstName,' ', memname.MiddleName) AS Name,ContactNo, BirthPlace, GenderID, Religion, EducationalAttainment,CivilStatus, MFI, Status, Type, LoanExpense,Savings, CapitalShare 
                                FROM 
                                Members mem 
                                LEFT JOIN MembersName memname ON mem.ControlNo=memname.ControlNo
                                LEFT JOIN (SELECT ControlNo, Status FROM members_has_membersmembershipstatus ORDER BY DateUpdated DESC LIMIT 1) mhmstatus ON mem.ControlNo=mhmstatus.ControlNo
                                LEFT JOIN MembersPicture mempic ON mem.ControlNo=mempic.ControlNo
                                LEFT JOIN (SELECT ControlNo, Type FROM members_has_membertype ORDER BY DateUpdated DESC LIMIT 1) mhmtype ON mem.ControlNo=mhmtype.ControlNo
                                LEFT JOIN MembersContact memcontact ON mem.ControlNo=memcontact.ControlNo
                                LEFT JOIN membersmfi mfi ON mem.ControlNo=mfi.ControlNo
                                WHERE mem.ControlNo='2'");
        return $getMember;
    }

    public function getMembersbyControl($controlNo) {
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
                                WHERE mem.ControlNo='$controlNo'");
        return $getMember;
    }

    public function getMembersAddress($memberID, $addressType) {
        $getMemberAddress = $db->query("SELECT Address, AddressDate, AddressType FROM MembersAddress memadd
                                        RIGHT JOIN Members mem ON memadd.ControlNo=mem.ControlNo
                                        WHERE MemberID=$memberID AND AddressType=$addressType");

        return $getMemberAddress;
    }

    public function getMemberOrganization($memberID) {
        $getMemberOrg = $db->query("SELECT Organization, Position
                                    FROM MembersOrganization memorg 
                                    RIGHT JOIN (SELECT ControlNo FROM Members mem WHERE mem.MemberID='$memberID) A ON memorg.ControlNo=A.ControlNo");

        return $getMemberOrg;
    }

}

?>