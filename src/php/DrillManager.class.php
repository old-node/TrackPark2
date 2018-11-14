<?php
/**************************************************************************************
Fichier :       DrillManager.class.php
Auteur :	    Francis Forest
Fonctionallité : Gestionnaire des épreuves.
Date :          25 avril 2018
=======================================================================================
Vérification :
Date        Nom                     Approuvé
2018-05-06  Olivier Lemay Dostie    Doit exclure l'épreuve avec
 * l'identifiant 0 dans le chargement, sinon OK.
=======================================================================================
Historique de modification :
Date        Nom                     Description
2018-04-25  Francis Forest          Création
2018-04-28  Olivier Lemay Dostie    Versionnement pour merger
**************************************************************************************/

include_once "SQLConnector.class.php";
include_once "Drill.class.php";

/**
 * Classe DrillManager
 */
class DrillManager
{

    /** get les drills de la base de données
     * @return array Drill
     */
    public static function loadDrills()
    {
        $drills = [];
        $conn = SQLConnector::createConn();

        $stat = $conn->prepare("SELECT * FROM drill");
        $stat->execute();
        $result = $stat->get_result();

        if (!$result)
        {
            die("Requête invalide: " . mysql_error() . "<br>");
        }

        while ($row = $result->fetch_array(MYSQLI_NUM))
        {
            $d = new Drill($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[9]);
            array_push($drills, $d);
        }

        $conn->close();
        return $drills;
    }

    /** get un drill selon le id
     * @param $id
     * @return Drill
     */
    public static function loadDrill($id)
    {
        $conn = SQLConnector::createConn();
        $stat = $conn->prepare("SELECT * FROM drill WHERE drill.id = ?");
        $stat->bind_param("i", $id);
        $stat->execute();
        $result = $stat->get_result();
        $row = $result->fetch_array(MYSQLI_NUM);

        $d = new Drill($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[9]);
        return $d;

    }

    /** Supprime un drill de la base de données
     * @param $drill Drill
     */
    public static function removeDrill($drill)
    {
        $id = $drill->getID();
        //DELETE FROM evaluation
        $conn = SQLConnector::createConn();
        $stat = $conn->prepare("DELETE FROM evaluation WHERE drill = ?;");
        $stat->bind_param("i", $id);
        $stat->execute();
        $conn->close();

        //DELETE from ta_course_drill
        $conn = SQLConnector::createConn();
        $stat = $conn->prepare("DELETE FROM ta_course_drill WHERE drill = ?;");
        $stat->bind_param("i", $id);
        $stat->execute();
        $conn->close();


        //DELETE FROM drill
        $conn = SQLConnector::createConn();
        $stat = $conn->prepare("DELETE FROM drill WHERE id = ?;");
        $stat->bind_param("i", $id);
        $stat->execute();
        $conn->close();
    }

    /** Modifie les informations d'un drill dans la base de données
     * @param Drill $newDrill
     */
    public static function updateDrill(Drill $drill)
    {
        #UPDATE drill
        $obsolete = 0;
        $type = $drill->getTypeID();
        $name = $drill->getName();
        $goal = $drill->getGoal();
        $aTries = $drill->getAllowedTries();
        $sT = $drill->getSuccessThreshold();
        $aTime = $drill->getAllowedTime();
        $fT = $drill->getFailureThreshold();
        $id = $drill->getID();
        $cap = $drill->getCap();

        $conn = SQLConnector::createConn();
        $stat = $conn->prepare("UPDATE drill SET cap = ?, drill_type = ?, name = ?, goal = ?, allowed_tries = ?, success_treshold = ?, allowed_time = ?, failure_treshold = ?, obsolote = ? WHERE id = ?;");
        $stat->bind_param("sissddddii", $cap, $type, $name, $goal, $aTries, $sT, $aTime, $fT, $obsolete, $id);
        $stat->execute();
        $conn->close();
    }

    /** ajoute un drill dans la base de données
     * @param $drill Drill
     * @return int id du nouveau drill
     */
    public static function addDrill($drill)
    {
        $obsolete = 0;
        $type = $drill->getTypeID();
        $name = $drill->getName();
        $goal = $drill->getGoal();
        $aTries = $drill->getAllowedTries();
        $sT = $drill->getSuccessThreshold();
        $aTime = $drill->getAllowedTime();
        $fT = $drill->getFailureThreshold();
        $cap = $drill->getCap();



        $conn = SQLConnector::createConn();
        $stat = $conn->prepare("INSERT INTO drill (cap, drill_type, name, goal, allowed_tries, success_treshold, allowed_time, failure_treshold, obsolote) VALUES (?,?,?,?,?,?,?,?,?);");
        $stat->bind_param("sissddddi", $type, $cap, $name, $goal, $aTries, $sT, $aTime, $fT, $obsolete);
        $stat->execute();

        return $stat->insert_id;
    }

    /** get le prochain id de la table drill
     * @return int prochain id de la drill
     */
    public static function loadNextDrillID()
    {
        $conn = SQLConnector::createConn();
        $stat = $conn->prepare("SELECT MAX(id) FROM drill;");
        $stat->execute();
        $result = $stat->get_result();

        $row = $result->fetch_array(MYSQLI_NUM);
        $id = $row[0] + 1;
        $conn->close();
        return $id;
    }
}