/*
import App from './components/app';
import Navigation from './components/navigation/navigation';
import Content from './components/content/content';
import Footnote from './components/footnote/footnote';
*/

import NotFound from './components/notfound';

import Login from './components/login';
import Register from './components/register';
import Forgot from './components/forgot';
import Logout from './components/logout';

import Home from './components/home';
import Contact from './components/contact';

import SectionSwitch from './components/sections/section.switch'

import CoachGroup from './components/sections/coach.group';
import Coach from './components/sections/coach';
import AthleteGroup from './components/sections/athlete.group';
import Athlete from './components/sections/athlete';
import DrillGroup from './components/sections/drill.group';
import Drill from './components/sections/drill';
import EvaluationGroup from './components/sections/evaluation.group';
import Evaluation from './components/sections/evaluation';
import GroupGroup from './components/sections/group.group';
import Group from './components/sections/group';
import CourseGroup from './components/sections/course.group';
import Course from './components/sections/course';
import CapGroup from './components/sections/cap.group';
import Cap from './components/sections/cap';
import ParkGroup from './components/sections/park.group';
import Park from './components/sections/park';

import UserTypeGroup from './components/sections/usertype.group';
import UserType from './components/sections/usertype';
import UserGroup from './components/sections/user.group';
import User from './components/sections/user';

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
    {login: {
        id: 90,
        name: "Connection",
        component: Login,
        className: "login",
        exact: true,
        href: "../login",
        path: "/account/login",
    }},
    {register: {
        id: 91,
        name: "Créer un compte",
        component: Register,
        className: "register",
        exact: true,
        href: "../register",
        path: "/account/register",
    }},
    {forgot: {
        id: 92,
        name: "Réinitialiser le mot de passe",
        component: Forgot,
        className: "forgot",
        exact: true,
        href: "../forgot",
        path: "/account/forgot",
    }},
    {logout: {
        id: 93,
        name: "Déconnexion",
        component: Logout,
        className: "logout",
        exact: true,
        href: "../logout",
        path: "/account/logout",
    }}
]

export const home = {
    id: 10,
    name: "Acceuil TrackPark2",
    component: Home,
    className: "home",
    exact: true,
    href: "../home",
    path: "/",
}

export const contact = {
    id: 11,
    name: "À propos",
    component: Contact,
    className: "contact",
    exact: true,
    href: "../contact",
    path: "/contact",
}

export const section_switch = {
    id: 50,
    name: "Liste des ", //{:s}
    component: SectionSwitch,
    className: "groupSwitch",
    exact: true,
    href: "../section.switch",
    path: "/s"
}

export const sections_group = [
    // Ajouter une balise pour nomer les éléments comme dans sessions?
    {
        id: 51,
        name: "Évaluateurs",
        component: CoachGroup,
        className: "coach",
        exact: true,
        href: "../coach",
        path: "/s/coach",
        tableName: "",
    },
    {
        id: 52,
        name: "Athlètes",
        component: AthleteGroup,
        className: "athlete",
        exact: true,
        href: "../athlete",
        path: "/s/athlete",
        tableName: "",
    },
    {
        id: 53,
        name: "Exercices",
        component: DrillGroup,
        className: "drill",
        exact: true,
        href: "../drill",
        path: "/s/drill",
        tableName: "",
    },
    {
        id: 54,
        name: "Évaluations",
        component: EvaluationGroup,
        className: "evaluation",
        exact: true,
        href: "../evaluation",
        path: "/s/evaluation",
        tableName: "",
    },
    {
        /* TODO: Revoir la liste pour ajouter les groupes requis avec un id */
        id: 55,
        name: "Groupes",
        component: GroupGroup,
        className: "group",
        exact: true,
        href: "../group",
        path: "/s/group",
        tableName: "",
    },
    {
        id: 56,
        name: "Parcours",
        component: CourseGroup,
        className: "course",
        exact: true,
        href: "../course",
        path: "/s/course",
        tableName: "",
    },
    {
        id: 57,
        name: "Casquettes",
        component: CapGroup,
        className: "cap",
        exact: true,
        href: "../cap",
        path: "/s/cap",
        tableName: "",
    },
    {
        id: 58,
        name: "Carte des parcs",
        component: ParkGroup,
        className: "park",
        exact: true,
        href: "../park",
        path: "/s/park",
        tableName: "",
    }
]

export const sections_group_admin = [
    {
        id: 60,
        name: "Types des utilisateurs",
        component: UserTypeGroup,
        className: "usertype",
        exact: true,
        href: "../usertype",
        path: "/s/usertype",
        tableName: "",
    },
    {
        id: 61,
        name: "Utilisateurs",
        component: UserGroup,
        className: "user",
        exact: true,
        href: "../user",
        path: "/s/user",
        tableName: "",
    },
]

export const sections = [
    {
        id: 71,
        name: "Évaluateur ", //{:number}
        component: Coach,
        className: "coach",
        exact: false,
        href: "../coach",
        path: "/s/coach/:number",
        groupID: 51,
    },
    {
        id: 72,
        name: "Athlète ",
        component: Athlete,
        className: "athlete",
        exact: false,
        href: "../athlete",
        path: "/s/athlete/:number",
        groupID: 52,
    },
    {
        id: 73,
        name: "Exercice ",
        component: Drill,
        className: "drill",
        exact: false,
        href: "../drill",
        path: "/s/drill/:number",
        groupID: 53,
    },
    {
        id: 74,
        name: "Évaluation ",
        component: Evaluation,
        className: "evaluation",
        exact: false,
        href: "../evaluation",
        path: "/s/evaluation/:number",
        groupID: 54,
    },
    {
        id: 75,
        name: "Groupe ",
        component: Group,
        className: "group",
        exact: false,
        href: "../group",
        path: "/s/group/:number",
        groupID: 55,
    },
    {
        id: 76,
        name: "Parcour ",
        component: Course,
        className: "course",
        exact: false,
        href: "../course",
        path: "/s/course/:number",
        groupID: 56,
    },
    {
        id: 77,
        name: "Casquette ",
        component: Cap,
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
        component: UserType,
        className: "usertype",
        exact: true,
        href: "../usertype",
        path: "/s/usertype/:number",
        groupID: 60,
    },
    {
        id: 81,
        name: "Utilisateurs",
        component: User,
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