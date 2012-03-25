<?php

class Config {

	protected $_vars = array();
	
	public function __construct() {}
	
	public function set($index, $value) {
		$this->_vars[$index] = $value;
	}
	
	public function get($index) {
		return isset($this->_vars[$index]) ? $this->_vars[$index] : null;
	}
}