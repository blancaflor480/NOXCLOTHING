<?php
session_start();
if (!isset($_SESSION['uname'])) {
    header("Location: index.php?error=Login%20First");
    die();
}

include 'dbconn/conn.php';

// Kunin ang mga detalye ng produkto mula sa form
$productName = $_POST['productName'];
$genre = $_POST['genre'];
$platform = $_POST['platform'];
$developer = $_POST['developer'];
$publisher = $_POST['publisher'];
$release_date = $_POST['release_date'];
$mature_content = $_POST['mature_content'];
$price = $_POST['price'];

$release_date_mysql = date('Y-m-d', strtotime($release_date));

if ($_FILES["image"]["error"] == 0) {
    $image_name = addslashes($_FILES['image']['name']);
    $image_size = $_FILES["image"]["size"];

    if ($image_size > 10000000) {
        die("File size is too big!");
    }

    move_uploaded_file($_FILES["image"]["tmp_name"], "uploads/" . $image_name);

    $sql = "INSERT INTO products (name, genre, platform, developer, publisher, release_date, mature_content, price, image_path) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssis", $productName, $genre, $platform, $developer, $publisher, $release_date_mysql, $mature_content, $price, $image_name);

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
