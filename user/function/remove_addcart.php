<?php
    // Include your database connection file
    include 'dbconn/conn.php';

    // Check if cart item id is provided
    if(isset($_POST['cartItemId'])) {
        $cartItemId = $_POST['cartItemId'];
        
        // SQL query to delete item from cart based on cart item id
        $sql = "DELETE FROM addcart WHERE id = $cartItemId";
        
        // Execute the query
        if(mysqli_query($conn, $sql)) {
            // Send a success response
            echo "success";
        } else {
            // Send an error response
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        // Send an error response if cart item id is not provided
        echo "Error: Cart item id not provided";
    }
?>
