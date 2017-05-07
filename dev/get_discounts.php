<?php
    include './cors.php';

    $uid = $_REQUEST["uid"];
    $check = 0;

    $sql = "SELECT * from discounts where uid = $uid";

    $result = $conn->query($sql);

    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $response[] = $row;
        }
    }

    echo json_encode($response);
?>
