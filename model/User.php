<?php
require_once "framework/Model.php";
class User extends Model{
    private ?int  $id;

    public function getId(): ?int
    {
        return $this->id;
    }
    private string $mail;
    private string $full_name;


    private string $role;
    private String $hashed_password;
    public function __construct($id,$mail,$hashed_password, $full_name, $role){
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
            return new User($data["id"], $data["mail"], $data["hashed_password"], $data["full_name"], $data["role"]);

        }
    }

    public static function get_user_by_id(int $id) : User|false {
        $query = self::execute("SELECT * FROM Users WHERE id = :id", ["id" => $id]);
        $data = $query->fetch(); // Un seul résultat au maximum
        if ($query->rowCount() == 0) {
            return false;
        } else {
            return new User($data["id"], $data["mail"], $data["hashed_password"], $data["full_name"], $data["role"]);
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

        $query = self::execute("SELECT notes.id FROM notes WHERE notes.owner = :id AND notes.pinned = :pinned AND notes.archived = :archive ORDER BY notes.weight DESC ", [
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

    public function get_One_note_by_id(int $noteId)
    {
        // Récupérer les détails de la note textuelle
        $queryNote = self::execute("SELECT text_notes.id, text_notes.content FROM text_notes WHERE text_notes.id = :id", ["id" => $noteId]);
        $rowNote = $queryNote->fetch();

        if ($rowNote) {
            return new TextNote(
                $rowNote['id'],
                $rowNote['content']
            );
        }

        // Si la note textuelle n'est pas trouvée, essayer avec une note de liste de contrôle
        $queryChecklistNote = self::execute("SELECT checklist_notes.id FROM checklist_notes WHERE checklist_notes.id = :id", ["id" => $noteId]);
        $rowChecklistNote = $queryChecklistNote->fetch();

        if ($rowChecklistNote) {
            return new CheckListNote(
                $rowChecklistNote['id']
            );
        }

        return null; // Aucune note trouvée
    }

    public function title_exist(string $title): bool{
        $query = self::execute("SELECT COUNT(*) FROM notes WHERE notes.owner = :id AND notes.title = :title;", ["id" => $this->id, "title" => $title]);
        $data = $query->fetch();
        $result = false;
        if ($data[0] > 0){
            $result = true;
        }
        return $result;
    }

    public function get_All_shared_notes(int $userShare): array
    {
        $query = self::execute("
        SELECT note_shares.*
        FROM note_shares
        INNER JOIN notes ON notes.id = note_shares.note
        WHERE notes.owner = :loggedInUserId
          AND note_shares.user = :userShare
    ", [
            "loggedInUserId" => $this->id,
            "userShare" => $userShare
        ]);

        $data = $query->fetchAll();
        $results = [];

        foreach ($data as $row) {
            $queryNote = self::execute("
            SELECT notes.id, notes.title, text_notes.content
            FROM notes
            LEFT JOIN text_notes ON notes.id = text_notes.id
            WHERE notes.id = :id
        ", ["id" => $row['note']]);

            $dataNote = $queryNote->fetch();

            if ($dataNote) {
                if ($dataNote['content'] !== null) {
                    // Note textuelle
                    $results[] = new TextNote(
                        $dataNote['id'],
                        $dataNote['title'],
                        $dataNote['content'],
                        $row['editor'] // Ajoutez l'éditeur à la création de la note
                    );
                } else {
                    // Note de liste de contrôle
                    $results[] = new CheckListNote(
                        $dataNote['id'],
                        $dataNote['title'],
                        $row['editor'] // Ajoutez l'éditeur à la création de la note
                    );
                }
            }
        }

        return $results;
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

    public function getFullName(): string
    {
        return $this->full_name;
    }

    public static function getFullNameById(int $userId): string|null {
        $query = self::execute("SELECT full_name FROM users WHERE id = :id", ["id" => $userId]);
        $data = $query->fetch();

        if ($query->rowCount() > 0) {
            return $data["full_name"];
        } else {
            return null;
        }
    }



    public function get_UserShares_Notes(): array {
        $query = self::execute("SELECT DISTINCT users.* FROM users
JOIN note_shares on note_shares.user = users.id
WHERE note_shares.note IN
(SELECT DISTINCT note_shares.note
FROM note_shares
JOIN notes ON notes.id = note_shares.note
WHERE notes.owner = :id)", [
            "id" => $this->id,
        ]);

        $data = $query->fetchAll();
        $results = [];

        if ($query->rowCount() > 0) {
            foreach ($data as $userData) {
                $user = new User(
                    $userData['id'],
                    $userData['mail'],
                    $userData['hashed_password'],
                    $userData['full_name'],
                    $userData['role']
                );
                $results[] = $user;
            }
        }

        return $results;
    }

    public function getOtherUsers(): array {
        $query = self::execute("select * FROM users WHERE NOT users.id = :id", [
            "id" => $this->id,
        ]);

        $data = $query->fetchAll();
        $results = [];
        foreach ($data as $row) {
            // Accédez à la valeur 'full_name' de chaque ligne, pas de '$data'
            $results[] = new User(
                $row['id'],
                $row['mail'],
                $row['hashed_password'],
                $row['full_name'],
                $row['role']
            );;
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

    public function persist_mail() : User {
        if(self::get_user_by_id($this->getId())) {
            self::execute("UPDATE users SET mail = :mail, hashed_password = :hashed_password, full_name = :full_name, role = :role WHERE id = :id",
                ["id" => $this->id, "mail" => $this->mail, "hashed_password" => $this->hashed_password, "full_name" => $this->full_name, "role" => $this->role]);

        }
        return $this;
    }

    public static function validate($fullname) : array {
        $errors = [];
        if(strlen($fullname) < 3) {
            $errors[] = "Le nom doit contenir au moins 3 caractères.";
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

    public function verifyPassword(string $password): bool {
        return self::check_password($password, $this->hashed_password);
    }


    public static function validate_passwords ($password, $confirmpassword) : array {

        $errors = [];
        if($password != $confirmpassword) {
            $errors[] = "les mots de passes ne correspondent pas";
        }
        return $errors;
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
        $this->hashed_password = $hashedPassword;
    }

}
