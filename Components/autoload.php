<?php

use Components\Request;

// autoloader
spl_autoload_register(function($name) {
	$path = str_replace('\\', '/', $name) . '.php';

	if (! file_exists($path)) {
		die(Request::makeError(500, 'Internal Server Error'));
	}

	require_once $path;
});
