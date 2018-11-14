<?php
/**************************************************************************************
Fichier :       Person.class.php
Auteur :		Olivier Lemay Dostie
Fonctionallité : Classe servant à former d'autres classes représentant des personnes.
Date :          23 avril 2018
=======================================================================================
Vérification :
Date		Nom					    Approuvé
2018-05-06  Olivier Lemay Dostie    Doit exclure la personne avec
 * l'identifiant 0 dans le chargement.
=======================================================================================
Historique de modification :
Date		Nom						Description
2018-04-23	Olivier Lemay Dostie	Création
2018-05-06  Olivier Lemay Dostie
**************************************************************************************/

include_once 'CtrlGeneral.php';
include_once 'Identite.class.php';

/**
 * Classe Person.
 */
abstract class Person implements Identite
{
    /**
     * @var string Nom de la table correspondant à la personne.
     */
    protected static $tableName = ""; // TODO : Vérifier que le nom de la table soit unique pour Coach et pour Athlete
    /**
     * @var array Noms des colonnes des attributs de Person.
     *
    protected const COL_NAMES = ["id" => 'i', "address" => 'i', "gender" => 'i',
    "first_name" => 's', "name" => 's', "birthday" => 's', "email" => 's',
    "phone_number" => 's', "profile_image_url" => 's', "profile_info" => 's',
    "comments" => 's', "availabilities" => 's', "holidays" => 's',
    "banned" => 'b', "inactive" => 'b', "creation_date" => 's'];*/

    /**
     * @var int Nombre d'instance.
     */
    protected static $count = 0;

    /**
     * @var int Identifiant.
     */
    protected $id;
    /**
     * @var int Identifiant de l'adresse.
     */
    protected $address;
    /**
     * @var int Identifiant du genre.
     */
    protected $gender;
    /**
     * @var string Prénom.
     */
    protected $first_name;
    /**
     * @var string Nom de famille.
     */
    protected $name;
    /**
     * @var string Date de naissance.
     */
    protected $birthday;
    /**
     * @var string Courriel.
     */
    protected $email;
    /**
     * @var string Numéro de téléphone.
     */
    protected $phone_number;
    /**
     * @var string Adresse URL de l'image du profil.
     */
    protected $profile_image_url;
    /**
     * @var string Information sur le profil.
     */
    protected $profile_info;
    /**
     * @var string Commentaires.
     */
    protected $comments;
    /**
     * @var string Relations entre cette personne et une autre.
     *
    protected $relations;*/
    /**
     * @var string Disponibilités.
     */
    protected $availabilities;
    /**
     * @var string Vacances.
     */
    protected $holidays;
    /**
     * @var bool État permettant ou non l'accès à un service.
     */
    protected $banned;
    /**
     * @var bool État indiquant si Person peut se connecter au service.
     */
    protected $inactive;
    /**
     * @var string Date de création ou d'inscription de Person.
     */
    protected $creation_date;

    /**
     * Constructeur de Person.
     *
     * @param int $id Identifiant de la personne.
     * @param string $tableName Nom de la table.
     * @precondition Utiliser 0 pour $id si vous voulez instancier une nouvelle personne.
     */
    protected function __construct(string $tableName, $id = 0)
    {
        assert(!empty($tableName));
        self::$tableName = $tableName;
        $this->id = $id;
    }

    /**
     * Modifie l'identifant de la personne et permet d'autres méthodes de fonctionner.
     *
     * @param int $id Nouvel identifiant.
     * @return Person Personne initialisée.
     */
    abstract public static function init(int $id): Person;

    /**
     * Met à jour les attributs à partir d'un enregistrement.
     *
     * @param mysqli_result $rows L'enregistrement d'une personne.
     * @return bool État de complétion de l'initialisation.
     */
    abstract public function initFromRow(mysqli_result $rows): bool;

    /**
     * Met à jour les attributs à partir d'un tableau d'attribut de personne.
     *
     * @param array $rows Tableau d'attribut de personne.
     * @return bool État de complétion de l'initialisation.
     */
    abstract public function initFromArray(array $rows): bool;

    /**
     * Copie les valeur d'une personne dans une autre.
     *
     * @param Person $person Personne à copier.
     */
    protected function copy(Person $person)
    {
        assert(isset($person));
        foreach (get_object_vars($person) as $key => $value)
        {
            $this->$key = $value;
        }
    }

    /**
     * Assigne les variables aditionnelles à Person.
     *
     * @param int $address Identifiant de l'adresse.
     * @param int $gender Identifiant du genre.
     * @param string $firstname Prénom.
     * @param string $lastname Nom de famille.
     * @param string $birthday Date de naissance.
     * @param string $email Adresse courriel.
     */
    protected function setValues1(int $address = 0, int $gender = 0,
                                  string $firstname, string $lastname,
                                  string $birthday = "", string $email = "")
    {
        $this->setAddress($address);
        $this->setGender($gender);
        $this->setFirstname($firstname);
        $this->setLastname($lastname);
        $this->setBirthday($birthday);
        $this->setEmail($email);
    }

