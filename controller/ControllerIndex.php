<?php
require_once "framework/Controller.php";
require_once "model/Note.php";
require_once "model/TextNote.php";
require_once "model/CheckListNoteItem.php";

class ControllerIndex extends Controller{

    public function index(): void
    {
            $user = $this->get_user_or_redirect();
           $notesPinned = $user->get_All_notes(true);
           $notesOthers = $user->get_All_notes(false);
           $userSharesNotes = $user->get_UserShares_Notes();
            $title = "My notes";
       // $notes_content = TextNote::get_All_note_content_by_id(1);
        (new View("index"))->show(["notesPinned" => $notesPinned, "notesOthers" => $notesOthers, "title" => $title, "userSharesNotes" => $userSharesNotes]);
    }

    public function archive_notes(): void{
        $user = $this->get_user_or_redirect();
        $title = "My archives";
        $notesArchives = $user->get_All_notesArchived();
        (new View("archives"))->show(["notesArchives" => $notesArchives, "title" => $title]);
    }

    public function setting(): void{
        $user = $this->get_user_or_redirect();
        $user_name = $user->get_fullname_User();
        $logout = $this->logout();
        $title = "Settings";
        (new View("setting"))->show(["user_name" => $user_name, "title" =>  $title]);

    }

    public function view_open_text_note(): void{
        $user = $this->get_user_or_redirect();
        $actualDate = new DateTime();
        $title = "title";

        (new View("open_text_note"))->show(["title" => $title]);
    }

    public function view_edit_text_note(): void{
        $user = $this->get_user_or_redirect();
        $actualDate = new DateTime();
        $idNote = intval($_GET['param1']);
        $title = TextNote::getTitleNote($idNote);
        $content = TextNote::getContentNote($idNote);
        $createDate = new DateTime(TextNote::getCreateDateTime($idNote));
        $editDate = (TextNote::getEditDateTime($idNote) != null) ? new DateTime(TextNote::getEditDateTime($idNote)) : null;

        $messageCreate = getMessageForDateDifference($actualDate, $createDate);
        $messageEdit = getMessageForDateDifference($actualDate, $editDate);


        (new View("text_note"))->show(["title" => $title, "content"=> "$content", "messageCreate" => $messageCreate,"messageEdit" => $messageEdit]);

        (new View("edit_text_note"))->show(["title" => $title]);
    }
}