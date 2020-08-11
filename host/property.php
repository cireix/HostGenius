<?php
require_once 'process/config.php';
session_start();
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
  header("location: /hostgenius/login.php");
  exit;
}
if($_SESSION['type'] != "admin" && $_GET['id'] != $_SESSION['userListing']){
    header("location: /hostgenius/property.php?id=".$_SESSION['userListing']);
}
if(!isset($_GET['id'])){
    header("location: /hostgenius/index.php");
}

$myQry = "SELECT address, inventory, damages, calendar, calendarNotes, managerID FROM listings WHERE id = ?";

//Prepare the query
if ($stmt = mysqli_prepare($link, $myQry)) {
  mysqli_stmt_bind_param($stmt, "s", $param_id);
    $param_id = $_GET['id'];
    $_SESSION['listingID'] = $_GET['id'];
    mysqli_stmt_execute($stmt);
    /* bind variables to prepared statement */
    mysqli_stmt_bind_result($stmt, $address, $inventory, $damages, $calendar, $calendarNotes, $managerID);

    /* fetch values */
    while (mysqli_stmt_fetch($stmt)) {}

    /* close statement */
    mysqli_stmt_close($stmt);
}
$myQry = "SELECT email, name, phone, photo from users WHERE id = ?";

//Prepare the query
if ($stmt = mysqli_prepare($link, $myQry)) {
  mysqli_stmt_bind_param($stmt, "s", $param_id);
    $param_id = $managerID;
    
    mysqli_stmt_execute($stmt);
    /* bind variables to prepared statement */
    mysqli_stmt_bind_result($stmt, $email, $name, $phone, $photo);

    /* fetch values */
    while (mysqli_stmt_fetch($stmt)) {}

    /* close statement */
    mysqli_stmt_close($stmt);
}



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
    <!-- <link href="assets/css/fullcalendar.print.css" rel="stylesheet" /> -->
    <link href="assets/css/override.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datepicker/0.6.5/datepicker.min.css" />

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
                <?php 
                    if($_SESSION['type'] == "admin"){
                ?>
                    <li>
                        <a href="index.php">
                            <i class="pe-7s-note2"></i>
                            <p>Listings</p>
                        </a>
                    </li>
                <?php
                    }
                ?>
                    <li class="active">
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
                        <a class="navbar-brand" href="#"><?=$address?></a>
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
                        <div class="col-md-12" style="text-align:center">
                            <div id="calendar"></div>
                            <button type="button" class="btn btn-primary eventAdd">Add Event</button>
                            <div id="addEvent" style="display:none">
                                <div class="col-md-12 card" >
                                    <div class="header">
                                        <h4 class="title">Add Event</h4>
                                        
                                    </div>
                                    <hr>
                                    <form style="margin-top: 20px" id="addEventForm">
                                        <div class="col-md-6">
                                            <div class="form-group" style="text-align:left">
                                                <label for="addEventTitle">Event Title</label>
                                                <input type="text" required class="form-control" id="addEventTitle" placeholder="Enter event title">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group" style="text-align:left">
                                                <label for="addEventTip">Event Information</label>
                                                <input type="text" required class="form-control" id="addEventTip" placeholder="Enter event information">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group input-group input-daterange" style="padding: 25px 0px;">
                                                <input class="form-control" required id="addEventStart" data-toggle="datepicker" placeholder="Start Date">
                                                <div class="input-group-addon">to</div>
                                                <input class="form-control" id="addEventEnd" data-toggle="datepicker" placeholder="End Date (optional)">
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <input type="button" class="form-control btn-primary" id="addEventSubmit" value="Submit">
                                            </div>
                                        </div>
                                        
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" style="margin-top:20px">
                            <div class="col-md-6 card">
                                <div class="header">
                                    <h4 class="title">Inventory</h4>
                                    <?php 
                                        if($_SESSION['type'] == "admin"){
                                    ?>
                                    <button type="button" class="btn btn-primary editInvBtn" forList="invList">Edit</button>
                                    <?php 
                                        }
                                    ?>
                                    
                                </div>
                                <ul class="list" id="invList"></ul>
                                <?php 
                                    if($_SESSION['type'] == "admin"){
                                ?>
                                <hr>
                                <div class="newField">
                                    <input type="number" class="newFieldCount invCount" value="1">
                                    <span>x</span>
                                    <input class="newFieldText invDesc" placeholder="Item Description">
                                    
                                    <button class="btn btn-primary newFieldAdd invAdd">Add</button>
                                </div>
                                <?php 
                                    }
                                ?>
                            </div>
                            <div class="col-md-6 card">
                                <div class="header">
                                    <h4 class="title">Damages</h4>
                                    <?php 
                                        if($_SESSION['type'] == "admin"){
                                    ?>
                                    <button type="button" class="btn btn-primary editDamBtn" forList="damList">Edit</button>
                                    <?php 
                                        }
                                    ?>
                                </div>
                                <ul class="list" id="damList"></ul>
                                <?php 
                                    if($_SESSION['type'] == "admin"){
                                ?>
                                <hr>
                                <div class="newField">
                                    <input class="newFieldText damDesc" placeholder="Item Description">
                                    <button class="btn btn-primary newFieldAdd damAdd">Add</button>

                                </div>
                                <?php 
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" style="margin-top: 20px;">
                            <div class="col-md-12 card">
                                <div class="header">
                                    <h4 class="title">Transactions</h4>
                                    <?php 
                                        if($_SESSION['type'] == "admin"){
                                    ?>
                                    <button type="button" class="btn btn-primary addTransBtn">Add</button>
                                    <?php 
                                        }
                                    ?>

                                </div>
                                <div class="content table-responsive table-full-width">
                                    <table class="table table-hover table-striped transactions" id="transTable">
                                        
                                    </table>
                                    <form id="addTrans" style="display:none">
                                        <hr>
                                        <div class="header" style="margin-bottom:20px;">
                                            <h4 class="title">Add Transaction</h4>
                                        </div>
                                        <div class="row transFormRow">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="transName">Client Name</label>
                                                    <input type="text" name="client" class="form-control" id="transName" placeholder="Enter client name">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="transTotal">Total Amount</label>
                                                    <input type="number" name="total" class="form-control" id="transTotal" placeholder="Enter total amount">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row transFormRow">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="transCleaning">Cleaning Fee</label>
                                                    <input type="number" name="cleaning" class="form-control" id="transCleaning" placeholder="Enter cleaning fee">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="transEarnings">Earnings</label>
                                                    <input type="number" name="earnings" class="form-control" id="transEarnings" placeholder="Enter earnings">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row transFormRow">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="transCommission">Manager Commission</label>
                                                    <input type="number" name="commission" class="form-control" id="transCommission" placeholder="Enter manager commission">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group input-group input-daterange " style="padding: 25px 0px;">
                                                    <input class="form-control" name="start" id="transStart" data-toggle="datepicker" placeholder="Start Date">
                                                    <div class="input-group-addon">to</div>
                                                    <input class="form-control" name="end" id="transEnd" data-toggle="datepicker" placeholder="End Date">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            
                                        </div>
                                        <div class="row transFormRow">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <input hidden name="unqid" id="unqid">
                                                    <input type="button" class="form-control btn-primary" id="transAdd" value="Add Transaction">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card card-user">
                                <div class="image">
                                    <img src="https://ununsplash.imgix.net/photo-1431578500526-4d9613015464?fit=crop&amp;fm=jpg&amp;h=300&amp;q=75&amp;w=400"
                                        alt="...">
                                </div>
                                <div class="content">
                                    <div class="author">
                                        <a href="#">
                                            <img class="avatar border-gray" src="assets/img/faces/<?=$photo?>.jpg" alt="...">

                                            <h4 class="title"><?=$name?>
                                                <br>
                                                <!-- <small>michael24</small> -->
                                            </h4>
                                        </a>
                                    </div>
                                    <p class="description text-center" style="margin-top: 30px;">
                                        Phone: <?=$phone?>
                                        <br> Email:
                                        <a href="mailto:<?=$email?>"><?=$email?></a>
                                    </p>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="col-md-12 card comments">
                                <div class="header">
                                    <h4 class="title">Comments</h4>
                                    <button type="button" class="btn btn-primary addComBtn">New</button>
                                </div>
                                <div class="chatlog" id="chatLog">
                                    
                                </div>
                                <hr>
                                <div class="addComment">
                                    <textarea id="commentBox" placeholder="Enter comment here ..."></textarea>
                                    <button class="sendComment btn-primary">Send</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




    </div>
    </div>


</body>

<!--   Core JS Files   -->
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

<!-- 
fc-day (calendarNotes)
<ul style="
    position:  absolute;
    top: 25px;
    list-style: none;
    padding: 0;
    "><li>Cleaning</li>
    <li>Cleaning</li>
</ul> -->
<script type="text/javascript ">
    var invEdit = false;
    var damEdit = false;
    var transAdd = false;
    var comAdd = false;

    var inventory = {};
    if('<?=$inventory?>' != ''){
        inventory = JSON.parse('<?=$inventory?>');
    }

    var damages = [];
    if('<?=$damages?>' != ''){
        damages = '<?=$damages?>'.split(",");
    }

    var events = [];
    if('<?=$calendarNotes?>' != ''){
        events = JSON.parse('<?=$calendarNotes?>');
    }

    var dates = {};
    if('<?=$calendar?>' != ''){
        dates = JSON.parse('<?=$calendar?>');
    }
    
    var tInventory;
    var tDamages;
    function fillCalendar(){
        $(".fc-day-top").each(function(){
            for(i = 1 ; i < 8; i ++){
                $(this).removeClass("cal"+i);
            }
        })
        var colorCount = 0;
        for (var name in dates){
            var inD = new Date(dates[name][1]);
            inD.setDate(inD.getDate()-1);
            var out = new Date(dates[name][2]);
            $(".fc-day-top").each(function(){
                var check = new Date($(this).attr("data-date"));
                if(moment(check).isBetween(inD,out)){  
                    console.log("123");
                    $(this).addClass("cal"+(colorCount%7+1));
                    
                }
            })  
            ++ colorCount;  
        }
        
    }
    function newInv(c,d){
        return '<li><span class="count">'+c+'</span>x <span class="item"> '+d+'</span></li>';
    }
    function newDam(d){
        return '<li><span class="item">'+d+'</span></li>';
    }
    function newTransInText(cl, pl, st){
        return '<input class="'+cl+'" value="'+pl+'" style="'+st+'">';
    }
    function newTransIn(cl, pl, st){
        return '<input type="number" class="'+cl+'" value="'+pl+'" style="'+st+'">';
    }
    <?php 
        if($_SESSION['type'] == "admin"){
    ?>
    
    function addToInventory(c,d){
        inventory[d] = c;
    }
    function addToDamages(d){
        damages.push(d);
    }
    function editTrans(id){
        var trans;
        $("tr").each(function(){
            if($(this).attr('transID') == id){
                trans = $(this);
                return;
            }
        });
        
        var name = trans.find(".name");
        var date = trans.find(".date");
        var total = trans.find('.total');
        var cleaning = trans.find(".cleaning");
        var earnings = trans.find(".earnings");
        var hg = trans.find(".hg");
        var status = trans.find(".status");
        //Name
        var nameF = name.html();
        name.html(newTransInText("editName",nameF,'text-align:center; width:70px'));
        //Total
        total.html(newTransIn("editTotal",total.html(),' width:70px'));
        //Cleaning
        cleaning.html(newTransIn("editCleaning",cleaning.html(),'width: 62px'));
        //Earnings
        earnings.html(newTransIn("editEarnings",earnings.html(),'width: 70px'));
        //HG
        hg.html(newTransIn("editHG",hg.html(),'width: 70px;'));
        //status
        status.removeClass("Paid");
        status.removeClass("Upcoming");
        status.removeClass("Late");
        status.css("color","black");
        if(status.html() == "Paid"){
            status.html("<select><option value='Upcoming'>Upcoming</option><option value='Late'>Late</option><option value='Paid' selected>Paid</option></select>");
        }else if(status.html() == "Late"){
            status.html("<select><option value='Upcoming'>Upcoming</option><option value='Late' selected>Late</option><option value='Paid'>Paid</option></select>");
        }else{
            status.html("<select><option value='Upcoming' selected>Upcoming</option><option value='Late'>Late</option><option value='Paid'>Paid</option></select>");
        }
        
    }

    function saveTrans(id){
        var trans;
        $("tr").each(function(){
            if($(this).attr('transID') == id){
                trans = $(this);
                return;
            }
        });
        
        var name = trans.find(".name");
        var total = trans.find('.total');
        var cleaning = trans.find(".cleaning");
        var earnings = trans.find(".earnings");
        var hg = trans.find(".hg");
        var status = trans.find(".status");

        name.html(name.find("input").val());
        total.html(parseFloat(total.find("input").val()).toFixed(2));
        cleaning.html(parseFloat(cleaning.find("input").val()).toFixed(2));
        earnings.html(parseFloat(earnings.find("input").val()).toFixed(2));
        hg.html(parseFloat(hg.find("input").val()).toFixed(2));
        
        var s = status.find(":selected").val();
        status.html(s);
        status.addClass(s);
        status.css('color','white');
        
        jQuery.ajax({
              url:'process/updateTransaction.php',
              type:'POST',
              data: genTransData(id,name.html(),total.html(),cleaning.html(),earnings.html(),hg.html(),status.html()),
              success:function(results) {

              },
              error:function(){
                  
              }
          });
        

    }
    function genTransData(id,name,total,cleaning,earnings,commission,status){
        return "id="+id+"&name="+name+"&total="+total+"&cleaning="+cleaning+"&earnings="+earnings+"&commission="+commission+"&status="+status;
    }
    <?php
        }
    ?>
    function calculate(){
        var e = 0;
        var o = 0;
        var h = 0;
        $(".earnings").each(function(){
            e += parseFloat($(this).html());
        })
        $(".hg").each(function(){
            h += parseFloat($(this).html());
        })
        
        $("#calcEarnings").html(e.toFixed(2));
        $("#calcHG").html(h.toFixed(2));
        <?php 
            if($_SESSION['type'] == "admin"){
        ?>
        
          jQuery.ajax({
              url:'process/updateCalculations.php',
              type:'POST',
              data:'hg='+h+"&total="+e,
              success:function(results) {
              }
          });
        <?php 
            }
        ?>
      
    }

    function loadInventory(){
        $("#invList").html("");
        for(var key in inventory){
            $("#invList").html($("#invList").html()+newInv(inventory[key],key));
        }
        if(invEdit){
            $('.editInvBtn').html("Edit");
            invEdit = false;
        }
    }
    function loadDamages(){
        $("#damList").html("");
        for(var index in damages){
            $("#damList").html($("#damList").html()+newDam(damages[index]));
        }
        if(damEdit){
            $('.editDamBtn').html("Edit");
            damEdit = false;
        }
    }
    
    <?php 
        if($_SESSION['type'] == "admin"){
    ?>
     function updateInventory() {
          jQuery.ajax({
              url:'process/updateInventory.php',
              type:'POST',
              data:'inventory='+JSON.stringify(inventory),
              success:function(results) {}
          });
      }
      function updateDamages() {
          jQuery.ajax({
              url:'process/updateDamages.php',
              type:'POST',
              data:'damages='+damages.toString(),
              success:function(results) {}
          });
      }
    <?php
        }
    ?>
      function updateEvents() {
          jQuery.ajax({
              url:'process/updateEvents.php',
              type:'POST',
              data:'events='+JSON.stringify(events),
              success:function(results) {}
          });
      }
    var transColor = 0;
    function getTable() {
        transColor = 0;
          jQuery.ajax({
              url:'process/grabTransactionsTable.php',
              type:'POST',
              success:function(results) {
                  jQuery($('#transTable')).html(results);
                  calculate();
                  $(".editTrans").on("click",function(){
                    if($(this).html()=="Edit"){
                        editTrans($(this).attr("transID"));
                        $(this).html("Save");
                    }else{
                        saveTrans($(this).attr("transID"));
                        calculate();
                        $(this).html("Edit");
                    }
                })
                $(".deleteTrans").on("click",function(){
                    deleteTransaction($(this).attr("transID"),$(this).attr('unqid'));
                });
                $("tr .name").each(function(){
                    $(this).addClass("cal"+(transColor%7+1));
                    transColor += 1;
                });
              }
          });
      }
    <?php 
        if($_SESSION['type'] == "admin"){
    ?>
    function addTransaction(){
        jQuery.ajax({
            url:'process/addTransaction.php',
            type:'POST',
            data: $("#addTrans").serialize(),
            success:function(results) {
                getTable();
                dates[$("#unqid").val()] = [$('#transName').val(), $("#transStart").val(),$("#transEnd").val()];
                fillCalendar();
                jQuery.ajax({
                    url:'process/updateCalendar.php',
                    type:'POST',
                    data: "calendar="+JSON.stringify(dates),
                    success:function(results) {}
                });
                $("#addTrans").slideUp();
                $("#addTrans")[0].reset();
                $(".addTransBtn").html("Add");
                transAdd = false;
            }
        });
    }
    function deleteTransaction(id,unqid){
        jQuery.ajax({
            url:'process/deleteTransaction.php',
            type:'POST',
            data: 'id='+id,
            success:function(results) {
                getTable();
                delete dates[unqid];
                fillCalendar();
                jQuery.ajax({
                    url:'process/updateCalendar.php',
                    type:'POST',
                    data: "calendar="+JSON.stringify(dates),
                    success:function(results) {}
                });
            }
        });
    }
    <?php
        }
    ?>
    function grabComments() {
          jQuery.ajax({
              url:'process/grabComments.php',
              type:'POST',
              success:function(results) {
                jQuery($('#chatLog')).html(results);
              }
          });
      }
    //   $("#calendar").fullCalendar( 'removeEvents' );
    //   $("#calendar").fullCalendar( 'addEventSource', events);
      
    $(function () {
        getTable();
        loadInventory();
        loadDamages();
        grabComments();
        
        // page is now ready, initialize the calendar...
        $('[data-toggle="datepicker"]').datepicker({
            autoClose: true,
        });
        $('#calendar').fullCalendar({
            selectable: true,
            events: events,
            displayEventTime: false,
            eventRender: function(event, element) {
                $(element).tooltip({title: event.tip});             
            },
            select: function(start, end, allDay) {
                
                var s = new Date(start);
                s.setDate(s.getDate()+1);
                var m = s.getMonth()+1;
                var d = s.getDate();
                if(m < 10){
                    m = "0"+m;
                }
                if(d < 10){
                    d = "0"+d;
                }
                $("#addEventStart").val(m+"/"+d+"/"+s.getFullYear());
                $(".eventAdd").hide();
                $("#addEvent").slideDown();
            }
        });
        $('#calendar').fullCalendar('option', 'height', 500);
        fillCalendar();
        $("#transStart").datepicker();
        $("#transEnd").datepicker();
        $(".fc-button").on('click',function(){
            fillCalendar();
        });
        $(".eventAdd").on("click",function(){
            $(".eventAdd").hide();
            $("#addEvent").slideDown();
            
            
        })

        $("#addEventSubmit").on("click",function(){
            var title = $("#addEventTitle").val();
            var tip = $("#addEventTip").val();
            var start = $("#addEventStart").val();
            var end = $("#addEventEnd").val();
            $("#addEvent").slideUp("fast",function(){
                if(title != "" && tip != "" && start != ""){
                    if(end != ""){
                        events.push({"title": title, "tip": tip, "start": new Date(start), "end": new Date(end)});
                    }else{
                        events.push({"title": title, "tip": tip, "start": new Date(start)});
                    }

                }
                $("#calendar").fullCalendar('removeEvents');
                $("#calendar").fullCalendar('addEventSource', events);
                //Add event to php
                updateEvents();
                $("#addEventForm")[0].reset();
                $(".eventAdd").show();
            });
            
        });
        <?php 
            if($_SESSION['type'] == "admin"){
        ?>
        $(".addTransBtn").on('click',function(){
            if(!transAdd){
                $("#addTrans").slideDown();
                $("#unqid").val('_' + Math.random().toString(36).substr(2, 9));
                $(this).html("Close");
                transAdd = true;
            }else{
                $("#addTrans").slideUp();
                $("#addTrans")[0].reset();
                $(this).html("Add");
                transAdd = false;
            }
        })
        $("#transAdd").on("click",function(){
            addTransaction();
        })
        $(".editInvBtn").on("click",function(){
            var lId = $(this).attr("forList");
            if(!invEdit){
                tInventory = JSON.parse(JSON.stringify(inventory));
                $("#"+lId + " li .count").each(function(){
                    $(this).html("<input type='number' class='editCount newFieldCount' value='"+$(this).html()+"'>");
                });
                $("#"+lId + " li .item").each(function(){
                    $(this).html("<input class='editItem' disabled value='"+$(this).html()+"'> <button class='deleteInvItem deleteItem'>&#10006;</button>");
                });
                $(".deleteInvItem").on('click',function(){
                    var invLi = $(this).parent().parent();
                    invLi.slideUp();
                    console.log(invLi.find('.editItem').val());
                    delete tInventory[invLi.find('.editItem').val().trim()];
                });
                $(this).html("Save");
                invEdit = true;
            }else{
                $("#"+lId + " li").each(function(){
                    tInventory[$(this).find('.item').find('input').val().substring(1)] = $(this).find('.count').find('input').val();
                });
                inventory = tInventory;
                loadInventory();
                $(this).html("Edit");
                invEdit = false;
                updateInventory();
            }
        });
        $(".editDamBtn").on("click",function(){
            var lId = $(this).attr("forList");
            if(!damEdit){
                $("#"+lId + " li .item").each(function(){
                    $(this).html("<input class='editItem' value='"+$(this).html()+"'> <button class='deleteDamItem deleteItem'>&#10006;</button>");
                });
                $(".deleteDamItem").on('click',function(){
                    var damLI = $(this).parent().parent();
                    damLI.slideUp('fast',function(){
                        damLI.remove();
                    });
                });
                $(this).html("Save");
                damEdit = true;
            }else{
                var tDamages = [];
                $("#"+lId + " li .item input").each(function(){
                    tDamages.push($(this).val());
                });
                damages = tDamages;
                
                loadDamages();
                $(this).html("Edit");
                damEdit = false;
                updateDamages();
            }
        });
        
       
        $(".invAdd").on('click',function(){

            addToInventory($('.invCount').val(),$('.invDesc').val())
            $(".invCount").val(1);
            $(".invDesc").val("");
            loadInventory();
            updateInventory();
        });
        $(".damAdd").on('click',function(){
            if(!damages.includes($('.damDesc').val())){
                addToDamages($('.damDesc').val());
            }
            $(".damDesc").val("");
            loadDamages();
            updateDamages();
        });
        <?php
            }
        ?>
        $(".addComBtn").on('click',function(){
            if(!comAdd){
                $(".addComment").slideDown();
                $(this).html("Close");
                
                comAdd = true;
            }else{
                $(".addComment").slideUp();
                $(this).html("New");
                $("#commentBox").val("");
                comAdd = false;
            }
            
        })
        $(".sendComment").on('click',function(){
            jQuery.ajax({
              url:'process/addComment.php',
              type:'POST',
              data:'msg='+$("#commentBox").val(),
              success:function(results) {
                grabComments();
                $(".addComment").slideUp();
                $(".addComBtn").html("New");
                $("#commentBox").val("");
                comAdd = false;
              }
          });
        });

        
    });
</script>

</html>