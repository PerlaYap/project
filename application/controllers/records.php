<?php if ( !  defined('BASEPATH')) exit('No direct script access allowed');

class Records extends CI_Controller {

	public function recordlist(){

		$this->load->view('header');
        $this->load->view('navigation');
		$this->load->view("records/list");
		$this->load->view('footer');
	}
	public function terminate(){

		$this->load->view('header');
        $this->load->view('navigation');
		$this->load->view("records/terminated");
		$this->load->view('footer');
	}
	public function pdm(){

		$this->load->view('header');
        $this->load->view('navigation');
		$this->load->view("records/pdm");
		$this->load->view('footer');
	}
	public function borrower(){

		$this->load->view('header');
        $this->load->view('navigation');
		$this->load->view("records/borrower");
		$this->load->view('footer');
	}
	public function activesaver(){

		$this->load->view('header');
        $this->load->view('navigation');
		$this->load->view("records/activesaver");
		$this->load->view('footer');
	}
	public function dormantsaver(){

		$this->load->view('header');
        $this->load->view('navigation');
		$this->load->view("records/dormantsaver");
		$this->load->view('footer');
	}
	public function volunteer(){

		$this->load->view('header');
        $this->load->view('navigation');
		$this->load->view("records/volunteer");
		$this->load->view('footer');
	}
	public function profiles(){

        $this->load->view('header');
        $this->load->view('navigation');
        $this->load->view("general/profile");
        $this->load->view("footer");
       
        }	
    public function audittrail(){
		
		$this->load->model('audittrail_model');
		$data['logs'] = $this->audittrail_model->getlog();

        $this->load->view("records/audittrail",$data);
       
	}
	public function terminationreport(){
		 $control_no = $_GET['name'];
		$this->termination_report($control_no);
	}

	public function termination_report($controlno){

	 	$this->load->model('terminate_voluntary_model');
	 	$result['data'] = $this->terminate_voluntary_model->gettermination_report($controlno);
	 	$this->load->view('reports/termination_report', $result);

	 }

	}
	
?>