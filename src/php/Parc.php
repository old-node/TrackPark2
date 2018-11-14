<?php
/**************************************************************************************
Fichier :       Parc.php
Auteur :        Antoine Gagnon
Fonctionnalité : Permet d'instancier un parc.
Date :          2 mai 2018
=======================================================================================
Vérification :
Date		Nom					    Approuvé
2018-05-06  Olivier Lemay Dostie    Oui
=======================================================================================
Historique de modification :
Date		Nom						Description
2018-05-02	Antoine Gagnon          Création
**************************************************************************************/

include_once 'SQLConnector.class.php';

/**
 * Classe Parc
 */
class Parc implements JsonSerializable
{
    private $name;

    private $lat;

    private $lng;

    /**
     * Parc constructor.
     * @param $name
     * @param $lat
     * @param $lng
     */
    public function __construct($name, $lat, $lng)
    {
        $this->name = $name;
        $this->lat = $lat;
        $this->lng = $lng;
    }

    public static function getAllParcs() {
        $parcs = [];
        $conn = SQLConnector::createConn();
        if ($stm = $conn->prepare("SELECT * FROM parc")) {
            $stm->execute();

            $result = $stm->get_result();

            while ($row = $result->fetch_assoc()) {
                array_push($parcs,
                    new Parc($row['name'], $row['lat'], $row['lng'])
                );
            }
        }
        $conn->close();
        return $parcs;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * @param mixed $lat
     */
    public function setLat($lat): void
    {
        $this->lat = $lat;
    }

    /**
     * @return mixed
     */
    public function getLng()
    {
        return $this->lng;
    }

    /**
     * @param mixed $lng
     */
    public function setLng($lng): void
    {
        $this->lng = $lng;
    }

    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}