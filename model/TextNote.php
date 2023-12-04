<?php

require_once "framework/Model.php";

class TextNote extends Model{
    public function __construct(public string $content)
    {
        
    }
    public function validate() : array {
        $error = [];
        
        return $error;
    }

    public function persist(){

    }

    public function delete(){

    }
}