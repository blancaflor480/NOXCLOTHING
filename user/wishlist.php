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
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Box icons -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css"
    />
    <!-- Custom StyleSheet -->
    <link rel="stylesheet" href="./css/styles.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.20/dist/sweetalert2.min.css">

    <title>Your Cart</title>

        <style>
        .cart-container {
            width: 80%;
            margin: 50px auto;
            background: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .cart-info {
            display: flex;
            align-items: center;
        }
        .cart-info img {
            width: 100px;
            height: auto;
            margin-right: 20px;
        }
        .cart-info div {
            flex-grow: 1;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table th, table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        table th {
            background-color: #222831;
            color: #fff;
        }
        .checkout {
            display: inline-block;
            padding: 10px 20px;
            background: #222831;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
        .checkout:hover {
            background: #444;
        }
        .container.cart {
    display: flex;
    justify-content: space-between;
}

.container.cart .cart-items {
    width: 100%; /* Adjust width as needed */
}

.container.cart .order-summary {
    width: 30%; /* Adjust width as needed */
    background-color: whitesmoke;
    padding: 15px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
}

.container.cart .order-summary table {
    width: 100%;
}

.container.cart .order-summary table td {
    padding: 15px;
    text-align: left;
}

.container.cart .order-summary .checkout {
    display: block;
    padding: 10px 20px;
    color: #fff;
    text-decoration: none;
    border-radius: 5px;
    margin-top: 20px;
    text-align: center;
}
.product-price{
    display: none;
}
.name{
    color: black;
    font-size: 1.6rem;
}
.btn-add{
  background-color: #3498DB;
  font-size: 2.5rem;
 color: white;
 border: none;
 border-radius: 5px;
width: 60px;
}
.btn-remove{
  background-color: #EC7063;
  font-size: 2.5rem;
  color: white;
  border: none;
border-radius: 5px;
width: 60px;

}

    </style>
  </head>
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
    <!-- Navigation -->
    <div class="top-nav">
      <div class="container d-flex">
        <p>Order Online Or Call Us: (001) 2222-55555</p>
        <ul class="d-flex">
          <li><a href="#">About Us</a></li>
          <li><a href="#">FAQ</a></li>
          <li><a href="#">Contact</a></li>
        </ul>
      </div>
    </div>
    <div class="navigation">
        <div class="nav-center container d-flex">
        <a href="/" class="logo"><h1>Nox</h1></a>

          <ul class="nav-list d-flex">
            <li class="nav-item">
              <a href="index.php" class="nav-link">Home</a>
            </li>
            <li class="nav-item">
              <a href="product.php" class="nav-link">Shop</a>
            </li>
            <li class="nav-item">
              <a href="#about" class="nav-link">About</a>
            </li>
            <li class="nav-item">
              <a href="#contact" class="nav-link">Contact</a>
            </li>
            <li class="icons d-flex">
            <a href="login-signup.php" class="icon">
              <i class="bx bx-user"></i>
            </a>
            <div class="icon">
              <i class="bx bx-search"></i>
            </div>
            <div class="icon">
              <i class="bx bx-heart"></i>
              <span class="d-flex">0</span>
            </div>
            <a href="cart.php" class="icon">
              <i class="bx bx-cart"></i>
              <span class="d-flex">0</span>
            </a>
          </li>
          </ul>

          <div class="icons d-flex">
           <a href="profile.php" class="icon">
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

    <!-- Cart Items -->
<!-- Cart Items -->
    <div class="container cart">

        <div class="cart-items">
            <table>
                <tr>
                    <th>Product</th>
                    <th>Unit Price</th>
                    <th>Action</th>
                    
                </tr>
   <?php
                $sql = "SELECT wishlist.*, products.price AS product_price, products.name_item, products.image_front 
                        FROM wishlist 
                        INNER JOIN products ON wishlist.products_id = products.id 
                        WHERE wishlist.customer_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $user_id);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "
                        <tr>
                            <td>
                                <div class='cart-info'>
                                    <img src='./images/" . htmlspecialchars($row['image_front']) . "' alt='" . htmlspecialchars($row['name_item']) . "' />
                                    <div>
                                        <a href='productDetails.php?id=" . $row['products_id'] . "'>
                                            <p class='name'><b>" . htmlspecialchars($row['name_item']) . "</b></p>
                                        </a>
                                    </div>
                                </div>
                            </td>
                            <td class='subtotal'>₱" . htmlspecialchars($row['product_price']) . "</td>
                            <td>
                                <button class='btn-add' style='background-color: black;' data-product-id='" . $row['products_id'] . "'>
                                    <i class='bx bx-cart-add'></i>
                                </button> 
                                <button class='btn-remove' style='background-color: transparent; color:red; border-color: black;' data-wishlist-id='" . $row['id'] . "'>
                                    <i class='bx bx-trash'></i>
                                </button>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'><center>Your wishlist is empty.</center></td></tr>";
                }
                ?>



            </table>
        </div>
    </div>

<!-- Featured -->
<?php 
  // Adjust the query to select featured products, assuming there is a column named 'is_featured'
  $stmt = $conn->prepare("SELECT id, name_item, type, discount, price, image_front FROM products WHERE YEAR(date_insert) = 2024 LIMIT 4 ");
  $stmt->execute();
  $featured = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>

    <!-- Latest Products -->
    <section class="section featured">
      <div class="top container">
        <h1>Latest Products</h1>
        <a href="#" class="view-more">View more</a>
      </div>
      <div class="product-center">
    <?php foreach ($featured as $product): ?>
    <div class="product-item">
      <div class="overlay">
        <a href="productDetails.php?id=<?php echo $product['id']; ?>" class="product-thumb">
          <img src="./images/<?php echo $product['image_front']; ?>" alt="<?php echo $product['name_item']; ?>" />
        </a>
        <?php if ($product['discount'] > 0): ?>
        <span class="discount"><?php echo $product['discount']; ?>%</span>
        <?php endif; ?>
      </div>
      <div class="product-info">
        <span><?php echo $product['type']; ?></span>
        <a href="productDetails.php?id=<?php echo $product['id']; ?>"><?php echo $product['name_item']; ?></a>
        <h4>$<?php echo $product['price']; ?></h4>
      </div>
      <ul class="icons">
        <li><i class="bx bx-heart add-to-wishlist" data-product-id="<?php echo $product['id']; ?>"></i></li>
        <li><i class="bx bx-cart add-to-cart" data-product-id="<?php echo $product['id']; ?>"></i></li>
      </ul>
    </div>
    <?php endforeach; ?>
  </div>
    </section>

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
          <span><i class="bx bxl-facebook-square"></i></span>
          <span><i class="bx bxl-instagram-alt"></i></span>
          <span><i class="bx bxl-github"></i></span>
          <span><i class="bx bxl-twitter"></i></span>
          <span><i class="bx bxl-pinterest"></i></span>
        </div>
      </div>
    </footer>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.20/dist/sweetalert2.all.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Function to remove item from wishlist
        function removeFromWishlist(wishlistId) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "function/remove_wishlist.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message,
                            position: 'top',
                            showConfirmButton: false,
                            timer: 2000
                        }).then(function() {
                        // Reload the page to reflect changes after successful removal
                        location.reload();
                    });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message,
                            position: 'top',
                            showConfirmButton: false,
                            timer: 2000
                        });
                    }
                }
            };

            var data = "wishlistId=" + wishlistId;
            xhr.send(data);
        }
 
        // Event listener for remove buttons
        var removeButtons = document.querySelectorAll(".btn-remove");
        removeButtons.forEach(function(button) {
            button.addEventListener("click", function() {
                var wishlistId = this.dataset.wishlistId;
                removeFromWishlist(wishlistId);
            });
        });

        // Function to move item from wishlist to cart
        function moveToCart(productId) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "function/move_cart.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message,
                            position: 'top',
                            showConfirmButton: false,
                            timer: 2000
                        }).then(function() {
                        // Reload the page to reflect changes after successful removal
                        location.reload();
                    });
                        updateWishlistIndicator();
                        updateCartIndicator();
                         // Reload page to reflect changes
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message,
                            position: 'top',
                            showConfirmButton: false,
                            timer: 2000
                        });
                    }
                }
            };

            var data = "productId=" + productId;
            xhr.send(data);
        }

        // Event listener for add to cart buttons
        var addToCartButtons = document.querySelectorAll(".btn-add");
        addToCartButtons.forEach(function(button) {
            button.addEventListener("click", function() {
                var productId = this.dataset.productId;
                moveToCart(productId);
            });
        });

        // Function to update wishlist indicator
        function updateWishlistIndicator() {
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "function/getwishlistcount.php", true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var wishlistCount = xhr.responseText;
                    var wishlistIndicator = document.querySelector("#wishlistCount");
                    wishlistIndicator.innerText = wishlistCount;
                }
            };
            xhr.send();
        }

        // Function to update cart indicator
        function updateCartIndicator() {
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "function/getcartcount.php", true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var cartCount = xhr.responseText;
                    var cartIndicator = document.querySelector("#count");
                    cartIndicator.innerText = cartCount;
                }
            };
            xhr.send();
        }
    });
</script>


<script>
        document.addEventListener("DOMContentLoaded", function() {

            var addToCartButtons = document.querySelectorAll(".add-to-cart");

            addToCartButtons.forEach(function(button) {
                button.addEventListener("click", function() {
                    var productId = this.dataset.productId;
                    addToCart(productId);
                });
            });

            function addToCart(productId) {
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "function/addtocart.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        var response = JSON.parse(xhr.responseText);
                        if (response.success) {
                            alert(response.message);
                            updateCartIndicator();
                        } else {
                            alert(response.message);
                        }
                    }
                };

                var data = "productId=" + productId;
                xhr.send(data);
            }

            function updateCartIndicator() {
                var xhr = new XMLHttpRequest();
                xhr.open("GET", "function/getcartcount.php", true);

                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        var cartCount = xhr.responseText;
                        var cartIndicator = document.querySelector("#count");
                        cartIndicator.innerText = cartCount;
                    }
                };

                xhr.send();
            }
        });
    </script>

    
    <!-- Custom Script -->
    <script src="./js/index.js"></script>
  </body>
</html>
