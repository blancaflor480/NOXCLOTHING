<?php
session_start();

// Check kung may session na itinakda para sa 'uname'
if (!isset($_SESSION['email'])) {
    header("Location: index.php?error=Login%20First");
    exit();
}

// Include ng database connection
include 'dbconn/conn.php';

// Kunin ang 'uname' mula sa session
$email = $_SESSION['email'];

// Subukan kung mayroong resulta sa query
$stmt = $conn->prepare("SELECT * FROM customer WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

// Siguraduhing may resulta bago kunin ang data
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $user_id = $user['id']; // Kunin ang 'id' ng user
} else {
    // Kung wala, i-redirect sa login page
    header("Location: login-signup.php?error=Login%20First");
    exit();
}

// I-set ang 'user_id' sa session para magamit sa ibang mga pahina
$_SESSION['user_id'] = $user_id;
?>



<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  	<link rel="icon" href="images/icon.png"/>
	
    <!-- Boxicons -->
    <link
      href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css"
      rel="stylesheet"
    />
    <!-- Glide js -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Glide.js/3.4.1/css/glide.core.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Glide.js/3.4.1/css/glide.theme.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Custom StyleSheet -->
    <link rel="stylesheet" href="./css/styles.css" />
    <title>NOX CLOTHING</title>
  </head>
  <style>
    .custom-list-group .list-group-item {
        margin-bottom: 13px; /* Adjust the value to your preferred spacing */
        border: none; 
        height: 40px;

        border-radius: 10px;
        transition: background-color 0.3s, color 0.3s; /* Smooth transition */
    }
    .custom-list-group a {
        text-decoration: none; /* To remove underline */

    }
    .custom-list-group .list-group-item:hover {
        background-color: black; /* Change background color on hover */
        color: white; /* Change text color on hover */
    }
    .custom-list-group .list-group-item i {
        transition: color 0.3s; /* Smooth transition for icons */
    }
    .custom-list-group .list-group-item:hover i {
        color: white; /* Change icon color on hover */
    }
</style>
<?php
    $totalItems = 0; // Initialize total items count

    $sql = "SELECT addcart.*, products.price AS product_price FROM addcart INNER JOIN products ON addcart.products_id = products.id";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $totalItems++; // Increment total items count
        }
    }
?>
  <?php
// Make sure to properly escape $_SESSION['uname'] to prevent SQL injection
$email = $_SESSION['email'];

// Query to count the number of items in the user's cart
$query = $conn->prepare("SELECT COUNT(id) AS numberofproduct FROM addcart WHERE customer_id = ? AND status != 'Paid'");
$query->bind_param("s", $user_id);
$query->execute();
$result = $query->get_result();

// Check if there are items in the cart
if ($result && $result->num_rows > 0) { 
    $row = $result->fetch_assoc();
    $numberofproduct = $row['numberofproduct'];
} else {
    $numberofproduct = 0;
}
?>

<?php
// Make sure to properly escape $_SESSION['uname'] to prevent SQL injection
$user_id = $_SESSION['user_id'];

// Query to count the number of items in the user's cart
$query = $conn->prepare("SELECT COUNT(id) AS numberwish  FROM wishlist WHERE customer_id = ?");
$query->bind_param("s", $user_id);
$query->execute();
$result = $query->get_result();

// Check if there are items in the cart
if ($result && $result->num_rows > 0) { 
    $row = $result->fetch_assoc();
    $numberwish  = $row['numberwish'];
} else {
    $numberwish  = 0;
}
?>
  <body>
    <!-- Header -->
    <header class="header" id="header">
      <!-- Top Nav -->
       <div class="top-nav">
      <div class="container d-flex">
        <p style="margin-top: 10px">Order Online Or Call Us: (001) 2222-55555</p>
        <ul class="d-flex" style="margin-top: 10px">
          <li><a href="About.php">About Us</a></li>
          <li><a href="#">FAQ</a></li>
          <li><a href="contact.php">Contact</a></li>
        </ul>
      </div>
    </div>
      
<div class="navigation">
        <div class="nav-center container d-flex">
        <a href="/" class="logo" style="margin-top: -10px;"><h1 style="font-size: 3rem; font-weigh: 700;">Nox</h1></a>

          <ul class="nav-list d-flex" style="margin-top: -10px;">
            <li class="nav-item">
              <a href="index.php" class="nav-link">Home</a>
            </li>
            <li class="nav-item">
              <a href="product.php" class="nav-link">Shop</a>
            </li>
            <li class="nav-item">
            <a href="#terms" class="nav-link">Terms</a>
            </li>
            <li class="nav-item">
              <a href="About.php" class="nav-link">About</a>
            </li>
            <li class="nav-item">
              <a href="contact.php" class="nav-link">Contact</a>
            </li>
            
           
          </li>
          </ul>

          <div class="icons d-flex" style="margin-top: -16px;">
            <a href="login-signup.php" class="icon">
              <i class="bx bx-user"></i>
            </a>
            <div class="icon">
              <i class="bx bx-search"></i>
            </div>
           <a href="wishlist.php" class="icon">
              <i class="bx bx-heart"></i>
              <span id="wishlistCount" class="d-flex"><?php echo $numberwish; ?></span>
              </a>
            <a href="cart.php" class="icon">
              <i class="bx bx-cart"></i>
              <span id="count" class="d-flex"><?php echo $numberofproduct; ?></span>
            </a>
            <a href="logout.php" class="icon">
              <i class="bx bx-log-out"></i>
            </a>
          
          </div>

         

          <div class="hamburger">
            <i class="bx bx-menu-alt-left"></i>
          </div>
        </div>
      </div>


