<?php

namespace Micro\Routing;

class Router {

	private $routes;

	function __construct() {
		$this->routes = array();
	}

	public function addRoute(Route $route) {
		$this->routes[] = $route;
	}

	public function getMatchingRoute($uri) {
		$matches = array();
		foreach ($this->routes as $route) {
			$pattern = $route->compile();

			if (preg_match('`^' . $pattern . '$`', $uri, $matches)) {
				array_shift($matches);
				return call_user_func_array($route->getCallback(), $matches);
				break;
			}
		}
		throw new RouteNotFoundException("No route found for URI $uri");
	}

}
