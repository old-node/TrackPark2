<?php
require_once '../../database/SQLConnector.php';
require_once '../../util/RequestUtil.php';

function verifyToken(): bool
{
    if (isPost()) {
        $data = json_decode(file_get_contents('php://input'), true);
        if (isset($data['token'])) {
            return isTokenValid($data['token']);
        }
        return false;
    } else if (isGet()) {
        if (isset($_GET['token'])) {
            return isTokenValid($_GET['token']);
        }
        return false;
    }
}

function isTokenValid($token): bool
{
    $conn = SQLConnector::createConn();
    if ($stm = $conn->prepare("SELECT token FROM session WHERE token = ?")) {
        $stm->bind_param("s", $token);
        $stm->execute();

        $result = $stm->get_result();

        return mysqli_num_rows($result) == 1;
    }
    return false;
}
