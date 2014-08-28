<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Addviolation_model extends CI_Model{

	function _construct(){

		parent::_construct();
	}

	public function add_violations(){
	$memberControl=$this->security->xss_clean($this->input->post('memberid'));
	$personnelId=$this->security->xss_clean($this->input->post('personnel'));
	$personnelID = substr($personnelId, 0, strpos($personnelId, '|'));
	/*echo $personnelId;*/
	/*echo "hiihi";*/
	$personnelControl= $this->getPersonnelControl($personnelID);

	$violationID  = $this->security->xss_clean($this->input->post('violations'));

	$month = $this->security->xss_clean($this->input->post('month'));
	$day = $this->security->xss_clean($this->input->post('day'));
	$year = $this->security->xss_clean($this->input->post('year'));
	$violationdate = $year."-".$month."-".$day;

	$comment  = $this->security->xss_clean($this->input->post('comment'));

	$this->addViolation($violationdate,$comment,$memberControl,$violationID,$personnelControl);

		return true;
	}


public function addViolation($date, $comment,$memControl,$violationID, $perId){
	$this->db->query("INSERT INTO members_has_violations (`Date`, `Comment`, `Members_ControlNo`, `Violations_ViolationID`, `CaritasPersonnel_ControlNo`) VALUES ('$date', '$comment', '$memControl', '$violationID', '$perId');");
}
	
	public function getMemberControlNo($memberID){
    $query = $this->db->query("SELECT ControlNo FROM members WHERE MemberID='$memberID'");

        if ($query->num_rows() > 0) {
            $row = $query->row();
            $controlNo = $row->ControlNo;
            return $controlNo;
        }
    }

    public function getPersonnelControl($personnelId){
    $query = $this->db->query("SELECT ControlNo FROM caritaspersonnel WHERE PersonnelID='$personnelId'");

        if ($query->num_rows() > 0) {
            $row = $query->row();
            $controlNo = $row->ControlNo;
            return $controlNo;
        }
    }


}
