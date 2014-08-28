<?php if ( !  defined('BASEPATH')) exit('No direct script access allowed');

class Dailycollection extends CI_Controller{

	public function collection(){

		$this->load->view('header');
    $this->load->view('navigation');
		$this->load->view("salveofficer/dailycollection");
    $this->load->view('footer');
	}

  public function recordcollection(){
    $this->load->model('recordcollection_model');
   $result = $this->recordcollection_model->getcollection();

   if ($result) {
    
    $this->homepages();
   }
  }
  public function addsavingorwithdrawal(){
    $this->load->model('recordcollection_model');
    $result = $this->recordcollection_model->getindividualcollection();

    if ($result) {
      $this->homepages();
    }
  }

  public function individualloanpay(){
    $this->load->model('recordcollection_model');
    $result = $this->recordcollection_model->getindividualloanpayment();
    if ($result==true) {
       echo "<script type='text/javascript'>alert('Successfully Added transaction!')</script>";
       $this->homepages();
    }else{
      echo "<script type='text/javascript'>alert('Transaction Failed!')</script>";
    }
  }


  public function homepages(){
    $this->load->view('header');
    $this->load->view('navigation');
    $this->load->view("salveofficer/homepage");
    $this->load->view('footer');
  }

	public function dcsummary(){

		$this->load->view('header');
    $this->load->view('navigation');
		$this->load->view("reports/dcsummary");
    $this->load->view('footer');
	}
  public function editcollection(){
    $this->load->view('header');
    $this->load->view('navigation');
    $this->load->view("salveofficer/editcollection");
    $this->load->view('footer');
  }
  public function edittransaction(){
    $this->load->model('editcollection_model');
    $result = $this->editcollection_model->gettransaction();

    if ($result) {
           echo "<script type='text/javascript'>alert('Successfully Changed Transaction!')</script>";
       }else{
            echo "<script type='text/javascript'>alert('Failed to Change Transaction!')</script>";
       }

        $this->load->view('header');
        $this->load->view('navigation');
        $this->load->view('salveofficer/homepage'); 
        $this->load->view('footer');
  }
    public function individualcollection(){
    $this->load->view('header');
    $this->load->view('navigation');
    $this->load->view("salveofficer/individualcollection");
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