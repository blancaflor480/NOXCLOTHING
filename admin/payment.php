<link rel="stylesheet" href="https://cdn.datatables.net/2.0.5/css/dataTables.bootstrap5.css">


<?php
session_start();
if (!isset($_SESSION['uname'])) {
    header("Location: index.php?error=Login%20First");
    die();
}

include 'dbconn/conn.php';

$uname = $_SESSION['uname'];
$stmt = $conn->prepare("SELECT * FROM admin WHERE uname = ?");
$stmt->bind_param("s", $uname);
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
            <h4><small>Product > </small> Payment Orders</h4>
        </div>
        
        <!-- Table Element -->
        <div class="card border-0">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title">
                    List of Payment
                </h5>
                <div class="d-flex justify-content-end align-items-center">
                   
                </div>
            </div>
            <div class="card-body table-responsive">
                <table id="dataTable" class="table table-hover table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Innovoice</th>
                            <th>Mode Payment</th>
                            <th>Payment Date</th>
                            <th>Amount Paid</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                    <?php
                        $sql = "SELECT payment.id, orders.innovoice, payment.mode_payment, payment.payment_date, payment.amount_paid,  payment.status 
                                FROM payment 
                                JOIN orders
                                ON payment.orders_id = orders.id";
             
                        $result = mysqli_query($conn, $sql);

                        if (mysqli_num_rows($result) > 0) {
                            while($row = mysqli_fetch_assoc($result)) {
                        ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['innovoice']; ?></td>
                            <td><?php echo $row['mode_payment']; ?></td>
                            <td><?php echo $row['payment_date']; ?></td>
                            <td><?php echo $row['amount_paid']; ?></td>
                            <td><?php echo $row['status']; ?></td>
                            
                            <td>
                                  <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteProductModal<?php echo $row['id']; ?>"><i class="fas fa-trash-alt"></i></button>
                            </td>
                        </tr>
                        <?php
                            }
                        } else {
                            echo "<tr><td colspan='5'>No orders found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

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

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<!-- DataTables -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<!-- DataTables -->
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.datatables.net/2.0.5/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.0.5/js/dataTables.bootstrap5.js"></script>
<script>
     $(document).ready(function() {
        $('#dataTable').DataTable();
    });
 </script>   