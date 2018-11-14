<?php
/**************************************************************************************
Fichier :       Athlete.class.php
Auteur :		Olivier Lemay Dostie
Fonctionallité : Classe déservant les athlètes à évaluer
Date :          23 avril 2018
=======================================================================================
Vérification :
Date		Nom					    Approuvé
=======================================================================================
Historique de modification :
Date		Nom						Description
2018-04-27	Olivier Lemay Dostie    Création
2018-05-04  Olivier Lemay Dostie    Mise a jour de l'historique et versionnement.
**************************************************************************************/

include_once 'SQLConnector.class.php';
include_once 'Person.class.php';

/**
 * Classe Athlete.
 */
class Athlete extends Person
{
    /**
     * Nom de la table.
     */
    public const TABLE_NAME = "athlete";

    /**
     * @var int Catégorie de l'athlète.
     */
    private $category;
    /**
     * @var array Liste des casquettes obtenues.
     */
    private $caps = array();
    /**
     * @var array Liste des statistiques de l'athlètes.
     */
    private $statistics = array();

    /**
     * Constructeur de l'Athlete.
     *
     * @param int $id Identifiant de la personne
     */
    private function __construct(int $id) {
        parent::__construct('athlete', $id);
    }

    /**
     * Crée un nouveau athlète dans la base de données.
     * @param int $id
     * @param int $address
     * @param int $category
     * @param int $gender
     * @param string $firstName
     * @param string $name
     * @param string $birthday
     * @param string $email
     * @param string $phoneNumber
     * @param string $profileImageUrl
     * @param string $profileInfo
     * @param string $comments
     *
    public static function newAthlete($id = 0, $address = 0, $category = 0, $gender = 0,
                                      $firstName = "", $name = "",
                                      $birthday = "", $email = "", $phoneNumber = "",
                                      $profileImageUrl = "", $profileInfo = "", $comments = "") {
        AthleteManager::insertFromAttributes(
            $id, $address, $category, $gender,
            $firstName, $name,
            $birthday, $email, $phoneNumber,
            $profileImageUrl, $profileInfo, $comments);
    }*/

    /**
     * Assigne les attributs à l'objet.
     *
     * @param Athlete $athlete
     * @return bool
     */
    public function copyAthlete(Athlete $athlete) : bool {
        if ($athlete === $this) {
            return true;
        }
        foreach (get_object_vars($athlete) as $key => $value) {
            $this->$key = $value;
        }
        return true;
    }

    /**
     * Modifie les valeurs de l'athlète.
     *
     * @param int $category Nouveau identifiant de la catégorie de l'athlète.
     * @param array $caps Identifiants des casquettes
     * @param array $statistics
     */
    private function setValues4(int $category = 0, array $caps = array(), array $statistics = array()) {
        $this->setCategoryID($category);
        $this->setCaps($caps);
        $this->setStatistics($statistics);
    }


    /**
     * @return int Identifiant de l'athlète créé.
     */
    public function insert(): int
    {
        $conn = SQLConnector::createConn();
        try {
            if (!$this->insertPerson(self::TABLE_NAME) ||
                !$this->update())
            {
                return 0;
            }

        } catch (Exception $e) {
            return 0;
        } finally {
            $conn->close();
        }
        return $this->id;
    }

    /**
     * Génère un objet Person en fonction de son identifiant et de sa table.
     *
     * @param int $id Identifiant de la personne.
     * @return Athlete Personne instanciée.
     * @precondition $id doit être un entier non null
     * @postcondition L'athlère retourné est null si aucun
     */
    static public function fromId($id): Athlete
    {
        $id = (int)$id;
        assert(isset($id));
        $conn = SQLConnector::createConn();
        try {
            $athlete = new Athlete($id);
            $athlete->initFromArray(parent::fetchAttributes($conn, self::TABLE_NAME, $id));

        } catch (Exception $e) {
            die("Erreur avec la base de donnée.");
        } finally {
            $conn->close();
        }
        return $athlete;
    }

    /**
     *
     *
     * @return array
     */
    public function getAttributes(): array
    {
        $a = [];
        foreach (get_object_vars($this) as $key => $value) {
            array_push($a, $value);
        }
        return $a;
    }

    /**
     * @inheritdoc
     */
    public static function init(int $id): Person
    {
        return new Athlete($id);
    }

