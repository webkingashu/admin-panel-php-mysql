<?php

class Template {
	
	protected $_engineInstance;
	protected $_vars = array();
	
	public function __construct() {
		require_once(ADMIN_DIR . 'include/smarty/Smarty.class.php');
		
		$this->_engineInstance = new Smarty();

		$this->_engineInstance->template_dir = ADMIN_DIR . 'template/';
		$this->_engineInstance->compile_dir  = ADMIN_DIR . 'template/compiled/';
		$this->_engineInstance->config_dir   = ADMIN_DIR . 'include/smarty/';
		$this->_engineInstance->cache_dir    = ADMIN_DIR . 'cache/';
		
	}
	
	public function __set($index, $value) {
		$this->_vars[$index] = $value;
		$this->_engineInstance->assign($index, $value); 
	}
	
	public function __get($index) {
		return isset($this->_vars[$index]) ? $this->_vars[$index] : null;
	}
	
	public function display($tpl) {
		$this->_engineInstance->display($tpl);
	}
	
	public function fetch($tpl) {
		return $this->_engineInstance->fetch($tpl);
	}
	
	public function setDebug($value = true) {
		$this->_engineInstance->debugging = true;
	}
	
	public function getEngineInstance() {
		return $this->_engineInstance;
	}
}