    /**
     * Assigne les variables aditionnelles à Person.
     *
     * @param string $phoneNumber Nouveau numéro de téléphone.
     * @param string $profileImageUrl Nouveau URL de l'image du profil.
     * @param string $profileInfo Nouvelle information sur la personne.
     * @param string $comments Nouveau commentaires sur la personne.
     * @param string $relations Informations en lien avec une autre personne
     */
    protected function setValues2(string $phoneNumber = "", string $profileImageUrl = "",
                                  string $profileInfo = "", string $comments = "", string $relations = "")
    {
        $this->setPhoneNumber($phoneNumber);
        $this->setProfileImageUrl($profileImageUrl);
        $this->setProfileInfo($profileInfo);
        $this->setComments($comments);
        //$this->setRelations($relations);
    }

    /**
     * Assigne les variables aditionnelles à Person.
     *
     * @param string $creationDate Nouvelle date de création.
     * @param bool $banned Nouvel état d'interdiction.
     * @param bool $inactive Nouvel état d'inactivité.
     */
    protected function setValues3(string $creationDate = "", bool $banned = false, bool $inactive = false)
    {
        $this->setCreationDate($creationDate);
        $this->setBanned($banned);
        $this->setInactive($inactive);
    }


    /*============================================*/
    /* GETTEURS, FETCHEURS, SETTEURS ET UPDATEURS */
    /*============================================*/

    /**
     * @inheritdoc
     */
    public static function getIdentiteCount(): int
    {
        return self::$count;
    }

    /**
     * @inheritdoc
     */
    public static function addIdentiteCount(): int
    {
        return self::$count++;
    }

    /**
     * @inheritdoc
     */
    public static function resetIdentiteCount()
    {
        self::$count = 0;
    }

    /**
     * @inheritdoc
     */
    public static function setIdentiteCount(int $count)
    {
        assert(!empty($count));
        self::$count = $count;
    }

    /**
     * @inheritdoc
     */
    public static function fetchIdentiteCount(): int
    {
        die("Not implemented");
        return 0;//TODO : mettre abstract ou ajouter $tableName en paramètre pour fetcher le nombre dans la BD
    }

    /**
     * @inheritdoc
     */
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function fetchIdentiteId(string $tableName): int
    {
        $conn = SQLConnector::createConn();
        try {
            $stat = $conn->prepare("SELECT id FROM {$tableName} WHERE ".
                "first_name = {$this->getFirstname()} AND name = ".$this->getLastname().
                " AND email = ".$this->getEmail());
            $stat->execute();
            $rs = $stat->get_result();

            if (!$rs) {
                die("Requête invalide: " . mysql_error() . "<br>");
            }
            if ($rs->num_rows > 1) {
                die("Deux personnes possèdent un courriel et un nom identique. ".
                    "Vérifiez l'intégité des données de la base de donnée.");
            }
            $row = $rs->fetch_array(MYSQLI_NUM);
            $this->setId($row[0]);

        } catch (Exception $e) {
            die("Une erreur s'est produite dans la connexion à la base de donnée.");
        } finally {
            $conn->close();
        }

        return $this->getId();
    }

    /**
     * @inheritdoc
     */
    public function setId(int $id) : void
    {
        $this->id = $id;
    }

    /**
     * @inheritdoc
     */
    public function updateIdentiteId(int $id, string $tableName) : void {
        $this->updateAttribute("id", $id, $tableName, 'id', $this->getId());
        $this->setId($id);
    }

    /**
     * Obtient l'identifiant du genre.
     *
     * @return int Identifiant du genre.
     */
    public function getGender(): int {
        return $this->gender;
    }

    /**
     * Obtient l'identifiant du genre.
     *
     * @param string $tableName Table correspondant à la personne.
     * @return int Identifiant du genre.
     */
    protected function fetchPersonGenderID(string $tableName): int {
        return self::fetchAttribute("gender", $tableName, $this->getId());
    }

    /**
     * Obtient le genre.
     *
     * @param string $tableName Table correspondant à la personne.
     * @return string Genre.
     */
    protected function fetchPersonGender(string $tableName): string {
        return self::fetchAttribute('title', 'gender',self::fetchPersonGenderID($tableName));
    }

    /**
     * Modifie le genre de Person.
     *
     * @param int $gender Nouveau identifiant du genre.
     */
    public function setGender(int $gender): void
    {
        $this->gender = $gender;
    }

    /**
     * Mets à jour le genre de Person.
     *
     * @param int $gender Nouveau identifiant du genre.
     * @param string $tableName Nom de la table.
     */
    public function updatePersonGenderID(int $gender, string $tableName): void
    {
        $this->updateAttribute("gender", $gender, $tableName, 'id', $this->getId());
        $this->setGender($gender);
    }

