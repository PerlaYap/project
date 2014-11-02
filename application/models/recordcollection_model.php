<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Recordcollection_model extends CI_Model{


	function _construct(){

		parent::_construct();
	}

	public function getcollection(){

		/*echo "welcome to get collection"."<br>";*/
		

		$sopersonnel = $this->security->xss_clean($this->input->post('sopersonnel'));
		$memberid = $this->security->xss_clean($this->input->post('memberid'));
		$branchno = $this->security->xss_clean($this->input->post('branchcontrolno'));
		$centerno = $this->security->xss_clean($this->input->post('centercontrolno'));
		$datesubmitted = $this->security->xss_clean($this->input->post('date'));

		$loanpayment = $this->security->xss_clean($this->input->post('loanpayment'));
		$sbupayment = $this->security->xss_clean($this->input->post('sbu'));
		$withdrawal = $this->security->xss_clean($this->input->post('withdrawal'));
		$amounttopay =$this->security->xss_clean($this->input->post('amounttopay'));
		$loanappcontrolno = $this->security->xss_clean($this->input->post('loanappcontrolno'));

		/*SAVINGS ACCOUNT ONLY*/
		$memberno2 = $this->security->xss_clean($this->input->post('memberno2'));
		$savingamount = $this->security->xss_clean($this->input->post('saveonly'));
		$withdrawalamount = $this->security->xss_clean($this->input->post('withdrawonly'));

		
		$savesize = count($memberno2);
	 	$size = count($memberid);
		if (!empty($memberid)) {
			for ($i=0; $i < $size ; $i++) { 
				/*echo "member".$i.":".$memberid[$i]."<br>";
				echo "loan payment".$i.":".$loanpayment[$i]."<br>";
				echo "SBU payment".$i.":".$sbupayment[$i]."<br>";
				echo "Withdrawal".$i.":".$withdrawal[$i]."<br>";
				echo "Amounttopay".$i.":".$amounttopay[$i]."<br>";
				echo "LoanAppcontrolno".$i.":".$loanappcontrolno[$i]."<br>";
				echo "<br><br>"; */
				if ($loanpayment[$i]>0) {
					$this->insertloantransaction($loanappcontrolno[$i], $loanpayment[$i], $datesubmitted, $memberid[$i] , $sopersonnel);	
				}else{
					$this->insertpastduetransaction($loanappcontrolno[$i], $amounttopay[$i], $datesubmitted, $memberid[$i] , $sopersonnel);
				}
				if ($withdrawal[$i]>0) {
					$this->insertwithdrawaltransaction($loanappcontrolno[$i], $withdrawal[$i], $datesubmitted, $memberid[$i] , $sopersonnel);
				}

				$this->insertsavingstransaction($loanappcontrolno[$i], $sbupayment[$i], $datesubmitted, $memberid[$i] , $sopersonnel);
				
				$this->updatemembertransaction($loanappcontrolno[$i], $memberid[$i], $loanpayment[$i], $sbupayment[$i], $amounttopay[$i],$withdrawal[$i] );

				/*$this->updateloadpayment($loanappcontrolno[$i], $memberid[$i], $loanpayment[$i],$amounttopay[$i] );*/

				

				}
		}

		if (!empty($memberno2)) {
			$loanappcontrolno2 = NULL;
			$loanpayment2 = 0;
			$amounttopay2 = 0;
			for ($n=0; $n < $savesize; $n++) { 
				/*echo "Memberno2: ".$memberno2[$n]."<br>";
				echo "Savings: ".$savingamount[$n]."<br>";
				echo "Withdrawal: ".$withdrawalamount[$n]."<br><br>";*/
				if ($withdrawalamount[$n]>0) {
					$this->insertwithdrawaltransaction($loanappcontrolno2, $withdrawalamount[$n], $datesubmitted, $memberno2[$n] , $sopersonnel);
				}

				$this->insertsavingstransaction($loanappcontrolno2, $savingamount[$n], $datesubmitted, $memberno2[$n] , $sopersonnel);
				
				$this->updatemembertransaction($loanappcontrolno2, $memberno2[$n], $loanpayment2, $savingamount[$n], $amounttopay2,$withdrawalamount[$n] );

			}
		}

		$data['result']=true;
		$data['center']= $centerno;
		return $data;
	}
	public function getindividualcollection(){
		$memberno2 = $this->security->xss_clean($this->input->post('memberid'));
		$savingamount = $this->security->xss_clean($this->input->post('sbu'));
		$withdrawalamount = $this->security->xss_clean($this->input->post('withdrawal'));
		$datesubmitted = $this->security->xss_clean($this->input->post('date'));
		$savesize = count($memberno2);
		$sopersonnel = $this->security->xss_clean($this->input->post('sopersonnel'));
		if (!empty($memberno2)) {
			$loanappcontrolno2 = NULL;
			$loanpayment2 = 0;
			$amounttopay2 = 0;
			
				/*echo "Memberno2: ".$memberno2[$n]."<br>";
				echo "Savings: ".$savingamount[$n]."<br>";
				echo "Withdrawal: ".$withdrawalamount[$n]."<br><br>";*/
				if ($withdrawalamount > 0) {
					$this->insertwithdrawaltransaction($loanappcontrolno2, $withdrawalamount, $datesubmitted, $memberno2 , $sopersonnel);
				}
			/*	if ($savingamount > 0) {*/
					$this->insertsavingstransaction($loanappcontrolno2, $savingamount, $datesubmitted, $memberno2 , $sopersonnel);	
				/*}*/
				
				
				$this->updatemembertransaction($loanappcontrolno2, $memberno2, $loanpayment2, $savingamount, $amounttopay2,$withdrawalamount );

			$data['result'] = true;
			$data['saving'] = $savingamount;
			$data['withdrawal'] = $withdrawalamount;
			$data['membername'] = $this->getmembername($memberno2);
			
		}else{
			 $data['result'] = false;
		}
		return $data;
		
	}
	public function getindividualloanpayment(){
		$sopersonnel = $this->security->xss_clean($this->input->post('sopersonnel'));
		$memberid = $this->security->xss_clean($this->input->post('memberid'));
		$datesubmitted = $this->security->xss_clean($this->input->post('date'));
		$loanpayment = $this->security->xss_clean($this->input->post('loan'));
		$sbupayment = $this->security->xss_clean($this->input->post('sbu'));
		$withdrawal = $this->security->xss_clean($this->input->post('withdrawal'));
		$amounttopay =$this->security->xss_clean($this->input->post('amounttopay'));
		$loanappcontrolno = $this->security->xss_clean($this->input->post('loanappcontrolno'));

		/*echo $sopersonnel."<br>".$memberid."<br>".$datesubmitted."<br>".$loanpayment."<br>".$sbupayment."<br>".$withdrawal."<br>".$amounttopay."<br>".$loanappcontrolno;*/

		if (!empty($memberid)) {
				if ($loanpayment>0) {
					$this->insertloantransaction($loanappcontrolno, $loanpayment, $datesubmitted, $memberid , $sopersonnel);	
				}else{
					$this->insertpastduetransaction($loanappcontrolno, $amounttopay, $datesubmitted, $memberid , $sopersonnel);
				}
				if ($withdrawal>0) {
					$this->insertwithdrawaltransaction($loanappcontrolno, $withdrawal, $datesubmitted, $memberid , $sopersonnel);
				}

				$this->insertsavingstransaction($loanappcontrolno, $sbupayment, $datesubmitted, $memberid , $sopersonnel);
				
				$this->updatemembertransaction($loanappcontrolno, $memberid, $loanpayment, $sbupayment, $amounttopay,$withdrawal );

				$data['result'] = true;
				$data['saving'] = $sbupayment;
				$data['loanpayment'] = $loanpayment;
				$data['withdrawal'] = $withdrawal;
				$data['membername'] = $this->getmembername($memberid);
			
		}else{
			$data['result'] = false;
		}

		return $data;	
	}
	public function updateloadpayment($loanappcontrol, $memberid, $loanpayment,$amounttopay){

		$getpasttransaction = $this->db->query("SELECT `ControlNo`,`LoanExpense`,`Savings`,`pastdue` FROM `members` WHERE `ControlNo` =$memberid");

			foreach ($getpasttransaction->result() as $result) {
		
			$pastloanexpense = $result->LoanExpense;
			$currentloanexpense = $pastloanexpense - $loanpayment;
			

			

			/*update loan expense, savings and pastdue*/
			$this->db->query("UPDATE `microfinance2`.`members` SET `LoanExpense` = '$currentloanexpense' WHERE `members`.`ControlNo` = $memberid;");
		
			/*if payment is 0, update pastdue*/
				$pastpastdue = $result->pastdue;
			if ($loanpayment=='0') {
				
		
				$currentpastdue = $pastpastdue +$amounttopay;
				/*Update pastdue*/
				$this->db->query("UPDATE `microfinance2`.`members` SET `pastdue` = '$currentpastdue' WHERE `members`.`ControlNo` = $memberid;");
			}elseif ($loanpayment > $amounttopay) {
					
				$currentpastdue = $pastpastdue - $loanpayment + $amounttopay;		
				
				$this->db->query("UPDATE `microfinance2`.`members` SET `pastdue` = '$currentpastdue' WHERE `members`.`ControlNo` = $memberid;");
			}
			/*Change loan status if loan expense is zero*/
			if ($currentloanexpense == 0) {
				
				$this->db->query("UPDATE `microfinance2`.`loanapplication` SET `Status` = 'Full Payment' WHERE `loanapplication`.`ControlNo` = $loanappcontrol; ");
				$this->db->query("UPDATE `microfinance2`.`members` SET `pastdue` = '0' WHERE `members`.`ControlNo` = $memberid;");
			}


		}
	}
	public function insertloantransaction($loanappno, $loanpayment, $datetime, $member, $so){

		$this->db->query("INSERT INTO `microfinance2`.`transaction` ( `LoanAppControlNo`, `Amount`, `DateTime`, `Members_ControlNo`, `Passbook_ControlNo`, `CaritasPersonnel_ControlNo`, `TransactionType`) VALUES ('$loanappno', '$loanpayment', '$datetime', '$member', '2', '$so', 'Loan ');");
	}
	public function insertwithdrawaltransaction($loanappno, $withdraw, $datetime, $member, $so){

		$this->db->query("INSERT INTO `microfinance2`.`transaction` ( `LoanAppControlNo`,`Amount`, `DateTime`, `Members_ControlNo`, `Passbook_ControlNo`, `CaritasPersonnel_ControlNo`, `TransactionType`) VALUES ('$loanappno','$withdraw', '$datetime', '$member', '2', '$so', 'Withdrawal ');");
	}
	public function insertsavingstransaction($loanappno, $savings, $datetime, $member, $so){
		/*if ($savings>0) {*/

			$this->db->query("INSERT INTO `microfinance2`.`transaction` ( `LoanAppControlNo`,`Amount`, `DateTime`, `Members_ControlNo`, `Passbook_ControlNo`, `CaritasPersonnel_ControlNo`, `TransactionType`) VALUES ('$loanappno','$savings', '$datetime', '$member', '2', '$so', 'Savings');");
	/*	}	*/
	}
	public function insertpastduetransaction($loanappno, $pastdue, $datetime, $member, $so){

		$this->db->query("INSERT INTO `microfinance2`.`transaction` ( `LoanAppControlNo`,`Amount`, `DateTime`, `Members_ControlNo`, `Passbook_ControlNo`, `CaritasPersonnel_ControlNo`, `TransactionType`) VALUES ('$loanappno','$pastdue', '$datetime', '$member', '2', '$so', 'Past Due');");
	}
	public function updatemembertransaction($loanappcontrol, $memberid, $loanpayment, $savingspayment, $amounttopay, $withdrawals){
		/*update LoanExpense, Savings, pastdue*/
		
		/*get the existing loan expense, savings and pastdue*/

		$getpasttransaction = $this->db->query("SELECT `ControlNo`,`LoanExpense`,`Savings`,`pastdue` FROM `members` WHERE `ControlNo` = $memberid" );

		foreach ($getpasttransaction->result() as $result) {
		
			$pastloanexpense = $result->LoanExpense;
			$currentloanexpense = $pastloanexpense - $loanpayment;
			

			$pastsavings = $result->Savings;
			$currentsavings = $pastsavings + $savingspayment - $withdrawals;

			/*update loan expense, savings and pastdue*/
			$this->db->query("UPDATE `microfinance2`.`members` SET `LoanExpense` = '$currentloanexpense' WHERE `members`.`ControlNo` = $memberid;");
			$this->db->query("UPDATE `microfinance2`.`members` SET `Savings` = '$currentsavings' WHERE `members`.`ControlNo` = $memberid;");
			
			/*if payment is 0, update pastdue*/
			$pastpastdue = $result->pastdue;
			if ($loanpayment=='0') {
				
				
				$currentpastdue = $pastpastdue +$amounttopay;
				/*Update pastdue*/
				$this->db->query("UPDATE `microfinance2`.`members` SET `pastdue` = '$currentpastdue' WHERE `members`.`ControlNo` = $memberid;");
			}elseif ($loanpayment > $amounttopay) {
					
				$currentpastdue = $pastpastdue - $loanpayment + $amounttopay;
				if ($currentpastdue < 0) {
						$currentpastdue = 0;		
					}		
				
				$this->db->query("UPDATE `microfinance2`.`members` SET `pastdue` = '$currentpastdue' WHERE `members`.`ControlNo` = $memberid;");
			}
			/*Change loan status if loan expense is zero*/
			if ($currentloanexpense == 0 && $loanappcontrol>0) {
				
				$this->db->query("UPDATE `microfinance2`.`loanapplication` SET `Status` = 'Full Payment' WHERE `loanapplication`.`ControlNo` = $loanappcontrol; ");
				$this->db->query("UPDATE `microfinance2`.`members` SET `pastdue` = '0' WHERE `members`.`ControlNo` = $memberid;");
				$this->db->query("UPDATE `microfinance2`.`members_has_membersmembershipstatus` SET `Status` = 'Active Saver' WHERE `members_has_membersmembershipstatus`.`ControlNo` = $memberid");
			}


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