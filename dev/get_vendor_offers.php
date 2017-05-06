<?php

    $html = "";

    include './cors.php';
    include './credentials.php';

    $sql = "SELECT * from bargainbin";
    // error_reporting(0);

    $strIn = "";

    $result = $conn->query($sql);

    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $response[] = $row;
        }
        echo json_encode($response);
    }

?>
