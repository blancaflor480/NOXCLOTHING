<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: index.php?error=Login%20First");
    exit();
}

// Include the database connection file
include 'dbconn/conn.php';

// Get the email from the session
$email = $_SESSION['email'];

// Prepare a statement to fetch user details
$stmt = $conn->prepare("SELECT * FROM customer WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

// Check if user details were found
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $user_id = $user['id']; // Get the user ID
} else {
    header("Location: login-signup.php?error=Login%20First");
    exit();
}

// Process the checkout form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Fetch the voucher code if provided
    $voucher_code = isset($_POST['voucher']) ? $_POST['voucher'] : null;
    
    $payment_method = $_POST['paymentMethod'];
    
    // Prepare the query to get the cart items for the user
    $query = "SELECT addcart.*, products.price AS product_price, products.discount
              FROM addcart
              INNER JOIN products ON addcart.products_id = products.id
              WHERE addcart.customer_id = ? AND addcart.status != 'Paid'";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Variables to calculate total amount
    $total_amount = 0.00;
    $order_date = date('Y-m-d');
    
    // Insert each cart item into the orders table
    while ($row = $result->fetch_assoc()) {
        $addcart_id = $row['id'];
        $products_id = $row['products_id'];
        $quantity = $row['quantity'];
        $color = $row['color'];
        $size = $row['size'];
        $price = $row['product_price'];
        $discount = $row['discount'];
        
        // Calculate the total amount for this item
        $item_total = ($price - $discount) * $quantity;
        $total_amount += $item_total;
        
        // Insert into the orders table
        $stmt = $conn->prepare("INSERT INTO orders (customer_id, products_id, addcart_id, innovoice, price, quantity, color, size, voucher_id, status, total_amount, order_date)
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'Pending', ?, ?)");
        $innovoice = rand(1000, 9999); // Generate a random invoice number
        $voucher_id = null; // Assume no voucher ID, you can handle voucher application separately
        
        // Bind parameters and execute the statement
        $stmt->bind_param("iiiidississ", $user_id, $products_id, $addcart_id, $innovoice, $price, $quantity, $color, $size, $voucher_id, $total_amount, $order_date);
        $stmt->execute();
    }

    // After inserting the orders, update the status of the cart items to 'Paid'
    $stmt = $conn->prepare("UPDATE addcart SET status = 'Paid' WHERE customer_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();

    // Redirect to a success page or order confirmation page
    header("Location: order_confirmation.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    
    <!-- Box icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

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
         
      <div class="card mt-5" style="background-color: #FEF9E7;">
          
      <div class="card-body">
      <h2 class="md-3 text-left" style="margin: 8px; font-weight: bold;"><i class="fas fa-map-marker-alt"></i> Delivery Address </h2>
      <span style="font-size: 1.3rem; color:blue; margin-top: -30px;">Change</span>
      <div class="row mt-4">
      <h5 class="col-5 mt-" style="margin: 8px; "><b>Customer:</b> <?php echo htmlspecialchars($user['fname']. ' ' . $user['mname'] . ' ' . $user['lname']); ?></h5>
          <h5 class="col-5 mt-3" style="margin: 8px; "><b>Email:</b> <?php echo htmlspecialchars($user['email']); ?></h5>
          <h5 class="col-5 mt-3" style="margin: 8px; "><b>Contact:</b> <?php echo htmlspecialchars($user['contactnumber']); ?></h5>
          <h5 class="col-5 mt-3" style="margin: 8px; ">
          <b>Address:</b> <?php echo htmlspecialchars($user['region'] . ', ' . $user['province'] . ', ' . $user['city'] . ', ' . $user['zipcode'] . ', ' . $user['barangay'] . ' ' . $user['street']); ?>
</h5>
          </div>
  </div>
</div>
          
<div class="card mt-3">
        <div class="card-body">
            <div class="row mt-2" style="background-color: white;">
                <div class="col-lg-9 mt-2">
                    <label for="voucher" id="form-label" style="margin: 8px; font-weight: bold;">
                        <h2 style="font-weight: bold;"><i class="fa fa-ticket" aria-hidden="true"></i> Voucher Code</h2>
                    </label>
                    <div class="input-group mt-2" style="margin: 8px;">
                        <input type="text" id="voucher" class="form-control pd-3" placeholder="Enter your code">
                        <button class="btn btn-primary btn-redeem" style="height: 45px;">Redeem</button>
                    </div>
                </div>
            </div>
        </div>
    </div>          


    <div class="card mt-3">
                        <div class="card-body">
                            <div class="row mt-2" style="background-color: white;">
                                <h2 style="margin: 8px; font-weight: bold;"><i class="fas fa-receipt"></i> Payment Methods</h2>
                                <div class="form-check col-md-3 mt-3">
                                    <input type="radio" id="creditcard" name="paymentMethod" value="Credit Card" onclick="showPopup('Credit Card')">
                                    <label for="creditcard" id="form-label">Credit Card</label>
                                </div>
                                <div class="form-check col-md-3 mt-3">
                                    <input type="radio" id="cashondelivery" name="paymentMethod" value="Cash on Delivery" onclick="showPopup('Cash on Delivery')">
                                    <label for="cashondelivery" id="form-label">Cash on delivery</label>
                                </div>
                                <div class="form-check col-md-4 mt-3 mb-3">
                                    <input type="radio" id="gcash" name="paymentMethod" value="G-Cash" onclick="showPopup('G-Cash')">
                                    <label for="gcash" id="form-label">G-Cash</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="creditCardInput" class="card mt-3" style="display: none;">
                        <div class="card-body">
                            <h4 class="text-left mb-3">CREDIT CARD DETAILS</h4>
                            <div class="row mt-4">
                                <div class="col-lg-6 mt-2">
                                    <div class="form-floating">
                                        <input type="number" id="creditcardnumber" style="height: 45px;" name="creditcardnumber" class="form-control" placeholder="Credit Card Number">
                                        <label for="creditcardnumber" style="font-size: 1.2rem;">Credit Card Number</label>
                                    </div>
                                </div>
                                <div class="col-lg-6 mt-2">
                                    <div class="form-floating">
                                        <input type="month" id="expirationdate" name="expirationdate" style="height: 45px;" class="form-control" placeholder="Expiration Date">
                                        <label for="expirationdate">Expiration Date</label>
                                    </div>
                                </div>
                                <div class="col-lg-6 mt-2">
                                    <div class="form-floating">
                                        <input type="number" id="cvv" name="cvv" class="form-control" style="height: 45px;" placeholder="CVV">
                                        <label for="cvv" style="font-size: 1.2rem;">CVV</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="gcashInput" class="card mt-3" style="display: none;">
                        <div class="card-body">
                            <h4 class="text-left mb-3">GCASH DETAILS</h4>
                            <div class="row mt-4">
                                <div class="col-lg-6 mt-2">
                                    <div class="form-floating">
                                        <input type="number" id="gcashNumber" name="gcashNumber" style="height: 45px;" class="form-control" placeholder="GCash Number">
                                        <label for="gcashNumber" style="font-size: 1.2rem;">GCash Number</label>
                                    </div>
                                </div>
                                <div class="col-lg-6 mt-2">
                                    <div class="form-floating">
                                        <input type="text" id="gcashName" name="gcashName" style="height: 45px;" class="form-control" placeholder="Account Name">
                                        <label for="gcashName" style="font-size: 1.2rem;">Account Name</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
        </form>
      </div>
      
      <!-- Order Summary Column -->
      <div class="col-lg-4 mt-5">
        <div class="card" style="width: 100%;">
        <div class="card-header" style="background-color: #222831;">
   <h2 style="margin: 10px; font-weight: bold; color: white;" > Order Summary </h2>
  </div>  
        <div class="card-body">
        <ul class="list-group list-group-flush">
        <?php
    // Gumawa ng query para sa order summary
    $query = "SELECT addcart.*, products.price AS product_price, products.name_item, products.discount
    FROM addcart 
    INNER JOIN products ON addcart.products_id = products.id WHERE addcart.customer_id = $user_id";
    $result = mysqli_query($conn, $query);

    // Variable initialization
    $totalPrice = 0.00;
    $totalItems = 0;

    if ($result && mysqli_num_rows($result) > 0) {
        // Loop through each item in the cart
        while ($row = mysqli_fetch_assoc($result)) {
            // Display details of each item
            echo "<li class='list-group-item'>";
            echo "<table>";
            echo "<tr>";
            echo "<td style='font-weight: bold;'>Product: </td>";
            echo "<td> x". $row['quantity'] ." ". $row['name_item'] . "</td>";
            echo "</tr>";
            
            
            echo "<tr>";
            echo "<td style='font-weight: bold;'>Subtotal: </td>";
            echo "<td>₱" . number_format($row['product_price'], 2) . "</td>";
            echo "</tr>";

            echo "<tr>";
            echo "<td style='font-weight: bold;'>Discount: </td>";
            echo "<td>₱" . number_format($row['discount'], 2) . "</td>";
            echo "</tr>";
        
            echo "</table>";
            echo "</li>";

            // Compute subtotal for each item
            $subtotal = $row['quantity'] * $row['product_price'];
            $totalPrice += $subtotal; // Add subtotal to total price
            $totalItems += $row['quantity']; // Increment total items count
        }

        // Display total price and total items
        echo "<li class='list-group-item'>";
        echo "<table>";
        
        echo "<tr>";
        echo "<td>Total Items:</td>";
        echo "<td>$totalItems</td>";
        echo "</tr>";
        
        echo "<td>Total Amount:</td>";
        echo "<td>₱" . number_format($totalPrice, 2) . "</td>";
        
        
        // Add checkout button
        echo "</table>";
        echo "<li style='text-align: center;'>";
        echo "<form action='checkout.php' method='post'>";
        echo "<button type='submit' class='btn btn-primary' style='background-color:#222831; border-color:#222831;
        margin: 10px; width: 90px; height: 45px; font-size: 1.3rem'>Checkout</button>";
         echo "<a href='cart.php'><button type='button' class='btn btn-primary' style='background-color: transparent; color: black; border-color:#222831;
        margin: 10px; width: 90px; height: 45px; font-size: 1.3rem'>Cancel</button></a>";
        echo "</form>";
        echo "<li>";
        
        echo "</li>";
    } else {
        echo "<li>No items in cart.</li>";
    }
?>

                
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
    function showPopup(paymentMethod) {
        // Hide both input sections initially
        document.getElementById('creditCardInput').style.display = 'none';
        document.getElementById('gcashInput').style.display = 'none';

        // Show the relevant input section based on the selected payment method
        if (paymentMethod === 'Credit Card') {
            document.getElementById('creditCardInput').style.display = 'block';
        } else if (paymentMethod === 'G-Cash') {
            document.getElementById('gcashInput').style.display = 'block';
        }
    }
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
