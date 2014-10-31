<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Rejectmember_model extends CI_Model{

	function _construct(){

		parent::_construct();
		}

	public function getcontrolno(){
		$controlno = $this->security->xss_clean($this->input->post('controlno'));
		return $controlno;
	}

	public function reject(){
		$controlno = $this->getcontrolno();
		$reason = $this->security->xss_clean($this->input->post('message'));

		//Sql statement for updating application status -> Approved
		$name = $this->getmembername($controlno);
		$query = $this->db->query("UPDATE `microfinance2`.`members` SET `Approved` = 'NO' WHERE `members`.`ControlNo` = $controlno;");
		$query2 = $this->db->query("UPDATE `microfinance2`.`members` SET `Comment` = '$reason' WHERE `members`.`ControlNo` = $controlno;");
		
		if($query){
			$result['result'] ='True';
			$result['name'] = $name;
		}else{
			$result['result']='False';
		}
		return $result;

		}

	public function getmembername($memberControl){

	    $query = $this->db->query("SELECT * FROM `membersname` where ControlNo =$memberControl");

	        if ($query->num_rows() > 0) {
	            $row = $query->row();
	            $fname = $row->FirstName;
	            $mname = $row->MiddleName;
	            $lname = $row->LastName;

	            $name = $fname." ".$mname." ".$lname;
	            return $name;
	        }

	}


	}
?>