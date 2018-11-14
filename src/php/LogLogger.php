<?php
/**
 * Created by Antoine Gagnon
 * Date: 2018-05-08
 */

include_once 'SQLConnector.class.php';
class LogLogger
{
    public static function log(string $username, bool $success) {
        $conn = SQLConnector::createConn();
        if ($stm = $conn->prepare("INSERT INTO loginlogs (username, ip, success) VALUES (?,?,?)")) {
            $ip = $_SERVER['REMOTE_ADDR'];

            $stm->bind_param("ssi", $username,$ip, intval($success));
            $stm->execute();
        }
        $conn->close();
    }
}