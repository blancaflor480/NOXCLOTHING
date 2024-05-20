<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: index.php?error=Login%20First");
    exit();
}

// Include the database connection
include 'dbconn/conn.php';

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
</head>
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
                <a href="login.html" class="icon"><i class="bx bx-user"></i></a>
                <div class="icon"><i class="bx bx-search"></i></div>
                <div class="icon"><i class="bx bx-heart"></i><span class="d-flex">0</span></div>
                <a href="cart.html" class="icon"><i class="bx bx-cart"></i><span class="d-flex">0</span></a>
            </div>
            <div class="hamburger"><i class="bx bx-menu-alt-left"></i></div>
        </div>
    </div>

    <!-- Product Details -->
<section class="section product-detail">
    <div class="details container">
        <div class="left image-container">
            <div class="main">
                <img src="../admin/uploads/<?php echo htmlspecialchars($product['image_front']); ?>" id="zoom" alt="Product Image"/>
            </div>
        </div>
        <div class="right">
            <span>Home/<?php echo htmlspecialchars($product['category']); ?></span>
            <h1><?php echo htmlspecialchars($product['name_item']); ?></h1>
            <div class="price">₱<?php echo number_format($product['price'], 2); ?></div>
            
            <!-- First Form (Size Selection) -->
            <form id="select-form">
                <div class="select-container" style="margin-left: 210px;">
                <span >
                    <select id="select-size" name="size">
                        <option>Select Size</option>
                        <option value="small">Small</option>
                        <option value="medium">Medium</option>
                        <option value="large">Large</option>
                    </select>
                    <span class="select-icon"><i class="bx bx-chevron-down"></i></span>
                </span>
                </div>
            </form><br><br>
            
            <!-- Second Form (Add to Cart) -->
            <form class="form">
                <input type="number" placeholder="1" style="width: 50px;" min="1" max="<?php echo $product['quantity']; ?>"/>
                <a href="cart.html" class="addCart">Add To Cart</a>
            </form>
            
            <h3>Product Detail</h3>
            <p><?php echo htmlspecialchars($product['description']); ?></p>
        </div>
    </div>
</section>
    <!-- Related Products -->
    <section class="section featured">
        <div class="top container">
            <h1>Related Products</h1>
            <a href="#" class="view-more">View more</a>
        </div>
        <div class="product-center container">
           <div class="product-item">
          <div class="overlay">
            <a href="" class="product-thumb">
              <img src="./images/product-5.jpg" alt="" />
            </a>
          </div>
          <div class="product-info">
            <span>MEN'S CLOTHES</span>
            <a href="">Concepts Solid Pink Men’s Polo</a>
            <h4>$150</h4>
          </div>
          <ul class="icons">
            <li><i class="bx bx-heart"></i></li>
            <li><i class="bx bx-search"></i></li>
            <li><i class="bx bx-cart"></i></li>
          </ul>
        </div>
        <div class="product-item">
          <div class="overlay">
            <a href="" class="product-thumb">
              <img src="./images/product-2.jpg" alt="" />
            </a>
            <span class="discount">40%</span>
          </div>
          <div class="product-info">
            <span>MEN'S CLOTHES</span>
            <a href="">Concepts Solid Pink Men’s Polo</a>
            <h4>$150</h4>
          </div>
          <ul class="icons">
            <li><i class="bx bx-heart"></i></li>
            <li><i class="bx bx-search"></i></li>
            <li><i class="bx bx-cart"></i></li>
          </ul>
        </div>
        <div class="product-item">
          <div class="overlay">
            <a href="" class="product-thumb">
              <img src="./images/product-7.jpg" alt="" />
            </a>
          </div>
          <div class="product-info">
            <span>MEN'S CLOTHES</span>
            <a href="">Concepts Solid Pink Men’s Polo</a>
            <h4>$150</h4>
          </div>
          <ul class="icons">
            <li><i class="bx bx-heart"></i></li>
            <li><i class="bx bx-search"></i></li>
            <li><i class="bx bx-cart"></i></li>
          </ul>
        </div>
        <div class="product-item">
          <div class="overlay">
            <a href="" class="product-thumb">
              <img src="./images/product-4.jpg" alt="" />
            </a>
            <span class="discount">40%</span>
          </div>
          <div class="product-info">
            <span>MEN'S CLOTHES</span>
            <a href="">Concepts Solid Pink Men’s Polo</a>
            <h4>$150</h4>
          </div>
          <ul class="icons">
            <li><i class="bx bx-heart"></i></li>
            <li><i class="bx bx-search"></i></li>
            <li><i class="bx bx-cart"></i></li>
          </ul>
        </div>
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
