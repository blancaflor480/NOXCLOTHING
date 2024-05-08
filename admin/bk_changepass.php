<?php
session_start();
include_once 'dbconn/conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $oldPassword = $_POST['oldPassword'];
    $newPassword = $_POST['newPassword'];
    $confirmNewPassword = $_POST['confirmNewPassword'];

    // Validation
    if (empty($oldPassword) || empty($newPassword) || empty($confirmNewPassword)) {
        echo "All fields are required.";
    } else {
        // Retrieve admin details from the database based on the session or any other authentication mechanism you're using
        // For simplicity, let's assume we have a session variable 'uname' containing the logged-in admin's username
        $uname = $_SESSION['uname'];
        $sql = "SELECT * FROM admin WHERE uname = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $uname);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $admin = $result->fetch_assoc();
            // Verify old password
            if ($admin['password'] === md5($oldPassword)) {
                // Check if new password and confirm password match
                if ($newPassword === $confirmNewPassword) {
                    // Hash the new password
                    $hashed_password = md5($newPassword);
                    // Update password in the database
                    $update_sql = "UPDATE admin SET password = ? WHERE uname = ?";
                    $update_stmt = $conn->prepare($update_sql);
                    $update_stmt->bind_param("ss", $hashed_password, $uname);
                    if ($update_stmt->execute()) {
                        echo "Password changed successfully.";
                    } else {
                        echo "Failed to update password. Please try again.";
                    }
                } else {
                    echo "New password and confirm password do not match.";
                }
            } else {
                echo "Incorrect old password.";
            }
        } else {
            echo "Admin not found.";
        }
    }
} else {
    // If not a POST request, redirect or display an error message
    echo "Invalid request method.";
}
?>
