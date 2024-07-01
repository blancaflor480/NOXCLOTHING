<?php
// Include your database connection
session();
include 'dbconn/conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate if the necessary POST data is present
    if (isset($_POST['productId'], $_POST['quantity'])) {
        // Sanitize and validate inputs
        $productId = intval($_POST['productId']);
        $quantity = intval($_POST['quantity']);

        // Validate quantity (if needed)
        if ($quantity < 1) {
            $quantity = 1; // Set minimum quantity if less than 1
        }

        // Check if user is logged in (assuming session is started properly)
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(["success" => false, "message" => "User not logged in."]);
            exit; // Stop further execution
        }

        // Update the quantity in the database
        $stmt = $conn->prepare("UPDATE addcart SET quantity = ? WHERE customer_id = ? AND products_id = ?");
        $stmt->bind_param("iii", $quantity, $_SESSION['user_id'], $productId);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo json_encode(["success" => true, "message" => "Quantity updated successfully."]);
        } else {
            echo json_encode(["success" => false, "message" => "Failed to update quantity."]);
        }

        $stmt->close();
    } else {
        echo json_encode(["success" => false, "message" => "Missing required parameters."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
}
?>
