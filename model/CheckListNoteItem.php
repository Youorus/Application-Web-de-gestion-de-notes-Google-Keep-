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

    public function persist(): CheckListNoteItem | array {
        if (self::get_item_by_id($this->id)) {
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
        return $this;
    }

    public function check_uncheck(): void {
        if($this->getChecked() == 0) {
            $this->setChecked(1);
        } else {
            $this->setChecked(0);
        }
    }

    public static function get_item_by_id(int $id): CheckListNoteItem | false {
        $query = self::execute("SELECT * FROM checklist_note_items WHERE id = :id", ["id" => $id]);
        $data = $query->fetch();
        if ($data) {
            return new CheckListNoteItem(
                id: $data['id'],
                checklist_note: $data['checklist_note'],
                content: $data['content'],
                checked: $data['checked']
            );
        } else {
            return false;
        }
    }





}