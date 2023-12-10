<?php

require_once "framework/Model.php";

class TextNote extends Model{

    private int $id;
    private ?string $content;

    public function __construct(int $id, ?string $content)
    {
        $this->id = $id;
        $this->content = $content;
    }

    public static function get_All_note_content_by_id(int $id): array {
        $query = self::execute("SELECT * 
FROM text_notes
JOIN notes ON text_notes.id = notes.id
JOIN users ON notes.owner = users.id
WHERE users.id = :id", ["id" => $id]);
        $data = $query->fetchAll();
        $results = [];

        foreach ($data as $row) {
            $content = $row['content'] ?? null;

            // Ajouter une note au tableau
            $results[] = new TextNote(
                $row["id"],
                $row["content"],
            );
        }

        return $results;
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
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): void
    {
        $this->content = $content;
    }
}