    /**
     * Initialise les attributs d'Athlete.
     *
     * @param int $id Identifiant de la personne
     * @param int $address
     * @param int $category Cathégorie de l'athète
     * @param int $gender Genre
     * @param string $firstName Nom
     * @param string $name Nom de famille
     * @param string $birthday Date de naissance
     * @param string $email Adresse courriel
     * @param string $phoneNumber Numéro de téléphone
     * @param string $profileImageUrl URL de l'image du profil
     * @param string $profileInfo Information sur la personne
     * @param string $comments Commentaires sur la personne
     * @param string $creationDate
     * @param bool $banned
     * @param bool $inactive
     */
    public function initAthlete($id = 0, $address = 0, $category = 0, $gender = 0, $firstName = "", $name = "",
                                $birthday = "", $email = "", $phoneNumber = "",
                                $profileImageUrl = "", $profileInfo = "", $comments = "",
                                $creationDate = "", $banned = false, $inactive = false) {
        parent::__construct('athlete', $id);
        parent::setValues1($address, $gender, $firstName, $name, $birthday, $email);
        parent::setValues2($phoneNumber, $profileImageUrl, $profileInfo, $comments);
        parent::setValues3($creationDate, $banned, $inactive);
        $capsTest = self::fetchAssociations($id, 'athlete','code','ta_cap_athlete');
        $this->setValues4($category, $capsTest);
    }

    /**
     * @inheritdoc
     * Pour la classe Coach.
     */
    public function update() : bool
    {
        $conn = SQLConnector::createConn();
        $row = array();
        try {
            $row = parent::fetchAttributes($conn, self::TABLE_NAME, $this->id);

        } catch (Exception $e) {
            return false;
        } finally {
            $conn->close();
        }
        return $this->initFromArray($row);
    }

    /**
     * @inheritdoc
     */
    public function initFromRow(mysqli_result $rows): bool
    {
        if (!$rows) {
            return false;
        }
        if ($rows[0] != $this->id) {
            echo "Initialisation d'un athlète n'ayant pas le même identifiant.";
        }
        $this->initAthlete($this->id,
            $rows[1], $rows[2], $rows[3], $rows[4], $rows[5], $rows[6], $rows[7], $rows[8],
            $rows[9], $rows[10], $rows[11], $rows[12], $rows[13], $rows[14]);
        return true;
    }

    /**
     * @inheritdoc
     */
    public function initFromArray(array $rows): bool
    {
        if (!$rows) {
            return false;
        }
        if ($rows[0] != $this->id) {
            echo "Initialisation d'un athlète n'ayant pas le même identifiant.";
        }
        $a = array();
        foreach ($rows as $row)
        {
            $r = $row;
            if (!isset($row))
            {
               $r = "";
            }
            array_push($a, $r);
        }
        $this->initAthlete($this->id,
            $a[1], $a[2], $a[3], $a[4], $a[5], $a[6], $a[7], $a[8],
            $a[9], $a[10], $a[11], $a[12], $a[13], $a[14]);
        return true;
    }

    /* ======== */
    /* GETTEURS */
    /* ======== */

    /**
     * Trouve l'identifiant de la personne correspondante.
     *
     * @return int Indentifiant de la personne.
     */
    public function fetchId() : int
    {
        return parent::fetchIdentiteId(self::TABLE_NAME);
    }

    /**
     * Obtient l'identifiant du genre.
     *
     * @return int Identifiant du genre.
     */
    public function fetchGenderId(): int
    {
        return parent::fetchPersonGenderID(self::TABLE_NAME);
    }

    /**
     * Obtient le genre.
     *
     * @return string Genre.
     */
    public function fetchGender(): string
    {
        return parent::fetchPersonGender(self::TABLE_NAME);
    }

    /**
     * Obtient l'adresse complète.
     *
     * @return string Adresse.
     */
    public function fetchAddress(): string
    {
        return parent::fetchPersonAddress(self::TABLE_NAME);
    }

    /**
     * Obtient l'identifiant de l'adresse.
     *
     * @return int Identifiant de l'adresse.
     */
    public function fetchAddressID(): int
    {
        return parent::fetchPersonAddressID(self::TABLE_NAME);
    }


    /**
     *
     */
    public function fetchFullname(): string
    {
        return parent::fetchIdentiteFullname(self::TABLE_NAME);
    }

    /**
     * Obtient le prénom de la personne.
     *
     * @return string Prénom.
     */
    public function fetchFirstName(): string
    {
        return parent::fetchPersonFirstname(self::TABLE_NAME);
    }

    /**
     * Obtient le nom de famille de la personne.
     *
     * @return string Nom de famille.
     */
    public function fetchLastname(): string
    {
        return parent::fetchPersonLastname(self::TABLE_NAME);
    }

