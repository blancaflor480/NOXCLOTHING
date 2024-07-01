<?php
session_start();
include 'dbconn/conn.php'; // Ensure this includes your database connection

header('Content-Type: application/json'); // Ensure JSON header

$response = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if user is logged in
    if (!isset($_SESSION['user_id'])) {
        $response['success'] = false;
        $response['message'] = "User not logged in.";
        echo json_encode($response);
        exit;
    }

    // Validate and sanitize inputs
    if (isset($_POST['id'], $_POST['quantity'])) {
        $productId = intval($_POST['id']);
        $quantity = intval($_POST['quantity']);

        // Validate quantity if needed
        if ($quantity < 1) {
            $response['success'] = false;
            $response['message'] = "Quantity must be at least 1.";
            echo json_encode($response);
            exit;
        }

        // Update the addcart table
        $stmt = $conn->prepare("UPDATE addcart SET quantity = ? WHERE product_id = ? AND customer_id = ? AND status = 'pending'");
        if ($stmt === false) {
            $response['success'] = false;
            $response['message'] = "Database error: " . $conn->error;
            echo json_encode($response);
            exit;
        }

        // Bind parameters and execute the statement
        $stmt->bind_param("iii", $quantity, $productId, $_SESSION['user_id']);
        $stmt->execute();

        // Check for errors and affected rows
        if ($stmt->errno) {
            $response['success'] = false;
            $response['message'] = "Database error: " . $stmt->error;
        } else {
            if ($stmt->affected_rows > 0) {
                $response['success'] = true;
                $response['message'] = "Cart updated successfully.";
            } else {
                $response['success'] = false;
                $response['message'] = "Failed to update cart. No rows affected.";
            }
        }

        $stmt->close();
    } else {
        $response['success'] = false;
        $response['message'] = "Missing required parameters.";
    }
} else {
    $response['success'] = false;
    $response['message'] = "Invalid request method.";
}

echo json_encode($response); // Output JSON response
?>
