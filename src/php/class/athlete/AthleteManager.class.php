<?php
/**************************************************************************************
Fichier :       AthleteManager.class.php
Auteur :		Olivier Lemay Dostie
Fonctionallité : Classe qui fait la gestion d'athlètes à évaluer
Date :          23 avril 2018
=======================================================================================
Vérification :
Date		Nom					    Approuvé
=======================================================================================
Historique de modification :
Date	    Nom                     Description
2018-04-27  Olivier Lemay Dostie    Création
2018-05-02  Olivier Lemay Dostie    Terminer les mises è jour pour être opérationnel.
**************************************************************************************/

include_once './PersonManager.class.php';
include_once './Athlete.class.php';

/**
 * Classe AltheteManager
 */
class AthleteManager extends PersonManager
{

    /**
     * Initialise le tableau d'athlète dans l'objet AthleteManager à partir de la BD.
     */
    public static function init()
    {
        $athletes = array();
        $result = null;
        $conn = SQLConnector::createConn();
        try {
            if (!$result = parent::initManager(Athlete::TABLE_NAME)) {
                die("Erreur durant l'initialisation de AthleteManager.");
            }
            //echo $result->fetch_assoc()[0];
            while ($row = $result->fetch_assoc())
            {
                $a = Athlete::fromId($row['id']);
                array_push($athletes, $a);
            }
        } catch (Exception $e) {
            die("Erreur durant l'initialisation de AthleteManager.");
        } finally {
            $conn->close();
        }
        self::setPersons($athletes);
    }

    public static function insertFromAttributes($id = 0, $address = 0, $athlete_category = 0, $genre = 0, $first_name = "", $name = "",
                                                $birthday = "", $email = "", $phone_number = "",
                                                $profile_image_url = "", $profile_info = "", $comments = ""): int
    {
        $insert_id = 0;
        $conn = SQLConnector::createConn();
        try {
            $athlete = Athlete::fromId($id);
            $athlete->initAthlete(
                $id, $address, $athlete_category, $genre, $first_name, $name,
                $birthday, $email, $phone_number,
                $profile_image_url, $profile_info, $comments);
            //méthode if exists à ajouter dans Athlete pour vérifier si l'iden
            $insert_id = $athlete->insert();
            if ($id != $insert_id)
            {
                self::addPerson($athlete);
            }

        } catch (Exception $a) {
            die("Une erreur s'est produite lors de l'ajout de l'athlète.");
        } finally {
            $conn->close();
        }

        return $insert_id;
    }

    /**
     * Ajoute un athlète à la base de donnée.
     *
     * @param array $a Données d'un nouveau athlète.
     * @return int Index de l'athlète inséré dans la base de donnée.
     * @precondition
     * @postcondition
     */
    public static function insertFromRow(array $a) : int {
        return self::insertFromAttributes(
            $a[0], $a[1], $a[2], $a[3], $a[4], $a[5],
            $a[6], $a[7], $a[8], $a[9], $a[10], $a[11]);
    }



    /**
     * Charge les athlètes à partir de la base de données.
     *
     * @return bool État de complétion du chargement.
     */
    public static function loadAthletes(): bool
    {
        $athletes = [];
        $conn = SQLConnector::createConn();
        try {
            $result = parent::loadPersons(Athlete::TABLE_NAME);
            while ($row = $result->fetch_array(MYSQLI_NUM))
            {
                $a = Athlete::fromId($row[0]);
                array_push($athletes, $a);
            }

        } catch (Exception $e) {
            return false;
        } finally {
            $conn->close();
        }

        self::setPersons($athletes);
        return true;
    }

    /**
     *
     *
     * @param Athlete $athlete Athlète à mettre à jours.
     * @return bool État de complétion de la mise à jour.
     */
    public static function updateAthlete(Athlete $athlete): bool
    {
        //TODO: self::$persons[$athlete->getId()] = $athlete;
        return $athlete->update();
    }

    /**
     * Enlève une casquette à un athlète.
     *
     * @param string $capCode Code de la casquette.
     * @param int $idAthlete Identifiant de l'athlète cible.
     * @return bool État de complétion de la suppression.
     */
    public static function removeCapFromAthlete(string $capCode, int $idAthlete): bool
    {
        $athlete = self::getPerson($idAthlete);
        if (!$athlete->hasCap($capCode))
        {
            return false;
        }
        return $athlete->removeUpdateCap($capCode);
    }

    //TODO check si le merge a bien fonctionné
    public static function getAthletesIndexes(array $athletes) : array
    {
        $indexes = array();
        try {
            foreach ($athletes as $i) {
                if (!is_a($i, 'Athlete')) {
                    if (is_int($i)) {
                        array_push($indexes, $i);
                    } else {
                        die("Doit être un objet de type Athlete.");
                    }
                }
                foreach (self::$athletes as $index => $a) {
                    /* Se fier seullement à l'id ? */
                    if ($a->getId() == $i->getId()) {
                        /** @var int $index Index de l'athlète trouvé. */
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
     * Ajoute une casquette à un athlète.
     *
     * @param string $capCode Code de la casquette.
     * @param int $idAthlete Identifiant de l'athlète cible.
     * @return bool État de complétion de l'ajout.
     */
    public static function addCapToAthlete(string $capCode, int $idAthlete): bool
    {
        // TODO
    }

}