<?php

require_once "framework/Model.php";
require_once "User.php";
require_once "CheckListNote.php";

enum NoteType {
    case TextNote;
    case ChecklistNote;
}

abstract  class Note extends Model{


    private int $id;
    private string $title;
    private int $owner;
    private DateTime $dateTime;
    private ?DateTime $dateTime_edit;
    private int $pinned;
    private int $archived;

    private int $weight;
    public function __construct(
        $id,
        $title,
        $owner,
         $dateTime,
         $dateTime_edit,
        $pinned,
        $archived,
        $weight
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->owner = $owner;
        $this->dateTime = $dateTime;
        $this->dateTime_edit = $dateTime_edit ;
        $this->pinned = $pinned;
        $this->archived = $archived;
        $this->weight = $weight;
    }
    public static function get_All_notes_by_id(int $id, bool $pinned): array {
        $pinnedValue = $pinned ? 1 : 0;
        $query = self::execute("SELECT notes.id FROM notes JOIN users ON users.id = notes.owner WHERE users.id = :id AND notes.pinned = :pinned ORDER BY notes.weight", ["id" => $id, "pinned" => $pinnedValue]);
        $data = $query->fetchAll();
        $results = [];

        foreach ($data as $row) {
            $queryNote = self::execute("SELECT text_notes.id, text_notes.content FROM text_notes WHERE text_notes.id = :id", ["id" => $row['id']]);
            $dataNote = $queryNote->fetchAll();


            if ($queryNote->rowCount() > 0) {
                foreach ($dataNote as $rowNote) {
                    $results[] = new TextNote(
                        $rowNote['id'],
                        $rowNote['content']
                    );
                }
            } else {
                        $queryChecklistNote = self::execute("SELECT checklist_notes.id FROM checklist_notes where checklist_notes.id = :id ", ["id" => $row['id']]);
                $dataChecklistNote = $queryChecklistNote->fetchAll();
                if ($queryChecklistNote->rowCount() > 0) {
                    foreach ($dataChecklistNote as $rowChecklistNote) {
                        $results[] = new CheckListNote(
                            $rowChecklistNote['id']
                        );
                    }
                }
            }
        }
        return $results;
    }



    abstract public function getType(): NoteType;


    public function validate() : array {
        $error = [];
        /*if(!User::get_user_by_mail($this->full_name)){
        }*/
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


    public function getOwner(): int
    {
        return $this->owner;
    }

    public function getDateTime(): DateTime
    {
        return $this->dateTime;
    }

    public function getDateTimeEdit(): DateTime
    {
        return $this->dateTime_edit;
    }

    public function getPinned(): int
    {
        return $this->pinned;
    }

    public function getArchived(): int
    {
        return $this->archived;
    }

    public function getWeight(): int
    {
        return $this->weight;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function setOwner(int $owner): void
    {
        $this->owner = $owner;
    }

    public function setDateTime(DateTime $dateTime): void
    {
        $this->dateTime = $dateTime;
    }

    public function setDateTimeEdit(DateTime $dateTime_edit): void
    {
        $this->dateTime_edit = $dateTime_edit;
    }

    public function setPinned(int $pinned): void
    {
        $this->pinned = $pinned;
    }

    public function setArchived(int $archived): void
    {
        $this->archived = $archived;
    }

    public function setWeight(int $weight): void
    {
        $this->weight = $weight;
    }



}

