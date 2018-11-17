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

if(isGet()) {
    if (isset($_GET['id'])) {
        $stm = $conn->prepare("
      SELECT athlete_group.*, ta_group_coach.coach FROM athlete_group
      JOIN ta_group_coach ON athlete_group.id = ta_group_coach.athlete_group
      WHERE id = ?
    ");
        $stm->bind_param("i", $_GET['id']);

    } else if (isset($_GET['coach'])) {
        $stm = $conn->prepare("
      SELECT athlete_group.*, ta_group_coach.coach FROM athlete_group
      JOIN ta_group_coach ON athlete_group.id = ta_group_coach.athlete_group
      WHERE coach = ?
    ");
        $stm->bind_param("i", $_GET['coach']);

    } else {
        $stm = $conn->prepare("
      SELECT athlete_group.*,ta_group_coach.coach FROM athlete_group
      JOIN ta_group_coach ON athlete_group.id = ta_group_coach.athlete_group
    ");
    }

    $stm->execute();
    $result = $stm->get_result();
    header('Content-Type: application/json');
    echo convertToJson($result);

} else if(isPost()) {

    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['action'])) {
        $action = $data['action'];

        if($action === 'addRight') {
            if(isset($data['group']) && isset($data['coach']) && isset($data['type'])) {
                $stm = $conn->prepare("INSERT INTO ta_group_coach (access_type, athlete_group, coach) VALUES (?,?,?)");
                $stm->bind_param("iii", $data['type'], $data['group'], $data['coach']);
                $stm->execute();
                http_response_code(200);
                return;
            } else {
                http_response_code(400);
                return;
            }
        }
    } else {
        http_response_code(400);
    }
}




