<?php
session_start();

// Include database connection
include '../dbconn/conn.php';

$response = array('success' => false, 'message' => '');

if (isset($_POST['wishlistId'])) {
    $wishlistId = $_POST['wishlistId'];

    // Check if user is logged in
    if (!isset($_SESSION['user_id'])) {
        $response['message'] = "User not logged in.";
        echo json_encode($response);
        exit();
    }

    $userId = $_SESSION['user_id'];

    // Remove item from wishlist
    $stmt = $conn->prepare("DELETE FROM wishlist WHERE id = ? AND customer_id = ?");
    $stmt->bind_param("ii", $wishlistId, $userId);

    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = "Item removed from wishlist successfully.";
    } else {
        $response['message'] = "Failed to remove item from wishlist.";
    }

    $stmt->close();
} else {
    $response['message'] = "Invalid request.";
}

echo json_encode($response);
?>
