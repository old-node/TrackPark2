/**************************************************************************************
Fichier :       app.test.js
Auteur :        Olivier Lemay Dostie
Fonctionnalité : Fichier des tests de l'application TrackPark2.
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
import ReactDOM from 'react-dom';
import App from './app';

it('renders without crashing', () => {
  const div = document.createElement('div');
  ReactDOM.render(<App />, div);
  ReactDOM.unmountComponentAtNode(div);
});
