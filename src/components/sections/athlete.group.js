import React from 'react'
//import { sections_group } from '../../constants'
import AthleteAPI from '../../api/athlete'
import { makeInfoLink } from '../../functions'

import AthleteGroup from './athlete.group';
const athlete = //sections_group[1]
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

// The Roster component matches one of two different routes
// depending on the full pathname
const GroupAthlete = () => (
  <div>
    <ul>
      {
        //<Link to={`/roster/${a.number}`}>{a.name}</Link>
        AthleteAPI.all().map(a => (
          <li key={a.number}>
            { makeInfoLink(athlete, a.number) }
          </li>
        ))
      }
    </ul>
  </div>
)

export default GroupAthlete
