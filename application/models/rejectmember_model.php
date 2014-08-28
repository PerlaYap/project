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

		$query = $this->db->query("UPDATE `microfinance2`.`members` SET `Approved` = 'NO' WHERE `members`.`ControlNo` = $controlno;");
		$query2 = $this->db->query("UPDATE `microfinance2`.`members` SET `Comment` = '$reason' WHERE `members`.`ControlNo` = $controlno;");

		if($query){
			return "True";
			}else{
				return "False";
			}

		}


	}
?>