<section class="container mt-5">
    <div class="row">
        <div class="col-md-3">
                <div class="bg-light p-3">
                    <div class="d-flex align-items-center mb-3" style="text-align: center;">
                        <div>
                            <img id="imagePreview" src="uploads/pfpp.png" alt="Profile Picture" style="max-width: 50px; height: auto;" />
                        </div>
                        <div class="ms-4 mt-4">
                            <p style="font-size: 1.3rem; font-weight: bold;"><?php echo htmlspecialchars($email); ?></p>
                        </div>
                    </div>
                    <div class="list-group mb-2 mt-4 custom-list-group" style="font-size: 1.7rem;">
    <a href="profile.php" class="list-group-item list-group-item-action"><i class='bx bx-user'></i> Profile</a>
    <a href="address.php" class="list-group-item list-group-item-action"><i class='bx bx-map'></i> Address</a>
    <a href="changepassword.php" class="list-group-item list-group-item-action"><i class='bx bx-edit'></i> Change Password</a>
    <a href="mypurchase.php" class="list-group-item list-group-item-action"><i class='bx bx-notepad'></i> My Purchase</a>
</div>
                </div>
            </div>
        
        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <div class="card-header d-flex justify-content-between align-items-center" style="background-color:transparent;">
                        <h3>My Purchase</h3>
                        <div class="col-md-2 mb-3">
                            <select id="inputState" class="form-select">
                                <option selected>All</option>
                                <option>To Pay</option>
                                <option>To Ship</option>
                                <option>To Receive</option>
                                <option>Completed</option>
                                <option>Cancelled</option>
                            </select>
                        </div>
                    </div>
                    <!-- Purchase Item Card -->
                    <div class="purchase-card mb-3 mt-5">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <span class="badge bg-warning text-dark">Preferred</span>
                                <strong>Brightest Roof Shop</strong>
                                <button class="btn btn-outline-secondary btn-sm">Chat</button>
                                <button class="btn btn-outline-secondary btn-sm">View Shop</button>
                            </div>
                            <div>
                                <span class="text-success">Parcel has been delivered</span>
                                <span class="badge bg-success">COMPLETED</span>
                            </div>
                        </div>
                        <div class="d-flex mt-3">
                            <img src="image.png" alt="Product Image" style="width: 80px; height: 80px; object-fit: cover;">
                            <div class="ms-3">
                                <p class="mb-1"><strong>SOFTEX Plain Round Neck Shirt light sky aqua blue royal violet brown black</strong></p>
                                <p class="mb-1">Variation: navy blue, Large</p>
                                <p class="mb-1">x1</p>
                                <button class="btn btn-outline-success btn-sm">Change of Mind</button>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div>
                                <span>Rate products by <a href="#">07/15/2024</a></span>
                                <p class="text-danger mb-0">Rate now and get 1.4 coins</p>
                            </div>
                            <div>
                                <span class="text-muted"><s>₱145</s></span>
                                <span class="text-danger ms-2">₱121</span>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end align-items-center mt-3">
                            <span class="me-3"><strong>Order Total: ₱121</strong></span>
                            <button class="btn btn-outline-danger me-2">Rate</button>
                            <button class="btn btn-outline-secondary me-2">Contact Seller</button>
                            <button class="btn btn-outline-primary">Buy Again</button>
                        </div>
                    </div>
                    <!-- End of Purchase Item Card -->
                </div>
            </div>
        </div>
    </div>
</section>

  <br>
    <!-- Footer -->
    <footer class="footer">
      <div class="row">
        <div class="col d-flex">
          <h4>INFORMATION</h4>
          <a href="">About us</a>
          <a href="">Contact Us</a>
          <a href="">Term & Conditions</a>
          <a href="">Shipping Guide</a>
        </div>
        <div class="col d-flex">
          <h4>USEFUL LINK</h4>
          <a href="">Online Store</a>
          <a href="">Customer Services</a>
          <a href="">Promotion</a>
          <a href="">Top Brands</a>
        </div>
        <div class="col d-flex">
          <span><i class='bx bxl-facebook-square'></i></span>
          <span><i class='bx bxl-instagram-alt' ></i></span>
          <span><i class='bx bxl-github' ></i></span>
          <span><i class='bx bxl-twitter' ></i></span>
          <span><i class='bx bxl-pinterest' ></i></span>
        </div>
      </div>
    </footer>


  

  </body>
  <script>
  document.getElementById('imageUpload').addEventListener('change', function(event) {
    const [file] = event.target.files;
    if (file) {
      const preview = document.getElementById('imagePreview');
      preview.src = URL.createObjectURL(file);
      preview.style.display = 'block';
    }
  });
</script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/Glide.js/3.4.1/glide.min.js"></script>
  <script src="./js/slider.js"></script>
  <script src="./js/index.js"></script>
</html>
