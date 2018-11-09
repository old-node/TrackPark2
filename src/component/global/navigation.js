import React from 'react';
import logo from '../../images/logo.png';
import '../../css/stylesheet.css';
import {sections} from './sections';

// TODO: Remplacer le code php
function makeButton(name) {
    return '<?php '+name+'(); ?>';
}

function Menu(props) {
    const active = props.section;
    let buttonList = [];
    for (var i = 0; i < sections.length; i++) {
        if (sections.name === active) {
            buttonList.push(<a class="sideMenuButton active" href={sections[i].href}>{sections[i].name}</a>);
        } else {
            buttonList.push(<a class="sideMenuButton" href={sections[i].href}>{sections[i].name}</a>);
        }
    }
    return (
        <div class="sideMenu col2 colm12 floatLeft">
            <img class="logo" src={logo} alt="logo" />
            {buttonList}
        </div>
    );
}

// par exemple:
// title: Gestion des athlètes, button: makeAddAthleteButton
export function Header(props) {
    return (
        <div class="topMenu col10 colt10 colm12 floatLeft">
            <div class="col2 colt2 colm12 floatLeft"> &nbsp; </div>
            <div class="col10 colt10 colm12 floatLeft">
                <div class="title col6 colt6 colm6 floatLeft">
                    <h1 > {props.title} </h1>
                </div>
                <div class="floatLeft col2 colt2 colm12">
                    {makeButton(props.button)}
                    </div>
                    <div class="floatLeft col4 colt4 colm12">
                    <button class="buttonImport">Importer des données</button>
                </div>
            </div>
        </div>
    );
}

export default Menu;