    /**
     * Obtient l'identifiant de l'adresse.
     *
     * @return int Identifiant de l'adresse.
     */
    public function getAddressID(): int
    {
        return $this->address;
    }

    /**
     * Obtient l'identifiant de l'adresse.
     *
     * @param string $tableName Table correspondant à la personne.
     * @return int Identifiant de l'adresse.
     */
    protected function fetchPersonAddressID(string $tableName): int {
        return self::fetchAttribute("address", $tableName, $this->getId());
    }

    /**
     * Obtient l'adresse complète.
     *
     * @param string $tableName Nom de la table de la personne.
     * @return string Adresse complète.
     */
    public function fetchPersonAddress(string $tableName): string  {
        return self::fetchAttribute("address", "address", self::fetchPersonAddressID($tableName));
    }

    /**
     * Modifie l'adresse de Person.
     *
     * @param int $address Nouveau identifiant de l'adresse.
     */
    public function setAddress(int $address): void
    {
        $this->address = $address;
    }

    /**
     * Mets à jour l'identifiant de l'adresse de Person.
     *
     * @param int $address Nouveau identifiant de l'adresse.
     * @param string $tableName Nom de la table.
     */
    public function updateAddressID(int $address, string $tableName): void
    {
        $id = $this->fetchAttribute('id', $tableName, $address);
        if ($id == $address) return; // TODO
        $this->updateAttribute("address", $address, $tableName, 'id', $this->getId());
        $this->setAddress($address);
    }

    /**
     * Mets à jour l'adresse de Person.
     *
     * @param string $address Nouvelle adresse.
     * @param string $tableName Nom de la table.
     */
    public function updatePersonAddress(string $address, string $tableName): void
    {
        if ($this->fetchPersonAddress($tableName) == $address) return;
        $this->updateAttribute("address", $address, $tableName, 'id', $this->getId());
        $this->setAddress($address);
    }

    /**
     * @inheritdoc
     * Concatenne le prénom et le nom de famille de la personne.
     */
    public function getFullname(): string {
        return self::getFirstname() ." ". self::getLastname();
    }

    /**
     * @inheritdoc
     * Concatenne le prénom et le nom de famille de la personne.
     */
    public function fetchIdentiteFullname(string $tableName): string {
        return self::fetchPersonFirstname($tableName) ." ". self::fetchPersonLastname($tableName);
    }

    /**
     * @inheritdoc
     */
    public function setFullname(string $first_name): void
    {
        die("Méthode pas implémentée. Utilisez setFirstname() et setLastname() au lieu");
        //$this->first_name = $first_name;
        //$this->name = $name;
    }

    /**
     * @inheritdoc
     */
    public function updateIdentiteFullname(string $firstname, string $tableName): void
    {
        die("Méthode pas implémentée. Utilisez updateFirstname() et updateLastname() au lieu");
    }

    /**
     * Obtient le prénom de la personne.
     *
     * @return string Prénom.
     */
    public function getFirstname(): string {
        return $this->first_name;
    }

    /**
     * Obtient le prénom de la personne.
     *
     * @param string $tableName Nom de la table.
     * @return string Prénom.
     */
    protected function fetchPersonFirstname(string $tableName): string {
        return self::fetchAttribute("first_name", $tableName, $this->getId());
    }

    /**
     * Modifie le prénom de Person.
     *
     * @param string $first_name Nouveau prénom.
     */
    public function setFirstname(string $first_name): void
    {
        $this->first_name = $first_name;
    }

    /**
     * Mets à jour le prénom de Person.
     *
     * @param string $firstname Nouveau prénom.
     * @param string $tableName Nom de la table.
     */
    public function updatePersonFirstname(string $firstname, string $tableName): void
    {
        $this->updateAttribute("first_name", $firstname, $tableName, 'id', $this->getId());
        $this->setFirstname($firstname);
    }

    /**
     * Obtient le nom de famille de la personne.
     *
     * @return string Nom de famille.
     */
    public function getLastname(): string {
        return $this->name;
    }

    /**
     * Obtient le nom de famille de la personne à partir de la base de données.
     *
     * @param string $tableName Nom de la table.
     * @return string Nom de famille.
     */
    protected function fetchPersonLastname(string $tableName): string {
        return self::fetchAttribute("name", $tableName, $this->getId());
    }

    /**
     * Modifie le nom de famille de la personne.
     *
     * @param string $lastname Nouveau nom de famille.
     */
    public function setLastname(string $lastname) : void {
        $this->name = $lastname;
    }

    /**
     * @inheritdoc
     * Pour le nom de famille.
     */
    public function updatePersonLastname(string $name, string $tableName) : void {
        $this->updateAttribute("name", $name, $tableName, 'id', $this->getId());
        $this->setFullname($name);
    }

    /**
     * Obtient l'adresse courriel de la personne.

     * @return string L'adresse courriel.
     */
    public function getEmail(): string {
        return $this->email;
    }

