import React, { Component } from 'react';
//import '../../css/footnote/footnote.css';
import Footer from './footer';
import Toast from './toast';

export default class Footnote extends Component {
  render(props) {
    return (
      <div id="footnote" className="footnote col12 colt12 colm12 floatLeft">
        <h2>
        </h2>
        <Footer />
        <Toast />
      </div>
    );
  }
}

