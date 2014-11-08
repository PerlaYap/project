<?php if ( !  defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

    public function index(){
		$this->login_1();
	   }

	public function login_1(){
		//loading login page in the view

			$this->load->view('login');
		}
    public function logout(){
        $activity = "Log out";
        $this->load->model("audittrail_model");
        $this->audittrail_model->setlog($activity);
        /*kill session*/
        $this->session->sess_destroy();
        redirect('/','refresh');
    }
	public function homepage(){

		//loading salveofficer homepage in the view
        $this->load->view('header');
        $this->load->view('navigation');
		$this->load->view('salveofficer/homepage'); 
        $this->load->view('footer');
     }
     public function editpassword(){
        $this->load->view('header');
        $this->load->view('navigation');
        $this->load->view('general/usereditpassword'); 
        $this->load->view('footer');
     }
    public function editpasswordcheck(){
        $this->load->model('editpassword_model');
        $message = $this->editpassword_model->editpwd();

        if ($message == "PS") {

            $activity = "Changed password.";
            $this->load->model("audittrail_model");
            $this->audittrail_model->setlog($activity);

            echo "<script type='text/javascript'>alert('Successfully Changed Password.')</script>";
              $this->homepage();           

        }else if ($message =="WCoP") {
            echo "<script type='text/javascript'>alert('Confirm password did not match new password.')</script>";
                $this->load->view('header');
                $this->load->view('navigation');
                $this->load->view('general/usereditpassword'); 
                $this->load->view('footer');
                
        }else if ($message == "WCuP") {
            echo "<script type='text/javascript'>alert('Wrong current password.')</script>";
                $this->load->view('header');
                $this->load->view('navigation');
                $this->load->view('general/usereditpassword'); 
                $this->load->view('footer');
        }else if ($message == "WCuN") {
            echo "<script type='text/javascript'>alert('New Password cannot be the same as the current password.')</script>";
                $this->load->view('header');
                $this->load->view('navigation');
                $this->load->view('general/usereditpassword'); 
                $this->load->view('footer');
        }

     }
	public function process(){

		//load the session library
		$this->load->library('session');

		//load model
		$this->load->model('login_model');

		// Validate the user can login
        $result = $this->login_model->validate();

        if (empty($result)) {
            echo "<script type='text/javascript'>alert('Access Denied! Kindly check your accessibility and account username and password.')</script>";
        	
        	 redirect('/','refresh');
        	
        }else{

        	$newdata = array(

        				'username' => $result['Username'],
        				'firstname'=> $result['FirstName']." ".$result['LastName'],
        				'branchno' =>$result['branchno'],
        				'rank'=>$result['Rank'],
                        'branch' => $result['BranchName'],
                        'personnelno'=> $result['personnelno'],
        				'logged_in' => TRUE
        		);

        	$this->session->set_userdata($newdata);
            
            $activity = "Log in";
            $this->load->model("audittrail_model");
            $this->audittrail_model->setlog($activity);

         
            header("Location: homepage");
        	/*if($result['Rank']=="salveofficer"){
        		header("Location: salvehomepage");
        	} elseif ($result['Rank']=='branchmanager') {
                header('Location: bmhomepage');
            }
            else{
        		echo "not a salve officer";
        	}*/
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
     
        public function terminate(){
        $this->load->model('terminate_voluntary_model');
        $controlno = $_GET['name'];
        $data['profileinfo'] = $this->terminate_voluntary_model->getprofileinfo($controlno);
        $data['branchcenter'] = $this->terminate_voluntary_model->getbranchcenter($controlno);
        $this->terminate_voluntary_model->getloancontrolno($controlno);
        $loan_info = $this->terminate_voluntary_model->getloaninfo($controlno);
            if (!empty($loan_info)) {
                $data['loaninfo'] = $loan_info;
                $data['comaker'] = $this->terminate_voluntary_model->getcomaker($controlno);
            }
        $data['capitalshare'] = $this->terminate_voluntary_model->getcapitalshare($controlno);
        $data['savings'] = $this->terminate_voluntary_model->getsavings($controlno);
        $data['type'] ="force";
        /*$controlno['name'] = $_POST['controlno'];*/
        $this->load->view('general/terminate_voluntary',$data);
     }

     public function terminatenow(){
        $this->load->model('terminate_voluntary_model');
        $controlno = $this->terminate_voluntary_model->getcontrolno();
        $this->terminate_voluntary_model->setterminatestatus($controlno);
        $profile = $this->terminate_voluntary_model->getprofileinfo($controlno);
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
            $this->termination_report($controlno);
            /*$this->directory();*/

               }
        public function termination_report($controlno){

        $this->load->model('terminate_voluntary_model');
        $result['data'] = $this->terminate_voluntary_model->gettermination_report($controlno);
        $this->load->view('reports/termination_report', $result);

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
    
    public function pastduemember(){
        $this->load->view("salveofficer/pastduemember");
        
    }
}
?>