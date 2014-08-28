<?php

class Math extends CI_Model{

	public function add($one,$two){
		return $one + $two;
	}

	public function subtract($var1, $var2){
		return $var1 - $var2;
	}
}

?>