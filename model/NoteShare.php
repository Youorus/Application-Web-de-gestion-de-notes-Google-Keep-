<?php
require_once "framework/Model.php";
require_once "model/Note.php"; 

class NoteShare {
private int $noteid;
private int $user;
private int $editor;

public function __construct(int $note, int $editor, int $user) {
$this->noteid = $note;
$this->editor = $editor;
$this->user = $user;
}

public function validate(): array {
$error = [];

return $error;
}

public function persist() {
    $query = "INSERT INTO note_shares (note, user, editor) VALUES (:note, :user, :editor) ON DUPLICATE KEY UPDATE editor = :editor";
        self::execute($query, ['note' => $this->note->getId(), 'user' => $this->user, 'editor' => $this->editor]);
        return $this;
}

//public function delete() {
//    $query = "DELETE FROM note_shares WHERE note = :note AND user = :user";
//    self::execute($query, ['note' => $this->note->getId(), 'user' => $this->user]);
//}

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

}
