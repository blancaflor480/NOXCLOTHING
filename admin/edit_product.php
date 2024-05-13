<?php
session_start();
include 'dbconn/conn.php';

$productId = $_POST['productID'];
$editProductName = $_POST['editProductName'];
$editProductColor = $_POST['editProductColor'];
$editProductSize = $_POST['editProductSize'];
$editProductCategory = $_POST['editProductCategory'];
$editProductQuantity = $_POST['editProductQuantity'];
$editProductStatus = $_POST['editProductStatus'];
$editProductType = $_POST['editProductType'];
$editProductManufacturer = $_POST['editProductManufacturer'];
$editDescription = isset($_POST['editDescription']) ? $_POST['editDescription'] : '';
$editDiscount = $_POST['editDiscount'];
$editPrice = $_POST['editPrice'];

// Prepare and bind parameters for the update query
$stmt = $conn->prepare("UPDATE products SET name_item=?, type=?, color=?, size=?, manufacturer=?, description=?, category=?, quantity=?, status=?, discount=?, price=? WHERE id=?");
$stmt->bind_param("sssssssssssi", $editProductName, $editProductType, $editProductColor, $editProductSize, $editProductManufacturer, $editDescription, $editProductCategory, $editProductQuantity, $editProductStatus,  $editDiscount, $editPrice, $productId);

// Execute the update query
if ($stmt->execute()) {
    $_SESSION['success_message'] = "Record updated successfully.";
} else {
    $_SESSION['error_message'] = "Error updating record: " . $conn->error;
}

// Check if there is a file selected for the image
if (!empty($_FILES['image_front']['name'])) {
    // Directory where the image will be moved
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["image_front"]["name"]);

    // If there are no errors, try to upload the file
    if (move_uploaded_file($_FILES["image_front"]["tmp_name"], $target_file)) {
        // Update the 'image_path' field in the database
        $update_image_stmt = $conn->prepare("UPDATE products SET image_front=? WHERE id=?");
        $update_image_stmt->bind_param("si", basename($_FILES["image_front"]["name"]), $productId);
        if ($update_image_stmt->execute()) {
            $_SESSION['success_message'] = "Record updated successfully.";
        } else {
            $_SESSION['error_message'] = "Failed to upload image.";
        }
    } else {
        $_SESSION['error_message'] = "Sorry, there was an error uploading your image file.";
    }
}

// Redirect to games.php
header("Location: games.php");
exit();
?>
