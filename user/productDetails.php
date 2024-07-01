<?php
session_start();

// Check if a session is set for 'email'
if (!isset($_SESSION['email'])) {
    header("Location: index.php?error=Login%20First");
    exit();
}

// Include the database connection
include 'dbconn/conn.php';

// Get the 'email' from the session
$email = $_SESSION['email'];

// Try to get the result from the query
$stmt = $conn->prepare("SELECT * FROM customer WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

// Ensure there's a result before fetching the data
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $user_id = $user['id']; // Get the 'id' of the user
} else {
    // If not, redirect to login page
    header("Location: login-signup.php?error=Login%20First");
    exit();
}

// Set the 'user_id' in the session to be used on other pages
$_SESSION['user_id'] = $user_id;

// Get the 'id' parameter from the URL
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];
} else {
    // Redirect to homepage if no product ID is provided
    header("Location: index.php");
    exit();
}

// Fetch the product details from the database
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if the product exists
if ($result->num_rows > 0) {
    $product = $result->fetch_assoc();
} else {
    // Redirect to homepage if the product does not exist
    header("Location: index.php?error=Product%20Not%20Found");
    exit();
}

$stmt = $conn->prepare("SELECT size FROM product_sizes WHERE products_id = ?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$inventory_result = $stmt->get_result();
$inventory = [];

while ($row = $inventory_result->fetch_assoc()) {
    $inventory[] = $row['size']; // Collect all sizes into an array
}

$stmt = $conn->prepare("SELECT color FROM product_colors WHERE products_id = ?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$inventory_result = $stmt->get_result();
$inventory_color = [];

// Fetch colors into an array
while ($row = $inventory_result->fetch_assoc()) {
    $inventory_color[] = $row['color'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images/icon.png"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css"/>
    <link rel="stylesheet" href="./css/styles.css"/>
    <title>NOX CLOTHING - <?php echo htmlspecialchars($product['name_item']); ?></title>
    <style>
        .color-container {
            margin-top: 10px;
        }

        .color-options {
            display: flex;
            flex-wrap: wrap;
        }

        .color-label {
            display: flex;
            border: 1px solid #ccc;
            border-radius: 2px;
            margin: 5px;
            padding: 10px 15px;
            cursor: pointer;
            font-size: 1rem;
            width: 70px;
            text-align: left;
            font-weight: 600;
        }

        .color-label input[type="radio"] {
            display: none;
        }

        .color-box {
    display: inline-block;
    width: 13px;
    height: 13px;
    border-radius: 50%;
    margin-right: 10px;
    border: 1px solid #000; /* Border color for visibility */
}

        .color-label:hover {
            border-color: #000;
        }

        .color-label input[type="radio"]:checked + .color-box {
            border: 2px solid #000;
        }

        .color-label.selected {
            border-color: #000;
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
            <a href="index.html" class="logo"><h1>Nox</h1></a>
            <ul class="nav-list d-flex">
                <li class="nav-item"><a href="index.php" class="nav-link">Home</a></li>
                <li class="nav-item"><a href="product.php" class="nav-link">Shop</a></li>
                <li class="nav-item"><a href="#terms" class="nav-link">Terms</a></li>
                <li class="nav-item"><a href="#about" class="nav-link">About</a></li>
                <li class="nav-item"><a href="#contact" class="nav-link">Contact</a></li>
                <li class="icons d-flex">
                    <a href="login.html" class="icon"><i class="bx bx-user"></i></a>
                    <div class="icon"><i class="bx bx-search"></i></div>
                    <div class="icon"><i class="bx bx-heart"></i><span class="d-flex">0</span></div>
                    <a href="cart.html" class="icon"><i class="bx bx-cart"></i><span class="d-flex">0</span></a>
                </li>
            </ul>
            <div class="icons d-flex">
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

            <div class="hamburger"><i class="bx bx-menu-alt-left"></i></div>
        </div>
    </div>


<!-- Product Details -->
<section class="section product-detail" style="background-color: #F5F5F5;">
    <span style="position: absolute; top: 130px; left: 190px; font-size: 1.3rem;" ><a href="index.php">Home</a> > <span style="font-size: 1.5rem; font-weight: bold;"><?php echo htmlspecialchars($product['category']); ?></span></span><br>
    <div class="details container" style="background-color: white; box-shadow: 1px 1px #C9C9C9; border-radius: 5px;  margin-top: -65px; ">
        
    
        <div class="left image-container" style="margin: 10px; border-radius: 10px;">
            <div class="main">
                <img src="../admin/uploads/<?php echo htmlspecialchars($product['image_front']); ?>" id="zoom" alt="Product Image"/>
            </div>
        </div>
        <div class="right">
            <br>
                
            <h2 style="font-size: 3rem;"><?php echo htmlspecialchars($product['name_item']); ?></h2>
            
              
                
                <span style="color: #F1C40F ; font-size: 1.3rem; margin-left: 5px;">
                    <?php
                    // Display stars based on rating
                    $rating = (int)$product['rating'];
                    for ($i = 1; $i <= 5; $i++) {
                        if ($i <= $rating) {
                            echo '<i class="bx bxs-star"></i>';
                        } else {
                            echo '<i class="bx bx-star"></i>';
                        }
                    }
                    ?>
                    <span style="color: black; font-size: 1.3rem;"><?php echo htmlspecialchars($product['rating']); ?> </span>
                    <span style="color: black; font-size: 1.3rem;">Rating</span>
                </span>
            
        <div></div>
    
      
                   <h2 class="price" style="font-size: 2.5rem;color: black;text-decoration: line-through;">₱<?php echo number_format($product['price'], 2); ?></h2><span id="finalPrice" class="price" style="font-size: 2.5rem;">₱ <?php echo htmlspecialchars($product['price']); ?></span>

      <form id="addCartForm" class="form" style="padding: 5px;">
    <input type="hidden" id="basePrice" name="price" value="<?php echo htmlspecialchars($product['price']); ?>"/>
    <input type="hidden" id="discount" name="discount" value="<?php echo htmlspecialchars($product['discount']); ?>"/>

    <br>
    <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['id']); ?>"/>

    <label for="color" style="font-weight: 400;">Color: </label>
    <div class="color-options" style="margin-left: 63px; margin-top: -30px; display: flex; flex-wrap: wrap; gap: 1px;">
        <?php
        $selectedColor = '';
        if (isset($_POST['color'])) {
            $selectedColor = htmlspecialchars(trim($_POST['color']));
        }

        foreach ($inventory_color as $color) {
            $colorName = htmlspecialchars(trim($color));
            $isChecked = ($colorName == $selectedColor);

            echo '<label class="color-label ' . ($isChecked ? 'selected' : '') . '">';
            echo '<input type="radio" name="color" value="' . $colorName . '" ' . ($isChecked ? 'checked' : '') . ' />';
            echo $colorName;
            echo '</label>';
        }
        ?>
    </div>

    <br>
    <div class="select-container" style="margin-left: 0px; display: flex; align-items: center;">
        <label for="size" style="font-weight: 400; margin-right: 10px;">Size: </label>
        <select name="size" id="select-size" style="margin-left: 25px;" required>
            <option value="">Select Size</option>
            <?php foreach ($inventory as $size): ?>
                <option value="<?php echo htmlspecialchars(trim($size)); ?>"><?php echo htmlspecialchars(trim($size)); ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <br>
    <label for="quantity" style="font-weight: 400;">Quantity: </label>
    <input type="number" name="quantity" id="quantityInput" placeholder="1" value="1" style="width: 50px;" min="1" max="<?php echo $product['quantity']; ?>" required/>
    
    <br><br>
    
    
    <br><br>
    <button type="submit" class="addCart" style="border-radius: 5px; padding: 17px; border-color: black; background-color: transparent; color: black;">
        <i class='bx bx-cart'></i> Add To Cart
    </button>
    <button type="button" class="addCart" style="border-radius: 5px; padding: 17px; width: 100px; margin: 10px;">Buy Now</button>
</form>

            
        </div>
    </div>
<?php 
  // Adjust the query to select featured products, assuming there is a column named 'is_featured'
  $stmt = $conn->prepare("SELECT id, name_item, type, discount, price, image_front FROM products WHERE YEAR(date_insert) = 2024 LIMIT 4 ");
  $stmt->execute();
  $featured = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>
<!-- Product Rating -->
<section class="section product-rating" style="margin-top: -70px;">
    <div class="container" style="background-color: white; box-shadow: 1px 1px #C9C9C9; border-radius: 5px;">
        <br>
        <div style="background-color: #F8F9F9; padding: 15px;">
        <h4 style="font-size: 1.9rem;">Product Description</h4>
        </div>
            <p style="font-size: 1.5rem; padding: 15px;"><?php echo htmlspecialchars($product['description']); ?></p>
        
    </div>
</section>
<section class="section product-rating" style="margin-top: -130px;">
    <div class="container" style="background-color: white; box-shadow: 1px 1px #C9C9C9; border-radius: 5px;">
        <br>
        <div style="background-color: #F8F9F9; padding: 15px;">
        <h4 style="font-size: 1.9rem;">Product Ratings</h4>
        </div>
        <span style="color: black; font-size: 3rem; margin-left: 10px; margin-top: -10px"><?php echo htmlspecialchars($product['rating']); ?> /5</span><br>
        <span style="color: #F1C40F ; font-size: 3rem; margin-left: 5px;">
                    <?php
                    // Display stars based on rating
                    $rating = (int)$product['rating'];
                    for ($i = 1; $i <= 5; $i++) {
                        if ($i <= $rating) {
                            echo '<i class="bx bxs-star"></i>';
                        } else {
                            echo '<i class="bx bx-star"></i>';
                        }
                    }
                    ?>
                    <br>
                    <span style="color: black; font-size: 1.3rem; margin-left: 10px;">Rating</span>
                </span>
            <p style="font-size: 1.5rem; padding: 15px;"><?php echo htmlspecialchars($product['description']); ?></p>
        
    </div>
</section>

</section>



    <!-- Related Products -->
    <section class="section featured">
        <div class="top container">
            
            <h1>Related Products</h1>
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
        <h4>Php<?php echo $product['price']; ?></h4>
      </div>
      <ul class="icons">
        <li><i class="bx bx-heart add-to-wishlist" data-product-id="<?php echo $product['id']; ?>"></i></li>
        <li><i class="bx bx-search"></i></li>
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
    <!-- Custom Script -->
    <script>
document.addEventListener('DOMContentLoaded', function() {
    var basePrice = parseFloat(document.getElementById('basePrice').value);
    var discount = parseFloat(document.getElementById('discount').value);
    var finalPriceElement = document.getElementById('finalPrice');

    function updatePrice() {
        var finalPrice = basePrice - (basePrice * discount / 100);
        finalPriceElement.textContent = finalPrice.toFixed(2);
    }

    updatePrice();
});
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
    // Kunin ang lahat ng label ng kulay
    var colorLabels = document.querySelectorAll('.color-label');

    colorLabels.forEach(function(label) {
        label.addEventListener('click', function() {
            // I-clear ang 'selected' class sa lahat ng label
            colorLabels.forEach(function(label) {
                label.classList.remove('selected');
            });

            // I-set ang 'selected' class sa piniling label
            this.classList.add('selected');

            // Makipag-ugnay sa input[type="radio"] para sa pagpili ng kulay
            var radio = this.querySelector('input[type="radio"]');
            radio.checked = true;
        });
    });
});

</script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var addCartForm = document.getElementById("addCartForm");

            addCartForm.addEventListener("submit", function(event) {
                event.preventDefault(); // Prevent the default form submission

                var formData = new FormData(addCartForm); // Create a FormData object

                var xhr = new XMLHttpRequest();
                xhr.open("POST", "function/addcart_details.php", true); // Send the form data to your PHP script

                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        var response = JSON.parse(xhr.responseText);
                        if (response.success) {
                            alert(response.message); // Display success message
                            updateCartIndicator();
                        } else {
                            alert(response.message); // Display error message
                        }
                    }
                };

                xhr.send(formData); // Send the FormData object
            });

            function updateCartIndicator() {
                var xhr = new XMLHttpRequest();
                xhr.open("GET", "function/getcartcount.php", true); // Fetch the updated cart count

                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        var cartCount = xhr.responseText;
                        var cartIndicator = document.querySelector("#count");
                        cartIndicator.innerText = cartCount; // Update the cart indicator
                    }
                };

                xhr.send();
            }
        });
    </script>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    var addToWishlistButtons = document.querySelectorAll(".add-to-wishlist");

    addToWishlistButtons.forEach(function(button) {
        button.addEventListener("click", function() {
            var productId = this.dataset.productId;
            addToWishlist(productId);
        });
    });

    function addToWishlist(productId) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "function/addtowhishlist.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                if (response.success) {
                    alert(response.message);
                    updateWishlistIndicator();
                } else {
                    alert(response.message);
                }
            }
        };

        var data = "productId=" + productId;
        xhr.send(data);
    }

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
    <script src="./js/index.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.0.min.js" integrity="sha384-JUMjoW8OzDJw4oFpWIB2Bu/c6768ObEthBMVSiIx4ruBIEdyNSUQAjJNFqT5pnJ6" crossorigin="anonymous"></script>
    <script src="./js/zoomsl.min.js"></script>
    <script>
        $(function () {
            $("#zoom").imagezoomsl({ zoomrange: [4, 4] });
        });
    </script>
</body>
</html>
