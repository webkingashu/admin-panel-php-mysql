<?php

	session_start();
	
	require_once preg_replace('#admin[\\\/]+include#i', '', dirname(__FILE__)) . 'config.php';
	
	define('ADMIN_URL', BASE_URL . 'admin/');
	define('ADMIN_DIR', BASE_DIR . 'admin/');
	
	require_once ADMIN_DIR . 'include/functions.php';
	
	/**
	 * Autoload
	 */
	function __autoload($class) {
		$file = ADMIN_DIR . 'include/class/' . strtolower($class) . '.class.php';
		if (file_exists($file)) {
			require_once $file;
			return true;
		}
		die('Class "' . $class . '" not found!<br />' . $file);
	}
	
	if (defined('DEBUG_CODE') && DEBUG_CODE == 1) {
		error_reporting(E_ALL);
		DB::showError(DEBUG_CODE);
	} else {	
		error_reporting(0);
	}
	
	$config = new Config;
	$config->set('db', DB::getInstance());
	$config->set('tpl', new Template);
	
	/**
	 * Settings
	 */
	
	$config->get('tpl')->adminURL = ADMIN_URL;
	$config->get('tpl')->baseURL  = BASE_URL;
	
	/**
	 * Messages
	 */
	$config->get('tpl')->message_text  = session('message_text');
	$config->get('tpl')->message_type  = session('message_type');
	$config->get('tpl')->message_width = session('message_width');
	unset(
		$_SESSION['message_text'], 
		$_SESSION['message_type'], 
		$_SESSION['message_width']
	);
	
	
	