    /**
     * Obtient la date de naissance de la personne.
     *
     * @return string Date de naissance.
     */
    public function fetchBirthday(): string
    {
        return parent::fetchPersonBirthday(self::TABLE_NAME);
    }

    /**
     * Obtient l'adresse courriel de la personne.
     *
     * @return string L'adresse courriel.
     */
    public function fetchEmail(): string
    {
        return parent::fetchPersonEmail(self::TABLE_NAME);
    }

    /**
     * Obtient le numéro de téléphone de la personne.
     *
     * @return string Le numéro de téléphone.
     */
    public function fetchPhoneNumber(): string
    {
        return parent::fetchPersonPhoneNumber(self::TABLE_NAME);
    }

    /**
     * Obtient l'URL de l'image du profil de la personne.
     *
     * @return string L'URL de l'image du profil.
     */
    public function fetchProfileImageUrl(): string
    {
        return parent::fetchPersonProfileImageUrl(self::TABLE_NAME);
    }

    /**
     * Obtient  de la personne.
     *
     * @return string
     */
    public function fetchProfileInfo(): string
    {
        return parent::fetchPersonProfileInfo(self::TABLE_NAME);
    }

    /**
     * Obtient  de la personne.
     *
     * @return string
     */
    public function fetchComments(): string
    {
        return parent::fetchPersonComments(self::TABLE_NAME);
    }

    /**
     * Obtient  de la personne.
     *
     * @return string
     *
    public function fetchRelations(): string
    {
        return parent::fetchPersonRelations(self::TABLE_NAME);
    }*/

    /**
     * Obtient  de la personne.
     *
     * @return string
     */
    public function fetchAvailabilities(): string
    {
        return parent::fetchPersonAvailabilities(self::TABLE_NAME);
    }

    /**
     * Obtient  de la personne.
     *
     * @return string
     */
    public function fetchHolidays(): string
    {
        return parent::fetchPersonHolidays(self::TABLE_NAME);
    }

    /**
     * Obtient l'état d'interdiction de la personne.
     *
     * @return bool État d'interdiction.
     */
    public function fetchBanned(): bool
    {
        return parent::fetchPersonBanned(self::TABLE_NAME);
    }

    /**
     * Obtient l'état d'inactivité de la personne.
     *
     * @return bool État d'inactivité.
     */
    public function fetchInactive(): bool
    {
        return parent::fetchPersonInactive(self::TABLE_NAME);
    }

    /**
     * Obtient la date de création de la personne.
     *
     * @return string La date de création de la personne.
     */
    public function fetchCreationDate(): string
    {
        return parent::fetchPersonCreationDate(self::TABLE_NAME);
    }

    /**
     * @return int
     */
    public function getCategoryID(): int
    {
        return $this->category;
    }

    /**
     * @return int
     */
    public function fetchCategoryID(): int
    {
        $this->category = self::fetchAttribute('category', self::TABLE_NAME, $this->id);
        return $this->category;
    }

    /**
     * @return string
     */
    public function fetchCategory(): string
    {
        return parent::fetchAttribute('name' , 'athlete_category', $this->getCategoryID());
    }

    /**
     * Modifie l'identifiant de la catégorie.
     *
     * @param int $id Nouveau identifiant de la catégorie.
     */
    public function setCategoryID(int $id)
    {
        $this->category = $id;
    }

    /**
     * Mets à jour l'identifiant de la catégorie.
     *
     * @param int $id Nouveau identifiant de la catégorie.
     * @return bool État de complétion de la mise à jour.
     */
    public function updateCategoryID(int $id): bool
    {
        $status = self::updateAttribute('category', $id, self::TABLE_NAME, 'id', $this->getId());
        if ($status)
        {
            $this->setCategoryID($id);
        }
        return $status;
    }



    /**
     * @param int $id
     */
    public function updateId(int $id): void
    {
        parent::updateIdentiteId($id, self::TABLE_NAME);
        $this->id = $id;
    }

    /**
     * @param int $address
     */
    public function updateAddress(int $address): void
    {
        parent::updatePersonAddress($address, self::TABLE_NAME);
        $this->address = $address;
    }

    /**
     * @param int $gender
     */
    public function updateGenderID(int $gender): void
    {
        parent::updatePersonGenderID($gender, self::TABLE_NAME);
        $this->gender = $gender;
    }

    /**
     * @param string $firstName
     */
    public function updateFirstName(string $firstName): void
    {
        parent::updatePersonFirstname($firstName, self::TABLE_NAME);
        $this->first_name = $firstName;
    }

