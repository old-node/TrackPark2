<?php
/**************************************************************************************
Fichier :       HTMLUtil.php
Auteur :        Antoine Gagnon
Fonctionnalité : Méthodes générales servant à la
 * formation des pages Web.
Date :          28 avril 2018
=======================================================================================
Vérification :
Date        Nom	                    Approuvé
2018-05-06  Olivier Lemay Dostie    Oui
=======================================================================================
Historique de modification :
Date        Nom	                    Description
2018-04-28  Antoine Gagnon          Création
2018-04-29	Olivier Lemay Dostie    Merge update
2018-05-06  Olivier Lemay Dostie    Ajout de makeTH
**************************************************************************************/

function makeTH($value)
{
    return '<th>'.$value.'</th>';
}

function makeTD($value) {
    return '<td>'.$value.'</td>';
}

function makeLink($url, $text) {
    return '<a href="'.$url.'">'.$text.'</a>';
}

function centerText($text) {
    return '<span style="text-align:center">'.$text.'</span>';
}

function makeCell($text)
{
    return "<td class='marginAuto'>" . $text . "</td>";
}

function makeCellTH($text)
{
    return "<th>" . $text . "</th>";
}

function writeTitle($title)
{
    echo "<h1>{$title}</h1>";
}

function makeButtonModifyCustom($link, $id)
{
    return "<button class='buttonGreen marginAuto' value={$id} name='id' onclick=\"location.href='{$link}?id={$id}';\">Modifier</button>";
}

function makeButtonDeleteCustom($link, $id)
{
    return "<button class='buttonWhite marginAuto' value={$id} onclick='$.post( \"{$link}\", {id:\"{$id}\"});location.reload();'>Supprimer</button>";
    //TODO faire en sorte que name soit conditionnel à la page en ajoutant le paramètre $what pour le concatenner après 'idDelete' ou tout simplement enlever 'Course'
}

