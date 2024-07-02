<?php
session_start();

if (!isset($_SESSION['email'])) {
    // Redirect if user is not logged in
    header("Location: index.php?error=Login%20First");
    exit();
}

include 'dbconn/conn.php'; // Include your database connection

// Get user ID from session
$user_id = $_SESSION['user_id'];

// Get the JSON input from the request body
$data = json_decode(file_get_contents('php://input'), true);

// Check if selectedItems is set and is an array
if (isset($data['selectedItems']) && is_array($data['selectedItems']) && !empty($data['selectedItems'])) {
    $selectedItems = $data['selectedItems'];
    $success = true;
    $errors = [];

    // Start a transaction
    $conn->begin_transaction();

    try {
        foreach ($selectedItems as $addcartId) {
            if (is_numeric($addcartId)) {
                // Check if addcart_id exists for the user and not already in p_checkout
                $stmt_select = $conn->prepare("SELECT id FROM addcart WHERE id = ? AND customer_id = ?");
                $stmt_select->bind_param("ii", $addcartId, $user_id);
                $stmt_select->execute();
                $result = $stmt_select->get_result();

                if ($result->num_rows > 0) {
                    // Check if addcart_id already exists in p_checkout
                    $stmt_check_existing = $conn->prepare("SELECT addcart_id FROM p_checkout WHERE addcart_id = ?");
                    $stmt_check_existing->bind_param("i", $addcartId);
                    $stmt_check_existing->execute();
                    $existing_result = $stmt_check_existing->get_result();

                    if ($existing_result->num_rows == 0) {
                        // Insert into p_checkout table
                        $stmt_insert = $conn->prepare("INSERT INTO p_checkout (addcart_id, date) VALUES (?, NOW())");
                        $stmt_insert->bind_param("i", $addcartId); // Bind addcart_id parameter
                        if ($stmt_insert->execute()) {
                            $stmt_insert->close();
                        } else {
                            throw new Exception("Execute failed for addcart_id: $addcartId - " . $stmt_insert->error);
                        }
                    } else {
                        throw new Exception("addcart_id: $addcartId already exists in p_checkout.");
                    }
                } else {
                    throw new Exception("addcart_id: $addcartId does not exist for user_id: $user_id");
                }

                $stmt_select->close();
                $stmt_check_existing->close();
            } else {
                throw new Exception("Invalid addcart_id: $addcartId");
            }
        }

        // Commit the transaction
        $conn->commit();
        echo json_encode(["success" => true, "message" => "Items inserted into p_checkout successfully."]);

    } catch (Exception $e) {
        // Rollback the transaction if something went wrong
        $conn->rollback();
        $errors[] = $e->getMessage();
        echo json_encode(["success" => false, "message" => "Failed to insert items into checkout: Some items failed to insert.", "errors" => $errors]);
    }

} else {
    echo json_encode(["success" => false, "message" => "Invalid or empty selectedItems provided."]);
}

$conn->close();

?>
