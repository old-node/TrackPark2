<?php
/**************************************************************************************
Fichier :       RequestUtil.php
Auteur :        Antoine Gagnon
Fonctionallité : Classe qui permet la connexion à une base de donnée.
Date :          28 avril 2018
=======================================================================================
Vérification :
Date		Nom					    Approuvé
2018-05-06  Olivier Lemay Dostie    Oui
=======================================================================================
Historique de modification :
Date		Nom						Description
2018-04-28  Antoine Gagnon          Création
2018-04-29  Olivier Lemay Dostie    Versionnement et merge
**************************************************************************************/

function isPost()
{
    return $_SERVER['REQUEST_METHOD'] === 'POST';
}

function isGet()
{
    return $_SERVER['REQUEST_METHOD'] === 'GET';
}

function redirectToRoot()
{
    header("Location: http://" . $_SERVER['HTTP_HOST']);
}

function isPostSetAndNotEmpty($key): bool
{
    return isset($_POST[$key]) && !empty($_POST[$key]);
}

function isGetSetAndNotEmpty($key): bool
{
    return isset($_GET[$key]) && !empty($_GET[$key]);
}

function getPath() {
    return (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
}