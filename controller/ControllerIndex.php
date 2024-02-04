<?php
require_once "framework/Controller.php";
require_once "model/Note.php";
require_once "model/TextNote.php";
require_once "model/CheckListNoteItem.php";
require_once "model/NoteShare.php";


 function open_note(Note $note): string{
    $type = "normal";
    if ($note->isArchived())
        $type = "archived";
    elseif ($note->isShared())
        $type = "share";

    return $type;
}

function getMessageForDateDifference(DateTime $referenceDate, ?DateTime $compareDate): string
{
    // Calcul de la différence en mois
    if ($compareDate == null) {
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
            return $nombreJoursEcart . " days ago";
        }
    } else {
        return $nombreMoisEcart . " month ago";
    }
}



class ControllerIndex extends Controller
{

    public function index(): void
    {
        $user = $this->get_user_or_redirect();
        $notesPinned = $user->get_All_notes(true);
        $notesOthers = $user->get_All_notes(false);
        $userSharesNotes = $user->get_UserShares_Notes();
        $title = "My notes";

        (new View("index"))->show(["notesPinned" => $notesPinned, "notesOthers" => $notesOthers, "title" => $title, "userSharesNotes" => $userSharesNotes]);

    }

    public function archive_notes(): void
    {
        $user = $this->get_user_or_redirect();
        $title = "My archives";
        $notesArchives = $user->get_All_notesArchived();
        $userSharesNotes = $user->get_UserShares_Notes();
        (new View("archives"))->show(["notesArchives" => $notesArchives, "title" => $title,"userSharesNotes" => $userSharesNotes,]);
    }


    public function setting(): void
    {
        $user = $this->get_user_or_redirect();
<<<<<<< HEAD
        if (isset($_GET['logout'])&& $_GET['logout'] == 'true'){
            $this->logout();
            header('Location: main/login.php');
            exit;
        }
        $user_name = $user->getFullName();


=======
        if (isset($_GET['logout'])) {
            $this->logout();
            header('Location: index.php');
            exit;
        }
        $user_name = $user->get_fullname_User();
>>>>>>> feat_view_shares
        $title = "Settings";
        (new View("setting"))->show(["user_name" => $user_name, "title" => $title]);

    }




    public function open_text_note() {
        $idNote = intval($_GET['param1']);
        $user = $this->get_user_or_redirect();
        $note = $user->get_One_note_by_id($idNote);
        $actualDate = new DateTime();
        $title = $note->getTitle();
        $content = $note->getContent();
        $createDate = $note->getDateTime();
        $editDate = $note->getDateTimeEdit();

        $messageCreate = getMessageForDateDifference($actualDate, $createDate);
        $messageEdit = getMessageForDateDifference($actualDate, $editDate);

        $noteType = open_note($note);

        (new View("text_note"))->show(["title" => $title, "content"=> "$content", "messageCreate" => $messageCreate,"messageEdit" => $messageEdit, "noteType"=>$noteType, "note"=>$note]);
    }

    public function open_checklist_note()
    {
        $idNote = intval($_GET['param1']);
        $user = $this->get_user_or_redirect();
        $note = $user->get_One_note_by_id($idNote);
        $actualDate = new DateTime();
        $title = $note->getTitle();
        $content = $note->getItems();

        $sortedItems = $this->sort_items($content);

        $createDate = $note->getDateTime();
        $editDate = $note->getDateTimeEdit();

        $messageCreate = getMessageForDateDifference($actualDate, $createDate);
        $messageEdit = getMessageForDateDifference($actualDate, $editDate);

        $noteType = open_note($note);

        (new View("checklist_note"))->show(["title" => $title, "content"=> $sortedItems, "messageCreate" => $messageCreate,"messageEdit" => $messageEdit, "note"=>$note,"noteType"=>$noteType, "idnote"=>$idNote]);
    }

    public function check_uncheck(){

        $user = $this->get_user_or_redirect();

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $idNote = intval($_POST['idnote']);
            $itemId = $_POST['item_id'];
            $checked = isset($_POST['checked']) ? 1 : 0;

            $item = CheckListNoteItem::get_item_by_id($itemId);
            if ($item) {
                $item->setChecked($checked);
                $item->persist();
            }


        }

        $this->redirect("index", "open_checklist_note/" . $idNote);

