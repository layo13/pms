<?php

namespace Micro;

abstract class Manager {
	/**
	 *
	 * @var \PDO Bd
	 */
    protected $dao;

    public function __construct($dao) {
        $this->dao = $dao;
    }
}
