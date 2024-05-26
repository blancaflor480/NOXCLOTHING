<?php
session_start();
include '../dbconn/conn.php';

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Initialize variables and handle missing data
    $username = isset($_POST['uname']) ? $_POST['uname'] : null;
    $firstName = isset($_POST['fname']) ? $_POST['fname'] : null;
    $middleName = isset($_POST['mname']) ? $_POST['mname'] : null;
    $lastName = isset($_POST['lname']) ? $_POST['lname'] : null;
    $email = isset($_POST['email']) ? $_POST['email'] : null;
    $password = isset($_POST['password']) ? md5($_POST['password']) : null;
    $role = isset($_POST['role']) ? $_POST['role'] : null;

    // Validate required fields
    if (!$username || !$firstName || !$lastName || !$email || !$password || !$role) {
        echo 'All fields are required.';
        exit();
    }

    // Image handling
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $imageName = $_FILES['image']['name'];
        $imageTmpName = $_FILES['image']['tmp_name'];
        $imageSize = $_FILES['image']['size'];
        $imageError = $_FILES['image']['error'];
        $imageType = $_FILES['image']['type'];

        // Allowed file types
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $imageExt = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));

        // Validate file type
        if (in_array($imageExt, $allowed)) {
            // Check file size (limit to 5MB)
            if ($imageSize < 5000000) {
                $uniqueImageName = uniqid('', true) . "." . $imageExt;
                $imageDestination = '../uploads/' . $uniqueImageName;

                // Move uploaded file
                if (move_uploaded_file($imageTmpName, $imageDestination)) {
                    // Insert into database
                    $sql = "INSERT INTO admin (fname, mname, lname, uname, email, password, role, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("ssssssss", $firstName, $middleName, $lastName, $username, $email, $password, $role, $imageDestination);

                    // Execute the query
                    if ($stmt->execute()) {
                        echo '<script>alert("Account added successfully"); window.location.href = "../account.php";</script>';
                    } else {
                        echo "Error: " . $stmt->error;
                    }

                    $stmt->close();
                    $conn->close();
                } else {
                    echo 'Error moving uploaded file.';
                }
            } else {
                echo 'File size exceeds limit.';
            }
        } else {
            echo 'Invalid file type.';
        }
    } else {
        echo 'Error uploading image!';
    }
} else {
    echo 'Invalid request method.';
}
?>
