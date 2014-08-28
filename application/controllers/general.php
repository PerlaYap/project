<?php if ( !  defined('BASEPATH')) exit('No direct script access allowed');

class General extends CI_Controller {

	
	
	
	
	/*public function membersbybranch(){
	
	
		$this->load->view("general/membersbybranch");
	}
	public function membersbycenter(){
		$this->load->view("general/membersbycenter");
	}*/

	public function members(){
		$this->load->view("header");
		$this->load->view("navigation");
		$this->load->view("general/members");
		$this->load->view("footer");
		}
    public function loancollectionpiechart(){
        

        $this->load->view("general/loancollectionpiechart");
    }

      public function loanperformance(){
        $this->load->view("general/loanperformance");
    }

    public function savingsperformance(){
        $this->load->view("general/savingsperformance");
    }

/*	public function profiles(){
		
		$this->load->view('header');
        $this->load->view('navigation');
		$this->load->view("general/profile");
		$this->load->view("footer");
		}*/


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
}

?>