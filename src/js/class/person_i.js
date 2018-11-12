/**************************************************************************************
Fichier :       person_i.js
Auteur :        Olivier Lemay Dostie
Fonctionallité : Interface pour les personnes
Date :          2018-11-10
=======================================================================================
Vérification :
Date		Nom					    Approuvé

=======================================================================================
Historique de modification :
Date		Nom                     Description
2018-11-10	Olivier Lemay Dostie    Création
**************************************************************************************/

//import identite_i from './identite_i'

export interface person_i {
    address?: int,
    category?: int,
    gender?: int,
    firstName?: int,
    lastName?: string,
    birthday?: string,
    email?: string,
    phoneNumber?: string,
    profileImageUrl?: string,
    profileInfo?: string,
    comments?: string,
}

export default person_i;
