<?php

require_once "Note.php";
class CheckListNote extends Note
{
    protected ?int $id;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function __construct(?int $id)
    {
        parent::__construct($id, "", 0, new DateTime(), null, 0, 0, 0);
        $this->id = $id;
    }


    public function delete(): void
    {

        self::execute("DELETE FROM checklist_note_items WHERE checklist_note_items.checklist_note = :id", ["id" => $this->getId()]);
        self::execute("DELETE FROM checklist_notes WHERE checklist_notes.id = :id", ["id" => $this->getId()]);
        parent::delete();
    }



    public function persist(): CheckListNote | array  {
        if (self::get_checklistnote_by_id($this->getId())) {
            self::execute("UPDATE notes SET title = :title, owner = :owner, created_at = :createdAt, 
                           edited_at = :editedAt, pinned = :pinned, archived = :archived, weight = :weight 
                           WHERE id = :id",
                [
                    'id' => $this->getId(),
                    'title' => $this->getTitle(),
                    'owner' => $this->getOwner(),
                    'createdAt' => $this->getDateTime()->format('Y-m-d H:i:s'),
                    'editedAt' => $this->getDateTimeEdit() ? $this->getDateTimeEdit()->format('Y-m-d H:i:s') : null,
                    'pinned' => $this->getPinned(),
                    'archived' => $this->getArchived(),
                    'weight' => $this->getWeight()
                ]);
        } else {
            self::execute("INSERT INTO notes (title, owner, created_at, edited_at, pinned, archived, weight)
                           VALUES (:title, :owner, :createdAt, :editedAt, :pinned, :archived, :weight)",
                [
                    'title' => $this->getTitle(),
                    'owner' => $this->getOwner(),
                    'createdAt' => $this->getDateTime()->format('Y-m-d H:i:s'),
                    'editedAt' => $this->getDateTimeEdit() ? $this->getDateTimeEdit()->format('Y-m-d H:i:s') : null,
                    'pinned' => $this->getPinned(),
                    'archived' => $this->getArchived(),
                    'weight' => $this->getWeight()
                ]);
            $this->id = self::lastInsertId();
            self::execute("INSERT INTO checklist_notes (id) VALUES (:id)",
                ['id' => $this->id]);
        }
        foreach ($this->getItems() as $item) {
            $item->setChecklistNote($this->id);
            $item->persist();
        }

        return $this;
    }



    public function getType(): NoteType
    {
        return NoteType::ChecklistNote;
    }

    public function getItems(): array
    {
        $query = self::execute("SELECT checklist_note_items.id, checklist_note_items.checklist_note, checklist_note_items.content, checklist_note_items.checked 
FROM checklist_note_items
JOIN checklist_notes
ON checklist_notes.id = checklist_note_items.checklist_note
WHERE checklist_note_items.checklist_note = :id ORDER BY checklist_note_items.checked = 1", ["id" => $this->id]);
        $data = $query->fetchAll();
        $results = [];

        foreach ($data as $row) {
            $results[] = new CheckListNoteItem(
                $row['id'],
                $row['checklist_note'],
                $row['content'],
                $row['checked']
            );
        }

        return $results;
    }





    public static function get_checklistnote_by_id(int $id) : CheckListNote | false {
        $query = self::execute("select * FROM checklist_notes where id = :id", ["id"=>$id]);
        $data = $query->fetch();
        if ($query->rowCount() == 0) {
            return false;
        } else {
            return new CheckListNote($data["id"]);
        }
    }

    public function validate_checklistnote(): array {
        $errors = [];

        if (strlen($this->getTitle()) < 3 || strlen($this->getTitle()) > 25) {
            $errors['title'] = "The title must be between 3 and 25 characters.";
        }

        $itemNames = [];
        foreach ($this->getItems() as $item) {
            if (in_array($item->getContent(), $itemNames)) {
                $errors[] = "Item names must be unique.";
            }
            $itemNames[] = $item->getContent();
        }

        return $errors;
    }

    public function getTitle(): string
    {
        if(empty($this->getTitleNote())){
            $query = self::execute("SELECT notes.title from notes WHERE notes.id = :id", ["id" => $this->id]);
            $data = $query->fetchAll();
            $results = "";
            foreach ($data as $row){
                $results = $row['title'];

            }

        }else{
            $results = $this->getTitleNote();
        }
        return $results;
    }




}