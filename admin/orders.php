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
            <h4><small>Product > </small> Transactions Orders</h4>
        </div>
        
        <!-- Table Element -->
        <div class="card border-0">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title">
                    List of Transactions
                </h5>
                <div class="d-flex justify-content-end align-items-center">
                    <a href="complaint.php" style="font-size: 17px;" class="btn btn-warning btn-sm me-2">Complaint</a>
                    <a href="history_transaction.php" style="font-size: 17px;" class="btn btn-primary btn-sm me-2">History</a>
                </div>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-hover table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Customer Name</th>
                            <th>Innovoice</th>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Size</th>
                            <th>Order Date</th>
                            <th>Total Amount</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                    <?php
                        $sql = "SELECT orders.id, customer.fname AS customer_name, orders.total_amount, orders.order_date 
                                FROM orders 
                                JOIN customer 
                                ON orders.customer_id = customer.id";
             
                        $result = mysqli_query($conn, $sql);

                        if (mysqli_num_rows($result) > 0) {
                            while($row = mysqli_fetch_assoc($result)) {
                        ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo isset($row['customer_name']) ? $row['customer_name'] : 'N/A'; ?></td>
                            <td><?php echo $row['innovoice']; ?></td>
                            <td><?php echo $row['products_id']; ?></td>
                            <td><?php echo $row['quantity']; ?></td>
                            <td><?php echo $row['size']; ?></td>
                            <td><?php echo $row['order_date']; ?></td>
                            <td><?php echo $row['total_amount']; ?></td>
                            <td><?php echo $row['status']; ?></td>
                            
                            <td>
                                <!-- Ang mga action buttons ay maaaring idagdag dito -->
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
