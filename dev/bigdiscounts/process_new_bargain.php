<?php
    include './connect.php';

    session_start();

    $pid = $_GET["pid"];
    $email = $_SESSION['useremail'];
    $discount = $_GET["discount"];
    $goal = $_GET["goal"];
    $bid = uniqid('BD');

    $sql = "INSERT INTO bargainbin(bid,pid,vemail,discount,goal) values('$bid','$pid','$email',$discount,$goal)";

    if($conn->query($sql)){
        header("Location: ../../retailer/details.php?pid=" . $pid . "&status=" . "success");
    } else {
        header("Location: ../../retailer/details.php?pid=" . $pid . "&status=" . "fail");
    }
?>
