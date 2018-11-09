<?php
/**************************************************************************************
Fichier :       PersonManager.class.php
Auteur :		Olivier Lemay Dostie
Fonctionallité : Classe qui fait la gestion des personnes.
Date :          2 mai 2018
=======================================================================================
Vérification :
Date		Nom					    Approuvé
=======================================================================================
Historique de modification :
Date	    Nom                     Description
2018-05-02  Olivier Lemay Dostie    Création
**************************************************************************************/

include_once "./Person.class.php";

/**
 * Classe PersonManager
 */
abstract class PersonManager
{
    /**
     * @var array Liste des personnes à gérer.
     */
    protected static $persons = array();

    /**
     *
     * @return bool
     */
    abstract static public function init();

    /**
     * Obtient le tableau de personne dans l'objet PersonManager à partir de la BD.
     *
     * @param string $tableName Nom de la table.
     * @return mysqli_result Résultat de la requête.
     */
    protected static function initManager(string $tableName) : mysqli_result
    {
        self::clear();
        $result = null;
        $conn = SQLConnector::createConn();
        try {
            $result = self::loadPersons($tableName);

        } catch (Exception $e) {
            die("Erreur durant l'initialisation de PersonManager.");
        } finally {
            $conn->close();
        }
        return $result;
    }


    /**
     * Modifie la liste des personnes.
     *
     * @param array $persons Nouvelle liste de personne.
     */
    public static function setPersons(array $persons) : void {
        self::clear();
        self::addPersons($persons);
    }

    /**
     * Ajoute une liste de personnes à la liste.
     *
     * @param array $persons Liste aditionnelle de personnes.
     */
    public static function addPersons(array $persons) : void {
        if (!is_array($persons)) {
            die('Le paramètre $persons doit être un tableau.');
        }
        try {
            foreach ($persons as $a) {
                self::addPerson($a);
            }
        } catch (Exception $e) {
            die("Une erreur s'est produite lors de l'ajout des personnes.");
        }
    }

    /**
     * Ajoute une personne à la liste.
     *
     * @return int Identifiant de la personne.
     * @param Person $p Personne à ajouter dans la liste.
     * @precondition $p doit être du type Personne.
     */
    public static function addPerson(Person $p) : int {
        if (!is_a($p, 'Person')) {
            die("Un des objets du tableau de Person n'est pas du bon type.");
        } else {
            array_push(self::$persons, $p);
        }
        return $p->getId();
    }

    /**
     * Retire un des athlète de la liste.
     *
     * @param int $index Index de la personne à retirer.
     * @return Person Personne retirée de la liste.
     */
    public static function removePerson(int $index) : Person {
        if ($index < 0 || $index >= self::count()) {
            die("Index à l'extérieur de la plage de la liste.");
        }
        $p = self::$persons[$index];
        unset(self::$persons[$index]);
        return $p;
    }

    /**
     * @return int Nombre de personne dans la liste.
     */
    public static function count() : int {
        return count(self::$persons);
    }

    /**
     * Vérifie si la liste de personne est vide.
     *
     * @return bool Etat du contenu vide de la liste.
     */
    public static function empty() : bool {
        return empty(self::$persons);
    }

    /**
     * Efface le contenu de la liste de personne.
     */
    public static function clear() : void {
        self::$persons = array();
    }

    /**
     * Enlève une personne de la base de donnée.
     *
     * @param string $tableName Nom de la table.
     * @param int $index Index de la personne à retirer.
     * @return bool Résultat du succès de la requête.
     * @precondition
     * @postcondition
     */
    protected static function deletePerson(string $tableName, int $index) : bool {
        $conn = SQLConnector::createConn();
        $success = false;
        try {
            $stat = $conn->prepare("DELETE FROM {$tableName} WHERE id = ".self::$persons[$index]->getId());
            $success = $stat->execute();
            if ($success) {
                self::removePerson($index);
            }

        } catch (Exception $e) {
            return false;
        } finally {
            $conn->close();
        }
        return $success;
    }

    /**
     * Construit une chaine de caractère contenant des paramètres.
     *
     * @param array $params Liste des paramètres à concatener.
     * @return string Chaine de caractère des paramètres.
     */
    protected static function appendParam(array $params) : string {
        $query = "";
        $count = count($params);
        foreach ($params as $key => $param) {
            $query .= $param;
            if ($key != $count) {
                $query .= ", ";
            }
        }
        return $query;
    }

