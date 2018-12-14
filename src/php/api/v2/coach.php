<?php
require_once '../../database/SQLConnector.php';
require_once '../../database/SQLResultToJson.php';

require_once 'verifyToken.php';
if(!verifyToken()) {
    http_response_code(401); //Unauthorized
    return;
}

$conn = SQLConnector::createConn();

if (isset($_GET['id'])) {
    $stm = $conn->prepare("SELECT * FROM coach WHERE id = ?");
    $stm->bind_param("i", $_GET['id']);
} else if(isset($_GET['group'])) {
    $stm = $conn->prepare("SELECT * FROM coach JOIN ta_group_coach on coach.id = ta_group_coach.coach WHERE ta_group_coach.athlete_group = ?");
    $stm->bind_param("i", $_GET['group']);

   
} else if(isset($_GET['idCoach'])) {
    $stm = $conn->prepare("INSERT INTO `ta_group_coach` (`access_type`, `athlete_group`, `coach`, `start_date`, `end_date`) VALUES ('2',".$_GET['idGroup'].",".$_GET['idCoach'].", NULL, NULL);");

} else {
    $stm = $conn->prepare("SELECT * FROM coach");
}

$stm->execute();
$result = $stm->get_result();
header('Content-Type: application/json');
echo convertToJson($result);

