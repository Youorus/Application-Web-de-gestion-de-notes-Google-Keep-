<?php
require_once "framework/Controller.php";
require_once "model/Note.php";
require_once "model/TextNote.php";
require_once "model/CheckListNoteItem.php";
require_once "model/NoteShare.php";


class ControllerEditText extends Controller
{
    public function index(): void
    {
        // Cette méthode est actuellement vide. Vous pouvez y ajouter du code si nécessaire.
    }

    public function note(): void
    {

        // Récupération de l'ID de la note depuis les paramètres de l'URL
        $idNote = intval($_GET['param1']);

        // Récupération de l'utilisateur actuel
        $user = $this->get_user_or_redirect();

        $minLenght = Configuration::get("title_min_lenght");
        $maxLenght = Configuration::get("title_max_lenght") ;

        // Récupération de la date actuelle
        $actualDate = new DateTime();

        // Récupération de la note spécifiée par son ID
        $note = $user->get_One_note_by_id($idNote);

        // Récupération des détails de la note
        $title = $note->getTitle();
        $content = $note->getContent();
        $createDate = $note->getDateTime();
        $editDate = $note->getDateTimeEdit();

        // Calcul des messages relatifs aux dates de création et de dernière édition

        // Affichage de la vue pour l'édition de la note
        (new View("edit_text_note"))->show([
            "title" => $title,
            "content" => $content,
            "minLenght" =>  $minLenght,
            "maxLenght" =>  $maxLenght,
            "note" => $note
        ]);
    }

    public function edited_note(): void
    {
        // Récupération de l'ID de la note depuis les paramètres de l'URL
        $idNote = intval($_GET['param1']);
        $user = $this->get_user_or_redirect();
        // Initialisation des erreurs
        $errors = [];


        // Initialisation des variables pour le titre et le contenu de la note
        $title = '';
        $content = '';

        // Vérification de l'existence et de la validité des données envoyées en POST
        if (isset($_POST["title_note"]) && isset($_POST["content_note"])) {
            $title = trim($_POST["title_note"]);
            $content = trim($_POST["content_note"]);

            // Validation de la longueur du titre

            $errors[] = TextNote::validate($title);

            if($user->title_exist($title)){
                $errors[] = "this title is already exist";
            }



            // Si aucune erreur n'est détectée, mise à jour de la note
            if ($errors) {
                $note = Note::get_textnote_by_id($idNote);
                $note->setTitle($title);
                $note->setContent($content);
                $note->persist();

                // Redirection vers l'index avec l'ID de la note en tant que paramètre
                $this->redirect("index", "open_text_note", "$idNote");
            }
        }

        // Affichage de la vue pour l'édition de la note avec les erreurs éventuelles
        (new View("edit_text_note"))->show([
            "errors" => $errors,
            "title" => $title,
            "content" => $content,
            "note" => Note::get_textnote_by_id($idNote) // Récupération de la note pour afficher les détails
        ]);
    }
}

?>
