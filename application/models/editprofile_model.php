<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Editprofile_model extends CI_Model{


	function _construct(){

		parent::_construct();
	}


	public function getcontrolno(){
		
		return $controlnum = $this->security->xss_clean($this->input->post('controlno'));
	}
}
?>