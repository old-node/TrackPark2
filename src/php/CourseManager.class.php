<?php
/**************************************************************************************
Fichier :       CourseManager.class.php
Auteur :		Francis Forest
Fonctionallité : Classe servant à gérer l'affichage des interfaces Web et
 * à inclure les fonctions communes à plusieurs fichiers.
Date :          23 avril 2018
=======================================================================================
Vérification :
Date		Nom					    Approuvé
2018-05-06  Olivier Lemay Dostie    Doit exclure l'épreuve avec
 * l'identifiant 0 dans le chargement, sinon OK.
=======================================================================================
Historique de modification :
Date		Nom						Description
2018-04-23	Francis Forest          Création
2018-05-05  Olivier Lemay Dostie    Versionnement et merge
**************************************************************************************/

include_once "Drill.class.php";
include_once "Course.class.php";

/**
 * Class CourseManager
 * Cette classe permet de gérer les courses du programme. Elle communique avec la BD pour insérer,
 * modifier et ajouter des champs.
 */
class CourseManager
{

    /**
     * Récupère les Courses de la base de données
     * @return array Course
     */
	public static function loadCourses()
	{
        $courses = [];

        #SELECT FROM course
        $conn = SQLConnector::createConn();
        $stat = $conn->prepare("SELECT * FROM course");
        $stat->execute();
        $result = $stat->get_result();

        if (!$result)
        {
            die("Requête invalide: " . mysql_error() . "<br>");
        }

        while ($row = $result->fetch_array(MYSQLI_NUM))
        {
            $c = new Course($row[0], $row[1], $row[2]);
            $drills = self::loadDrillsOfCourse($c->getID());
            $c->setDrills($drills);

            array_push($courses, $c);
        }

        $conn->close();
        return $courses;
	}

    /**
     * Récupère le course selon un ID
     * @param $id int id du course
     * @return Course
     */
    public static function loadCourse($id)
    {
        //SELECT FROM course
        $conn = SQLConnector::createConn();
        $stat = $conn->prepare("SELECT * FROM course WHERE course.id = ?");
        $stat->bind_param("i", $id);
        $stat->execute();
        $result = $stat->get_result();

        $row = $result->fetch_array(MYSQLI_NUM);

        $c = new Course($row[0], $row[1], $row[2]);

        $c = new Course($row[0], $row[1], $row[2]);
        $drills = self::loadDrillsOfCourse($c->getID());
        $groups = self::loadGroupsOfCourse($c->getID());
        $c->setDrills($drills);
        $c->setGroups($groups);

        return $c;
    }

