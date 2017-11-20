<?php

var_dump($_GET, $_POST);

function httpRequest($url, $method = 'GET', $data = NULL, $header = '', &$outHeader = '') {
	return file_get_contents($url, FALSE, stream_context_create(array(
		'http' => array(
			'method' => $method,
			'header' => $header
		)
	)));
}

$url = "http://localhost/pms/customer";

var_dump($url, httpRequest($url));