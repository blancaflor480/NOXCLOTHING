
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>NOX CLOTHING - Email Verification</title>
    <link rel="icon" href="images/icon.png"/>
    <link rel="stylesheet" href="style2.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs/build/css/alertify.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs/build/css/themes/default.min.css"/>
</head>
<body>
<script src="https://cdn.jsdelivr.net/npm/alertifyjs/build/alertify.min.js"></script>


<div class="container" id="container">


    <div class="form-container sign-in-container">
<?php
session_start();
require 'dbconn/conn.php';

// Check if the session email is set
if (!isset($_SESSION['email'])) {
    header("Location: login-signup.php");
    exit();
}

if (isset($_POST['verify'])) {
    $email = $_SESSION['email'];
    $entered_otp = mysqli_real_escape_string($conn, $_POST['otp_code']);

    // Fetch the stored OTP for comparison
    $otp_query = "SELECT otp FROM customer WHERE email='$email'";
    $otp_result = mysqli_query($conn, $otp_query);

    if (mysqli_num_rows($otp_result) === 1) {
        $row = mysqli_fetch_assoc($otp_result);
        $stored_otp = $row['otp'];

        if ($entered_otp == $stored_otp) {
            // OTP matches, mark email as verified
            $verify_query = "UPDATE customer SET email_verified=1 WHERE email='$email'";
            mysqli_query($conn, $verify_query);

            // Delete the OTP from the database after successful verification
            $delete_otp_query = "UPDATE customer SET otp=NULL WHERE email='$email'";
            mysqli_query($conn, $delete_otp_query);

            // Display success message and redirect using JavaScript
            echo "<script>
                alertify.set('notifier', 'position', 'top-center');
                alertify.success('OTP verified successfully.');
                setTimeout(function() {
                    window.location.href = 'login-signup.php';
                }, 2000); // Redirect after 2 seconds
            </script>";
            exit();
        } else {
            echo "<script>
                alertify.set('notifier', 'position', 'top-center');
                alertify.error('Invalid OTP. Please try again.');
            </script>";
        }
    } else {
        echo "<script>
            alertify.set('notifier', 'position', 'top-center');
            alertify.error('An error occurred. Please try again.');
        </script>";
    }
}
?>
        <form action="" method="post">
            <h1>Email Verification</h1>
            <span style="padding-bottom: 20px;">We're so excited to see you again!</span>
            <input type="number" name="otp_code" placeholder="OTP Verification" required />
            <button type="submit" name="verify" style="margin-bottom: 40px; margin-top: 10px; padding: 12px 140px;">Verify</button>
        </form>
    </div>
    <div class="overlay-container">
        <div class="overlay">
            <div class="overlay-panel overlay-left">
                <a href="index.html" class="close-button-left"><img src="images/close-wht.png" class="close-icon-left"></a>
                <h3 style="font-size: 2rem;">NOX CLOTHING</h3>
                <p>Already have an account? To keep connected<br>with us please login with your personal info.</p>
                <button class="ghost" id="signIn">Sign In</button>
            </div>
            <div class="overlay-panel overlay-right">
                <a href="index.html" class="close-button-right"><img src="images/close-wht.png" class="close-icon-right"></a>
                <h3 style="font-size: 2rem;">NOX CLOTHING</h3>
                <p>New to NOX CLOTHING? Sign up below to create<br>your account and start your journey with us.</p>
            </div>
        </div>
    </div>
</div>

<script src="script.js"></script>
</body>
</html>
