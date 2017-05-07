<?php
    include '../dev/bigdiscounts/item_lookup.php';
    include '../dev/bigdiscounts/connect.php';

    session_start();

    if($_SERVER["REQUEST_METHOD"] == "GET") {
        $pid = $_GET["pid"];
    } else {
        header("Location: ./index.php");
    }

    $email = $_SESSION["useremail"];
?>

<html>
	<head>
	    <meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>bar-gain</title>

		<!-- Bootstrap -->
		<link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">


        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
		<script src="https://use.fontawesome.com/ab12edd70a.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="../js/sweetalert.min.js"></script>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <link rel="stylesheet" type="text/css" href="../css/sweetalert.css">
    </head>

	<body>
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toogle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <img href="index.php" src="../img/bargain.png" height="50x" style="padding-right: 15px">
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav" style="float: right;">
                        <li class="active"><a href="index.php"> <span class="glyphicon glyphicon-home" aria-hidden="true"></span> Home</a></li>
                        <li><a href="../index.php"> <span class="glyphicon glyphicon-user" aria-hidden="true"></span> Retailer</a></li>
                        <li><a href="login.php"><span class="glyphicon glyphicon-off" aria-hidden="true"></span> SignUp/SignIn</a></li>
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                 <form action="./search-results.php" method="GET">
                        <div class="form-group col-md-7">
                            <input type="text" class="form-control" id="search_item" name="search_item" placeholder="Search...."></input>
                        </div>
                        <div class="form-group col-md-3">
                            <select class="form-control" name="category">
                                <option value="Electronics">Electronics</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-default btn-block" type="submit" name="simple_search">Search</button>
                    </form>
                </div>
            </div>
        </nav>
        <div style="margin-top: 150px"></div>

		<div class="row">
            <div class="container">
                <?php
                    $sql  = "SELECT * FROM bargainbin where pid = '$pid' and vemail = '$email'";
                    $result = $conn->query($sql);

                    if($result->num_rows == 1) {
                        $row = $result->fetch_assoc();

                        $html =
                            '<div class="table-responsive">' .
                                '<table class="table-bordered">' .
                                    '<thead>' .
                                        '<th> PID </th>' .
                                        '<th> Discount </th>' .
                                        '<th> Goal </th>' .
                                        '<th> Reach </th>' .
                                    '</thead>' .
                                    '<tbody>' .
                                        '<tr>' .
                                            '<td>' . $row["pid"] . '</td>' .
                                            '<td>' . $row["discount"] . '%</td>' .
                                            '<td>' . $row["goal"] . '</td>' .
                                            '<td>' . $row["reach"] . '</td>' .
                                        '</tr>' .
                                    '</tbody>' .
                                '</table>' .
                            '</div>';
                        echo $html;
                    }
                ?>
				<?php
					echo itemLookup($pid);
				?>
				<div style="margin-left: 30px">
                <a class="btn btn-primary" href="<?php echo '../dev/bigdiscounts/add_item.php?pid=' . $pid; ?>">Add to Stock</a>
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#discountModal">Offer Discount</button>
                <?php
                    $sql = "SELECT * from discounts where pid = '$pid'";

                    $result = $conn->query($sql);

                    if($result->num_rows == 0) {
                        echo '<h3>No discount demand</h3>';
                    }
                ?>
                <div id="chart_div"></div>
            </div>
		</div>

        <?php
            if(isset($_GET["status"])) {
                $status = $_GET["status"];
                if($status == "success") {
                    ?>
                    <script>
                        swal("Success!", "", "success")
                    </script>
                <?php } else {
                    ?>
                    <script>
                        sweetAlert("Failed", "", "error");
                    </script>
                <?php }
            }
        ?>

        <div id="discountModal" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Offer a discount in the Bargainbin</h4>
                    </div>
                    <div class="modal-body">
                        <form action="../dev/bigdiscounts/process_new_bargain.php" method="GET">
                            <div class="col-md-11 col-lg-11 col-xs-11 center-block panel-login panel-white">
                                <div class="form-group">
                                    <label for="pid">Product ID</label>
                                    <input type="text" class="form-control" name="product_id" id="pid" required="require" value="<?php echo $pid;?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="vemail">Vendor Email</label>
                                    <input type="email" class="form-control" name="vemail" id="vemail" required="require" value="<?php echo $email; ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="discount">Discount</label>
                                    <input type="number" class="form-control" name="discount" id="discount" required="require" min=1 max=99>
                                </div>
                                <div class="form-group">
                                    <label for="goal">Goal</label>
                                    <input type="number" class="form-control" name="goal" id="goal" required="require" min=1>
                                </div>
                                <button class="btn btn-success" type="submit">Submit</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </form>
                        <div class="modal-footer">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            google.charts.load('current', {packages: ['corechart', 'bar']});
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {
                var data = google.visualization.arrayToDataTable([
                      ['Date', 'Price'],
                      <?php
                        $count = array(0,0,0,0,0,0,0,0,0,0);

                        while ($row = $result->fetch_assoc()) {
                            $num = $row['discount'];

                            if($num <10)
                                $count[0]++;
                            else if($num >=10 && $num<20)
                                $count[1]++;
                            else if($num >=20 && $num<30)
                                $count[2]++;
                            else if($num >=30 && $num<40)
                                $count[3]++;
                            else if($num >=40 && $num<50)
                                $count[4]++;
                            else if($num >=50 && $num<60)
                                $count[5]++;
                            else if($num >=60 && $num<70)
                                $count[6]++;
                            else if($num >=70 && $num<80)
                                $count[7]++;
                            else if($num >=80 && $num<90)
                                $count[8]++;
                            else if($num >=90 && $num<100)
                                $count[9]++;
                            // echo "['".$row['timestamp']."',".$num."],";
                        }
                            echo "['0-10'," . $count[0] . "],";
                            echo "['10-20'," . $count[1] . "],";
                            echo "['20-30'," . $count[2] . "],";
                            echo "['30-40'," . $count[3] . "],";
                            echo "['40-50'," . $count[4] . "],";
                            echo "['50-60'," . $count[5] . "],";
                            echo "['60-70'," . $count[6] . "],";
                            echo "['70-80'," . $count[7] . "],";
                            echo "['80-90'," . $count[8] . "],";
                            echo "['90-100'," . $count[9] . "]";
                      ?>
                    ]);

                    var options = {
                      title: 'Discounts Demanded by Users',
                      legend: { position: 'bottom' }
                    };
                    var chart = new google.visualization.ColumnChart(
                document.getElementById('chart_div'));

              chart.draw(data, options);
            }
        </script>
	</body>
</html>
