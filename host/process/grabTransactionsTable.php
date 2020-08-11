<?php
    require_once 'config.php';
    session_start();
    if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
        header("location: /hostgenius/login.php");
        exit;
    }
?>
<thead>
    <th>ID</th>
    <th>Occupant Name</th>
    <th>Dates</th>
    <th>Total Amount</th>
    <th>Cleaning Fee</th>
    <th>Earnings</th>
    <th>Commission</th>
    <th>Status</th>
    <?php
        if($_SESSION['type'] == "admin"){
            echo '<th>Edit</th>';
        }
    ?>
</thead>
<tbody>
                                        
<?php
    //Prepare the query
    $qry = "SELECT id, name, total, cleaning, earnings, commission, checkin, checkout, status, unqid FROM transactions WHERE listingID = ?";
    if ($stmt = mysqli_prepare($link, $qry)) {
        mysqli_stmt_bind_param($stmt, "s", $param_id);
        $param_id = $_SESSION['listingID']; 
        mysqli_stmt_execute($stmt);
        
        /* bind variables to prepared statement */
        mysqli_stmt_bind_result($stmt, $id, $name, $total, $cleaning, $earnings, $commission, $checkin, $checkout, $status, $unqid);
        /* fetch values */
        while (mysqli_stmt_fetch($stmt)) {
            ?>
           
           <tr transID="<?=$id?>">
                <td><?=$id?></td>
                <td class="name"><?=$name?></td>
                <td>
                    <p class="dates">In: <?=$checkin?></p>

                    <p class="dates">Out: <?=$checkout?></p>
                </td>
                <td>$<span class="total"><?=$total?></span>
                </td>
                
                <td style="color: goldenrod">- $<span class="cleaning"><?=$cleaning?></span>
                </td>
                <td style="color: green">$<span class="earnings"><?=$earnings?></span>
                </td>
                <td style="color: <?php
                        if($_SESSION['type']=="admin"){
                            echo "green";
                        }else{
                            echo "goldenrod";
                        }
                    ?>">
                    <?php
                        if($_SESSION['type']!="admin"){
                            echo "-";
                        }
                    ?> $<span class="hg"><?=$commission?></span>
                </td>
                <td>
                    <span class="status <?=$status?>"><?=$status?></span>
                </td>
                <?php
                    if($_SESSION['type'] == "admin"){
                        ?>
                        <td style="width:100px;">
                            <button type="button" class="btn btn-primary editTrans" transID="<?=$id?>">Edit</button>
                            <button type="button" class="btn btn-primary deleteTrans" transID="<?=$id?>" transName="<?=$name?>" unqid=<?=$unqid?>>&#10006;</button>
                        </td>
                        <?php
                    }
                ?>
                
            </tr>


            <?php
            
            // $registarCol
        }
        ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan=5></td>
                <td style="color: green">$<span id="calcEarnings"></span>
                </td>
                <td style="color: <?php
                    if($_SESSION['type']=="admin"){
                        echo "green";
                    }else{
                        echo "goldenrod";
                    }
                ?>">
                <?php
                    if($_SESSION['type']=="admin"){
                    
                    
                ?> $<span id="calcHG"></span>
                <?php } ?>
                </td>
                <td></td>
            </tr>
        </tfoot>
        <?php

        /* close statement */
        mysqli_stmt_close($stmt);
    }
    ?>
    
