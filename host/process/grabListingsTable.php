<?php
    require_once 'config.php';
    session_start();
    if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
        header("location: /login.php");
        exit;
    }
?>
<table class="table table-hover table-striped">
    <thead>
        <th>ID</th>
        <th>Address</th>
        <th>Total Earnings</th>
        <th>Commission</th>
        <th>Detail</th>
    </thead>
    <tbody>
    <?php
    //Prepare the query
    $qry = "SELECT id, address, hg, total FROM listings";
    if ($stmt = mysqli_prepare($link, $qry)) {
        mysqli_stmt_execute($stmt);
        /* bind variables to prepared statement */
        mysqli_stmt_bind_result($stmt, $id, $address, $hg, $total);
        /* fetch values */
        while (mysqli_stmt_fetch($stmt)) {
            ?>
           
           <tr>
                <td><?=$id?></td>
                <td><?=$address?></td>
                <td style="color: green">$<?=$total?></td>
                <td style="color: green">$<?=$hg?></td>
                <td>
                    <a class="btn btn-warning" href="/property.php?id=<?=$id?>">View</a>
                </td>
            </tr>


            <?php
            
            // $registarCol
        }

        /* close statement */
        mysqli_stmt_close($stmt);
    }
    ?>
    </tbody>
</table>



