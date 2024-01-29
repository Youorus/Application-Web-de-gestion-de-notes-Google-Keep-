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

    public static function isArchived(int $id): bool{
        $query = self::execute("SELECT notes.archived from notes WHERE notes.id = :id", ["id" => $id]);
        $data = $query->fetchAll();
        $results = "";
        foreach ($data as $row){
            $results = $row['archived'];
        }
        if (intval($results) == 0 )
            return false;
        return true;
    }

    public static function isShared(int $id): bool{
        $query = self::execute("SELECT COUNT(*) FROM `note_shares` WHERE note_shares.note = :id", ["id" => $id]);
        $data = $query->fetch();
        $result = false;
        if ($data[0] > 0){
            $result = true;
        }
        return $result;
    }

    public function ispinned(): bool{
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

    public function persist(): Note {

        if (self::getNoteById($this->id)) {
            // Si la note existe, mettez à jour les informations
            self::execute("UPDATE notes SET title = :title, owner = :owner, created_at = :created_at, edited_at = :edited_at, pinned = :pinned, archived = :archived, weight = :weight WHERE id = :id", [
                "title" => $this->title,
                "owner" => $this->owner,
                "created_at" => $this->dateTime,
                " edited_at" => $this->dateTime_edit,
                "pinned" => $this->pinned,
                "archived" => $this->archived,
                "weight" => $this->weight,
                "id" => $this->id
            ]);
        } else {
            // Si la note n'existe pas
            self::execute("INSERT INTO notes (id, title, owner, created_at, edited_at, pinned, archived, weight) VALUES (:id, :title, :owner, :created_at, NULL, :pinned, :archived, :weight)", [
                "id" => $this->id,
                "title" => $this->title,
                "owner" => $this->owner,
                "created_at" => $this->dateTime->format('Y-m-d H:i:s'), // Formatage de la date
                "pinned" => $this->pinned,
                "archived" => $this->archived,
                "weight" => $this->weight
            ]);
        }

        return $this;
    }


    public static function getNoteById(int $noteId): ?Note {
        $query = self::execute("SELECT * FROM notes WHERE id = :id", ["id" => $noteId]);
        $data = $query->fetch();

        if ($data) {
            $note = null;

            // Vérifier le type de la note (TextNote ou ChecklistNote)
            if ($data['type'] === NoteType::TextNote) {
                $note = new TextNote(
                    $data['id'],
                    $data['content']
                );
            } elseif ($data['type'] === NoteType::ChecklistNote) {
                $note = new CheckListNote(
                    $data['id']
                );
            }

            // Remplir les propriétés communes
            $note->setTitle($data['title']);
            $note->setOwner($data['owner']);
            $note->setDateTime(new DateTime($data['created_at']));
            $note->setDateTimeEdit($data['edited_at'] ? new DateTime($data['edited_at']) : null);
            $note->setPinned($data['pinned']);
            $note->setArchived($data['archived']);
            $note->setWeight($data['weight']);

            return $note;
        }

        // Si la note n'est pas trouvée, retourner null
        return null;
    }


    public function delete() {
        // Logique de suppression ici si nécessaire
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
