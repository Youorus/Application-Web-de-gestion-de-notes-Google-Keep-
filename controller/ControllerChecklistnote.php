<?php
require_once "framework/Controller.php";
require_once "model/Note.php";
require_once "model/TextNote.php";
require_once "model/CheckListNoteItem.php";
require_once "model/NoteShare.php";



class ControllerChecklistnote extends Controller {

    private function getMessageForDateDifference(DateTime $referenceDate, ?DateTime $compareDate): string
    {
        // Vérifier si la date de comparaison est nulle
        if ($compareDate === null) {
            return "Not yet";
        }

        // Calcul de la différence entre les dates
        $interval = $referenceDate->diff($compareDate);

        // Vérifier si la date de comparaison est dans le passé
        if ($interval->invert === 0) {
            // Si la différence est inférieure à une minute
            if ($interval->s < 60) {
                return "Just now";
            }
            // Si la différence est inférieure à une heure
            if ($interval->i < 60) {
                return "About " . $interval->i . " minutes ago";
            }
            // Si la différence est inférieure à un jour
            if ($interval->h < 24) {
                return "About " . $interval->h . " hours ago";
            }
            // Si la différence est inférieure à une semaine
            if ($interval->d < 7) {
                return "About " . $interval->d . " days ago";
            }
            // Si la différence est inférieure à un mois
            if ($interval->m < 1) {
                return "About " . floor($interval->d / 7) . " weeks ago";
            }
            // Si la différence est inférieure à un an
            if ($interval->y < 1) {
                return "About " . $interval->m . " months ago";
            }
            // Si la différence est supérieure ou égale à un an
            return "About " . $interval->y . " years ago";
        } else {
            // Si la date de comparaison est dans le futur
            // Utilisez simplement une chaîne vide pour indiquer une date future
            return "";
        }
    }

    private function open_note(Note $note): string{
        $type = "normal";
        if ($note->isArchived())
            $type = "archived";
        elseif ($note->isShared())
            $type = "share";

        return $type;
    }
    public function index(): void
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

        $messageCreate = $note->getDateTimeCreate()->format('s');
        $messageEdit = $note->getDateTimeEdit() ? $note->getDateTimeEdit()->format('s') : '';

        $noteType = $this->open_note($note);

