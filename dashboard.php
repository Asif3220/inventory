<?php
require_once('auth.php');
include('db.php');
//echo '<br>_SESSION<pre>';
//print_r($_SESSION);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Dashboard</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/dashboard.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
<!--          <div style="float:left; width:20%"><img src="images/Simply-Eezy-Logo-1.png" width="20%"  class="img-responsive" alt="EEZY"></div>-->
		  <a class="navbar-brand" href="#">Inventory Management</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="logout.php">Log Out</a></li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
		  <br><img src="images/SimplyEezyLogo.png" ><br>
            <li class="active"><a href="dashboard.php">Overview <span class="sr-only">(current)</span></a></li>
			<li><a href="inventory.php">Inventory</a></li>
			<li><a href="stock.php">Stock</a></li> 
			<li><a href="sales.php">Sales Orders</a></li>
                       
           </ul>
         <div style="position:fixed;bottom:0px;margin-right:right;margin-left:auto; font-style:italic"><footer>Design & developed by Creosoft Systems Team | Inventory Management - Version <strong>1.0</strong> </footer></div>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Dashboard</h1>

		<div class="well well-lg">
			<div class="row">
				<div style=" text-align:center;">
				
					<div class="col-xs-3">
						<button type="button" class="btn btn-success btn-lg" onClick='location.href="dashboard.php";'>Overview</button>
					</div>	
						
					<div class="col-xs-3">
						<button type="button" class="btn btn-primary btn-lg" onClick='location.href="inventory.php";'>Inventory</button>
					</div>
					
					<div class="col-xs-3">
						<button type="button" class="btn btn-primary btn-lg" onClick='location.href="stock.php";'>Stock</button>
					</div>					
					
					<div class="col-xs-3">
						<button type="button" class="btn btn-primary btn-lg" onClick='location.href="sales.php";'>Sales Order</button>
					</div>
					
				</div>
			</div>
		</div>	
          
        </div>
      </div>
    </div>
	
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="js/vendor/jquery.min.js"><\/script>')</script>
    <script src="js/bootstrap.min.js"></script>
    <!-- Just to make our placeholder images work. Don't actually copy the next line! -->
    <script src="js/holder.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="js/ie10-viewport-bug-workaround.js"></script>
	
  </body>
</html>
