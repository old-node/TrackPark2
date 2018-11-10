/**************************************************************************************
Fichier :        .js
Auteur :         .
Fonctionallité : .
Date :           2018-11-10
=======================================================================================
Vérification :
Date        Nom                     Approuvé

=======================================================================================
Historique de modification :
Date        Nom                     Description
2018-11-10  Olivier Lemay Dostie    Création
**************************************************************************************/

import '../../css/stylesheet.css';
import sections from './sections';

// Affiche la description non modifiable d'un .
export function Info(props) {
    let content = [];
    if (props.athlete.id === 0 || props.section > sections.length) {
        content = "404";
    }
    for (var i = 0; i < sections.length; i++) {
        if (sections.id === props.section) {
            content = ""; // Ajouter le contenu de la page en import
            continue;
        }
    }
    return (content);
}

export default Info;