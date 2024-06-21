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
    <title>About</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f9f9f9;
        margin: 0;
      }


.container1 {
    max-width: 1000px;
    margin: 0 auto;
    padding: 20px;
    background-color: #fff;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

header {
    text-align: center;
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 1px solid #ddd;
}

header h1 {
    font-size: 2.5em;
    margin: 0;
}

nav ul {
    list-style: none;
    padding: 0;
}

nav ul li {
    display: inline;
    margin: 0 10px;
}

nav ul li a {
    text-decoration: none;
    color: #007BFF;
}

nav ul li a:hover {
    text-decoration: underline;
}

.section {
    margin: 20px 0;
}

.team-grid {
    display: flex;
    justify-content: space-around;
    flex-wrap: wrap;
}

.team-member {
    text-align: center;
    max-width: 200px;
    margin: 10px;
}

.team-member img {
    max-width: 100%;
    height: auto;
    border-radius: 50%;
    transition: transform 0.3s;
}

.team-member img:hover {
    transform: scale(1.1);
}

.timeline-event {
    background-color: #e9ecef;
    margin: 10px 0;
    padding: 10px;
    border-left: 5px solid #007BFF;
}

footer {
    text-align: center;
    margin-top: 40px;
    font-size: 0.9em;
    color: #666;
    padding-top: 10px;
    border-top: 1px solid #ddd;
}

button {
    padding: 10px 20px;
    font-size: 1em;
    color: white;
    background-color: black;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    margin-top: 10px;
}

button:hover {
    background-color: gray;
}



</style>
  <body>
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
            <a href="contact.php" class="nav-link">Contact</a>
          </li>
        </ul>
        
        <div class="icons d-flex" style="margin-top: -16px;">
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
    <div class="container1">
        <header>
        <center>
            <h1>About Us</h1>
            <nav>
                <ul>
                    <li><a href="#mission">Mission & Vision</a></li>
                    <li><a href="#team">Team</a></li>
                    <li><a href="#history">History</a></li>
                </ul>
            </nav>
        </header>
        <section id="mission" class="section">
          <b>  <h2 style: align="center";>Our Mission</h2> 
           
      
          <p>Nox Clothing aims to deliver stylish, high-quality clothing and accessories to fashion-forward individuals. Developed by talented students at Cavite State University Imus Campus, we are committed to innovation, sustainability, and excellence.</p>
          &nbsp;
           <h2 style: align="center";>Our Vision</h2> 
          <p>Nox Clothing aims to revolutionize the online fashion industry by providing a seamless, personalized shopping experience that celebrates individuality and sustainability. We envision a world where fashion is accessible, inclusive, and eco-friendly, empowering our customers to express their unique style confidently and responsibly.</p>
       
      </section></b> 
        <section id="team" class="section">
        <b>  <h2 style: align="center";>Meet Our Team</h2> 
        &nbsp;
            <div class="team-grid">
                <div class="team-member">
        
                    <h3>Jade Bryan Blancaflor</h3>
                    <p>3rd year IT Student from CVSU- Imus Campus</p>
                    <p>Full Stack Developer</p>
                </div>
                <div class="team-member">
      
                    <h3>Aubriana Chanelle Buyo</h3>
                    <p>3rd year IT Student from CVSU- Imus Campus</p>
                    <p>Front end Developer</p>
                </div>
                <div class="team-member">
          
                    <h3>Ma. Angelico Rubrico</h3>
                    <p>3rd year IT Student from CVSU- Imus Campus</p>
                    <p>Front end Developer</p>
                </div>

                <div class="team-member">
           
                    <h3>Elijah Gabriel Divosion</h3>
                    <p>3rd year IT Student from CVSU- Imus Campus</p>
                    <p>Front end Developer</p>
                </div>

                <div class="team-member">
                
                    <h3>Christian Job Trio</h3>
                    <p>3rd year IT Student from CVSU- Imus Campus</p>
                    <p>Back end Developer</p>
                    <p></p>
                </div>
            </div>
        </section>
</center>
        <section id="history" class="section">
            <h2>Our History</h2>
            <p>Since our founding in February 2024, we have continuously evolved to meet the changing needs of our customers.</p>
            <button onclick="toggleTimeline()">Read More</button>
            <div id="timeline" style="display:none;">
                <div class="timeline-event">
                    <h3>2024</h3>
                    <p>Company founded with a vision to revolutionize the industry.</p>
                </div>
           
            </div>
        </section>
        <footer>
            <p>&copy; 2024 Our Company. All rights reserved.</p>
        </footer>
    </div>
    <script>function toggleTimeline() {
    var timeline = document.getElementById("timeline");
    if (timeline.style.display === "none") {
        timeline.style.display = "block";
    } else {
        timeline.style.display = "none";
    }
}
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