    /**
     * Obtient l'adresse courriel de la personne.
     *
     * @param string $tableName Nom de la table.
     * @return string L'adresse courriel.
     */
    protected function fetchPersonEmail(string $tableName): string {
        return self::fetchAttribute("email", $tableName, $this->getId());
    }

    /**
     * Modifie l'adresse courriel de Person.
     *
     * @param string $email Nouvelle adresse courriel.
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * Mets à jour l'adresse courriel de Person.
     *
     * @param string $email Nouvelle adresse courriel.
     * @param string $tableName Nom de la table.
     */
    protected function updatePersonEmail(string $email, string $tableName): void
    {
        $this->updateAttribute("email", $email, $tableName, 'id', $this->getId());
        $this->setEmail($email);
    }

    /**
     * Obtient la date de naissance de la personne.
     *
     * @return string Date de naissance.
     */
    public function getBirthday(): string {
        return $this->birthday;
    }

    /**
     * Obtient la date de naissance de la personne.
     *
     * @param string $tableName Nom de la table.
     * @return string Date de naissance.
     */
    protected function fetchPersonBirthday(string $tableName): string {
        return self::fetchAttribute("birthday", $tableName, $this->getId());
    }

    /**
     * Modifie la date de naissance de Person.
     *
     * @param string $birthday Nouvelle date de naissance.
     */
    public function setBirthday(string $birthday): void
    {
        $this->birthday = $birthday;
    }

    /**
     * Modifie la date de naissance de Person.
     *
     * @param string $birthday Nouvelle date de naissance.
     * @param string $tableName Nom de la table.
     */
    protected function updatePersonBirthday(string $birthday, string $tableName): void
    {
        $this->updateAttribute("birthday", $birthday, $tableName, 'id', $this->getId());
        $this->setBirthday($birthday);
    }

    /**
     * Obtient le numéro de téléphone de la personne.
     *
     * @return string Le numéro de téléphone.
     */
    public function getPhoneNumber(): string {
        return $this->phone_number;
    }

    /**
     * Obtient le numéro de téléphone de la personne.
     *
     * @param string $tableName Nom de la table.
     * @return string Le numéro de téléphone.
     */
    protected function fetchPersonPhoneNumber(string $tableName): string {
        return self::fetchAttribute("phone_number", $tableName, $this->getId());
    }

    /**
     * Modifie le numéro de téléphone de Person.
     *
     * @param string $phone_number Nouveau numéto de téléphone.
     */
    public function setPhoneNumber(string $phone_number): void
    {
        $this->phone_number = $phone_number;
    }

    /**
     * Modifie le numéro de téléphone de Person.
     *
     * @param string $phoneNumber Nouveau numéto de téléphone.
     * @param string $tableName Nom de la table.
     */
    protected function updatePersonPhoneNumber(string $phoneNumber, string $tableName): void
    {
        $this->updateAttribute("phoneNumber", $phoneNumber, $tableName, 'id', $this->getId());
        $this->setPhoneNumber($phoneNumber);
    }

    /**
     * Obtient l'URL de l'image du profil de la personne.
     *
     * @return string L'URL de l'image du profil.
     */
    public function getProfileImageUrl(): string {
        return $this->profile_image_url;
    }

    /**
     * Obtient l'URL de l'image du profil de la personne.
     *
     * @param string $tableName Nom de la table.
     * @return string L'URL de l'image du profil.
     */
    protected function fetchPersonProfileImageUrl(string $tableName): string {
        return self::fetchAttribute("profile_image_url", $tableName, $this->getId());
    }

    /**
     * Modifie l'URL de l'image du profil de Person.
     *
     * @param string $profile_image_url Nouvelle URL de l'image du profil.
     */
    public function setProfileImageUrl(string $profile_image_url): void
    {
        $this->profile_image_url = $profile_image_url;
    }

    /**
     * Modifie l'URL de l'image du profil de Person.
     *
     * @param string $profileImageUrl Nouvelle URL de l'image du profil.
     * @param string $tableName Nom de la table.
     */
    public function updatePersonProfileImageUrl(string $profileImageUrl, string $tableName): void
    {
        $this->updateAttribute("profileImageUrl", $profileImageUrl, $tableName, 'id', $this->id);
        $this->setProfileImageUrl($profileImageUrl);
    }

    /**
     * @inheritdoc
     */
    public function getDescription() : string {
        return $this->profile_info;
    }

    /**
     * @inheritdoc
     */
    public function fetchPersonDescription(string $tableName) : string {
        $this->setDescription(self::fetchAttribute("profile_info", $tableName, $this->getId()));
        return $this->getDescription();
    }

    /**
     * @inheritdoc
     * Pour la description du profil.
     */
    public function setDescription(string $profileInfo) : void {
        $this->profile_info = $profileInfo;
    }

