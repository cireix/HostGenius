<?php
// Include config file
session_start();
require_once 'config.php';
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
  header("location: /login.php");
  exit;
}
// Define variables and initialize with empty values
$id = $_SESSION['listingID'];
$hg = $_POST['hg'];
$total = $_POST['total'];



// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
	
	// Check input errors before inserting in database

		// Prepare an insert statement
			$sql = "UPDATE listings SET hg = ?, total = ? WHERE id = ?";

		if($stmt = mysqli_prepare($link, $sql)){
			// Bind variables to the prepared statement as parameters

				mysqli_stmt_bind_param($stmt, "sss", $param_hg, $param_total, $param_id);
			
			
			// Set parameters
			$param_id = $id;
            $param_total = $total;
            $param_hg = $hg;
			
			// Attempt to execute the prepared statement
			if(mysqli_stmt_execute($stmt)){
				// Redirect to login page
                echo 123;
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