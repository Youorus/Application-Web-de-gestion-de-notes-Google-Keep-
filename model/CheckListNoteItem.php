<?php

require_once "CheckListNote.php";

class CheckListNoteItem extends Model {
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



    public function validate() : array {
        $error = [];
        
        return $error;
    }

    public function getType(): NoteType
    {
        return  NoteType::ChecklistNote;
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

    public function persist(): void {
        if ($this->id) {
            // Mise à jour de l'item existant
            self::execute("UPDATE checklist_note_items SET checklist_note = :checklist_note, content = :content, checked = :checked WHERE id = :id",
                [
                    'id' => $this->id,
                    'checklist_note' => $this->checklist_note,
                    'content' => $this->content,
                    'checked' => $this->checked
                ]);
        } else {
            self::execute("INSERT INTO checklist_note_items (checklist_note, content, checked) VALUES (:checklist_note, :content, :checked)",
                [
                    'checklist_note' => $this->checklist_note,
                    'content' => $this->content,
                    'checked' => $this->checked
                ]);
            $this->id = self::lastInsertId();
        }
    }

}