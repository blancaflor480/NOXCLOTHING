<!-- FOR LOGIN -->
<!DOCTYPE html>
<html lang="en" >
	<head>
	  <meta charset="UTF-8">
		<title> NOX CLOTHING </title>
		<link rel="icon" href="images/icon.png"/>
	  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css'>
      <link rel="stylesheet" href="style2.css">
	  <!-- Include Alertify CSS -->
	  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs/build/css/alertify.min.css"/>
    <!-- Include Alertify theme default CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs/build/css/themes/default.min.css"/>

	</head>
	<script src="https://cdn.jsdelivr.net/npm/alertifyjs/build/alertify.min.js"></script>

	<body>
<?php 
	session_start();
	require 'dbconn/conn.php';
	
	if(isset($_SESSION['email'])){
		header("Location: login-signup.php");
		exit(); // Make sure to exit after redirection
	}
	
	if (isset($_POST['login'])) {
		$email = mysqli_real_escape_string($conn, $_POST['email']);
		$password = mysqli_real_escape_string($conn, md5($_POST['password']));

		$sql = "SELECT * FROM customer WHERE email ='{$email}' AND password = '{$password}'";
		$result = mysqli_query($conn, $sql);
	
		if(mysqli_num_rows($result) === 1){
			$row = mysqli_fetch_assoc($result);
			$_SESSION['email'] = $email;
			header("Location: index.php?email=$email");
			exit();	
		} else {
			// Display error message using Alertify
			echo "<script>
					alertify.set('notifier','position', 'top-center');
					alertify.error('<i class=\"fas fa-exclamation-circle\"></i> Username and Password doesn\'t match, please try again.');
					document.querySelector('.alertify-notifier .ajs-message').style.fontSize = '0.7rem';
					document.querySelector('.alertify-notifier .ajs-message').style.padding = '30px';
					document.querySelector('.alertify-notifier .ajs-message').style.width = '400px';
					document.querySelector('.alertify-notifier .ajs-message').style.backgroundColor = '#fc5555';
					document.querySelector('.alertify-notifier .ajs-modal').style.border = '2px solid red';
				</script>";
		}	
	}		
?>

<script>
function passError() {
    var passwordInput = document.getElementById('password');
    var passError = document.getElementById('passError');
    var password = passwordInput.value;

    if (password.length < 8) {
        passError.textContent = "Password must be at least 8 characters long.";
		console.log(passError);
    } else {
        passError.textContent = "";
    }
}

function showAlert(title, message, icon, type) {
            Swal.fire({
                title: title,
                text: message,
                icon: icon,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'OK'
            }).then((result) => {
               if (result.isConfirmed) {
                   window.location.href = 'login-signup.php';
                }
            });
        }
    </script>
		<!--<video autoplay loop muted plays-inline class="back-video">
			<source src="images/bgvid-glitch.mp4" type="video/mp4">
		</video>-->
	<div class="container" id="container">
		<div class="form-container sign-up-container">
			<form action="" method="post">
<?php
include 'dbconn/conn.php';

