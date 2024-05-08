<?php
    session_start();
    if (!isset($_SESSION['email'])) {
        header("Location: index.php?error=Login%20First");
        die();
    }

    include 'config.php';

    $email = $_SESSION['email'];
    $conn_String = mysqli_connect("localhost", "root", "", "billing");
    $stmt = $conn_String->prepare("SELECT * FROM tableusers WHERE email = '{$_SESSION['email']}'");
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    
    if (!$result) {
        header("Location: index.php?error=Login%20First");
        exit();
    }

?>


<?php include('sidebar.php'); ?>
<main class="content px-3 py-2">
    <div class="container-fluid">
        <div class="mb-3">
            <h4><small>Home</small> > <span style="font-weight: 600;">

            Settings Account</span></h4>
        </div>
        
        <!-- Table Element -->
<div class="row">
  <div class="col-sm-6 mb-3 mb-sm-0">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title ms-1" style="font-weight: 600; font-size: 1.1rem;">Change Password</h5>
    </div>
      <div class="card-body">
        
<div class="mb-3">
  <label for="exampleFormControlInput1" class="form-label">Enter Current Password</label>
  <input type="email" class="form-control" id="exampleFormControlInput1">
  </div>
  <div class="mb-3">
  <label for="exampleFormControlInput1" class="form-label">Enter New Password</label>
  <input type="email" class="form-control" id="exampleFormControlInput1">
</div>
<div class="mb-3">
  <label for="exampleFormControlInput1" class="form-label">Confirm New Password</label>
  <input type="email" class="form-control" id="exampleFormControlInput1">
</div>

<div class="mb-3">
<button class="btn btn-success btn-sm">Submit</button>
</div>
      </div>
    </div>
  </div>
  <div class="col-sm-6">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title ms-1" style="font-weight: 600; font-size: 1.1rem;">Change Email Address</h5>
    </div>
      <div class="card-body">
        
<div class="mb-3">
  <label for="exampleFormControlInput1" class="form-label">Enter Current Email</label>
  <input type="email" class="form-control" id="exampleFormControlInput1">
  </div>
  <div class="mb-3">
  <label for="exampleFormControlInput1" class="form-label">Confirm New Email</label>
  <input type="email" class="form-control" id="exampleFormControlInput1">
</div>
<div class="mb-3">
  <label for="exampleFormControlInput1" class="form-label">Portal Password</label>
  <input type="email" class="form-control" id="exampleFormControlInput1">
</div>

<div class="mb-3">
<button class="btn btn-success btn-sm">Submit</button>
</div>
      </div>
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
                                    <strong>RRBMS</strong>
                                </a>
                            </p>
                        </div>
                        
                    </div>
                </div>
            </footer>
        </div>
    </div>

