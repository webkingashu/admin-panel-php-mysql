<?php

	require_once 'include/init.php';
	
	$router = new Router(
		$config,
		array(
			'core'             => 'core/index',
			'tables-settings'  => 'core/coreSettings',
		)
	);