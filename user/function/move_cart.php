<?php
session_start();
include '../dbconn/conn.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["success" => false, "message" => "Login First"]);
    exit();
}

$user_id = $_SESSION['user_id'];
$productId = $_POST['productId'];

// Check if product is in the wishlist
$checkWishlistQuery = "SELECT * FROM wishlist WHERE customer_id = ? AND products_id = ?";
$stmt = $conn->prepare($checkWishlistQuery);
$stmt->bind_param("ii", $user_id, $productId);
$stmt->execute();
$wishlistResult = $stmt->get_result();

if ($wishlistResult->num_rows > 0) {
    // Move item to cart
    $moveToCartQuery = "INSERT INTO addcart (customer_id, products_id, quantity, status) VALUES (?, ?, 1, 'Pending')";
    $stmt = $conn->prepare($moveToCartQuery);
    $stmt->bind_param("ii", $user_id, $productId);
    $stmt->execute();

    // Remove item from wishlist
    $removeFromWishlistQuery = "DELETE FROM wishlist WHERE customer_id = ? AND products_id = ?";
    $stmt = $conn->prepare($removeFromWishlistQuery);
    $stmt->bind_param("ii", $user_id, $productId);
    $stmt->execute();

    echo json_encode(["success" => true, "message" => "Item moved to cart"]);
} else {
    echo json_encode(["success" => false, "message" => "Item not found in wishlist"]);
}
?>
