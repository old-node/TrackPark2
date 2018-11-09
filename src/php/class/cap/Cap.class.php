<?php
/**************************************************************************************
Fichier :       Cap.class.php
Auteur :		Antoine Gagnon
Fonctionnalité : Classe représentant une casquette se gère sois-même dans
 * la base de données.
Date :          28 avril 2018
=======================================================================================
Vérification :
Date		Nom					    Approuvé
2018-05-06  Olivier Lemay Dostie    Oui
=======================================================================================
Historique de modification :
Date		Nom						Description
2018-04-28	Antoine Gagnon          Création
2018-05-04  Olivier Lemay Dostie    Mise a jour de l'historique et versionnement.
**************************************************************************************/

/**
 * Classe Cap
 */
class Cap
{
    const CAP_TABLE = 'cap';
    const CODE_FIELD = 'code';
    const NAME_FIELD = 'name';
    const DESCRIPTION_FIELD = 'description';
    const COLOR_FIELD = 'color';

    /**
     * @var string L'ID de la cap
     */
    private $code;

    /**
     * @var string le nom du type d'utilisateur
     */
    private $name;

    /**
     * @var string la description de ce type
     */
    private $description;

    /**
     * @var string le niveau de permission de ce type d'utilisateur
     */
    private $color;

    /**
     * UserType constructor.
     * @param $id
     * @param $name
     * @param $description
     */
    protected function __construct(string $id, string $name, $description = "", string $color)
    {
        $this->code = $id;
        $this->name = $name;
        if(!isset($description)) {
            $description = "";
        }
        $this->description = $description;
        $this->color = $color;
    }

    /**
     * Retrouve une casquette dans la base de donnée et retourne un instance de celle-ci
     * @param $code string le code de la casquette
     * @return Cap|null un instance de la casquette, null si aucune casquette n'éxiste pour le code
     */
    public static function fromID($code)
    {
        if(empty($code) || $code == 'Aucune')
        {
            return null;
        }
        $conn = SQLConnector::createConn();
        if ($stm = $conn->prepare("SELECT * FROM ".self::CAP_TABLE." WHERE code = ?")) {
            $stm->bind_param("s", $code);
            $stm->execute();

            $result = $stm->get_result();

            if (mysqli_num_rows($result) == 1) {
                $row = $result->fetch_assoc();
                $conn->close();
                return new Cap($row[self::CODE_FIELD], $row[self::NAME_FIELD], $row[self::DESCRIPTION_FIELD], $row[self::COLOR_FIELD]);
            }
        }
        $conn->close();
        return null;
    }

    /**
     * Crée une nouvelle casquette dans la base de donnée et retourne un instance de celle ci
     * @param string $code le code de la casquette
     * @param string $name le nom de la casquette
     * @param string $description la description de la casquette
     * @param string $color la couleur de la casquette
     * @return Cap instance de la nouvelle casquette
     */
    public static function newCap(string $code, string $name, string $description, string $color): Cap
    {
        $conn = SQLConnector::createConn();
        if ($stm = $conn->prepare("INSERT INTO ".self::CAP_TABLE." (code, name, description, color) VALUES (?,?,?,?)")) {
            $stm->bind_param("ssss", $code,$name, $description, $color);
            $stm->execute();
            $id = $conn->insert_id;
            return new Cap($id, $name, $description, $color);
        }
        $conn->close();
        return null;
    }

    /**
     * @return array tout les casquettes dans la base de donnée
     */
    public static function getAllCaps()
    {
        $caps = [];
        $conn = SQLConnector::createConn();
        if ($stm = $conn->prepare("SELECT * FROM ".self::CAP_TABLE/*." WHERE code <> Aucune"*/)) {
            $stm->execute();

            $result = $stm->get_result();

            while ($row = $result->fetch_assoc()) {
                array_push($caps,
                    new Cap($row[self::CODE_FIELD], $row[self::NAME_FIELD], $row[self::DESCRIPTION_FIELD], $row[self::COLOR_FIELD])
                );
            }
        }
        $conn->close();
        return $caps;
    }

    /**
     * Retire une casquette de la base de donnée
     * @param string $code le code de la casquette à retirer
     */
    public static function remove(string $code) {
        $conn = SQLConnector::createConn();
        if ($stm = $conn->prepare("DELETE FROM ".self::CAP_TABLE." WHERE code = ?")) {
            $stm->bind_param("s", $code);
            $stm->execute();
        }
        $conn->close();
    }

    /**
     * @return string l'ID du type
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @param string $code assigne un ID au type
     */
    public function setCode(string $code): void
    {
        $this->code = $code;
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
        $desc = $this->getDB(self::DESCRIPTION_FIELD);
        if (!isset($desc)) {
            return "";
        }
        return $desc;
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
     * @return string la couleur de la casquette
     */
    public function getColor(): string
    {
        return $this->getDB(self::COLOR_FIELD);
    }

    /**
     * Assigne une couleur à la casque
     * @param string $color la couleur à assigner
     */
    public function setColor(string $color): void
    {
        $this->color = $color;
        $this->setDB(self::COLOR_FIELD, $color);
    }

    /**
     * Assigne une valeur dans la base de donnée pour la casquette
     * @param string $field le champs à changer
     * @param mixed $value la valeur à mettre
     */
    private function setDB($field, $value): void
    {
        $conn = SQLConnector::createConn();

        $field = mysqli_real_escape_string($conn, $field);

        if ($stm = $conn->prepare("UPDATE " . self::CAP_TABLE . " SET " . $field . "= ? WHERE code = ?")) {
            $stm->bind_param("ss", $value, $this->code);
            $stm->execute();
        }
        $conn->close();
    }

    /**
     * Va chercher une valeur dans la base de donnée
     * @param string $field le champs à aller chercher
     * @return mixed|null la valeur dans le champs
     */
    private function getDB($field)
    {
        $conn = SQLConnector::createConn();

        $field = mysqli_real_escape_string($conn, $field);

        if ($stm = $conn->prepare("SELECT " . $field . " FROM " . self::CAP_TABLE . " WHERE code = ?")) {
            $stm->bind_param("s", $this->code);
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