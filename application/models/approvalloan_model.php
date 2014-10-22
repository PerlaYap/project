<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Approvalloan_model extends CI_Model{

	function _construct(){

		parent::_construct();
		}

	public function approveloan(){
		$controlno = $this->security->xss_clean($this->input->post('loanID'));

		return $this->approveLoanQuery($controlno);
		}

	public function currentloan(){
		 $controlno = $this->security->xss_clean($this->input->post('loanID'));
		 $memberno = $this->security->xss_clean($this->input->post('memberID'));
		 $activerelease = $this->security->xss_clean($this->input->post('activerelease'));
		 $so = $this->security->xss_clean($this->input->post('sonumber'));
		 $amount = $this->security->xss_clean($this->input->post('capitalshare'));
		 $date= date('Y-m-d');

		$this->addReleaseDate($controlno, $date);
		$this->addloanbalance($activerelease, $memberno);
		$this->insertCapitalShare($controlno, $amount,$date,$memberno,$so);

		return $this->currentizeLoanQuery($controlno);
	}

	public function rejectloan(){
		$comment=$this->security->xss_clean($this->input->post('message'));
		$controlno = $this->security->xss_clean($this->input->post('loanID'));

		$this->addRejectComment($comment,$controlno);

		return $this->rejectLoanQuery($controlno);
		}

	public function approveLoanQuery($loanControlNo){
	    $this->db->query("UPDATE loanapplication SET Status='Active' WHERE ControlNo='$loanControlNo';");
	}
	public function addloanbalance($loanbalance, $membercontrolno){
		$this->db->query("UPDATE members SET LoanExpense = '$loanbalance' WHERE members.ControlNo = '$membercontrolno';");
	}

	public function rejectLoanQuery($loanControlNo){
	    $this->db->query("UPDATE loanapplication SET Status='Rejected' WHERE ControlNo='$loanControlNo';");
	}

	public function addRejectComment($comment, $controlNo){
		$this->db->query("UPDATE loanapplication SET Comments='$comment' WHERE ControlNo='$controlNo';");
	}

	public function currentizeLoanQuery($loanControlNo){
	    $this->db->query("UPDATE loanapplication SET Status='Current' WHERE ControlNo='$loanControlNo';");
	}

	public function addReleaseDate($loanControl,$dateRelease){
		$this->db->query("UPDATE LoanApplication SET DateReleased='$dateRelease' WHERE ControlNo='$loanControl';");
	}

	public function insertCapitalShare($loanappno, $loanpayment, $datetime, $member, $so){

		$this->db->query("INSERT INTO `microfinance2`.`transaction` ( `LoanAppControlNo`, `Amount`, `DateTime`, `Members_ControlNo`, `Passbook_ControlNo`, `CaritasPersonnel_ControlNo`, `TransactionType`) VALUES ('$loanappno', '$loanpayment', '$datetime', '$member', '2', '$so', 'Capital Share');");
	}
}

?>