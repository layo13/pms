<?php

$folder = '/pms/customer/'; // RewriteBase

require_once __DIR__ . '/../vendor/autoload.php';

$requestMethod = $_SERVER['REQUEST_METHOD'];
$requestUri = $_SERVER['REQUEST_URI'];
$requestUri = str_replace_first($folder, "/", $requestUri);
$requestUri = str_replace("?" . $_SERVER['QUERY_STRING'], '', $requestUri);
$root = __DIR__;

////////////////////////////////////////////////////////////////////////////////

function autoload($class) {
	$file = str_replace("\\", "/", __DIR__ . "/src/" . $class . ".php");

	if (is_file($file)) {
		require($file);
	} else {
		return;
	}
}

spl_autoload_register('autoload');
////////////////////////////////////////////////////////////////////////////////
// MAPPING
if ($requestMethod === "GET" && array_key_exists("pmsd", $_GET) && $_GET["pmsd"] === '') {
	header("Content-Type: text/xml; Charset=UTF-8");
	readfile($root . "/app.xml");

	/* $controllerDir = $root . "/src/Controller";
	  $scandir = scandir($controllerDir);
	  foreach ($scandir as $file) {
	  $filename = $controllerDir . '/' . $file;
	  if (is_file($filename)) {
	  $controllerClassName = '\Controller\\' . pathinfo($filename, PATHINFO_FILENAME);
	  $rc = new ReflectionClass($controllerClassName);
	  $rmList = $rc->getMethods(ReflectionMethod::IS_PUBLIC);
	  foreach ($rmList as $rm) {
	  $docComment = $rm->getDocComment();

	  $lines = array_map(function($e) {
	  return trim($e, " \t\n\r\0\x0B*");
	  }, explode("\n", $docComment));

	  array_shift($lines);
	  array_pop($lines);

	  foreach ($lines as $line) {
	  var_dump($line);
	  }
	  }
	  }
	  } */
	die;
}

////////////////////////////////////////////////////////////////////////////////

$controllerClassName = \Controller\MainController::class;

$router = new Micro\Routing\Router();
$rc = new ReflectionClass($controllerClassName);
$rmList = $rc->getMethods(ReflectionMethod::IS_PUBLIC);
/* @var $rm ReflectionMethod */
foreach ($rmList as $rm) {
	$route = new \Micro\Routing\Route();
	$route->setCallback(array(new $controllerClassName(), $rm->name));

	$docComment = $rm->getDocComment();

	$lines = array_map(function($e) {
		return trim($e, " \t\n\r\0\x0B*");
	}, explode("\n", $docComment));

	array_shift($lines);
	array_pop($lines);

	foreach ($lines as $line) {
		if (preg_match("/@pattern\s(.+)/", $line, $matches)) {
			$route->setPattern($matches[1]);
		} elseif (preg_match("/@parameter\s(.+)\s(.+)/", $line, $matches)) {
			$route->addParamter(new Micro\Routing\RouteParameter($matches[1], $matches[2]));
		}
	}
	$router->addRoute($route);
}

//var_dump($router);
//$uris = array('/hello', '/hello/John', '/read/page/13', '/nimp/13');
//foreach ($uris as $uri) {var_dump($uri . ' -> ' . $router->getMatchingRoute($uri));}

$content = NULL;
try {
	$content = $router->getMatchingRoute($requestUri);
} catch (Exception $e) {
	header("HTTP/1.0 404 Not Found");
	echo "<html><head><title>Are you lost ?</title></head><body>Are you lost ($requestMethod, $requestUri) ?</body></html>";
	die();
}
echo $content;
$httpHeader = new \Micro\HTTP\Header(Micro\HTTP\ContentType::TEXT_HTML, Micro\HTTP\Charset::UTF8);
