<?php

class ControllerDelete extends Controller
{

    #[\Override] public function index(): void
    {

    }

    public function note(): void {
        $idNote = intval($_GET['param1']);
        (new View("delete_note"))->show(["idNote" => $idNote]);
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