    /**
     * Construit une chaine de caractère contenant des paramètres couplés.
     *
     * @param array $paramsA Liste des paramètres à concatener.
     * @param array $paramsB Liste des paramètres à concatener.
     * @return string Chaine de caractère des paramètres.
     * @precondition $params1 et $params2 doivent être de même taille.
     * @postcondition Le résultat est sous la forme 'a1 = a2 AND b1 = b2 ...'
     */
    protected static function appendCouple(array $paramsA, array $paramsB) : string {
        $query = "";
        if (count($paramsA) != count($paramsB)) {
            die("Les deux tableaux doivent contenir le même nombre d'élément.");
        }
        $count = count($paramsA);
        foreach ($paramsA as $key => $param) {
            $query .= $param ." = ". $paramsB[$key];
            if ($key != $count) {
                $query .= " AND ";
            }
        }
        return $query;
    }

    /**
     * Obtient les personnes de la base de donnée ayant les valeurs recherchés.
     *
     * @param string $tableName Nom de la table de la personne.
     * @param array $cols Colonnes où l'on compare les valeurs.
     * @param array $values Valeurs qu'on vérifie la similarité.
     * @return array Personnes correspondants de la base de donnée.
     * @precondition ...
     * @postcondition ...
     */
    protected static function select(string $tableName, array $cols, array $values = array()) : array {
        $conn = SQLConnector::createConn();
        $persons = array();
        try {
            $query = "SELECT * FROM ".$tableName;
            //* (En création, la méthode modulaire ne sera p-e pas fonctionnelle)
            //* @param array $results Colonnes recherchées.
            //$query .= self::appendParam($results);

            if (count($values) > 0) {
                $query .= " WHERE ";
                $query .= self::appendCouple($cols, $values);
            }

            $stat = $conn->prepare($query);
            $stat->execute();
            $rs = $stat->get_result();
            if (!$rs) {
                die("Requête invalide: " . mysql_error() . "<br>");
            }
            while ($row = $rs->fetch_array(MYSQLI_NUM)) {
                /*$p = Person::fromId($row[0]);
                $p->initPerson($row);
                array_push($persons, $p);*/
            }

        } catch (Exception $e) {
            return array();
        } finally {
            $conn->close();
        }
        return $persons;
    }

    /**
     * Obtient la liste des personnes.
     *
     * @return array Personnes du gesionnaire.
     */
    public static function getPersons() : array {
        return self::$persons;
    }

    /**
     * Obtient la personne ayant l'identifiant.
     *
     * @param int $id Identifiant de la personne.
     * @return Person Personne correspondant.
     */
    public static function getPerson(int $id) : Person
    {
        assert(isset(self::$persons));
        assert(isset($id));
        foreach (self::$persons as $a) {
            if ($a->getId() == $id) {
                return $a;
            }
        }
        return null;
    }

    /**
     * Obtient les indexes des personnes comprits dans la liste.
     *
     * @param array $persons Personnes recherchés.
     * @return array Indexes des personnes recherchés.
     */
    public static function getPersonIndexes(array $persons) : array {
        $indexes = array();
        try {
            foreach ($persons as $i) {

                foreach (self::$persons as $index => $a) {
                    if ($a->getId() == $i->getId()) {
                        array_push($indexes, $index);
                    }
                }
            }
            return $indexes;
        } catch (Exception $e) {
            return array();
        }
    }

    /**
     * Obtient les athlètes correspondant aux indexes de la liste.
     *
     * @param array $indexes Indexes des athlètes recherchés.
     * @return array Athlètes recherchés.
     */
    public static function getIndexedPersons(array $indexes) : array {
        $persons = array();
        try {
            foreach ($indexes as $i) {
                array_push($persons, self::$persons[$i]);
            }
            return $persons;
        } catch (Exception $e) {
            return array();
        }
    }

    /**
     * Ajoute un athlète à la base de donnée.
     *
     * @param array $a Données d'un nouveau athlète.
     * @return int Index de l'athlète inséré dans la base de donnée.
     */
    abstract public static function insertFromRow(array $a) : int;

    /**
     * Charge les identifiants des personnes à partir de la base de données.
     *
     * @param string $tableName Nom de la table.
     * @return mysqli_result Liste des identifiants des personnes.
     */
    protected static function loadPersons(string $tableName): mysqli_result
    {
        $result = null;
        $conn = SQLConnector::createConn();
        try {
            $result = $conn->query("SELECT id FROM ".$tableName);

        } catch (Exception $e) {
            return null;
        } finally {
            $conn->close();
        }

        return $result;
    }

    /**
     * Mets à jour toutes les personnes dans la base de données.
     *
     * @return bool État de complétion de la mis à jour.
     */
    public static function updatePersons(): bool
    {
        foreach (self::$persons as $p) {
            if (!$p->update())
            {
                return false;
            }
        }
        return true;
    }
}