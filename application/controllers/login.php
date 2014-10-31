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
            echo "<script type='text/javascript'>alert('Successfully Changed Password.')</script>";
                $this->load->view('header');
                $this->load->view('navigation');
                $this->load->view('salveofficer/homepage'); 
                $this->load->view('footer');            

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

      
        $this->load->view("general/terminate");
      
       
        }

        public function forceterminate(){
     

      $this->load->model('terminate_model');
      $result = $this->terminate_model->getdetails();

       if ($result) {
           echo "<script type='text/javascript'>alert('Successfully Terminated!')</script>";
       }else{
            echo "<script type='text/javascript'>alert('Failed to terminate!')</script>";
       }

        $this->load->view('header');
        $this->load->view('navigation');
        $this->load->view('salveofficer/homepage'); 
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
    
    public function pastduemember(){
        $this->load->view("salveofficer/pastduemember");
        
    }
}
?>