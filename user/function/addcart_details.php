<?php
session_start();
include 'dbconn/conn.php';

$response = ['success' => false, 'message' => ''];

if (isset($_POST['product_id'], $_POST['color'], $_POST['size'], $_POST['quantity'], $_POST['price'])) {
    $product_id = $_POST['product_id'];
    $color = $_POST['color'];
    $size = $_POST['size'];
    $quantity = (int)$_POST['quantity'];
    $price = (float)$_POST['price'];
    $user_id = $_SESSION['user_id'];

    // Check if the product already exists in the cart for the same color and size
    $stmt = $conn->prepare("SELECT id FROM addcart WHERE products_id = ? AND customer_id = ? AND color = ? AND size = ? AND status != 'Paid'");
    $stmt->bind_param("iiss", $product_id, $user_id, $color, $size);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Update the quantity and price if the product already exists in the cart
        $cart_item = $result->fetch_assoc();
        $cart_item_id = $cart_item['id'];
        $stmt = $conn->prepare("UPDATE addcart SET quantity = quantity + ?, price = ? WHERE id = ?");
        $stmt->bind_param("idi", $quantity, $price, $cart_item_id);
    } else {
        // Insert a new cart item
        $stmt = $conn->prepare("INSERT INTO addcart (products_id, customer_id, color, size, quantity, price) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iissid", $product_id, $user_id, $color, $size, $quantity, $price);
    }

    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = 'Product added to cart successfully!';
    } else {
        $response['message'] = 'Failed to add product to cart. Please try again.';
    }
} else {
    $response['message'] = 'Invalid request. Please provide all required data.';
}

echo json_encode($response);
?>
