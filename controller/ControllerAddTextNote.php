<?php
require_once 'model/TextNote.php';
require_once 'framework/View.php';
require_once 'framework/Controller.php';

class ControllerAddTextNote extends Controller
{
    public function index(): void
    {
        (new View("add_text_note"))->show([]);
    }

    public function add_text_note(): void
    {
        $errors = []; // Tableau pour stocker les erreurs
        $title_note = '';
        $content_note = '';
        $idnote = "";
        $user = $this->get_user_or_redirect();

        if (isset($_POST["title_note"]) && isset($_POST["content_note"])) {
            $title_note = trim($_POST["title_note"]);
            $content_note = trim($_POST["content_note"]);

            // Validation de la longueur du titre
            if (strlen($title_note) < 3) {
                $errors[] = "Le titre doit avoir au moins 3 caractères.";
            }
            if (empty($errors)){
                // Création de la note si la validation est réussie
                $note = new TextNote(0, $content_note);
                $note->setOwner($user->getId());
                $note->persist(); // Enregistrement de la note
                $note->setTitle($title_note);

                // Redirection vers l'index avec l'ID de la note en tant que paramètre
                $idnote = $note->getId();
                $this->redirect("index", "open_text_note", "$idnote");
            }

        }

        // Affichage de la vue avec les erreurs
        (new View("add_text_note"))->show(["errors" => $errors, "title_note" => $title_note, "content_note" => $content_note]);
    }
}
?>
