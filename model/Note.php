<?php

require_once "framework/Model.php";
require_once "User.php";

class Note extends Model{

    private int $id;
    private string $title;
    private int $owner;
    private ?DateTime $dateTime;
    private ?DateTime $dateTime_edit;
    private int $pinned;
    private int $archived;
    private int $weight;

    public function __construct(
        $id,
        $title,
        $owner,
        ?DateTime $dateTime,
        ?DateTime $dateTime_edit,
        $pinned,
        $archived,
        $weight
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->owner = $owner;
        $this->dateTime = $dateTime;
        $this->dateTime_edit = $dateTime_edit;
        $this->pinned = $pinned;
        $this->archived = $archived;
        $this->weight = $weight;
    }


    public static function get_All_note_by_id(int $id): array {
        $query = self::execute("SELECT * FROM notes JOIN users ON notes.owner = users.id WHERE users.id = :id", ["id" => $id]);
        $data = $query->fetchAll();
        $results = [];

        foreach ($data as $row) {
            $dateTime = isset($row['dateTime']) ? new DateTime($row['dateTime']) : null;
            $dateTimeEdit = isset($row['dateTime_edit']) ? new DateTime($row['dateTime_edit']) : null;

            // Utiliser les valeurs par défaut si les clés ne sont pas définies
            $pinned = $row['pinned'] ?? null;
            $archived = $row['archived'] ?? null;
            $weight = $row['weight'] ?? null;

            // Ajouter une note au tableau
            $results[] = new Note(
                $row["id"],
                $row["title"],
                $row["owner"],
                $dateTime,
                $dateTimeEdit,
                $pinned,
                $archived,
                $weight
            );
        }

        return $results;
    }


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

    public function getTitle(): string
    {
        return $this->title;
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