    /**
     * @inheritdoc
     * Pour la description du profil.
     */
    public function updateDescription(string $profileInfo, string $tableName) : void {
        $this->updateAttribute("profile_info", $profileInfo, $tableName, 'id', $this->getId());
        $this->setDescription($profileInfo);
    }

    /**
     * Obtient la description du profil de la personne.
     *
     * @return string Description du profil.
     */
    public function getProfileInfo(): string {
        return self::getDescription();
    }

    /**
     * Obtient  de la personne.
     *
     * @param string $tableName Nom de la table.
     * @return string
     */
    protected function fetchPersonProfileInfo(string $tableName): string {
        return self::fetchPersonDescription($tableName);
    }

    /**
     * Modifie la description de Person.
     *
     * @param string $profile_info Description de Person.
     */
    public function setProfileInfo(string $profile_info): void
    {
        $this->setDescription($profile_info);
    }

    /**
     * Modifie la description de Person.
     *
     * @param string $profileInfo Description de Person.
     * @param string $tableName Nom de la table.
     */
    public function updatePersonProfileInfo(string $profileInfo, string $tableName): void
    {
        $this->updateDescription($profileInfo, $tableName);
    }

    /**
     * Obtient les commentaires sur le profil de la personne.
     *
     * @return string Commentaires sur le profil.
     */
    public function getComments(): string {
        return $this->comments;
    }

    /**
     * Obtient les commentaires sur le profil de la personne.
     *
     * @param string $tableName Nom de la table.
     * @return string Commentaires sur le profil.
     */
    protected function fetchPersonComments(string $tableName): string {
        return self::fetchAttribute("comments", $tableName, $this->getId());
    }

    /**
     * Modifie les commentaires faits sur Person.
     *
     * @param string $comments Nouveaux commentaires fait sur Person.
     */
    public function setComments(string $comments): void
    {
        $this->comments = $comments;
    }

    /**
     * Modifie les commentaires faits sur Person.
     *
     * @param string $comments Nouveaux commentaires fait sur Person.
     * @param string $tableName Nom de la table.
     */
    protected function updatePersonComments(string $comments, string $tableName): void
    {
        $this->updateAttribute("comments", $comments, $tableName, 'id', $this->id);
        $this->setComments($comments);
    }

    /**
     * Obtient les relations de la personne.
     *
     * @return string Les relations sur la personne.
     *
    public function getRelations(): string {
        return $this->relations;
    }

    /**
     * Obtient les relations de la personne.
     *
     * @param string $tableName Nom de la table.
     * @return string Les relations sur la personne.
     *
    protected function fetchPersonRelations(string $tableName): string {
        return self::fetchAttribute("relations", $tableName, $this->getId());
    }

    /**
     * Modifie les relations que Person a.
     *
     * @param string $relations Nouvelles relations.
     *
    public function setRelations(string $relations): void
    {
        $this->relations = $relations;
    }

    /**
     * Modifie les relations que Person a.
     *
     * @param string $relations Nouvelles relations.
     * @param string $tableName Nom de la table.
     *
    protected function updateRelations(string $relations, string $tableName): void
    {
        $this->updateAttribute("relations", $relations, $tableName, $this->id);
        $this->setRelations($relations);
    }*/

    /**
     * Obtient les disponibilités de la personne.
     *
     * @return string Disponibilités.
     */
    public function getAvailabilities(): string {
        return $this->availabilities;
    }

    /**
     * Obtient les disponibilités de la personne.
     *
     * @param string $tableName Nom de la table.
     * @return string Disponibilités.
     */
    protected function fetchPersonAvailabilities(string $tableName): string {
        return self::fetchAttribute("availabilities", $tableName, $this->getId());
    }

    /**
     * Modifie les disponibilités de Person.
     *
     * @param string $availabilities Nouvelles disponibilités.
     */
    public function setAvailabilities(string $availabilities): void
    {
        $this->availabilities = $availabilities;
    }

    /**
     * Modifie les disponibilités de Person.
     *
     * @param string $availabilities Nouvelles disponibilités.
     * @param string $tableName Nom de la table.
     */
    protected function updatePersonAvailabilities(string $availabilities, string $tableName): void
    {
        $this->updateAttribute("availabilities", $availabilities, $tableName, 'id', $this->id);
        $this->setAvailabilities($availabilities);
    }

    /**
     * Obtient les vacances de la personne.
     *
     * @return string Vacances.
     */
    public function getHolidays(): string {
        return $this->holidays;
    }

    /**
     * Obtient les vacances de la personne.
     *
     * @param string $tableName Nom de la table.
     * @return string Vacances.
     */
    protected function fetchPersonHolidays(string $tableName): string {
        $this->setHolidays(self::fetchAttribute("holidays", $tableName, $this->getId()));
        return $this->getHolidays();
    }

    /**
     * Modifie les vacances de Person.
     *
     * @param string $holidays Nouvelles vacances.
     */
    public function setHolidays(string $holidays): void
    {
        $this->holidays = $holidays;
    }

