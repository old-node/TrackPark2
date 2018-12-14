/**************************************************************************************
Fichier :       Endpoints.js
Auteur :        Antoine Gagnon
Fonctionnalité : Liste des points d'accès de l'API.
Date :          22 novembre 2018
=======================================================================================
Vérification :
Date        Nom                     Approuvé
=======================================================================================
Historique de modification :
Date        Nom                     Description
2018-12-14	Olivier Lemay Dostie    Ajout des description
**************************************************************************************/

const BASE = "http://localhost/api/v2/";

/**
 * Endpoints to the Trackpark API
 */
const Enpoints = {
  ATHLETE: BASE + "athlete.php",
  ATHLETE_CATEGORY: BASE + "athlete_category.php",
  CAP: BASE + "cap.php",
  COACH: BASE + "coach.php",
  COURSE_TYPE: BASE + "course_type.php",
  DRILL: BASE + "drill.php",
  EVALUATION: BASE + "evaluation.php",
  GROUP: BASE + "group.php",
  DRILL_TYPE: BASE + "drill_type.php",
  COURSE: BASE + "course.php",
  PARC: BASE + "park.php",
  AUTH: BASE + "auth.php"
};

export default Enpoints;
