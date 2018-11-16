import React, { Component } from 'react';
import '../../css/navigation/navigation.css';


const posts = [
  {id: 1, name: 'Parc Julien', address: '234 rue de la chapelle, sherbrooke, qc j0b 4g0'}
 
];
  export default class Park extends Component {
    render(props) {
      return (
        <main id="content" className="content">
         <div> {posts[0].name }  </div>
         <div> {posts[0].address }  </div>
         <div id='googlemap'><iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d5601.485355294887!2d-71.89411715001995!3d45.41452831599123!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4cb7b3a162c46f25%3A0x60ba0e08ee5182e!2sParc+Victoria%2C+Sherbrooke%2C+QC+J1E+3T6!5e0!3m2!1sfr!2sca!4v1542220689960" width="600" height="450" ></iframe></div>
        </main>
      );
    }
  }

