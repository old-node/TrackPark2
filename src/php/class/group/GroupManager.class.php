<?php
/**************************************************************************************
Fichier :       UIWDrillManager.php
Auteur :        Francis Forest
Fonctionallité : Fichier qui construit la maquete UIWGroupManager.
 * Affiche le gestionnaire des groupes.
Date :          25 avril 2018
=======================================================================================
Vérification :
Date        Nom					    Approuvé
2018-05-06  Olivier Lemay Dostie    Doit exclure l'épreuve avec
 * l'identifiant 0 dans le chargement, sinon OK.
=======================================================================================
Historique de modification :
Date        Nom					    Description
2018-04-25  Shawn Corriveau         Création
2018-04-28  Olivier Lemay Dostie    Versionnement pour merger
2018-04-30  Françis Forest          Refactorisation et réimplémentation
2018-05-06  Olivier Lemay Dostie    Mise à jour de la syntaxe
**************************************************************************************/

include_once "./SQLConnector.class.php";
include_once "./Group.class.php";

/**
 * Classe GroupManager
 */
class GroupManager
{
    /** get les groupes de la DB
     * @return array Group
     */
    public static function loadGroups()
    {
        $groups = [];

        $conn = SQLConnector::createConn();
        $stat = $conn->prepare("SELECT * FROM athlete_group");
        $stat->execute();
        $result = $stat->get_result();

        if (!$result) {
            die("Requête invalide: " . mysql_error() . "<br>");
        }

        while ($row = $result->fetch_array(MYSQLI_NUM)) {
            $g = new Group($row[0], $row[1], $row[2]);
            array_push($groups, $g);

            GroupManager::addAthletes($g);
            GroupManager::updateAssignedCoach($g);
            GroupManager::updateCollabCoaches($g);
            GroupManager::updateCourses($g);
        }

        $conn->close();
        return $groups;

    }

    /** get un groupe de la DB selon l'id
     * @param int $id id du groupe
     * @return Group
     */
    public static function loadGroup($id)
    {
        $conn = SQLConnector::createConn();
        $stat = $conn->prepare("SELECT * FROM athlete_group WHERE id = ?;");
        $stat->bind_param("i", $id);
        $stat->execute();
        $result = $stat->get_result();

        $row = $result->fetch_array(MYSQLI_NUM);
        $g = new Group($row[0], $row[1], $row[2]);

        GroupManager::addAthletes($g);
        GroupManager::updateAssignedCoach($g);
        GroupManager::updatecollabCoaches($g);
        GroupManager::updateCourses($g);

        return $g;
    }

    /** ajoute des athlètes au groupe
     * @param Group $g Group
     */
    public static function addAthletes($g)
    {
        $id = $g->getID();
        $athletes = [];
        $conn = SQLConnector::createConn();
        $stat = $conn->prepare("SELECT * FROM ta_group_athlete WHERE athlete_group = ?;");
        $stat->bind_param("i", $id);
        $stat->execute();
        $result = $stat->get_result();

        if (!$result) {
            die("Requête invalide: " . mysql_error() . "<br>");
        }

        while ($row = $result->fetch_array(MYSQLI_NUM)) {
            array_push($athletes, $row[1]);
        }

        $conn->close();
        $g->setAthletes($athletes);
    }

    /** assigne le coach princial du groupe
     * @param Group $g Group
     */
    public static function updateAssignedCoach($g)
    {
        $id = $g->getID();
        $conn = SQLConnector::createConn();
        $stat = $conn->prepare("SELECT coach FROM ta_group_coach WHERE athlete_group = ? AND access_type = 1;");
        $stat->bind_param("i", $id);
        $stat->execute();
        $result = $stat->get_result();
        if ($row = $result->fetch_array(MYSQLI_NUM))
        {
            $g->setAssignedCoach($row[0]);
        }
        $conn->close();
    }

