<?php
require_once "model/User.php";
require_once "framework/Controller.php";
require_once "model/Note.php";
require_once "model/TextNote.php";
require_once "model/CheckListNoteItem.php";
require_once "model/NoteShare.php";

class ControllerDelete extends Controller
{

    #[\Override] public function index(): void
    {
        $user = $this->get_user_or_redirect();
        $idNote = "";
        $title = "";

        if (isset($_POST["idNote"])){
            $idNote = intval($_POST["idNote"]);
            $note = $user->get_One_note_by_id($idNote);
            $title = $note->getTitle();
        }

        (new View("delete_note"))->show(["idNote" => $idNote, "title" => $title]);
    }

    public function note(): void {

    }

    public function validate(): void {
        $idNote = intval($_GET['param1']);
        $user = $this->get_user_or_redirect();
        $note = $user->get_One_note_by_id($idNote);

        if ($note) {
            $note->delete();
            $this->redirect("index");
        }

        // Rediriger vers la page index après la suppression
        $this->redirect("index");
    }


    public function close(): void{
        $idNote = intval($_GET['param1']);

        $this->redirect("index", "open_text_note", $idNote);
    }

}