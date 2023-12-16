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
        $query = self::execute("SELECT text_notes.id AS text_note_id, text_notes.content AS text_content
FROM text_notes
JOIN notes ON text_notes.id = notes.id
JOIN users ON notes.owner = users.id
WHERE users.id = :id order by notes.weight", ["id" => $id]);
        $data = $query->fetchAll();
        $results = [];

        foreach ($data as $row) {
            $textNoteId = $row['text_note_id'];
            $textContent = $row['text_content'] ?? null;

            // Ajouter une note de texte au tableau
            $results[] = new TextNote(
                $textNoteId,
                $textContent,
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