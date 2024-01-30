<?php
require_once "framework/Model.php";
require_once "User.php";

enum NoteType {
    case TextNote;
    case ChecklistNote;
}

abstract class Note extends Model {
    private int $id;
    private string $title;
    private int $owner;
    private DateTime $dateTime;
    private ?DateTime $dateTime_edit;
    private int $pinned;
    private int $archived;
    private int $weight;

    public function __construct(
        int $id,
        string $title,
        int $owner,
        DateTime $dateTime,
        ?DateTime $dateTime_edit,
        int $pinned,
        int $archived,
        int $weight
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->owner = $owner;
        $this->dateTime = $dateTime;
        $this->dateTime_edit = $dateTime_edit;
        $this->pinned = $pinned;
        $this->archived = $archived;
        $this->weight = $weight;
    }

    abstract public function getType(): NoteType;

    public function isArchived(): bool{
        $query = self::execute("SELECT notes.archived FROM notes  WHERE notes.id = :id", ["id" => $this->id]);
        $data = $query->fetch();
        $result = false;
        if ($data[0] > 0){
            $result = true;
        }
        return $result;
    }

    public function isShared(): bool{
        $query = self::execute("SELECT COUNT(*) FROM `note_shares` WHERE note_shares.note = :id", ["id" => $this->id]);
        $data = $query->fetch();
        $result = false;
        if ($data[0] > 0){
            $result = true;
        }
        return $result;
    }

    public function isPinned(): bool{
        $query = self::execute("SELECT notes.pinned FROM notes  WHERE notes.id = :id", ["id" => $this->id]);
        $data = $query->fetch();
        $result = false;
        if ($data[0] > 0){
            $result = true;
        }
        return $result;
    }

    public function validate(): array {
        $error = [];
        // Validation logique ici si nécessaire
        return $error;
    }

    public function delete(): void {
        self::execute("DELETE FROM notes WHERE id = :id", ["id" => $this->getId()]);

    }

    public function getId(): int {
        return $this->id;
    }

    public function getOwner(): int {
        return $this->owner;
    }

    public function getDateTime(): DateTime {
        $query = self::execute("SELECT notes.created_at FROM notes WHERE notes.id = :id", ["id" => $this->id]);
        $data = $query->fetchAll();

        // Vérifier s'il y a des données avant d'itérer sur $data
        if (!empty($data)) {
            $row = $data[0]; // Prendre la première ligne des résultats

            // Convertir la chaîne de date en objet DateTime
            $dateTime = new DateTime($row['created_at']);
            return $dateTime;
        }

        // Si aucune donnée n'est trouvée, retourner un objet DateTime par défaut
        return new DateTime();
    }

    public static function get_textnote_by_id(int $id): TextNote | false {
        $query = self::execute("SELECT * FROM text_notes WHERE id = :id", ["id" => $id]);
        $data = $query->fetch();
        if ($query->rowCount() == 0) {
            return false;
        } else {
            return new TextNote($data["id"], $data["content"]
            );
        }
    }


    public static function get_checklistnote_by_id(int $id) : CheckListNote | false {
        $query = self::execute("select * FROM checklist_notes where id = :id", ["id"=>$id]);
        $data = $query->fetch(); // un seul résultat au maximum
        if ($query->rowCount() == 0) {
            return false;
        } else {
            return new CheckListNote($data["id"], $data["title"], User::get_user_by_id($data["owner"]), $data["created_at"], $data["edited_at"], $data["pinned"], $data["archived"], $data["weight"]);
        }
    }

    public function getDateTimeEdit(): ?DateTime {
        $query = self::execute("SELECT notes.edited_at FROM notes WHERE notes.id = :id", ["id" => $this->id]);
        $data = $query->fetchAll();

        // Vérifier s'il y a des données avant d'itérer sur $data
        if (!empty($data)) {
            $row = $data[0]; // Prendre la première ligne des résultats

            // Vérifier si la valeur de 'edited_at' est null
            if ($row['edited_at'] !== null) {
                // Convertir la chaîne de date en objet DateTime
                return new DateTime($row['edited_at']);
            }
        }

        // Si aucune donnée n'est trouvée ou si 'edited_at' est null, retourner null
        return null;
    }

    public function getPinned(): int {
        return $this->pinned;
    }

    public function getArchived(): int {
        return $this->archived;
    }

    public function getWeight(): int {
        return $this->weight;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function setTitle(string $title): void {
        $this->title = $title;
    }

    public function setOwner(int $owner): void {
        $this->owner = $owner;
    }

    public function setDateTime(DateTime $dateTime): void {
        $this->dateTime = $dateTime;
    }

    public function setDateTimeEdit(?DateTime $dateTime_edit): void {
        $this->dateTime_edit = $dateTime_edit;
    }

    public function setPinned(int $pinned): void {
        $this->pinned = $pinned;
    }

    public function setArchived(int $archived): void {
        $this->archived = $archived;
    }

    public function setWeight(int $weight): void {
        $this->weight = $weight;
    }

    public function getTitle(): string
    {
        $query = self::execute("SELECT notes.title from notes WHERE notes.id = :id", ["id" => $this->id]);
        $data = $query->fetchAll();
        $results = "";
        foreach ($data as $row){
            $results = $row['title'];
        }
        return $results;
    }

}
