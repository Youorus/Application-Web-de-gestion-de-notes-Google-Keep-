<?php
require_once "model/Note.php";

class TextNote extends Note {

    private ?string $content;

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function __construct(int $id, ?string $content) {
        parent::__construct($id, " ", 0, new DateTime(), null, 0, 0, 0);
        $this->content = $content;
    }


    public static function validate(string $title): int
    {
        return parent::validateTitle($title); // TODO: Change the autogenerated stub
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
        $currentDateTime = new DateTime('now');
        // Vérifier si la note existe déjà dans la base de données
        if (!parent::get_textnote_by_id($this->getId())) {
            // Si la note n'existe pas, l'insérer dans la base de données
            $lastWeight = self::getLastWeightNote();
            // Insérer une nouvelle note dans 'notes'
            parent::execute(
                "INSERT INTO notes (title, owner, created_at, pinned, archived, weight) 
            VALUES (:title, :owner, :createdAt, :pinned, :archived, :weight)",
                [
                    'title' => $this->getTitleNote(),
                    'owner' => $this->getOwner(),
                    'createdAt' => $currentDateTime->format('Y-m-d H:i:s'),
                    'pinned' => $this->getPinned(),
                    'archived' => $this->getArchived(),
                    'weight' => $lastWeight + 1
                ]
            );
            $this->setId(parent::lastInsertId());
            // Insérer dans 'text_notes'
            parent::execute(
                "INSERT INTO text_notes (id, content) VALUES (:id, :content)",
                ['id' => $this->getId(), 'content' => $this->content]
            );
        } else {
            // Si la note existe, mettre à jour les données dans la base de données
            // Mettre à jour la note existante dans 'notes'
            parent::execute(
                "UPDATE notes SET title = :title, edited_at = :editedAt, owner = :owner,
            pinned = :pinned, archived = :archived WHERE id = :id",
                [
                    'id' => $this->getId(),
                    'title' => $this->getTitleNote(),
                    'owner'=> $this->getOwner(),
                    'editedAt' => $currentDateTime->format('Y-m-d H:i:s'), // Mise à jour de la date de modification
                    'pinned' => $this->getPinned(),
                    'archived' => $this->getArchived(),
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





    public function setContent(?string $content): void
    {
        $this->content = $content;
    }

    public function getType(): NoteType
    {
        return  NoteType::TextNote;
    }




//    public static function geteditDateTime(int $id): string|null{
//        $query = self::execute("SELECT notes.edited_at FROM notes WHERE notes.id = :id", ["id" => $id]);
//        $data = $query->fetchAll();
//        $results = "";
//        foreach ($data as $row){
//            $results = $row['edited_at'];
//        }
//        return $results;
//    }
//
//

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