<?php
require_once "framework/Controller.php";
require_once "model/Note.php";
require_once "model/TextNote.php";
require_once "model/CheckListNoteItem.php";

class ControllerIndex extends Controller{

    public function index(): void
    {
        //$checklist_Note = CheckListNoteItem::get_All_item_checklist_by_id(1);
        $notesPinned = Note::get_All_notes_by_id(1, true);
        $notesOthers = Note::get_All_notes_by_id(1, false);
       // $notes_content = TextNote::get_All_note_content_by_id(1);
        (new View("index"))->show(["notesPinned" => $notesPinned, "notesOthers" => $notesOthers]);
    }
}