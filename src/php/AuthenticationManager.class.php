<?php
/**************************************************************************************
Fichier :       Authenticator.class.php
Auteur :        Antoine Gagnon
Fonctionnalité : Classe utilisé dans l'authentification des utilisateur avec le système
Date :          2018-04-23
=======================================================================================
Vérification :
Date		Nom					    Approuvé
2018-05-06  Olivier Lemay Dostie    Doit exclure l'épreuve avec
 * l'identifiant 0 dans le chargement, sinon OK.
=======================================================================================
Historique de modification :
Date	    Nom                     Description
2018-04-23  Antoine Gagnon          Création
2018-05-06  Olivier Lemay Dostie    Mise à jour de l'historique et versionnement.
**************************************************************************************/

include_once 'User.class.php';
include_once 'SQLConnector.class.php';
include_once 'SessionUtil.php';
include_once 'Exceptions.php';
include_once 'LogLogger.php';

/**
 * Classe AuthenticationManager
 */
class AuthenticationManager
{
    /**
     * @return bool si l'utilisateur est connecté
     */
    public static function isLoggedIn(): bool {
        session_start_if_not_started();
        return isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true;
    }

    /**
     * Va chercher l'utilisateur actuellement connecté
     * @return null|User l'instance de l'utilisateur connecté, null si aucun utilisateur est connecté
     */
    public static function getLoggedInUser() {
        session_start_if_not_started();
        if(!self::isLoggedIn()) {
            return null;
        }

        return User::fromID($_SESSION['user_id']);
    }

    /**
     * Essaye de connecté l'utilisateur
     * @param string $username le nom d'utilisateur de l'utilisateur
     * @param string $password le mot de passe NON HASHÉ de l'utilisateur
     * @throws InvalidCredentialsException si le nom d'utilisateur ou le mot de passe est invalide
     * @throws InvalidPasswordException si le format du mot de passe est invalide
     */
    public static function tryLogUserIn(string $username, string $password) {
        session_start_if_not_started();
        if(self::verifyCredentials($username, $password)) {

            $user = User::fromUsername($username);

            LogLogger::log($_POST['username'], true);

            $_SESSION['user_id'] = $user->getId();
            $_SESSION['user'] = $_POST['username'];
            $_SESSION['level'] = $user->getUserType()->getPermissionLevel();
            $_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
            $_SESSION['loggedin'] = true;
        } else {
            throw new InvalidCredentialsException();
        }
    }

    /**
     * Vérifie le nom d'utilisateur et le mot de passe pour la connexion
     * @param string $username le nom d'utilisateur
     * @param string $password le mot de passe
     * @return bool si les informations passés sont valide
     * @throws InvalidPasswordException si le format du mot de passe est invalide
     */
    public static function verifyCredentials(string $username, string $password): bool {
        if (!empty($username) && !empty($password)) {
            $password = self::validatePassword($password);
            $user = User::fromUsername($username);
            if(!is_null($user)) {
                return password_verify($password, $user->getPasswordHash());
            }
        }
        return false;
    }

    /**
     * sanitize le mot de passe et le retourne
     * @param $password
     * @return bool
     * @throws InvalidPasswordException si le mot de passe est invalide
     *
     * @author delight.im
     * @license MIT
     * @source https://github.com/delight-im/PHP-Auth/blob/master/src/UserManager.php#L310-L322
     */
    public static function validatePassword($password): string {
        if (empty($password)) {
            throw new InvalidPasswordException();
        }
        $password = trim($password);
        if (strlen($password) < 1) {
            throw new InvalidPasswordException();
        }
        return $password;
    }
}