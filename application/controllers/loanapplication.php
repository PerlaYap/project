<?php if ( !  defined('BASEPATH')) exit('No direct script access allowed');

class LoanApplication extends CI_Controller{

	public function addnewloan(){
		$this->load->view("header");
		$this->load->view("navigation");
		$this->load->view("Salveofficer/addnewloan");
		$this->load->view("footer");
		}
	public function addnewloanprocess(){
		$data=array('mid'=>$this->input->post('memberid'), 'date'=>$this->input->post('loandate'));
		
		$this->load->view("header");
		$this->load->view("navigation");
		$this->load->view("Salveofficer/addnewloan2",$data);
		$this->load->view("footer");
		}
	public function addnewloanprocess1(){

		$this->load->model('addnewloan_model');

		$result=$this->addnewloan_model->add_loanapplication();
		

		if ($result['r'] == 1) {

			$activity = "Added new loan to ".$result['name']." (Pending)";
	        $this->load->model("audittrail_model");
	        $this->audittrail_model->setlog($activity);

			$this->load->view('header');
	        $this->load->view('navigation');
			$this->load->view('salveofficer/homepage'); 
	        $this->load->view('footer');
				}
		}
	public function forloanapprovallist(){

		$this->load->view('header');
        $this->load->view('navigation');
		$this->load->view("branchmanager/loanapprovallist");
        $this->load->view('footer');

		}
	public function forloanapprovals(){

		$this->load->view('header');
        $this->load->view('navigation');
		$this->load->view("branchmanager/loanforapproval");
        $this->load->view('footer');
		
		}
	public function loanapproved(){
		$this->load->view('header');
        $this->load->view('navigation');
		$this->load->view("branchmanager/loanapproved");
		$this->load->view('footer');
		}
	public function approveloan(){

		//alert for successfully approved and back to homepage
		$this->load->model("approvalloan_model");
		$result =$this->approvalloan_model->approveloan();

			$message = "Successfully Approved Loan Application.";
			echo "<script type='text/javascript'>alert('$message');</script>";
		$activity = "Approved Loan Application of ".$result['name'].".";
        $this->load->model("audittrail_model");
        $this->audittrail_model->setlog($activity);

			$this->load->view('header');
	        $this->load->view('navigation');
			$this->load->view('salveofficer/homepage'); 
	        $this->load->view('footer');
		}
	public function reasonrejectloan(){
			$data=array('loanControl'=>$this->input->post('loanID'));
			
			$this->load->view("header");
			$this->load->view("navigation");
			$this->load->view("branchmanager/loanrejectreason", $data);
			$this->load->view("footer"); }
	public function rejectloan(){
			$this->load->model("approvalloan_model");
			$result= $this->approvalloan_model->rejectloan();

			$message = "Successfully Rejected Application.";
			echo "<script type='text/javascript'>alert('$message');</script>";
			$activity = "Rejected Loan Application of ".$result['name'].".";
	        $this->load->model("audittrail_model");
	        $this->audittrail_model->setlog($activity);

			$this->load->view('header');
	        $this->load->view('navigation');
			$this->load->view('salveofficer/homepage'); 
	        $this->load->view('footer'); }
	public function approvedloans(){
		$this->load->view('header');
        $this->load->view('navigation');
		$this->load->view("branchmanager/loanapproved");
		$this->load->view('footer');
	 }
	public function releaseLoan(){

		/*	echo "hello world";*/
		$this->load->model("approvalloan_model");
		$result= $this->approvalloan_model->currentloan();

		$data=array('loanControl'=>$this->input->post('loanID'));

		$activity = "Released Loan of ".$result['name']." amounted to P".$result['totalpayment'].".";
	    $this->load->model("audittrail_model");
	    $this->audittrail_model->setlog($activity);

		$this->load->view("reports/paymentchecklist",$data);
	 }
	public function printsummary(){
		$data=array('loanControl'=>$this->input->post('loanID'));

		$this->load->view('header');
        $this->load->view('navigation');
		$this->load->view("reports/summaryreport", $data);
		$this->load->view('footer');
	 }
	public function backtoloan(){
		$data=array('loanControl'=>$this->input->post('loanID'));

		$this->load->view("reports/paymentchecklist");
	 }
	public function showSummary(){
		$data=array('loanControl'=>$this->input->post('loanID'));

		$this->load->view('header');
        $this->load->view('navigation');
		$this->load->view("reports/summaryreport", $data);
		$this->load->view('footer');
	 }
	public function showPayment(){
		$data=array('loanControl'=>$this->input->post('loanID'));
		$this->load->view("reports/paymentchecklist", $data);
	 }

	}

?>