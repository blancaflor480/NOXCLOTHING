<?php
    session_start();
    if (!isset($_SESSION['uname'])) {
        header("Location: login-signup.php?error=Login%20First");
        die();
    }

    include 'dbconn/conn.php';

    $uname = $_SESSION['uname'];
    $conn_String = mysqli_connect("localhost", "root", "", "noxclothing");
    $stmt = $conn_String->prepare("SELECT * FROM admin WHERE uname = '{$_SESSION['uname']}'");
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    
    if (!$result) {
        header("Location: login-signup.php?error=Login%20First");
        exit();
    }

?>


<?php include('sidebar.php'); ?>

   <main class="content px-3 py-2">
                <div class="container-fluid">
                    <div class="mb-3">
                        <h4>Dashboard</h4>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-6 d-flex">
                            <div class="card flex-fill border-0 illustration">
                                <div class="card-body p-0 d-flex flex-fill">
                                    <div class="row g-0 w-100">
                                        <div class="col-6">
                                            <div class="p-3 m-1">
                                                <h4>Hello, <?php echo $result['fname']; ?>!</h4>
                                                <p class="mb-0">Date: <?php echo $result['logintime']; ?></p>
                                            </div>
                                        </div>
                                        <div class="col-6 align-self-end text-end">
                                            <img src="image/admin.png" class="img-fluid illustration-img"
                                                alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                       <?php
                           $uname = $_SESSION['uname'];

                           $query = mysqli_query($conn_String, "SELECT COUNT(id) AS numberofpending FROM orders ");
                           $row = mysqli_fetch_assoc($query);

                           if (mysqli_num_rows($query) > 0) { 
                            $numberofpending = $row['numberofpending'];
                           } else {
                           $numberofpending = 2;
                          }
                        ?>
                        <div class="col-12 col-md-3 d-flex" >
                           <div class="card flex-fill border-0">
                              <div class="card-body py-4">
                                <div class="d-flex align-items-start">
                                  <div class="flex-grow-1">
                                     <h4 class="mb-2">
                                         Orders
                                     </h4>
                                    <h4 class="mb-2" style="font-weight: bold; color: darkred;">
                                      <?php echo $numberofpending ?>
                                    </h4>
                                   </div>
                                   <div class="ms-2" style="margin-top: 10px;">
                                   <i class="fa-regular fa-envelope" style="font-size: 60px;"></i>
                                    </div>
                                 </div>
                              </div>
                           </div>
                       </div> 
                        <div class="col-12 col-md-3 d-flex">
                           <div class="card flex-fill border-0">
                              <div class="card-body py-4">
                                <div class="d-flex align-items-start">
                                  <div class="flex-grow-1">
                                     <h4 class="mb-2">
                                         Product
                                     </h4>
                                     <?php
                           $uname = $_SESSION['uname'];

                           $query = mysqli_query($conn_String, "SELECT COUNT(id) AS numberofproduct FROM products ");
                           $row = mysqli_fetch_assoc($query);

                           if (mysqli_num_rows($query) > 0) { 
                            $numberofproduct = $row['numberofproduct'];
                           } else {
                            $numberofproduct = 2;
                          }
                        ?>
                                    <h4 class="mb-2" style="font-weight: bold; color: darkred;">
                                   
                         <?php echo $numberofproduct ?>
                                   
                                       
                        </h4>
                                   </div>
                                   <div class="ms-2" style="margin-top: 10px;">
                                  
                                   <i class="fa fa-shopping-cart" style="font-size: 60px;"></i>
                                    </div>
                                 </div>
                              </div>
                           </div>
                       </div>
                         <!--<div class="col-12 col-md-3 d-flex">
                            <div class="card flex-fill border-0">
                                <div class="card-body py-4">
                                    <div class="d-flex align-items-start">
                                        <div class="flex-grow-1">
                                            <h4 class="mb-2">
                                                Registered Date
                                            </h4>
                                            <p class="mb-2">
                                                <?php echo $result['datereg']; ?>
                                            </p>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>-->
                        <?php
                           $uname = $_SESSION['uname'];
                           $query = mysqli_query($conn_String, "SELECT COUNT(id) AS numberofcustomer FROM customer ");
                           $row = mysqli_fetch_assoc($query);

                           if (mysqli_num_rows($query) > 0) { 
                            $numberofcustomer = $row['numberofcustomer'];
                           } 
                        ?>
                        <div class="col-12 col-md-3 d-flex">
                           <div class="card flex-fill border-0">
                              <div class="card-body py-4">
                                <div class="d-flex align-items-start">
                                  <div class="flex-grow-1">
                                     <h4 class="mb-2">
                                         Customer
                                     </h4>
                                    <h4 class="mb-2" style="font-weight: bold; color: darkred;">
                                      <?php echo $numberofcustomer ?>
                                    </h4>
                                   </div>
                                   <div class="ms-2" style="margin-top: 10px;">
                                   <i class="fa-regular fa-user" style="font-size: 60px;"></i>
                                    </div>
                                 </div>
                              </div>
                           </div>
                       </div> 
                       <?php
                           $uname = $_SESSION['uname'];

                           $query = mysqli_query($conn_String, "SELECT COUNT(id) AS numberofpending FROM orders ");
                           $row = mysqli_fetch_assoc($query);

                           if (mysqli_num_rows($query) > 0) { 
                            $numberofpending = $row['numberofpending'];
                           } else {
                           $numberofpending = 2;
                          }
                        ?>
                        <div class="col-12 col-md-3 d-flex">
                           <div class="card flex-fill border-0">
                              <div class="card-body py-4">
                                <div class="d-flex align-items-start">
                                  <div class="flex-grow-1">
                                     <h4 class="mb-2">
                                         Earning
                                     </h4>
                                    <h4 class="mb-2" style="font-weight: bold; color: darkred;">
                                      <?php echo $numberofpending ?>
                                    </h4>
                                   </div>
                                   <div class="ms-2" style="margin-top: 10px;">
                                   <i class="fa-solid fa-coins" style="font-size: 60px;"></i>
                                    </div>
                                 </div>
                              </div>
                           </div>
                       </div> 
                       <?php
                           $uname = $_SESSION['uname'];

                           $query = mysqli_query($conn_String, "SELECT COUNT(id) AS numberofpending FROM orders ");
                           $row = mysqli_fetch_assoc($query);

                           if (mysqli_num_rows($query) > 0) { 
                            $numberofpending = $row['numberofpending'];
                           } else {
                           $numberofpending = 2;
                          }
                        ?>
                        <div class="col-12 col-md-3 d-flex">
                           <div class="card flex-fill border-0">
                              <div class="card-body py-4">
                                <div class="d-flex align-items-start">
                                  <div class="flex-grow-1">
                                     <h4 class="mb-2">
                                         Completed Orders
                                     </h4>
                                    <h4 class="mb-2" style="font-weight: bold; color: darkred;">
                                      <?php echo $numberofpending ?>
                                    </h4>
                                   </div>
                                   <div class="ms-2" style="margin-top: 10px;">
                                   <i class="fa-solid fa-check" style="font-size: 60px;"></i>
                                    </div>
                                 </div>
                              </div>
                           </div>
                       </div> 
                       <?php
                           $uname = $_SESSION['uname'];

                           $query = mysqli_query($conn_String, "SELECT COUNT(id) AS numberofpending FROM orders ");
                           $row = mysqli_fetch_assoc($query);

                           if (mysqli_num_rows($query) > 0) { 
                            $numberofpending = $row['numberofpending'];
                           } else {
                           $numberofpending = 2;
                          }
                        ?>
                        <div class="col-12 col-md-3 d-flex">
                           <div class="card flex-fill border-0">
                              <div class="card-body py-4">
                                <div class="d-flex align-items-start">
                                  <div class="flex-grow-1">
                                     <h4 class="mb-2">
                                         Pending Order
                                     </h4>
                                    <h4 class="mb-2" style="font-weight: bold; color: darkred;">
                                      <?php echo $numberofpending ?>
                                    </h4>
                                   </div>
                                   <div class="ms-2" style="margin-top: 10px;">
                                   <i class="fa-regular fa-clock" style="font-size: 60px;"></i>
                                    </div>
                                 </div>
                              </div>
                           </div>
                       </div> 
                       
                        
                    </div>
                    <!-- Table Element -->
                    <div class="card border-0">
                        <div class="card-header">
                            <h5 class="card-title">
                                <b>Best Selling Item</b>
                            </h5>
                            <h6 class="card-subtitle text-muted">
                                This announcement provides information about top of the month. 
                            </h6>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Games</th>
                                        <th scope="col">Sell</th>
                                        <th scope="col">Download</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row">System maintainance.</th>
                                        <td>Febuary 10, 2023</td>
                                        <td>Febuary 10, 2023</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
            <!--<a href="#" class="theme-toggle">
                <i class="fa-regular fa-moon"></i>
                <i class="fa-regular fa-sun"></i>
            </a>-->
           
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row text-muted">
                        <div class="col-6 text-start">
                            <p class="mb-0">
                                <a href="#" class="text-muted">
                                    <strong>GAME VAULT</strong>
                                </a>
                            </p>
                        </div>
                        
                    </div>
                </div>
            </footer>
        </div>
    </div>
 