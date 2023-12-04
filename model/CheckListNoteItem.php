<?php

require_once "framework/Model.php";

class CheckListNoteItem extends Model{
    public function __construct(public int $checklist_note, public string $content, public int $checked){

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