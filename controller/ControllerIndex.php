<?php
require_once "framework/Controller.php";
require_once "model/Note.php";
require_once "model/TextNote.php";
require_once "model/CheckListNoteItem.php";
require_once "model/NoteShare.php";

function getMessageForDateDifference(DateTime $referenceDate, ?DateTime $compareDate): string {
    // Calcul de la différence en mois
    if ($compareDate == null){
        return "Not yet";
    }
    $interval = $referenceDate->diff($compareDate);
    $nombreMoisEcart = $interval->y * 12 + $interval->m;


    // Vérification si le nombre de mois d'écart est le même mois
    if ($nombreMoisEcart == 0) {
        // Vérification du nombre de jours d'écart
        $nombreJoursEcart = $interval->d;

        if ($nombreJoursEcart == 0) {
            return "Today";
        } else {
            return  $nombreJoursEcart . " days ago";
        }
    } else {
        return  $nombreMoisEcart . " month ago";
    }
}


class ControllerIndex extends Controller{

    function getMessageForDateDifference(DateTime $referenceDate, ?DateTime $compareDate): string {
        // Calcul de la différence en mois
        if ($compareDate == null){
            return "Not yet";
        }
        $interval = $referenceDate->diff($compareDate);
        $nombreMoisEcart = $interval->y * 12 + $interval->m;
    
    
        // Vérification si le nombre de mois d'écart est le même mois
        if ($nombreMoisEcart == 0) {
            // Vérification du nombre de jours d'écart
            $nombreJoursEcart = $interval->d;
    
            if ($nombreJoursEcart == 0) {
                return "Today";
            } else {
                return  $nombreJoursEcart . " days ago";
            }
        } else {
            return  $nombreMoisEcart . " month ago";
        }
    }


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
        if (isset($_GET['logout'])) {
            $this->logout();
            header('Location: index.php');
            exit;
        }
        $user_name = $user->get_fullname_User();
        $title = "Settings";
        (new View("setting"))->show(["user_name" => $user_name, "title" =>  $title]);

    }




    public function open_text_note(): void{
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


    
    }

    public function view_edit_text_note(): void{
        $user = $this->get_user_or_redirect();

        $actualDate = new DateTime();
        $idNote = intval($_GET['param1']);
        $title = TextNote::getTitleNote($idNote);
        $content = TextNote::getContentNote($idNote);
        $createDate = new DateTime(TextNote::getCreateDateTime($idNote));
        $editDate = (TextNote::getEditDateTime($idNote) != null) ? new DateTime(TextNote::getEditDateTime($idNote)) : null;
        
        $messageCreate = $this->getMessageForDateDifference($actualDate, $createDate);
        $messageEdit = $this->getMessageForDateDifference($actualDate, $editDate);


        (new View("edit_text_note"))->show(["title" => $title, "content"=> "$content", "messageCreate" => $messageCreate,"messageEdit" => $messageEdit]);

        
    }

    public function save_note(): void{
        $user = $this->get_user_or_redirect();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['note_id']) && isset($_POST['content'])) {
            $idNote = $_POST['note_id'];
            $content = $_POST['content'];

            $note = new TextNote($idNote,$content);
            $note->setId($idNote);
            $note->setContent($content);

                if ($note->persist()) {
                    header('Location: index/open_text_note.php');
                    exit();

                
                }
            }
        }

        $title = "title";
        // $actualDate = new DateTime();
        $idNote = intval($_GET['param1']);
        $dateCreation = new DateTime(Note::getDateTimeCreate($idNote));
        //$messageCreate = getMessageForDate($actualDate, $dateCreation);
        (new View("edit_text_note"))->show(["title" => $title,"dateCreation" => $dateCreation]);

    }

    public function view_add_text_note(): void{
        $content = '';
        $id = '';
        if(isset($_POST['content'])){
            $content = $_POST['content'];
            $note = new TextNote($content, $id);
        }
        (new View("add_text_note"))->show(["content" => $content]);
    }

    public function view_shares_note(): void{
        $noteId = null;
        
        if(isset($_GET['id'])){
            $noteId = $_GET['id'];
            $noteType = getType($noteId);
            

            if ($noteType == 'checklist') {
                header('Location: view_checklist_note.php?id=' . $noteId); //mettre le vrai nom de la vue de open check list note de anass
            } else {
                header('Location: index/open_text_note.php?id=' . $noteId);
            }

           
        }

        
       

        (new View("shares"))->show(["id" => $noteId]);
    }

    public function add_share() {
        $user = $this->get_user_or_redirect(); // S'assure que l'utilisateur est connecté
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Récupération des données du formulaire
            $noteId = $_POST['note_id'];
            $shareUserId = $_POST['user_id'];
            $permission = $_POST['permission'] === 'editor' ? 1 : 0;
    
            // Obtenez l'objet Note à partir de son ID
            $note = Note::getId($noteId);
            if ($note instanceof Note) {
                // Création de l'objet NoteShare et sauvegarde dans la base de données
                $share = new NoteShare($note, $permission, $shareUserId);
                $share->persist();
    
                // Redirection avec un message de succès ou d'erreur
                $this->redirect('index.php?action=view_shares_note&id=' . $noteId); // Assurez-vous que la méthode redirect accepte cette syntaxe
            } else {
                // Gérez l'erreur si l'objet Note n'est pas récupéré correctement
            }
        }
    }

    public function delete_share(){

        $user = $this->get_user_or_redirect();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Récupération des données du formulaire
            $noteId = $_POST['note_id'];
            $shareUserId = $_POST['user_id'];

            $note = Note::getId($noteId);
            if ($note instanceof Note) {
                $share = new NoteShare($note,$user->getId(),$shareUserId);
                $share->delete();
                $this->redirect('index.php?action=view_shares_note&id=' . $noteId);
            }
            //suppression du partage
            
    } 
}

    public function toggle_share_permission(){
       
    }

     
}