<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Household
 *
 * @author albert
 */
class Household extends CI_Model {

    //put your code here

    public function addHousehold($age, $gender, $status) {
        $db->query("INSERT INTO membershousehold(`Age`, `GenderID`, `CivilStatus`) VALUES ('$age', '$gender', '$status')");
    }

    public function addHouseholdOccupation($controlNo, $occupation) {
        $db->query("INSERT INTO householdoccupation (`HouseholdNo`, `Occupation`) VALUES ('$controlNo', '$occupation')");
    }

    public function addHouseholdName($controlNo, $firstName, $middleName, $lastName) {
        $db->query("INSERT INTO householdname (`HouseholdNo`, `FirstName`, `MiddleName`, `LastName`) VALUES ('$controlNo', '$firstName', '$middleName', '$lastName')");
    }

    public function addMembersHasHousehold($membersControlNo, $householdNo, $relationship) {
        $db->query("INSERT INTO members_has_membershousehold` (`ControlNo`, `HouseholdNo`, `Relationship`) VALUES ('$membersControlNo', '$householdNo', '$relationship')");
    }
    
    
    //get Household Member Control Number

  public function getHouseholdControlNo() {
         $getHouseholdControlNo = $db->query("SELECT ControlNo FROM Members ORDER BY ControlNo DESC LIMIT 1 ");
        
        return $getHouseholdControlNo;
        }
  
    //Views
    public function getMembersHousehold($memberControlNo){
        $getHousehold=$db->query("SELECT ControlNo, msmhouse.HouseholdNo, Relationship, Age, GenderID, CivilStatus, A.Name, A.Occupation
                    FROM members_has_membershousehold msmhouse
                    LEFT JOIN 
                    (SELECT memhouse.HouseholdNo AS HouseholdNo, Age, GenderID, CivilStatus,  concat(hname.LastName,', ',hname.FirstName,' ', hname.MiddleName) AS Name, Occupation FROM membershousehold memhouse
                    LEFT JOIN householdname hname ON memhouse.HouseholdNo=hname.HouseholdNo
                    LEFT JOIN householdoccupation hoccu ON memhouse.HouseholdNo=hoccu.HouseholdNo)A ON msmhouse.HouseholdNo=A.HouseholdNo
                    WHERE ControlNo='$memberControlNo'");
        
        return $getHousehold;
    }
 }
?>