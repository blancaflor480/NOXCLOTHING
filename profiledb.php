<?php
session_start();
$user_id = $_SESSION['user_id'];
$_SESSION['user_id'] = $user_id;
$email = $_SESSION['email'];
$_SESSION['email']=$email;
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "noxclothing"; 
$conn = new mysqli($servername, $username, $password, $dbname);

$id=$_SESSION['user_id'];
$a = new mysqli($servername, $username, $password, $dbname);
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
    if (is_uploaded_file($_FILES['image']['tmp_name'])) {
        // Get the image content
        $image = file_get_contents($_FILES['image']['tmp_name']);
        
        // Use prepared statement to update image data in the database for a specific ID
        $stmt = $conn->prepare("UPDATE customer SET `image`=? WHERE id=?");
        $stmt->bind_param("si", $image, $user_id);

        if ($stmt->execute()) {
            echo "Image uploaded successfully.";
        } else {
            echo "Error updating image: " . $stmt->error;
        }

        // Close the prepared statement
        $stmt->close();
    } else {
        echo "Error: Please select a valid image file.";
    }
}

if (isset($_POST['submit'])) {
	$fname=$_POST['fname'];
	$mname=$_POST['mname'];
	$lname=$_POST['lname'];
	$emailadd=$_POST['email'];
	$phone=$_POST['phone'];
	$gender1=$_POST['gender'];
	$date=$_POST['birth'];
	
	
	$sql = "UPDATE customer SET 
                fname = '$fname', 
                mname = '$mname', 
                lname = '$lname', 
                email = '$emailadd', 
                contactnumber = '$phone', 
                gender = '$gender1', 
                bday = '$date'
			
            WHERE id = '$id'"; // Assuming email is unique and used as identifier

    
    if(mysqli_query($a,$sql)){	
		$_SESSION['email'] = $emailadd;
		header("Location: profile.php");
	}
}
?>