<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Editcollection_model extends CI_Model{

	public function gettransaction(){
	$transactionno = $this->security->xss_clean($this->input->post('transactionno'));

	 $amount = $this->security->xss_clean($this->input->post('amounttochange'));
	 $prev_amount = $this->security->xss_clean($this->input->post('prev_amount'));
/*	echo "<br>";*/
	 $transaction_type = $this->security->xss_clean($this->input->post('transacttype'));
	 $prev_ttype = $this->security->xss_clean($this->input->post('prev_ttype'));


		$this->updatetransaction ($transactionno, $amount, $transaction_type);

		$memberid = $this->getmemberid($transactionno);
		$name = $this->getmembername($memberid);
		 
		 $result['result'] = true;
		 $result['prev_amount'] = $prev_amount;
		 $result['prev_ttype'] = $prev_ttype;
		 $result['amount'] = $amount;
		 $result['transaction_type'] = $transaction_type;
		 $result['transactno'] = $transactionno;
		 $result['membername'] = $name;

		 return $result;


	}

	public function updatetransaction ($transactionno, $amount, $transaction_type){
		//setting amount
		$this->db->query("UPDATE `microfinance2`.`transaction` SET `Amount` = '$amount' WHERE `transaction`.`ControlNo` = $transactionno;");
		//setting transaction type
		$this->db->query("UPDATE `microfinance2`.`transaction` SET `TransactionType` = '$transaction_type' WHERE `transaction`.`ControlNo` = $transactionno;");
		
	}
	public function getmemberid($t_controlno){
		$query = $this->db->query("SELECT `ControlNo`, `Members_ControlNo` FROM `transaction` WHERE `ControlNo` = $t_controlno");

		if ($query->num_rows() > 0) {
	            $row = $query->row();
	            $memberid = $row->Members_ControlNo;
	           
	            return $memberid;
	        }


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