/**************************************************************************************
Fichier :       coach.popup.js
Auteur :        Olivier Lemay Dostie
Fonctionnalité : Bulle d'information pour le tableau des évaluateurs.
Date :          22 novembre 2018
=======================================================================================
Vérification :
Date        Nom                     Approuvé
=======================================================================================
Historique de modification :
Date        Nom                     Description
2018-12-14	Olivier Lemay Dostie    Ajout des description
**************************************************************************************/

import React from "react";
import { withRouter } from "react-router-dom";
import { Dropdown, Button }from "semantic-ui-react";
import CoachAPI from "../../../api/coach";
import '../../../css/tables.css';
var selected = 0
var id = 0

class CoachPopUp extends React.Component {
  exposedCampaignOnChange = (e, {value}) => {
    e.persist();
    selected=value;
  };

  showValue() {
    CoachAPI.addGroup(selected, id)
  }

  render() {
    const coachs = this.props.coachs;
    id = this.props.id
    const options = coachs.map(({id,  name, first_name}) => ({ value: id, text: name + " " +  first_name}))

    return (
      <div>
        <div className="dropdown">
          <Dropdown  placeholder='Choisir un Coach' fluid search selection options={options}
                      onChange={this.exposedCampaignOnChange} />
        </div>
        <div className="btnDropDown">
          <Button onClick={this.showValue}> Ajouter un coach</Button>
        </div>
      </div>
      )
  }
}

export default withRouter(CoachPopUp)