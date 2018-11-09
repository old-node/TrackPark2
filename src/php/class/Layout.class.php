<?php
/**************************************************************************************
Fichier :       Layout.class.php
Auteur :        Francis Forest
Fonctionnalité : Classe qui instancie les schémas
 * utilisé dans la description des parcours.
Date :          26 avril 2018
=======================================================================================
Vérification :
Date        Nom	                    Approuvé
2018-05-06  Olivier Lemay Dostie    Oui
=======================================================================================
Historique de modification :
Date        Nom	                    Description
2018-04-26  Francis Forest          Création
2018-04-29  Olivier Lemay Dostie    Versionnement pour merger
**************************************************************************************/

/**
 * Classe Layout
 */
class Layout
{
    private $type;
    private $typeDescription;
    private $image;
    private $description;

    /**
     * Layout.class constructor.
     * @param $type
     * @param $typeDescription
     * @param $image
     * @param $description
     */
    public function __construct($type, $typeDescription, $image, $description)
    {
        $this->type = $type;
        $this->typeDescription = $typeDescription;
        $this->image = $image;
        $this->description = $description;
    }


}