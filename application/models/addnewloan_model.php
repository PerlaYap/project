<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Addnewloan_model extends CI_Model{

	function _construct(){

		parent::_construct();
	}

public function add_loanapplication(){

	//other Variables Needed

	$memberId=$this->security->xss_clean($this->input->post('memberid'));
	$memberControl= $this->getMemberControlNo($memberId);
	$branchNo=$this->security->xss_clean($this->input->post('branch'));
	$branchControl= $this->getBranchNo($branchNo);


	//Loan Application Table
	$amountrequested = $this->security->xss_clean($this->input->post('amountreq'));
    $capitalShare=$this->security->xss_clean($this->input->post('capitalshare'));
	$dayofweek  = $this->security->xss_clean($this->input->post('paymentday'));
	$loantype  = $this->security->xss_clean($this->input->post('loantype'));
	$dateapplied = $this->security->xss_clean($this->input->post('loandate'));

    if($loantype == "23-Weeks"){
        $interest= $amountrequested * 0.15; 
    }
    else if($loantype == "40-Weeks"){
        $interest= $amountrequested * 0.20; 
    }

	 //LoanBusiness if
	 $loanBusiness  = $this->security->xss_clean($this->input->post('loanbusiness'));

	if($loanBusiness=="newbusiness"){

		//Loan Business table
	    $businessName  = $this->security->xss_clean($this->input->post('businessname'));
	    $businessType  = $this->security->xss_clean($this->input->post('type'));

	    $establish_month = $this->security->xss_clean($this->input->post('month'));
		$establish_day = $this->security->xss_clean($this->input->post('day'));
		$establish_year = $this->security->xss_clean($this->input->post('year'));
		$dateestablish = $establish_year."-".$establish_month."-".$establish_day;

		//Business Contact Table
	    $contact_number  = $this->security->xss_clean($this->input->post('contact'));

	    //Business Address
	    $business_address = $this->security->xss_clean($this->input->post('businessaddress'));
	}

	//Materials 
	$omaterials = $this->security->xss_clean($this->input->post('materials'));
    $oquantity = $this->security->xss_clean($this->input->post('quantity'));
    $ounitprice = $this->security->xss_clean($this->input->post('unitprice'));

    //Other Materials
    $materials_1 = $this->security->xss_clean($this->input->post('materials_1'));
    $quantity_1 = $this->security->xss_clean($this->input->post('quantity_1'));
    $unitprice_1 = $this->security->xss_clean($this->input->post('unitprice_1'));

    //Comaker household
    $comakerHousehold=$this->security->xss_clean($this->input->post('comaker'));

    if($comakerHousehold == "newhousehold"){
    $hfName = $this->security->xss_clean($this->input->post('hfname'));
    $hmName = $this->security->xss_clean($this->input->post('hmname'));
    $hlName = $this->security->xss_clean($this->input->post('hlname'));
    $hgender = $this->security->xss_clean($this->input->post('hgender'));
    $hrelationship = $this->security->xss_clean($this->input->post('hrelation'));
    $hoccupation = $this->security->xss_clean($this->input->post('hoccupation'));
    $hage = $this->security->xss_clean($this->input->post('hname'));
    $hcivil = $this->security->xss_clean($this->input->post('hcivil'));
    }

    //Comaker Member
    $mcomakerid = $this->security->xss_clean($this->input->post('mcomakerid'));
    $mrelationship = $this->security->xss_clean($this->input->post('mrelationship'));

    //Income CI
    $incomeName=array();
    for($a=0; $a<4;$a++){
        $id="incomedrop".$a;
        $incomeName[$a]= $this->security->xss_clean($this->input->post($id));
    }

    $incomeAmount=array();
    for($a=0; $a<4;$a++){
        $id="income".$a;
        $incomeAmount[$a]= $this->security->xss_clean($this->input->post($id));
    }

    $income=array_combine($incomeName, $incomeAmount);

    //Family Expense CI
    $fexpenseName=array();
    for($a=0; $a<11;$a++){
        $id="fexpensedrop".$a;
        $fexpenseName[$a]= $this->security->xss_clean($this->input->post($id));
    }

    $fexpenseAmount=array();
    for($a=0; $a<11;$a++){
        $id="fexpense".$a;
        $fexpenseAmount[$a]= $this->security->xss_clean($this->input->post($id));
    }


    $fExpense=array_combine($fexpenseName, $fexpenseAmount);

    //Business Expense CI
    $bexpenseName=array();
    for($a=0; $a<10;$a++){
        $id="bexpensedrop".$a;
        $bexpenseName[$a]= $this->security->xss_clean($this->input->post($id));
    }

    $bexpenseAmount=array();
    for($a=0; $a<10;$a++){
        $id="bexpense".$a;
        $bexpenseAmount[$a]= $this->security->xss_clean($this->input->post($id));
    }


    $bExpense=array_combine($bexpenseName, $bexpenseAmount);

    //Start adding 

    $this->addLoanApplication($amountrequested,$interest, $capitalShare, $dateapplied,$dayofweek,"Pending",$loantype);
    $loanControlNo=$this->getLoanControlNo();
    $this->addApplicationNo($loanControlNo);

    $this->addMembersLoanApplication($loanControlNo,$memberControl,$branchControl);

    if($loanBusiness=="newbusiness"){
    $this->addLoanBusiness($businessName,$businessType,$dateestablish);
    $businessControlNo=$this->getBusinessControlNo();
    $this->addBusinessContact($businessControlNo,$contact_number);
    $this->addBusinessAddress($businessControlNo,$business_address);
	}

	else{
	$businessControlNo=$loanBusiness;
	}

	//Materials

    //FIRST ENTRY
            $this->addBusinessMaterials($loanControlNo,$businessControlNo,$omaterials,$oquantity,$ounitprice);

    //SECOND ENTRY

	if (!empty($materials_1) && !empty($quantity_1) && !empty($unitprice_1)) {
	    $arrsize = count($materials_1);
	    for ($size=0; $size < $arrsize ; $size++) {
            if($materials_1[$size]!="" && $quantity_1[$size]!="" && $unitprice_1[$size]!="" )
	    	$this->addBusinessMaterials($loanControlNo,$businessControlNo,$materials_1[$size],$quantity_1[$size],$unitprice_1[$size]);
	    }

	}

	//Comaker

	if($comakerHousehold == "newhousehold"){

	$this->addHousehold($hage, $hgender, $hcivil);
    $householdno = $this->getHouseholdControlNo();
    $this->addMembersHasHousehold($memberControl, $householdno, $hrelationship);
    $this->addHouseholdOccupation($householdno, $hoccupation);
    $this->addHouseholdName($householdno, $hfName, $hmName, $hlName);
	}

	else{
		$householdno=$comakerHousehold;
	}

	$this->addHouseholdComaker($loanControlNo,$householdno);

	//Member Comaker

	$this->addMemberComaker($loanControlNo,$memberControl,$mrelationship);

    //Income

    foreach ($income as $type => $amount) {
        if($amount!="")
        $this->addIncome($loanControlNo,$type,$amount);
    }

    //fExpense

    foreach ($fExpense as $type => $amount) {
        if($amount!="")
        $this->addFExpense($loanControlNo,$type,$amount);
    }

    //bExpense

    foreach ($bExpense as $type => $amount) {
        if($amount!="")
        $this->addBExpense($loanControlNo,$type,$amount);
    }

return true;

}


public function addLoanApplication($amountreq, $interest, $capitalShare, $dateapplied, $dayofweek,$status,$loantype){
	$this->db->query("INSERT INTO loanapplication (`AmountRequested`, `Interest`, `CapitalShare`, `DateApplied`, `DayoftheWeek`, `Status`, `LoanType`) VALUES ('$amountreq', '$interest', '$capitalShare', '$dateapplied', '$dayofweek', '$status', '$loantype')");
}

public function addLoanBusiness($businessName,$businessType,$dateEstablished){
    $this->db->query("INSERT INTO loanbusiness (`BusinessName`, `BusinessType`, `DateEstablished`) VALUES ('$businessName', '$businessType', '$dateEstablished')");
}

public function addBusinessContact($controlNo,$contact){
    $this->db->query("INSERT INTO businesscontact (`ControlNo`, `ContactNo`) VALUES ('$controlNo', '$contact')");
}

public function addBusinessAddress($controlNo,$businessAddress){
    $this->db->query("INSERT INTO businessaddress (`ControlNo`, `Address`) VALUES ('$controlNo', '$businessAddress')");
}

public function addBusinessMaterials($loanControlNo, $businessControlNo,$materials,$quantity,$unitPrice){
    $this->db->query("INSERT INTO loanbusiness_has_loanapplication (`LoanApplication_ControlNo`, `LoanBusiness_ControlNo` , `Material`, `Quantity`, `UnitPrice`) VALUES ('$loanControlNo', '$businessControlNo', '$materials', '$quantity', '$unitPrice');");
}

public function addMembersLoanApplication($loanControlNo,$memberControlNo,$branchControlNo){
    $this->db->query("INSERT INTO `microfinance2`.`loanapplication_has_members` (`LoanApplication_ControlNo`, `Members_ControlNo`, `CaritasBranch_ControlNo`) VALUES ('$loanControlNo', '$memberControlNo', '$branchControlNo');");
}

public function addMemberComaker($loanControlNo,$memberControlNo,$relationship){
    $this->db->query("INSERT INTO member_comaker (`LoanApplication_ControlNo`, `Members_ControlNo`, `Relationship`) VALUES ('$loanControlNo', '$memberControlNo', '$relationship');");
}

public function addHouseholdComaker($loanControlNo,$householdControlNo){
    $this->db->query("INSERT INTO `microfinance2`.`nonmember_comaker` (`LoanApplication_ControlNo`, `MembersHousehold_HouseholdNo`) VALUES ('$loanControlNo', '$householdControlNo')");
}
public function addHouseholdSign($householdControlNo, $sign){
    $this->db->query("INSERT INTO householdsignature (`ControlNo`,`Signature`) VALUES ('$$householdControlNo','$sign)");
}

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

public function addIncome($loanControl, $type, $amount) {
        $this->db->query("INSERT INTO loanapplication_has_incometype (`LoanApplication_ControlNo`, `IncomeType_IncomeType`, `Amount`) VALUES ('$loanControl', '$type', '$amount');");
    }

public function addFExpense($loanControl, $type, $amount) {
        $this->db->query("INSERT INTO loanapplication_has_familyexpensetype (`LoanApplication_ControlNo`, `FamilyExpenseType_ExpenseType`, `Amount`) VALUES ('$loanControl', '$type', '$amount');");
    }

public function addBExpense($loanControl, $type, $amount) {
        $this->db->query("INSERT INTO loanapplication_has_businessexpensetype (`loanapplication_ControlNo`, `BusinessExpenseType_ExpenseType`, `Amount`) VALUES ('$loanControl', '$type', '$amount');");
    }

public function addHouseholdSignature($controlNo, $picture){
    $this->db->query("INSERT INTO householdsignature (`HouseholdNo`, `Signature`) VALUES ('$controlNo', '$picture')");
}

public function addApplicationNo($loanControl) {
        $this->db->query("UPDATE LoanApplication SET ApplicationNumber='$loanControl' WHERE ControlNo='$loanControl'");
    }

//get Loan Application Control No
public function getLoanControlNo(){
    $query = $this->db->query("SELECT ControlNo FROM loanapplication ORDER BY ControlNo DESC LIMIT 1 ");

        if ($query->num_rows() > 0) {
            $row = $query->row();
            $controlNo = $row->ControlNo;
            return $controlNo;
        }
    }

//get Loan Business Control No
public function getBusinessControlNo(){
    $query = $this->db->query("SELECT ControlNo FROM loanbusiness ORDER BY ControlNo DESC LIMIT 1 ");

        if ($query->num_rows() > 0) {
            $row = $query->row();
            $controlNo = $row->ControlNo;
            return $controlNo;
        }
    }

public function getMemberControlNo($memberID){
    $query = $this->db->query("SELECT ControlNo FROM members WHERE MemberID='$memberID'");

        if ($query->num_rows() > 0) {
            $row = $query->row();
            $controlNo = $row->ControlNo;
            return $controlNo;
        }
    }

public function getBranchNo($branch){
    $query = $this->db->query("SELECT ControlNo FROM caritasbranch WHERE BranchName='$branch'");

        if ($query->num_rows() > 0) {
            $row = $query->row();
            $controlNo = $row->ControlNo;
            return $controlNo;
        }
    }

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