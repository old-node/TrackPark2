import React from 'react';
import '../../css/stylesheet.css';
import {sections} from './sections';

// Retourne la valeur du props text (fonction dummy)
// (Inclure un fichier avec les fonctions au lieu de les créer dans ce fichier)
export function text1(props) {
    return props.text;
}

// Affiche le contenu principal de la page
function Content(props) {
    let content = [];
    if (props.section === 0 || props.section > sections.length) {
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

// Affiche l'information en lien avec un des éléments de la page
export function Info(props) {
    const text = text1(props);
    return (
        <div class="col10 colt10 colm12 floatLeft">
            {text}
        </div>
    );
}

// Affiche une fenêtre superposé sur la page pour une modification ou une confirmation
export function Popup(props) {
    const text = text1(props);
    return (
        <div class="">
            {text}
        </div>
    );
}

export default Content;