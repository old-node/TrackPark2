/**************************************************************************************
Fichier :       functions.js
Auteur :        Olivier Lemay Dostie
Fonctionnalité : Fonctions utilitaire pour toute l'application.
Date :          22 novembre 2018
=======================================================================================
Vérification :
Date        Nom                     Approuvé
=======================================================================================
Historique de modification :
Date        Nom                     Description
2018-12-14	Olivier Lemay Dostie    Ajout des description
**************************************************************************************/

import React from 'react';
import { Link } from 'react-router-dom';
import { Route } from 'react-router-dom';

// Création d'un liens pour le menu
export function makeMenuLink(section, active, setActive) {
  let classActive = ""
  if (section.name === active) {
    classActive = "active"
  }
  if (section.href.match("^(http|https)://")) {
    classActive += " phpLink"
    return (<li key={section.id}><a className={classActive}
      onClick={() => {setActive(section.name)}}
      href={section.href}>{section.name}</a></li>)
  } else {
    classActive += " reactLink"
    return (<li key={section.id}><Link className={classActive}
      onClick={() => {setActive(section.name)}}
      to={section.href}>{section.name}</Link></li>);
  }
}

// Création d'un lien dans le menu mobile
export function makeInfoLink(section, number) {
  return (<li key={section.id} onClick={toggleMenu}>
      <Link to={section.href + number}>{section.name}</Link>
    </li>);
}

// Création d'une Route pour une section
export function makeRoute(section) {
  if (section === undefined) {
    return (<Route />)
  }
  if (section.exact) {
    return (<Route exact path={section.path} component={section.component} />)
  } else {
    return (<Route path={section.path} component={section.component} />)
  }
}

// Basculement du menu dans le mode mobile
export async function toggleMenu() {
  let topnav = document.getElementById("myTopnav");
  if (topnav && topnav.className === "topnav") {
    topnav.className += " responsive";
  } else {
    topnav = {className: "topnav"}
  }

  let menuTitle = document.getElementById("menuTitle");
  if (menuTitle && menuTitle.className === "menuTitle") {
    menuTitle.className += " hidden";
  } else {
    menuTitle = {className: "menuTitle"}
  }
}

