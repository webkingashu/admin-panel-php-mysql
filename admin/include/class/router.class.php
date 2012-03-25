<?php

class Router {

	/** ## index.php
	 *	$router = new Router(
	 *		new Config,
	 *		array(
	 *			'contact'   => 'index/contact',
	 *			'produse'   => 'produse/index',
	 *			'produs'    => 'produse/detalii',
	 *		)
	 *	);
	 */
	
	protected $_route;
	protected $_controller;
	protected $_action;
	protected $_file;
	protected $_defaultController;
	
	public static $params = array();
	
	public function __construct(Config $config, $route = array(), $defaultController = 'index') {
		$this->_defaultController = $defaultController;
		$this->_getRoute($route);
		$this->_getParams();
		
		/**
		 *	Set controller
		 */
		$controller = !empty($_REQUEST['controller']) ? $_REQUEST['controller'] : $this->_controller;
		$this->_file = ADMIN_DIR . 'controller/' . $controller . '.php';
		if (!file_exists($this->_file)) {
			$controller = $this->_defaultController;
			$this->_file = ADMIN_DIR . 'controller/' . $controller . '.php';
			$this->_action = 'error404';
		}
		$this->_controller = $controller;
		
		/**
		 *	Set action
		 */
		$this->_action = !empty($_REQUEST['action']) ? $_REQUEST['action'] : $this->_action;
		
		/**
		 *	Load file and execute action
		 */
		require_once $this->getFile();
		
		$className = $this->_controller . 'Controller';
		$instance = new $className($config);
		if (is_callable(array($instance, $this->_action))) {
			$instance->{$this->_action}();
		} else {
			$instance->index();
		}
	}
	
	protected function _getRoute($route) {
		$uri    = parse_url($_SERVER['REQUEST_URI']);
		$tmp    = preg_replace('/^(.*?)index.php$/i', '$1', $_SERVER['PHP_SELF']);
		$_route = preg_replace("#$tmp#", '', $uri['path']); 
		
		preg_match('#^([^\/]+)?\/?([^\/]+)?#', $_route, $match);
		if (empty($match[1])) { $_route .= $this->_defaultController; }
		if (empty($match[2])) { $_route .= '/index'; }
		
		foreach ($route as $key=>$value) {
			if (preg_match("#^$key\/#", $_route)) {
				$this->_route = preg_replace("#^$key#", $value, $_route);
				return true;
			}
		}
		$this->_route = $_route;
		return true;
	}
	
	protected function _getParams() {
		$this->_route = preg_replace('#/+#', '/', $this->_route);
		$route = explode('/', $this->_route);
		for ($i = 0;$i < count($route);$i++) {
			if ($i == 0) {
				$this->_controller = $route[$i];
			} else if ($i == 1) {
				$this->_action = $route[$i];
			} else {
				self::$params[] = $route[$i];
			}
		}
	}
	
	public function getController() {
		return $this->_controller;
	}
	
	public function getAction() {
		return $this->_action;
	}

	public function getFile() {
		return $this->_file;
	}
}