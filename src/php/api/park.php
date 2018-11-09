<?php
/**************************************************************************************
Fichier :        park.php
Auteur :         Antoine Gagnon
Fonctionallité : Permet d'afficher des cartes de l'API google.
Date :           1 mai 2018
=======================================================================================
Vérification :
Date        Nom                     Approuvé
=======================================================================================
Historique de modification :
Date        Nom                     Description
2018-05-04  Antoine Gagnon          Création
**************************************************************************************/

require_once '../SQLConnector.class.php';
require_once '../Parc.php';
require_once '../RequestUtil.php';

require_once '../EvaluationManager.class.php';
require_once '../Evaluation.class.php';

require_once '../Parc.php';

if(isGet()) {
    header('Content-Type: application/json');
    echo json_encode(Parc::getAllParcs());
}