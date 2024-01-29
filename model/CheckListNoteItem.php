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

    public function persist(): CheckListNoteItem {
        // Logique de persistance ici si nécessaire
        if ($this->id) {
            // Si l'élément de la liste de contrôle a déjà un ID, il existe déjà dans la base de données
            // Vous pouvez mettre à jour l'élément existant
            self::execute("UPDATE checklist_note_items SET content = :content, checked = :checked WHERE id = :id", [
                "content" => $this->content,
                "checked" => $this->checked,
                "id" => $this->id
            ]);
        } else {
            // Sinon, il s'agit d'un nouvel élément, vous pouvez l'insérer dans la base de données
            self::execute("INSERT INTO checklist_note_items (checklist_note, content, checked) VALUES (:checklist_note, :content, :checked)", [
                "checklist_note" => $this->checklist_note,
                "content" => $this->content,
                "checked" => $this->checked
            ]);

            // Mettez à jour l'ID de l'objet avec l'ID généré par la base de données
            $this->id = self::lastInsertId();
        }
        return $this;
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