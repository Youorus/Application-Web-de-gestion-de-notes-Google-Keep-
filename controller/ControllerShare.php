<?php
require_once 'model/TextNote.php';
require_once 'framework/View.php';
require_once 'framework/Controller.php';

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
        (new View("shares"))->show(["note" => $note, "otherUsers" => $otherUsers]);
    }


}
?>
