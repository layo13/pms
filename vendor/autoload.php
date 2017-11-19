<?php

require_once(__DIR__ . '/fct.php');

function autoload($class) {
	$file = str_replace("\\", "/", __DIR__ . "/../src/" . $class . ".php");

	if (is_file($file)) {
		require($file);
	} else {
		return;
	}
}

spl_autoload_register('autoload');

require_once (__DIR__ . "/Micro/MicroLoader.php");
MicroLoader::register();
