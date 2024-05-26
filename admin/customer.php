
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
                        </div>
                
                </div>
                
                <div class="card-body table-responsive">
                <table id="dataTable" class="table table-hover table-striped table-bordered">
                <thead>
                            <tr>
                                <th>Profile</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Birthday</th>
                                <th>Verified</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                        <?php
                            $sql = "SELECT * FROM customer";
                            $meta = mysqli_query($conn, $sql);

                            if (mysqli_num_rows($meta) > 0) {
                                while($row = mysqli_fetch_assoc($meta)) {
                          ?>
       <tr>
                            <td style="text-align: center;">
    <?php if ($row['image'] != ""): ?>
        <img src="uploads/<?php echo $row['image']; ?>" style="width: 80px; height: 80px;">
    <?php else: ?>
        <img src="uploads/default.jpg" style="width: 80px; height: 80px;">
    <?php endif; ?>
</td>
                            <td><?php echo $row['fname']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['bday']; ?></td>
                            <td class="text-center">
        <?php if ($row['email_verified'] == 1): ?>
            <button class="btn btn-success" style="font-size: 0.8rem;">
                <i class='bx bx-check-circle'></i> Verified
            </button>
        <?php else: ?>
            <button class="btn btn-danger" style="font-size: 0.8rem;">
                <i class='bx bx-x-circle'></i> Not Verified
            </button>
        <?php endif; ?>
    </td>
                            
                            <td>
                               
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editCustomerModal<?php echo $row['id']; ?>"><i class="fas fa-edit"></i></button>
           
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteProductModal<?php echo $row['id']; ?>"><i class="fas fa-trash-alt"></i></button>

                        </td>
                        </tr>
 <!-- Edit Customer Modal -->
<div class="modal fade" id="editCustomerModal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="editCustomerModalLabel<?php echo $row['id']; ?>" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCustomerModalLabel<?php echo $row['id']; ?>">Edit Customer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Edit Customer Form -->

                <div class="text-center mb-3">
                    <img src="uploads/<?php echo $row['image']; ?>" alt="User Image" class="img-thumbnail" style="max-width: 150px;">
                </div>


                <form action="backend_customer/edit_account.php" method="POST" enctype="multipart/form-data">
                    <!-- Input fields for editing customer details -->
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="mb-3">
                                <label for="editfname<?php echo $row['id']; ?>" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="editfname<?php echo $row['id']; ?>" name="fname" value="<?php echo $row['fname']; ?>" required>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="mb-3">
                                <label for="editmname<?php echo $row['id']; ?>" class="form-label">Middle Name</label>
                                <input type="text" class="form-control" id="editmname<?php echo $row['id']; ?>" name="mname" value="<?php echo $row['mname']; ?>" required>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="mb-3">
                                <label for="editlname<?php echo $row['id']; ?>" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="editlname<?php echo $row['id']; ?>" name="lname" value="<?php echo $row['lname']; ?>" required>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="editbday<?php echo $row['id']; ?>" class="form-label">Birth Day</label>
                        <input type="date" class="form-control" id="editbday<?php echo $row['id']; ?>" name="bday" value="<?php echo $row['bday']; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="editImage<?php echo $row['id']; ?>" class="form-label">Profile Image</label>
                        <input type="file" class="form-control" id="editImage<?php echo $row['id']; ?>" name="image">
                        <input type="hidden" class="form-control" id="currentImagePath" name="currentImagePath" value="<?php echo $row['image']; ?>">
                    </div>
                    <hr class="my-3 mt-2">
                    <h6 class="mb-3 fw-bold">Address</h6>
          
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="mb-3">
                                <label for="editregion<?php echo $row['id']; ?>" class="form-label">Region</label>
                                <input type="text" class="form-control" id="editregion<?php echo $row['id']; ?>" name="region" value="<?php echo $row['region']; ?>" required>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="mb-3">
                                <label for="editprovince<?php echo $row['id']; ?>" class="form-label">Province</label>
                                <input type="text" class="form-control" id="editprovince<?php echo $row['id']; ?>" name="province" value="<?php echo $row['province']; ?>" required>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="mb-3">
                                <label for="editcity<?php echo $row['id']; ?>" class="form-label">City</label>
                                <input type="text" class="form-control" id="editcity<?php echo $row['id']; ?>" name="city" value="<?php echo $row['city']; ?>" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="editstreet<?php echo $row['id']; ?>" class="form-label">Street</label>
                                <input type="text" class="form-control" id="editstreet<?php echo $row['id']; ?>" name="street" value="<?php echo $row['street']; ?>" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="editzipcode<?php echo $row['id']; ?>" class="form-label">Zip Code</label>
                                <input type="text" class="form-control" id="editzipcode<?php echo $row['id']; ?>" name="zipcode" value="<?php echo $row['zipcode']; ?>" required>
                            </div>
                        </div>
                    </div>
                    <hr class="my-3 mt-2">
                    <h6 class="mb-3 fw-bold">Account</h6>
          
                    <div class="mb-3">
                        <label for="editemail<?php echo $row['id']; ?>" class="form-label">Email</label>
                        <input type="email" class="form-control" id="editemail<?php echo $row['id']; ?>" name="email" value="<?php echo $row['email']; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="edituname<?php echo $row['id']; ?>" class="form-label">Username</label>
                        <input type="text" class="form-control" id="edituname<?php echo $row['id']; ?>" name="uname" value="<?php echo $row['uname']; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="editpassword<?php echo $row['id']; ?>" class="form-label">Password</label>
                        <input type="password" class="form-control" id="editpassword<?php echo $row['id']; ?>" name="password" value="<?php echo $row['password']; ?>" required>
                    </div>
                    <hr class="my-3 mt-4">
                    <!-- Hidden input field to store customer ID -->
                    <input type="hidden" name="customerId" value="<?php echo $row['id']; ?>">
                    <div class="text-center d-flex justify-content-center">
    <button type="submit" class="btn btn-primary me-2">Update</button>
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
</div>
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
                        <form action="backend_customer/delete_account.php" method="POST">
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
                    <h5 class="modal-title" id="addProductModalLabel">Add Customer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Add Product Form -->
                    <form action="backend_customer/add_account.php" method="POST"  enctype="multipart/form-data">
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
                            <label for="genre" class="form-label">Birth Day</label>
                            <input type="date" class="form-control" id="bday" name="bday" required>
                        </div>
                        <div class="mb-3">
                            <label for="pfp" class="form-label">Profile Image</label>
                            <input type="file" class="form-control" id="image" name="image" required>
                        </div>
        <div class="row">

            <div class="col-sm-4">
                <div class="mb-3">
                    <label for="firstName" class="form-label">Region</label>
                    <input type="text" class="form-control" id="region" name="region" required>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="mb-3">
                    <label for="middleName" class="form-label">Province</label>
                    <input type="text" class="form-control" id="province" name="province" required>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="mb-3">
                    <label for="lastName" class="form-label">City</label>
                    <input type="text" class="form-control" id="city" name="city" required>
                </div>
            </div>
        </div>

        <div class="row">

            <div class="col-sm-6">
                <div class="mb-3">
                    <label for="firstName" class="form-label">Street</label>
                    <input type="text" class="form-control" id="street" name="street" required>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="mb-3">
                    <label for="middleName" class="form-label">Zip Code</label>
                    <input type="text" class="form-control" id="zipcode" name="zipcode" required>
                </div>
            </div>
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