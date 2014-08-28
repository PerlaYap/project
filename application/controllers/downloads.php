<?php if ( !  defined('BASEPATH')) exit('No direct script access allowed');

class Downloads extends CI_Controller {

	public function downloadlist(){

		$this->load->view('header');
        $this->load->view('navigation');
		$this->load->view("downloads/list");
		$this->load->view('footer');

	}
	public function dailycollectionindividual(){
		$this->load->view('downloads/dailycollectionindividual');
	}

	}

?>