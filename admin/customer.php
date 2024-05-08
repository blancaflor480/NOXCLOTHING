
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
                <h4><small>Dashboard > </small> Customer Information</h4>
            </div>
            <!-- Table Element -->
            <div class="card border-0">
            <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title">
                        Customer List
                    </h5>
                    <div class="d-flex justify-content-end align-items-center">
                        <button type="button" class="btn btn-success btn-sm me-2" data-bs-toggle="modal" data-bs-target="#addProductModal">Add</button>
                        <a href="history_transaction.php" style="font-size: 17px;" class="btn btn-primary btn-sm me-2">History</a>
                    </div>
                
                </div>
                
                <div class="card-body table-responsive">
                <table id="dataTable" class="table table-hover table-striped table-bordered">
                <thead>
                            <tr>
                                <th>Account No.</th>
                                <th>Name</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Birthday</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                        <?php
                            $sql = "SELECT * FROM customer";
                            $meta = mysqli_query($conn, $sql);

                            if (mysqli_num_rows($meta) > 0) {
                                while($result = mysqli_fetch_assoc($meta)) {
                          ?>
       <tr>
                            <td><?php echo $result['id']; ?></td>
                            <td><?php echo $result['fname']; ?></td>
                            <td><?php echo $result['uname']; ?></td>
                            <td><?php echo $result['email']; ?></td>
                            <td><?php echo $result['bday']; ?></td>
                            <td>
                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editProductModal<?php echo $result['id']; ?>"><i class="fas fa-edit"></i></button>
                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteProductModal<?php echo $result['id']; ?>"><i class="fas fa-trash-alt"></i></button>
                            </td>
                        </tr>

        <!-- Edit Product Modal -->
        <div class="modal fade" id="editProductModal<?php echo $result['id']; ?>" tabindex="-1" aria-labelledby="editProductModalLabel<?php echo $result['id']; ?>" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editProductModalLabel<?php echo $result['id']; ?>">Edit Admin Profile</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Edit Product Form -->
                        <form action="backend_account/edit_account.php" method="POST">
                            <!-- Input fields for editing product details -->
                            <div class="mb-3">
            <label for="editfullname<?php echo $result['id']; ?>" class="form-label">Full Name</label>
            <input type="text" class="form-control" id="editfname<?php echo $result['id']; ?>" name="fname" value="<?php echo $result['fullname']; ?>" required>
           
            <label for="editemail<?php echo $result['id']; ?>" class="form-label">Email</label>
            <input type="email" class="form-control" id="editemail<?php echo $result['id']; ?>" name="email" value="<?php echo $result['email']; ?>" required>
           
            <label for="editbday<?php echo $result['id']; ?>" class="form-label">Birth Day</label>
            <input type="date" class="form-control" id="edituname<?php echo $result['id']; ?>" name="uname" value="<?php echo $result['bday']; ?>" required>
           

            <label for="edituname<?php echo $result['id']; ?>" class="form-label">Username</label>
            <input type="text" class="form-control" id="edituname<?php echo $result['id']; ?>" name="uname" value="<?php echo $result['uname']; ?>" required>
           
            
            <label for="editpassword<?php echo $result['id']; ?>" class="form-label">Password</label>
            <input type="password" class="form-control" id="editpassword<?php echo $result['id']; ?>" name="password" value="<?php echo $result['password']; ?>" required>
   
            

          <!--  <label for="editImage<?php echo $row['id']; ?>" class="form-label">Image</label>
            <input type="file" class="form-control" id="editImage<?php echo $row['id']; ?>" name="image" value="<?php echo $row['image_path']; ?>" >
            -->
            
                            </div>
                            <!-- Add more input fields for other details if needed -->

                            <input type="hidden" name="productID" value="<?php echo $result['id']; ?>">

                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Product Modal -->
        <div class="modal fade" id="deleteProductModal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="deleteProductModalLabel<?php echo $row['id']; ?>" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteProductModalLabel<?php echo $row['id']; ?>">Delete Admin Account</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Delete Product Form -->
                        <p>Are you sure you want to delete this account?</p>
                        <form action="backend_account/delete_account.php" method="POST">
                            <input type="hidden" name="productID" value="<?php echo $row['id']; ?>">
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
                            
        <?php
            }
        } else {
            echo "<tr><td colspan='6'>No games found</td></tr>";
        }
        ?>
    </tbody>

                    </table>
                </div>
            </div>
        </div>
    </main>

    <!-- Add Product Modal -->
    <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProductModalLabel">Add Admin Account</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Add Product Form -->
                    <form action="backend_account/add_account.php" method="POST"  enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="productName" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="productName" name="fname" required>
                        </div>
                        <div class="mb-3">
                            <label for="productName" class="form-label">Middle Name</label>
                            <input type="text" class="form-control" id="productName" name="mname" required>
                        </div>
                        <div class="mb-3">
                            <label for="productName" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="productName" name="lname" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="genre" class="form-label">Username</label>
                            <input type="text" class="form-control" id="uname" name="uname" required>
                        </div>
                        <div class="mb-3">
                            <label for="platform" class="form-label">Email</label>
                            <input type="email" class="form-control" id="platform" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="developer" class="form-label">Password</label>
                            <input type="password" class="form-control" id="developer" name="password" required>
                        </div>
                        <div class="mb-3">
    <label for="role" class="form-label">Role</label>
    <select class="form-select" id="role" name="role" required>
        <option value="admin">Admin</option>
        <option value="staff">Staff</option>
    </select>
</div>

                        <button type="submit" class="btn btn-primary">Add Account</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
   
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
    <!-- Bootstrap Bundle with Popper -->

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