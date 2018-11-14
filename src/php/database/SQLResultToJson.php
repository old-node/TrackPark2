<?php

/**
 * @param $results mysqli_result
 * @return string
 */
function convertToJson($results) {
    $rows = array();
    while($row = $results->fetch_assoc()) {
        $rows[] = $row;
    }
    $encoded = json_encode($rows);
    return $encoded;
}