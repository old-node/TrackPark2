<?php
require_once '../../database/SQLConnector.php';
require_once '../../database/SQLResultToJson.php';

require_once 'verifyToken.php';
if(!verifyToken()) {
    http_response_code(401); //Unauthorized
    return;
}

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

