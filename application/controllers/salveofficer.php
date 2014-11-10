<?php if ( !  defined('BASEPATH')) exit('No direct script access allowed');

class Salveofficer extends CI_Controller {


	public function addnewmember(){
		$this->load->view('header');
        $this->load->view('navigation');
		$this->load->view("salveofficer/verification");
		$this->load->view('footer');
		}
	public function verifymember(){
		$this->load->model('verifymember_model');
		$result['data'] = $this->verifymember_model->getverificationinfo();
		
		if (count($result['data'])==0) {
			$data=array('fname' => $this->input->post('firstname'), 'lname' => $this->input->post('lastname'),'mname' => $this->input->post('middlename'),'bday' => $this->input->post('birthday'));

			echo "<script type='text/javascript'>alert('NO RESULT FOUND! You may proceed to add the new member.')</script>";
			$this->load->view('header');
        	$this->load->view('navigation');
			$this->load->view("Salveofficer/addnewmember",$data);
			$this->load->view('footer');
		}else{

			$num = count($result);
			echo "<script type='text/javascript'>alert('".$num." RESULT FOUND!')</script>";
			$this->load->view('header');
        	$this->load->view('navigation');
			$this->load->view("Salveofficer/foundverification",$result);
			$this->load->view('footer');
		}
	 }
	public function gotoprofile(){
		$sub = $_GET['submitvalue'];
		if ($sub=="View Profile") {

		$this->load->view('header');
        $this->load->view('navigation');
        $this->load->view("general/profile");
        $this->load->view("footer");	
		}else if($sub=="Cancel"){
		$this->load->view('header');
        $this->load->view('navigation');
        $this->load->view("salveofficer/homepage");
        $this->load->view("footer");	
		}else{
			echo "Please Try Again.";
		}
		
	 }
	public function approvedaccounts(){
		$this->load->view('header');
        $this->load->view('navigation');
		$this->load->view("Salveofficer/approvedaccounts");
		 $this->load->view('footer');
		
		}
	public function addnewmemberprocess(){
			//load model
			$this->load->model('addnewmember_model');

			$result = $this->addnewmember_model->get_memberdetails();

			/*	if ($result == 1) { */
			
			$activity = "Added new member named ".$result." . (Pending)";
	        $this->load->model("audittrail_model");
	        $this->audittrail_model->setlog($activity);

			$this->load->view('header');
	        $this->load->view('navigation');
			$this->load->view('salveofficer/homepage'); 
	        $this->load->view('footer');
			
				/*}*/
			}
	public function search(){
    
        //load model
        $this->load->model('search_model');
        $data['searchval'] = $this->search_model->getsearchname();
        
        $this->load->view('header');
        $this->load->view('navigation');
        $this->load->view('general/search', $data);
        $this->load->view('footer');

        }
    public function profiles(){

        $this->load->view('header');
        $this->load->view('navigation');
        $this->load->view("general/profile");
        $this->load->view("footer");
       
        }
    public function editprofile(){
     

      $this->load->model('editprofile_model');
      $data['number'] = $this->editprofile_model->getcontrolno();

        $this->load->view('header');
        $this->load->view('navigation');
        $this->load->view('salveofficer/SOeditmember',$data);
        $this->load->view("footer");
    	}
    public function editmember(){

        $this->load->model('editprofiledetails_model');
       $result = $this->editprofiledetails_model->setdetails();

       if ($result) {
           echo "<script type='text/javascript'>alert('Successfully Updated Profile!')</script>";
       }else{
            echo "<script type='text/javascript'>alert('Failed to update profile!')</script>";
       }
		
        $this->load->view('header');
        $this->load->view('navigation');
        $this->load->view('salveofficer/homepage'); 
        $this->load->view('footer');
       
    	}
    public function violations(){

        $this->load->view('header');
        $this->load->view('navigation');
        $this->load->view("salveofficer/violations");
        $this->load->view("footer");
       
        }
    public function addviolation(){
		$this->load->model('addviolation_model');

		$result=$this->addviolation_model->add_violations();

		if ($result == 1) {
			$this->load->view('header');
	        $this->load->view('navigation');
			$this->load->view('salveofficer/homepage'); 
	        $this->load->view('footer');
				}
		}
	public function capitalshare(){
		$this->load->view('header');
        $this->load->view('navigation');
		$this->load->view("salveofficer/capitalshare");
		$this->load->view('footer');
		}
	public function directory(){

		$this->load->view('header');
        $this->load->view('navigation');
		$this->load->view("general/directory");
		$this->load->view('footer');
		}
	public function activedormant(){
		$this->load->view('salveofficer/activedormant');
	 }
	public function targetactualcenter(){
		$this->load->view('salveofficer/targetactualcenter');
	 }
	public function terminate(){
		$this->load->model('terminate_voluntary_model');
		$controlno = $this->terminate_voluntary_model->getcontrolno();
		$data['profileinfo'] = $this->terminate_voluntary_model->getprofileinfo($controlno);
		$data['branchcenter'] = $this->terminate_voluntary_model->getbranchcenter($controlno);
		$loan_info = $this->terminate_voluntary_model->getloaninfo($controlno);
			if (!empty($loan_info)) {
				$data['loaninfo'] = $loan_info;
				// $data['comaker'] = $this->terminate_voluntary_model->getcomaker();
				$data['comaker'] = $this->terminate_voluntary_model->getcomaker($controlno);
			}
		$data['capitalshare'] = $this->terminate_voluntary_model->getcapitalshare($controlno);
		$data['savings'] = $this->terminate_voluntary_model->getsavings($controlno);
		 $data['type'] ="voluntary";
		/*$controlno['name'] = $_POST['controlno'];*/
		$this->load->view('general/terminate_voluntary',$data);
	 }
	public function terminatenow(){
		$this->load->model('terminate_voluntary_model');
		$controlno = $this->terminate_voluntary_model->getcontrolno();
		$this->terminate_voluntary_model->setterminatestatus($controlno);
		$profile = $this->terminate_voluntary_model->getprofileinfo($controlno);
		$data['profile'] = $profile;
		foreach ($profile as $p) {
			$fname = $p->FirstName;
			$mname = $p->MiddleName;
			$lname = $p->LastName;
		}
			$name = $fname." ".$mname." ".$lname;

		$activity = "Withdraw the account of ".$name." (Withdraw Voluntarily)." ;
        $this->load->model("audittrail_model");
        $this->audittrail_model->setlog($activity);

        	echo "<script type='text/javascript'>alert('Successfully withdraw the account of ".$name."')</script>";
        	$this->load->view('general/termination_reason', $data);
        	/*$this->termination_report($controlno);*/
        	/*$this->directory();*/

	 }
	 public function termination_reason(){
            $this->load->model('terminate_voluntary_model');
            $controlno = $this->terminate_voluntary_model->getcontrolno();
            $this->terminate_voluntary_model->setterminationreason($controlno);

             echo "<script type='text/javascript'>alert('Reason for termination is now Recorded.')</script>";

             $this->termination_report($controlno);
        }
	 public function termination_report($controlno){

	 	$this->load->model('terminate_voluntary_model');
	 	$result['data'] = $this->terminate_voluntary_model->gettermination_report($controlno);
	 	$this->load->view('reports/termination_report', $result);

	 }
	public function payloanbalance(){
		$this->load->model('terminate_voluntary_model');

		$controlno = $this->terminate_voluntary_model->getcontrolno();
		$submittype = $_POST['paymenttype'];
		$loanbalance = $this->terminate_voluntary_model->getloanbalance();
		$savings = $this->terminate_voluntary_model->getsavings($controlno);

		if ($submittype =='Cash Payment') {
			$loantopay['controlno'] = $controlno;
			$loantopay['loanbalance'] = $loanbalance;
			$loantopay['paymenttype'] = $submittype;

			$this->load->view('general/payloanbalance', $loantopay);
		}else if ($submittype =='Savings') {
			/*echo "you click savings";*/
			$this->load->model('recordcollection_model');

			$loantopay['controlno'] = $controlno;
			$loantopay['loanbalance'] = $loanbalance;
			$loantopay['paymenttype'] = $submittype;
			$loantopay['savings'] = $savings;
			foreach ($savings as $save) {
				$sav = $save->Savings;
			}
			$datetoday = $this->terminate_voluntary_model->getdatetoday();
			$sopersonnel = $this->terminate_voluntary_model->getsopersonnel();

			$loaninfo = $this->terminate_voluntary_model->getloaninfo($controlno);

				foreach ($loaninfo as $loan) {
					$AmountRequested = $loan->AmountRequested;
					$Interest = $loan->Interest;
					$Dateapplied = $loan->DateApplied;
					$dayofweek = $loan->DayoftheWeek;
					$status = $loan->Status;
					$LoanType = $loan->LoanType;
					$loanappcontrol = $loan->LoanControl;
				}

				$activerelease = $AmountRequested+$Interest;
					if ($LoanType =="23-Weeks") {
						$amounttopay = $activerelease/23;
					}else if ($LoanType =="40-Weeks") {
						$amounttopay = $activerelease/40;
					}

				$savingspayment = 0;
				
				if ($loanbalance<=$sav) {
					$withdrawals = $loanbalance;
				}elseif ($loanbalance > $sav) {
					$withdrawals = $sav;
				}else{
					$withdrawals = 0;
				}

				$paymentrecieved = $withdrawals;
				
				if (!$paymentrecieved == 0) {
				$this->recordcollection_model->insertwithdrawaltransaction($loanappcontrol, $withdrawals, $datetoday, $controlno, $sopersonnel);

				$this->recordcollection_model->insertloantransaction($loanappcontrol, $paymentrecieved, $datetoday, $controlno, $sopersonnel);

				$this->recordcollection_model->updatemembertransaction($loanappcontrol, $controlno, $paymentrecieved, $savingspayment, $amounttopay, $withdrawals);

				$name = $this->recordcollection_model->getmembername($controlno);

					$activity = "Recorded loan collection to ".$name." account amounted to ".$paymentrecieved.".";
			        $this->load->model("audittrail_model");
			        $this->audittrail_model->setlog($activity);
				}

			$this->load->view('general/payloanbalance', $loantopay);
		}
	 }
	public function payloanbalance_2(){
		$this->load->model('terminate_voluntary_model');
		$this->load->model('recordcollection_model');

		$controlno = $this->terminate_voluntary_model->getcontrolno();
		$loanbalance = $this->terminate_voluntary_model->getloanbalance();
		$paymentrecieved = $this->terminate_voluntary_model->getpaymentrecieved();
		$datetoday = $this->terminate_voluntary_model->getdatetoday();
		$sopersonnel = $this->terminate_voluntary_model->getsopersonnel();
		$loaninfo = $this->terminate_voluntary_model->getloaninfo($controlno);
		$savings = $this->terminate_voluntary_model->getsavingsfromform();

		foreach ($loaninfo as $loan) {
			$AmountRequested = $loan->AmountRequested;
			$Interest = $loan->Interest;
			$Dateapplied = $loan->DateApplied;
			$dayofweek = $loan->DayoftheWeek;
			$status = $loan->Status;
			$LoanType = $loan->LoanType;
			$loanappcontrol = $loan->LoanControl;
		}

		$activerelease = $AmountRequested+$Interest;
		if ($LoanType =="23-Weeks") {
			$amounttopay = $activerelease/23;
		}else if ($LoanType =="40-Weeks") {
			$amounttopay = $activerelease/40;
		}

		$savingspayment = 0;
		$withdrawals = 0;

		$name = $this->recordcollection_model->getmembername($controlno);


		$this->recordcollection_model->insertloantransaction($loanappcontrol, $paymentrecieved, $datetoday, $controlno, $sopersonnel);

		$this->recordcollection_model->updatemembertransaction($loanappcontrol, $controlno, $paymentrecieved, $savingspayment, $amounttopay, $withdrawals); 


		$activity = "Recorded loan collection to ".$name." account amounted to ".$paymentrecieved.".";
        $this->load->model("audittrail_model");
        $this->audittrail_model->setlog($activity);
       
       /* echo "payment recieved: ".$paymentrecieved;
        echo "<br>";
        echo "loan balance: ".$loanbalance;
        echo "<br>";
        echo "savings:".$savings; */


		if ($paymentrecieved < $loanbalance-$savings) {
			echo "<script type='text/javascript'>alert('Account Termination Failed! Please settle the remaining loan balance before terminating the account.')</script>";

			echo "<script type='text/javascript'>window.location.href='profiles?name='+".$controlno."</script>";
			
		}else if ($paymentrecieved == $loanbalance-$savings) {
			$this->terminate_voluntary_model->setterminatestatus($controlno);
			$profile = $this->terminate_voluntary_model->getprofileinfo($controlno);
			$data['profile'] = $profile;
				foreach ($profile as $p) {
					$fname = $p->FirstName;
					$mname = $p->MiddleName;
					$lname = $p->LastName;
				}
			$name = $fname." ".$mname." ".$lname;

		$activity = "Withdraw the account of ".$name." (Voluntarily)." ;
        $this->load->model("audittrail_model");
        $this->audittrail_model->setlog($activity);

        	echo "<script type='text/javascript'>alert('Successfully withdraw the account of ".$name."')</script>";
        	$this->load->view('general/termination_reason', $data);
        	/*$this->termination_report($controlno);*/

			/*$this->load->view('general/successtermination');*/
			/*echo "<script type='text/javascript'>alert('Loan Fully Paid. Account terminated successfully.')</script>";*/
			/*$this->directory();*/
		}
	 }
	public function accountstable(){
		$this->load->view('salveofficer/homepagetable');
	}
	public function targettable(){
		$this->load->view('salveofficer/homepagetable2');
	}

	


}

?>