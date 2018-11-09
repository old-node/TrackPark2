<?php
/**************************************************************************************
Fichier :       Evaluation.class.php
Auteur :        Francis Forest
Fonctionnalité : Classe instancie une évaluation d'une épreuve (Drill).
Date :          24 avril 2018
=======================================================================================
Vérification :
Date        Nom	                    Approuvé
2018-05-06  Olivier Lemay Dostie    Oui
=======================================================================================
Historique de modification :
Date        Nom	                    Description
2018-04-24  Francis Forest          Création
2018-04-28  Olivier Lemay Dostie    Versionnement pour merger
**************************************************************************************/

/**
 * Classe Evaluation
 */
class Evaluation implements JsonSerializable
{
    private $ID;
    private $fieldID;
    private $coachID;
    private $drillID;
    private $athleteID;
    private $periodID;
    private $date;
    private $numericalValue;
    private $resultMessage;
    private $resultState;
    private $commentary;

    public function __construct($id, $fID, $cID, $dID, $aID, $pID, $date, $nV, $rM, $rS, $c)
    {
        $this->setID($id);
        $this->setFieldID($fID);
        $this->setCoachID($cID);
        $this->setDrillID($dID);
        $this->setAthleteID($aID);
        $this->setPeriodID($pID);
        $this->setDate($date);
        $this->setNumericalValue($nV);
        $this->setResultMessage($rM);
        $this->setResultState($rS);
        $this->setCommentary($c);
    }

    /**
     * @return mixed
     */
    public function getID()
    {
        return $this->ID;
    }

    /**
     * @param mixed $ID
     */
    public function setID($ID)
    {
        $this->ID = $ID;
    }

    /**
     * @return mixed
     */
    public function getFieldID()
    {
        return $this->fieldID;
    }

    /**
     * @param mixed $fieldID
     */
    public function setFieldID($fieldID)
    {
        $this->fieldID = $fieldID;
    }

    /**
     * @return mixed
     */
    public function getCoachID()
    {
        return $this->coachID;
    }

    /**
     * @param mixed $coachID
     */
    public function setCoachID($coachID)
    {
        $this->coachID = $coachID;
    }

    /**
     * @return mixed
     */
    public function getDrillID()
    {
        return $this->drillID;
    }

    /**
     * @param mixed $drillID
     */
    public function setDrillID($drillID)
    {
        $this->drillID = $drillID;
    }

    /**
     * @return mixed
     */
    public function getAthleteID()
    {
        return $this->athleteID;
    }

    /**
     * @param mixed $athleteID
     */
    public function setAthleteID($athleteID)
    {
        $this->athleteID = $athleteID;
    }

    /**
     * @return mixed
     */
    public function getPeriodID()
    {
        return $this->periodID;
    }

    /**
     * @param mixed $periodID
     */
    public function setPeriodID($periodID)
    {
        $this->periodID = $periodID;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getNumericalValue()
    {
        return $this->numericalValue;
    }

    /**
     * @param mixed $numericalValue
     */
    public function setNumericalValue($numericalValue)
    {
        $this->numericalValue = $numericalValue;
    }

    /**
     * @return mixed
     */
    public function getResultMessage()
    {
        return $this->resultMessage;
    }

    /**
     * @param mixed $resultMessage
     */
    public function setResultMessage($resultMessage)
    {
        $this->resultMessage = $resultMessage;
    }

    /**
     * @return mixed
     */
    public function getResultState()
    {
        return $this->resultState;
    }

    /**
     * @param mixed $resultState
     */
    public function setResultState($resultState)
    {
        $this->resultState = $resultState;
    }

    /**
     * @return mixed
     */
    public function getCommentary()
    {
        return $this->commentary;
    }

    /**
     * @param mixed $commentary
     */
    public function setCommentary($commentary)
    {
        $this->commentary = $commentary;
    }

    public function update(Evaluation $e)
    {
        $this->setID($e->getID());
        $this->setFieldID($e->getFieldID());
        $this->setCoachID($e->getCoachID());
        $this->setDrillID($e->getDrillID());
        $this->setAthleteID($e->getAthleteID());
        $this->setPeriodID($e->getPeriodID());
        $this->setDate($e->getDate());
        $this->setNumericalValue($e->getNumericalValue());
        $this->setResultMessage($e->getResultMessage());
        $this->setResultState($e->getResultState());
        $this->setCommentary($e->getCommentary());
    }

    public function print()
    {
        echo  $this->getCoachID() . " " . $this->getDrillID() . " " . $this->getAthleteID() . " " . $this->getPeriodID() . " " . $this->getDate() . " " . $this->getNumericalValue() . " " . $this->getResultMessage() . " " . $this->getResultState() . " " . $this->getCommentary() . "<br>";
    }

    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}