<style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 300px;
            padding: 20px;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            text-align: center;
        }
        .popup p {
            margin-bottom: 20px;
        }
        .btn1 {
            padding: 10px 20px;
            background-color: black;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn1:hover {
            background-color: #0056b3;
        }
        .input-container {
            margin-bottom: 20px;
        }
    </style>

<?php
session_start();

// Check kung may session na itinakda para sa 'email'
if (!isset($_SESSION['email'])) {
    header("Location: index.php?error=Login%20First");
    exit();
}

// Include ng database connection
include 'dbconn/conn.php';

// Kunin ang 'email' mula sa session
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Custom StyleSheet -->
    <link rel="stylesheet" href="./css/styles.css" />
    <title>Your Cart</title>
<style>

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
        <p style="margin-top: 10px">Order Online Or Call Us: (001) 2222-55555</p>
        <ul class="d-flex" style="margin-top: 10px">
          <li><a href="#">About Us</a></li>
          <li><a href="#">FAQ</a></li>
          <li><a href="#">Contact</a></li>
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
              <a href="#about" class="nav-link">About</a>
            </li>
            <li class="nav-item">
              <a href="#contact" class="nav-link">Contact</a>
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

      <section class="section" style="margin-top: -100px">

<div class="container mt-5">
    <h1><small style="font-size: 1.7rem;">Home > </small>Check Out</h1>
    <div class="row">
      <div class="col-lg-8">
        <form novalidate>
          <h5 class="mb-3">Customer</h5>
          <div class="row" style="background-color: white;">
            <div class="col-sm-6">
              <label for="firstname" id="form-label">First name</label>
              <input type="text" id="firstname" class="form-control">
            </div>
            <div class="col-sm-6">
              <label for="lastname" id="form-label">Last name</label>
              <input type="text" id="lastname" class="form-control">
            </div>
            <div class="col-6 mt-2">
              <label for="email" id="form-label">Email</label>
              <input type="text" id="email" class="form-control">
            </div>
            <div class="col-6 mt-2">
              <label for="contactnumber" id="form-label">Contact number</label>
              <input type="text" id="contactnumber" class="form-control">
            </div>
          </div>
          
          <h5 class="mb-3 mt-2">Delivery Address</h5>
          <div class="row" style="background-color: white;">
            <div class="col-md-3">
              <label for="region" id="form-label">Region</label>
              <input type="text" id="region" class="form-control">
            </div>
            <div class="col-md-3">
              <label for="province" id="form-label">Province</label>
              <input type="text" id="province" class="form-control">
            </div>
            <div class="col-md-3">
              <label for="city" id="form-label">City</label>
              <input type="text" id="city" class="form-control">
            </div>
            <div class="col-md-3">
              <label for="postalcode" id="form-label">Postal Code</label>
              <input type="text" id="postalcode" class="form-control">
            </div>
            <div class="col-md-6 mt-2">
              <label for="barangay" id="form-label">Barangay</label>
              <input type="text" id="barangay" class="form-control">
            </div>
            <div class="col-md-6 mt-2">
              <label for="street" id="form-label">Street</label>
              <input type="text" id="street" class="form-control">
            </div>
          </div>
          
          <hr class="my-3">
          <div class="row mt-2" style="background-color: white;">
            <h5 class="mb-3 mt-2">Voucher Code</h5>
            <div class="col-md-6 mt-2">
              <label for="voucher" id="form-label">Voucher Code</label>
              <input type="text" id="voucher" class="form-control">
            </div>
          </div>
          
          <hr class="my-3">
          <div class="row mt-2" style="background-color: white;">
            <h5 class="mb-3 mt-2">Payment Method</h5>

                <div class="form-check col-md-3">
        <input type="radio" id="creditcard" name="paymentMethod" value="Credit Card" onclick="showPopup('Credit Card')">
          <label for="creditcard" id="form-label">Credit Card</label>
    </div>
    
         <div class="form-check col-md-3">
        <input type="radio" id="cashondelivery" name="paymentMethod" value="Cash on Delivery" onclick="showPopup('Cash on Delivery')">
          <label for="cashondelivery" id="form-label">Cash on delivery</label>
    </div>
    
         <div class="form-check col-md-4">
        <input type="radio" id="gcash" name="paymentMethod" value="G-Cash" onclick="showPopup('G-Cash')">
         <label for="gcash" id="form-label">G-Cash</label>
    </div>


    <div id="popup" class="popup">
        <p id="popup-message"></p>
        <div id="input-container" class="input-container"></div>
        <button class="btn" onclick="closePopup()">Close</button>
        <button class="btn" onclick="doneAction()" id="done-btn" style="display:none;">Done</button>
    </div>

    <script>
        function showPopup(option) {
            const popupMessage = document.getElementById('popup-message');
            const inputContainer = document.getElementById('input-container');
            const doneButton = document.getElementById('done-btn');

            if (option === 'Credit Card') {
                popupMessage.textContent = 'Credit Card Number:';
                inputContainer.innerHTML = '<input type="text" placeholder="Enter Credit Card Number">';
                doneButton.style.display = 'inline-block';
            } else if (option === 'G-Cash') {
                popupMessage.textContent = 'Enter Number:';
                inputContainer.innerHTML = '<input type="text" placeholder="Enter G-Cash Number">';
                doneButton.style.display = 'inline-block';
            } else {
                popupMessage.textContent = 'Checkout Complete!';
                inputContainer.innerHTML = '';
                doneButton.style.display = 'none';
            }

            document.getElementById('popup').style.display = 'block';
        }

        function closePopup() {
            document.getElementById('popup').style.display = 'none';
        }

        function doneAction() {
            alert('Checkout Complete!');
            closePopup();
        }
    </script>

          </div>
        </form>
      </div>
      
      <!-- Order Summary Column -->
      <div class="col-lg-4">
        <div class="card" style="width: 100%;">
        <div class="card-header">
   <h2> Order Summary </h2>
  </div>  
        <div class="card-body">
        <ul class="list-group list-group-flush">
            <table>            
                <tr>
                    <td>Subtotal</td>
                    <td id="total-price">₱ <?php echo number_format($totalPrice, 2); ?></td>
                </tr>
                <tr>
                    <td>Items</td>
                    <td id="total-items"><?php echo $totalItems; ?></td>
                </tr>
                <tr>
                    <td>Discount</td>
                    <td id="discount">₱ <?php echo number_format($discount, 2); ?></td>
                </tr>
                <tr>
                    <td>Total Amount</td>
                    <td id="final-total">₱ <?php echo number_format($finalTotal, 2); ?></td>
                </tr>
            </table>
            <center>
            <a href="checkout.php" class="checkout" style= "color: white" , "background-color: black";>Checkout</a>
  </ul>       
    </div>
        </div>
      </div>
    </div>
  </div>
</section>
</center>
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
    // Function to remove item from cart
    function removeFromCart(cartItemId) {
        // Send an AJAX request to the backend to remove the item
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "function/remove_addcart.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
                if (this.responseText === "success") {
                    // Show alert if removal is successful
                    alert("Item removed successfully.");
                    // Reload the page to reflect changes after successful removal
                    location.reload();
                } else {
                    // Show alert if there is an error
                    alert("Error: " + this.responseText);
                }
            }
        };
        xhr.send("cartItemId=" + cartItemId);
    }
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

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        // Function to update the order summary
        function updateOrderSummary() {
            // Get all quantity input elements
            var quantities = document.querySelectorAll(".quantity");
            var totalItems = 0;
            var totalPrice = 0.00;

            quantities.forEach(function(quantityInput) {
                var quantity = parseInt(quantityInput.value);
                var productId = quantityInput.dataset.productId;
                var price = parseFloat(quantityInput.closest("tr").querySelector(".product-price").innerText.replace('₱', ''));

                totalItems += quantity;
                totalPrice += (quantity * price);
            });

            var discountRate = 0.1; // Assuming a 10% discount
            var discount = totalPrice * discountRate;
            var finalTotal = totalPrice - discount;

            // Update the order summary
            document.getElementById("total-items").innerText = totalItems;
            document.getElementById("total-price").innerText = "₱" + totalPrice.toFixed(2);
            document.getElementById("discount").innerText = "₱" + discount.toFixed(2);
            document.getElementById("final-total").innerText = "₱" + finalTotal.toFixed(2);
        }

        // Add event listeners to all quantity input fields
        var quantityInputs = document.querySelectorAll(".quantity");
        quantityInputs.forEach(function(input) {
            input.addEventListener("change", function() {
                if (this.value < 1) {
                    this.value = 1; // Ensure the quantity is at least 1
                }
                updateOrderSummary();
            });
        });

        // Initial order summary update
        updateOrderSummary();
    });
