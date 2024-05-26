
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
    <script>
document.getElementById('editImage<?php echo $row['id']; ?>').addEventListener('change', function() {
    var input = this;
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('currentImagePath<?php echo $row['id']; ?>').value = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
    }
});
</script>

    <?php include('sidebar.php'); ?>
    <main class="content px-3 py-2">
        <div class="container-fluid">
            <div class="mb-3">
                <h4><small>Product > </small>Voucher </h4>
            </div>
            <!-- Table Element -->
            <div class="card border-0">
            <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title">
                        List of Voucher 
                    </h5>
                    <div class="d-flex justify-content-end align-items-center">
                    <button type="button" class="btn btn-success btn-sm me-2" data-bs-toggle="modal" data-bs-target="#addVoucherModal">Add</button>
                </div>
                </div>
                
                <div class="card-body table-responsive">
                <table id="dataTable" class="table table-hover table-striped table-bordered">
                
                <thead>
                            <tr>
                            <th>#</th>
                            <th>Voucher Code</th>
                            <th>Discount</th>
                            <th>Expiry</th>
                            <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
        <?php
        $sql = "SELECT * FROM voucher";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
        ?>
        <tr>
        <td><?php echo $row['id']; ?></td>
                                    <td><?php echo $row['vouchercode']; ?></td>
                                    <td><?php echo $row['discount']; ?></td>
                                    <td><?php echo $row['expirydate']; ?></td>    
        <td>
               
        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editVoucherModal<?php echo $row['id']; ?>"><i class="fas fa-edit"></i></button>
                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteVoucherModal<?php echo $row['id']; ?>"><i class="fas fa-trash-alt"></i></button>
        </td>
        </tr>

  <!-- Edit Voucher Modal -->
  <div class="modal fade" id="editVoucherModal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="editVoucherModalLabel<?php echo $row['id']; ?>" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editVoucherModalLabel<?php echo $row['id']; ?>">Edit Voucher</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="edit_voucher.php" method="POST">
                                                    <div class="mb-3">
                                                        <label for="editVoucherCode<?php echo $row['id']; ?>" class="form-label">Voucher Code</label>
                                                        <input type="text" class="form-control" id="editVoucherCode<?php echo $row['id']; ?>" name="editVoucherCode" value="<?php echo $row['vouchercode']; ?>" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="editDiscount<?php echo $row['id']; ?>" class="form-label">Discount</label>
                                                        <input type="text" class="form-control" id="editDiscount<?php echo $row['id']; ?>" name="editDiscount" value="<?php echo $row['discount']; ?>" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="editExpiry<?php echo $row['id']; ?>" class="form-label">Expiry Date</label>
                                                        <input type="date" class="form-control" id="editExpiry<?php echo $row['id']; ?>" name="editExpiry" value="<?php echo $expiry; ?>" required>
                                                    </div>
                                                    <input type="hidden" name="voucherID" value="<?php echo $row['id']; ?>">
                                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Delete Voucher Modal -->
                                <div class="modal fade" id="deleteVoucherModal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="deleteVoucherModalLabel<?php echo $row['id']; ?>" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteVoucherModalLabel<?php echo $row['id']; ?>">Delete Voucher</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Are you sure you want to delete this voucher?</p>
                                                <form action="delete_voucher.php" method="POST">
                                                    <input type="hidden" name="voucherID" value="<?php echo $row['id']; ?>">
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>                           
        <?php
            }
        } else {
            echo "<tr><td colspan='5'>No vouchers found</td></tr>";
        }
        ?>
    </tbody>

                    </table>
                </div>
            </div>
        </div>
    </main>
<!-- Add Voucher Modal -->
<div class="modal fade" id="addVoucherModal" tabindex="-1" aria-labelledby="addVoucherModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addVoucherModalLabel">Add Voucher</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="add_voucher.php" method="POST">
                    <div class="mb-3">
                        <label for="voucherCode" class="form-label">Voucher Code</label>
                        <input type="text" class="form-control" id="voucherCode" name="voucherCode" required>
                    </div>
                    <div class="mb-3">
                        <label for="discount" class="form-label">Discount</label>
                        <input type="number" class="form-control" id="discount" name="discount" required>
                    </div>
                    <div class="mb-3">
                        <label for="expiry" class="form-label">Expiry Date</label>
                        <input type="date" class="form-control" id="expiry" name="expiry" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Voucher</button>
                </form>
            </div>
        </div>
    </div>
</div>
   

   <script>
    <?php if (isset($_SESSION['success_message'])): ?>
    var successMessage = "<?php echo $_SESSION['success_message']; ?>";
    alert(successMessage);
    <?php unset($_SESSION['success_message']); ?>
<?php elseif (isset($_SESSION['error_message'])): ?>
    var errorMessage = "<?php echo $_SESSION['error_message']; ?>";
    alert(errorMessage);
    <?php unset($_SESSION['error_message']); ?>
<?php endif; ?>
</script>
    <!-- Bootstrap Bundle with Popper -->
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
