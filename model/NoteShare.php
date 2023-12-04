<?php

require_once "framework/Model.php";

class NoteShare extends Model{
    public function __construct(public int $editor){

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