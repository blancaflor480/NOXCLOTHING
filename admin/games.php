
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
                <h4><small>Product > </small>Items </h4>
            </div>
            <!-- Table Element -->
            <div class="card border-0">
            <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title">
                        List of Items 
                    </h5>
                    <div class="d-flex justify-content-end align-items-center">
                        <button type="button" class="btn btn-success btn-sm me-2" data-bs-toggle="modal" data-bs-target="#addProductModal">Add</button>
                        </div>
                </div>
                
                <div class="card-body table-responsive">
                <table id="dataTable" class="table table-hover table-striped table-bordered">
                
                <thead>
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Product Name</th>
                                <th>Status</th>
                                <th>Quantity</th>
                                <th>Category</th>
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
            <td><?php if ($row['image_front'] != ""): ?>
                        <img src="uploads/<?php echo $row['image_front']; ?>" style="width: 80px;">
                      <?php else: ?>
                        <img src="uploads/default.jpg" style="width: 80px">
                      <?php endif; ?></td>
            <td><?php echo $row['name_item']; ?></td>
            <td><?php echo $row['status']; ?></td>
            <td><?php echo $row['quantity']; ?></td>
            <td><?php echo $row['category']; ?></td>
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
                        <form action="edit_product.php" method="POST" enctype="multipart/form-data">
                            <!-- Input fields for editing product details -->
                             <div class="mb-3">
                        <label for="editProductName<?php echo $row['id']; ?>" class="form-label">Product Name</label>
                        <input type="text" class="form-control" id="editProductName<?php echo $row['id']; ?>" name="editProductName" value="<?php echo $row['name_item']; ?>" required>
                        
                        <label for="editProductColor<?php echo $row['id']; ?>" class="form-label">Color</label>
                        <input type="text" class="form-control" id="editProductColor<?php echo $row['id']; ?>" name="editProductColor" value="<?php echo $row['color']; ?>" required>
                        
                        <label for="editProductSize<?php echo $row['id']; ?>" class="form-label">Size</label>
                        <select class="form-control" id="editProductSize<?php echo $row['id']; ?>" name="editProductSize" required>
                            <option value="small" <?php if($row['size'] == 'small') echo 'selected'; ?>>Small</option>
                            <option value="medium" <?php if($row['size'] == 'medium') echo 'selected'; ?>>Medium</option>
                            <option value="large" <?php if($row['size'] == 'large') echo 'selected'; ?>>Large</option>
                        </select>

                        <label for="editProductCategory<?php echo $row['id']; ?>" class="form-label">Category</label>
                        <select class="form-select" id="editProductCategory<?php echo $row['id']; ?>" name="editProductCategory" required>
                            <option disabled>Select Here</option>
                            <option value="T-SHIRT" <?php if($row['category'] == 'T-SHIRT') echo 'selected'; ?>>T-SHIRT</option>
                            <option value="SHORTS" <?php if($row['category'] == 'SHORT') echo 'selected'; ?>>SHORTS</option>
                            <option value="JACKETS" <?php if($row['category'] == 'JACKET') echo 'selected'; ?>>JACKETS</option>
                        </select>
                        
                        <label for="editProductQuantity<?php echo $row['id']; ?>" class="form-label">Quantity</label>
                        <input type="text" class="form-control" id="editProductQuantity<?php echo $row['id']; ?>" name="editProductQuantity" value="<?php echo $row['quantity']; ?>" required>
                        
                        <label for="editProductType<?php echo $row['id']; ?>" class="form-label">Type</label>
                        <select class="form-select" id="editProductType<?php echo $row['id']; ?>" name="editProductType" required>
                            <option disabled>Select Here</option>
                            <option value="male" <?php if($row['type'] == 'male') echo 'selected'; ?>>Male</option>
                            <option value="female" <?php if($row['type'] == 'female') echo 'selected'; ?>>Female</option>
                            <option value="other" <?php if($row['type'] == 'other') echo 'selected'; ?>>Other</option>
                        </select>
                        
                        <label for="editProductManufacturer<?php echo $row['id']; ?>" class="form-label">Manufacturer</label>
                        <select class="form-select" id="editProductManufacturer<?php echo $row['id']; ?>" name="editProductManufacturer" required>
                            <option disabled>Select Here</option>
                            <option value="Nike" <?php if($row['manufacturer'] == 'Nike') echo 'selected'; ?>>Nike</option>
                            <option value="Dickies" <?php if($row['manufacturer'] == 'Dickies') echo 'selected'; ?>>Dickies</option>
                            <option value="UNIQLO" <?php if($row['manufacturer'] == 'UNIQLO') echo 'selected'; ?>>UNIQLO</option>
                        </select>
                        
                        <label for="editProductStatus<?php echo $row['id']; ?>" class="form-label">Status</label>
                        <select class="form-select" id="editProductStatus<?php echo $row['id']; ?>" name="editProductStatus" required>
                            <option disabled>Select Here</option>
                            <option value="Restock" <?php if($row['status'] == 'Restock') echo 'selected'; ?>>Restock</option>
                            <option value="Low Stock" <?php if($row['status'] == 'Low Stock') echo 'selected'; ?>>Low Stock</option>
                            <option value="Instock" <?php if($row['status'] == 'Instock') echo 'selected'; ?>>Instock</option>
                        </select>
                        
                     <label for="editDescription<?php echo $row['id']; ?>" class="form-label">Description</label>
                       <textarea class="form-control" id="editDescription<?php echo $row['id']; ?>" name="editDescription" required><?php echo $row['description']; ?></textarea>


                        <div style="position: relative;">
    <label for="editImage<?php echo $row['id']; ?>" class="form-label">Image</label>
    <input type="file" class="form-control" id="editImage<?php echo $row['id']; ?>" name="image_front" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0;">
    <input type="text" class="form-control" id="currentImagePath<?php echo $row['id']; ?>" value="<?php echo $row['image_front']; ?>" readonly> 
    <button type="button" class="btn btn-secondary" onclick="document.getElementById('editImage<?php echo $row['id']; ?>').click()" style="position: absolute; top: 30px; right: 0;">Choose File</button>
