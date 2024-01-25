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
        $query = self::execute("SELECT notes.create_at from notes where notes.id = :id", ["id" => $this->id]);
        $data = $query->fetch();
        if ($data) {
            return new DateTime($data['create_at']);
        } else {
            return new DateTime();
        }
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