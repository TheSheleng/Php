<?php

class Input extends Control {
private $name;
private $value;

public function getName() {
return $this->name;
}

public function setName($name) {
$this->name = $name;
}

public function getValue() {
return $this->value;
}

public function setValue($value) {
$this->value = $value;
}
}
