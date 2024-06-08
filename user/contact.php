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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700&display=swap">
    <!-- Custom StyleSheet -->
    <link rel="stylesheet" href="./css/styles.css" />
    <title>Contact</title>
    <style>
      body {
        font-family: Arial, sans-serif;
        background-color: #f9f9f9;
        margin: 0;
      }

      .contact-container {
        display: flex;
        justify-content: space-between;
        background: white;

        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 1200px;
        margin: 20px auto;
      }

      .contact-section {
        width: 49%;
        padding:2%;
      }

      h1 {
        margin-bottom: 20px;
        font-size: 35px;
        color: #333;
        text-align: center;
      }

      form {
        display: flex;
        flex-direction: column;
      }

      label {
        margin-bottom: 5px;
        font-weight: bold;
      }

      input, textarea {
        margin-bottom: 15px;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 16px;
      }

      button {
        padding: 10px 15px;
        background-color: black;
        border: none;
        border-radius: 4px;
        color: white;
        font-size: 16px;
        cursor: pointer;
      }

      button:hover {
        background-color: gray;
      }

      #responseMessage {
        margin-top: 20px;
        font-size: 16px;
      }
      .contact-details{
  background-color: #4c4c4c;

 }
      .contact-details h3 {
      
        color:  white;
        
      }

      .contact-details h1 {
        margin: 10px 0;
        color:  white;
        
      }
      hr {
    border: none;
    height: 2px;
    background-color: white;
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
?>  <body>
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
        <a href="/" class="logo" style="margin-top: -10px;">
          <h1 style="font-size: 3rem; font-weight: 700;">Nox</h1>
        </a>

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
            <a href="#contact" class="nav-link">Contact</a>
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

    <center>
    &nbsp;
      <h1>Connect with us</h1>
      <div class="contact-container">
        <div class="contact-section">
          <form id="contactForm">
          &nbsp;
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="message">Message:</label>
            <textarea id="message" name="message" rows="5" required></textarea>

            <button type="submit">Submit</button>
          </form>
          <div id="responseMessage"></div>
        </div>

        <div class="contact-section contact-details">
       
            <h1>LET'S CONNECT</h1>

            <hr>
            &nbsp;
            <h3>Email: aubrianachanelle.buyo@cvsu.edu.ph</h3>
            &nbsp;
            <h3>Telephone Number: 456-777-451</h3>
            &nbsp;
            <h3>Mobile Number: 0912345678</h3>
      
        </div>
      </div>
    </center>

    <script>
      document.getElementById('contactForm').addEventListener('submit', function(event) {
        event.preventDefault();

        const name = document.getElementById('name').value.trim();
        const email = document.getElementById('email').value.trim();
        const message = document.getElementById('message').value.trim();
        const responseMessage = document.getElementById('responseMessage');

        if (name && email && message) {
          // dito sana magssend yung message sa server or sa admin pa konek nalang uwu
          responseMessage.style.color = 'green';
          responseMessage.textContent = 'Thank you for your message!';
        } else {
          responseMessage.style.color = 'red';
          responseMessage.textContent = 'Please fill in all fields.';
        }
      });
    </script>

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
  </body>
</html>
