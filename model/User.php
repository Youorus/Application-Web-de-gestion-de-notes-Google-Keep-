<?php
require_once "framework/Model.php";
class User extends Model{
    private int  $id;
    private string $mail;
    private string $full_name;
    private string $role;
    private String $hashed_password;
    public function __construct($mail,$hashed_password, $full_name, $role, $id=NULL){
        $this->id = $id;
        $this->mail = $mail;
        $this->hashed_password = $hashed_password;
        $this->full_name = $full_name;
        $this->role = $role;

    }
    public static function get_user_by_mail(string $mail) : User|false {
        $query = self::execute("SELECT * FROM Users where mail = :mail", ["mail"=>$mail]);
        $data = $query->fetch(); // un seul résultat au maximum
        if ($query->rowCount() == 0) {
            return false;
        } else {
            return new User($data["mail"], $data["hashed_password"], $data["full_name"], $data["role"], $data["id"]);
        }
    }
    private static function check_password(string $clear_password, string $hash) : bool {
        return $hash === Tools::my_hash($clear_password);
    }
    public static function validate_login(string $mail, string $password) : array {
        $errors = [];
        $user = User::get_user_by_mail($mail);
        if ($user) {
            if (!self::check_password($password, $user->hashed_password)) {
                $errors[] = "Wrong password. Please try again.";
            }
        } else {
            $errors[] = "Can't find a User with the email '$mail'. Please sign up.";
        }
        return $errors;
    }

    public function get_All_notes(bool $pinned, int $archive = 0): array
    {
        $pinnedValue = $pinned ? 1 : 0;

        $query = self::execute("SELECT notes.id FROM notes WHERE notes.owner = :id AND notes.pinned = :pinned AND notes.archived = :archive ORDER BY notes.weight", [
            "id" => $this->id,
            "pinned" => $pinnedValue,
            "archive" => $archive
        ]);

        $data = $query->fetchAll();
        $results = [];

        foreach ($data as $row) {
            $queryNote = self::execute("SELECT text_notes.id, text_notes.content FROM text_notes WHERE text_notes.id = :id", ["id" => $row['id']]);
            $dataNote = $queryNote->fetchAll();

            if ($queryNote->rowCount() > 0) {
                foreach ($dataNote as $rowNote) {
                    $results[] = new TextNote(
                        $rowNote['id'],
                        $rowNote['content']
                    );
                }
            } else {
                $queryChecklistNote = self::execute("SELECT checklist_notes.id FROM checklist_notes WHERE checklist_notes.id = :id", ["id" => $row['id']]);
                $dataChecklistNote = $queryChecklistNote->fetchAll();

                if ($queryChecklistNote->rowCount() > 0) {
                    foreach ($dataChecklistNote as $rowChecklistNote) {
                        $results[] = new CheckListNote(
                            $rowChecklistNote['id']
                        );
                    }
                }
            }
        }

        return $results;
    }

    public function get_User(bool $pinned, int $archive = 0): array
    {

    }

    public  function get_All_notesArchived(): array {

        $query = self::execute("SELECT notes.id FROM notes JOIN users ON users.id = notes.owner WHERE users.id = :id  AND notes.archived = 1 ORDER BY notes.weight", [
            "id" => $this->id,
        ]);

        $data = $query->fetchAll();
        $results = [];

        foreach ($data as $row) {
            $queryNote = self::execute("SELECT text_notes.id, text_notes.content FROM text_notes WHERE text_notes.id = :id", ["id" => $row['id']]);
            $dataNote = $queryNote->fetchAll();

            if ($queryNote->rowCount() > 0) {
                foreach ($dataNote as $rowNote) {
                    $results[] = new TextNote(
                        $rowNote['id'],
                        $rowNote['content']
                    );
                }
            } else {
                $queryChecklistNote = self::execute("SELECT checklist_notes.id FROM checklist_notes WHERE checklist_notes.id = :id", ["id" => $row['id']]);
                $dataChecklistNote = $queryChecklistNote->fetchAll();

                if ($queryChecklistNote->rowCount() > 0) {
                    foreach ($dataChecklistNote as $rowChecklistNote) {
                        $results[] = new CheckListNote(
                            $rowChecklistNote['id']
                        );
                    }
                }
            }
        }

        return $results;
    }


    public function get_UserShares_Notes(){
        $query = self::execute("SELECT DISTINCT users.full_name FROM note_shares JOIN users on users.id = note_shares.user WHERE note_shares.note in(
        select note_shares.note FROM note_shares WHERE note_shares.user = :id ) and note_shares.user != :id", [
            "id" => $this->id,
        ]);
        $data = $query->fetchAll();
        $results =[];
        if ($query->rowCount() > 0) {
            foreach ($data as $row) {
                $results[] = $row['full_name'];

            }
        }
        return $results;
    }

    public function persist(): User {

        if (self::get_user_by_mail($this->mail)) {
            self::execute("UPDATE users SET hashed_password = :hashed_password, full_name = :full_name, role = :role WHERE mail = :mail",
                ["mail" => $this->mail, "hashed_password" => $this->hashed_password, "full_name" => $this->full_name, "role" => $this->role]);
        } else {
            self::execute("INSERT INTO users (mail, hashed_password, full_name, role) VALUES (:mail, :hashed_password, :full_name, :role)",
                ["mail" => $this->mail, "hashed_password" => $this->hashed_password, "full_name" => $this->full_name, "role" => $this->role]);

            $this->id = self::lastInsertId();
        }
        return $this;
    }
    public function validate() : array

    {
        $errors = [];
        if(!strlen($this->full_name) >= 3) {
            $errors[] = "Le nom doit contenir au moins 3 caractères";
        }
        return $errors;

    }

    public static function validate_unicity($email): array {
        $errors = [];
        $user = self::get_user_by_mail($email);
        if ($user) {
            $errors[] = "Une adresse email existe déjà";
        }
        return $errors;

    }

    public static function validate_passwords ($password, $confirmpassword) : array {

        $errors = [];
        if($password != $confirmpassword) {
            $errors[] = "les mots de passes ne correspondent pas";
        }
        return $errors;
    }





    public function getId(): int
    {
        return $this->id;
    }

    public function getMail(): string
    {
        return $this->mail;
    }

    public function getName(): string
    {
        return $this->full_name;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function getHashedPassword(): string
    {
        return $this->hashedPassword;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setMail(string $mail): void
    {
        $this->mail = $mail;
    }

    public function setName(string $full_name): void
    {
        $this->full_name = $full_name;
    }

    public function setRole(string $role): void
    {
        $this->role = $role;
    }

    public function setHashedPassword(string $hashedPassword): void
    {
        $this->hashedPassword = $hashedPassword;
    }


}
