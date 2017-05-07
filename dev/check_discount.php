<?php
    include './cors.php';

    $uid = $_REQUEST["uid"];
    $pid = $_REQUEST["pid"];
    $vemail = $_REQUEST["vemail"];
    $check = 0;

    $sql = "SELECT * from bargainbin where pid = '$pid' and vemail = '$vemail'";

    $result = $conn->query($sql);

    if($result->num_rows > 1) {
        while($row = $result->fetch_assoc()) {
            if($row["uid"] === $uid) {
                $check = 1;
                break;
            }
        }
    }
    $response = array('status' => 200, 'message' => 'success', 'check' => $check);

    echo json_encode($response);
?>
