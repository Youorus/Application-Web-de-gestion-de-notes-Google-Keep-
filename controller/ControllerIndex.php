<?php
require_once "framework/Controller.php";
require_once "model/Note.php";

class ControllerIndex extends Controller{

    public function index(): void
    {
        $notes = Note::get_All_note_by_id(1);
        (new View("index"))->show(array("notes" => $notes));
    }
}