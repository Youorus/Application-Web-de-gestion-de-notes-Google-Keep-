<?php
require_once "framework/Controller.php";
require_once "model/Note.php";
require_once "model/TextNote.php";
require_once "model/CheckListNoteItem.php";

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

        $note = new TextNote();
        $note->id = $idNote;
        $note->content = $content;

            if ($note->persist()) {
                header('Location: index/open_text_note.php');
                exit();

            
            }
        }
    }
}
}