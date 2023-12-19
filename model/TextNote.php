<?php

require_once "framework/Model.php";

class TextNote extends Note {

    private int $id;
    private ?string $content;

    public function __construct(int $id, ?string $content)
    {
        $this->id = $id;
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

    public function getType(): NoteType
    {
        return  NoteType::TextNote;
    }


}