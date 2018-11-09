import React from 'react';
import ReactDOM from 'react-dom';
import './css/index.css';
import App from './js/App';
import Menu, {Header} from './component/global/navigation';
import Content, {Info, Popup} from './component/global/main';
import Footer, {Toast} from './component/global/footnote';
import * as serviceWorker from './js/serviceWorker';

ReactDOM.render(<Menu section="default"/>, document.getElementById('menu'));
ReactDOM.render(<Header title="Gestion des " value="default"/>, document.getElementById('header'));
ReactDOM.render(<Content section="2"/>, document.getElementById('content'));
ReactDOM.render(<Info text="Info"/>, document.getElementById('info'));
ReactDOM.render(<Popup text="Popup"/>, document.getElementById('popup'));
ReactDOM.render(<Footer text="Footer"/>, document.getElementById('footer'));
ReactDOM.render(<Toast text="Toast"/>, document.getElementById('toast'));

// If you want your app to work offline and load faster, you can change
// unregister() to register() below. Note this comes with some pitfalls.
// Learn more about service workers: http://bit.ly/CRA-PWA
serviceWorker.unregister();
