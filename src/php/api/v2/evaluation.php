<?php
require_once '../../database/SQLConnector.php';
require_once '../../database/SQLResultToJson.php';
require_once '../../util/RequestUtil.php';

require_once 'verifyToken.php';
if(!verifyToken()) {
    http_response_code(401); //Unauthorized
    return;
}

$conn = SQLConnector::createConn();
$query = "SELECT evaluation.*, d.name AS 'drill_name', a.first_name AS 'athlete_first_name', a.name AS 'athlete_name'  FROM evaluation JOIN drill d ON evaluation.drill = d.id JOIN athlete a ON evaluation.athlete = a.id";
if (isGet()) {

    if (isset($_GET['id'])) {
        $stm = $conn->prepare($query . " WHERE evaluation.id = ?");
        $stm->bind_param("i", $_GET['id']);

    } else if (isset($_GET['athlete'])) {
        $stm = $conn->prepare($query . " WHERE athlete = ?");
        $stm->bind_param("i", $_GET['athlete']);

    } else if (isset($_GET['coach'])) {
        $stm = $conn->prepare($query . " WHERE coach = ?");
        $stm->bind_param("i", $_GET['coach']);

    } else {
        $stm = $conn->prepare($query);
    }

    $stm->execute();
    $result = $stm->get_result();
    header('Content-Type: application/json');
    echo convertToJson($result);

} else if (isPost()) {
    $data = json_decode(file_get_contents('php://input'), true);
    if (isset($data['id'])) {
        if (isset($data['state']) && isset($data['numerical_value'])) {
            $stm = $conn->prepare("UPDATE evaluation SET result_state = ?, numerical_value = ? WHERE id = ?");
            $stm->bind_param("iii", $data['state'], $data['numerical_value'], $data['id']);
            $stm->execute();
        } else if (isset($data['numerical_value'])) {
            $stm = $conn->prepare("UPDATE evaluation SET numerical_value = ? WHERE id = ?");
            $stm->bind_param("ii", $data['numerical_value'], $data['id']);
            $stm->execute();
        } else if (isset($data['state'])) {
            $stm = $conn->prepare("UPDATE evaluation SET result_state = ? WHERE id = ?");
            $stm->bind_param("ii", $data['state'], $data['id']);
            $stm->execute();
        }

        $stm = $conn->prepare( $query . " WHERE evaluation.id = ?");
        $stm->bind_param("i", $data['id']);
        $stm->execute();
        $result = $stm->get_result();
        header('Content-Type: application/json');
        echo convertToJson($result);
    } else {
        http_response_code(400);
    }
}


