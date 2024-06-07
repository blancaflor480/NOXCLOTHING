<?php
session_start();
include 'dbconn/conn.php';
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Box icons -->
    <link rel="icon" href="images/icon.png"/>
	
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css"
    />
    <!-- Custom StyleSheet -->
    <link rel="stylesheet" href="./css/styles.css" />
    <title>NOX CLOTHING</title>
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
        <a href="/" class="logo"><h1>Nox</h1></a>

          <ul class="nav-list d-flex">
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
              <a href="#about" class="nav-link">About</a>
            </li>
            <li class="nav-item">
              <a href="contact.php" class="nav-link">Contact</a>
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
            <a href="login-signup.php" class="icon">
              <i class="bx bx-user"></i>
            </a>
            <div class="icon">
              <i class="bx bx-search"></i>
            </div>
           <a href="wishlist.php" class="icon">
              <i class="bx bx-heart"></i>
              </a>
            <a href="cart.php" class="icon">
              <i class="bx bx-cart"></i>
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

<!-- All Products -->

<?php
       $stmt = $conn->prepare("SELECT id, name_item, discount, price, image_front, type FROM products WHERE type='female'");
       $stmt->execute();
       $men_products = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        ?>
<section class="section all-products" id="products">
        <div class="top container">
            <h1>Mens Products</h1>
            <form>
                <select id="sortOptions" onchange="redirect()">
					<option value="1">Default Sorting</option>
					<option value="2">Sort By Price</option>
					<option value="3">Sort By Popularity</option>
					<option value="4">Sort By Sale</option>
					<option value="5">Sort By Rating</option>
				</select>

						<script>
						function redirect() {
							var selectedValue = document.getElementById("sortOptions").value;
							if (selectedValue == "1") window.location.href = "product.php";
							else if (selectedValue == "2") window.location.href = "sortbyprice.php";
							else if (selectedValue == "3") window.location.href = "sortbypopularity.php";
							else if (selectedValue == "4") window.location.href = "sortbysale.php";
							else if (selectedValue == "5") window.location.href = "sortbyrating.php";
						}
						</script>


                <span><i class="bx bx-chevron-down"></i></span>
            </form>
        </div>

<div class="product-center">
<?php if (!empty($men_products)): ?>
                <?php foreach ($men_products as $product): ?>
                    <div class="product-item">
                        <div class="overlay">
                            <a href="productDetails.php?id=<?php echo $product['id']; ?>" class="product-thumb">
                                <img src="admin/uploads/<?php echo $product['image_front']; ?>" alt="<?php echo htmlspecialchars($product['name_item']); ?>" />
                            </a>
                            <?php if ($product['discount'] > 0): ?>
                                <span class="discount"><?php echo $product['discount']; ?>%</span>
                            <?php endif; ?>
                        </div>
                        <div class="product-info">
                            <span><?php echo htmlspecialchars($product['type']); ?></span>
                            <a href="productDetails.php?id=<?php echo $product['id']; ?>"><?php echo htmlspecialchars($product['name_item']); ?></a>
                            <h4>Php <?php echo number_format($product['price'], 2); ?></h4>
                        </div>
                        <ul class="icons">
                            <li><i class="bx bx-heart add-to-wishlist" data-product-id="<?php echo $product['id']; ?>"></i></li>
                            <li><i class="bx bx-search"></i></li>
                            <li><i class="bx bx-cart add-to-cart" data-product-id="<?php echo $product['id']; ?>"></i></li>
                        </ul>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No men's products found.</p>
            <?php endif; ?>    
</div>

    </section>

    <section class="pagination">
      <div class="container">
        <span>1</span> <span>2</span> <span>3</span> <span>4</span>
        <span><i class="bx bx-right-arrow-alt"></i></span>
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
  </body>
</html>
