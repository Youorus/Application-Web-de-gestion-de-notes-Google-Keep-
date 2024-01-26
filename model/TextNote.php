<?php


class TextNote extends Note {

    private ?string $content;

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function __construct(int $id, ?string $content) {
        parent::__construct($id, "", 0, new DateTime(), null, 0, 0, 0);
        $this->content = $content;
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
       return parent::getId();
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }



    public function setContent(?string $content): void
    {
        $this->content = $content;
    }

    public function getType(): NoteType
    {
        return  NoteType::TextNote;
    }


    public static function getTitleNote(int $id): string{
        $query = self::execute("SELECT notes.title from notes WHERE notes.id = :id", ["id" => $id]);
        $data = $query->fetchAll();
        $results = "";
        foreach ($data as $row){
            $results = $row['title'];
        }
        return $results;
    }

    public static function getContentNote(int $id): string|null{
        $query = self::execute("SELECT text_notes.content from text_notes WHERE text_notes.id = :id", ["id" => $id]);
        $data = $query->fetchAll();
        $results = "";
        foreach ($data as $row){
            $results = $row['content'];
        }
        return $results;
    }

    public static function getCreateDateTime(int $id): string{
        $query = self::execute("SELECT notes.created_at FROM notes WHERE notes.id = :id", ["id" => $id]);
        $data = $query->fetchAll();
        $results = "";
        foreach ($data as $row){
            $results = $row['created_at'];
        }
        return $results;
    }

    public static function geteditDateTime(int $id): string|null{
        $query = self::execute("SELECT notes.edited_at FROM notes WHERE notes.id = :id", ["id" => $id]);
        $data = $query->fetchAll();
        $results = "";
        foreach ($data as $row){
            $results = $row['edited_at'];
        }
        return $results;
    }

    public function getTitle(): string
    {
        $query = self::execute("SELECT notes.title from notes WHERE notes.id = :id", ["id" => $this->getId()]);
        $data = $query->fetchAll();
        $results = "";
        foreach ($data as $row){
            $results = $row['title'];
        }
        return $results;
    }
}