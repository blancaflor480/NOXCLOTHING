<!DOCTYPE html>
<html lang="en" data-bs-theme="white">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NOX CLOTHING</title>
    <link rel="icon" href="images/main.png"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css">
    

    <!-- Include Alertify CSS for styling -->
   
    <script src="https://kit.fontawesome.com/ae360af17e.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/style.css">
     
</head>
<body>
<?php
include 'dbconn/conn.php';
  if (isset($_SESSION['uname'])) {
    $uname = $_SESSION['uname'];
} else {
    // Handle the case when the session variable is not set, redirect or show an error.
    header("Location: login-signup.php");
    exit();
}

$query  = mysqli_query($conn, "SELECT * FROM admin WHERE uname = '$uname'") or die(mysqli_error());
$row = mysqli_fetch_array($query);
$role  = $row['role'];
?>

    <div class="wrapper">
        <aside id="sidebar" class="js-sidebar">
            <!-- Content For Sidebar -->
            <div class="h-100">
                <div class="sidebar-logo">
                    <!--<a href="dashboard.php"><img src="images/main-logo.png" style="width: 213px"></a>-->
                    
                    <a href="dashboard.php"><img src="images/main.png" style="width: 70px"><span style="color: white; ">NOX CLOTHING</span></a>
                    
                </div>
                <ul class="sidebar-nav">
                    <li class="sidebar-header">
                        Main Menu
                    </li>
                    <li class="sidebar-item">
                        <a href="dashboard.php" class="sidebar-link">
                            <i class="fa fa-home pe-2"></i>
                            Home
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link collapsed" data-bs-target="#pages" data-bs-toggle="collapse"
                            aria-expanded="false"><i class="fa-solid fa-file-lines pe-2"></i>
                            Product
                        </a>
                        <ul id="pages" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar" >
                            <li class="sidebar-item "  style="padding-left: 25px;">
                                <a href="games.php" class="sidebar-link"><i class="fa-solid fa-scroll pe-2"></i> Items </a>
                            </li>
                            <!--<li class="sidebar-item">
                                <a href="#" class="sidebar-link">Page 2</a>
                            </li>-->
                        </ul>
                        <ul id="pages" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                            <li class="sidebar-item "style="padding-left: 25px;">
                                <a href="orders.php" class="sidebar-link"><i class="fa-solid fa-scroll pe-2"></i> Transactions</a>
                            </li>
                            <!--<li class="sidebar-item">
                                <a href="#" class="sidebar-link">Page 2</a>
                            </li>-->
                        </ul>
                       
                        <ul id="pages" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                            <li class="sidebar-item " style="padding-left: 25px;">
                                <a href="" class="sidebar-link"><i class="fa-solid fa-scroll pe-2"></i> History</a>
                            </li>
                            <!--<li class="sidebar-item">
                                <a href="#" class="sidebar-link">Page 2</a>
                            </li>-->
                        </ul>
                    </li>
                    <?php if ($role == 'Admin'): ?>
                    <li class="sidebar-item">
                        <a href="customer.php" class="sidebar-link collapsed"><i class="fa-solid fa-user pe-2"></i>
                            Customer Info
                        </a>
                    </li>
                    
                    <li class="sidebar-item">
                        <a href="account.php" class="sidebar-link collapsed"><i class="fa-solid fa-user pe-2"></i>
                            Admin Accounts
                        </a>
                    </li>
                    <?php endif; ?>
                    
                    <li class="sidebar-item">
                        <a href="" class="sidebar-link collapsed"><i class="fa-solid fa-message pe-2"></i>
                           Complaint
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="" class="sidebar-link collapsed"><i class="fa-solid fa-gear pe-2"></i>
                            Settings
                        </a>
                   </li> 

                       <!--<ul id="auth" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                            <li class="sidebar-item">
                                <a href="#" class="sidebar-link">Login</a>
                            </li>
                            <li class="sidebar-item">
                                <a href="#" class="sidebar-link">Register</a>
                            </li>
                            <li class="sidebar-item">
                                <a href="#" class="sidebar-link">Forgot Password</a>
                            </li>
                        </ul>-->
                   
                    <!--<li class="sidebar-header">
                        Multi Level Menu
                    </li>-->
                    <!--<li class="sidebar-item">
                        <a href="#" class="sidebar-link collapsed" data-bs-target="#multi" data-bs-toggle="collapse"
                            aria-expanded="false"><i class="fa-solid fa-share-nodes pe-2"></i>
                            Multi Dropdown
                        </a>
                        <ul id="multi" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                            <li class="sidebar-item">
                                <a href="#" class="sidebar-link collapsed" data-bs-target="#level-1"
                                    data-bs-toggle="collapse" aria-expanded="false">Level 1</a>
                                <ul id="level-1" class="sidebar-dropdown list-unstyled collapse">
                                    <li class="sidebar-item">
                                        <a href="#" class="sidebar-link">Level 1.1</a>
                                    </li>
                                    <li class="sidebar-item">
                                        <a href="#" class="sidebar-link">Level 1.2</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>-->
                </ul>
            </div>
        </aside>
       <!--< ?php 
