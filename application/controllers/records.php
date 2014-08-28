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
	}

?>