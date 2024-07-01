<?php
require 'dbconn/conn.php'; // Include your database connection file

header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);

if (!empty($data['cartData'])) {
    foreach ($data['cartData'] as $item) {
        $productId = $item['productId'];
        $quantity = $item['quantity'];
        $price = $item['price'];

        $sql = "UPDATE addcart SET quantity = ?, price = ? WHERE products_id = ? AND customer_id = ? AND status != 'Pending'";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('idii', $quantity, $price, $productId, $user_id);

        if (!$stmt->execute()) {
            echo json_encode(['success' => false, 'message' => 'Failed to save cart data.']);
            exit;
        }
    }

    echo json_encode(['success' => true, 'message' => 'Cart data saved successfully.']);
} else {
    echo json_encode(['success' => false, 'message' => 'No cart data provided.']);
}
?>
