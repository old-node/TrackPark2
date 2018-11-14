<?php
/**************************************************************************************
Fichier :       Relation.class.php
Auteur :		Olivier Lemay Dostie
Fonctionallité : Struture servant à décrire une relation entre chaque personne.
 * (Fonctionnalité pas implémentée)
Date :          23 avril 2018
=======================================================================================
Vérification :
Date		Nom					    Approuvé
=======================================================================================
Historique de modification :
Date		Nom						Description
2018-04-27	Olivier Lemay Dostie	Création
**************************************************************************************/

/**
 * Classe Relation.
 */
class Relation
{
    /**
     * @var int Identifiant en relation.
     */
    public $id;
    /**
     * @var string Message décrivant la relation.
     */
    public $text;

    /**
     * Constructeur de Relation.
     *
     * @param $id int Identifiant en relation.
     * @param $text string Message décrivant la relation.
     */
    public function __construct($id, $text)
    {
        $this->id = $id;
        $this->text = $text;
    }

    /**
     * Obtient l'identifiant en relation.
     *
     * @return int Identifiant en relation.
     */
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * Obtient la description de la relation.
     *
     * @return string Message décrivant la relation.
     */
    public function getText() : string
    {
        return $this->text;
    }

    /**
     * Modifie l'identifiant en relation.
     *
     * @param int $id Nouveau identifiant en relation.
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Modifie la description de la relation.
     *
     * @param mixed $text Nouvelle description de la relation.
     */
    public function setText($text)
    {
        $this->text = $text;
    }


}