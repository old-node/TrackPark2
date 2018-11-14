<?php
/**************************************************************************************
Fichier :       EvaluationManager.class.php
Auteur :        Francis Forest
Fonctionnalité : Classe qui fait la gestion des évaluations des épreuves.
Date :          24 avril 2018
=======================================================================================
Vérification :
Date        Nom	                    Approuvé
2018-05-06  Olivier Lemay Dostie    Doit exclure l'épreuve avec
 * l'identifiant 0 dans le chargement, sinon OK.
=======================================================================================
Historique de modification :
Date        Nom	                    Description
2018-04-24  Francis Forest          Création
2018-04-28  Olivier Lemay Dostie    Versionnement pour merger
**************************************************************************************/

include_once "Evaluation.class.php";
include_once 'SQLConnector.class.php';

/**
 * Classe EvaluationManager
 */
class EvaluationManager
{
    /** get les evaluations de la base de données
     * @return array Evaluation
     */
    public static function loadEvaluations()
    {
        $evaluations = [];
        $conn = SQLConnector::createConn();
        $stat = $conn->prepare("SELECT * FROM evaluation");
        $stat->execute();
        $result = $stat->get_result();

        if (!$result)
        {
            die("Requête invalide: " . mysql_error() . "<br>");
        }

        while ($row = $result->fetch_array(MYSQLI_NUM))
        {
            $e = new Evaluation($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[9], $row[10]);
            array_push($evaluations, $e);
        }

        $conn->close();
        return $evaluations;
    }

    /** get l'evaluation selon l'id
     * @param $id id de l'évaluation
     * @return Evaluation
     */
    public static function loadEvaluation($id)
    {
        $conn = SQLConnector::createConn();
        $stat = $conn->prepare("SELECT * FROM evaluation WHERE evaluation.id = ?;");
        $stat->bind_param("i", $id);
        $stat->execute();
        $result = $stat->get_result();

        $row = $result->fetch_array(MYSQLI_NUM);
        $e = new Evaluation($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[9], $row[10]);

        return $e;
    }

    /** ajoute une évaluation à la base de données
     * @param Evaluation $e
     * @return int id de la nouvelle évaluation
     */
    public static function addEvaluation(Evaluation $e): int
    {
        $field = $e->getFieldID();
        $coach = $e->getCoachID();
        $drill = $e->getDrillID();
        $athlete = $e->getAthleteID();
        $periode = $e->getPeriodID();
        $date = $e->getDate();
        $nm = $e->getNumericalValue();
        $rm = $e->getResultMessage();
        $rs = $e->getResultState();
        $c = $e->getCommentary();
        $o = 0;

        #addEvaluationDB
        $conn = SQLConnector::createConn();
        $stat = $conn->prepare("INSERT INTO evaluation (field, coach, drill, athlete, period, date, numerical_value, result_message, result_state, comment, obsolete) VALUES (?,?,?,?,?,?,?,?,?,?,?);");
        $stat->bind_param("iiiiisdsisi", $field, $coach, $drill, $athlete, $periode, $date, $nm, $rm, $rs, $c, $o);
        $stat->execute();

        return $stat->insert_id;
    }

    /** supprime un évaluation de la base de données
     * @param $e Evaluation
     */
    public static function removeEvaluation($e)
    {
        $id = $e->getID();
        $conn = SQLConnector::createConn();
        $stat = $conn->prepare("DELETE FROM evaluation WHERE id = ?;");
        $stat->bind_param("i", $id);
        $stat->execute();
        $conn->close();
    }

    /** update les infos d'une évaluation dans la base de données
     * @param $e Evaluation
     */
    public static function updateEvaluation($e)
    {
        $field = $e->getFieldID();
        $coach = $e->getCoachID();
        $drill = $e->getDrillID();
        $athlete = $e->getAthleteID();
        $periode = $e->getPeriodID();
        $date = $e->getDate();
        $nm = $e->getNumericalValue();
        $rm = $e->getResultMessage();
        $rs = $e->getResultState();
        $c = $e->getCommentary();
        $id = $e->getID();
        $o = 0;

        #UPDATE evaluation
        $conn = SQLConnector::createConn();
        $stat = $conn->prepare("UPDATE evaluation SET field = ?, coach = ?, drill = ?, athlete = ?, period = ?, date = ?, numerical_value = ?, result_message = ?, result_state = ?, comment = ?, obsolete = ?  WHERE id = ?;");
        $stat->bind_param("iiiiisdsisii", $field, $coach, $drill, $athlete, $periode, $date, $nm, $rm, $rs, $c, $o, $id);
        $stat->execute();
        $conn->close();
    }

    /** get le prochain id de la table evaluation
     * @return int prochain id de la table evaluation
     */
    public static function getNextEvaluationID()
    {
        $conn = SQLConnector::createConn();
        $stat = $conn->prepare("SELECT MAX(id) FROM evaluation;");
        $stat->execute();
        $result = $stat->get_result();

        $row = $result->fetch_array(MYSQLI_NUM);
        $id = $row[0] + 1;
        $conn->close();
        return $id;

    }
}