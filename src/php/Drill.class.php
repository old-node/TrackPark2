<?php
/**************************************************************************************
Fichier :       Drill.class.php
Auteur :	    Francis Forest
Fonctionallité : Gestionnaire des épreuves.
Date :          25 avril 2018
=======================================================================================
Vérification :
Date        Nom                     Approuvé
2018-05-06  Olivier Lemay Dostie    Oui
=======================================================================================
Historique de modification :
Date        Nom                     Description
2018-04-25  Francis Forest          Création
2018-04-28  Olivier Lemay Dostie    Versionnement pour merger
**************************************************************************************/

/**
 * Classe Drill
 *
 * Un Drill est un exercice. Il compose un Course.
 */
class Drill
{
    private $id;                //id du drill
    private $cap;               //id de la cap
    private $typeID;            //type du drill
    private $name;              //nom du drill
    private $goal;              //but du drill
    private $allowedTries;      //nombre d'essais alloué
    private $successThreshold;  //nombre pour réussir le drill
    private $allowedTime;       //temps alloué
    private $failureThreshold;  //limite de mauvais essais pour un échec
    private $obsolete;          //si le drill est encore valide ou non

    /**
     * Drill constructor.
     * @param $id int id du drill
     * @param $cap int Casquette attribué au drill
     * @param $typeID int type du drill
     * @param $name string nom du drill
     * @param $goal string but du drill
     * @param $allowedTries float nombre d'essais alloués
     * @param $succesThreshold float nombre pour réussir le drill
     * @param $allowsTime float temps alloué
     * @param $failureThreshold float limite de mauvais essais pour un échec
     * @param $obsolete int si le drill est encore valide ou non
     */
    public function __construct($id, $cap, $typeID, $name, $goal, $allowedTries, $succesThreshold, $allowsTime, $failureThreshold, $obsolete)
    {
        $this->id = $id;
        $this->cap = $cap;
        $this->typeID = $typeID;
        $this->name = $name;
        $this->goal = $goal;
        $this->allowedTries = $allowedTries;
        $this->successThreshold = $succesThreshold;
        $this->allowedTime = $allowsTime;
        $this->failureThreshold = $failureThreshold;
        $this->obsolete = $obsolete;
    }

    /** get le id du drill
     * @return int id du drill
     */
    public function getID()
    {
        return $this->id;
    }

    /** set le id du drill
     * @param int $id id du drill
     */
    public function setID($id)
    {
        $this->id = $id;
    }

    public function getCap()
    {
        return $this->cap;
    }

    public function setCap($cap)
    {
        $this->cap = $cap;
    }

    /** get le type du drill
     * @return int type du drill
     */
    public function getTypeID()
    {
        return $this->typeID;
    }

    /** set le type du drill
     * @param int $typeID type du drill
     */
    public function setTypeID($typeID)
    {
        $this->typeID = $typeID;
    }

    /** get le nom du drill
     * @return string nom du drill
     */
    public function getName()
    {
        return $this->name;
    }

    /** set le nom du drill
     * @param string $name nom du drill
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /** get le but du drill
     * @return string but du drill
     */
    public function getGoal()
    {
        return $this->goal;
    }

    /** set le but du drill
     * @param string $goal but du drill
     */
    public function setGoal($goal)
    {
        $this->goal = $goal;
    }

    /** get le nombre d'essais
     * @return float nombre d'essais
     */
    public function getAllowedTries()
    {
        return $this->allowedTries;
    }

    /** set le nombre d'essais
     * @param float $allowedTries nombre d'essais
     */
    public function setAllowedTries($allowedTries)
    {
        $this->allowedTries = $allowedTries;
    }

    /** get le nombre pour réussir
     * @return float nombre pour réussir
     */
    public function getSuccessThreshold()
    {
        return $this->successThreshold;
    }

    /** set le nombre pour réussir
     * @param float $successThreshold nombre pour réussir
     */
    public function setSuccessThreshold($successThreshold)
    {
        $this->successThreshold = $successThreshold;
    }

    /** get le temps alloué
     * @return float temps alloué
     */
    public function getAllowedTime()
    {
        return $this->allowedTime;
    }

    /** set le temps alloué
     * @param float $allowedTime temps alloué
     */
    public function setAllowedTime($allowedTime)
    {
        $this->allowedTime = $allowedTime;
    }

    /** get le nombre d'échec maximal
     * @return float nombre d'échec maximal
     */
    public function getFailureThreshold()
    {
        return $this->failureThreshold;
    }

    /** set le nombre d'échec maximal
     * @param float $failureThreshold nombre d'échec maximal
     */
    public function setFailureThreshold($failureThreshold)
    {
        $this->failureThreshold = $failureThreshold;
    }

    /** get si valide
     * @return int si valide
     */
    public function getObsolete()
    {
        return $this->obsolete;
    }

    /** set si valide
     * @param boolean $obsolete si valide
     */
    public function setObsolete($obsolete)
    {
        $this->obsolete = $obsolete;
    }

    /** Modifie les informations du drill
     * @param Drill $n drill
     */
    public function update(Drill $n)
    {
        $this->setTypeID($n->getTypeID());
        $this->setName($n->getName());
        $this->setGoal($n->getGoal());
        $this->setAllowedTries($n->getAllowedTries());
        $this->setSuccessThreshold($n->getSuccessThreshold());
        $this->setAllowedTime($n->getAllowedTime());
        $this->setFailureThreshold($n->getFailureThreshold());
        $this->setObsolete($n->getObsolete());
    }

    /**
     * Affiche les informations du drill
     */
    public function printRow()
    {
        echo "<tr><td>{$this->getName()}</td><td>{$this->getTypeID()}</td><td>{$this->getGoal()}</td><td>{$this->getAllowedTries()}</td><td>{$this->getAllowedTime()}</td><td>{$this->getSuccessThreshold()}</td><td>{$this->getFailureThreshold()}</td><td>{$this->getObsolete()}</td></tr>";
    }

    /**
     * Affiche les infromations du drill dans une rangée d'un tableau HTML
     */
    public function printRowWithoutClosingTR()
{
    echo "<tr><td>{$this->getName()}</td><td>{$this->getTypeID()}</td><td>{$this->getGoal()}</td><td>{$this->getAllowedTries()}</td><td>{$this->getAllowedTime()}</td><td>{$this->getSuccessThreshold()}</td><td>{$this->getFailureThreshold()}</td><td>{$this->getObsolete()}</td>";
}
}