<?php
/**************************************************************************************
Fichier :       Coach.class.php
Auteur :		Olivier Lemay Dostie
Fonctionallité : Classe servant à instancier des évaluateurs.
Date :          23 avril 2018
=======================================================================================
Vérification :
Date		Nom					    Approuvé
=======================================================================================
Historique de modification :
Date		Nom						Description
2018-04-27	Olivier Lemay Dostie	Création
**************************************************************************************/

include_once './SQLConnector.class.php';
include_once './Person.class.php';

/**
 * Classe Coach
 */
class Coach extends Person
{
    /**
     * @var string Nom de la table des évaluateurs dans la base de données.
     */
    public const TABLE_NAME = "coach";
    /**
     * @var string Formations que l'évaluateur à complété.
     */
    private $formations;
    /**
     * @var string Habiletés d'enseignement aquise par l'évaluateur.
     */
    private $teachingSkills;
    /**
     * @var string Rôles que l'administrateur à donné à l'évaluateur.
     */
    private $roles;

    /**
     * Constructeur de Coach.
     *
     * @param int $id
     * @precondition
     * @postcondition
     */
    protected function __construct(int $id)
    {
        assert(isset($id));
        parent::__construct('coach', $id);
    }

    /**
     * Assigne les attributs à l'objet.
     *
     * @param Coach $coach Évaluateur à copier.
     * @precondition $coach doit être instancié et non null.
     * @postcondition Toutes les variables de $coach sont copiés dans l'évaluateur.
     */
    public function copyCoach(Coach $coach)
    {
        assert(isset($coach));

        if ($coach === $this) {
            return;
        }
        foreach (get_object_vars($coach) as $key => $value) {
            $this->$key = $value;
        }
    }