        //$this->redirect("index", "open_checklist_note");
    }

    private function sort_items(array $items): array {
        usort($items, function($a, $b) {
            return $a->getChecked() <=> $b->getChecked();
        });
        return $items;

    }


    public function share_notes(){
        $userId = $_GET['param1'];
        $user = $this->get_user_or_redirect();
        $userSharesNotes = $user->get_UserShares_Notes();
        $userName = User::getFullNameById($userId);
        $title = "Shared by ". $userName;
        $notesShares = $user->get_All_shared_notes($userId);


        (new View("share_notes"))->show(["title" => $title, "userName"=> $userName,"userSharesNotes" => $userSharesNotes, "notesShares"=> $notesShares]);
    }



    public function edit_text_note(): void{
        $idNote = intval($_GET['param1']);
        $user = $this->get_user_or_redirect();
        $actualDate = new DateTime();
        $note = $user->get_One_note_by_id($idNote); // je recupere la note sur laquelle on se trouve
        $title = $note->getTitle();
        $content = $note->getContent();
        $createDate = $note->getDateTime();
        $editDate = $note->getDateTimeEdit();

        $messageCreate = getMessageForDateDifference($actualDate, $createDate);
        $messageEdit = getMessageForDateDifference($actualDate, $editDate);
        $noteType = "edited";

        (new View("edit_text_note"))->show(["title" => $title, "content"=> "$content", "messageCreate" => $messageCreate,"messageEdit" => $messageEdit, "noteType"=>$noteType, "note"=>$note]);

    }

    public function save_note(): void
    {
        $user = $this->get_user_or_redirect();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['note_id']) && isset($_POST['content'])) {
                $idNote = $_POST['note_id'];
                $content = $_POST['content'];

                $note = new TextNote($idNote, $content);
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
        (new View("edit_text_note"))->show(["title" => $title, "dateCreation" => $dateCreation]);

    }

