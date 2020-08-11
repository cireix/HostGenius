<?php
// Include config file
session_start();
require_once 'config.php';
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
  header("location: /login.php");
  exit;
}
// Define variables and initialize with empty values

$msg = $_POST['msg'];


// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
	
	// Check input errors before inserting in database
    
		// Prepare an insert statement
		$sql = "INSERT INTO comments (name, listingID, message, userID) VALUES (?, ?, ?, ?)";
		 
		if($stmt = mysqli_prepare($link, $sql)){
			// Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssss", $param_name, $param_listingID, $param_message, $param_userID);
			
			// Set parameters
            $param_name = $_SESSION['name'];
            $param_listingID = $_SESSION['listingID'];
            $param_message = $msg;
            $param_userID = $_SESSION['userID'];

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