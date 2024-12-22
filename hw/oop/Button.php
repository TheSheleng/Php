<?php

class Button extends Input {
private $isSubmit;

public function getSubmitState() {
return $this->isSubmit;
}

public function setSubmitState() {
$this->isSubmit = true;
}

public function __construct($background, $width, $height, $name, $value, $isSubmit) {
$this->setBackground($background);
$this->setWidth($width);
$this->setHeight($height);
$this->setName($name);
$this->setValue($value);
$this->setSubmitState($isSubmit);
}
}