    /**
     * @param string $name
     */
    public function updateLastName(string $name): void
    {
        parent::updatePersonLastname($name, self::TABLE_NAME);
        $this->name = $name;
    }

    /**
     * @param string $birthday
     */
    public function updateBirthday(string $birthday): void
    {
        parent::updatePersonBirthday($birthday, self::TABLE_NAME);
        $this->birthday = $birthday;
    }

    /**
     * @param string $email
     */
    public function updateEmail(string $email): void
    {
        parent::updatePersonEmail($email, self::TABLE_NAME);
        $this->email = $email;
    }

    /**
     * @param string $phoneNumber
     */
    public function updatePhoneNumber(string $phoneNumber): void
    {
        parent::updatePersonPhoneNumber($phoneNumber, self::TABLE_NAME);
        $this->phone_number = $phoneNumber;
    }

    /**
     * @param string $profileImageUrl
     */
    public function updateProfileImageUrl(string $profileImageUrl): void
    {
        parent::updatePersonProfileImageUrl($profileImageUrl, self::TABLE_NAME);
        $this->profile_image_url = $profileImageUrl;
    }

    /**
     * @param string $profileInfo
     */
    public function updateProfileInfo(string $profileInfo): void
    {
        parent::updatePersonProfileInfo($profileInfo, self::TABLE_NAME);
        $this->profile_info = $profileInfo;
    }

    /**
     * @param string $comments
     */
    public function updateComments(string $comments): void
    {
        parent::updatePersonComments($comments, self::TABLE_NAME);
        $this->comments = $comments;
    }

    /**
     * @param string $relations
     *
    public function updateRelations(string $relations): void
    {
    parent::updatePersonRelations($relations, self::TABLE_NAME);
    $this->relations = $relations;
    }*/

    /**
     * @param string $availabilities
     */
    public function updateAvailabilities(string $availabilities): void
    {
        parent::updatePersonAvailabilities($availabilities, self::TABLE_NAME);
        $this->availabilities = $availabilities;
    }

    /**
     * @param string $holidays
     */
    public function updateHolidays(string $holidays): void
    {
        parent::updatePersonHolidays($holidays, self::TABLE_NAME);
        $this->holidays = $holidays;
    }

    /**
     * @param bool $banned
     */
    public function updateBanned(bool $banned): void
    {
        parent::updatePersonBanned($banned, self::TABLE_NAME);
        $this->banned = $banned;
    }

    /**
     * @param bool $inactive
     */
    public function updateInactive(bool $inactive): void
    {
        parent::updatePersonInactive($inactive, self::TABLE_NAME);
        $this->inactive = $inactive;
    }

    /**
     * @param string $creationDate
     */
    public function updateCreationDate(string $creationDate): void
    {
        parent::updatePersonCreationDate($creationDate, self::TABLE_NAME);
        $this->creation_date = $creationDate;
    }

    /**
     * @param int $gender
     */
    public function updateGender(int $gender): void
    {
        parent::updatePersonGenderID($gender, self::TABLE_NAME);
    }

    /**
     * Modifie les relations que l'athlète a avec autres.
     *
     * @param string $relations Nouvelles relations.
     *
    public function updateRelations(string $relations): void
    {
        parent::updatePersonRelations($relations, self::TABLE_NAME);
        $this->relations = $relations;
    }*/

    /**
     * Modifie la catégorie de l'athlète.
     *
     * @param int $category Identifiant de la catégorie.
     */
    public function setCategory(int $category): void
    {
        $this->category = $category;
    }

    /**
     * Modifie la catégorie de l'athlète.
     *
     * @param int $category Identifiant de la catégorie.
     */
    public function updateCategory(int $category): void
    {
        parent::updateAttribute("athlete_category", $category, self::TABLE_NAME, 'id', $this->id);
    }

    /**
     * Modifie la liste de casquette.
     *
     * @param array $caps Nouvelle liste de casquette.
     */
    public function setCaps(array $caps)
    {
        $this->caps = $caps;
    }

    /**
     *
     *
     * @param string $cap Code de la casquette à ajouter.
     * @return bool Si la casquette à été ajoutée.
     */
    public function addCap(string $cap): bool
    {
        //TODO: implémenter if (!Cap::validCode($cap)) {
        //  die("Les identifiants des nouvelles casquettes de la méthode setCaps doivent
        //  faire partie des identifiants des casquettes déjà existantes.");
        //}
        if ($this->hasCap($cap)) {
            return false;
        }
        array_push($this->caps, $cap);
        if (!parent::updateAttribute("cap", $cap, "ta_cap_athlete", 'code', $this->id))
        {
            return false;
        }
        return true;
    }

