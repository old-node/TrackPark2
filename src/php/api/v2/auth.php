<?php
require_once '../../util/RequestUtil.php';
require_once '../../database/SQLResultToJson.php';
require_once '../../AuthenticationManager.class.php';
require_once '../../User.class.php';

if(isPost()) {
    $data = json_decode(file_get_contents('php://input'), true);
    if(isset($data['username']) && isset($data['password'])) {
        if(AuthenticationManager::verifyCredentials($data['username'], $data['password'])) {
            $user = User::fromUsername($data['username']);
            $id = $user->getId();
            $coach = $user->getEvaluator();

            $find = findSession($id);
            if($find !== null) {
                header('Content-Type: application/json');
                echo "{\"id\": {$id},\"token\": \"{$find}\",\"coach\": {$coach}}";
                return;
            }

            $token = generateToken();
            insertSession($id, $token);
            header('Content-Type: application/json');
            echo "{\"id\": {$id},\"token\": \"{$token}\",\"coach\": {$coach}}";
            return;
        }
    }

    http_response_code(400); //Bad request
}

function generateToken() {
    return md5(uniqid(rand(), true));
}

function findSession($user_id) : ?string {
    $conn = SQLConnector::createConn();
    if ($stm = $conn->prepare("SELECT token FROM session WHERE user_id = ?")) {
        $stm->bind_param("i", $user_id);
        $stm->execute();

        $result = $stm->get_result();

        if (mysqli_num_rows($result) == 1) {
            $row = $result->fetch_assoc();
            return $row["token"];
        } else {
            return null;
        }
    }
    $conn->close();
}

function insertSession($id, $token) {
    $conn = SQLConnector::createConn();
    if ($stm = $conn->prepare("INSERT INTO session (user_id, token) VALUES (?,?)")) {
        $stm->bind_param("is", $id, $token);
        $stm->execute();
    }
    $conn->close();
}