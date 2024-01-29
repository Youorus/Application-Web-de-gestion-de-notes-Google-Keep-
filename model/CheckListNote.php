<?php

require_once "Note.php";
class CheckListNote extends Note {
    private int $id;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }
    public function __construct(int $id) {
        parent::__construct($id, "", 0, new DateTime(), null, 0, 0, 0);
        $this->id = $id;
    }



    public function validate() : array {
        $error = [];

        return $error;
    }

    public function persist(): CheckListNote {
        // Vérifier si la note existe déjà dans la base de données
        $existingNote = self::execute("SELECT * FROM checklist_notes WHERE id = :id", ["id" => $this->getId()])->fetch();

        if ($existingNote) {
            // Si la note existe, mettez à jour les informations
            self::execute("UPDATE checklist_notes SET title = :title, owner = :owner, created_at = :created_at, edited_at = NOW() WHERE id = :id", [
                "title" => $this->getTitle(),
                "owner" => $this->getOwner(),
                "created_at" => $this->getDateTime()->format('Y-m-d H:i:s'),
                "id" => $this->getId()
            ]);
        } else {
            // Si la note n'existe pas, insérez une nouvelle ligne
            self::execute("INSERT INTO checklist_notes (id, title, owner, created_at, edited_at) VALUES (:id, :title, :owner, :created_at, NULL)", [
                "id" => $this->getId(),
                "title" => $this->getTitle(),
                "owner" => $this->getOwner(),
                "created_at" => $this->getDateTime()->format('Y-m-d H:i:s')
            ]);
        }
        return $this;
    }

    public function delete(){

    }

    public function getType(): NoteType
    {
        return NoteType::ChecklistNote;
    }

    public function getItems(): array {
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

}