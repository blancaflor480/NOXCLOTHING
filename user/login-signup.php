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
	<link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />

	</head>
	<script src="https://cdn.jsdelivr.net/npm/alertifyjs/build/alertify.min.js"></script>

	<body>
	<style>
  .error-message {
    display: none;
    color: red;
    font-size: 0.6rem;
	margin-right: 250px;
	width: 200px;
	margin-top: -5px;
  }

  .visible {
    display: block;
  }

  .invalid {
    border: 2px solid red;
  }
</style>

		
<?php 
	session_start();
	require 'dbconn/conn.php';
	
	if (isset($_POST['login'])) {
		$email = mysqli_real_escape_string($conn, $_POST['email']);
		$password = mysqli_real_escape_string($conn, md5($_POST['password']));

		// Check if the email is verified and the OTP is NULL
		$sql = "SELECT * FROM customer WHERE email ='{$email}' AND password = '{$password}' AND otp IS NULL AND email_verified = 1";
		$result = mysqli_query($conn, $sql);
	
		if(mysqli_num_rows($result) === 1){
			$row = mysqli_fetch_assoc($result);
			$_SESSION['email'] = $email;
			header("Location: index.php?email=$email");
			exit();	
		} else {
			// Check if the email exists but is not verified
			$sql_verify = "SELECT * FROM customer WHERE email ='{$email}'";
			$result_verify = mysqli_query($conn, $sql_verify);
			if(mysqli_num_rows($result_verify) === 1){
				// Display error message for unverified email
				echo "<script>
						alertify.set('notifier','position', 'top-center');
						alertify.error('<i class=\"fas fa-exclamation-circle\"></i> Your email is not verified yet.');
						document.querySelector('.alertify-notifier .ajs-message').style.fontSize = '0.7rem';
						document.querySelector('.alertify-notifier .ajs-message').style.padding = '30px';
						document.querySelector('.alertify-notifier .ajs-message').style.width = '400px';
						document.querySelector('.alertify-notifier .ajs-message').style.backgroundColor = '#fc5555';
						document.querySelector('.alertify-notifier .ajs-modal').style.border = '2px solid red';
					</script>";
			} 
            else{
				// Display error message for incorrect username/password
				echo "<script>
						alertify.set('notifier','position', 'top-center');
						alertify.error('<i class=\"fas fa-exclamation-circle\"></i> Username and Password doesn\'t match.');
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

<script>
  function passError() {
    var passwordInput = document.getElementById('password');
    var passError = document.getElementById('passError');
    var password = passwordInput.value;

    if (password.length < 8) {
      passError.textContent = "Password must be at least 8 characters long.";
    } else {
      passError.textContent = "";
    }
  }

</script>
<div class="container" id="container">
		<div class="form-container sign-up-container">
			<form action="" method="post" id="signupform">
<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include 'dbconn/conn.php';
require 'vendor/autoload.php'; // Include PHPMailer via Composer


if (isset($_POST['submit'])) {
    $fname = mysqli_real_escape_string($conn, stripcslashes($_REQUEST['fname']));
    $mname = mysqli_real_escape_string($conn, stripcslashes($_REQUEST['mname']));
    $lname = mysqli_real_escape_string($conn, stripcslashes($_REQUEST['lname']));
    $email = mysqli_real_escape_string($conn, stripcslashes($_REQUEST['email']));
    $password = mysqli_real_escape_string($conn, stripcslashes($_REQUEST['password']));
    $bday = mysqli_real_escape_string($conn, stripcslashes($_REQUEST['bday']));

    $errors = array();

    if (strlen($password) < 8) {
        $errors['password'] = 'Password must be at least 8 characters long. Please try again.';
    }

    $check_email_query = "SELECT * FROM customer WHERE email='$email'";
    $check_email_result = mysqli_query($conn, $check_email_query);
   
    if (mysqli_num_rows($check_email_result) > 0) {
        $errors['email'] = "Email already exists";
    }
   
    if (empty($errors)) {
        $hashed_password = md5($password);

        $query = "INSERT INTO customer (fname, mname, lname, email, password, bday) VALUES ('$fname','$mname','$lname', '$email', '$hashed_password', '$bday')";
        $result = mysqli_query($conn, $query);

        if ($result) {
            // Generate OTP
            $otp = rand(100000, 999999);

            // Store OTP in the database
            $otp_query = "UPDATE customer SET otp='$otp' WHERE email='$email'";
            mysqli_query($conn, $otp_query);

            // Send OTP via Gmail
            $mail = new PHPMailer(true);
            try {
                // Server settings
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'billinghoa@gmail.com'; // Replace with your Gmail address
                $mail->Password = 'sqtrxkdxrkbalgfu'; // Replace with your Gmail password
                $mail->SMTPSecure = 'ssl';
                $mail->Port = 465;

                // Recipients
                $mail->setFrom('billinghoa@gmail.com', 'NOX CLOTHING SHOP');
                $mail->addAddress($email);

                // Content
                $mail->isHTML(true);
                $mail->Subject = 'Your OTP Code';
                $mail->Body    = "Your OTP code is <b>$otp</b>";

                $mail->send();

                // Set session email and redirect to verification page
                $_SESSION['email'] = $email;

                echo "<script>
                    alertify.set('notifier','position', 'top-center');
                    alertify.success('Registered Successfully. OTP has been sent to your email.');
                    document.querySelector('.alertify-notifier .ajs-message').style.backgroundColor = '#42ba96';
                    setTimeout(function() {
                        window.location.href = 'verification.php'; // Redirect to OTP verification page
                    }, 500);
                    </script>";
                exit();
            } catch (Exception $e) {
                echo "<script>
                    alertify.set('notifier','position', 'top-center');
                    alertify.error('Message could not be sent. Mailer Error: {$mail->ErrorInfo}');
                    </script>";
            }
        } else {
            echo "<script>
                alertify.set('notifier','position', 'top-center');
                alertify.error('Failed. Try again');
                </script>";
        }
    } else {
        foreach ($errors as $error) {
            echo "<script>
            alertify.set('notifier','position', 'top-center');
            alertify.error('$error');
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
<br><br><br>
            <h1>CREATE ACCOUNT.</h1>
				<span>by continuing with </span>
				<div class="social-container">
					<a href="#" class="social"><i class="fab fa-google"></i></a>Google
						</div>
				
				
				<input type="text" id="fname-up" name = "fname" placeholder="First Name" value="<?php if (isset($_POST['submit'])) { echo $fname; } ?>" />
                <span id="fname-Error" class="error-message"><i class="bx bx-error"></i> Please enter your firstname</span>

                <input type="text" id="mname-up" name = "mname" placeholder="Middle Name" value="<?php if (isset($_POST['submit'])) { echo $mname; } ?>"  />
                <span id="mname-Error" class="error-message"><i class="bx bx-error"></i> Please enter your middle name</span>

                <input type="text" id="lname-up" name = "lname" placeholder="Last Name" value="<?php if (isset($_POST['submit'])) { echo $lname; } ?>"  />
                <span id="lname-Error" class="error-message"><i class="bx bx-error"></i> Please enter your last name</span>
       
                <input type="email" id="email-up" name = "email" value="<?php if (isset($_POST['submit'])) { echo $email; } ?>" placeholder="Email" />
                <span id="email-Error" class="error-message"><i class="bx bx-error"></i> Please enter your email</span>
                <span style = "display: flex; margin-right: 272px;">
				<?php if (isset($errors['email'])) echo '<span style ="color: red; font-size: 0.6rem; text-align: left;"><i class="bx bx-error"></i> ' . $errors['email'] . '</span>'; ?>
				</span>
	

				<input type="password" id="pass-up" name="password" id="password" placeholder="Password"  oninput="passError()" />
				<span id="pass-Error" class="error-message"><i class="bx bx-error"></i> Please enter your password</span>
                <span id = "passError" style ="color: red; font-size: 0.6rem; margin-left: -155px; text-align: left;"></span>
                
				
				<input placeholder="Birthday" id="bday-up" name="bday" class="textbox-n" type="text" onfocus="(this.type='date')" onblur="(this.type='text')" id="date"  />
				<span id="bday-Error" class="error-message"><i class="bx bx-error"></i> Please select your Birthday</span>
       
                <button style="margin-top: 20px; padding: 12px 140px;" id="sign-up" type="submit" name ="submit">Continue</button>
                
			
			<div class="checkbox-container">
                 <label for="agree-checkbox">By registering, you agree to GameVault's <span style="color: darkcyan;">Terms of Service</span> and <span style="color: darkcyan;">Privacy Policy</span>.</label>
           </div>

           <br><br><br> 
			</form>
            
		</div>
        
		<div class="form-container sign-in-container">
		<form action="" method="post" id="loginForm">
        <h1>WELCOME BACK!</h1>
        <span style="padding-bottom: 20px;">We're so excited to see you again!</span>
        <input type="email" name="email" placeholder="Email" id="email"/>
        <span id="emailError" class="error-message"><i class="bx bx-error"></i> Please enter your email</span>
        <input type="password" name="password" placeholder="Password" id="password-login">
       <span id="passwordError" class="error-message"> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<i class="bx bx-error"></i> Please enter your password</span>
        <a href="#" style="font-size: 10px; color: darkred; margin-top: -3px; margin-left: 260px;">Forgot your password?</a>
        <button name="login" id="signin" style="margin-bottom: 40px; margin-top: 10px; padding: 12px 140px;">Sign In</button>
        <span style="margin-bottom: 20px;">------ or continue with ------</span>
        <div class="social-container">
          <a href="#" class="social"><i class="fab fa-google"></i></a>Google
        </div>
      </form>

		</div>
		<div class="overlay-container">
			<div class="overlay">
				<div class="overlay-panel overlay-left">
					<a href="../index.php" class="close-button-left"><img src="images/close-wht.png" class="close-icon-left"></a>
					<!--<img src="images/main-logo.png" style="width: 250px; height: 105px; margin-bottom: -15px;">-->
					<h3 style="font-size: 2rem;">NOX CLOTHING</h3>
					<p>Already have an account? To keep connected<br>with us please login with your personal info.</p>
					<button class="ghost" id="signIn">Sign In</button>
				</div>
				<div class="overlay-panel overlay-right">
					<a href="../index.php" class="close-button-right"><img src="images/close-wht.png" class="close-icon-right"></a>
					<h3 style="font-size: 2rem;">NOX CLOTHING</h3>
					
					<!--<img src="images/main-logo.png" style="width: 250px; height: 105px; margin-bottom: -15px;">-->
					<p>If you create an account, it takes less time to go through checkout and complete your orders. Register today for free!</p>
					<button class="ghost" id="signUp">Create an Account</button>
				</div>
			</div>
		</div>
	</div>

    <script>
  document.getElementById("signin").addEventListener("click", function(event) {
    var emailField = document.getElementById("email");
    var passwordField = document.getElementById("password-login");
    var emailError = document.getElementById("emailError");
    var passwordError = document.getElementById("passwordError");
    var valid = true;

    if (!emailField.value) {
      emailError.classList.add("visible");
      emailField.classList.add("invalid");
      valid = false;
    } else {
      emailError.classList.remove("visible");
      emailField.classList.remove("invalid");
    }

    if (!passwordField.value) {
      passwordError.classList.add("visible");
      passwordField.classList.add("invalid");
      valid = false;
    } else {
      passwordError.classList.remove("visible");
      passwordField.classList.remove("invalid");
    }

    if (!valid) {
      event.preventDefault();
      alertify.set('notifier','position', 'top-center');
      alertify.error('<i class="fas fa-exclamation-circle"></i> Please fill out the required fields.');
      document.querySelector('.alertify-notifier .ajs-message').style.fontSize = '0.7rem';
      document.querySelector('.alertify-notifier .ajs-message').style.padding = '30px';
      document.querySelector('.alertify-notifier .ajs-message').style.width = '400px';
      document.querySelector('.alertify-notifier .ajs-message').style.backgroundColor = '#fc5555';
      document.querySelector('.alertify-notifier .ajs-modal').style.border = '2px solid red';
    } else {
      document.getElementById("loginForm").submit();
    }
  });

  function passError() {
    var password = document.getElementById("pass-up").value;
    var passError = document.getElementById("passError");
    if (password.length < 8) {
      passError.innerHTML = "Password must be at least 8 characters long";
    } else {
      passError.innerHTML = "";
    }
  }
</script>

<script>
  document.getElementById("signupform").addEventListener("submit", function(event) {
    var fname = document.getElementById("fname-up").value;
    var mname = document.getElementById("mname-up").value;
    var lname = document.getElementById("lname-up").value;
    var email = document.getElementById("email-up").value;
    var password = document.getElementById("pass-up").value;
    var bday = document.getElementById("bday-up").value;

    var fnameError = document.getElementById("fname-Error");
    var mnameError = document.getElementById("mname-Error");
    var lnameError = document.getElementById("lname-Error");
    var emailError = document.getElementById("email-Error");
    var passwordError = document.getElementById("pass-Error");
    var bdayError = document.getElementById("bday-Error");

    var valid = true;

    if (!fname) {
      fnameError.classList.add("visible");
      document.getElementById("fname-up").classList.add("invalid");
      valid = false;
    } else {
      fnameError.classList.remove("visible");
      document.getElementById("fname-up").classList.remove("invalid");
    }

    if (!mname) {
      mnameError.classList.add("visible");
      document.getElementById("mname-up").classList.add("invalid");
      valid = false;
    } else {
      mnameError.classList.remove("visible");
      document.getElementById("mname-up").classList.remove("invalid");
    }

    if (!lname) {
      lnameError.classList.add("visible");
      document.getElementById("lname-up").classList.add("invalid");
      valid = false;
    } else {
      lnameError.classList.remove("visible");
      document.getElementById("lname-up").classList.remove("invalid");
    }

    if (!email) {
      emailError.classList.add("visible");
      document.getElementById("email-up").classList.add("invalid");
      valid = false;
    } else {
      emailError.classList.remove("visible");
      document.getElementById("email-up").classList.remove("invalid");
    }

    if (!password) {
      passwordError.classList.add("visible");
      document.getElementById("pass-up").classList.add("invalid");
      valid = false;
    } else {
      passwordError.classList.remove("visible");
      document.getElementById("pass-up").classList.remove("invalid");
    }

    if (!bday) {
      bdayError.classList.add("visible");
      document.getElementById("bday-up").classList.add("invalid");
      valid = false;
    } else {
      bdayError.classList.remove("visible");
      document.getElementById("bday-up").classList.remove("invalid");
    }

    if (!valid) {
      event.preventDefault();
      alertify.set('notifier','position', 'top-center');
      alertify.error('<i class="fas fa-exclamation-circle"></i> Please fill out the required fields.');
      document.querySelector('.alertify-notifier .ajs-message').style.fontSize = '0.7rem';
      document.querySelector('.alertify-notifier .ajs-message').style.padding = '30px';
      document.querySelector('.alertify-notifier .ajs-message').style.width = '400px';
      document.querySelector('.alertify-notifier .ajs-message').style.backgroundColor = '#fc5555';
      document.querySelector('.alertify-notifier .ajs-modal').style.border = '2px solid red';
    } else {
      document.getElementById("loginForm").submit();
    }
  });
</script>
	<script  src="script.js"></script>

	</body>
</html>


