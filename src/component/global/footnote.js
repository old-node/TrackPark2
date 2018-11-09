import React from 'react';
import '../../css/stylesheet.css';
import {sections} from './navigation';
import {text1} from './main';


function Footer(props) {
    const text = text1(props);
    return (
        <div class="col12 colt12 colm12 floatLeft">
            {text}
        </div>
    );
}

export function Toast(props) {
    const text = text1(props);
    return (
        <div class="">
            {text}
        </div>
    );
}

export default Footer;