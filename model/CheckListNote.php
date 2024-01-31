<?php

require_once "Note.php";
class CheckListNote extends Note
{
    private int $id;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function __construct(int $id)
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

    public function validate(): array
    {
        $error = [];

        return $error;
    }

    public function persist(): CheckListNote | array {
        $errors = $this->validate();
        if (!empty($errors)) {
            return $errors;
        }

        if (!parent::get_checklistnote_by_id($this->getId())) {
            // Insérer une nouvelle note dans 'notes'
            parent::execute(
                "INSERT INTO notes (title, owner, created_at, edited_at, pinned, archived, weight) 
             VALUES (:title, :owner, :createdAt, :editedAt, :pinned, :archived, :weight)",
                [
                    'title' => $this->getTitle(),
                    'owner' => $this->getOwner(),
                    'createdAt' => $this->getDateTime()->format('Y-m-d H:i:s'),
                    'editedAt' => $this->getDateTimeEdit()?->format('Y-m-d H:i:s'),
                    'pinned' => $this->getPinned(),
                    'archived' => $this->getArchived(),
                    'weight' => $this->getWeight()
                ]
            );
            $this->setId(parent::lastInsertId());

            // Insére dans 'checklist_notes'
            parent::execute(
                "INSERT INTO checklist_notes (id) VALUES (:id)",
                ['id' => $this->getId()]
            );
        } else {
            // Mettre à jour la note existante
            parent::execute(
                "UPDATE notes SET title = :title, edited_at = :editedAt, 
             pinned = :pinned, archived = :archived, weight = :weight WHERE id = :id",
                [
                    'id' => $this->getId(),
                    'title' => $this->getTitle(),
                    'editedAt' => $this->getDateTimeEdit()?->format('Y-m-d H:i:s'),
                    'pinned' => $this->getPinned(),
                    'archived' => $this->getArchived(),
                    'weight' => $this->getWeight()
                ]
            );

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
WHERE checklist_note_items.checklist_note = :id", ["id" => $this->id]);
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



    public function getTitle(): string
    {
        $query = self::execute("SELECT notes.title from notes WHERE notes.id = :id", ["id" => $this->id]);
        $data = $query->fetchAll();
        $results = "";
        foreach ($data as $row) {
            $results = $row['title'];
        }
        return $results;
    }
}


