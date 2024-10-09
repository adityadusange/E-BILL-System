<?php 
    require_once('head_html.php'); 
    require_once('../Includes/config.php'); 
    require_once('../Includes/session.php'); 
    require_once('../Includes/user.php'); 
    if ($logged==false) {
         header("Location:../index.php");
    }
?>


<body>

    <div id="wrapper">

       <?php 
            require_once("nav.php");
            require_once("sidebar.php");
        ?>

        
        <div id="page-content-wrapper">

            <div class="container-fluid">

              
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Transaction
                        </h1>
                        <ol class="breadcrumb">
                          <li>Transaction</li>
                          <li class="active">History</li>
                        </ol>
                        
                        <div class="table-responsive">
                            <table class="table table-hover table-striped table-bordered table-condensed">
                                <thead>
                                    <tr>
                                        <th>Transaction No.</th>
                                        <th>Bill Date</th>
                                        <th>Amount</th>
                                        <th>Dues (if any)</th>
                                        <th>Final Amount Payed</th>
                                        <th>Transaction Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $id=$_SESSION['uid'];
                                    $query1 = "SELECT COUNT(*) FROM bill , transaction WHERE transaction.bid=bill.id AND bill.uid={$id}  ";
                                    $result1 = mysqli_query($con,$query1);
                                    $row1 = mysqli_fetch_row($result1);
                                    $numrows = $row1[0];
                                    include("paging1.php");
                                    
                                    $result = retrieve_transaction_history($_SESSION['uid'],$offset, $rowsperpage);
                                    while($row = mysqli_fetch_assoc($result)){
                                    ?>
                                        <tr>
                                            <td>
                                                <?php 
                                                    if($row['pdate']!=NULL) echo 'TRN_'.$row['id'] ;
                                                    else echo "-";
                                                 ?>
                                            </td>
                                            <!-- <?php echo $row['id'] ?></td> -->
                                            <td height="50"><?php echo $row['bdate'] ?></td>
                                            <td><?php echo $row['amount'].' Rs' ?></td>
                                            <td><?php echo $row['dues'].' Rs' ?></td>
                                            <td><?php echo $row['payable'].' Rs' ?></td>
                                            <td>
                                                <?php 
                                                    if($row['pdate']!=NULL) echo $row['pdate'];
                                                    else echo "TRANSACTION PENDING";
                                                ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <?php include("paging2.php");  ?>
                        </div>
                       
                    </div>
                                     
                </div>
             
            </div>
            

        </div>
        
        
        


    </div>
  

    <?php 
    require_once("footer.php");
    require_once("js.php");
    ?>
    
</body>

</html>
