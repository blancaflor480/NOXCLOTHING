
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
    <title>Contact</title>
    <style>
    body {
    font-family: Arial, sans-serif;
    background-color: #f9f9f9;

    height: 100vh;
    margin: 0;
}

.contact-container {
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    width: 800px;
    max-width: 100%;
}



h1 {
    margin-bottom: 20px;
    font-size: 35px;
    color: #333;
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
</style>
  </head>

  <body>
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
  <center>
  &nbsp;
       <b> <h1>Connect with us</h1> </b>

         <div class="contact-container">
        <form id="contactForm">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="message">Message:</label>
            <textarea id="message" name="message" rows="5" required></textarea>

            <button type="submit">Submit</button>
        </form>
        <div id="responseMessage"></div>

     <HR>
        &nbsp;
<b>
        <h1> Contact Details: </h1>
        
        <h2>Email: aubrianachanelle.buyo@cvsu.edu.ph</h2>
        &nbsp; 
        <h2>Telephone Number: 456-777-451</h2>
        &nbsp; 
        <h2>Mobile Number: 0912345678 </h2>
        <HR>
</b>

    </div>
    <script>
    document.getElementById('contactForm').addEventListener('submit', function(event) {
    event.preventDefault();

    const name = document.getElementById('name').value.trim();
    const email = document.getElementById('email').value.trim();
    const message = document.getElementById('message').value.trim();
    const responseMessage = document.getElementById('responseMessage');

    if (name && email && message) {
        // fito sana magssend yung message sa server or sa admin pa konek nalang uwu
        responseMessage.style.color = 'green';
        responseMessage.textContent = 'Thank you for your message!';
    } else {
        responseMessage.style.color = 'red';
        responseMessage.textContent = 'Please fill in all fields.';
    }
});
</script>
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

</body>
</html>