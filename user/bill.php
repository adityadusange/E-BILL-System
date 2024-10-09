<?php 
    require_once('head_html.php'); 
    require_once('../Includes/config.php'); 
    require_once('../Includes/session.php'); 
    require_once('../Includes/user.php'); 
    if ($logged == false) {
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
                        <h1 class="page-header">Bills</h1>

                        <ul class="nav nav-pills nav-justified">
                            <li class="active"><a href="#history" data-toggle="pill">History</a></li>
                            <li><a href="#due" data-toggle="pill">Due</a></li>
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane fade in active" id="history">
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped table-bordered table-condensed">
                                        <thead>
                                            <tr>
                                                <th>Bill No.</th>
                                                <th>Bill Date</th>
                                                <th>UNITS Consumed</th>
                                                <th>Amount</th>
                                                <th>Due Date</th>
                                                <th>STATUS</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $id = $_SESSION['uid'];
                                            $query1 = "SELECT COUNT(*) FROM bill WHERE uid={$id}";
                                            $result1 = mysqli_query($con, $query1);
                                            $row1 = mysqli_fetch_row($result1);
                                            $numrows = $row1[0];
                                            include("paging1.php");

                                            $result = retrieve_bills_history($_SESSION['uid'], $offset, $rowsperpage);
                                            while ($row = mysqli_fetch_assoc($result)) {
                                            ?>
                                                <tr>
                                                    <td height="50"><?php echo 'EBS_' . $row['id'] ?></td>
                                                    <td height="50"><?php echo $row['bdate'] ?></td>
                                                    <td><?php echo $row['units'] ?></td>
                                                    <td><?php echo $row['amount'] . ' Rs' ?></td>
                                                    <td><?php echo $row['ddate'] ?></td>
                                                    <td><?php echo $row['status'] ?></td>
                                                </tr>
                                            <?php  } ?>
                                        </tbody>
                                    </table>     
                                    <?php include("paging2.php"); ?>                     
                                </div>
                            </div>
                            <div class="tab-pane fade" id="due">
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped table-bordered table-condensed">
                                        <thead>
                                            <tr>
                                                <th>Bill Date</th>
                                                <th>UNITS Consumed</th>
                                                <th>Due Date</th>
                                                <th>Amount</th>
                                                <th>DUES</th>
                                                <th>Payable</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $id = $_SESSION['uid'];
                                            $query1 = "SELECT COUNT(*) FROM bill WHERE uid={$id} AND status='PENDING'";
                                            $result1 = mysqli_query($con, $query1);
                                            $row1 = mysqli_fetch_row($result1);
                                            $numrows = $row1[0];
                                            include("paging1.php");

                                            $result = retrieve_bills_due($_SESSION['uid'], $offset, $rowsperpage);
                                            $counter = 1;
                                            while ($row = mysqli_fetch_assoc($result)) {
                                            ?>
                                                <tr>
                                                    <form action="transact_bill.php" method="post">
                                                    <input type="hidden" name="bdate" value=<?php echo $row['bdate'] ?> >
                                                    <td height="50"><?php echo $row['bdate'] ?></td>

                                                    <input type="hidden" name="units" value=<?php echo $row['units'] ?> >
                                                    <td><?php echo $row['units'] ?></td>

                                                    <input type="hidden" name="ddate" value=<?php echo $row['ddate'] ?> >
                                                    <td><?php echo $row['ddate'] ?></td>

                                                    <input type="hidden" name="amount" value=<?php echo $row['amount'] ?> >
                                                    <td><?php echo '$' . $row['amount'] ?></td>

                                                    <td><?php echo '$' . $row['dues'] ?></td>

                                                    <input type="hidden" name="payable" value=<?php echo $row['payable'] ?> >
                                                    <td><?php echo '$' . $row['payable'] ?></td>

                                                    <td>
                                                    <button class="btn btn-success form-control" data-toggle="modal" data-target="#PAY">PAY</button>
                                                    <div class="modal fade" id="PAY" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-sm">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                                    <h3 class="modal-title text-center"><b>Bills Transaction</b></h3>
                                                                </div>
                                                                <div class="modal-body text-center">
                                                                    <h4>ARE YOU SURE?</h4>
                                                                    <p>Do it before <?php echo $row['ddate']; ?> or DUES will be served!!</p>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-danger" data-dismiss="modal">LATER</button>
                                                                    <button type="submit" id="pay_bill" name="pay_bill" class="btn btn-success">PAY</button>
                                                    </form> 
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                </tr>
                                            <?php 
                                                $counter = $counter + 1;
                                            }
                                            ?>
                                        </tbody>

                                    </table>

                                <?php include("paging2.php"); ?>

                                </div>

                            </div> 
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
