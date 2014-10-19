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


	/*public function addnewmember(){
		$this->load->view('header');
        $this->load->view('navigation');
		$this->load->view("Salveofficer/addnewmember");
		$this->load->view('footer');
		}
*/
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

			if ($result == 1) { 

			$this->load->view('header');
	        $this->load->view('navigation');
			$this->load->view('salveofficer/homepage'); 
	        $this->load->view('footer');
			
				}
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
		$data['profileinfo'] = $this->terminate_voluntary_model->getprofileinfo();
		$data['branchcenter'] = $this->terminate_voluntary_model->getbranchcenter();
		$loan_info = $this->terminate_voluntary_model->getloaninfo();
			if (!empty($loan_info)) {
				$data['loaninfo'] = $loan_info;
			}
		/*$controlno['name'] = $_POST['controlno'];*/
		$this->load->view('general/terminate_voluntary',$data);
	}


}

?>