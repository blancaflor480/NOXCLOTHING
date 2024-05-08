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
            <h4>Complaint</h4>
        </div>
        
        <!-- Table Element -->
        <div class="card border-0">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title">
                    List of complaint's homeowner's
                </h5>
                <div class="d-flex justify-content-end align-items-center">
                    <a href="history_transaction.php" style="font-size: 12px;" class="btn btn-primary btn-sm me-2">New Complaint</a>
                </div>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-hover table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Complaint #</th>
                            <th>Date Time</th>
                            <th>Type</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                                    <?php
            $qry = $conn->prepare("SELECT Id, tableusers_id, email, typecomplaint, description, stats, date_time FROM `tablecomplaint` WHERE `tableusers_id` = ?");
$qry->bind_param("i", $result['Id']);
$qry->execute();
$qry->bind_result($complaintId, $tableusers_id, $email, $typecomplaint, $description, $stats, $date_time);

while ($qry->fetch()) {
?>
    <tr>
        <td><?= $complaintId; ?></td>
        <td><?= $date_time; ?></td>
        <td><?= $typecomplaint; ?></td>
        <td>
        <?php
            switch ($stats) {
                 case 0:
                echo '<span class="badge text-bg-danger text-lg px-3">UNPROCESS</span>';
                break;
            case 1:
                echo '<span class="badge text-bg-success text-lg px-3">PROCESS</span>';
                break;
            case 2:
                echo '<span class="badge text-bg-warning text-lg px-3">PENDING</span>';
                break;
            default:
                echo '<span class="badge text-bg-secondary text-lg px-3">UNKNOWN</span>';
            }
            ?>

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

