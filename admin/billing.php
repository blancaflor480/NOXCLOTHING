<?php
    session_start();
    if (!isset($_SESSION['email'])) {
        header("Location: index.php?error=Login%20First");
        die();
    }

    include 'config.php';

    $email = $_SESSION['email'];
    $conn_String = mysqli_connect("localhost", "root", "", "billing");
    $stmt = $conn_String->prepare("SELECT * FROM tableusers WHERE email = '{$_SESSION['email']}'");
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    
    if (!$result) {
        header("Location: index.php?error=Login%20First");
        exit();
    }

?>


<?php include('sidebar.php'); ?>
<main class="content px-3 py-2">
    <div class="container-fluid">
        <div class="mb-3">
            <h4><small>Billing > </small> Billing Dues</h4>
        </div>
        
        <!-- Table Element -->
        <div class="card border-0">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title">
                    Bills Dues Date
                </h5>
                <div class="d-flex justify-content-end align-items-center">
                    <a href="complaint.php" style="font-size: 12px;" class="btn btn-warning btn-sm me-2">Complaint</a>
                    <a href="history_transaction.php" style="font-size: 12px;" class="btn btn-primary btn-sm me-2">History</a>
                </div>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-hover table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Bill no.</th>
                            <th>Reading Date</th>
                            <th>Due Date</th>
                            <th>Homeowner</th>
                            <th>Status</th>
                            <th>Total Amount</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $qry = $conn->prepare("SELECT b.id, b.reading_date, b.due_date, concat(c.lname, ', ', c.fname, ' ', coalesce(c.mname,'')) as `name`, b.status, b.total
                      FROM `tablebilling_list` b 
                      INNER JOIN tableusers c ON b.tableusers_id = c.id 
                      WHERE c.email = ? AND b.status = 0 OR b.status = 2 
                      ORDER BY unix_timestamp(`reading_date`) DESC, `name` ASC ");
                     $qry->bind_param("s", $email);
                     $qry->execute();
                     $qry->bind_result($id, $reading_date, $due_date, $name, $status, $total);


                       while ($qry->fetch()) {
    ?>
    <tr>
        <td><?= $id; ?></td>
        <td><?= date("Y-m-d", strtotime($reading_date)); ?></td>
        <td><?= date("Y-m-d", strtotime($due_date)); ?></td>
        <td><?= $name; ?></td>
        <td>
            <?php
            switch ($status) {
                 case 0:
                echo '<span class="badge text-bg-danger text-lg px-3">UNPAID</span>';
                break;
            case 1:
                echo '<span class="badge text-bg-success text-lg px-3">PAID</span>';
                break;
            case 2:
                echo '<span class="badge text-bg-warning text-lg px-3">PENDING</span>';
                break;
            default:
                echo '<span class="badge text-bg-secondary text-lg px-3">UNKNOWN</span>';
            }
            ?>
        </td>
        <td><b><?= $total; ?></b></td>
        <td>
            <?php if ($status != 2): ?>
                <button type="button" value="<?= $id; ?>" class="payBtn btn btn-success btn-sm" 
                    data-toggle="modal" data-target="#paymentModal" 
                    data-total="<?= $total; ?>"
                    data-paymode="<?= $paymode; ?>" 
                    onclick="selectPaymentOption('online', <?= $id; ?>, <?= $total; ?>)">
                    <i class="bi bi-credit-card"></i> Pay
                </button>
            <?php endif; ?>
        </td>
    </tr>
<?php
}
?>
                    
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>


            <!--<a href="#" class="theme-toggle">
                <i class="fa-regular fa-moon"></i>
                <i class="fa-regular fa-sun"></i>
            </a>-->
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row text-muted">
                        <div class="col-6 text-start">
                            <p class="mb-0">
                                <a href="#" class="text-muted">
                                    <strong>RRBMS</strong>
                                </a>
                            </p>
                        </div>
                        
                    </div>
                </div>
            </footer>
        </div>
    </div>