    /**
     * Récupère les drills du Course
     * @param $idCourse int id du course
     * @return array Drill
     */
	public static function loadDrillsOfCourse($idCourse)
	{
		$drills = [];

		#SELECT FROM drill JOIN ta_course_drill
		$conn = SQLConnector::createConn();

		$stat = $conn->prepare("SELECT drill.id, drill.cap, drill.drill_type, drill.name, 
          drill.goal, drill.allowed_tries, drill.success_treshold, 
          drill.allowed_time, drill.failure_treshold, drill.obsolote FROM course 
          JOIN ta_course_drill ON ta_course_drill.course = course.id 
          JOIN drill ON ta_course_drill.drill = drill.id WHERE course.id = ?");
		$stat->bind_param("i",$idCourse);
		$stat->execute();
		$result = $stat->get_result();

		if (!$result)
		{
			die("Requête invalide: " . mysql_error() . "<br>");
		}
		
		while ($row = $result->fetch_array(MYSQLI_NUM))
		{
			$d = new Drill($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[9]);
			array_push($drills, $d);
		}
		
		$conn->close();
		return $drills;
	}

    /** get les groupes d'un course
     * @param $idCourse int id du course
     * @return array Group groupes du course
     */
	public static function loadGroupsOfCourse($idCourse)
    {
        $groups = [];

        #SELECT FROM ta_course_group
        $conn = SQLConnector::createConn();

        $stat = $conn->prepare("SELECT athlete_group FROM ta_course_group WHERE course = ?;");
        $stat->bind_param("i",$idCourse);
        $stat->execute();
        $result = $stat->get_result();

        if (!$result)
        {
            die("Requête invalide: " . mysql_error() . "<br>");
        }

        while ($row = $result->fetch_array(MYSQLI_NUM))
        {
            $g = $row[0];
            array_push($groups, $g);
        }

        $conn->close();
        return $groups;
    }

    /**
     * Ajoute un course dans la base de données
     * @param $course
     * @return int l'id du nouveau course ajouté
     */
	public static function addCourse($course)
	{
        #INSERT INTO course
        //$cap = $course->getCap();
        $type = $course->getType();
        $name = $course->getName();
        $conn = SQLConnector::createConn();
        $stat = $conn->prepare("INSERT INTO course (course_type, name) VALUES (?,?);");
        $stat->bind_param("is",$type, $name);
        $stat->execute();

        $id = $stat->insert_id;
        $conn->close();

        return $id;
	}

	public static function removeCourse($course)
    {
        $id = $course->getID();
        //DELETE FROM ta_course_group
        $conn = SQLConnector::createConn();
        $stat = $conn->prepare("DELETE FROM ta_course_group WHERE course = ?;");
        $stat->bind_param("i", $id);
        $stat->execute();
        $conn->close();

        //DELETE from ta_course_drill
        $conn = SQLConnector::createConn();
        $stat = $conn->prepare("DELETE FROM ta_course_drill WHERE course = ?;");
        $stat->bind_param("i", $id);
        $stat->execute();
        $conn->close();


        //DELETE FROM course
        $conn = SQLConnector::createConn();
        $stat = $conn->prepare("DELETE FROM course WHERE id = ?;");
        $stat->bind_param("i", $id);
        $stat->execute();
        $conn->close();
    }

    /** Update un course dans la base de données
     * @param $course Course
     */
	public static function updateCourse($course)
	{
		#UPDATE course
        $cap = $course->getCap();
        $type = $course->getType();
        $name = $course->getName();
        $id = $course->getID();
		$conn = SQLConnector::createConn();
		$stat = $conn->prepare("UPDATE course SET course_type = ?, name = ? WHERE course.id = ?;");
		$stat->bind_param("isi", $type, $name, $id);
		$stat->execute();
		$conn->close();
	}

    /** get les drills qui ne sont pas dans un course
     * @param $course Course
     * @return array Drill
     */
	public static function loadDrillsNotInCourse($course)
    {
        $drills = [];
        #SELECT DRILLS from not in course
        $id = $course->getID();
        $conn = SQLConnector::createConn();
        $stat =$conn->prepare("SELECT * FROM drill WHERE NOT EXISTS (SELECT * FROM ta_course_drill WHERE ta_course_drill.drill = drill.id AND ta_course_drill.course = ?);");
        $stat->bind_param("i", $id);
        $stat->execute();
        $result = $stat->get_result();

        if (!$result)
        {
            die("Requête invalide: " . mysql_error() . "<br>");
        }

        while ($row = $result->fetch_array(MYSQLI_NUM))
        {
            $d = new Drill($row[0], $row[1], null,  $row[2], $row[3], $row[4], $row[5], $row[5], $row[6], $row[7], $row[8]);
            array_push($drills, $d);
        }

        $conn->close();
        return $drills;
    }

    /** get les groupes qui ne sont pas dans un course
     * @param $course Course
     * @return array Group
     */
    public static function loadGroupsNotInCourse($course)
    {
        $groups = [];
        #SELECT groups not in course
        $id = $course->getID();
        $conn = SQLConnector::createConn();
        $stat =$conn->prepare("SELECT athlete_group.id FROM athlete_group WHERE NOT EXISTS (SELECT ta_course_group.athlete_group FROM ta_course_group WHERE ta_course_group.athlete_group = athlete_group.id AND ta_course_group.course = ?);");
        $stat->bind_param("i", $id);
        $stat->execute();
        $result = $stat->get_result();

        if (!$result)
        {
            die("Requête invalide: " . mysql_error() . "<br>");
        }

        while ($row = $result->fetch_array(MYSQLI_NUM))
        {
            $g = $row[0];
            array_push($groups, $g);
        }

        $conn->close();
        return $groups;
    }

    /** Ajoute un drill à un course
     * @param $idCourse int id du course
     * @param $idDrill int id du drill
     */
    public static function addDrillToCourse($idCourse, $idDrill)
    {
        $conn = SQLConnector::createConn();
        $stat = $conn->prepare("INSERT INTO ta_course_drill (course, drill) VALUES (?,?);");
        $stat->bind_param("ii", $idCourse, $idDrill);
        $stat->execute();
        $conn->close();
    }

    /** Supprime un drill du course
     * @param $idCourse int id du course
     * @param $idDrill int id du drill
     */
    public static function removeDrillFromCourse($idCourse, $idDrill)
    {
        $conn = SQLConnector::createConn();
        $stat = $conn->prepare("DELETE FROM ta_course_drill WHERE course = ? AND drill = ?;");
        $stat->bind_param("ii", $idCourse, $idDrill);
        $stat->execute();
        $conn->close();
    }

    /** Ajoute un groupe à un course
     * @param $idCourse int id du course
     * @param $idGroup int id du groupe
     */
    public static function addGroupToCourse($idCourse, $idGroup)
    {
        $conn = SQLConnector::createConn();
        $stat = $conn->prepare("INSERT INTO ta_course_group (course, athlete_group) VALUES (?,?);");
        $stat->bind_param("ii", $idCourse, $idGroup);
        $stat->execute();
        $conn->close();

    }

    /** supprime un groupe du course
     * @param $idCourse int id du course
     * @param $idGroup int id du groupe
     */
    public static function removeGroupFromCourse($idCourse, $idGroup)
    {
        $conn = SQLConnector::createConn();
        $stat = $conn->prepare("DELETE FROM ta_course_group WHERE course = ? AND athlete_group = ?;");
        $stat->bind_param("ii", $idCourse, $idGroup);
        $stat->execute();
        $conn->close();
    }

    /** get le prochain id de la table course
     * @return int prochain id de la table course
     */
    public static function loadNextCourseID()
    {
        $conn = SQLConnector::createConn();
        $stat = $conn->prepare("SELECT MAX(id) FROM course;");
        $stat->execute();
        $result = $stat->get_result();

        $row = $result->fetch_array(MYSQLI_NUM);
        $id = $row[0] + 1;
        $conn->close();
        return $id;

    }
}