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
    $stm = $conn->prepare("SELECT * FROM drill WHERE id = ?");
    $stm->bind_param("i", $_GET['id']);
} else {
    $stm = $conn->prepare("SELECT * FROM drill");
}

$stm->execute();
$result = $stm->get_result();
header('Content-Type: application/json');
echo convertToJson($result);