    /**
     *
     *
     * @return int
     */
    public function getCapCount(): int
    {
        return count($this->caps);
    }

    /**
     * @return array
     */
    public function getCapIDs(): array
    {
        //$this->caps = self::getAssociations("athlete",
        //    "cap", "ta_cap_athlete");
        return $this->caps;
    }

    /**
     * Obtient l'identifiant de la casquette
     *
     * @return int
     */
    public function getHighestCapId(): int
    {
        if (empty($this->caps))
        {
            return 0;
        }
        return max($this->caps, 0);

        /*if (is_array($this->caps) && !empty($this->caps)) {
            $id = $this->caps[count($this->caps) - 1];
            if ($id == null) {
                $id = -1;
            }
        }
        return $id;*/
    }

    public function hasCap(string $code): bool
    {
        return in_array($code, $this->caps);
    }

    public function addCapDB(string $code): bool
    {
        if ($this->hasCap($code))
        {
            return false;
        }
        $conn = SQLConnector::createConn();
        try {
            if ($conn->connect_error) {
                return false;
            }
            $stat = $conn->query(
                "INSERT INTO ta_cap_athlete (cap, athlete)".
                " VALUES ({$code}, {$this->id}");
            if (!$stat) {
                return false;
            }

        } catch (Exception $e) {
            return false;
        } finally {
            $conn->close();
        }
        $this->addCap($code);
        return true;
    }

    public function removeCap(string $code)
    {
        $conn = SQLConnector::createConn();
        try {
            if ($conn->connect_error) {
                return false;
            }
            $stat = $conn->query(
                "INSERT INTO ta_cap_athlete (cap, athlete)".
                " VALUES ({$code}, {$this->id}");
            if (!$stat) {
                return false;
            }

        } catch (Exception $e) {
            return false;
        } finally {
            $conn->close();
        }
        unset($this->caps[$code]);
        return true;
    }

    /**
     * Obtient le nom d'une des casquettes de l'athlète.
     *
     * @param string $code Identifiant de la casquette recherchée.
     * @return string Nom de la casquette.
     */
    public function fetchCapString(string $code) : string {
        return parent::fetchAttributeFromCode('name', 'cap', 'code', $code);
    }

    /**
     * Obtient le nom d'une des casquettes de l'athlète.
     *
     * @return string Nom de la casquette ayant l'identifiant le plus grand.
     */
    public function fetchHighestCapString() : string {
        return $this->fetchCapString($this->getHighestCapId());
    }

    /**
     * Obtient le nom de la casquette en fonction de son identifiant.
     *
     * @param string $code Identifiant de la casquette.
     * @return string Nom de la casquette recherchée.
     *
    static public function fetchCap(string $code) : string
    {
    if ($code < 1) {
    return "Aucune casquette";
    }
    return self::fetchAttributeFromCode('name','cap', 'code', $code);
    }*/

    /**
     * Modifie la liste de casquette.
     *
     * @param array $caps Nouvelle liste de casquette.
     * @return bool Complétion de l'opération.
     */
    public function updateCaps(array $caps): bool
    {

        foreach ($caps as $cap) {

            $this->addCap($cap);
        }
        $this->setCaps($caps);
        return true;
    }


    /**
     * @return array
     */
    public function getStatistics(): array
    {
        return $this->statistics;
    }

    /**
     * Modifie la liste de statistique.
     *
     * @param array $statistics Nouvelle liste de statistique.
     */
    public function setStatistics(array $statistics) {
        $this->statistics = $statistics;
    }

    /**
     * Modifie la liste de statistique.
     *
     * @param array $statistics Nouvelle liste de statistique.
     */
    public function updateStatistics(array $statistics) {
        foreach ($statistics as $stat) {
            if (!is_a($stat, 'Object')){
                die("Le paramètre de la méthode setSetatistics doit être un 
                tableau composé de juste des objets de type Statistic");
            }
            // Ajouter les statistiques dans ta_athlete_statistic (Méthode non suivante fonctionnelle)
            parent::updateAttribute("stat", $stat, "ta_athlete_statistic", 'id', $this->id);
        }
        $this->statistics = $statistics;
    }

    /**
     * Ajoute les données d'une personne dans une ligne d'un tableau.
     */
    public function printRow()
    {
        echo "<tr>{$this->printParentCells()}<td>{$this->getCategoryID()}</td></tr>";
    }
}