    /** set lea coachs collaborateurs du groupe
     * @param Group $g Group
     */
    public static function updateCollabCoaches($g)
    {
        $id = $g->getID();
        $coaches = [];
        $conn = SQLConnector::createConn();
        $stat = $conn->prepare("SELECT coach FROM ta_group_coach WHERE athlete_group = ? AND access_type = 2;");
        $stat->bind_param("i", $id);
        $stat->execute();
        $result = $stat->get_result();

        if (!$result) {
            die("Requête invalide: " . mysql_error() . "<br>");
        }

        while ($row = $result->fetch_array(MYSQLI_NUM)) {
            array_push($coaches, $row[0]);
        }

        $conn->close();
        $g->setCollabCoachs($coaches);

    }

    /** set les Courses du groupe
     * @param Group $g Group
     */
    public static function updateCourses($g)
    {
        $id = $g->getID();
        $courses = [];

        $conn = SQLConnector::createConn();
        $stat = $conn->prepare("SELECT course FROM ta_course_group WHERE athlete_group = ?;");
        $stat->bind_param("i", $id);
        $stat->execute();
        $result = $stat->get_result();

        if (!$result) {
            die("Requête invalide: " . mysql_error() . "<br>");
        }

        while ($row = $result->fetch_array(MYSQLI_NUM)) {
            array_push($courses, $row[0]);
        }

        $conn->close();
        $g->setCourses($courses);
    }

    /** update les infos du groupe dans la DB
     * @param $g Group
     */
   public static function addGroup($g)
    {
        $name = $g->getName();
        $description = $g->getDescription();
		$id = $g->getID();
        #INSERT INTO athlete_group
        $conn = SQLConnector::createConn();
        $stat = $conn->prepare("INSERT INTO athlete_group (name, description) VALUES (?,?);");
        $stat->bind_param("ss", $name, $description);
        $stat->execute();

		$index = $stat->insert_id;

		$conn->close();
		$conn = SQLConnector::createConn();
		$stat = $conn->prepare("INSERT INTO ta_group_coach (access_type, athlete_group) VALUES (1, ?);");
		$stat->bind_param("i",$id);
		$stat->execute();
		$conn->close();

        return $index;
    }

    /** supprime un groupe de la DB
     * @param Group $g Group
     */
    public static function removeGroup($g)
    {

        $id = $g->getID();
        //DELETE FROM ta_course_group
        $conn = SQLConnector::createConn();
        $stat = $conn->prepare("DELETE FROM ta_course_group WHERE athlete_group = ?;");
        $stat->bind_param("i", $id);
        $stat->execute();
        $conn->close();

        //DELETE from ta_group_athlete
        $conn = SQLConnector::createConn();
        $stat = $conn->prepare("DELETE FROM ta_group_athlete WHERE athlete_group = ?;");
        $stat->bind_param("i", $id);
        $stat->execute();
        $conn->close();


        //DELETE FROM ta_group_coach
        $conn = SQLConnector::createConn();
        $stat = $conn->prepare("DELETE FROM ta_group_coach WHERE athlete_group = ?;");
        $stat->bind_param("i", $id);
        $stat->execute();
        $conn->close();

        //DELETE FROM athlete_group
        $conn = SQLConnector::createConn();
        $stat = $conn->prepare("DELETE FROM athlete_group WHERE id = ?;");
        $stat->bind_param("i", $id);
        $stat->execute();
        $conn->close();
    }

    /** get le prochain id de la table athlete_group
     * @return int prochain id
     */
    public static function loadNextGroupID()
    {
        $conn = SQLConnector::createConn();
        $stat = $conn->prepare("SELECT MAX(id) FROM athlete_group;");
        $stat->execute();
        $result = $stat->get_result();

        $row = $result->fetch_array(MYSQLI_NUM);
        $id = $row[0] + 1;
        $conn->close();
        return $id;
    }

    public static function getAthletesInGroup($group)
    {
        $athletes = [];
        $id = $group->getID();
        $conn = SQLConnector::createConn();
        $stat = $conn->prepare("SELECT athlete FROM ta_group_athlete WHERE athlete_group = ?;");
        $stat->bind_param("i", $id);

        $stat->execute();
        $result = $stat->get_result();

        if (!$result) {
            die("Requête invalide: " . mysql_error() . "<br>");
        }

        while ($row = $result->fetch_array(MYSQLI_NUM)) {
            $a = $row[0];
            array_push($athletes, $a);
        }

        $conn->close();
        return $athletes;

    }

