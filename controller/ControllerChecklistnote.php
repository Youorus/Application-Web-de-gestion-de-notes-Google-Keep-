<?php
require_once "framework/Controller.php";
require_once "model/Note.php";
require_once "model/TextNote.php";
require_once "model/CheckListNoteItem.php";
require_once "model/NoteShare.php";



class ControllerChecklistnote extends Controller {

    protected function open_note(Note $note): string{
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



}



?>