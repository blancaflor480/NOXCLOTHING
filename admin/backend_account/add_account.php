<?php
session_start();
include 'dbconn/conn.php';

// Kunin ang mga detalye ng account mula sa form
$username = isset($_POST['uname']) ? $_POST['uname'] : "";
$firstName = $_POST['fname'];
$middleName = isset($_POST['mname']) ? $_POST['mname'] : "";
$lastName = isset($_POST['lname']) ? $_POST['lname'] : "";
$email = $_POST['email'];
$password = md5($_POST['password']);
$role = $_POST['role'];

// Kunin ang mga detalye ng larawan
$imageName = $_FILES['image']['name'];
$imageTmpName = $_FILES['image']['tmp_name'];
$imageSize = $_FILES['image']['size'];
$imageError = $_FILES['image']['error'];

// Kung mayroong larawan na ipinadala
if ($imageError === 0) {
    $imageDestination = '../uploads/' . $imageName;
    move_uploaded_file($imageTmpName, $imageDestination);
} else {
    // Kapag may error sa pag-upload ng larawan
    echo "Error uploading image!";
}

// Query para idagdag ang account sa database kasama ang larawan
$sql = "INSERT INTO admin (fname, mname, lname, uname, email, password, role, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssssss", $firstName, $middleName, $lastName, $username, $email, $password, $role, $imageDestination);

// Patakbuhin ang query
if ($stmt->execute()) {
    // Kung ang pagdaragdag ay matagumpay, i-redirect sa kung saan man nais mong dalhin ang user
    echo '<script>alert("Account added successfully"); window.location.href = "../account.php";</script>';
} else {
    // Kung may error, ipakita ang error message
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Isara ang prepared statement at kawing sa database
$stmt->close();
$conn->close();
?>

?>
