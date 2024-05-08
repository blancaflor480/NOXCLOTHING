<?php
include 'dbconn/conn.php';

// Kunin ang mga input mula sa form
$productId = $_POST['productID'];
$productName = $_POST['editProductName'];
$genre = $_POST['genre'];
$platform = $_POST['platform'];
$developer = $_POST['developer'];
$publisher = $_POST['publisher'];
$release_date = $_POST['release_date'];
$mature_content = $_POST['mature_content'];
$image_path = $_POST['image_path'];
$price = $_POST['price'];

// Prepare and bind parameters for the update query
$stmt = $conn->prepare("UPDATE products SET name=?, genre=?, platform=?, developer=?, publisher=?, release_date=?, mature_content=?, image_path=?, price=? WHERE id=?");
$stmt->bind_param("sssssssssi", $productName, $genre, $platform, $developer, $publisher, $release_date, $mature_content, $image_path, $price, $productId);

// Execute the update query
if ($stmt->execute()) {
    echo '<script>alert("Record updated successfully"); window.location.href = "games.php";</script>';
} else {
    echo '<script>alert("Error updating record: ' . $conn->error . '"); window.location.href = "games.php";</script>';
}

// Close statement and database connection
$stmt->close();
$conn->close();
?>
