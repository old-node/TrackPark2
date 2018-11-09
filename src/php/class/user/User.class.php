<?php
/**************************************************************************************
Fichier :       User.class.php
Auteur :        Antoine Gagnon
Fonctionnalité : Classe réprésentant un utilisateur se gère aussi sois même
 * dans la base de données.
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

include_once './UserType.class.php';
include_once './SQLConnector.class.php';

define("MIN_PASS_LENGHT", 8);

/**
 * Classe User
 */
class User
{
    const USER_TABLE = 'user';
    const USERNAME_FIELD = 'username';
    const PASSWORD_FIELD = 'password_hash';
    const USERTYPE_FIELD = 'user_type';
    const EVALUATOR_FIELD = 'coach';

    /**
     * @var int L'ID du joueur
     */
    private $id;

    /**
     * @var UserType Le type d'utilisateur
     */
    private $userType;

    /**
     * @var L'évaluateur lié à cet utilisateur
     */
    private $evaluator;

    /**
     * @var string Le nom d'utilisateur de l'utilisateur
     */
    private $username;

    /**
     * @var string Le hash du mot de passe de l'utilisateur
     */
    private $passwordHash;

    /**
     * User constructor.
     * @param $id
     * @param $userType
     * @param $evaluator
     * @param $username
     * @param $hash
     */
    protected function __construct(int $id, string $username, string $hash, UserType $userType, $evaluator)
    {
        $this->id = $id;
        $this->userType = $userType;
        $this->evaluator = $evaluator;
        $this->username = $username;
        $this->passwordHash = $hash;
    }

    /**
     * Crée un instance d'un utilisateur à partire de son ID
     * @param int $id
     * @return null|User
     */
    public static function fromID(int $id)
    {
        $conn = SQLConnector::createConn();
        if ($stm = $conn->prepare("SELECT * FROM user WHERE id = ?")) {
            $stm->bind_param("i", $id);
            $stm->execute();

            $result = $stm->get_result();

            if (mysqli_num_rows($result) == 1) {
                $row = $result->fetch_assoc();
                $conn->close();

                return new User(
                    $row["id"], $row[self::USERNAME_FIELD], $row[self::PASSWORD_FIELD],
                    UserType::fromID($row[self::USERTYPE_FIELD]), $row[self::EVALUATOR_FIELD]
                );
            }
        }
        $conn->close();
        return null;
    }

    public static function fromUsername(string $username)
    {
        $conn = SQLConnector::createConn();
        if ($stm = $conn->prepare("SELECT * FROM user WHERE username = ?")) {
            $stm->bind_param("s", $username);
            $stm->execute();

            $result = $stm->get_result();

            if (mysqli_num_rows($result) == 1) {
                $row = $result->fetch_assoc();
                $conn->close();

                return new User(
                    $row["id"], $row[self::USERNAME_FIELD], $row[self::PASSWORD_FIELD],
                    UserType::fromID($row[self::USERTYPE_FIELD]), $row[self::EVALUATOR_FIELD]
                );
            }
        }
        $conn->close();
        return null;
    }

    /**
     * Crée un nouvel utilisateur, l'ajoute dans la base de donnée
     * @param string $username
     * @param string $password
     * @param $userType
     * @param $evaluator
     * @return User
     */
    public static function newUser(string $username, string $password, $userType, $evaluator): User
    {
        $conn = SQLConnector::createConn();

        if ($stm = $conn->prepare("INSERT INTO user (username, password_hash, user_type, coach) VALUES (?,?,?,?)")) {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stm->bind_param("ssii", $username, $hash, $userType, $evaluator);
            $stm->execute();
            $id = $conn->insert_id;

            return new User($id, $username, $hash, UserType::fromID($userType), $evaluator);
        }
        $conn->close();
    }

    public static function getAllUsers(): array
    {
        $users = [];
        $conn = SQLConnector::createConn();
        if ($stm = $conn->prepare("SELECT * FROM user")) {
            $stm->execute();

            $result = $stm->get_result();

            while ($row = $result->fetch_assoc()) {
                array_push($users,
                    new User(
                        $row["id"], $row[self::USERNAME_FIELD], $row[self::PASSWORD_FIELD],
                        UserType::fromID($row[self::USERTYPE_FIELD]), $row[self::EVALUATOR_FIELD]
                    )
                );
            }
        }
        $conn->close();
        return $users;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return UserType
     */
    public function getUserType(): UserType
    {
        return $this->userType;
    }

    /**
     * @param mixed $userType
     */
    public function setUserType(UserType $userType): void
    {
        $this->userType = $userType;
        $this->setDB(self::USERTYPE_FIELD, $userType->getId());
    }

    /**
     * @return mixed
     */
    public function getEvaluator()
    {
        return $this->getDB(self::EVALUATOR_FIELD);
    }

    /**
     * @param mixed $evaluator
     */
    public function setEvaluator($evaluator): void
    {
        $this->evaluator = $evaluator;
        $this->setDB(self::EVALUATOR_FIELD, $evaluator);
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->getDB(self::USERNAME_FIELD);
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
        $this->setDB(self::USERNAME_FIELD, $username);
    }

    /**
     * @return string
     */
    public function getPasswordHash(): string
    {
        return $this->getDB(self::PASSWORD_FIELD);
    }

    /**
     * @param string $passwordHash
     */
    public function setPasswordHash(string $passwordHash): void
    {
        $this->passwordHash = $passwordHash;
        $this->setDB(self::PASSWORD_FIELD, $passwordHash);
    }

    public function setPassword(string $password): void
    {
        $this->passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $this->setDB(self::PASSWORD_FIELD, $this->passwordHash);
    }

    private function setDB($field, $value): void
    {
        $conn = SQLConnector::createConn();

        $field = mysqli_real_escape_string($conn, $field);

        if ($stm = $conn->prepare("UPDATE " . self::USER_TABLE . " SET " . $field . "= ? WHERE id = ?")) {
            $stm->bind_param("si", $value, $this->id);
            $stm->execute();
        }
        $conn->close();
    }

    private function getDB($field)
    {
        $conn = SQLConnector::createConn();

        $field = mysqli_real_escape_string($conn, $field);

        if ($stm = $conn->prepare("SELECT " . $field . " FROM " . self::USER_TABLE . " WHERE id = ?")) {
            $stm->bind_param("i", $this->id);
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