    /**
     * Modifie les vacances de Person.
     *
     * @param string $holidays Nouvelles vacances.
     * @param string $tableName Nom de la table.
     */
    public function updatePersonHolidays(string $holidays, string $tableName): void
    {
        $this->updateAttribute("holidays", $holidays, $tableName, 'id', $this->id);
        $this->setHolidays($holidays);
    }

    /**
     * Obtient l'état d'interdiction de la personne.
     *
     * @return bool État d'interdiction.
     */
    public function isBanned(): bool {
        return $this->banned;
    }

    /**
     * Obtient l'état d'interdiction de la personne.
     *
     * @param string $tableName Nom de la table.
     * @return bool État d'interdiction.
     */
    protected function fetchPersonBanned(string $tableName): bool {
        return self::fetchAttribute("banned", $tableName, $this->getId());
    }

    /**
     * Modifie l'état d'interdiction de Person.
     *
     * @param bool $banned Nouvelle état d'interdiction.
     */
    public function setBanned(bool $banned): void
    {
        $this->banned = $banned;
    }

    /**
     * Modifie l'état d'interdiction de Person.
     *
     * @param bool $banned Nouvelle état d'interdiction.
     * @param string $tableName Nom de la table.
     */
    public function updatePersonBanned(bool $banned, string $tableName): void
    {
        $this->updateAttribute("banned", $banned, $tableName, 'id', $this->id);
        $this->setBanned($banned);
    }

    /**
     * Obtient l'état d'inactivité de la personne.
     *
     * @return bool État d'inactivité.
     */
    public function isInactive(): bool {
        return $this->inactive;
    }

    /**
     * Obtient l'état d'inactivité de la personne.
     *
     * @param string $tableName Nom de la table.
     * @return bool État d'inactivité.
     */
    protected function fetchPersonInactive(string $tableName): bool {
        return self::fetchAttribute("inactive", $tableName, $this->getId());
    }

    /**
     * Modifie l'état d'inactivité de Person.
     *
     * @param bool $inactive Nouvelle état d'inactivité.
     */
    public function setInactive(bool $inactive): void
    {
        $this->inactive = $inactive;
    }

    /**
     * Modifie l'état d'inactivité de Person.
     *
     * @param bool $inactive Nouvelle état d'inactivité.
     * @param string $tableName Nom de la table.
     */
    public function updatePersonInactive(bool $inactive, string $tableName): void
    {
        $this->updateAttribute("inactive", $inactive, $tableName, 'id', $this->id);
        $this->setInactive($inactive);
    }

    /**
     * Obtient date de création du profil de la personne.
     *
     * @return string Date de création du profil.
     */
    public function getCreationDate(): string {
        return $this->creation_date;
    }

    /**
     * Obtient date de création du profil de la personne.
     *
     * @param string $tableName Nom de la table.
     * @return string Date de création du profil.
     */
    protected function fetchPersonCreationDate(string $tableName): string {
        return self::fetchAttribute("creation_date", $tableName, $this->getId());
    }

    /**
     * Modifie la date de création du profil de la personne.
     *
     * @param string $date Nouvelle date.
     * @precondition $date doit être dans le format Ymd "20010314" ou vide pour
     * qu'elle devienne la date du jour actuel.
     */
    protected function setCreationDate(string $date = ""): void
    {
        //assert(validDate($date));
        $this->creation_date = initDate($date);
    }

    /**
     * Modifie la date de création de la personne.
     *
     * @param string $date Nouvelle date.
     * @param string $tableName Nom de la table.
     * @precondition $date doit être dans le format Ymd "20010314" ou vide.
     */
    protected function updatePersonCreationDate(string $date = "", string $tableName): void
    {
        //assert(validDate($date));
        $date = initDate($date);
        $this->updateAttribute("creation_date", $date, $tableName, 'id', $this->getId());
        $this->setCreationDate($date);
    }


    /*====================*/
    /* MÉTHODES GÉNÉRALES */
    /*====================*/

    /**
     * Génère un objet Person en fonction de son identifiant et de sa table.
     *
     * @param int $id Identifiant de la personne.
     * @return mixed Personne instanciée.
     */
    abstract static protected function fromId(int $id);

    /**
     * Obtient la valeur d'un des attributs d'une table.
     *
     * @param string $attribute Nom de la colone de l'attribut recherché.
     * @param string $tableName Nom de la table de la base de donnée.
     * @param int $id Identifiant de l'enregistrement.
     * @return mixed Valeur de l'attibut recherché.
     */
    protected static function fetchAttribute(string $attribute, string $tableName, int $id)
    {
        $conn = SQLConnector::createConn();
        try {
            $result = $conn->query("SELECT {$attribute} FROM {$tableName} WHERE id = ".$id);
            if (!$result)
            {
                die("Requête invalide: " . mysql_error() . "<br>");
            }
            if ($result->num_rows > 1) {
                die("Plus d'un des enregistrements de la table $tableName possèdent le même identifiant".
                    "Vérifiez l'intégrité de la base de donnée.");
            }
            $row = $result->fetch_array(MYSQLI_NUM);

        } catch (Exception $e) {
            die("Une erreur s'est produite durant la connexion de la base de donnée.");
        } finally {
            $conn->close();
        }
        return $row[0];
    }

