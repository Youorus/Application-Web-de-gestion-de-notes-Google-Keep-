<?php
require_once "framework/Model.php";
require_once "model/Note.php"; 

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
    $query = "INSERT INTO note_shares (note, user, editor) VALUES (:note, :user, :editor) ON DUPLICATE KEY UPDATE editor = :editor";
        self::execute($query, ['note' => $this->note->getId(), 'user' => $this->user, 'editor' => $this->editor]);
        return $this;
}

public function delete() {
    $query = "DELETE FROM note_shares WHERE note = :note AND user = :user";
    self::execute($query, ['note' => $this->note->getId(), 'user' => $this->user]);
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

public function getType(): string {
        $noteId = $this->note->getId();

        $query = "SELECT COUNT(*) FROM checklist_note_items WHERE note_id = :id";
        $result = self::execute($query, ["id" => $noteId]);
        $count = $result->fetchColumn();

        return $count > 0 ? 'checklist' : 'standard';
        
}



}
