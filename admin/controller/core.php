<?php

class coreController extends Controller {

	public function index() {
		if (!empty(Router::$params[0])) {
			
			$settings = Admin_Core_Settings::getPageSettings(Router::$params[0]);
			$core = new Admin_Core($this->config, $settings);
		}
	}
	
	public function coreSettings() {
		$core = new Admin_Core_Settings($this->config);
	}
}