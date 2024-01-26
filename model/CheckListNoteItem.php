<?php

require_once "CheckListNote.php";

class CheckListNoteItem extends CheckListNote {
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