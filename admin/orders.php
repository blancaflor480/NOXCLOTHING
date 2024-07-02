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
            <h4><small>Product > </small> Orders</h4>
        </div>
        
        <!-- Table Element -->
        <div class="card border-0">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title">
                    List of Orders
                </h5>
                <div class="d-flex justify-content-end align-items-center">
                    <!-- Additional buttons if needed -->
                </div>
            </div>
            <div class="card-body table-responsive">
                <table id="dataTable" class="table table-hover table-striped table-bordered">
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
                        $sql = "SELECT orders.id, customer.fname AS customer_name, products.name_item AS productname, orders.innovoice, addcart.quantity, orders.total_amount, orders.order_date, orders.status, addcart.size
                                FROM orders 
                                INNER JOIN products ON orders.products_id = products.id
                                INNER JOIN addcart ON orders.addcart_id = addcart.id
                                INNER JOIN customer ON addcart.customer_id = customer.id";

                        $result = mysqli_query($conn, $sql);

                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                <tr>
                                    <td><?php echo $row['id']; ?></td>
                                    <td><?php echo isset($row['customer_name']) ? $row['customer_name'] : 'N/A'; ?></td>
                                    <td><?php echo $row['innovoice']; ?></td>
                                    <td><?php echo $row['productname']; ?></td>
                                    <td><?php echo $row['quantity']; ?></td>
                                    <td><?php echo $row['size']; ?></td>
                                    <td><?php echo $row['order_date']; ?></td>
                                    <td><?php echo $row['total_amount']; ?></td>
                                    <td><?php echo $row['status']; ?></td>
                                    <td>
                                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editProductModal<?php echo $row['id']; ?>"><i class="fas fa-edit"></i></button>
                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteProductModal<?php echo $row['id']; ?>"><i class="fas fa-trash-alt"></i></button>
                                    </td>
                                </tr>
                            <?php
                            }
                        } else {
                            echo "<tr><td colspan='10'>No orders found</td></tr>";
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

<!-- Bootstrap Bundle JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/2.0.5/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.0.5/js/dataTables.bootstrap5.js"></script>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable();
    });
</script>
