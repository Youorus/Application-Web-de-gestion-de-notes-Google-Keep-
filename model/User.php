<?php
require_once "framework/Model.php";
class User extends Model{
    private int  $id;
    private string $mail;
    private string $name;
    private string $role;
    private String $hashed_password;
    public function __construct($id, $mail,$hashed_password, $name, $role){
        $this->id = $id;
        $this->mail = $mail;
        $this->hashed_password = $hashed_password;
        $this->name = $name;
        $this->role = $role;

    }
    public static function get_user_by_mail(string $mail) : User|false {
        $query = self::execute("SELECT * FROM Users where mail = :mail", ["mail"=>$mail]);
        $data = $query->fetch(); // un seul résultat au maximum
        if ($query->rowCount() == 0) {
            return false;
        } else {
            return new User($data["id"],$data["mail"], $data["hashed_password"], $data["full_name"], $data["role"]);
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
        return $this->name;
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

    public function setName(string $name): void
    {
        $this->name = $name;
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
