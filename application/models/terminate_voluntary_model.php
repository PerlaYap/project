<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class terminate_voluntary_model extends CI_Model{


	function _construct(){

		parent::_construct();
	}

	public function getcontrolno(){

		 $controlno = $this->security->xss_clean($this->input->post('controlno'));
		 return $controlno;
		 }
	public function getprofileinfo($control_no){
		/*$control_no = $this->getcontrolno();*/
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
	public function getbranchcenter($control_no){
		/*$control_no = $this->getcontrolno();*/
		$branchcenter = $this->db->query("SELECT cm.`CaritasCenters_ControlNo`, cc.`CenterNo`, cbc.`CaritasBranch_ControlNo`, b.`BranchName`
							FROM `caritascenters_has_members` cm, `caritascenters` cc, `caritasbranch_has_caritascenters` cbc,
							`caritasbranch` b
							where `Members_ControlNo` = '$control_no' and cm.`CaritasCenters_ControlNo` = cc.`ControlNo` and
							cbc.`CaritasCenters_ControlNo` = cc.`ControlNo` and
							b.`ControlNo` = cbc.`CaritasBranch_ControlNo`");
			return $branchcenter->result();
	 }
	public function getloaninfo($control_no){
		/*$control_no = $this->getcontrolno();*/
		$getLoanInfo = $this->db->query("SELECT loanapplication_ControlNo AS LoanControl, ApplicationNumber, AmountRequested, Interest, DateApplied, DayoftheWeek, Status, LoanType FROM loanapplication_has_members lhm
			LEFT JOIN loanapplication la ON lhm.LoanApplication_ControlNo=la.ControlNo
			WHERE lhm.Members_ControlNo='$control_no' and Status='Current'");
		return $getLoanInfo->result();
	 }
	public function getloancontrolno (){
		$control_no = $this->getcontrolno();
		$getLoanInfo = $this->db->query("SELECT loanapplication_ControlNo AS LoanControl, ApplicationNumber, AmountRequested, Interest, DateApplied, DayoftheWeek, Status, LoanType FROM loanapplication_has_members lhm
			LEFT JOIN loanapplication la ON lhm.LoanApplication_ControlNo=la.ControlNo
			WHERE lhm.Members_ControlNo='$control_no' and Status='Current'");

		if ($getLoanInfo->num_rows()>0) {
			$row = $getLoanInfo->row();
			return $row->LoanControl;
		}
	 }
	public function getcomaker(){

		$loanappcontrol = $this->getloancontrolno();

		$comaker = $this->db->query("SELECT LastName, FirstName, MiddleName,MemberID, Address, ContactNo FROM `members` m join `member_comaker` mc on m.ControlNo = mc.`Members_ControlNo` join `membersname` mn on mn.ControlNo = mc.`Members_ControlNo` join `membersaddress` madd on madd.ControlNo = mc.`Members_ControlNo` join `memberscontact` mcon on mcon.ControlNo = mc.`Members_ControlNo` where `LoanApplication_ControlNo` =$loanappcontrol");

		return $comaker->result();	
	 }
	public function getcapitalshare($control_no){

		/*$control_no = $this->getcontrolno();*/

		 $getTotalCapitalShare = $this->db->query("SELECT  SUM(CapitalShare) AS TotalShare FROM loanapplication_has_members lhm LEFT JOIN (SELECT * FROM LoanApplication la WHERE Status!='Rejected' AND Status!='Pending')A ON lhm.LoanApplication_ControlNo=A.ControlNo WHERE Members_ControlNo=$control_no AND ControlNo IS NOT NULL");

		 return $getTotalCapitalShare->result(); 
	  }
	public function getsavings($control_no){
		/*$control_no = $this->getcontrolno();*/

		$gettotsavings = $this->db->query("SELECT `Savings` FROM `members` where `ControlNo` = $control_no");

		return $gettotsavings->result();
	 }
	public function getloanbalance(){
		 $loanbalance = $this->security->xss_clean($this->input->post('loanbalance'));
		 return $loanbalance;}
	public function getpaymentrecieved(){
		$paymentrecieved = $this->security->xss_clean($this->input->post('paymentrecieved'));
		return $paymentrecieved;
	 }
	public function getdatetoday(){
		$datetoday = $this->security->xss_clean($this->input->post('datetoday'));
		return $datetoday;
	 }
	public function getsopersonnel(){
		$sopersonnel = $this->security->xss_clean($this->input->post('sopersonnel'));
		return $sopersonnel;
	 }
	public function setterminatestatus($control_no){
		 
		 $this->db->query("INSERT INTO members_has_membersmembershipstatus(`ControlNo`, `DateUpdated`, `Status`) VALUES ('$control_no', NOW(), 'Terminated Voluntarily')"); }
	public function paythroughsavings($loantopay){

		 $control_no = $loantopay['controlno'];
		 $loanbalance = $loantopay['loanbalance'];
		
	 	 foreach ($loantopay['savings'] as $save) {
		 $savingstot =$save->Savings;	
		 }
		 $savingstot;

		 if ($savingstot>=$loanbalance) {
			/*add transaction of payment ng loan amount equal sa full ng loan balance*/
			/*withdrawal the money*/
			/*update yung sa member*/
		 }elseif ($savingstot<$loanbalance) {
			
		 } }
	public function gettermination_report($control_no){
		$result = $this->db->query("SELECT  
								    m.controlno,
								    concat(mn.FirstName,
								            ' ',
								            mn.MiddleName,
								            ' ',
								            mn.LastName) as Name,
								    date(mt.DateUpdated) as DateEntered,
								    cs.totcapitalshare,
								    m.savings,
								    (cs.totcapitalshare + m.savings) as recievable_amount,
									st.status,
									date(st.DateUpdated) as StatusUpdateDate
								from
								    members m
								        left join
								    membersname mn ON m.ControlNo = mn.ControlNo
								        left join
								    members_has_membertype mt ON mt.ControlNo = m.ControlNo
								        left join
								    totalcapitalshare cs ON cs.Members_ControlNo = m.ControlNo
								        right join
								    (SELECT 
								        MemberControl, Status, DateUpdated
								    FROM
								        (SELECT 
								        ControlNo AS MemberControl
								    FROM
								        Members_has_Membersmembershipstatus) A
								    LEFT JOIN (SELECT 
								        *
								    FROM
								        (SELECT 
								        *
								    FROM
								        Members_has_MembersMembershipstatus
								    ORDER BY DateUpdated DESC) A
								    GROUP BY ControlNo) B ON A.MemberControl = B.ControlNo
								where Status = 'Terminated Voluntarily' or Status = 'Terminated'
								    group by MemberControl) st ON st.MemberControl = m.ControlNo
								where m.controlno = $control_no;");

		return $result->result(); }


    
}
?>