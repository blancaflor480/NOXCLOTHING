<?php
session_start();
include 'dbconn/conn.php';

// Get account details from the form
$customerId = $_POST['customerId']; // Hidden input field to store customer ID
$firstName = $_POST['fname'];
$middleName = isset($_POST['mname']) ? $_POST['mname'] : "";
$lastName = isset($_POST['lname']) ? $_POST['lname'] : "";
$username = $_POST['uname'];
$email = $_POST['email'];

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

// Get other form fields
$region = isset($_POST['region']) ? $_POST['region'] : ""; // Ensure region is not empty
$province = isset($_POST['province']) ? $_POST['province'] : "";
$city = isset($_POST['city']) ? $_POST['city'] : "";
$street = isset($_POST['street']) ? $_POST['street'] : "";
$zipcode = isset($_POST['zipcode']) ? $_POST['zipcode'] : "";

// Update account details in the database
$sql = "UPDATE customer SET fname=?, mname=?, lname=?, email=?, region=?, province=?, city=?, street=?, zipcode=?, image=? WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssssssssi", $firstName, $middleName, $lastName, $email, $region, $province, $city, $street, $zipcode, $imageDestination, $customerId);

// Execute the query
if ($stmt->execute()) {
    // If the update is successful, redirect to the desired page
    echo '<script>alert("Account updated successfully"); window.location.href = "../customer.php";</script>';
} else {
    // If there's an error, display the error message
    echo "Error: " . $sql . "<br>" . $stmt->error;
}

// Close the prepared statement and database connection
$stmt->close();
$conn->close();
?>
