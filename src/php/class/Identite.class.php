<?php
/**************************************************************************************
Fichier :       Identite.class.php
Auteur :		Olivier Lemay Dostie
Fonctionallité : Interface qui sert à l'identification des entitées classes métier
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
 * Interface Identite.
 */
interface Identite
{
    /**
     * Retourne le nombre d'instance de la classe.
     *
     * @return int Nombre d'instance de la classe.
     * @precondition La classe est incluse.
     * @postcondition Un nombre non-négatif est retourné.
     */
    static public function getIdentiteCount(): int;

    /**
     * Remet à zéro le nombre d'Identite à 0;
     */
    static public function resetIdentiteCount();

    /**
     * Ajoute un Identite à sa quantité.
     */
    static public function addIdentiteCount(): int;

    /**
     * @param int $count Nouvelle quantité d'Identite.
     * @precondition
     */
    static public function setIdentiteCount(int $count);

    /**
     * Obtient l'identifiant d'Identite.
     *
     * @return int Identifiant d'Identite.
     */
    public function getId(): int;

    /**
     * Obtient l'identifiant d'Identite à partir de la base de données.
     *
     * @param string $tableName Nom de la table.
     * @return int Identifiant d'Identite.
     */
    public function fetchIdentiteId(string $tableName): int;

    /**
     * Modifie l'identifiant d'Identite.
     *
     * @param int $id Nouveau identifiant.
     */
    public function setId(int $id): void;

    /**
     * Met à jour l'identifiant d'Identite.
     *
     * @param int $id Nouveau identifiant.
     * @param string $tableName Nom de la table.
     */
    public function updateIdentiteId(int $id, string $tableName) : void;

    /**
     * Obtient le nom d'Identite.
     *
     * @return string Nom.
     */
    public function getFullname() : string;

    /**
     * Obtient le nom à jour d'Identite.
     *
     * @param string $tableName Nom de la table.
     * @return string Nom.
     */
    public function fetchIdentiteFullname(string $tableName) : string;

    /**
     * Modifie le nom d'Identite.
     *
     * @param string $name Nouveau nom.
     */
    public function setFullname(string $name) : void;

    /**
     * Modifie le nom d'Identite.
     *
     * @param string $name Nouveau nom.
     * @param string $tableName Nom de la table.
     */
    public function updateIdentiteFullname(string $name, string $tableName);

    /**
     * Obtient la description d'Identite.
     *
     * @return string Description.
     */
    function getDescription() : string;

    /**
     * Obtient la description d'Identite.
     *
     * @param string $tableName Nom de la table.
     * @return string Description.
     */
    function fetchPersonDescription(string $tableName) : string;

    /**
     * Modifie la description d'Identite.
     *
     * @param string $description Nouvelle description.
     */
    public function setDescription(string $description) : void;

    /**
     * Modifie la description d'Identite.
     *
     * @param string $description Nouvelle description.
     * @param string $tableName Nom de la table.
     */
    public function updateDescription(string $description, string $tableName) : void;

    /**
     * Met à jour toutes les données d'Identite à partir de son identifiant.
     */
    public function update(): bool;

}