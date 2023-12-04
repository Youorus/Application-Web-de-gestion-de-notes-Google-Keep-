<?php

require_once "framework/Model.php";

class CheckListNote extends Model{
    public function __construct(public int $id){

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