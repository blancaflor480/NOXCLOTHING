<?php
session_start();
if (!isset($_SESSION['uname'])) {
    header("Location: login-signup.php?error=Login%20First");
    die();
}

include 'dbconn/conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['productID'])) {
        $productID = $_POST['productID'];

        // Query para sa pag-delete ng produkto
        $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
        $stmt->bind_param("i", $productID);

        if ($stmt->execute()) {
            // Produkto ay matagumpay na na-delete
            header("Location: games.php?success=Product%20successfully%20deleted");
            exit();
        } else {
            // May error sa pag-delete ng produkto
            header("Location: games.php?error=Failed%20to%20delete%20product");
            exit();
        }
    } else {
        // Walang productID na natanggap
        header("Location: games.php?error=Product%20ID%20not%20provided");
        exit();
    }
} else {
    // Hindi POST request
    header("Location: games.php");
    exit();
}
?>
