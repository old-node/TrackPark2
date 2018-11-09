<?php
/**************************************************************************************
Fichier :       Group.class.php
Auteur :        Shawn Corriveau
Fonctionnalité : Classe qui instancie un groupe d'athlète et ses évaluateurs.
Date :          28 avril 2018
=======================================================================================
Vérification :
Date        Nom	                    Approuvé
2018-05-06  Olivier Lemay Dostie    Oui
=======================================================================================
Historique de modification :
Date        Nom	                    Description
2018-04-25  Shawn Corriveau         Création
2018-04-28  Olivier Lemay Dostie    Versionnement pour merger
2018-04-30  Françis Forest          Refactorisation et réimplémentation
2018-05-06  Olivier Lemay Dostie    Mise à jour de la syntaxe
**************************************************************************************/

include_once './AthleteManager.class.php';

/**
 * Classe Group
 */
class Group
{
    //public const TABLE_NAME = "athlete_group";
    //public const ID_FIELD = "id";
    private $id;
    //public const NAME_FIELD = "name";
    private $name;
    //public const DESCRIPTION_FIELD = "description";
    private $description;
    private $athletes = [];
    private $courses = [];
    private $assignedCoach;
    private $collabCoaches;


    public function __construct($id, $name, $description)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
    }

    /**
     * @return int
     */
    public function getID(): int
    {
        return $this->id;
    }

    /**
     * Méthode proposé pour vérifier si l'identifiant est toujours le même que dans la BD.
     */
    public function fetchID(): int {
        $query = "SELECT id FROM athlete_group ".
            "WHERE name = ? AND description = ? AND ".
            "(SELECT access_type FROM ta_group_coach WHERE coach = ?) = ".
            "(SELECT id FROM access_type WHERE name = 'Assigné')";

        $conn = SQLConnector::createConn();
        try {
            $stat = $conn->prepare($query);
            $stat->bind_param('ssi',
                $this->getName(), $this->getDescription(), $this->getAssignedCoach());
            $stat->execute();
            $rs = $stat->get_result();

            if (!$rs) {
                die("Requête invalide: " . mysql_error() . "<br>");
            }
            $row = $rs->fetch_array(MYSQLI_NUM);

        } catch (Exception $e) {
            die("Une erreur s'est produite dans la connexion à la base de donnée.");
        } finally {
            $conn->close();
        }
        $this->setId($row[0]);
        return $this->getId();
    }

    /**
     * @param int $id
     */
    public function setID(int $id): void
    {
        $this->id = $id;
    }

    public function updateID(int $id): void
    {
        $conn = SQLConnector::createConn();
        try {
            $query = "UPDATE athlete_group ".
                "SET id={$this->getID()} WHERE id=$id";
            if ($conn->query($query) === TRUE) {
                $this->setID($id);
            } else {
                echo "Une erreur s'est produite lors de la mise à jour de l'identifiant: " . $conn->error;
            }
        } catch (Exception $e) {
            die("Une erreur s'est produite dans la connexion à la base de donnée.");
        } finally {
            $conn->close();
        }
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    public function fetchName()
    {
        //TODO
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function updateName()
    {
        //TODO
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    //TODO : fetch


    /**
     * @param string  $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    //TODO : update


    /**
     * @return array
     */
    public function getAthletes(): array
    {
        return $this->athletes;
    }

    //TODO : fetch
    public function fetchAthletes(): array
    {
        return AthleteManager::getIndexedPersons($this->athletes);
    }

    /**
     * @param array $athletes
     */
    public function setAthletes(array $athletes): void
    {
        $this->athletes = AthleteManager::getPersonIndexes($athletes);
    }


    //TODO : update
    public function updateAthletes(array $athletes): void
    {
        $conn = SQLConnector::createConn();
        $old = $this->getAthletes();
        $new = AthleteManager::getPersonIndexes($athletes);
        /* (Pas requis? : Juste vérifier que chaqun sont encore dans la BD)
        $toUpdate = array_intersect($old, $new);
        $update = $conn->prepare("UPDATE ta_group_athlete ".
            "SET athlete=? WHERE athlete_group = {$this->getID()}");*/
        $toRemove = array_diff($old, $new);
        $delete = $conn->prepare("DELETE FROM ta_group_athlete WHERE athlete_group={$this->getID()} AND athlete=?");
        $toInsert = array_diff($new, $old);
        $insert = $conn->prepare("INSERT INTO ta_group_athlete (athlete_group, athlete) VALUES ({$this->getID()}, ?)");

        try {
            foreach ($toRemove as $id)
            {
                $this->executeIntParam($delete, $id, "retirés");
            }
            foreach ($toInsert as $id)
            {
                $this->executeIntParam($insert, $id, "insérés");
            }
            $this->setAthletes($athletes);

        } catch (Exception $e) {
            die("Une erreur s'est produite dans la connexion à la base de donnée.\n");
        } finally {
            $conn->close();
        }
    }

    /**
     * @param mysqli_stmt $stat Déclaration mysqli que l'on doit paramétrer et exécuter.
     * @param int $var Valeur de l'élément à paramétrer.
     * @param string $action Action faites sur l'enregistrement (insérés/modifiés/retirés)
     * @postcondition Fermer la connexion de la déclaration dès qu'elle n'est plus utile.
     */
    private function executeIntParam(mysqli_stmt $stat, int $var, string $action = "insérés/modifiés/retirés")
    {
        $stat->bind_param('i',$var);
        $stat->execute();
        $status = $stat->get_result();

        if ($status === false) {
            trigger_error($stat->error, E_USER_ERROR);
        }
        printf("%d enregistrements ".$action."\n", $stat->affected_rows);
    }

    /**
     * @return array
     */
    public function getCourses(): array
    {
        return $this->courses;
    }

    //TODO : fetch ... (même chose pour les autres)

    /**
     * @param array $courses
     */
    public function setCourses(array $courses): void
    {
        $this->courses = $courses;
    }

    /**
     * @return int
     */
    public function getAssignedCoach()
    {
        return $this->assignedCoach;
    }

    public function fetchAssignedCoach(): Coach
    {
        return Coach::fromId($this->assignedCoach);
    }

    /**
     * @param Coach $assignedCoach
     */
    public function setAssignedCoach($assignedCoachId): void
    {
        $this->setAssignedCoachID($assignedCoachId);
    }

    public function setAssignedCoachID($id)
    {
        $this->assignedCoach = $id;
    }

    /**
     * @return array
     */
    public function getCollabCoachs(): array
    {
        return $this->collabCoaches;
    }

    /**
     * @return array
     */
    public function fetchCollabCoachs(): array
    {
        return CoachManager::getIndexedCoachs($this->getCollabCoachs());
    }

    /**
     * @param array $collabCoaches
     */
    public function setCollabCoachs(array $collabCoaches): void
    {
        $this->collabCoaches = $collabCoaches;
    }

    /**
     * @param array $collabCoaches
     */
    public function updateCollabCoachs(array $collabCoaches): void
    {
        $this->setCollabCoachs(CoachManager::getCoachsIndexes($collabCoaches));
    }

    public function addCollabCoach(Coach $c)
    {
        // Update Coach ID if necessary
        $this->addCollabCoachID($c->getId());
    }

    public function addCollabCoachID(int $id)
    {
        array_push($this->collabCoaches, $id);
    }

    public function addAthlete(Athlete $a)
    {
        // Update Athlete ID if necessary
        $this->addAthleteID($a->getId());
    }

    public function addAthleteID(int $a)
    {
        array_push($this->athletes, $a);
    }

    public function __toString():string
    {
        return $this->getName()." - ".$this->getDescription()." - ". print_r($this->getAthletes(), true);
    }
}