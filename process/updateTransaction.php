<?php
// Include config file
session_start();
require_once 'config.php';
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
  header("location: /login.php");
  exit;
}
// Define variables and initialize with empty values
$id = $_POST['id'];
$name = $_POST['name'];
$total = $_POST['total'];
$cleaning = $_POST['cleaning'];
$earnings = $_POST['earnings'];
$commission = $_POST['commission'];
$status = $_POST['status'];

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
	
	// Check input errors before inserting in database

		// Prepare an insert statement
			$sql = "UPDATE transactions SET name = ?, total = ?, cleaning = ?, earnings = ?, commission = ?, status = ? WHERE id = ?";

		if($stmt = mysqli_prepare($link, $sql)){
			// Bind variables to the prepared statement as parameters

				mysqli_stmt_bind_param($stmt, "sssssss", $param_name, $param_total, $param_cleaning, $param_earnings, $param_commission, $param_status, $param_id);

                $param_name = $name;
                $param_total = $total;
                $param_cleaning = $cleaning;
                $param_earnings = $earnings;
                $param_commission = $commission;
                $param_status = $status;
                $param_id = $id;
			
			// Set parameters

			
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