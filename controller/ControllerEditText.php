<?php
require_once 'model/TextNote.php';
require_once 'framework/View.php';
require_once 'framework/Controller.php';
require_once 'controller/ControllerIndex.php';

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
        $messageCreate = getMessageForDateDifference($actualDate, $createDate);
        $messageEdit = getMessageForDateDifference($actualDate, $editDate);

        // Affichage de la vue pour l'édition de la note
        (new View("edit_text_note"))->show([
            "title" => $title,
            "content" => $content,
            "messageCreate" => $messageCreate,
            "messageEdit" => $messageEdit,
            "note" => $note
        ]);
    }

    public function edited_note(): void
    {
        // Récupération de l'ID de la note depuis les paramètres de l'URL
        $idNote = intval($_GET['param1']);

        // Initialisation des erreurs
        $errors = [];

        // Initialisation des variables pour le titre et le contenu de la note
        $title = '';
        $content = '';

        // Vérification de l'existence et de la validité des données envoyées en POST
        if (isset($_POST["title"]) && isset($_POST["content"])) {
            $title = trim($_POST["title"]);
            $content = trim($_POST["content"]);

            // Validation de la longueur du titre
            if (strlen($title) < 3) {
                $errors[] = "Le titre doit comporter au moins 3 caractères.";
            }

            // Si aucune erreur n'est détectée, mise à jour de la note
            if (empty($errors)) {
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
