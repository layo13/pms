<?php

namespace Micro;

abstract class Entity implements \ArrayAccess {

    protected $erreurs = array();
    protected $id;

    public function __construct(array $donnees = array()) {
        if (!empty($donnees)) {
            $this->hydrate($donnees);
        }
    }

    public function isNew() {
        return empty($this->id);
    }

    public function erreurs() {
        return $this->erreurs;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = (int) $id;
    }

    public function hydrate(array $donnees) {
        foreach ($donnees as $attribut => $valeur) {
            $methode = 'set' . ucfirst($attribut);

            if (is_callable(array($this, $methode))) {
                $this->$methode($valeur);
            }
        }
    }

    public function offsetGet($var) {
        if (isset($this->$var) && is_callable(array($this, $var))) {
            return $this->$var();
        }
    }

    public function offsetSet($var, $value) {
        $method = 'set' . ucfirst($var);

        if (isset($this->$var) && is_callable(array($this, $method))) {
            $this->$method($value);
        }
    }

    public function offsetExists($var) {
        return isset($this->$var) && is_callable(array($this, $var));
    }

    public function offsetUnset($var) {
        throw new \Exception('Impossible de supprimer une quelconque valeur');
    }

    public function toArray() {
        $formated = array();
        $properties = (array) $this;
        $className = get_class($this);

        foreach ($properties as $name => $value) {
            $formated[preg_replace('/[\x00-\x1F\x80-\xFF]/', '', (str_replace(array($className, "*"), array("", ""), $name)))] = $value;
        }
        return $formated;
    }

    public function toJson() {
        return json_encode($this->toArray());
    }

}
