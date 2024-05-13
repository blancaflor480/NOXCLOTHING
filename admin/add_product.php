<?php
session_start();
if (!isset($_SESSION['uname'])) {
    header("Location: index.php?error=Login%20First");
    die();
}

include 'dbconn/conn.php';

// Kunin ang mga detalye ng produkto mula sa form
$productName = $_POST['productName'];
$color = $_POST['color'];
$size = $_POST['size'];
$category = $_POST['category'];
$quantity = $_POST['quantity'];
$status = $_POST['status'];
$type = $_POST['type'];
$manufacturer = $_POST['manufacturer'];
$description = isset($_POST['description']) ? $_POST['description'] : '';
$discount = $_POST['discount'];
$price = $_POST['price'];


if ($_FILES["image_front"]["error"] == 0) {
    $image_name = addslashes($_FILES['image_front']['name']);
    $image_size = $_FILES["image_front"]["size"];

    if ($image_size > 10000000) {
        die("File size is too big!");
       }
       move_uploaded_file($_FILES["image_front"]["tmp_name"], "uploads/" . $image_name);

    $sql = "INSERT INTO products (name_item, type, color, size, manufacturer, description, category, quantity, status, image_front,discount, price) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
     $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssssii", $productName, $type, $color, $size, $manufacturer, $description, $category, $quantity, $status, $image_name, $discount, $price);


    // Patakbuhin ang query
    if ($stmt->execute()) {
        // Kung ang pagdaragdag ay matagumpay, i-redirect sa product list page
        echo '<script>alert("Record added successfully"); window.location.href = "games.php";</script>';
    } else {
        // Kung may error, ipakita ang error message
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Isara ang prepared statement at kawing sa database
    $stmt->close();
} else {
    // Kung may error sa pag-upload, maglabas ng error message
    echo "There was an error uploading your file!";
}

// Isara ang kawing sa database
$conn->close();
?>
