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


    public static function get_noteShare_byID(int $id): NoteShare | false {
        $query = self::execute("SELECT * FROM note_shares WHERE id = :id", ["id" => $id]);
        $data = $query->fetch();
        if ($query->rowCount() == 0) {
            return false;
        } else {
            return new NoteShare($data["note"], $data["editor"], $data["user"]);
        }
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
