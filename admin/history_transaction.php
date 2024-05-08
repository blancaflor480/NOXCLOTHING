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
<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<!-- Include DataTables CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">
<!-- Include DataTables JavaScript -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>

<main class="content px-3 py-2">
    <div class="container-fluid">
        <div class="mb-3">
            <h4><small>Billing > </small> History Transaction</h4>
        </div>
        
        <!-- Table Element -->
        <div class="card border-0">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title">
                    Bills Dues Date
                </h5>
                <div class="d-flex justify-content-end align-items-center">
                    <a href="complaint.php" style="font-size: 12px;" class="btn btn-warning btn-sm me-2">Complaint</a>
                    <a href="complaint.php" style="font-size: 12px;" class="btn btn-primary btn-sm me-2">Complaint</a>
                </div>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-hover table-striped table-bordered">
                    <thead>
                        <tr>
                            
                  <th>Bill no.</th>
                  <th>Reading Date</th>
                  <th>Due Date</th>
                  <th>Current Amount</th>
                  <th>Penalties</th>
                  <th>Service Fee</th>
                  <th>Previous</th>
                  <th>Amount</th>
                          <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php 
                 $i = 1;
                $email = $_SESSION['email']; // Get the email of the logged-in user
                $qry = $conn->prepare("SELECT b.*, concat(c.lname, ', ', c.fname, ' ', coalesce(c.mname,'')) as `name` 
                          FROM `tablebilling_list` b 
                          INNER JOIN tableusers c ON b.tableusers_id = c.id 
                          WHERE c.email = ? 
                          ORDER BY unix_timestamp(`reading_date`) DESC, `name` ASC ");
                $qry->bind_param("s", $email);
                $qry->execute();
                $result = $qry->get_result();

             while($row = $result->fetch_assoc()):
?>
                    
                  <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo date("Y-m-d", strtotime($row['reading_date'])); ?></td>
                    <td><?php echo date("Y-m-d", strtotime($row['due_date'])); ?></td>
                    <td><?php echo $row['reading']; ?></td>
                    <td><?php echo $row['penalties']; ?></td>
                    <td><?php echo $row['service']; ?></td>
                    <td><?php echo $row['previous']; ?></td>
                    <td><b><?php echo $row['total']; ?></b></td>
                    <td>
    <?php
        $status = $row['status']; // Assuming 'status' is the column name in your database table for the billing status
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
                    
                   </tr>
                <?php endwhile ?>
              
                    
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

