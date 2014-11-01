<?php if ( !  defined('BASEPATH')) exit('No direct script access allowed');

class Mis extends CI_Controller {


	public function index(){

		}

public function listofbranches(){
		$this->load->view("header");
		$this->load->view("navigation");
		$this->load->view("mis/listofbranches");
		$this->load->view("footer");
	
	
		}
public function addnewofficer(){
		$this->load->view('header');
        $this->load->view('navigation');
		$this->load->view("mis/addnewofficer");
		 $this->load->view('footer');
		}
//for navigation
	public function newbranch(){

		$this->load->view("header");
		$this->load->view("navigation");
		$this->load->view("mis/newbranch");
		$this->load->view("footer");
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


public function addnewofficerprocess(){
			//load model
			$this->load->model('addnewofficer_model');

			$result['user'] = $this->addnewofficer_model->get_officerdetails();

			if(!empty($result)){
		
			$message = "Officer is successfully added.";

			echo "<script type='text/javascript'>alert('$message');</script>";
		$activity = "Added new ".$result['user']['position'] ." named ".$result['user']['Name'].".";
        $this->load->model("audittrail_model");
        $this->audittrail_model->setlog($activity);

			$this->load->view('mis/newuserreport', $result);

			/*$this->load->view('header');
	        $this->load->view('navigation');
			$this->load->view('salveofficer/homepage'); 
	        $this->load->view('footer');
			*/
				}else{
				$message = "No User added.";

			echo "<script type='text/javascript'>alert('$message');</script>";
			$this->load->view('header');
	        $this->load->view('navigation');
			$this->load->view('mis/addnewofficer'); 
	        $this->load->view('footer');
					
				}
		}

		//this is th function being called by the view form action=""
		public function addbranch(){
			//load model
			$this->load->model('addbranch_model');

			$result = $this->addbranch_model->get_branchdetails();

			if($result['result'] == true){
		
			$message = $result['branchname'] ." Branch is successfully added.";

		$activity = "Added new branch (".$result['branchname'] .").";
        $this->load->model("audittrail_model");
        $this->audittrail_model->setlog($activity);

			echo "<script type='text/javascript'>alert('$message');</script>";


			$this->load->view('header');
	        $this->load->view('navigation');
			$this->load->view('salveofficer/homepage'); 
	        $this->load->view('footer');
			
				}
			
		
		
		}
		
		public function updatebranch(){
		$this->load->view("header");
		$this->load->view("navigation");
		$this->load->view("mis/editbranch");
		$this->load->view("footer");

	}


	public function editbranch(){
		
	$this->load->model('editbranchdetails_model');
    $result = $this->editbranchdetails_model->setdetails();

       if ($result['result']==true ) {

       	$activity = "Updated ".$result['branchname']." Branch.";
        $this->load->model("audittrail_model");
        $this->audittrail_model->setlog($activity);

           echo "<script type='text/javascript'>alert('Successfully Updated!')</script>";
       }else{
            echo "<script type='text/javascript'>alert('Failed to Update!')</script>";
       }

        $this->load->view('header');
        $this->load->view('navigation');
        $this->load->view('salveofficer/homepage'); 
        $this->load->view('footer');
       
    }

	public function updateuser(){
		$this->load->view("header");
		$this->load->view("navigation");
		$this->load->view("mis/edituser");
		$this->load->view("footer");

	}
		public function userprofile(){
		$this->load->view("header");
		$this->load->view("navigation");
		$this->load->view("mis/userprofile");
		$this->load->view("footer");

	}

public function listofusers(){
		$this->load->view("header");
		$this->load->view("navigation");
		$this->load->view("mis/listofusers");
		$this->load->view("footer");
	
	
		}

public function edituser(){

	 $this->load->model('edituserdetails_model');
	$submit = $_POST['subs'];


	if ($submit == "Save") {
		$result = $this->edituserdetails_model->changeposition();
		
		$activity = "Updated the position of ".$result['name']." to ".$result['position'] .".";
        $this->load->model("audittrail_model");
        $this->audittrail_model->setlog($activity);

		echo "<script type='text/javascript'>alert('Successfully Updated the Position!')</script>";
	}elseif ($submit == "Disable") {
		$result = $this->edituserdetails_model->disableuser();

		$activity = "Disabled the account of ".$result['name'].".";
        $this->load->model("audittrail_model");
        $this->audittrail_model->setlog($activity);

		echo "<script type='text/javascript'>alert('Successfully Disabled Profile!')</script>";
	}elseif ($submit == "Enable") {
		$result = $this->edituserdetails_model->enableuser();

		$activity = "Enabled the account of ".$result['name'].".";
        $this->load->model("audittrail_model");
        $this->audittrail_model->setlog($activity);

		echo "<script type='text/javascript'>alert('Successfully Enabled Profile!')</script>";
	}else{
		echo "<script type='text/javascript'>alert('Failed to update profile!')</script>";
	}

        $this->load->view('header');
        $this->load->view('navigation');
        $this->load->view('mis/listofusers'); 
        $this->load->view('footer');

/*        $this->load->model('edituserdetails_model');
       $result = $this->edituserdetails_model->setdetails();

       if ($result) {
           echo "<script type='text/javascript'>alert('Successfully Updated Profile!')</script>";
       }else{
            echo "<script type='text/javascript'>alert('Failed to update profile!')</script>";
       }

*/       
    }

    public function resetpassword(){
    	/*echo "my friend";*/
    	$this->load->model('edituserdetails_model');

    	$result['user'] = $this->edituserdetails_model->resetpassword();

    	$activity = "Reset password of ".$result['user']['Name']." .";
        $this->load->model("audittrail_model");
        $this->audittrail_model->setlog($activity);
    	
    	$this->load->view('mis/newuserreport', $result);


    }





}
?>