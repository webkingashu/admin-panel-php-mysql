<?php

	function get($index, $default = null) {
		return isset($_GET[$index]) ? $_GET[$index] : $default;
	}
	
	function post($index, $default = null) {
		return isset($_POST[$index]) ? $_POST[$index] : $default;
	}
	
	function request($index, $default = null) {
		return isset($_REQUEST[$index]) ? $_REQUEST[$index] : $default;
	}
	
	function session($index, $default = null) {
		return isset($_SESSION[$index]) ? $_SESSION[$index] : $default;
	}
	
	function cookie($index, $default = null) {
		return isset($_COOKIE[$index]) ? $_COOKIE[$index] : $default;
	}
	
	function filter($table, $field) {
		return isset($_SESSION['filter'][$table][$field]) ? $_SESSION['filter'][$table][$field] : null;
	}
	
	function isEmail($str) {
		return preg_match('/^[a-z0-9_\.-]+@[a-z0-9\.-]+\.[a-z]{2,4}$/i', $str);
	}
	
	function message($text, $type = '', $width = null) {
		$_SESSION['message_text']  = $text;
		$_SESSION['message_type']  = $type;
		$_SESSION['message_width'] = $width;
	}
	
	function pr($array, $exit = false) {
		echo '<pre>' . print_r($array, true) . '</pre>';
		if ($exit) { exit; }
	}
	
	function location($location = ADMIN_URL) {
		header('Location: ' . $location);
		exit;
	}
	
	function currentUrl() {
		return 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
	}