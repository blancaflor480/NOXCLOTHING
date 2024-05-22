<?php
session_start();

// Include ng database connection
include 'dbconn/conn.php';

// Kunin ang 'user_id' mula sa session
$user_id = $_SESSION['user_id'];

// Query to count the number of items in the user's cart
$query = $conn->prepare("SELECT COUNT(id) AS numberwish FROM wishlist WHERE customer_id = ?");
$query->bind_param("s", $user_id);
$query->execute();
$result = $query->get_result();

// Check if there are items in the cart
if ($result && $result->num_rows > 0) { 
    $row = $result->fetch_assoc();
    $numberwish = $row['numberwish'];
} else {
    $numberwish = 0;
}

// Return the count of items in the cart as response
echo $numberwish;
?>
