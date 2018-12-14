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
    $stm = $conn->prepare("SELECT * FROM course WHERE id = ?");
    $stm->bind_param("i", $_GET['id']);
} else if (isset($_GET['coach'])) {
    $stm = $conn->prepare(
        "SELECT * FROM course
                JOIN ta_course_group ON ta_course_group.course = course.id
                JOIN ta_group_coach on ta_group_coach.coach = ta_course_group.athlete_group
                WHERE ta_group_coach.coach = ?
        ");
    $stm->bind_param("i", $_GET['coach']);
} else {
    $stm = $conn->prepare("SELECT * FROM course");
}

$stm->execute();
$result = $stm->get_result();
header('Content-Type: application/json');
echo convertToJson($result);

