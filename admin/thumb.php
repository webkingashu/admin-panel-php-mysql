<?php

	//require_once 'include/init.php';
	require_once 'include/class/images.class.php';
	require_once 'include/functions.php';
	
	$cache = true;
	$cacheDir = '../userfiles/cache/';
	
	/* Params */
	$width  = get('w', 0);
	$height = get('h', 0);
	$action = get('action');
	$type   = get('type', 'jpg');
	$radius = get('radius');
	$src    = get('src');
	
	/* If chache is set to true */
	if ($cache) {
		if (!is_dir('../userfiles/')) { mkdir('../userfiles/', 0777); }
		if (!is_dir('../userfiles/cache/')) { mkdir('../userfiles/cache/', 0777); }
		
		$cacheName = base64_encode(implode('|', $_GET)) . '.' . $type;
		
		if (file_exists($cacheDir . $cacheName)) {
			switch ($type) {
				case'gif': header('Content-type: image/gif'); break;
				case'png': header('Content-type: image/png'); break;
				default: header('Content-type: image/jpeg');
			}
			echo file_get_contents($cacheDir . $cacheName);
			die;
		}
	}
	
	$img = new Images($src);
	$img->resize($width, $height, $action, $type);
	$img->roundCorners($radius);
	$img->render();
	if ($cache) { $img->save($cacheDir . $cacheName); }
	