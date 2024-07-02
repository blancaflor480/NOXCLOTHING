<?php
session_start();

// Check if session email exists
if (!isset($_SESSION['email'])) {
    header("Location: index.php?error=Login%20First");
    exit();
}

// Include database connection
include 'dbconn/conn.php';

// Get the user email from session
$email = $_SESSION['email'];

// Prepare and execute statement to fetch user data
$stmt = $conn->prepare("SELECT * FROM customer WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $user_id = $user['id'];
} else {
    header("Location: login-signup.php?error=Login%20First");
    exit();
}

$_SESSION['user_id'] = $user_id;

// Handle AJAX request for updating quantity
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'updateQuantity') {
    $productId = $_POST['productId'];
    $quantity = intval($_POST['quantity']);

    if ($quantity < 1) {
        $quantity = 1;
    }

    // Check if the product exists in the cart for this user
    $stmt = $conn->prepare("SELECT id FROM addcart WHERE customer_id = ? AND products_id = ?");
    $stmt->bind_param("ii", $user_id, $productId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Product exists, update the quantity
        $stmt = $conn->prepare("UPDATE addcart SET quantity = ? WHERE customer_id = ? AND products_id = ?");
        $stmt->bind_param("iii", $quantity, $user_id, $productId);
        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "Quantity updated successfully."]);
        } else {
            echo json_encode(["success" => false, "message" => "Failed to update quantity.", "error" => $stmt->error]);
        }
    } else {
        // Product does not exist in the cart, return an error
        echo json_encode(["success" => false, "message" => "Product not found in the cart."]);
    }
    $stmt->close();
    exit();
}
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

    <title>NOX CLOTHING | Cart</title>

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
            width: 95%;
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
    width: 85%; /* Adjust width as needed */
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
          <li><a href="About.php">About Us</a></li>
          <li><a href="#">FAQ</a></li>
          <li><a href="contact.php">Contact</a></li>
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
              <a href="About.php" class="nav-link">About</a>
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
            
              <i class="bx bx-heart"></i>
            <a href="wishlist.php" class="icon">
              <span class="d-flex">0</span>
            </a>

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
<div style="margin: auto;position: absolute; left: 220px; top: 150px;">
    <h2><small style="font-size: 1.7rem;">Home > </small>Cart</h2>
</div>
    
    <div class="container cart">

        <div class="cart-items">
           <table style="background-color:#F2F4F4;">
    <tr>
        <th></th>
        <th>Product</th>
        <th>Variation</th>
        <th>Quantity</th>
        <th style="text-align: center;">Unit Price</th>
        
    </tr>
    <?php
    $totalItems = 0;
    $totalPrice = 0.00;

    $sql = "SELECT addcart.*, products.price AS product_price, addcart.id AS addcartId, addcart.price AS cart_price, products.name_item, products.image_front, products.discount, products.quantity, addcart.quantity AS qty 
            FROM addcart 
            INNER JOIN products ON addcart.products_id = products.id 
            WHERE addcart.customer_id = ? AND addcart.status != 'Paid'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $totalItems++;
            $unitPrice = $row['cart_price'];
            
            $quantity = $row['qty'];

            // Calculate subtotal and discount
            $subtotal = $unitPrice * $quantity;
            $discount = $row['discount'];
            $discountAmount = ($subtotal * $discount) / 100;
            $discountedSubtotal = $subtotal - $discountAmount;

            $totalPrice += $discountedSubtotal;

            echo "
            <tr>
         <td><input style='width: 15px; height: 15px;' type='checkbox' class='cart-checkbox' value='" . $row['addcartId'] . "' data-product-id='" . $row['addcartId'] . "' /></td>
  
    


                <td>
                    <div class='cart-info'>
                        <img src='../admin/uploads/" . htmlspecialchars($row['image_front']) . "' alt='" . htmlspecialchars($row['name_item']) . "' />
                        <div>
                            <a href='productDetails.php?id=" . $row['products_id'] . "'>
                                <p class='name'><b>" . htmlspecialchars($row['name_item']) . "</b></p>
                            </a>
                            <span class='product-price'>₱" . number_format($unitPrice, 2) . "</span> <br />
                            <a href='javascript:void(0);' onclick='removeFromCart(" . $row['id'] . ")'>remove</a>
                        </div>
                    </div>
                </td>
                <td><a href='productDetails.php?id=" . $row['products_id'] . "'>
                        <p class='name' style='font-size: 1.3rem;'>" . htmlspecialchars($row['color']) . ", " . htmlspecialchars($row['size']) . "</p>
                    </a>
                    <button style='width: 50px; background-color: #222; font-size: 1.2rem; border-radius: 5px; color: white;'>Update</button>
                </td>
                <td>
                    <input type='number' value='" . $quantity . "' min='1' max='" . $row['quantity'] . "' class='quantity' data-product-id='" . $row['id'] . "' />
                </td>


     <td class='subtotal'>"; 
        if ($discount > 0) {
            echo "<span style='text-decoration: line-through;'>₱" . number_format($row['product_price'],2) . "</span> ₱" . number_format($row['cart_price'],2);
        } else {
            echo "₱" . number_format($subtotal, 2);
        }

            echo "</td>
            </tr>";
        }
    } else {
        echo "<tr><td colspan='6' style='text-align: center;'>Your cart is empty.</td></tr>";
        echo "<td colspan='6' style='text-align: center;'><a href='product.php'><input type='button' value='Go to Shop' style='width: 100px; background-color: #222; border-radius: 5px; color: white;'></a></td>";
    }

    // Calculate total discount and final total
    $discountRate = 0.0;
    if ($result && $result->num_rows > 0) {
        $result->data_seek(0);
        $firstRow = $result->fetch_assoc();
        if ($firstRow !== null && array_key_exists('discount', $firstRow)) {
            $discountRate = $firstRow['discount'] / 100;
        }
    }

    $discount = $totalPrice * $discountRate;
    $finalTotal = $totalPrice - $discount;
    ?>
