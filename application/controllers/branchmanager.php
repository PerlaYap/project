<!-- haleluya!!!! -->
<?php if ( !  defined('BASEPATH')) exit('No direct script access allowed');

class Branchmanager extends CI_Controller{
	
	public function listofcenters(){
		$this->load->view("header");
		$this->load->view("navigation");
		$this->load->view("branchmanager/listofcenters");
		$this->load->view("footer");
		}
	
	public function sample(){
		$this->load->view("header");
		$this->load->view("navigation");
		$this->load->view("branchmanager/sample");
		$this->load->view("footer");
		}
	
	
	public function approvallist(){
		
		$this->load->view('header');
        $this->load->view('navigation');
		$this->load->view("branchmanager/pendingmember");
        $this->load->view('footer');
		
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

       if ($result['result']== true) {

       			$activity = "Updated the profile of ".$result['name'] ." .";
		        $this->load->model("audittrail_model");
		        $this->audittrail_model->setlog($activity);

           echo "<script type='text/javascript'>alert('Successfully Updated Profile!')</script>";
       }else{
            echo "<script type='text/javascript'>alert('Failed to update profile!')</script>";
       }

        $this->load->view('header');
        $this->load->view('navigation');
        $this->load->view('salveofficer/homepage'); 
        $this->load->view('footer');
       
    	}
	public function forapprovals(){

		$this->load->view('header');
        $this->load->view('navigation');
		$this->load->view("branchmanager/forapproval");
        $this->load->view('footer');
		
		}
		
	public function newcenter(){
		$this->load->view('header');
        $this->load->view('navigation');
		$this->load->view("branchmanager/newcenter");
        $this->load->view('footer');
		}
	public function addcenter(){
			//load model
			$this->load->model('addcenter_model');

			$result = $this->addcenter_model->get_centerdetails();

			if($result['result'] == 'True'){

				$activity = "Added new center (Center No: ".$result['CenterNo'] .") .";
		        $this->load->model("audittrail_model");
		        $this->audittrail_model->setlog($activity);
		
			$message = "Center has successfully been added.";

			echo "<script type='text/javascript'>alert('$message');</script>";


			$this->load->view('header');
	        $this->load->view('navigation');
			$this->load->view('salveofficer/homepage'); 
	        $this->load->view('footer');
			
				}
			}
			
	public function updatecenter(){
		$this->load->view('header');
        $this->load->view('navigation');
		$this->load->view("branchmanager/editcenter");
        $this->load->view('footer');
		}
	public function editcenter(){
			
			
			//load model
			$this->load->model('editcenterdetails_model');

			$result = $this->editcenterdetails_model->setdetails();

			if($result['result'] == true){
			
			$activity = "Updated center ".$result['centerno'].".";
	        $this->load->model("audittrail_model");
	        $this->audittrail_model->setlog($activity);

			$message = "Center has successfully been updated.";

			echo "<script type='text/javascript'>alert('$message');</script>";


			$this->load->view('header');
	        $this->load->view('navigation');
			$this->load->view('salveofficer/homepage'); 
	        $this->load->view('footer');
			
				}
			}
	public function approvemember(){

		//add member's id

		$this->load->model("approvemember_model");

		$result =$this->approvemember_model->approve();

		if($result['result'] == 'True'){

		$activity = "Approved membership application of ".$result['name'];
        $this->load->model("audittrail_model");
        $this->audittrail_model->setlog($activity);

		//alert for successfully approved and back to homepage
		$message = "Successfully Approved Application.";

		echo "<script type='text/javascript'>alert('$message');</script>";
		}

		
		$cn =$this->approvemember_model->getcontrolno();

		$controlno['number'] = $cn;

		$this->load->view("branchmanager/memberid", $controlno);

		/*$this->load->model("approvemember_model");
		
		
		*/

		}

	public function addmemberid(){
		$this->load->model("approvemember_model");
		$result = $this->approvemember_model->addmemberid();

		if($result == 'True'){
		//alert for successfully approved and back to homepage
		$message = "Successfully Added Member's ID.";

		echo "<script type='text/javascript'>alert('$message');</script>";
		 }else{
			$message = "Failed to add member's ID.";
			echo "<script type='text/javascript'>alert('$message');</script>";
		}

		$this->load->view('header');
        $this->load->view('navigation');
		$this->load->view('salveofficer/homepage'); 
        $this->load->view('footer');
	}	
	public function rejectedaccounts(){
		$this->load->view("header");
		$this->load->view("navigation");
		$this->load->view("branchmanager/rejectedmembers");
		$this->load->view("footer");
		}

	public function reasonforreject(){
		$this->load->model("rejectmember_model");
		$data['controlno'] = $this->rejectmember_model->getcontrolno();

		$this->load->view("header");
		$this->load->view("navigation");
		$this->load->view("branchmanager/reasonforreject", $data);
		$this->load->view("footer");
		}

	public function rejectmember(){

		$this->load->model("rejectmember_model");
		$result= $this->rejectmember_model->reject();

		if($result['result'] =='True'){

			$activity = "Disapproved the membership application of  ".$result['name']." .";
	        $this->load->model("audittrail_model");
	        $this->audittrail_model->setlog($activity);
			$message = "Successfully Rejected Application.";

			echo "<script type='text/javascript'>alert('$message');</script>";

			$this->load->view('header');
	        $this->load->view('navigation');
			$this->load->view('salveofficer/homepage'); 
	        $this->load->view('footer');
			
			}
		}

	}
?>