    /**
     * Ajoute un évaluateur dans la base de données.
     *
     * @return int Identifiant de la personne créée.
     */
    public function insert(): int
    {
        $conn = SQLConnector::createConn();
        try {
            $this->insertPerson(self::TABLE_NAME);
            /*$stat = $conn->prepare("UPDATE ".self::TABLE_NAME." SET ".
                "formations = {$this->getFormations()}".
                " WHERE id = ".$this->getId());
            // Ajouter les autres relations par la suite

            $stat->execute();
            if (!$stat->get_result())
            {
                return 0;
            }*/

        } catch (Exception $e) {
            return 0;
        } finally {
            $conn->close();
        }
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    static public function fromId(int $id) : Coach
    {
        $conn = SQLConnector::createConn();
        try {
            $coach = new Coach($id);
            $row = parent::fetchAttributes($conn, self::TABLE_NAME, $id);
            $coach->initFromArray($row);

        } catch (Exception $e) {
            die("Erreur avec la base de donnée.");
        } finally {
            $conn->close();
        }
        return $coach;
    }

    /**
     *
     *
     * @return array
     */
    public function getAttributes(): array
    {
        $c = [];
        foreach (get_object_vars($this) as $key => $value) {
            array_push($c, $value);
        }
        return $c;
    }

    /**
     * @inheritdoc
     */
    public static function init(int $id): Person
    {
        return new Coach($id);
    }

    /**
     * Initialise les attributs de Coach.
     *
     * @param int $id Identifiant de la personne.
     * @param int $address
     * @param int $gender Genre.
     * @param string $firstName Nom.
     * @param string $name Nom de famille.
     * @param string $birthday Date de naissance.
     * @param string $email Adresse courriel.
     * @param string $phoneNumber Numéro de téléphone.
     * @param string $profileImageUrl URL de l'image de profil.
     * @param string $profileInfo Description du profil.
     * @param string $comments Commentaires sur la personne.
     * @param string $creationDate Date de création du profil.
     * @param bool $banned État d'interdication à un service.
     * @param bool $inactive État d'inactivité du profil.
     * @param string $formations Formations complétés.
     * @param string $teachingSkills Habiletés d'enseignement aquises.
     * @param string $roles Rôles organisationnels.
     * @precondition
     * @postcondition
     */
    public function initCoach(int $id = 0, int $address = 0, int $gender = 0, string $firstName, string $name,
                              string $birthday = "", string $email = "", string $phoneNumber = "",
                              string $profileImageUrl, string $profileInfo = "", string $comments = "",
                              string $creationDate = "", bool $banned = false, bool $inactive = false,
                              string $formations = "", string $teachingSkills = "", string $roles = "")
    {
        parent::__construct(self::TABLE_NAME, $id);
        parent::setValues1($address, $gender, $firstName, $name, $birthday, $email);
        parent::setValues2($phoneNumber, $profileImageUrl, $profileInfo, $comments);
        parent::setValues3($creationDate, $banned, $inactive);
        $this->setValues4($formations, $teachingSkills, $roles);
    }

    /**
     * Initialise les attributs correspondant seullement à Coach.
     *
     * @param string $formations Formations complétées.
     * @param string $teachingSkills Habiletés principales.
     * @param string $roles Rôles organisationels.
     */
    private function setValues4(string $formations, string $teachingSkills, string $roles)
    {
        $this->formations = $formations;
        $this->teachingSkills = $teachingSkills;
        $this->roles = $roles;
    }

    /**
     * @param array $values Nouvelles valeurs de l'évaluateur.
     */
    private function setValues4Row(array $values)
    {
        $this->setValues4($values[0], $values[1], $values[2]);
    }

    /**
     * Met à jour les attributs à partir d'un enregistrement.
     *
     * @param $row
     *
    private function updateCoach($row)
    {
        $this->initCoach($this->id,
            $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8],
            $row[9], $row[10], $row[11], $row[12], $row[13], $row[14], $row[15], $row[16]);
    }*/

    /**
     * @inheritdoc
     * Pour la classe Coach.
     */
    public function update() : bool
    {
        $conn = SQLConnector::createConn();
        try {
            parent::updatePerson(self::TABLE_NAME);
            // Charger les autres informations de coach.
            $row = [parent::fetchAttribute('formations',self::TABLE_NAME, $this->id)];
            $this->setValues4Row($row);

        } catch (Exception $e) {
            die("Une erreur s'est produite dans la connexion à la base de donnée.");
        } finally {
            $conn->close();
        }
        return $this->initCoach($row);
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
            echo "Update d'un évaluateur n'ayant pas le même identifiant.";
        }
        $this->initCoach($this->id,
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
            echo "Update d'un évaluateur n'ayant pas le même identifiant.";
        }
        $this->initCoach($this->id,
            $rows[1], $rows[2], $rows[3], $rows[4], $rows[5], $rows[6], $rows[7], $rows[8],
            $rows[9], $rows[10], $rows[11], $rows[12], $rows[13], $rows[14]);
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
     * Obtient la liste des formations que l'évaluateur a complété.
     *
     * @return string Les formations complétées.
     */
    public function getFormations(): string
    {
        return $this->formations;
    }

    /**
     * Obtient la liste des formations que l'évaluateur a complété.
     *
     * @return string Les formations complétées.
     */
    public function fetchFormations(): string
    {
        return parent::fetchAttribute("formations",self::TABLE_NAME, $this->id);
    }

    /**
     * Obtient les habiletés principales de l'évaluateur pour la formation des athlètes.
     *
     * @return string Les habiletés reconnues.
     */
    public function getTeachingSkills(): string
    {
        return $this->teachingSkills;
    }

    /**
     * Obtient les habiletés principales de l'évaluateur pour la formation des athlètes.
     *
     * @return string Les habiletés reconnues.
     */
    public function fetchTeachingSkills(): string
    {
        return parent::fetchAttribute("teaching_skills",self::TABLE_NAME, $this->id);
    }

    /**
     * Obtient les rôles organisationels de l'évaluateur.
     *
     * @return string Les rôles possédés.
     */
    public function getRoles(): string
    {
        return $this->roles;
    }

    /**
     * Obtient les rôles organisationels de l'évaluateur.
     *
     * @return string Les rôles possédés.
     */
    public function fetchRoles(): string
    {
        return parent::fetchAttribute("roles",self::TABLE_NAME, $this->id);
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
     * @param string $formations
     */
    public function updatePersonFormations(string $formations): void
    {
        parent::updateAttribute("formations", $formations, self::TABLE_NAME, 'id', $this->id);
        $this->formations = $formations;
    }

    /**
     * @param string $teachingSkills
     */
    public function updatePersonTeachingSkills(string $teachingSkills): void
    {
        parent::updateAttribute("teaching_skills", $teachingSkills, self::TABLE_NAME, 'id', $this->id);
        $this->teachingSkills = $teachingSkills;
    }

    /**
     * @param string $roles
     */
    public function updatePersonRoles(string $roles): void
    {
        parent::updateAttribute("roles", $roles, self::TABLE_NAME, 'id', $this->id);
        $this->roles = $roles;
    }

    /**
     * Ajoute les données d'une personne dans une ligne d'un tableau.
     */
    public function printRow()
    {
        echo "<tr>{$this->printParentCells()}<td>{$this->getRoles()}</td></tr>";
    }
}