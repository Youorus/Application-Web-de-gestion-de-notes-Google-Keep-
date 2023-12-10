<?php
require_once "framework/Controller.php";
require_once "model/Note.php";
require_once "model/TextNote.php";
require_once "model/CheckListNoteItem.php";

class ControllerIndex extends Controller{

    public function index(): void
    {
        $checklist_Note = CheckListNoteItem::get_All_item_checklist_by_id(1);
        $notes = Note::get_All_note_by_id(1);
        $notes_content = TextNote::get_All_note_content_by_id(1);
        (new View("index"))->show(["notes_content" => $notes_content, "notes" => $notes, "checklist_Note" => $checklist_Note,]);
    }
}