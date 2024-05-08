<?php
session_start();
include 'dbconn/conn.php';

// Kunin ang mga detalye ng account mula sa form
$firstName = $_POST['fname'];
$middleName = isset($_POST['mname']) ? $_POST['mname'] : ""; // Check kung may value ang mname bago kunin
$lastName = isset($_POST['lname']) ? $_POST['lname'] : ""; // Check kung may value ang lname bago kunin
$username = $_POST['uname'];
$email = $_POST['email'];
$role = $_POST['role'];


// Kunin ang file details ng image kung meron
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

// Pagkuha ng bagong password kung mayroon
if (!empty($_POST['password'])) {
    $password = md5($_POST['password']); // I-encrypt ang password gamit ang MD5

    // Query para i-update ang account sa database kasama ang bagong password at larawan
    $sql = "UPDATE admin SET fname=?, mname=?, lname=?, email=?, password=?, role=?, image=? WHERE uname=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssss", $firstName, $middleName, $lastName, $email, $password, $role, $imageDestination, $username);
} else {
    // Kung walang inilagay na bagong password, i-update lamang ang ibang impormasyon at larawan
    $sql = "UPDATE admin SET fname=?, mname=?, lname=?, email=?, role=?, image=? WHERE uname=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssss", $firstName, $middleName, $lastName, $email, $role, $imageDestination, $username);
}

// Patakbuhin ang query
if ($stmt->execute()) {
    // Kung ang pag-update ay matagumpay, i-redirect sa kung saan man nais mong dalhin ang user
    echo '<script>alert("Account updated successfully"); window.location.href = "../account.php";</script>';
} else {
    // Kung may error, ipakita ang error message
    echo "Error: " . $sql . "<br>" . $stmt->error;
}

// Isara ang prepared statement at kawing sa database
$stmt->close();
$conn->close();
?>
