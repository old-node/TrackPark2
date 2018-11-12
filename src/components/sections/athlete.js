import React from 'react'
import { Link } from 'react-router-dom'
//import { notfound, sections_group } from '../../constants'
import AthleteAPI from '../../api/athlete' //{sections_group[1].className}

import AthleteGroup from './athlete.group';
import NotFound from '../notfound'

const athlete_group = //sections_group[1].path;
{
  id: 52,
  name: "Athlètes",
  component: AthleteGroup,
  className: "athlete",
  exact: true,
  href: "../athlete",
  path: "/s/athlete",
  tableName: "",
}

// The athlete looks up the athlete using the number parsed from
// the URL's pathname. If no athlete is found with the given
// number, then a "athlete not found" message is displayed.
const athlete = (props) => {
  const athlete = AthleteAPI.get(
    parseInt(props.match.params.number, 10)
  )
  if (!athlete) {
    //return <div>Sorry, but the athlete was not found</div>
    return <NotFound message="L'athlète n'a pas pu être trouvé."/>
  }
  return (
    <div>
      <Link to={athlete_group}>Retour</Link>
      <h1>{athlete.fullName()}</h1>
    </div>
  )
}

export default athlete
