
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
                <h4><small>Product > </small>Games </h4>
            </div>
            <!-- Table Element -->
            <div class="card border-0">
            <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title">
                        List of Games
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
                                <th>Game No.</th>
                                <th>Banner</th>
                                <th>Name</th>
                                <th>Genre</th>
                                <th>Platform</th>
                                <th>Developer</th>
                                <th>Publisher</th>
                                <th>Release Date</th>
                                <th>Mature Content</th>
                                <th>Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
        <?php
        $sql = "SELECT * FROM products";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
        ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php if ($row['image_path'] != ""): ?>
                        <img src="uploads/<?php echo $row['image_path']; ?>" style="width: 80px;">
                      <?php else: ?>
                        <img src="uploads/default.jpg" style="width: 80px">
                      <?php endif; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['genre']; ?></td>
            <td><?php echo $row['platform']; ?></td>
            <td><?php echo $row['developer']; ?></td>
            <td><?php echo $row['publisher']; ?></td>
            <td><?php echo $row['release_date']; ?></td>
            <td><?php echo $row['mature_content']; ?></td>
            <td><?php echo $row['price']; ?></td>
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
                        <h5 class="modal-title" id="editProductModalLabel<?php echo $row['id']; ?>">Edit Product</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Edit Product Form -->
                        <form action="edit_product.php" method="POST">
                            <!-- Input fields for editing product details -->
                            <div class="mb-3">
                            <label for="editProductName<?php echo $row['id']; ?>" class="form-label">Product Name</label>
            <input type="text" class="form-control" id="editProductName<?php echo $row['id']; ?>" name="editProductName" value="<?php echo $row['name']; ?>" required>
            
            <label for="editGenre<?php echo $row['id']; ?>" class="form-label">Genre</label>
            <input type="text" class="form-control" id="editGenre<?php echo $row['id']; ?>" name="genre" value="<?php echo $row['genre']; ?>" required>
            
            <label for="editPlatform<?php echo $row['id']; ?>" class="form-label">Platform</label>
            <input type="text" class="form-control" id="editPlatform<?php echo $row['id']; ?>" name="platform" value="<?php echo $row['platform']; ?>" required>
            
            <label for="editDeveloper<?php echo $row['id']; ?>" class="form-label">Developer</label>
            <input type="text" class="form-control" id="editDeveloper<?php echo $row['id']; ?>" name="developer" value="<?php echo $row['developer']; ?>" required>
            
            <label for="editDeveloper<?php echo $row['id']; ?>" class="form-label">Publisher</label>
            <input type="text" class="form-control" id="editDeveloper<?php echo $row['id']; ?>" name="publisher" value="<?php echo $row['publisher']; ?>" required>
            
            <label for="editReleaseDate<?php echo $row['id']; ?>" class="form-label">Release Date</label>
            <input type="date" class="form-control" id="editReleaseDate<?php echo $row['id']; ?>" name="release_date" value="<?php echo $row['release_date']; ?>">
            
            <label for="editmature<?php echo $row['id']; ?>" class="form-label">Mature Content</label>
            <input type="number" class="form-control" id="editmature<?php echo $row['id']; ?>" name="mature_content" value="<?php echo $row['mature_content']; ?>" required>
            

            <div style="position: relative;">
    <label for="editImage<?php echo $row['id']; ?>" class="form-label">Image</label>
    <input type="file" class="form-control" id="editImage<?php echo $row['id']; ?>" name="image_path" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0;">
    <input type="text" class="form-control" id="currentImagePath" value="<?php echo $row['image_path']; ?>" readonly>
    <button type="button" class="btn btn-secondary" onclick="document.getElementById('editImage<?php echo $row['id']; ?>').click()" style="position: absolute; top: 30; right: 0;">Choose File</button>
    
</div>


            <label for="editPrice<?php echo $row['id']; ?>" class="form-label">Price</label>
            <input type="text" class="form-control" id="editPrice<?php echo $row['id']; ?>" name="price" value="<?php echo $row['price']; ?>" required>
        
                            </div>
                            <!-- Add more input fields for other details if needed -->

                            <input type="hidden" name="productID" value="<?php echo $row['id']; ?>">

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
                        <h5 class="modal-title" id="deleteProductModalLabel<?php echo $row['id']; ?>">Delete Product</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Delete Product Form -->
                        <p>Are you sure you want to delete this product?</p>
                        <form action="delete_product.php" method="POST">
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
                    <h5 class="modal-title" id="addProductModalLabel">Add Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Add Product Form -->
                    <form action="add_product.php" method="POST"  enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="productName" class="form-label">Product Name</label>
                            <input type="text" class="form-control" id="productName" name="productName" required>
                        </div>
                        <div class="mb-3">
                            <label for="genre" class="form-label">Genre</label>
                            <input type="text" class="form-control" id="genre" name="genre" required>
                        </div>
                        <div class="mb-3">
                            <label for="platform" class="form-label">Platform</label>
                            <input type="text" class="form-control" id="platform" name="platform" required>
                        </div>
                        <div class="mb-3">
                            <label for="developer" class="form-label">Developer</label>
                            <input type="text" class="form-control" id="developer" name="developer" required>
                        </div>
                        <div class="mb-3">
                            <label for="publisher" class="form-label">Publisher</label>
                            <input type="text" class="form-control" id="publisher" name="publisher" required>
                        </div>

                        <div class="mb-3">
                            <label for="release_date" class="form-label">Release Date</label>
                            <input type="date" class="form-control"   name="release_date" />
                        </div>
                        
                        <div class="mb-3">
                            <label for="release_date" class="form-label">Mature Content</label>
                            <input type="number" class="form-control"   name="mature_content" />
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Banner</label>
                            <input type="file" class="form-control" id="image" name="image">
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Price</label>
                            <input type="number" class="form-control" id="price" name="price" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Product</button>
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
