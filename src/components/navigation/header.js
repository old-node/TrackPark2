import React, { Component } from 'react';
import '../../css/navigation/header.css';

export default class Header extends Component {
  render(props) {
    if (props === undefined) {
      props = {title: "", button: null}
    }

    return (
      <header id="header" className="header topMenu col10 colt10 colm12 floatLeft">
        <h3>
            Header Component
        </h3>
        <div className="col2 colt2 colm12 floatLeft"> &nbsp; </div>
        <div className="col10 colt10 colm12 floatLeft">
          <div className="title col6 colt6 colm6 floatLeft">
            <h1 > {props.title} </h1>
          </div>
          <div className="floatLeft col2 colt2 colm12">
            {props.button}
            </div>
            <div className="floatLeft col4 colt4 colm12">
            <button className="buttonImport">Importer des données</button>
          </div>
        </div>
      </header>
    );
  }
}
