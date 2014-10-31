<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Audittrail_model extends CI_Model{


	function _construct(){

		parent::_construct();
	}

	public function setlog($activity){
		date_default_timezone_set('Asia/Manila');
		 $user = $this->session->userdata('personnelno');
		/*'YYYY-MM-DD HH:MI:SS'*/
		 $datetime = date("Y-m-d H:i:s");

		$this->db->query("INSERT INTO `log`(`datetime`, `Activity`, `caritaspersonnel_ControlNo`) VALUES ('$datetime','$activity','$user')");
	}
	public function getlog(){
		$branchno = $this->session->userdata('branchno');
		$log = $this->db->query("SELECT * FROM `audittrail` where PersonnelNo in (Select CaritasPersonnel_ControlNo from caritasbranch_has_caritaspersonnel where caritasbranch_controlNo = $branchno)");
		return $log->result();
	}

}

?>