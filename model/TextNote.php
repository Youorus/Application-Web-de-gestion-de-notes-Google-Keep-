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


//        if($this->getId()){
//            self::execute("UPDATE notes SET content = :content  WHERE id = :id",
//        ["id" => $this->getId(), "content" => $this->content]);
//
//
//        }else{
//            self::execute("INSERT INTO notes(content) VALUES (:content)",
//            ["content" => $this->content]);
//
//            $this->setId(self::lastInsertId());
//        }
//        return $this;
//    }

   




    public function persist(): TextNote | array {
        $errors = $this->validate();
        if (!empty($errors)) {
            return $errors;
        }

        if (!parent::get_textnote_by_id($this->getId())) {
            // Insérer une nouvelle note dans 'notes'
            parent::execute(
                "INSERT INTO notes (title, owner, created_at, edited_at, pinned, archived, weight) 
             VALUES (:title, :owner, :createdAt, :editedAt, :pinned, :archived, :weight)",
                [
                    'title' => $this->getTitle(),
                    'owner' => $this->getOwner(),
                    'createdAt' => $this->getDateTime()->format('Y-m-d H:i:s'),
                    'editedAt' => $this->getDateTimeEdit()?->format('Y-m-d H:i:s'),
                    'pinned' => $this->getPinned(),
                    'archived' => $this->getArchived(),
                    'weight' => $this->getWeight()
                ]
            );
            $this->setId(parent::lastInsertId());

            // Insérer dans 'text_notes'
            parent::execute(
                "INSERT INTO text_notes (id, content) VALUES (:id, :content)",
                ['id' => $this->getId(), 'content' => $this->content]
            );
        } else {
            // Mettre à jour la note existante
            parent::execute(
                "UPDATE notes SET title = :title, edited_at = :editedAt, 
             pinned = :pinned, archived = :archived, weight = :weight WHERE id = :id",
                [
                    'id' => $this->getId(),
                    'title' => $this->getTitle(),
                    'editedAt' => $this->getDateTimeEdit()? $this->getDateTimeEdit()->format('Y-m-d H:i:s') : null,
                    'pinned' => $this->getPinned(),
                    'archived' => $this->getArchived(),
                    'weight' => $this->getWeight()
                ]
            );

            // Mettre à jour le contenu dans 'text_notes'
            parent::execute(
                "UPDATE text_notes SET content = :content WHERE id = :id",
                ['id' => $this->getId(), 'content' => $this->content]
            );
        }

        return $this;
    }


public function delete(): void
{
    self::execute("DELETE FROM text_notes WHERE id = :id", ["id" => $this->getId()]);
    parent::delete(); // TODO: Change the autogenerated stub
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