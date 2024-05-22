<?php
// Include ng database connection
include 'dbconn/conn.php';
session_start();

// Check kung may POST request mula sa AJAX
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Kunin ang product ID mula sa POST request
    $productId = $_POST['productId'];

    // Siguraduhing may user ID sa session bago kunin
    if (isset($_SESSION['user_id'])) {
        $customerId = $_SESSION['user_id'];

        // Suriin kung ang produktong iyon ay nasa wishlist na ng user
        $checkWishlistStmt = $conn->prepare("SELECT * FROM wishlist WHERE customer_id = ? AND products_id = ?");
        $checkWishlistStmt->bind_param("ii", $customerId, $productId);
        $checkWishlistStmt->execute();
        $checkWishlistResult = $checkWishlistStmt->get_result();

        if ($checkWishlistResult->num_rows > 0) {
            // Kung ang produkto ay nasa wishlist na, mag-return ng error response
            echo json_encode(array("success" => false, "message" => "Product already exists in wishlist."));
        } else {
            // Isingit ang product sa wishlist table
            $insertStmt = $conn->prepare("INSERT INTO wishlist (customer_id, products_id) VALUES (?, ?)");
            $insertStmt->bind_param("ii", $customerId, $productId);
            $insertStmt->execute();

            // Mag-return ng success response kung ang lahat ng proseso ay nagtagumpay
            echo json_encode(array("success" => true, "message" => "Product successfully added to wishlist."));
        }
    } else {
        // Kung walang user ID sa session, mag-return ng error response
        echo json_encode(array("success" => false, "message" => "User ID not found in session."));
    }
} else {
    // Kung hindi POST request, mag-return ng error response
    echo json_encode(array("success" => false, "message" => "Invalid request method."));
}

// Isara ang database connection
$conn->close();
?>
