<?php
require '../../database/SQLConnector.php';
require '../../database/SQLResultToJson.php';

$conn = SQLConnector::createConn();

if (isset($_GET['id'])) {
    $stm = $conn->prepare("SELECT * FROM athlete WHERE id = ?");
    $stm->bind_param("i", $_GET['id']);

} else if (isset($_GET['coach'])) {
    $stm = $conn->prepare("
        SELECT athlete.* FROM athlete
        JOIN ta_group_athlete a ON athlete.id = a.athlete
        JOIN ta_group_coach b ON a.athlete_group = b.athlete_group
        WHERE b.coach = ?
    ");
    $stm->bind_param("i", $_GET['coach']);

} else if (isset($_GET['group'])) {
    $stm = $conn->prepare("
        SELECT athlete.* FROM athlete
        JOIN ta_group_athlete a ON athlete.id = a.athlete
        WHERE a.athlete_group = ?
    ");
    $stm->bind_param("i", $_GET['group']);

} else {
    $stm = $conn->prepare("SELECT * FROM athlete");
}

$stm->execute();
$result = $stm->get_result();
header('Content-Type: application/json');
echo convertToJson($result);

