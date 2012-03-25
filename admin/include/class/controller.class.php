<?php

abstract class Controller {
	
	public $config;
	public $tlp;
	public $db;
	
	public function __construct(Config $config) {
		$this->config = $config;
		$this->tpl    = $config->get('tpl');
		$this->db     = $config->get('db');
		$this->init();
	}
	
	public function init() {
		if (!Auth::isLogged()) {
			location(ADMIN_URL . 'account/');
		}
		
		$this->tpl->corePages = Admin_Core_Settings::getVisibleTable();
		$adminDetails = Auth::getAdminDetails();
		$this->tpl->username = $adminDetails['username'];
	}
	
	public function display($tpl) {
		$this->tpl->display($tpl);
	}
	
	public function fetch($tpl) {
		$this->tpl->fetch($tpl);
	}
	
	abstract public function index();
}