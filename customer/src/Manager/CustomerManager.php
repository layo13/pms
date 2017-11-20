<?php

namespace Model;

use Micro\Manager;
use Entity\Customer;

class CustomerManager extends Manager {

	public function getList($debut = -1, $limite = -1) {
		$sql = "SELECT id as id, email as email, password as password, register_date as registerDate, first_name as firstName, last_name as lastName, birth_date as birthDate, sex as sex FROM customer";

		if ($debut != -1 || $limite != -1) {
			$sql .= ' LIMIT ' . (int) $limite . ' OFFSET ' . (int) $debut;
		}

		$requete = $this->dao->query($sql);
		$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Customer');

		$customerList = new \Util\ArrayList($requete->fetchAll());

		$requete->closeCursor();

		return $customerList;
	}

	public function getUnique($id) {
		$requete = $this->dao->prepare("SELECT id as id, email as email, password as password, register_date as registerDate, first_name as firstName, last_name as lastName, birth_date as birthDate, sex as sex FROM customer WHERE id = :id");
		$requete->bindValue(':id', (int) $id);
		$requete->execute();

		$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Customer');

		if ($customer = $requete->fetch()) {
			return $customer;
		}

		return NULL;
	}

	protected function add(Customer $customer) {
		$requete = $this->dao->prepare("INSERT INTO customer (email, password, register_date, first_name, last_name, birth_date, sex) VALUES (:email, :password, :registerDate, :firstName, :lastName, :birthDate, :sex)");

		$requete->bindValue(':email', $customer->getEmail());
		$requete->bindValue(':password', $customer->getPassword());
		$requete->bindValue(':registerDate', $customer->getRegisterDate());
		$requete->bindValue(':firstName', $customer->getFirstName());
		$requete->bindValue(':lastName', $customer->getLastName());
		$requete->bindValue(':birthDate', $customer->getBirthDate());
		$requete->bindValue(':sex', $customer->getSex());

		$exec = $requete->execute();

		if ($exec) {
			$customer->setId($this->dao->lastInsertId());
			return true;
		} else {
			return false;
		}
	}

	public function delete($id) {
		$requete = $this->dao->prepare('DELETE FROM customer WHERE id = :id');
		$requete->bindValue(':id', $id, \PDO::PARAM_INT);
		return $requete->execute();
	}

	protected function modify(Customer $customer) {
		$requete = $this->dao->prepare("UPDATE customer SET email = :email, password = :password, register_date = :registerDate, first_name = :firstName, last_name = :lastName, birth_date = :birthDate, sex = :sex WHERE id = :id");

		$requete->bindValue(':email', $customer->getEmail());
		$requete->bindValue(':password', $customer->getPassword());
		$requete->bindValue(':registerDate', $customer->getRegisterDate());
		$requete->bindValue(':firstName', $customer->getFirstName());
		$requete->bindValue(':lastName', $customer->getLastName());
		$requete->bindValue(':birthDate', $customer->getBirthDate());
		$requete->bindValue(':sex', $customer->getSex());
		$requete->bindValue(':id', $customer->getId());
		return $requete->execute();
	}

	public function save(Customer $customer) {

		return $customer->isNew() ? $this->add($customer) : $this->modify($customer);
	}

}
