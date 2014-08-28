<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class terminate_model extends CI_Model{


	function _construct(){

		parent::_construct();
	}

	public function getdetails(){


	    $control = $this->security->xss_clean($this->input->post('number'));


  		$this->updateTerminate($control);


return true;
    }

    public function updateTerminate($control) {
        $this->db->query("UPDATE `members_has_membersmembershipstatus` SET `Status` = 'Terminated', `DateUpdated` = now() WHERE `ControlNo` ='$control'");
    }
    
}
?>