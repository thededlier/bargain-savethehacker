<?php
    session_start();

    $email =  $_SESSION["useremail"];
    include '../dev/bigdiscounts/connect.php';
    include '../dev/bigdiscounts/get_vendor_products.php';
    include '../dev/bigdiscounts/get_vendor_offers.php';
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
        <link href="../css/stylesheet.css" rel="stylesheet">
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
		<script src="https://use.fontawesome.com/ab12edd70a.js"></script>
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
                        <li><a href="../index.php"> <span class="glyphicon glyphicon-user" aria-hidden="true"></span> Log Out</a></li>
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
                <div class="col-md-8 col-xs-12">
                    <h3>Your Stock</h3>
                    <?php echo get_vendor_products($email); ?>
                </div>
                <div class="col-md-4 col-xs-12">
                    <h1>Your Offers</h1>
                    <?php echo get_vendor_offers($email);?>
                </div>
				<?php
					if(isset($_POST["simple_search"])) {
						$searchIndex = $_POST["category"];
						$keywords = $_POST["search_item"];
						itemSearch($searchIndex, $keywords);
					}
				?>
            </div>
		</div>
        <?php include '../dev/bigdiscounts/notify_goal_reach.php'; ?>
        <hr/>
	</body>
</html>
