<?php
    include './connect.php';

    session_start();

    $pid = $_GET["pid"];
    $useremail = $_SESSION['useremail'];

    $sql = "UPDATE retailers SET products = CONCAT(products, '$pid,') where email = '$useremail'";

    if($conn->query($sql)){
        header("Location: ../../retailer/details.php?pid=" . $pid . "&status=" . "success");
    } else {
        header("Location: ../../retailer/details.php?pid=" . $pid . "&status=" . "fail");
    }
?>
