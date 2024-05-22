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

        // Suriin kung ang produktong iyon ay nasa cart na ng user
        $checkCartStmt = $conn->prepare("SELECT * FROM addcart WHERE customer_id = ? AND products_id = ?");
        $checkCartStmt->bind_param("ii", $customerId, $productId);
        $checkCartStmt->execute();
        $checkCartResult = $checkCartStmt->get_result();

        if ($checkCartResult->num_rows > 0) {
            // Kung ang produkto ay nasa cart na, mag-return ng error response
            echo json_encode(array("success" => false, "message" => "Product already exists in cart."));
        } else {
            // Kunin ang price ng product mula sa database
            $stmt = $conn->prepare("SELECT price FROM products WHERE id = ?");
            $stmt->bind_param("i", $productId);
            $stmt->execute();
            $result = $stmt->get_result();

            // Siguraduhing may resulta bago kunin ang data
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $price = $row['price'];

                // Isingit ang order sa addcart table
                $quantity = 1; // Kung default na 1, maaari mong baguhin depende sa iyong pangangailangan
                $total = $price * $quantity;
                // Ito ay default na 1, pwede mong baguhin depende sa iyong pagtatasa
                $insertStmt = $conn->prepare("INSERT INTO addcart (customer_id, products_id, quantity, price) VALUES (?, ?, ?, ?)");
                $insertStmt->bind_param("iiid", $customerId, $productId, $quantity, $total);
                $insertStmt->execute();

                // Mag-return ng success response kung ang lahat ng proseso ay nagtagumpay
                echo json_encode(array("success" => true, "message" => "Product successfully added to cart."));
            } else {
                // Kung walang resulta (invalid product ID), mag-return ng error response
                echo json_encode(array("success" => false, "message" => "Invalid product ID."));
            }
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





