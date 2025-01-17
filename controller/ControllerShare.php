<?php
require_once 'model/TextNote.php';
require_once 'model/CheckListNote.php';
require_once 'framework/View.php';
require_once 'framework/Controller.php';
require_once 'model/NoteShare.php';

class ControllerShare extends Controller
{
    public function index(): void
    {

    }

    public function note(): void {
        $user = $this->get_user_or_redirect();
        $idNote = intval($_GET['param1']);
        $note = $user->get_One_note_by_id($idNote);
        $otherUsers = $user->getOtherUsers();
        (new View("shares"))->show(["note" => $note, "otherUsers" => $otherUsers, "idNote" => $idNote]);
    }

    public function add(): void{
        $user = $this->get_user_or_redirect();

        $id = 0;
        $permission = "";
        $idNote = "";

        if (isset($_POST["userId"]) && isset($_POST["permission"]) && isset($_POST["idNote"])){
            $idUser = intval($_POST["userId"]);
            $permission = intval($_POST["permission"]);
            $idNote = intval($_POST["idNote"]);

            $note = NoteShare::get_noteShare_byID($idNote);
            if ($note === false){
                $noteShare = new NoteShare($idNote,$permission,$idUser);
                $noteShare->persist();
                $this->redirect("index");
            }
        }
    }


}
?>
