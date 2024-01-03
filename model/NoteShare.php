<?php
require_once "framework/Model.php";
require_once "path_to/Note.php"; // Assurez-vous de spécifier le bon chemin vers votre classe Note

class NoteShare extends Model {
private Note $note;
private int $user;
private int $editor;

public function __construct(Note $note, int $editor, int $user) {
$this->note = $note;
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
