<?php
session_start();
include '../dbconn/conn.php';

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Initialize variables and handle missing data
    $firstName = isset($_POST['fname']) ? $_POST['fname'] : null;
    $middleName = isset($_POST['mname']) ? $_POST['mname'] : null;
    $lastName = isset($_POST['lname']) ? $_POST['lname'] : null;
    $birthday = isset($_POST['bday']) ? $_POST['bday'] : null;
    $image = isset($_FILES['image']) ? $_FILES['image'] : null;
    $region = isset($_POST['region']) ? $_POST['region'] : null;
    $province = isset($_POST['province']) ? $_POST['province'] : null;
    $city = isset($_POST['city']) ? $_POST['city'] : null;
    $street = isset($_POST['street']) ? $_POST['street'] : null;
    $zipcode = isset($_POST['zipcode']) ? $_POST['zipcode'] : null;
    $username = isset($_POST['uname']) ? $_POST['uname'] : null;
    $email = isset($_POST['email']) ? $_POST['email'] : null;
    $password = isset($_POST['password']) ? md5($_POST['password']) : null;
    
    // Validate required fields
    if (!$firstName || !$lastName || !$birthday || !$image || !$region || !$province || !$city || !$street || !$zipcode || !$username || !$email || !$password) {
        echo 'All fields are required.';
        exit();
    }

    // Image handling
    if ($image['error'] === 0) {
        $imageName = $image['name'];
        $imageTmpName = $image['tmp_name'];
        $imageSize = $image['size'];
        $imageError = $image['error'];
        $imageType = $image['type'];

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
                    $sql = "INSERT INTO customer (fname, mname, lname, bday, region, province, city, street, zipcode, uname, email, password, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("sssssssssssss", $firstName, $middleName, $lastName, $birthday, $region, $province, $city, $street, $zipcode, $username, $email, $password, $imageDestination);

                    // Execute the query
                    if ($stmt->execute()) {
                        echo '<script>alert("Customer added successfully"); window.location.href = "../customer.php";</script>';
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
