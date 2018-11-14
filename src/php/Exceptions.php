<?php
/**************************************************************************************
Fichier :       Exceptions.php
Auteur :        Antoine Gagnon
Fonctionnalité : Divers exceptions qui sont levées durant les authentifications.
Date :          23 avril 2018
=======================================================================================
Vérification :
Date        Nom	                    Approuvé
2018-05-06  Olivier Lemay Dostie    Oui
=======================================================================================
Historique de modification :
Date        Nom	                    Description
2018-04-23  Antoine Gagnon          Création
2018-04-28  Olivier Lemay Dostie    Versionnement pour merger
**************************************************************************************/

class AuthException extends Exception
{
}

class InvalidPasswordException extends AuthException
{
}

class InvalidCredentialsException extends AuthException
{
}