</div>

                        
                        <label for="editPrice<?php echo $row['id']; ?>" class="form-label">Discount</label>
                        <input type="text" class="form-control" id="editPrice<?php echo $row['id']; ?>" name="editDiscount" value="<?php echo $row['discount']; ?>" required>
                        
                        <label for="editPrice<?php echo $row['id']; ?>" class="form-label">Price</label>
                        <input type="text" class="form-control" id="editPrice<?php echo $row['id']; ?>" name="editPrice" value="<?php echo $row['price']; ?>" required>
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
                            <label for="color" class="form-label">Color</label>
                            <input type="text" class="form-control" id="color" name="color" required>
                        </div>
                        <!--GAGAWIN SELECT ITO -->
                        <div class="mb-3">
                          <label for="platform" class="form-label">Size</label>
                             <select class="form-select" id="size" name="size" required>
                             <option disbaled>Select Here</option>
                           
                             <option value="small">Small</option>
                                <option value="medium">Medium</option>
                                <option value="large">Large</option>
        <!-- Add more options as needed -->
                           </select>
                       </div>

                        <div class="mb-3">
                            <label for="category" class="form-label">Category</label>
                            <select class="form-select" name="category">
                                  <option disbaled>Select Here</option>
                                  <option value="T-SHIRT">T-SHIRT</option>
                                  <option value="SHORTS">SHORTS</option>
                                  <option value="JACKETS">JACKETS</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="publisher" class="form-label">Quantity</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" required>
                        </div>

                        <div class="mb-3">
                            <label for="release_date" class="form-label">type</label>
                                  <select class="form-select" name="type">
                                  <option disbaled>Select Here</option>
                                  <option value="male">Male</option>
                                  <option value="female">Female</option>
                                  <option value="other">Other</option>
                            </select>
                       </div>
                        <div class="mb-3">
                            <label for="manufacture" class="form-label">Manufacturer</label>
                            <select class="form-select" name="manufacturer">
                                  <option disbaled>Select Here</option>
                                  <option value="Nike">Nike</option>
                                  <option value="Dickies">Dickies</option>
                                  <option value="UNIQLO">UNIQLO</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="manufacture" class="form-label">Status</label>
                            <select class="form-select" name="status">
                                  <option disbaled>Select Here</option>
                                  <option value="Restock">Restock</option>
                                  <option value="Low Stock">Stock</option>
                                  <option value="Instock">Instock</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
        <label for="image" class="form-label">Image Product</label>
        <input type="file" class="form-control" name="image_front">
    </div>


                        <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea class="form-control" id="description" name="description"></textarea>
    </div>
                       <div class="mb-3">
                            <label for="discount" class="form-label">Discount</label>
                            <input type="number" class="form-control" id="discount" name="discount" required>
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
