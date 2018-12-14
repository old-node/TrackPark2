/*
import App from './components/app';
import Navigation from './components/navigation/navigation';
import Content from './components/content/content';
import Footnote from './components/footnote/footnote';
*/

import NotFound from './components/notfound';

import Login from './auth/login';
import Register from './components/register';
/*import Logout from './components/logout';*/

import Home from './components/home';

import ParkGroup from './components/sections/park.group';
import Park from './components/sections/park';


//import  from './components/sections/';


export const templates = [
  {
    id: 0,
    name: "TrackPark2",
    component: null,//App,
    className: "app",
    exact: true,
    href: "../app",
    path: ""
  },
  {
    id: 1,
    name: "Navigation TrackPark2",
    component: null,//Navigation,
    className: "navigation",
    exact: true,
    href: "../navigation",
    path: ""
  },
  {
    id: 2,
    name: "Contenu TrackPark2",
    component: null,//Content,
    className: "content",
    exact: true,
    href: "../content",
    path: ""
  },
  {
    id: 3,
    name: "Pied de page TrackPark2",
    component: null,//Footnote,
    className: "footnote",
    exact: true,
    href: "../footnote",
    path: ""
  },
]

export const notfound = {
  id: 404,
  name: "Page introuvable",
  component: NotFound,
  exact: false,
  href: "../notfound",
  className: "404",
  path: "*",
}

export const sessions = [
  {
    login: {
      id: 90,
      name: "Connection",
      component: Login,
      className: "login",
      exact: true,
      href: "../login",
      path: "/account/login",
    }
  },
  {
    register: {
      id: 91,
      name: "Créer un compte",
      component: Register,
      className: "register",
      exact: true,
      href: "../register",
      path: "/account/register",
    }
  },
  {
    forgot: {
      id: 92,
      name: "Réinitialiser le mot de passe",
      component: null,
      className: "forgot",
      exact: true,
      href: "../forgot",
      path: "/account/forgot",
    }
  },
  {
    logout: {
      id: 93,
      name: "Déconnexion",
      component: null,
      className: "logout",
      exact: true,
      href: "../logout",
      path: "/account/logout",
    }
  }
]

export const home = {
  id: 10,
  name: "Acceuil TrackPark2",
  component: Home,
  className: "home",
  exact: true,
  href: "../parkgroup",
  path: "/parkgroup",
}

export const section_switch = {
  id: 50,
  name: "Liste des ", //{:s}
  component: null,
  className: "groupSwitch",
  exact: true,
  href: "../section.switch",
  path: "/s"
}
export const park = {
  id: 58,
  name: "Carte des parcs",
  component: Park,
  className: "park",
  exact: true,
  href: "../park",
  path: "/s/parkgroup",
  tableName: "",
}

export const parkgroup = {
  id: 58,
  name: "Carte des parcs",
  component: ParkGroup,
  className: "parkgroup",
  exact: true,
  href: "../parkgroup",
  path: "/s/parkgroup",
  tableName: "",
}
export const sections_group = [
  // Ajouter une balise pour nomer les éléments comme dans sessions?
  {
    id: 52,
    name: "Athlètes",
    component: null,
    className: "athlete",
    exact: true,
    href: "../athlete",
    path: "/s/athlete",
    tableName: "",
  },
  {
    /* TODO: Revoir la liste pour ajouter les groupes requis avec un id */
    id: 55,
    name: "Groupes",
    component: null, //TODO
    className: "group",
    exact: true,
    href: "../group",
    path: "/s/group",
    tableName: "",
  },
  {
    id: 54,
    name: "Évaluations",
    component: null, //External
    className: "evaluation",
    exact: true,
    href: "../evaluation",
    path: "/s/evaluation",
    tableName: "",
  },
  {
    id: 53,
    name: "Exercices",
    component: null, //External
    className: "drill",
    exact: true,
    href: "../drill",
    path: "/s/drill",
    tableName: "",
  },
  {
    id: 56,
    name: "Parcours",
    component: null, //External
    className: "course",
    exact: true,
    href: "../course",
    path: "/s/course",
    tableName: "",
  },
  {
    id: 58,
    name: "Carte des parcs",
    component: parkgroup,
    className: "parkgroup",
    exact: true,
    href: "../parkgroup",
    path: "/s/parkgroup",
    tableName: "",
  }
]


export const sections_group_admin = [
  {
    id: 60,
    name: "Types des utilisateurs",
    component: null, //External
    className: "usertype",
    exact: true,
    href: "http://localhost/manageUserType.php",
    path: "/s/usertype",
    tableName: "",
  },
  {
    id: 61,
    name: "Utilisateurs",
    component: null, //External
    className: "user",
    exact: true,
    href: "http://localhost/manageUsers.php",
    path: "/s/user",
    tableName: "",
  },
]

export const sections = [
  {
    id: 71,
    name: "Évaluateur ", //{:number}
    component: null, //TODO
    className: "coach",
    exact: false,
    href: "../coach",
    path: "/s/coach/:number",
    groupID: 51,
  },
  {
    id: 72,
    name: "Athlète ",
    component: null,
    className: "athlete",
    exact: false,
    href: "../athlete",
    path: "/s/athlete/:number",
    groupID: 52,
  },
  {
    id: 73,
    name: "Exercice ",
    component: null, //Todo
    className: "drill",
    exact: false,
    href: "../drill",
    path: "/s/drill/:number",
    groupID: 53,
  },
  {
    id: 74,
    name: "Évaluation ",
    component: null, //Todo
    className: "evaluation",
    exact: false,
    href: "../evaluation",
    path: "/s/evaluation/:number",
    groupID: 54,
  },
  {
    id: 75,
    name: "Groupe ",
    component: null, //Todo
    className: "group",
    exact: false,
    href: "../group",
    path: "/s/group/:number",
    groupID: 55,
  },
  {
    id: 76,
    name: "Parcour ",
    component: null, //External
    className: "course",
    exact: false,
    href: "../course",
    path: "/s/course/:number",
    groupID: 56,
  },
  {
    id: 77,
    name: "Casquette ",
    component: null, //External
    className: "cap",
    exact: false,
    href: "../cap",
    path: "/s/cap/:number",
    groupID: 57,
  },
  {
    id: 78,
    name: "Parc ",
    component: Park,
    className: "park",
    exact: false,
    href: "../park",
    path: "/s/park/:number",
    groupID: 58,
  }
]

export const sections_admin = [
  {
    id: 80,
    name: "Types des utilisateurs",
    component: null, //External
    className: "usertype",
    exact: true,
    href: "../usertype",
    path: "/s/usertype/:number",
    groupID: 60,
  },
  {
    id: 81,
    name: "Utilisateurs",
    component: null, //External
    className: "user",
    exact: true,
    href: "../user",
    path: "/s/user/:number",
    groupID: 61,
  },
]

/*export const pages = [
    templates,
    notfound,
    sessions,
    home,
    contact,
    section_switch,
    sections_group,
    sections_group_admin,
    sections,
    sections_admin,
] // Remove groupswitch and app from this list?

export default sections_group;
*/