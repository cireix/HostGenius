<?php
require_once 'config.php';
session_start();
// Define variables and initialize with empty values
$username = $password = "";
$error = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
	
//,--.                 ,--.              ,---.            ,--.  ,--.                      ,--.  ,--.                ,--.  ,--.                
//|  |    ,---.  ,---. `--',--,--,      /  O  \ ,--.,--.,-'  '-.|  ,---.  ,---. ,--,--, ,-'  '-.`--' ,---. ,--,--.,-'  '-.`--' ,---. ,--,--,  
//|  |   | .-. || .-. |,--.|      \    |  .-.  ||  ||  |'-.  .-'|  .-.  || .-. :|      \'-.  .-',--.| .--'' ,-.  |'-.  .-',--.| .-. ||      \ 
//|  '--.' '-' '' '-' '|  ||  ||  |    |  | |  |'  ''  '  |  |  |  | |  |\   --.|  ||  |  |  |  |  |\ `--.\ '-'  |  |  |  |  |' '-' '|  ||  | 
//`-----' `---' .`-  / `--'`--''--'    `--' `--' `----'   `--'  `--' `--' `----'`--''--'  `--'  `--' `---' `--`--'  `--'  `--' `---' `--''--' 
//							`---'                                                                                                                         
	// Check if username is empty
	if(empty($_POST["username"])){
		$_SESSION['loginError'] = 'Invalid Credentials';
		header("location: /login.php");
	} else{
		$username = $_POST["username"];
	}
	
	// Check if password is empty
	if(empty($_POST['password'])){
		$_SESSION['loginError'] = 'Invalid Credentials';
		header("location: /login.php");
	} else{
		$password = $_POST['password'];
	}
	// Validate credentials
	if(empty($username_err) && empty($password_err)){
		// Prepare a select statement
		
		$sql = "SELECT username, password, type, listingID, name, id FROM users WHERE username = ?";
		
		if($stmt = mysqli_prepare($link, $sql)){
			// Bind variables to the prepared statement as parameters
			mysqli_stmt_bind_param($stmt, "s", $param_username);
			
			// Set parameters
			$param_username = $username;
			
			// Attempt to execute the prepared statement
			if(mysqli_stmt_execute($stmt)){
				// Store result
				mysqli_stmt_store_result($stmt);
				
				// Check if username exists, if yes then verify password
				if(mysqli_stmt_num_rows($stmt) == 1){                    
					// Bind result variables
					mysqli_stmt_bind_result($stmt, $username, $hashed_password, $type, $listingID, $name, $id);
					if(mysqli_stmt_fetch($stmt)){
						if($password==$hashed_password){
							/* Password is correct, so start a new session and
							save the username to the session */
							// session_start();
							$_SESSION['username'] = $username;
							$_SESSION['type'] = $type;
							$_SESSION['name'] = $name;
							$_SESSION['userID'] = $id;
							if($type != "admin"){
								$_SESSION['userListing'] = $listingID;
								header("location: /property.php?id=".$_SESSION['userListing']);
							}else{
								header("location: /index.php");
							}
						} else{
							// Display an error message if password is not valid
							$_SESSION['loginError'] = 'Invalid Credentials';
							header("location: /login.php");
						}
					}
				} else{
					// Display an error message if username doesn't exist
					$_SESSION['loginError'] = 'Invalid Credentials';
					header("location: /login.php");
				}
			} else{
				echo "Oops! Something went wrong. Please try again later.";
			}
		}
		
		// Close statement
		mysqli_stmt_close($stmt);
	}
	
	// Close connection
	mysqli_close($link);
	

}	
?>
