<?php
require_once 'process/config.php';
session_start();
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
  header("location: /hostgenius/login.php");
  exit;
}
if($_SESSION['type'] != "admin"){
    header("location: /hostgenius/property.php?id=".$_SESSION['userListing']);
}

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="icon" type="image/png" href="assets/img/favicon.ico">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <title>HostGenius | Admin Panel</title>

    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />


    <!-- Bootstrap core CSS     -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Animation library for notifications   -->
    <link href="assets/css/animate.min.css" rel="stylesheet" />

    <!--  Light Bootstrap Table core CSS    -->
    <link href="assets/css/light-bootstrap-dashboard.css?v=1.4.0" rel="stylesheet" />


    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="assets/css/demo.css" rel="stylesheet" />


    <!--     Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
    <link href="assets/css/pe-icon-7-stroke.css" rel="stylesheet" />
    <link href="assets/css/override.css" rel="stylesheet" />

</head>

<body>

    <div class="wrapper">
        <div class="sidebar" data-color="azure" data-image="assets/img/sidebar-5.jpg">

            <!--

        Tip 1: you can change the color of the sidebar using: data-color="blue | azure | green | orange | red | purple"
        Tip 2: you can also add an image using data-image tag

    -->

            <div class="sidebar-wrapper">
                <div class="logo">
                    <a href="http://www.creative-tim.com" class="simple-text">
                        HostGenius
                    </a>
                </div>

                <ul class="nav">
                    <li class="active">
                        <a href="index.php">
                            <i class="pe-7s-note2"></i>
                            <p>Listings</p>
                        </a>
                    </li>
                    <li>
                        <a href="property.php">
                            <i class="pe-7s-map-2"></i>
                            <p>Property</p>
                        </a>
                    </li>


                </ul>
            </div>
        </div>

        <div class="main-panel">
            <nav class="navbar navbar-default navbar-fixed">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation-example-2">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="#">Property Listings</a>
                    </div>
                    <div class="collapse navbar-collapse">


                        <ul class="nav navbar-nav navbar-right">


                            <li>
                                <a href="process/logoutProcess.php">
                                    <p><?=$_SESSION['name']?>, Log Out</p>
                                </a>
                            </li>
                            <li class="separator hidden-lg"></li>
                        </ul>
                    </div>
                </div>
            </nav>


            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="header">
                                    <!-- <h4 class="title">Striped Table with Hover</h4> -->

                                </div>
                                <div class="content table-responsive table-full-width" id="table">
                                    

                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="card">
                                <div class="header" style="text-align:center">
                                    <h4 class="title">Add Property</h4>
                                </div>
                                <form class="row" style="margin-top:20px" method="post" action="process/createProcess.php">
                                    <div class="col-md-12">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <input type="text" name="address" class="form-control" id="property" placeholder="Enter property address">
                                            </div>
                                            <div class="form-group">
                                                <input type="submit" class="form-control btn-primary" value="Submit">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>




        </div>
    </div>


</body>

<!--   Core JS Files   -->
<script src="assets/js/jquery.3.2.1.min.js" type="text/javascript"></script>
<script src="assets/js/bootstrap.min.js" type="text/javascript"></script>

<!--  Charts Plugin -->
<script src="assets/js/chartist.min.js"></script>

<!--  Notifications Plugin    -->
<script src="assets/js/bootstrap-notify.js"></script>

<!--  Google Maps Plugin    -->

<!-- Light Bootstrap Table Core javascript and methods for Demo purpose -->
<script src="assets/js/light-bootstrap-dashboard.js?v=1.4.0"></script>

<!-- Light Bootstrap Table DEMO methods, don't include it in your project! -->
<script src="assets/js/demo.js"></script>

<script type="text/javascript">
    function getTable() {
          jQuery.ajax({
              url:'process/grabListingsTable.php',
              type:'POST',
              success:function(results) {
                  jQuery($('#table')).html(results);
              }
          });
      }
      $(function () {
          getTable();
      });
</script>

</html>