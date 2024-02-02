<?php
require_once "framework/Model.php";
require_once "path_to/Note.php"; // Assurez-vous de spécifier le bon chemin vers votre classe Note

class NoteShare extends Note {
private int $noteid;
private int $user;
private int $editor;

public function __construct(int $note, int $editor, int $user) {
    parent::__construct($note, "", 0, new DateTime(), null, 0, 0, 0);
$this->noteid = $note;
$this->editor = $editor;
$this->user = $user;
}

public function validate(): array {
$error = [];

return $error;
}

public function persist() {

}

public function delete() {

}

public function getNote(): Note {
return $this->note;
}

public function setNote(Note $note): void {
$this->note = $note;
}

public function getUser(): int {
return $this->user;
}

public function setUser(int $user): void {
$this->user = $user;
}

public function getEditor(): int {
return $this->editor;
}

public function setEditor(int $editor): void {
$this->editor = $editor;
}

public function getType(): NoteType {

return $this->note->getType();
}

}
