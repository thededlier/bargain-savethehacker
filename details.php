<?php
    include './dev/simple_item_lookup.php';
    include './dev/bigdiscounts/connect.php';

    session_start();

    if($_SERVER["REQUEST_METHOD"] == "GET") {
        $pid = $_GET["pid"];
    } else {
        header("Location: ./index.php");
    }
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
		<link href="./vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">


        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
		<script src="https://use.fontawesome.com/ab12edd70a.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
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
                    <img href="#" src="../img/bargain.png" height="50x" style="padding-right: 15px">
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav" style="float: right;">
                        <li class="active"><a href="#"> <span class="glyphicon glyphicon-home" aria-hidden="true"></span> Home</a></li>
                        <li><a href="./retailer/login.html"> <span class="glyphicon glyphicon-user" aria-hidden="true"></span> Retailer</a></li>
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
					echo simpleItemLookup($pid);
				?>
				<div style="margin-left: 30px">
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#discountModal">Wish for Discount</button>
            </div>
		</div>

        <?php
            if(isset($_GET["status"])) {
                $status = $_GET["status"];
                if($status == "success") {
                    ?>
                    <script>
                        alert("Success");
                    </script>
                <?php } else {
                    ?>
                    <script>
                        alert("Failed");
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
                        <h4 class="modal-title">At what price are you willing to buy?</h4>
                        <p>Remember to keep your discount rates reasonable so that the seller has a better idea of what price he can sell at</p>
                    </div>
                    <div class="modal-body">
                        <form action="../dev/bigdiscounts/process_new_bargain.php" method="GET">
                            <div class="col-md-11 col-lg-11 col-xs-11 center-block panel-login panel-white">
                                <div class="form-group">
                                    <label for="pid">Product ID</label>
                                    <input type="text" class="form-control" name="product_id" id="pid" required="require" value="<?php echo $pid;?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="uid">User ID</label>
                                    <input type="uid" class="form-control" name="uid" id="uid" required="require" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="discount">Discount</label>
                                    <input type="number" class="form-control" name="discount" id="discount" required="require" min=1 max=99>
                                </div>
                                <button class="btn btn-success" type="submit">Submit</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                    </div>
                </div>
            </div>
        </div>
        <script src="https://www.gstatic.com/firebasejs/3.9.0/firebase.js"></script>
        <script src="./js/firebase.js"></script>
        <script>
        </script>
	</body>
</html>