include ('config.php');
if (isset($_SESSION['email'])) {
  $email = $_SESSION['email'];
} else {
  // Handle the case when the session variable is not set, redirect or show an error.
  header("Location: index.php");
  exit();
}

$conn_String = mysqli_connect("localhost", "root", "", "billing");
$stmt = $conn_String->prepare("SELECT * FROM tableusers WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();

$query = mysqli_query($conn, "SELECT fname, category, image from tableusers");
if (mysqli_num_rows($query) > 0){
     $row = mysqli_fetch_assoc($query);
     if(isset($row['image'])&& $row['image'] != ""){
     }
 }
?>-->
        <div class="main">
            <nav class="navbar navbar-expand px-3 border-bottom">
                <button class="btn" id="sidebar-toggle" type="button">
                    <span class="navbar-toggler-icon"></span>
                </button>


                <div class="navbar-collapse navbar">
                    <ul class="navbar-nav">

                    
                    <button type="button" class="btn btn-dark position-relative me-4" id="notif" style="font-size: 0.7rem;">
                          <i class="fa-regular fa-bell"></i> Notification
                       <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            99+
                       <span class="visually-hidden">unread messages</span>
                      </span>
                     
                    </button>
                       
                        <li class="nav-item dropdown">
                            <a href="#" data-bs-toggle="dropdown" class="nav-icon pe-md-0">
                             <div class="d-flex align-items-center"> <!-- Container for image and text -->
                          
                            <img src="image/profile.jpg" class="avatar img-fluid rounded" alt="">
                            <!--&nbsp;<p class="navbar-brand mb-0 me-2" style="font-size: 0.6rem">Logout</p>-->
                        </div>
                        </a>
                            

                            <div class="dropdown-menu dropdown-menu-end">
                            
                         
                            <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#profileModal">
                               Profile
                            </button>
                                <a href="logout.php" class="dropdown-item">Log-out</a>
                            </div>

            
            
                    </ul>
                </div>
            </nav>
    <!-- Profile Modal -->
<div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="profileModalLabel">User Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Profile Content Here -->
                <div class="mb-3">
            <label for="editfname<?php echo $row['id']; ?>" class="form-label">First name</label>
            <input type="text" class="form-control" id="editfname<?php echo $row['id']; ?>" name="fname" value="<?php echo $row['fname']; ?>" disabled>
           
            <label for="editmname<?php echo $row['id']; ?>" class="form-label">Middle name</label>
            <input type="text" class="form-control" id="editmname<?php echo $row['id']; ?>" name="mname" value="<?php echo $row['mname']; ?>" disabled>
           
            <label for="editlname<?php echo $row['id']; ?>" class="form-label">Last name</label>
            <input type="text" class="form-control" id="editfname<?php echo $row['id']; ?>" name="lname" value="<?php echo $row['lname']; ?>" disabled>
           
            <label for="editemail<?php echo $row['id']; ?>" class="form-label">Email</label>
            <input type="email" class="form-control" id="editemail<?php echo $row['id']; ?>" name="email" value="<?php echo $row['email']; ?>" disabled>
           
            <label for="edituname<?php echo $row['id']; ?>" class="form-label">Username</label>
            <input type="text" class="form-control" id="edituname<?php echo $row['id']; ?>" name="uname" value="<?php echo $row['uname']; ?>" disabled>
           
            
            <label for="editrole<?php echo $row['id']; ?>" class="form-label">Role</label>
<select class="form-select" id="editrole<?php echo $row['id']; ?>" name="role" disabled>
    <option value="admin" <?php if($row['role'] == 'admin') echo 'selected'; ?>>Admin</option>
    <option value="staff" <?php if($row['role'] == 'staff') echo 'selected'; ?>>Staff</option>
</select>

          <!--  <label for="editImage<?php echo $row['id']; ?>" class="form-label">Image</label>
            <input type="file" class="form-control" id="editImage<?php echo $row['id']; ?>" name="image" value="<?php echo $row['image_path']; ?>" >
            -->
            
                            </div>
            </div>
            <div class="modal-footer">
                <!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#changepassword">
 Change Password
</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
    
</div>
<!-- Modal -->
<?php include('changepassword.php'); ?>    
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>
</body>

</html>
