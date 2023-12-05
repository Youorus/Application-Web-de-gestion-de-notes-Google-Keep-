<?php

require_once "framework/Model.php";
require_once "User.php";

class Note extends Model{
    public function __construct(public string $title, public int $owner, public DateTime $create_at, public DateTime $edited_at, public int $pinned, public int $archived, public float $weight ){
        
    }

    public function validate() : array {
        $error = [];
        /*if(!User::get_user_by_mail($this->full_name)){

        }*/
        return $error;
    }

    public function persist(){

    }

    public function delete(){

    }
}
