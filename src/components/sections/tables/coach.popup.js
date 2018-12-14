import React, { Component } from "react";
import { withRouter } from "react-router-dom";
import { Dropdown, Form, Button, Icon }from "semantic-ui-react";
import CoachAPI from "../../../api/coach";
import '../../../css/tables.css';
var selected = 0
var id = 0
class CoachPopUp extends React.Component {

 
  constructor(props) {
    super(props);
  }

  exposedCampaignOnChange = (e, {value}) => {
    e.persist();
    console.log(value);
    selected=value;
    console.log(selected);
  };
 
  showValue()
  {
    console.log(this.props)

  
      CoachAPI.addGroup(selected, id)
   
  }
  render() {
    const coachs = this.props.coachs;
    id = this.props.id
    const options = coachs.map(({id,  name, first_name}) => ({ value: id, text: name + " " +  first_name}))
   
   
    return (
      <div>
        <div class="dropdown">
      <Dropdown  placeholder='Choisir un Coach' fluid search selection options={options}
      onChange={this.exposedCampaignOnChange} />
</div>
<div class="btnDropDown">
      <Button onClick={this.showValue}> Ajouter un coach</Button>
       </div>
       </div>
      )
  }
}

export default withRouter(CoachPopUp)