</table>
        </div>
        <div class="order-summary">
            <h3>ORDER SUMMARY</h3>
            <table>            
                <tr>
                    <td>Subtotal</td>
                    <td id="total-price">₱ <?php echo number_format($totalPrice, 2); ?></td>
                </tr>
                <tr>
                    <td>Items</td>
                    <td id="total-items"><input type="hidden" value="<?php echo number_format($totalItems, 2); ?>" name="quantity"> <?php echo $totalItems; ?></td>
                </tr>
                <tr>
                    <td>Discount</td>
                    <td id="discount">₱ <?php echo number_format($row['discount'], 2); ?></td>
                </tr>
                <tr>
                    <td>Total Amount</td>
                    <td id="final-total">₱ <input type="hidden" value="<?php echo number_format($finalTotal, 2); ?>" name="total"><?php echo number_format($finalTotal, 2); ?></td>
                </tr>
            </table>
            <!--<a href="checkout.php" class="checkout">Proceed to Checkout</a>-->
            <form id="checkout-form">
    <input type="submit" style="width: 250px;" class="checkout" value="Proceed to Checkout" <?php if ($totalItems == 0) echo 'disabled'; ?>>
</form>


     
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

 <!-- SweetAlert JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.20/dist/sweetalert2.all.min.js"></script>
  
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
                    // Show SweetAlert if removal is successful
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        position: 'top',
                        text: 'Item removed successfully.',
                        showConfirmButton: false,
                        timer: 2000
                    }).then(function() {
                        // Reload the page to reflect changes after successful removal
                        location.reload();
                    });
                } else {
                    // Show SweetAlert if there is an error
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        position: 'top',
                        text: 'Error: ' + this.responseText,
                        showConfirmButton: false,
                        timer: 2000
                    });
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
        var checkboxes = document.querySelectorAll('.cart-checkbox');
        var checkoutButton = document.querySelector('.checkout');

        checkboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                updateOrderSummary();
            });
        });

        checkoutButton.addEventListener('click', function(event) {
            event.preventDefault();
            processCheckout();
        });

        function updateOrderSummary() {
            var totalItems = 0;
            var totalPrice = 0.00;

            checkboxes.forEach(function(checkbox) {
                if (checkbox.checked) {
                    var quantity = parseInt(checkbox.closest('tr').querySelector('.quantity').value);
                    var price = parseFloat(checkbox.closest('tr').querySelector('.product-price').innerText.replace('₱', ''));
                    totalPrice += (quantity * price);
                    totalItems++;
                }
            });

            // Update order summary elements
            var discountRate = 0.1; // Assuming a 10% discount rate
            var discount = totalPrice * discountRate;
            var finalTotal = totalPrice - discount;

            document.getElementById("total-items").innerText = totalItems;
            document.getElementById("total-price").innerText = "₱" + totalPrice.toFixed(2);
            document.getElementById("discount").innerText = "₱" + discount.toFixed(2);
            document.getElementById("final-total").innerText = "₱" + finalTotal.toFixed(2);

            checkoutButton.disabled = (totalItems === 0);
        }

        function processCheckout() {
            var selectedItems = [];

            checkboxes.forEach(function(checkbox) {
                if (checkbox.checked) {
                    selectedItems.push(checkbox.dataset.productId); // Corrected to use dataset.productId
                }
            });

            if (selectedItems.length > 0) {
                // Send an AJAX request to insert_checkout.php with selected items
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'function/insert_checkout.php', true);
                xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        console.log(xhr.responseText); // Handle the response if needed
                        var response = JSON.parse(xhr.responseText);
                        if (response.success) {
                            alert("Items inserted into checkout successfully.");
                            // Redirect to another page or update the UI as needed
                        } else {
                            alert("Failed to insert items into checkout.");
                        }
                    }
                };

                xhr.send(JSON.stringify({ selectedItems: selectedItems }));
            } else {
                alert("No items selected for checkout.");
            }
        }
    });
