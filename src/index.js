/**************************************************************************************
Fichier :       index.js
Auteur :        Olivier Lemay Dostie
Fonctionnalité : Racine de l'application.
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
import { render } from 'react-dom';
import { BrowserRouter } from 'react-router-dom';
import './css/index.css';
import App from './components/app';

render((
  <BrowserRouter>
    <App />
  </BrowserRouter>
), document.getElementById('root'));

