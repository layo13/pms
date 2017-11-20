<?php

namespace Entity;

use Micro\Entity;

class Customer extends Entity {

	private $email;
	private $password;
	private $registerDate;
	private $firstName;
	private $lastName;
	private $birthDate;
	private $sex;

	function getEmail() {
		return $this->email;
	}

	function getPassword() {
		return $this->password;
	}

	function getRegisterDate() {
		return $this->registerDate;
	}

	function getFirstName() {
		return $this->firstName;
	}

	function getLastName() {
		return $this->lastName;
	}

	function getBirthDate() {
		return $this->birthDate;
	}

	function getSex() {
		return $this->sex;
	}

	function setEmail($email) {
		$this->email = $email;
	}

	function setPassword($password) {
		$this->password = $password;
	}

	function setRegisterDate($registerDate) {
		$this->registerDate = $registerDate;
	}

	function setFirstName($firstName) {
		$this->firstName = $firstName;
	}

	function setLastName($lastName) {
		$this->lastName = $lastName;
	}

	function setBirthDate($birthDate) {
		$this->birthDate = $birthDate;
	}

	function setSex($sex) {
		$this->sex = $sex;
	}


}