    /**
     * Obtient la valeur d'un des attributs d'une table.
     *
     * @param string $attribute Nom de la colone de l'attribut recherché.
     * @param string $tableName Nom de la table de la base de donnée.
     * @param string $codeName Nom de la colone du code recherché.
     * @param string $code Code de la valeur recherchée.
     * @return mixed Valeur de l'attibut recherché.
     */
    protected static function fetchAttributeFromCode(string $attribute, string $tableName, string $codeName, string $code)
    {
        $conn = SQLConnector::createConn();
        try {
            $result = $conn->query("SELECT {$attribute} FROM {$tableName} WHERE {$codeName} = ".$code);
            if (!$result)
            {
                die("Requête invalide: " . mysql_error() . "<br>");
            }
            if ($result->num_rows > 1) {
                die("Plus d'un des enregistrements de la table $tableName possèdent le même identifiant".
                    "Vérifiez l'intégrité de la base de donnée.");
            }
            $row = $result->fetch_array(MYSQLI_NUM);

        } catch (Exception $e) {
            die("Une erreur s'est produite durant la connexion de la base de donnée.");
        } finally {
            $conn->close();
        }
        return $row[0];
    }



    /**
     * Obtient une liste d'identifiant associé à celui recherché.
     *
     * @param int $id Identifiant de l'association.
     * @param string $foreingKey Nom de la colonne de l'identifiant de l'association.
     * @param string $attribute Nom de la colonne de l'attribut recherché.
     * @param string $tableName Nom de la table de la base de donnée.
     * @return array Liste d'identifiant associé à celui recherché.
     */
    protected static function fetchAssociations(int $id, string $foreingKey,
                                                string $attribute, string $tableName): array
    {
        $conn = SQLConnector::createConn();
        $associations = array();
        try {
            $result = $conn->query("SELECT {$attribute} FROM {$tableName} WHERE {$foreingKey} = ".$id);
            if ($result < 1)
            {
                return $associations;
            }
            if (!$result)
            {
                die("Requête invalide: " . mysql_error() . "<br>");
            }
            while ($row = $result->fetch_array(MYSQLI_NUM))
            {
                array_push($associations, $row[0]);
            }

        } catch (Exception $e) {
            die("Une erreur s'est produite durant la connexion de la base de donnée.");
        } finally {
            $conn->close();
        }
        return $associations;
    }

    /**
     * Mets à jour la valeur d'un des attributs d'une table.
     *
     * @param string $attribute Nom de la colone de l'attribut recherché.
     * @param mixed $var Nouvelle valeur de l'attribut.
     * @param string $tableName Nom de la table de la base de donnée.
     * @param string $codeCol Nom de la colone d'ont on recherche une valeur.
     * @param int $code Identifiant de l'enregistrement.
     * @return mixed Valeur de l'attibut recherché.
     */
    protected static function updateAttribute(string $attribute, $var, string $tableName, string $codeCol, int $code) : bool
    {
        $conn = SQLConnector::createConn();
        try {
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            $result = $conn->query("SELECT {$codeCol} FROM {$tableName} WHERE {$codeCol} = ".$code);
            if (!$result)
            $result = $conn->query("UPDATE {$tableName} SET {$attribute} = {$var} WHERE {$codeCol} = ".$code);


        } catch (Exception $e) {
            die("Une erreur s'est produite durant la connexion de la base de donnée.");
        } finally {
            $conn->close();
        }
        return true;

        /*$type = "";
        switch (get_class($var)) {
            case "string": $type = "s";
                break;
            case "int": $type = "i";
                break;
            case "bool": $type = "b";
                break;
            case "double": $type = "d";
                break;
        }
        $result->bind_param($type,$var);
        $result->execute();*/
    }


    /**
     * @return array Liste des attributs de la personne.
     */
    abstract public function getAttributes(): array;

    /**
     * Recherche les données de Person en fonction de son identifiant.
     *
     * @param mysqli $conn Connexion au serveur.
     * @param string $tableName Nom de la table.
     * @param int $id Identifiant de la personne recherchée.
     * @return array Résultat de la requête.
     * @postcondition Doit fermer la connexion dès qu'elle n'est plus utilisée.
     */
    protected static function fetchAttributes(mysqli $conn, string $tableName, $id): array
    {
        $row = null;
        try {
            $stat = $conn->prepare("SELECT * FROM {$tableName} WHERE id=".$id);
            $stat->execute();
            $rs = $stat->get_result();

            if (!$rs) {
                die("Requête invalide: " . mysql_error() . "<br>");
            }
            $row = $rs->fetch_array(MYSQLI_NUM);

        } catch (Exception $e) {
            die("Une erreur s'est produite dans la connexion à la base de donnée.");
        }
        return $row;
    }