//    public function open_checklist_note () {
//
//    }



    public function view_add_text_note(): void{
        $content = '';
        $id = '';
        if(isset($_POST['content'])){
            $content = $_POST['content'];
            $note = new TextNote($content, $id);
        }
        (new View("add_text_note"))->show(["content" => $content]);
    }




    public function unpin(): void {
        $idNote = intval($_GET['param1']);
        $user = $this->get_user_or_redirect();
        $note = $user->get_One_note_by_id($idNote);

        if ($note) {
            $note->setPinned(0);
            $note->persist();
        }
        if($note->getType() == NoteType::TextNote){
            $this->redirect("index", "open_text_note", $_GET['param1']);
        }else{
            $this->redirect("index", "open_checklist_note", $_GET['param1']);
        }
    }

    public function pin(): void {
        $idNote = intval($_GET['param1']);
        $user = $this->get_user_or_redirect();
        $note = $user->get_One_note_by_id($idNote);

        if ($note) {
            $note->setPinned(1);
            var_dump($note);
            $note->persist();
        }
        if($note->getType() == NoteType::TextNote){
            $this->redirect("index", "open_text_note", $_GET['param1']);
        }else{
            $this->redirect("index", "open_checklist_note", $_GET['param1']);
        }

    }

    public function unarchive(){
        $idNote = intval($_GET['param1']);
        $user = $this->get_user_or_redirect();
        $note = $user->get_One_note_by_id($idNote);

        if ($note) {
            $note->setArchived(0);
            $note->persist();
        }

        if($note->getType() == NoteType::TextNote){
            $this->redirect("index", "open_text_note", $_GET['param1']);
        }else{
            $this->redirect("index", "open_checklist_note", $_GET['param1']);
        }
    }

    public function archive(){
        $idNote = intval($_GET['param1']);
        $user = $this->get_user_or_redirect();
        $note = $user->get_One_note_by_id($idNote);

        if ($note) {
            $note->setArchived(1);
            $note->persist();
        }

        if($note->getType() == NoteType::TextNote){
            $this->redirect("index", "open_text_note", $_GET['param1']);
        }else{
            $this->redirect("index", "open_checklist_note", $_GET['param1']);
        }
    }

    public function deleteNote(){
        $idNote = intval($_GET['param1']);
        $user = $this->get_user_or_redirect();
        $note = $user->get_One_note_by_id($idNote);

        if ($note) {
            $note->delete();
        }

        $this->redirect("index");
    }


    public function add_checklistnote() {
        $user = $this->get_user_or_redirect();
        $errors = [];
        $title = '';
        $noteType = "add";

        if (isset($_POST['title'])) {

            $title = $_POST['title'] ?? '';
            $items = $_POST['items[]'] ?? '';
            $ownerId = $user->getId();
            $createdAt = new DateTime();
            $weight = 1.0;

            $checklistNote = new CheckListNote(0);
            $checklistNote->setTitle($title);
            $checklistNote->setOwner($ownerId);
            $checklistNote->setDateTime($createdAt);
            $checklistNote->setPinned(false);
            $checklistNote->setArchived(false);
            $checklistNote->setWeight($weight);

            $errors = $checklistNote->validate_checklistnote();


            $items = [];
            $listitems = [];
            for ($i = 0; $i <= 4; $i++) {
                if (!empty($_POST["items"][$i])) {
                    $itemContent = $_POST["items"][$i];
                    $item = new CheckListNoteItem(
                        id: 0,
                        checklist_note: 0,
                        content: $itemContent,
                        checked: false
                    );
                    if (in_array($itemContent, $listitems)) {
                        $errors = array_merge($errors, ['item'.$i => 'Item names must be unique']);
                    }
                    $listitems[] = $itemContent;
                    $items[] = $item;
                }
            }


            if (empty($errors)) {
                $checklistNote = $checklistNote->persist();

                foreach ($items as $item) {
                    $item->setChecklistNote($checklistNote->getId());
                    $item->persist();
                }

                $this->redirect("index", "open_checklist_note", $checklistNote->getId());
            }
        }

        (new View("add_checklist_note"))->show([
            "title" => $title,
            "errors" => $errors,
            "noteType"=>$noteType
        ]);
    }

    /*
    public function editchecklistnote() {
        return print_r($_GET);
        $idNote = $_GET['param1'];
        $user = $this->get_user_or_redirect();
        $note = $user->get_One_note_by_id($idNote);
        $actualDate = new DateTime();
        $title = $note->getTitle();


        if(isset($_POST['title'])) {

        }
        $content = $note->getItems();

        $sortedItems = $this->sort_items($content);

        $createDate = $note->getDateTime();
        $editDate = $note->getDateTimeEdit();

        $messageCreate = getMessageForDateDifference($actualDate, $createDate);
        $messageEdit = getMessageForDateDifference($actualDate, $editDate);

        $noteType = open_note($note);

        (new View("edit_checklistnote"))->show(["title" => $title, "content"=> $sortedItems, "messageCreate" => $messageCreate,"messageEdit" => $messageEdit, "note"=>$note,"noteType"=>$noteType]);

    }
    */

    public function edit_checklistnote() {
        $idNote = intval($_GET['param1']);

        $user = $this->get_user_or_redirect();
        $note = $user->get_One_note_by_id($idNote);
        $actualDate = new DateTime();
        $title = $note->getTitle();

        if(isset($_POST['title'])) {
            return print_r($_POST);
        }
        $content = $note->getItems();

        $sortedItems = $this->sort_items($content);

        $createDate = $note->getDateTime();
        $editDate = $note->getDateTimeEdit();

        $messageCreate = getMessageForDateDifference($actualDate, $createDate);
        $messageEdit = getMessageForDateDifference($actualDate, $editDate);

        $noteType = open_note($note);

        (new View("edit_checklistnote"))->show(["title" => $title, "content"=> $sortedItems, "messageCreate" => $messageCreate,"messageEdit" => $messageEdit, "note"=>$note,"noteType"=>$noteType]);

    }

    public function editchecklistnote() {
        if(isset($_POST['idnote'], $_POST['title'])) {
            $error = [];
            $idNote = $_POST['idnote'];
            $user = $this->get_user_or_redirect();
            $ownerId = $user->getId();

            $note = $user->get_One_note_by_id($idNote);
            $note->setOwner($ownerId);
            //return var_dump($note);
            if ($note) {

                $note->setTitle($_POST['title']);
                $editDate = new DateTime();
                $note->setDateTimeEdit($editDate);
                //return print_r($note);

                $error = $note->validate_checklistnote();

                if (empty($error)) {

                    $note->persist();

                    $this->redirect("index", "edit_checklistnote", $idNote);
                }
            }
        }
    }

    /*
    public function edit_checklistnote() {
        $error = [];
        $idNote = intval($_GET['param1']);

        $user = $this->get_user_or_redirect();
        $note = $user->get_One_note_by_id($idNote);
        $ownerId = $user->getId();

        $title = $_POST['title'];


        $checklistNote = new CheckListNote($idNote);
        $checklistNote->setTitle($title);
        $editDate = new DateTime();
        $checklistNote->setDateTimeEdit($editDate);
        $checklistNote->setOwner($ownerId);

        $error = $checklistNote->validate_checklistnote();

        if(empty($error)) {
           $checklistNote->persist();
        }

        $this->redirect("index", "open_checklist_note", $idNote);



    }
    */

    public function delete_item () {
        //return print_r($_POST);
        $idnoteitem = $_POST['id_item'];
        $idNote = $_POST['idnote'];

        $checklistnoteitem = new CheckListNoteItem($idnoteitem, 0, "", 0);
        $checklistnoteitem->delete_item();


        $this->redirect("index", "edit_checklistnote", $idNote);
    }

    public function add_item() {
        //$idnoteitem = $_POST['id_item'];
        $idNote = $_POST['idnote'];
        $content = $_POST['content'];
        $checklistnoteitem = new CheckListNoteItem(0, $idNote, $content, 0);
        $checklistnoteitem->persist();

        $this->redirect("index", "edit_checklistnote", $idNote);
    }


}

    public function view_shares_note(): void{
        $noteId = null;
        
        if(isset($_GET['id'])){
            $noteId = $_GET['id'];
            $noteType = getType($noteId);
            
            $usersIds = User::getUsersIds();
            

            if ($noteType == 'checklist') {
                header('Location: view_checklist_note.php?id=' . $noteId); //mettre le vrai nom de la vue de open check list note de anass
            } else {
                header('Location: index/open_text_note.php?id=' . $noteId);
            }

           
        }

        
       

        (new View("shares"))->show(["id" => $noteId, "usersIds" => $usersIds]);
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
    
                
                $this->redirect('index.php?action=view_shares_note&id=' . $noteId); 
            } else {
                
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

