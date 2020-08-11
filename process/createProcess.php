<?php
// Include config file
session_start();
require_once 'config.php';
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
  header("location: /login.php");
  exit;
}
// Define variables and initialize with empty values



$address = $_POST["address"];
$cFee = $_POST['cFee'];
$cPercent = $_POST['cPercent'];

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
	
	// Check input errors before inserting in database
		
		// Prepare an insert statement
		$sql = "INSERT INTO listings (address, hg, total, managerID, cFee, cPercent) VALUES (?, ?, ?, ?, ?, ?)";
		 
		if($stmt = mysqli_prepare($link, $sql)){
			// Bind variables to the prepared statement as parameters
			mysqli_stmt_bind_param($stmt, "ssssss", $param_address, $param_hg, $param_total, $param_managerID, $param_cFee, $param_cPercent);
			
			// Set parameters
            $param_address = $address;
            $param_hg = 0;
            $param_total = 0;
			$param_managerID = 1;
			$param_cFee = $cFee;
			$param_cPercent = $cPercent;
			
			// Attempt to execute the prepared statement
			if(mysqli_stmt_execute($stmt)){
				// Redirect to login page
				header("location: /index.php");
				

			} else{
				echo "Something went wrong. Please try again later.";
				// echo $cFee;
				// echo $cPercent;
			}
		}
		 
		// Close statement
		mysqli_stmt_close($stmt);
	
	
	// Close connection
	mysqli_close($link);
}
?>