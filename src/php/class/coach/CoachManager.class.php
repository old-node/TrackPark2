<?php
/**************************************************************************************
Fichier :       Coach.class.php
Auteur :		Olivier Lemay Dostie
Fonctionallité : Classe qui fait la gestion des évaluateurs.
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

include_once './PersonManager.class.php';
include_once './Coach.class.php';

/**
 * Classe CoachManager
 */
class CoachManager extends PersonManager
{

    /**
     * Initialise le tableau de personne dans l'objet CoachManager à partir de la BD.
     */
    public static function init()
    {
        $coachs = array();
        $conn = SQLConnector::createConn();
        try {
            if (!$result = parent::initManager(Coach::TABLE_NAME)) {
                die("Erreur durant l'initialisation de CoachManager.");
            }

            while ($row = $result->fetch_assoc())
            {
                $c = Coach::fromId($row['id']);
                array_push($coachs, $c);
            }
        } catch (Exception $e) {
            die("Erreur durant l'initialisation de AthleteManager.");
        } finally {
            $conn->close();
        }
        self::setPersons($coachs);
    }

    public static function insertFromAttributes($id = 0, $address, $genre, $first_name, $name,
                                                $birthday, $email, $phone_number,
                                                $profile_image_url, $profile_info, $comments): int
    {
        $insert_id = 0;
        $conn = SQLConnector::createConn();
        try {
            $coachs = Coach::fromId($id);
            $coachs->initCoach(
                $id, $address, $genre, $first_name, $name,
                $birthday, $email, $phone_number,
                $profile_image_url, $profile_info, $comments);
            //méthode if exists à ajouter dans Coach pour vérifier si l'iden
            $insert_id = $coachs->insert();
            if ($id != $insert_id)
            {
                self::addPerson($coachs);
            }

        } catch (Exception $a) {
            die("Une erreur s'est produite lors de l'ajout de l'athlète.");
        } finally {
            $conn->close();
        }

        return $insert_id;
    }

    /**
     * @inheritdoc
     * @precondition
     * @postcondition
     */
    public static function insertFromRow(array $a) : int {
        return self::insertFromAttributes(
            $a[0], $a[1], $a[2], $a[3], $a[4], $a[5],
            $a[6], $a[7], $a[8], $a[9], $a[10]);
    }

    /**
     * Charge les évaluateurs à partir de la base de données.
     *
     * @return bool État de complétion du chargement.
     */
    public static function loadCoachs(): bool
    {
        $persons = [];
        $conn = SQLConnector::createConn();
        try {
            $result = parent::loadPersons(Coach::TABLE_NAME);
            while ($row = $result->fetch_array(MYSQLI_NUM))
            {
                $a = Coach::fromId($row[0]);
                array_push($persons, $a);
            }

        } catch (Exception $e) {
            return false;
        } finally {
            $conn->close();
        }

        self::setPersons($persons);
        return true;
    }

    /**
     *
     *
     * @param Coach $coach Évaluateur à mettre à jours.
     * @return bool État de complétion de la mise à jour.
     */
    public static function updateCoach(Coach $coach): bool
    {
        //TODO: self::$persons[$athlete->getId()] = $athlete;
        return $coach->update();
    }


}