    /** get les athlètes qui ne sont pas dans le groupe
     * @param Group $group Group
     * @return array Athlete
     */
    public static function loadAthletesNotInGroup($group)
    {
        $athletes = [];
        #SELECT athletes from not in group
        $id = $group->getID();
        $conn = SQLConnector::createConn();
        $stat = $conn->prepare("SELECT athlete.id FROM athlete WHERE NOT EXISTS (SELECT * FROM ta_group_athlete WHERE ta_group_athlete.athlete = athlete.id AND ta_group_athlete.athlete_group = ?);");
        $stat->bind_param("i", $id);
        $stat->execute();
        $result = $stat->get_result();

        if (!$result) {
            die("Requête invalide: " . mysql_error() . "<br>");
        }

        while ($row = $result->fetch_array(MYSQLI_NUM)) {
            $a = $row[0];
            array_push($athletes, $a);
        }

        $conn->close();
        return $athletes;
    }

    /** Ajoute un athlète à un groupe
     * @param int $idGroup id du groupe
     * @param int $idAthlete id de l'athlète
     */
    public static function addAthleteToGroup($idGroup, $idAthlete)
    {
        $conn = SQLConnector::createConn();
        $stat = $conn->prepare("INSERT INTO ta_group_athlete (athlete_group, athlete) VALUES (?,?);");
        $stat->bind_param("ii", $idGroup, $idAthlete);
        $stat->execute();
        $conn->close();
    }

    /** supprime un athlète du groupe
     * @param int $idGroup id du groupe
     * @param int $idAthlete id de l'athlète
     */
    public static function removeAthleteFromGroup($idGroup, $idAthlete)
    {
        $conn = SQLConnector::createConn();
        $stat = $conn->prepare("DELETE FROM ta_group_athlete WHERE athlete_group = ? AND athlete = ?;");
        $stat->bind_param("ii", $idGroup, $idAthlete);
        $stat->execute();
        $conn->close();
    }

    /** get les courses qui ne sont pas dans le groupe
     * @param $group Group
     * @return array Course
     */
    public static function loadCoursesNotInGroup($group)
    {
        $courses = [];
        #SELECT athletes from not in group
        $id = $group->getID();
        $conn = SQLConnector::createConn();
        $stat = $conn->prepare("SELECT course.id FROM course WHERE NOT EXISTS (SELECT * FROM ta_course_group WHERE ta_course_group.course = course.id AND ta_course_group.athlete_group = ?);");
        $stat->bind_param("i", $id);
        $stat->execute();
        $result = $stat->get_result();

        if (!$result) {
            die("Requête invalide: " . mysql_error() . "<br>");
        }

        while ($row = $result->fetch_array(MYSQLI_NUM)) {
            $a = $row[0];
            array_push($courses, $a);
        }

        $conn->close();
        return $courses;
    }

    /** ajoute un course au groupe
     * @param int $idGroup id du groupe
     * @param int $idCourse id du course
     */
    public static function addCourseToGroup($idGroup, $idCourse)
    {
        $conn = SQLConnector::createConn();
        $stat = $conn->prepare("INSERT INTO ta_course_group (course, athlete_group) VALUES (?,?);");
        $stat->bind_param("ii", $idCourse, $idGroup);
        $stat->execute();
        $conn->close();
    }

    /** supprime un course du groupe
     * @param int $idGroup id du groupe
     * @param int $idCourse id du course
     */
    public static function removeCourseFromGroup($idGroup, $idCourse)
    {
        $conn = SQLConnector::createConn();
        $stat = $conn->prepare("DELETE FROM ta_course_group WHERE athlete_group = ? AND course = ?;");
        $stat->bind_param("ii", $idGroup, $idCourse);
        $stat->execute();
        $conn->close();
    }
}
