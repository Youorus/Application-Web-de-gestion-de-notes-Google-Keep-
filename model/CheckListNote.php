<?php

require_once "framework/Model.php";

class CheckListNote extends Model{
    private int $id;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }
    public function __construct(int $id){
        $this->id = $id;
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