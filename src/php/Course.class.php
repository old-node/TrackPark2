<?php
/**************************************************************************************
Fichier :       Course.class.php
Auteur :		Francis Forest
Fonctionallité : Cette classe est un regroupement d'épreuves (Drill).
 * Les parcours (Course) sont associés à des groupes (Group).
Date :          23 avril 2018
=======================================================================================
Vérification :
Date		Nom                     Approuvé
2018-04-28  Olivier Lemay Dostie    Vérification générale
=======================================================================================
Historique de modification :
Date		Nom						Description
2018-04-23	Francis Forest          Création
2018-04-28  Olivier Lemay Dostie    Versionnement pour merger
2018-05-06  Olivier Lemay Dostie    Enlever le paramêtre cap de la classe
 * (mis dans Drill comme dans la base de données) et mise a jour de l'historique.
**************************************************************************************/

include_once "Drill.class.php";

/**
 * Classe Course
 */
class Course
{
    private $id;                //id du course
    private $cap;               //casquette du course
    private $type;              //type de course
    private $name;              //nom du course

    private $drills = [];       //drills du course
    private $groups = [];       //groupes ayant ce course

    /**
     * Construit un course avec son id, son type, sa casquette et son nom
     * @param $id int
     * @param $cap int
     * @param $type int
     * @param $name string
     * @param $drills Drill
     */
    public function __construct($id, $type, $name)
    {
        $this->id = $id;
        //$this->cap = $cap;
        $this->type = $type;
        $this->name = $name;
    }

    /** Get le id du course
     * @return int
     */
    public function getID()
    {
        return $this->id;
    }

    /** Set le id du course
     * @param int $id
     */
    public function setID($id)
    {
        $this->id = $id;
    }

    /** get la casqutte du course
     * @return int
     */
    public function getCap()
    {
        return $this->cap;
    }

    /** set la casquette du course
     * @param int $cap
     */
    public function setCap($cap)
    {
        $this->cap = $cap;
    }

    /** retourne le type du course
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /** set le type du course
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /** get le nom du course
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /** set le nom du course
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /** set les drills du course
     * @param array $drills Drill
     */
    public function setDrills(array $drills): void
    {
        $this->drills = $drills;
    }

    /** get les drills du course
     * @return array Drill
     */
    public function getDrills()
    {
        return $this->drills;
    }

    /** get les groups du course
     * @return array Groupes
     */
    public function getGroups(): array
    {
        return $this->groups;
    }

    /** set les groups du course
     * @param array $groups Groupes
     */
    public function setGroups(array $groups)
    {
        $this->groups = $groups;
    }

    /** update le course dans la base de données
     * @param Course $c Parcours à copier
     */
    public function update(Course $c)
    {
        $this->setCap($c->getCap());
        $this->setType($c->getType());
        $this->setName($c->getName());
        $this->setDrills($c->getDrills());
    }

    /**
     * affiche les informations du course
     */
    public function print()
    {
        echo $this->getID() . $this->getName() . $this->getType() . $this->getCap();
    }

    /**
     * affiche les informations du course dans une ligne d'un tableau HTML
     */
    public function printRow()
    {
        echo "<tr><td>{$this->getID()}</td><td>{$this->getName()}</td><td>{$this->getType()}</td><td>{$this->getCap()}</td></tr>";
    }
}