    abstract public function update(): bool;

    /**
     * Mets à jours tout les attributs de la personne.
     *
     * @param string $tableName Nom de la table correspondant à la personne.
     * @return bool Vrai si toutes les attributs ont été mis à jours.
     */
    protected function updatePerson(string $tableName): bool
    {
        if (empty($this->id))
        {
            return false;
            //return $this->insertPerson($tableName);
        }

        $conn = SQLConnector::createConn();
        try {
            if ($conn->connect_error) {
                return false;
            }
            $stat = $conn->prepare("UPDATE {$tableName} SET ".
                "address = ?, gender = ?, first_name = ?, name = ?, birthday = ?, email = ?,".
                "phone_number = ?, profile_image_url = ?, profile_info = ?, comments = ?,".
                "availabilities = ?, holidays = ?, banned = ?, inactive = ?, creation_date = ?".
                " WHERE id = ".$this->getId());
            $stat->bind_param('iissssssssssbbs',
                $this->address, $this->gender, $this->first_name, $this->name, $this->birthday, $this->email,
                $this->phone_number, $this->profile_image_url, $this->profile_info, $this->comments,
                $this->availabilities, $this->holidays, $this->banned, $this->inactive, $this->creation_date);

            $stat->execute();
            if (!$stat->get_result())
            {
                return false;
            }
            /*$stat = $conn->prepare("UPDATE {$tableName} SET ? = ? WHERE id = ".$this->getId());
            foreach (get_object_vars($this) as $attribute => $test)
            {
                //self::COL_NAMES
                switch (get_class($attribute)) {
                    case "string": $type = "s";
                        break;
                    case "int": $type = "i";
                        break;
                    case "bool": $type = "b";
                        break;
                    case "double": $type = "d";
                        break;
                    default: die("Erreur dans le type de l'attribut de Person.");
                        break;
                }
                $stat->bind_param('s'.$type,$attribute, );

                $stat->execute();
                if (!$stat->get_result())
                {
                    return false;
                }
            }*/

        } catch (Exception $e) {
            return false;
        } finally {
            $conn->close();
        }
        return true;
    }

    /**
     * Ajoute la personne dans la base de données.
     *
     * @return int Identifiant de la personne dans la base de donnée.
     */
    abstract public function insert(): int;

    /**
     * Ajoute la personne dans la base de données.
     *
     * @param string $tableName
     * @return int Identifiant de la personne dans la base de donnée.
     */
    protected function insertPerson(string $tableName): int {
        // check si l'id est déjà utilisé dans la table
        $conn = SQLConnector::createConn();
        try {
            if ($conn->connect_error) {
                return false;
            }
            $stat = $conn->query("INSERT INTO {$tableName} ".
                "(id, address, gender, first_name, name, birthday, email,".
                "phone_number, profile_image_url, profile_info, comments,".
                "availabilities, holidays, banned, inactive, creation_date".
                " VALUES ({$this->id},{$this->address},{$this->gender},{$this->first_name},{$this->name},".
                "{$this->birthday},{$this->email},{$this->phone_number},".
                "{$this->profile_image_url},{$this->profile_info},{$this->comments},".
                "{$this->availabilities},{$this->holidays},{$this->banned},{$this->inactive},{$this->creation_date}");

            $this->setId($conn->insert_id);

        } catch (Exception $e) {
            return false;
        } finally {
            $conn->close();
        }
        return $this->getId();
    }

    /**
     * Efface les informations de la personne
     */
    public function clear() : void {
        $this->id = 0;
        $this->gender = 0;
        $this->first_name = "";
        $this->name = "";
        $this->birthday = "";
        $this->email = "";
        $this->phone_number = "";
        $this->profile_image_url = "";
        $this->profile_info = "";
        $this->comments = "";
        //$this->relations = "";
        $this->availabilities = "";
        $this->holidays = "";
        $this->banned = "";
        $this->inactive = "";
        $this->creation_date = "";
    }

    /**
     * Ajoute les données d'une personne dans une ligne d'un tableau.
     */
    abstract public function printRow();

    /**
     * Ajoute les données de la personne dans des cellules d'une ligne.
     */
    protected function printParentCells(){
        echo "<td>{$this->getFirstname()}</td><td>{$this->getLastname()}</td><td>{$this->getEmail()}</td><td>{$this->getPhoneNumber()}</td>";
    }

    /**
     * @return string Information sur la personne.
     */
    public function __toString(): string
    {
        return self::getFullname().", ".self::getEmail();
    }

    public function print(): void
    {
        echo $this->__toString();
    }
}