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

        $minLenght = Configuration::get("title_min_lenght");
        $maxLenght = Configuration::get("title_max_lenght") ;
        $minItemLenght = Configuration::get("item_min_length") ;
        $maxItemLenght = Configuration::get("item_max_length") ;


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


    public function edit_checklistnote()
    {
        $idNote = intval($_GET['param1']);
        $coderror = isset($_GET['param2']) ? intval($_GET['param2']) : null;

        $minLength = Configuration::get("title_min_lenght");
        $maxLength = Configuration::get("title_max_lenght");
        $minItemLength = Configuration::get("item_min_length");
        $maxItemLength = Configuration::get("item_max_length");

        $user = $this->get_user_or_redirect();
        $note = $user->get_One_note_by_id($idNote);
        $actualDate = new DateTime();
        $title = $note->getTitle();
        $content = $note->getItems();
        $sortedItems = $this->sort_items($content);
        $createDate = $note->getDateTime();
        $editDate = $note->getDateTimeEdit();
        $messageCreate = $this->getMessageForDateDifference($actualDate, $createDate);
        $messageEdit = $this->getMessageForDateDifference($actualDate, $editDate);
        $noteType = $this->open_note($note);

        $error = "";
        if($coderror == 1) {
            $error = "Le titre doit contenir au moins 3 caractères";
        } elseif ($coderror == 2) {
            $error = "Les items doivent être uniques";
        }

        // Passer les variables à la vue
        (new View("edit_checklistnote"))->show([
            "title" => $title,
            "content" => $sortedItems,
            "messageCreate" => $messageCreate,
            "messageEdit" => $messageEdit,
            "note" => $note,
            "noteType" => $noteType,
            "coderror" => $coderror,
            "msgerror" => $error,
            "minLength" => $minLength,
            "maxLength" => $maxLength,
            "minItemLength" => $minItemLength,
            "maxItemLength" => $maxItemLength
        ]);
    }




    public function editchecklistnote()
    {
        if (isset($_POST['idnote'], $_POST['title'])) {
            $error = [];
            $idNote = $_POST['idnote'];
            $user = $this->get_user_or_redirect();
            $ownerId = $user->getId();

            $minLenght = Configuration::get("title_min_lenght");
            $maxLenght = Configuration::get("title_max_lenght") ;

            $note = $user->get_One_note_by_id($idNote);
            $note->setOwner($ownerId);
            //return var_dump($note);
            if ($note) {

                if($note->isPinned()) {
                    $note->setPinned(1);
                }
                if(!empty($_POST['title'])) {
                    $note->setTitle($_POST['title']);
                } else {
                    $note->setTitle(" ");
                }

                $editDate = new DateTime();
                $note->setDateTimeEdit($editDate);
                //return print_r($note);

                $error = $note->validate_checklistnote();

                //return print_r($error);

                if (empty($error)) {
                    $note->persist();
                    $this->redirect("Checklistnote", "edit_checklistnote", "$idNote", 0);
                } else {
                    $coderror = 2;
                    if(isset($error["title"])) {
                        $coderror = 1;
                    }
                    $this->redirect("Checklistnote", "edit_checklistnote", "$idNote", "$coderror");
                }
            }
        }
    }




    public function delete_item()
    {
        //return print_r($_POST);
        $idnoteitem = $_POST['id_item'];
        $idNote = $_POST['idnote'];

        $checklistnoteitem = new CheckListNoteItem($idnoteitem, 0, "", 0);
        $checklistnoteitem->delete_item();


        $this->redirect("Checklistnote", "edit_checklistnote", "$idNote");
    }

    public function add_item()
    {
        //$idnoteitem = $_POST['id_item'];
        $idNote = $_POST['idnote'];
        $content = $_POST['content'];
        $error = "";
        $coderror = "";

        $checklistnote = new CheckListNote($idNote);
        $allItems = $checklistnote->getItems();

        foreach ($allItems as $item) {
            if (strtolower(trim($item->getContent())) === strtolower($content)) {
                $this->redirect("Checklistnote", "edit_checklistnote", "$idNote", 2);
            }
        }

        if (empty($errors)) {
            $checklistnoteitem = new CheckListNoteItem(0, $idNote, $content, 0);
            $checklistnoteitem->persist();
            $this->redirect("Checklistnote", "edit_checklistnote", "$idNote", 0);
        }

    }

    public function check_uncheck()
    {

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

        $this->redirect("Checklistnote", "index", "$idNote");

        //$this->redirect("index", "open_checklist_note");
    }

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