if (isset($_POST['submit'])) {
    $uname = stripcslashes($_REQUEST['uname']);
    $uname = mysqli_real_escape_string($conn, $uname);
    $fname = stripcslashes($_REQUEST['fname']);
    $fname = mysqli_real_escape_string($conn, $fname);
    $email = stripcslashes($_REQUEST['email']);
    $email = mysqli_real_escape_string($conn, $email);
    $password = stripcslashes($_REQUEST['password']);
    $password = mysqli_real_escape_string($conn, $password);
    $bday = stripcslashes($_REQUEST['bday']);
    $bday = mysqli_real_escape_string($conn, $bday);

	if ((strlen($password) < 8)) {
		$errors['password'] = 'Password must be at least 8 characters long. Please try again.';
	}
	

    $check_email_query = "SELECT * FROM customer WHERE email='$email'";
    $check_email_result = mysqli_query($conn, $check_email_query);
    $check_uname_query = "SELECT * FROM customer WHERE uname='$uname'";
    $check_uname_result = mysqli_query($conn, $check_uname_query);

    if (mysqli_num_rows($check_email_result) > 0) {
        $errors['email'] = "Email already exists";
    }
    if (mysqli_num_rows($check_uname_result) > 0) {
        $errors['uname'] = "Username already exists";
    }

    if (empty($errors)) {
        // Hashing password with MD5
        $hashed_password = md5($password);

        $query = "INSERT into customer (uname,fname,email,password,bday) VALUES ('$uname','$fname','$email','$hashed_password','$bday')";
        $result = mysqli_query($conn, $query);

        if ($result) {
            echo "<script>
        alertify.set('notifier','position', 'top-center');
        alertify.success('Registered Successfully');
        document.querySelector('.alertify-notifier .ajs-message').style.backgroundColor = '#42ba96';
        setTimeout(function() {
            window.location.href = 'login-signup.php';
        }, 500); // 1000 milliseconds = 1 seconds
        </script>";
    exit();
        } else {
            echo "<script>
                alertify.set('notifier','position', 'top-center');
                alertify.error('Failed. Try again');
                </script>";
        }
	} else {
       foreach($errors as $error){
		echo "<script>
		alertify.set('notifier','position', 'top-center');
		alertify.error( '$error');
		document.querySelector('.alertify-notifier .ajs-message').style.fontSize = '0.7rem';
		document.querySelector('.alertify-notifier .ajs-message').style.padding = '30px';
		document.querySelector('.alertify-notifier .ajs-message').style.width = '400px';
		document.querySelector('.alertify-notifier .ajs-message').style.backgroundColor = '#fc5555';
		document.querySelector('.alertify-notifier .ajs-modal').style.border = '2px solid red';
		</script>";
	   }
	}
}
?>

            <h1>CREATE ACCOUNT.</h1>
				<span>by continuing with </span>
				<div class="social-container">
					<a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
					<a href="#" class="social"><i class="fab fa-google"></i></a>
					<a href="#" class="social"><i class="fab fa-apple"></i></a>
						</div>
				<input type="email" name = "email" value="<?php if (isset($_POST['submit'])) { echo $email; } ?>" placeholder="Email" required />
				
				<span style = "display: flex; margin-right: 265px;">
				<?php if (isset($errors['email'])) echo '<span style ="color: red; font-size: 0.5rem; text-align: left;">' . $errors['email'] . '</span>'; ?>
				</span>
				
				<input type="text" name = "fname" placeholder="Name" value="<?php if (isset($_POST['submit'])) { echo $fname; } ?>" required />
				
				<input type="text" name ="uname" placeholder="Username" value="<?php if (isset($_POST['submit'])) { echo $uname; } ?>" required />
				
				<span style = "display: flex; margin-right: 239px;">
				<?php if (isset($errors['uname'])) echo '<span style ="color: red; font-size: 0.5rem; text-align: left;">' . $errors['uname'] . '</span>'; ?>
				</span>

				<input type="password" name="password" id="password" placeholder="Password" required oninput="passError()" />
				<span id = "passError" style ="color: red; font-size: 0.5rem; margin-left: -155px; text-align: left;"></span>
             
				
				<input placeholder="Birthday" name="bday" class="textbox-n" type="text" onfocus="(this.type='date')" onblur="(this.type='text')" id="date" required="" />
				<button style="margin-top: 20px; padding: 12px 140px;" type="submit" name ="submit">Continue</button>
			
			<div class="checkbox-container">
                 <label for="agree-checkbox">By registering, you agree to GameVault's <span style="color: darkcyan;">Terms of Service</span> and <span style="color: darkcyan;">Privacy Policy</span>.</label>
           </div>

          
			</form>
		</div>

		<div class="form-container sign-in-container">
			<form action="" method = "post">
		<h1>WELCOME BACK!</h1>
				<span style="padding-bottom: 20px;">We're so excited to see you again!</span>
				<input type="email" name="email" placeholder="Email" / required >
				<input type="password" name="password" placeholder="Password" / required >
				
				<a href="#" style="font-size: 10px; color: darkred; margin-top: -3px; margin-left: -260px;">Forgot your password?</a>
				<button name="login" style="margin-bottom: 40px; margin-top: 10px; padding: 12px 140px;">Sign In</button>
				<span style="margin-bottom: 20px;">------ or continue with ------</span>
				<div class="social-container">
					<a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
					<a href="#" class="social"><i class="fab fa-google"></i></a>
					<a href="#" class="social"><i class="fab fa-apple"></i></a>
				</div>
			
				
			</form>
		</div>
		<div class="overlay-container">
			<div class="overlay">
				<div class="overlay-panel overlay-left">
					<a href="index.html" class="close-button-left"><img src="images/close-wht.png" class="close-icon-left"></a>
					<!--<img src="images/main-logo.png" style="width: 250px; height: 105px; margin-bottom: -15px;">-->
					<h3 style="font-size: 2rem;">NOX CLOTHING</h3>
					<p>Already have an account? To keep connected<br>with us please login with your personal info.</p>
					<button class="ghost" id="signIn">Sign In</button>
				</div>
				<div class="overlay-panel overlay-right">
					<a href="index.html" class="close-button-right"><img src="images/close-wht.png" class="close-icon-right"></a>
					<h3 style="font-size: 2rem;">NOX CLOTHING</h3>
					
					<!--<img src="images/main-logo.png" style="width: 250px; height: 105px; margin-bottom: -15px;">-->
					<p>If you create an account, it takes less time to go through checkout and complete your orders. Register today for free!</p>
					<button class="ghost" id="signUp">Create an Account</button>
				</div>
			</div>
		</div>
	</div>
	  <script  src="script.js"></script>

	</body>
</html>


