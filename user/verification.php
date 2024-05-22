<?php
session_start(); // Start the session
require 'dbconn/conn.php';

// Check if the user is not logged in or if the email is not set in the session
if (!isset($_SESSION['email'])) {
    header("Location: login-signup.php");
    exit(); // Ensure to exit after redirection
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

            // Redirect to a different page after successful verification
            header("Location: verification-success.php");
            exit();
        } else {
            echo "<script>
                alertify.set('notifier','position', 'top-center');
                alertify.error('Invalid OTP. Please try again.');
                </script>";
        }
    } else {
        echo "<script>
            alertify.set('notifier','position', 'top-center');
            alertify.error('An error occurred. Please try again.');
            </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>NOX CLOTHING</title>
    <link rel="icon" href="images/icon.png"/>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css'>
    <link rel="stylesheet" href="style2.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs/build/css/alertify.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs/build/css/themes/default.min.css"/>
</head>
<script src="https://cdn.jsdelivr.net/npm/alertifyjs/build/alertify.min.js"></script>

<body>
<div class="container" id="container">
    <div class="form-container sign-in-container">
        <form action="" method="post">
            <h1>EMAIL VERIFICATION</h1>
            <span style="padding-bottom: 20px;">We're so excited to see you again!</span>
            <input type="number" name="otp_code" placeholder="Otp Verification" required />
            <button name="verify" style="margin-bottom: 40px; margin-top: 10px; padding: 12px 140px;">VERIFY</button>
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
                <p>New to GameVault? Sign up below to create<br> your account and start journey with us.</p>
            </div>
        </div>
    </div>
</div>
<script src="script.js"></script>
</body>
</html>
