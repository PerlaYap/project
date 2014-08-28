<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Editcollection_model extends CI_Model{

	public function gettransaction(){
	$transactionno = $this->security->xss_clean($this->input->post('transactionno'));

	 $amount = $this->security->xss_clean($this->input->post('amounttochange'));
/*	echo "<br>";*/
	 $transaction_type = $this->security->xss_clean($this->input->post('transacttype'));


		$this->updatetransaction ($transactionno, $amount, $transaction_type);
		 return true;

	}

	public function updatetransaction ($transactionno, $amount, $transaction_type){
		$this->db->query("UPDATE `microfinance2`.`transaction` SET `Amount` = '$amount' WHERE `transaction`.`ControlNo` = $transactionno;");

		$this->db->query("UPDATE `microfinance2`.`transaction` SET `TransactionType` = '$transaction_type' WHERE `transaction`.`ControlNo` = $transactionno;");
		
	}
}

?>