<?php

class Params {
    protected $paramList;

    public function __construct($paramList) {
        $this->paramList = $paramList;
    }

    public function get($id, $default) {
        if (array_key_exists($id, $this->paramList)) {
            return $this->paramList[$id]; 
        }
        return $default; 
    }
}