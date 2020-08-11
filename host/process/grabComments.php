<?php
    require_once 'config.php';
    session_start();
    if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
        header("location: /hostgenius/login.php");
        exit;
    }
?>

                                        
<?php
    //Prepare the query
    $qry = "SELECT name, message, timestamp, userID FROM comments WHERE listingID = ? ORDER BY timestamp DESC ";
    if ($stmt = mysqli_prepare($link, $qry)) {
        mysqli_stmt_bind_param($stmt, "s", $param_id);
        $param_id = $_SESSION['listingID']; 
        mysqli_stmt_execute($stmt);
        
        /* bind variables to prepared statement */
        mysqli_stmt_bind_result($stmt, $name, $message, $timestamp, $userID);
        /* fetch values */
        while (mysqli_stmt_fetch($stmt)) {
            ?>
           
           <div class="post" user="<?=$userID?>">
                <h5><?=$name?> (<?=$timestamp?>)</h5>
                <hr>
                <div class="message">
                    <?=$message?>
                </div>
            </div>


            <?php
            
            // $registarCol
        }

        /* close statement */
        mysqli_stmt_close($stmt);
    }
    ?>
    
