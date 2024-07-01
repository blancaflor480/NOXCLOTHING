<?php
session_start();
include 'dbconn/conn.php';

header('Content-Type: application/json');

$response = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if user is logged in
    if (!isset($_SESSION['user_id'])) {
        $response['success'] = false;
        $response['message'] = "User not logged in.";
        echo json_encode($response);
        exit;
    }

    // Check if at least one product is selected
    if (!isset($_POST['selected_products']) || empty($_POST['selected_products'])) {
        $response['success'] = false;
        $response['message'] = "No products selected for checkout.";
        echo json_encode($response);
        exit;
    }

    // Sanitize selected products
    $selectedProducts = array_map('intval', $_POST['selected_products']);

    // Begin transaction
    $conn->begin_transaction();

    try {
        // Update addcart table for selected products
        foreach ($selectedProducts as $productId) {
            $stmt = $conn->prepare("UPDATE addcart SET status = 'Pending' WHERE product_id = ? AND customer_id = ? AND status = 'pending'");
            if ($stmt === false) {
                throw new Exception("Database error: " . $conn->error);
            }

            $stmt->bind_param("ii", $productId, $_SESSION['user_id']);
            $stmt->execute();

            if ($stmt->errno) {
                throw new Exception("Database error: " . $stmt->error);
            }

            if ($stmt->affected_rows === 0) {
                throw new Exception("Failed to update cart for product ID: $productId");
            }

            $stmt->close();
        }

        // Commit transaction if all updates are successful
        $conn->commit();

        $response['success'] = true;
        $response['message'] = "Checkout processed successfully.";

    } catch (Exception $e) {
        // Rollback transaction on error
        $conn->rollback();

        $response['success'] = false;
        $response['message'] = $e->getMessage();
    }

} else {
    $response['success'] = false;
    $response['message'] = "Invalid request method.";
}

echo json_encode($response);
?>
