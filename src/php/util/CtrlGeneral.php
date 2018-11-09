<?php
/**************************************************************************************
Fichier :       CtrlGeneral.php
Auteur :		Olivier Lemay Dostie
Fonctionallité : Classe servant à gérer l'affichage des interfaces Web et
 * à inclure les fonctions communes à plusieurs fichiers.
Date :          23 avril 2018
=======================================================================================
Vérification :
Date		Nom					    Approuvé
=======================================================================================
Historique de modification :
Date		Nom						Description
2018-04-23	Olivier Lemay Dostie    Création
2018-05-05  Olivier Lemay Dostie    Versionnement en fonction de HTMLUtil.php
**************************************************************************************/

include_once 'RequestUtil.php';

/* ==================== */
/* GESTION DES FENÊTRES */
/* ==================== */
/**
 *
 */
/*public static function b()
{
}*/


/*
function makeRemoveButton($id, $fromWhat, $whatMesage)
{
    return "<button class='buttonGreen marginAuto' type='submit' value={$id} name='idRemove".$fromWhat."'>".$whatMesage."</button>";
}
*/

/*
function makeAddButton($id, $fromWhat, $whatMesage)
{
    return "<button class='buttonGreen marginAuto' type='submit' value={$id} name='idAdd".$fromWhat."'>".$whatMesage."</button>";
}
*/

/* ================= */
/* INCLUSIONS ET CSS */
/* ================= */

/**
 *
 */
function sessionStart()
{
    session_start();

    if(isset($_SESSION['level'])) {
        if( $_SESSION['level'] < 255) {
            die("Vous devez être administrateur pour accèder à cette page");
        }
    } else {
        header("Location: login.php?rd=" . getPath());
    }
}


/* =========== */
/* VALIDATIONS */
/* =========== */

/**
 * Valide le format d'une variable en fonction d'une expression régulière.
 *
 * @param mixed $var Variable à valider.
 * @param string $regEx Expression régulière du format.
 * @return bool État de validation du bon format.
 */
function validRegEx($var, string $regEx): bool
{
    assert(isset($var));
    return preg_match($regEx, $var);
}

/**
 * Valide le format d'un numéro de téléphone.
 *
 * @param string $phoneNumber Numéro de téléphone à valider.
 * @return bool État de validation du bon format.
 */
function validPhoneNumber(string $phoneNumber): bool
{
    return validRegEx($phoneNumber,
        "^(\+\d{1,2}\s)?\(?\d{3}\)?[\s.-]?\d{3}[\s.-]?\d{4}$");
}

/**
 * Valide le format d'une chaine de caractère représentant une adresse.
 *
 * @param string $address Adresse à valider.
 * @return bool État de validation du bon format.
 */
function validAddress(string $address): bool
{
    //  https://smartystreets.com/products/single-address?mode=extract
    return validRegEx($address,
        "/^[a-zA-Z0-9\s,.'-]{3,}$/");
}

/**
 * Valide le format d'une adresse courriel.
 *
 * @param string $email Adresse courriel à valider.
 * @return bool État de validation du bon format.
 */
function validEmail(string $email): bool
{
    //  http://emailregex.com/
    return validRegEx($email,
        "/^(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){255,})".
        "(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){65,}@)".
        "(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|".
        "(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22))".
        "(?:\.(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|".
        "(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22)))*@".
        "(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-[a-z0-9]+)*\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|".
        "(?:(?:xn--)[a-z0-9]+))(?:-[a-z0-9]+)*)|(?:\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|".
        "(?:(?!(?:.*[a-f0-9][:\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}".
        "(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|".
        "(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}".
        "(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))".
        "(?:\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\]))$/iD");
}

/**
 * Convertis dans une chaine de caractère tout les caractères accentués non accepté par ceux correspondant.
 *
 * @param string $name Chaine de caractère à convertir.
 * @return string Chaine de caractère convertie.
 */
function parseName(string $name): string
{
    assert(isset($name));
    /*  https://stackoverflow.com/a/2385967
    Convertir les caractères désirés vers ceux acceptés.
    Comme avec (si désiré) : str_replace ('à','a',$name);
    àáâäãåą => a?
    ÀÁÂÄÃÅĄ => A?
    Æ => ?
    ß => ?
    čć/çč => c?
    ĆČ/ÇČ => C?
    ∂ð => ?
    ęèéêëė => e?
    ĖĘÈÉÊË => E?
    įìíîï => i
    ÌÍÎÏĮ => I
    ł => l
    Ł => L
    ń/ñ => n
    Ń/Ñ => N
    òóôöõø => o
    ÒÓÔÖÕØ => O
    Œ => ?
    š => s
    Š => S
    ùúûüųū => u
    ÙÚÛÜŲŪ => U
    ÿý => y
    ŸÝ => Y
    żź/ž => z
    ŻŹ/Ž => Z
    */
    return $name;
}

/**
 * Valide le format d'un nom.
 *
 * @param string $name Nom à valider.
 * @return bool État de validation du bon format.
 */
function validName(string $name): bool
{
    return parseName($name) != $name ? false : validRegEx($name,
        "/^[a-z ,.'-]+$/i");
}

/**
 * Valide le format d'une date.
 *
 * @param string $date Date à valider.
 * @param string $format Format de la date.
 * @return bool État de validation du bon format.
 * @precondition Par défaut, le format Ymd est utilisé.
 */
function validDate(string $date, $format = 'Ymd'): bool
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;

    //  https://www.regular-expressions.info/dates.html
    //  /^(19|20)\d\d[- /.](0[1-9]|1[012])[- /.](0[1-9]|[12][0-9]|3[01])$
    /*return self::validRegEx($date,
        "/^(19|20)\d\d[- /.](0[1-9]|1[012])[- /.](0[1-9]|[12][0-9]|3[01])$");*/
}

/**
 * Initialise une date en fonction de la journée actuelle si elle
 *
 * @param string $date Date à initialiser si elle est vide ou nulle.
 * @param string $format Format de la date.
 * @return string Date initialisée dans le format spécifié à la journée actuelle ou une autre.
 * @precondition Par défaut, le format Ymd est utilisé.
 */
function initDate(string $date = "", string $format = 'Ymd'): string
{
    //assert(CtrlGeneral::validDate($date, $format));
    if (empty($date)) {
        $date = date($format);
    } else {
        $date = DateTime::createFromFormat('Ymd', $date);
    }
    return $date;
}

/**
 * Méthode suggérée pour charger du texte sans les accents ou le traduire de
 * sorte que les accents deviennent du code HTML. (Pour les acnciens navigateurs).
 * @param string $text
 */
function parseToHTML(string $text) {
    //http://www.starr.net/is/type/htmlcodes.html
    str_replace('é', '&eacute;', $text);
    str_replace('É', '&Egrave;', $text);
    str_replace('ê', '&ecirc;', $text);
    str_replace('Ê', '&Ecirc;', $text);
}

