<?php
// Include config file
require_once 'process/config.php';
// Define variables and initialize with empty values
session_start();
?>
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
    <link href="assets/css/fullcalendar.min.css" rel="stylesheet" />
    <link href="assets/css/fullcalendar.print.css" rel="stylesheet" />
    <link href="assets/css/override.css" rel="stylesheet" />
    <link href="assets/css/login.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datepicker/0.6.5/datepicker.min.css" />

</head>

<body class="loginBody">
    <div class="login-page">
        <div class="form">

            <form class="login-form" method="post" action="process/loginProcess.php">
                <img src="assets/img/logo.png" style="max-width: 360px; margin-bottom: 50px;">
                <input type="text" placeholder="username" name="username"/>
                <input type="password" placeholder="password" name="password"/>
                <button class="btn-primary">login</button>

            </form>
        </div>
    </div>


    <script src=" assets/js/jquery.3.2.1.min.js " type="text/javascript "></script>
    <script src="assets/js/bootstrap.min.js " type="text/javascript "></script>

    <!--  Charts Plugin -->
    <script src="assets/js/chartist.min.js "></script>

    <!--  Notifications Plugin    -->
    <script src="assets/js/bootstrap-notify.js "></script>

    <!--  Google Maps Plugin    -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.js"></script>
    <!-- Light Bootstrap Table Core javascript and methods for Demo purpose -->
    <script src="assets/js/light-bootstrap-dashboard.js?v=1.4.0 "></script>

    <!-- Light Bootstrap Table DEMO methods, don't include it in your project! -->
    <script src="assets/js/moment.min.js "></script>
    <script src="assets/js/fullcalendar.min.js "></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datepicker/0.6.5/datepicker.min.js"></script>
</body>

</html>