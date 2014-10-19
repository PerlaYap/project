<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class terminate_voluntary_model extends CI_Model{


	function _construct(){

		parent::_construct();
	}

	public function getcontrolno(){

		 $controlno = $this->security->xss_clean($this->input->post('controlno'));
		 //this is to be send
		/* $profileinfo = $this->getprofileinfo($controlno);
		 $branchcenter = $this->getbranchcenter($controlno);*/
		 return $controlno;
		 /*return $profileinfo->result();*/
		 
		 

		}
	public function getprofileinfo(){
		$control_no = $this->getcontrolno();
		$profileinfo = $this->db->query("SELECT  mem.ControlNo, MemberID,memname.LastName,memname.FirstName, memname.MiddleName, ContactNo,Birthday,BirthPlace, GenderID, Religion, Date(cm.DateEntered) as date, EducationalAttainment,CivilStatus, MFI,Address,AddressDate, Status, Type,BusinessType,CompanyName,CompanyContact,YearEntered, LoanExpense,Savings, CapitalShare 
                                FROM 
                                Members mem 
                                LEFT JOIN MembersName memname ON mem.ControlNo=memname.ControlNo
                                LEFT JOIN (SELECT ControlNo, Status FROM members_has_membersmembershipstatus ORDER BY DateUpdated DESC LIMIT 1) mhmstatus ON mem.ControlNo=mhmstatus.ControlNo
                                
                                LEFT JOIN (SELECT ControlNo, Type FROM members_has_membertype ORDER BY DateUpdated DESC LIMIT 1) mhmtype ON mem.ControlNo=mhmtype.ControlNo
                                LEFT JOIN MembersContact memcontact ON mem.ControlNo=memcontact.ControlNo
                                LEFT JOIN membersmfi mfi ON mem.ControlNo=mfi.ControlNo
                                LEFT JOIN membersaddress madd ON mem.ControlNo=madd.ControlNo
                                LEFT JOIN sourceofincome soi ON mem.ControlNo=soi.ControlNo
                                LEFT JOIN CaritasCenters_has_Members cm ON mem.ControlNo = cm.Members_ControlNo
                                WHERE mem.ControlNo='$control_no'");
		
		return $profileinfo->result();
	}
	public function getbranchcenter(){
		$control_no = $this->getcontrolno();
		$branchcenter = $this->db->query("SELECT cm.`CaritasCenters_ControlNo`, cc.`CenterNo`, cbc.`CaritasBranch_ControlNo`, b.`BranchName`
							FROM `caritascenters_has_members` cm, `caritascenters` cc, `caritasbranch_has_caritascenters` cbc,
							`caritasbranch` b
							where `Members_ControlNo` = '$control_no' and cm.`CaritasCenters_ControlNo` = cc.`ControlNo` and
							cbc.`CaritasCenters_ControlNo` = cc.`ControlNo` and
							b.`ControlNo` = cbc.`CaritasBranch_ControlNo`");
			return $branchcenter->result();
	}
	public function getloaninfo(){
		$control_no = $this->getcontrolno();
		$getLoanInfo = $this->db->query("SELECT loanapplication_ControlNo AS LoanControl, ApplicationNumber, AmountRequested, Interest, DateApplied, DayoftheWeek, Status, LoanType FROM loanapplication_has_members lhm
			LEFT JOIN loanapplication la ON lhm.LoanApplication_ControlNo=la.ControlNo
			WHERE lhm.Members_ControlNo='$control_no' and Status='Current'");
		return $getLoanInfo->result();
	}
	

    
}
?>