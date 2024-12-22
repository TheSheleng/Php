<?php

class Label extends Control {
    private $for;

    public function getParentName() {
        return $this->for;
    }

    public function setParentName($object) {
        if ($object instanceof Button || $object instanceof Text) {
            $this->for = $object->getName();
        }
    }

    public function __construct($background, $width, $height, $name, $value, $forObject) {
        $this->setBackground($background);
        $this->setWidth($width);
        $this->setHeight($height);
        $this->setName($name);
        $this->setValue($value);
        $this->setParentName($forObject);
    }
}
