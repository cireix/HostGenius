<?php
// Include config file
session_start();
require_once 'config.php';
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
  header("location: /login.php");
  exit;
}
// Define variables and initialize with empty values



$client = $_POST['client'];
$total = $_POST['total'];
$cleaning = $_POST['cleaning'];
$earnings = $_POST['earnings'];
$commission = $_POST['commission'];
$start = $_POST['start'];
$end = $_POST['end'];
$lID = $_SESSION['listingID'];
$unqid = $_POST['unqid'];

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
	
	// Check input errors before inserting in database
		
		// Prepare an insert statement
		$sql = "INSERT INTO transactions (name,total,cleaning,earnings,commission,checkin,checkout,status,listingID,unqid) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		 
		if($stmt = mysqli_prepare($link, $sql)){
			// Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssssssss", $param_client, $param_total, $param_cleaning, $param_earnings,
                                                    $param_commission, $param_checkin, $param_checkout, $param_status, $param_listingID, $param_unqid);
			
			// Set parameters
            $param_client = $client;
            $param_total = $total;
            $param_cleaning = $cleaning;
            $param_earnings = $earnings;
            $param_commission = $commission;
            $param_checkin = $start;
            $param_checkout = $end;
            $param_status = "Upcoming";
            $param_listingID = $lID;
			$param_unqid = $unqid;
			
			// Attempt to execute the prepared statement
			if(mysqli_stmt_execute($stmt)){
				// Redirect to login page
				header("location: /index.php");
				

			} else{
				echo "Something went wrong. Please try again later.";
			}
		}
		 
		// Close statement
		mysqli_stmt_close($stmt);
	
	
	// Close connection
	mysqli_close($link);
}
?>