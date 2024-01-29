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

    public function persist(): TextNote
    {
        // Vérifier si la note existe déjà dans la base de données
        $existingNote = self::execute("SELECT * FROM text_notes WHERE id = :id", ["id" => $this->getId()])->fetch();

        if ($existingNote) {
            // Si la note existe, mettez à jour les informations, y compris le contenu
            self::execute("UPDATE text_notes SET content = :content WHERE id = :id", [
                "content" => $this->content,
                "id" => $this->getId()
            ]);
        } else {
            // Si la note n'existe pas, insérez une nouvelle ligne
            self::execute("INSERT INTO text_notes (id, content) VALUES (:id, :content)", [
                "id" => $this->getId(),
                "content" => $this->content
            ]);
        }
        return $this;
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




}