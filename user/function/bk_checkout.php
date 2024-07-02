<?php
include 'dbconn/conn.php';


// Mga detalye mula sa frontend
$data = json_decode(file_get_contents('php://input'), true);
$addcartIds = $data['addcartIds'];  // Kunin ang mga addcartIds

// Mga detalye ng order
$invoice = uniqid();  // Lumikha ng invoice number
$status = "Pending";  // Default status

// Simulan ang transaction
$conn->begin_transaction();

try {
    // I-insert ang order sa orders table
    $stmt = $conn->prepare("INSERT INTO orders (products_id, addcart_id, invoice, status, total_amount, order_date) 
                            SELECT ac.products_id, ac.id, ?, ?, ac.total_price, NOW() 
                            FROM addcart ac
                            WHERE ac.id IN (".implode(',', array_fill(0, count($addcartIds), '?')).")");
    
    // Bind parameters para sa prepared statement
    $stmt->bind_param("ss", $invoice, $status);
    
    // Bind ang addcartIds bilang parameters
    foreach ($addcartIds as $key => $addcartId) {
        $stmt->bind_param(($key + 1), $addcartId); // Dapat magdagdag ka ng data type (s, i, etc.) depende sa iyong schema
    }
    
    // I-execute ang statement
    $stmt->execute();

    // Kunin ang last inserted ID
    $order_id = $stmt->insert_id;

    // Mark as processed ang mga items sa addcart na na-order
    $stmt2 = $conn->prepare("UPDATE addcart SET status = 'Ordered' WHERE id IN (".implode(',', array_fill(0, count($addcartIds), '?')).")");
    
    // Bind ang addcartIds bilang parameters
    foreach ($addcartIds as $key => $addcartId) {
        $stmt2->bind_param(($key + 1), $addcartId); // Dapat magdagdag ka ng data type (s, i, etc.) depende sa iyong schema
    }
    
    // I-execute ang statement
    $stmt2->execute();

    // Commit ng transaction
    $conn->commit();

    // I-display ang response
    echo json_encode(array("message" => "Order successfully placed.", "order_id" => $order_id));
} catch (Exception $e) {
    // Kung may error, rollback ang transaction
    $conn->rollback();
    echo json_encode(array("message" => "Failed to place order. Error: " . $e->getMessage()));
}

// Isara ang mga statements
$stmt->close();
$stmt2->close();
$conn->close();
?>
