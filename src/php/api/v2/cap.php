<?php
require '../../database/SQLConnector.php';
require '../../database/SQLResultToJson.php';

$conn = SQLConnector::createConn();

if (isset($_GET['code'])) {
    $stm = $conn->prepare("SELECT * FROM cap WHERE code = ?");
    $stm->bind_param("s", $_GET['code']);
} else {
    $stm = $conn->prepare("SELECT * FROM cap");
}

$stm->execute();
$result = $stm->get_result();
header('Content-Type: application/json');
echo convertToJson($result);

