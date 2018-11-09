<?php
/**************************************************************************************
Fichier :       UserType.class.php
Auteur :        Antoine Gagnon
Fonctionnalité : Classe réprésentant un type d'utilisateur
                se gère aussi sois même dans la base de donnée
Date :          2018-04-26
=======================================================================================
Vérification :
Date        Nom	                    Approuvé
2018-05-06  Olivier Lemay Dostie    Oui
=======================================================================================
Historique de modifications :
Date        Nom	                    Description
2018-04-29	Olivier Lemay Dostie    Merge update
=======================================================================================
**************************************************************************************/

/**
 * Classe UserType
 */
class UserType
{
    const USERTYPE_TABLE = 'user_type';
    const NAME_FIELD = 'name';
    const DESCRIPTION_FIELD = 'description';
    const PERMISSION_FIELD = 'permission_level';

    /**
     * @var int L'ID du type d'utilisateur
     */
    private $id;

    /**
     * @var string le nom du type d'utilisateur
     */
    private $name;

    /**
     * @var string la description de ce type
     */
    private $description;

    /**
     * @var int le niveau de permission de ce type d'utilisateur
     */
    private $permissionLevel;

    /**
     * UserType constructor.
     * @param $id
     * @param $name
     * @param $description
     */
    protected function __construct(int $id, string $name, string $description, int $permissionLevel)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->permissionLevel = $permissionLevel;
    }

    public static function fromID($id) {
        $conn = SQLConnector::createConn();
        if ($stm = $conn->prepare("SELECT * FROM user_type WHERE id = ?")) {
            $stm->bind_param("i", $id);
            $stm->execute();

            $result = $stm->get_result();

            if (mysqli_num_rows($result) == 1) {
                $row = $result->fetch_assoc();
                $conn->close();
                return new UserType($row['id'], $row[self::NAME_FIELD], $row[self::DESCRIPTION_FIELD], $row[self::PERMISSION_FIELD]);
            }
        }
        $conn->close();
        return null;
    }

    public static function newUserType(string $name, string $description, int $level) {
        $conn = SQLConnector::createConn();
        if ($stm = $conn->prepare("INSERT INTO user_type (name, description, permission_level) VALUES (?,?,?)")) {
            $stm->bind_param("ssi", $name, $description, $level);
            $stm->execute();
            $id = $conn->insert_id;
            return new UserType($id, $name, $description, $level);
        }
        $conn->close();
    }

    public static function getAllTypes() {
        $types = [];
        $conn = SQLConnector::createConn();
        if ($stm = $conn->prepare("SELECT * FROM user_type")) {
            $stm->execute();

            $result = $stm->get_result();

            while ($row = $result->fetch_assoc()) {
                array_push($types,
                    new UserType($row['id'], $row[self::NAME_FIELD], $row[self::DESCRIPTION_FIELD], $row[self::PERMISSION_FIELD])
                );
            }
        }
        $conn->close();
        return $types;
    }

    /**
     * @return int l'ID du type
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id assigne un ID au type
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string le nom du type
     */
    public function getName(): string
    {
        return $this->getDB(self::NAME_FIELD);
    }

    /**
     * @param string $name assigne un nom au type
     */
    public function setName(string $name): void
    {
        $this->name = $name;
        $this->setDB(self::NAME_FIELD, $name);
    }

    /**
     * @return string la description du type
     */
    public function getDescription(): string
    {
        return $this->getDB(self::DESCRIPTION_FIELD);
    }

    /**
     * @param string $description assigne une description au titre
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
        $this->setDB(self::DESCRIPTION_FIELD, $description);
    }

    /**
     * @return int
     */
    public function getPermissionLevel(): int
    {
        return $this->getDB(self::PERMISSION_FIELD);
    }

    /**
     * @param int $permissionLevel
     */
    public function setPermissionLevel(int $permissionLevel): void
    {
        $this->permissionLevel = $permissionLevel;
        $this->setDB(self::PERMISSION_FIELD, $permissionLevel);
    }

    private function setDB($field, $value): void {
        $conn = SQLConnector::createConn();

        $field = mysqli_real_escape_string($conn, $field);

        if ($stm = $conn->prepare("UPDATE ". self::USERTYPE_TABLE ." SET ". $field . "= ? WHERE id = ?")) {
            $stm->bind_param("si",  $value, $this->id);
            $stm->execute();
        }
        $conn->close();
    }

    private function getDB($field) {
        $conn = SQLConnector::createConn();

        $field = mysqli_real_escape_string($conn, $field);

        if ($stm = $conn->prepare("SELECT ". $field ." FROM ". self::USERTYPE_TABLE . " WHERE id = ?")) {
            $stm->bind_param("i",  $this->id);
            $stm->execute();

            $result = $stm->get_result();

            if (mysqli_num_rows($result) == 1) {
                $row = $result->fetch_assoc();
                $conn->close();
                return $row[$field];
            }
        }
        $conn->close();
        return null;
    }
}