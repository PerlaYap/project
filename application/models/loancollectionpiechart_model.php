<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Loancollectionpiechart_model extends CI_Model{

	public function getcontrolno(){
		$controlno = $_GET['name'];

		return $controlno;
	}

}

?>