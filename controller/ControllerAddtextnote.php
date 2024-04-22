<?php
require_once 'model/TextNote.php';
require_once 'framework/View.php';
require_once 'framework/Controller.php';

class ControllerAddtextnote extends Controller
{
    public function index(): void
    {
        $user = $this->get_user_or_redirect();
        $errors = []; // Tableau pour stocker les erreurs
        $title_note = '';
        $content_note = '';
        $idnote = "";

        $minLenght = Configuration::get("title_min_lenght");
        $maxLenght = Configuration::get("title_max_lenght") ;

        if (isset($_POST["title_note"]) && isset($_POST["content_note"])) {
            $title_note = trim($_POST["title_note"]);
            $content_note = trim($_POST["content_note"]);



            // Validation de la longueur du titre


            if (TextNote::validate($title_note) > 0)
                $errors[] = "The title must have more than 3 characters";
            if (TextNote::validate($title_note) < 0)
                $errors[] = "The title must have less than 25 characters";


            if($user->title_exist( $title_note)){
                $errors[] = "this title is already exist";
            }


            if (empty($errors)){

                // Création de la note si la validation est réussie
                $note = new TextNote(0, $content_note);
                $note->setOwner($user->getId());
                $note->setTitle($title_note);
                $note->persist(); // Enregistrement de la note


                // Redirection vers l'index avec l'ID de la note en tant que paramètre
                $idnote = $note->getId();
                $this->redirect("index", "open_text_note", "$idnote");
            }

        }

        // Affichage de la vue avec les erreurs
        (new View("add_text_note"))->show(["errors" => $errors, "title_note" => $title_note, "content_note" => $content_note, "minLenght" =>  $minLenght, "maxLenght" =>  $maxLenght]);
    }

//    public function add_text_note(): void
//    {
//
//        $user = $this->get_user_or_redirect();
//        $errors = []; // Tableau pour stocker les erreurs
//        $title_note = '';
//        $content_note = '';
//        $idnote = "";
//
//        if (isset($_POST["title_note"]) && isset($_POST["content_note"])) {
//            $title_note = trim($_POST["title_note"]);
//            $content_note = trim($_POST["content_note"]);
//
//            // Validation de la longueur du titre
//
//                $errors[] = TextNote::validate($title_note);
//
//                if($user->title_exist( $title_note)){
//                    $errors[] = "this title is already exist";
//                }
//
//
//            if (empty($errors)){
//                // Création de la note si la validation est réussie
//                $note = new TextNote(0, $content_note);
//                $note->setOwner($user->getId());
//                $note->setTitle($title_note);
//                $note->persist(); // Enregistrement de la note
//
//
//                // Redirection vers l'index avec l'ID de la note en tant que paramètre
//                $idnote = $note->getId();
//              $this->redirect("index", "open_text_note", "$idnote");
//            }
//
//        }
//
//        // Affichage de la vue avec les erreurs
//        (new View("add_text_note"))->show(["errors" => $errors, "title_note" => $title_note, "content_note" => $content_note]);
//    }



    public function validate(): void{
        $user = $this->get_user_or_redirect();
        $res = "false";
        if (isset($_POST["test"])){
            if($user->title_exist($_POST["test"]))
                $res = "true";

        }
        echo $res;
    }
}
?>