</script>
<script>
        document.querySelectorAll('.quantity').forEach(item => {
            item.addEventListener('input', event => {
                let quantity = event.target.value;
                let productId = event.target.dataset.productId;

                if (quantity < 1) {
                    alert('Quantity must be at least 1');
                    event.target.value = 1;
                    return;
                }

                fetch('update_cart.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `id=${productId}&quantity=${quantity}`,
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        updateCart();
                    } else {
                        alert('Error updating cart');
                    }
                })
                .catch(error => console.error('Error:', error));
            });
        });

        function updateCart() {
            let totalItems = 0;
            let totalPrice = 0.0;

            document.querySelectorAll('.quantity').forEach(item => {
                let quantity = parseInt(item.value);
                let price = parseFloat(item.closest('tr').querySelector('.product-price').textContent.replace('₱', ''));
                let subtotalElement = item.closest('tr').querySelector('.subtotal');
                let subtotal = quantity * price;

                subtotalElement.textContent = `₱${subtotal.toFixed(2)}`;
                totalItems += quantity;
                totalPrice += subtotal;
            });

            let discountRate = 0.1;
            let discount = totalPrice * discountRate;
            let finalTotal = totalPrice - discount;

            document.getElementById('total-items').textContent = totalItems;
            document.getElementById('total-price').textContent = `₱${totalPrice.toFixed(2)}`;
            document.getElementById('discount').textContent = `₱${discount.toFixed(2)}`;
            document.getElementById('final-total').textContent = `₱${finalTotal.toFixed(2)}`;
        }

        
    </script>
    <!-- Custom Script -->
    <script src="./js/index.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

  </body>
</html>
