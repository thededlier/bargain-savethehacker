<?php
    $html = "";

    $sql = "SELECT * FROM bargainbin where vemail = '$email' AND goal <= reach AND alerted = 0";

    $result = $conn->query($sql);

    if($reult->num_rows > 0) {
        while($rows = $result->fetch_assoc()) {
            $html .=
                '<div class="alert alert-info" style="margin-top: 100px;">
                    <strong>Information!</strong> A goal has been reached on a product <a href="details.php?pid=' . $pid . '" class="alert-link"> ' . $pid . '</a>.
                </div>';
        }
    }
    echo $html;
?>
