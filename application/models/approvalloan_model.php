<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Approvalloan_model extends CI_Model{

	function _construct(){

		parent::_construct();
		}

	public function approveloan(){
		$controlno = $this->security->xss_clean($this->input->post('loanID'));

			$this->approveLoanQuery($controlno);
			$mcontrol = $this->getmembercontrol($controlno);
			$name = $this->getmembername($mcontrol);

			$result['result']=true;
			$result['name'] = $name;

			return $result;
		}
	public function currentloan(){
		 $controlno = $this->security->xss_clean($this->input->post('loanID'));
		 $memberno = $this->security->xss_clean($this->input->post('memberID'));
		 $activerelease = $this->security->xss_clean($this->input->post('activerelease'));
		 $so = $this->security->xss_clean($this->input->post('sonumber'));
		 $amount = $this->security->xss_clean($this->input->post('capitalshare'));
		 $totalpayment = $this->security->xss_clean($this->input->post('totalpayment'));
		 $date= date('Y-m-d');

			$this->addReleaseDate($controlno, $date);
			$this->addloanbalance($activerelease, $memberno);
			$this->insertCapitalShare($controlno, $amount,$date,$memberno,$so);

			$this->currentizeLoanQuery($controlno);

		 	$name = $this->getmembername($memberno);


			$result['result']=true;
			$result['name'] = $name;
			$result['totalpayment'] = $totalpayment;

			return $result;

	 }
	public function rejectloan(){
		$comment=$this->security->xss_clean($this->input->post('message'));
		$controlno = $this->security->xss_clean($this->input->post('loanID'));

		$this->addRejectComment($comment,$controlno);
		$this->rejectLoanQuery($controlno);
		$mcontrol = $this->getmembercontrol($controlno);
			$name = $this->getmembername($mcontrol);

			$result['result']=true;
			$result['name'] = $name;

			return $result;
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
	public function getmembercontrol($loancontrol){
		$query = $this->db->query("SELECT `LoanApplication_ControlNo`, `Members_ControlNo`, `CaritasBranch_ControlNo` FROM `loanapplication_has_members` WHERE `LoanApplication_ControlNo` ='$loancontrol' ");

		 if ($query->num_rows() > 0) {
	            $row = $query->row();
	            $membercontrol = $row->Members_ControlNo;

	            return $membercontrol;
	        }


		}	
}

?>