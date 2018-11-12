import React from 'react'
//import { sections_group, sections_group_admin, sections, sections_admin } from '../../constants';
//import { makeRoute } from '../../functions'

/* TODO: Add parent and children section if required in constants. */
/* TODO: For better structure, move Components
who are not groups in a switch in info.js */

// The component matches one of two different routes
// depending on the full pathname

let routes_group = [];
let routes_group_admin = [];
let routes = [];
let routes_admin = [];
/*sections_group.forEach(element => {
  routes_group.push(makeRoute(element));
});
sections_group_admin.forEach(element => {
  routes_group_admin.push(makeRoute(element));
});
sections.forEach(element => {
  routes.push(makeRoute(element));
});
sections_admin.forEach(element => {
  routes_admin.push(makeRoute(element));
});*/

const SectionSwitch = () => (
  <div id="switch_section" className="switch_section">
    { routes_group }
    { this.state.admin && routes_group_admin }
    { routes }
    { this.state.admin && routes_admin }
  </div>
)

// TODO: make sure that state.admin cannot be modified (secure)

export default SectionSwitch;
