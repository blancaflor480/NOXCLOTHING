
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
                document.getElementById('currentImagePath').value = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    });
</script>
    <?php include('sidebar.php'); ?>
    <main class="content px-3 py-2">
        <div class="container-fluid">
            <div class="mb-3">
                <h4><small>Dashboard > </small> Account Information</h4>
            </div>
            <!-- Table Element -->
            <div class="card border-0">
            <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title">
                        Account List
                    </h5>
                    <div class="d-flex justify-content-end align-items-center">
                        <button type="button" class="btn btn-success btn-sm me-2" data-bs-toggle="modal" data-bs-target="#addProductModal">Add</button>
                       </div>
                
                </div>
                
                <div class="card-body table-responsive">
                <table id="dataTable" class="table table-hover table-striped table-bordered">
                <thead>
                            <tr>
                                <th style="text-align: left;">Profile Image</th>
                                <th>Name</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
        <?php
        $sql = "SELECT * FROM admin";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
        ?>
        <tr>
        <td style="text-align: center;">
    <?php if ($row['image'] != ""): ?>
        <img src="uploads/<?php echo $row['image']; ?>" style="width: 80px; height: 80px;">
    <?php else: ?>
        <img src="uploads/default.jpg" style="width: 80px; height: 80px;">
    <?php endif; ?>
</td>
            <td><?php echo $row['fname'] . ' ' . $row['mname'] . ' ' . $row['lname']; ?></td>
            <td><?php echo $row['uname']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['role']; ?></td>
            <td>
               
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editProductModal<?php echo $row['id']; ?>"><i class="fas fa-edit"></i></button>
            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteProductModal<?php echo $row['id']; ?>"><i class="fas fa-trash-alt"></i></button>

        </td>
        </tr>

        <!-- Edit Product Modal -->
        <div class="modal fade" id="editProductModal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="editProductModalLabel<?php echo $row['id']; ?>" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editProductModalLabel<?php echo $row['id']; ?>">Edit Admin Profile</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Edit Product Form -->
                        <form action="backend_account/edit_account.php" method="POST" enctype="multipart/form-data">
                            <!-- Input fields for editing product details -->
                            <div class="md-3">
                            <div class="row">
            <div class="col-sm-4">
                <div class="mb-3">
                    <label for="editfname<?php echo $row['id']; ?>" class="form-label">First name</label>
                    <input type="text" class="form-control" id="editfname<?php echo $row['id']; ?>" name="fname" value="<?php echo $row['fname']; ?>" required>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="mb-3">
                    <label for="editmname<?php echo $row['id']; ?>" class="form-label">Middle name</label>
                    <input type="text" class="form-control" id="editmname<?php echo $row['id']; ?>" name="mname" value="<?php echo $row['mname']; ?>" required>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="mb-3">
                    <label for="editlname<?php echo $row['id']; ?>" class="form-label">Last name</label>
                    <input type="text" class="form-control" id="editfname<?php echo $row['id']; ?>" name="lname" value="<?php echo $row['lname']; ?>" required>
                </div>
            </div>
        </div>


    
            <label for="editemail<?php echo $row['id']; ?>" class="form-label">Email</label>
            <input type="email" class="form-control" id="editemail<?php echo $row['id']; ?>" name="email" value="<?php echo $row['email']; ?>" required>
           





            <div style="position: relative;">
    <label for="editImage<?php echo $row['id']; ?>" class="form-label">Image</label>
    <input type="file" class="form-control" id="editImage<?php echo $row['id']; ?>" name="image" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0;">
    <input type="text" class="form-control" id="currentImagePath" value="<?php echo $row['image']; ?>" readonly>
    <button type="button" class="btn btn-secondary" onclick="document.getElementById('editImage<?php echo $row['id']; ?>').click()" style="position: absolute; top: 30; right: 0;">Choose File</button>
</div>

            <label for="edituname<?php echo $row['id']; ?>" class="form-label">Username</label>
            <input type="text" class="form-control" id="edituname<?php echo $row['id']; ?>" name="uname" value="<?php echo $row['uname']; ?>" required>
           
            <label for="editpassword<?php echo $row['id']; ?>" class="form-label">Password</label>
                        <div class="input-group">
                        <input type="password" class="form-control" id="editpasswordInput<?php echo $row['id']; ?>" name="password" value="<?php echo $row['password']; ?>" required>
                        </div>

            <label for="editrole<?php echo $row['id']; ?>" class="form-label">Role</label>
<select class="form-select" id="editrole<?php echo $row['id']; ?>" name="role" required>
    <option value="Admin" <?php if($row['role'] == 'Admin') echo 'selected'; ?>>Admin</option>
    <option value="Staff" <?php if($row['role'] == 'Staff') echo 'selected'; ?>>Staff</option>
</select>

            
                            </div>
                            <!-- Add more input fields for other details if needed -->

                            <input type="hidden" name="productID" value="<?php echo $row['id']; ?>">
<br>
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
                    <div class="row">
            <div class="col-sm-4">
                <div class="mb-3">
                    <label for="firstName" class="form-label">First Name</label>
                    <input type="text" class="form-control" id="firstName" name="fname" required>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="mb-3">
                    <label for="middleName" class="form-label">Middle Name</label>
                    <input type="text" class="form-control" id="middleName" name="mname" required>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="mb-3">
                    <label for="lastName" class="form-label">Last Name</label>
                    <input type="text" class="form-control" id="lastName" name="lname" required>
                </div>
            </div>
        </div>
                        <div class="mb-3">
                            <label for="pfp" class="form-label">Profile Image</label>
                            <input type="file" class="form-control" id="image" name="image" required>
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