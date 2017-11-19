<?php

namespace Micro\Routing;

class Route {

	private $pattern;
	private $parameters;
	private $callback;

	function __construct() {
		$this->parameters = array();
	}

	public function getCallback() {
		return $this->callback;
	}

	public function setPattern($pattern) {
		$this->pattern = $pattern;
	}

	public function setCallback($callback) {
		$this->callback = $callback;
	}

	public function addParamter(RouteParameter $parameter) {
		$this->parameters[] = $parameter;
	}

	public function compile() {
		$pattern = $this->pattern;

		/* @var $parameter RouteParameter */
		foreach ($this->parameters as $parameter) {
			if ($parameter->getType() == "int") {
				$paramPattern = '([0-9]+)';
			} elseif ($parameter->getType() == "string") {
				$paramPattern = '([a-zA-z0-9]+)';
			} else {
				$paramPattern = '([a-zA-z0-9]+)';
			}
			$pattern = str_replace("{" . $parameter->getName() . "}", $paramPattern, $pattern);
		}
		return $pattern;
	}

}
