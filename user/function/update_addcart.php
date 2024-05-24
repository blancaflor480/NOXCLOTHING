<?php
 include 'dbconn/conn.php';
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: index.php?error=Login%20First");
    exit();
}

include 'dbconn/conn.php';

$id = $_POST['id'];
$quantity = $_POST['quantity'];

// Update quantity in the cart
$sql = "UPDATE addcart SET quantity = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $quantity, $id);

$response = [];
if ($stmt->execute()) {
    $response['success'] = true;
} else {
    $response['success'] = false;
}

$stmt->close();
$conn->close();

echo json_encode($response);
?>