</script>



<script>
document.addEventListener("DOMContentLoaded", function() {
    // Function to update the order summary based on quantity changes
    function updateOrderSummary() {
        var quantities = document.querySelectorAll(".quantity");
        var totalItems = 0;
        var totalPrice = 0.00;

        quantities.forEach(function(quantityInput) {
            var quantity = parseInt(quantityInput.value);
            var productId = quantityInput.dataset.productId;
            var price = parseFloat(quantityInput.closest("tr").querySelector(".product-price").innerText.replace('₱', ''));
            var maxQuantity = parseInt(quantityInput.getAttribute('max'));

            // Validate quantity against max stock
            if (quantity < 1) {
                quantityInput.value = 1;
            } else if (quantity > maxQuantity) {
                alert('Maximum available quantity is ' + maxQuantity);
                quantityInput.value = maxQuantity;
            }

            totalItems += quantity;
            totalPrice += (quantity * price);
        });

        // Update order summary elements
        var discountRate = 0.1; // Assuming a 10% discount rate
        var discount = totalPrice * discountRate;
        var finalTotal = totalPrice - discount;

        document.getElementById("total-items").innerText = totalItems;
        document.getElementById("total-price").innerText = "₱" + totalPrice.toFixed(2);
        document.getElementById("discount").innerText = "₱" + discount.toFixed(2);
        document.getElementById("final-total").innerText = "₱" + finalTotal.toFixed(2);
    }

    // Add event listeners to all quantity input fields
    var quantityInputs = document.querySelectorAll(".quantity");
    quantityInputs.forEach(function(input) {
        input.addEventListener("change", function() {
            updateOrderSummary();
        });
    });

    // Initial order summary update
    updateOrderSummary();
});
</script>
<script>
        // Update quantity via AJAX
        document.querySelectorAll('.quantity-input').forEach(input => {
            input.addEventListener('change', function() {
                const productId = this.dataset.productId;
                const quantity = this.value;

                fetch('cart.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams({
                        action: 'updateQuantity',
                        productId: productId,
                        quantity: quantity
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire('Success', data.message, 'success').then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire('Error', data.message, 'error');
                    }
                })
                .catch(error => {
                    Swal.fire('Error', 'Failed to update quantity.', 'error');
                });
            });
        });

        // Handle checkout button click
        document.getElementById('checkoutButton').addEventListener('click', function(event) {
            const checkboxes = document.querySelectorAll('.cart-checkbox:checked');
            if (checkboxes.length === 0) {
                event.preventDefault();
                Swal.fire('Warning', 'Please select at least one item to checkout.', 'warning');
            }
        });
    </script>

<script>
        document.querySelectorAll('.quantity').forEach(item => {
    item.addEventListener('input', event => {
        let quantity = event.target.value;
        let maxQuantity = parseInt(event.target.getAttribute('max'));
        let productId = event.target.dataset.productId;

        if (quantity < 1) {
            alert('Quantity must be at least 1');
            event.target.value = 1;
            return;
        } else if (quantity > maxQuantity) {
            alert('Maximum available quantity is ' + maxQuantity);
            event.target.value = maxQuantity;
            return;
        }

        fetch('function/update_addcart.php', {
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
  </body>
</html>
