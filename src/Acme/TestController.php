<?php

namespace Acme;

class TestController {

	/**
	 * @pattern /hello
	 * @return string
	 */
	public function helloWorldAction() {
		return "Hello World !";
	}

	/**
	 * @pattern /hello/{name}
	 * @parameter name string
	 * @return string
	 */
	public function helloAction($name) {
		return "Hello $name !";
	}

	/**
	 * @pattern /read/{entity}/{id}
	 * @parameter entity string
	 * @parameter id int
	 * @return string
	 */
	public function readEntityAction($entity, $id) {
		return "Lecture de l'entite $entity $id";
	}

}
