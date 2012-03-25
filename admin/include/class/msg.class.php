<?php

class msg {
	
	protected static $_instance;
	protected $_msgs = array();
	protected $_session = array();
	
	protected function __construct() {
		if (session_id() === '') {
			session_start();
		}
		$this->_session = isset($_SESSION['msg']) ? $_SESSION['msg'] : '';
	}
	public function __destruct() {
		foreach ($this->_msgs as $msg) {
			echo $msg;
		}
		$_SESSION['msg'] = $this->_session;
	}
	
	protected function _getInstance() {
		if (!self::$_instance) {
			self::$_instance = new self;
		}
		return self::$_instance;
	}
	
	public function printError($err = '', $session = false) {
		if ($session) {
			self::_getInstance()->_session = '<div class="error" style="border: 1px solid #800000; font-size: 9pt; font-family: monospace; color: #800000; padding: .5em; margin: 8px; background-color: #eadddd">
				<span><b>Error:</b> ' . nl2br($err) . '</span>
			</div>';
		} else {
			self::_getInstance()->_msgs[] = '<div class="error" style="border: 1px solid #800000; font-size: 9pt; font-family: monospace; color: #800000; padding: .5em; margin: 8px; background-color: #eadddd">
				<span><b>Error:</b> ' . nl2br($err) . '</span>
			</div>';
		}
	}
	
	public function printMsg($msg = '', $type = 'Message', $session = false) { 
		if ($session) {
			self::_getInstance()->_session = '<div class="message" style="border: 1px solid #000080; font-size: 9pt; font-family: monospace; color: #000080; padding: .5em; margin: 8px; background-color: #E6E5FF">
				<span><b>' . $type . ':</b> ' . nl2br($msg) . '</span>
			</div>';
		} else {
			self::_getInstance()->_msgs[] = '<div class="message" style="border: 1px solid #000080; font-size: 9pt; font-family: monospace; color: #000080; padding: .5em; margin: 8px; background-color: #E6E5FF">
				<span><b>' . $type . ':</b> ' . nl2br($msg) . '</span>
			</div>';
		}
	}
	
	public function printWarning($wrn = '', $session = false) { 
		if ($session) {
			self::_getInstance()->_session = '<div class="warning" style="border: 1px solid #B8860B; font-size: 9pt; font-family: monospace; color: #B8860B; padding: .5em; margin: 8px; background-color: #eef1be">
				<span><b>Warning:</b> ' . nl2br($wrn) . '</span>
			</div>';
		}else {
			self::_getInstance()->_msgs[] = '<div class="warning" style="border: 1px solid #B8860B; font-size: 9pt; font-family: monospace; color: #B8860B; padding: .5em; margin: 8px; background-color: #eef1be">
				<span><b>Warning:</b> ' . nl2br($wrn) . '</span>
			</div>';
		}
	}
	
	public function printSessionMsg($return = false) {
		if ($return) {
			return $this->_session;
		} else {
			echo $this->_session;
		}
		unset($_SESSION['msg']);
	}
}