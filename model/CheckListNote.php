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

    public function persist(){

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


    public function getTitle(): string
    {
        $query = self::execute("SELECT notes.title from notes WHERE notes.id = :id", ["id" => $this->id]);
        $data = $query->fetchAll();
        $results = "";
        foreach ($data as $row){
            $results = $row['title'];
        }
        return $results;
    }


}