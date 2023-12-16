<?php

require_once "framework/Model.php";

class CheckListNoteItem extends Model{
    private int $id;


    private int $checklist_note;
    private string $content;

    private int $checked;
    public function __construct(int $id, int $checklist_note, string $content,  int $checked){
        $this->id = $id;
        $this->checklist_note = $checklist_note;
        $this->content = $content;
        $this->checked = $checked;
    }

    public static function get_All_item_checklist_by_id(int $id): array {
        $query = self::execute("SELECT checklist_note_items.id as id, checklist_note_items.checklist_note as checklist_note, checklist_note_items.content as content, checklist_note_items.checked as checked
FROM checklist_note_items
JOIN checklist_notes ON checklist_note_items.checklist_note = checklist_notes.id
JOIN notes ON notes.id = checklist_notes.id
JOIN users ON notes.owner = users.id
WHERE users.id = :id
", ["id" => $id]);
        $data = $query->fetchAll();
        $results = [];

        foreach ($data as $row) {
            // Ajouter une note au tableau
            $results[] = new CheckListNoteItem(
                $row["id"],
                $row["checklist_note"],
                $row["content"],
                $row["checked"]
            );
        }

        return $results;
    }

    public static function get_item_checklist_by_id(int $id): array {
        $query = self::execute("SELECT distinct content 
FROM checklist_note_items
WHERE checklist_note_items.checklist_note = :id
", ["id" => $id]);
        $data = $query->fetchAll();
        $results = [];

        foreach ($data as $row) {
            // Ajouter une note au tableau
            $results[] = $row['content'];
        }

        return $results;
    }
    public function validate() : array {
        $error = [];
        
        return $error;
    }

    public function persist(){

    }

    public function delete(){

    }
    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getChecklistNote(): int
    {
        return $this->checklist_note;
    }

    public function setChecklistNote(int $checklist_note): void
    {
        $this->checklist_note = $checklist_note;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function getChecked(): int
    {
        return $this->checked;
    }

    public function setChecked(int $checked): void
    {
        $this->checked = $checked;
    }
}