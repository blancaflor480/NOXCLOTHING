<?php
session_start();
include 'dbconn/conn.php';

// Get account details from the form
$firstName = $_POST['fname'];
$middleName = isset($_POST['mname']) ? $_POST['mname'] : "";
$lastName = isset($_POST['lname']) ? $_POST['lname'] : "";
$username = $_POST['uname'];
$email = $_POST['email'];
$role = $_POST['role'];

// Check if an image file is uploaded
$imageDestination = "";
if ($_FILES["image"]["error"] == 0) {
    $image_name = addslashes($_FILES['image']['name']);
    $image_size = $_FILES["image"]["size"];

    // Check the image file size
    if ($image_size > 10000000) {
        die("File size is too big!");
    }

    // Move the uploaded image to the server
    $imageDestination = "../uploads/" . $image_name;
    move_uploaded_file($_FILES["image"]["tmp_name"], $imageDestination);
}

// Get the current image path from the database
$stmt_image = $conn->prepare("SELECT image FROM admin WHERE uname = ?");
$stmt_image->bind_param("s", $username);
$stmt_image->execute();
$result_image = $stmt_image->get_result()->fetch_assoc();
$currentImagePath = $result_image['image'];

// If no new image is uploaded, retain the current image path
if (empty($imageDestination)) {
    $imageDestination = $currentImagePath;
}

// Get the new password if provided
if (!empty($_POST['password'])) {
    $password = md5($_POST['password']);

    // Update account details in the database with the new password and image
    $sql = "UPDATE admin SET fname=?, mname=?, lname=?, email=?, password=?, role=?, image=? WHERE uname=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssss", $firstName, $middleName, $lastName, $email, $password, $role, $imageDestination, $username);
} else {
    // Update account details in the database without changing the password but updating the image
    $sql = "UPDATE admin SET fname=?, mname=?, lname=?, email=?, role=?, image=? WHERE uname=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssss", $firstName, $middleName, $lastName, $email, $role, $imageDestination, $username);
}

// Execute the query
if ($stmt->execute()) {
    // If the update is successful, redirect to the desired page
    echo '<script>alert("Account updated successfully"); window.location.href = "../account.php";</script>';
} else {
    // If there's an error, display the error message
    echo "Error: " . $sql . "<br>" . $stmt->error;
}

// Close the prepared statement and database connection
$stmt->close();
$stmt_image->close();
$conn->close();
?>