        (new View("checklist_note"))->show(["title" => $title, "content" => $sortedItems, "messageCreate" => $messageCreate, "messageEdit" => $messageEdit, "note" => $note, "noteType" => $noteType, "idnote" => $idNote]);
    }

    public function form() {
        $user = $this->get_user_or_redirect();
        $errors = [];
        $title = '';
        $noteType = "add";


        (new View("add_checklist_note"))->show([
            "title" => $title,
            "errors" => $errors,
            "noteType" => $noteType
        ]);
    }

    public function add()
    {
        $user = $this->get_user_or_redirect();
        $errors = [];
        $title = '';
        $noteType = "add";

        if (isset($_POST['title'])) {

            $title = $_POST['title'] ?? '';
            $items = $_POST['items[]'] ?? '';
            $ownerId = $user->getId();
            $createdAt = new DateTime();

            $checklistNote = new CheckListNote(0);
            $weight = $checklistNote->getMaxWeight($ownerId);
            $checklistNote->setTitle($title);
            $checklistNote->setOwner($ownerId);
            $checklistNote->setDateTime($createdAt);
            $checklistNote->setPinned(false);
            $checklistNote->setArchived(false);
            $checklistNote->setWeight($weight);

            $errors = $checklistNote->validate_checklistnote();

            if($user->title_exist($title)){
                $errors['title'] = "this title is already exist";
            }

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
                        $errors = array_merge($errors, ['item' . $i => 'Item names must be unique']);
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

                $this->redirect("Checklistnote", "index", $checklistNote->getId());
            }
        }

        (new View("add_checklist_note"))->show([
            "title" => $title,
            "errors" => $errors,
            "noteType" => $noteType
        ]);
    }

    private function sort_items(array $items): array
    {
        usort($items, function ($a, $b) {
            return $a->getChecked() <=> $b->getChecked();
        });
        return $items;

    }


    public function editchecklistnote()
    {
        $idNote = $_POST['idnote'] ?? $_GET['param1'] ?? null;
        $errors = [];

        $user = $this->get_user_or_redirect();
        $note = $user->get_One_note_by_id($idNote);

        $minLenght = Configuration::get("title_min_lenght");
        $maxLenght = Configuration::get("title_max_lenght") ;
        $minItemLength = Configuration::get("item_min_length") ;
        $maxItemLength = Configuration::get("item_max_length") ;


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $title = $_POST['title'] ?? '';

            if (strlen(trim($title)) < $minLenght) {
                $errors['title'] = "Le titre doit contenir au moins " . $minLenght . " caractères.";
            }

            if (strlen(trim($title)) > $maxLenght) {
                $errors['title'] = "Le titre doit contenir au moins " . $maxLenght . " caractères.";
            }

            if($user->title_exist($title)){
                $errors['title'] = "this title is already exist";
            }

            if (empty($errors)) {
                $note->setTitle($title);
                $note->setDateTimeEdit(new DateTime());

                if($note->isPinned()) {
                    $note->setPinned(1);
                }
                $weight = $note->getWeightByIdNote($idNote);
                $maxWeight = $note->getMaxWeight($user->getId());
                if($weight != $maxWeight) {
                    $note->setWeight($maxWeight);
                }

                $note->persist();
                $this->redirect("Checklistnote", "index", $idNote);
            }
        }

        $title = $note->getTitle();
        $items = $note->getItems();
        $actualDate = new DateTime();
        $createDate = $note->getDateTime();
        $editDate = $note->getDateTimeEdit();
        $messageCreate = $this->getMessageForDateDifference($actualDate, $createDate);
        $messageEdit = $this->getMessageForDateDifference($actualDate, $editDate);
        $noteType = $this->open_note($note);

        (new View("edit_checklistnote"))->show([
            "note" => $note,
            "title" => $title,
            "items" => $items,
            "messageCreate" => $messageCreate,
            "messageEdit" => $messageEdit,
            "noteType" => $noteType,
            "errors" => $errors,
            "minLength" => $minLenght,
            "maxLength" => $maxLenght,
            "minItemLength" => $minItemLength,
            "maxItemLength" => $maxItemLength
        ]);
    }





    public function delete_item()
    {
        //return print_r($_POST);
        $idnoteitem = $_POST['id_item'];
        $idNote = $_POST['idnote'];

        $checklistnoteitem = new CheckListNoteItem($idnoteitem, 0, "", 0);
        $checklistnoteitem->delete_item();


        $this->redirect("Checklistnote", "editchecklistnote", $idNote);
    }

    public function add_item()
    {
        $idNote = $_POST['idnote'];
        $content = $_POST['content'];
        $user = $this->get_user_or_redirect();
        $note = $user->get_One_note_by_id($idNote);


        $errors = [];

        // Récupération des configurations de longueur minimale et maximale pour les items
        $minItemLength = Configuration::get("item_min_length");
        $maxItemLength = Configuration::get("item_max_length");

        $checklistnote = new CheckListNote($idNote);
        $allItems = $checklistnote->getItems();

        if (strlen(trim($content)) < $minItemLength) {
            $errors['item'] = "Item must have at least $minItemLength characters.";
        } elseif (strlen(trim($content)) > $maxItemLength) {
            $errors['item'] = "Item must have less than $maxItemLength characters.";
        }

        foreach ($allItems as $item) {
            if (strtolower(trim($item->getContent())) === strtolower(trim($content))) {
                $errors['unique'] = "Les items doivent être uniques.";
            }
        }

        if (empty($errors)) {
            $checklistnoteitem = new CheckListNoteItem(0, $idNote, $content, 0);
            $checklistnoteitem->persist();
            $this->redirect("Checklistnote", "editchecklistnote", $idNote);
        }

        $title = $note->getTitle();
        $items = $note->getItems();
        $actualDate = new DateTime();
        $createDate = $note->getDateTime();
        $editDate = $note->getDateTimeEdit();
        $messageCreate = $this->getMessageForDateDifference($actualDate, $createDate);
        $messageEdit = $this->getMessageForDateDifference($actualDate, $editDate);
        $noteType = $this->open_note($note);

        (new View("edit_checklistnote"))->show([
            "note" => $note,
            "title" => $title,
            "items" => $items,
            "messageCreate" => $messageCreate,
            "messageEdit" => $messageEdit,
            "noteType" => $noteType,
            "errors" => $errors,
            "minItemLength" => $minItemLength,
            "maxItemLength" => $maxItemLength
        ]);
    }



    public function check_uncheck()
    {
        $user = $this->get_user_or_redirect();
       // if ($_SERVER["REQUEST_METHOD"] === "GET") {
            if (isset($_GET['param1'])) {
            $itemId = $_GET['param1'];
            $checked = $_GET['param2'];
            $item = CheckListNoteItem::get_item_by_id($itemId);
            if ($item) {
                $item->setChecked($checked);
                $item->persist();

            }
            return var_dump(array("res"));
        }
        return var_dump(array("ko"));

    }
/*
    public function check_uncheck()
    {
        $user = $this->get_user_or_redirect();
        // if ($_SERVER["REQUEST_METHOD"] === "GET") {
        if (isset($_GET['item_id'])) {
            $itemId = $_GET['item_id'];
            $checked = isset($_GET['checked']) ? 1 : 0;
            $item = CheckListNoteItem::get_item_by_id($itemId);
            if ($item) {
                $item->setChecked($checked);
                $item->persist();
            }
            return var_dump(array("res"));
        }
        return var_dump(array("ko"));

    }
*/













}



?>