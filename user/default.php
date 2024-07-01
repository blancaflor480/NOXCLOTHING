	<?php 
	session_start();
	if (!isset($_SESSION['email'])) {
		header("Location: index.php?error=Login%20First");
		exit();
	}
	$user_id = $_SESSION['user_id'];
	// Include database connection
	include 'dbconn/conn.php';
	$servername = "localhost"; 
	$username = "root"; 
	$password = ""; 
	$dbname = "noxclothing"; 
	$conn = new mysqli($servername, $username, $password, $dbname);
	$email = $_SESSION['email'];
	$user_id = $_SESSION['user_id'];
	
	if(isset($_POST["delete"])){
		$sqldel = "DELETE FROM customer WHERE id=$user_id";
				if(mysqli_query($conn,$sqldel)){
																		echo "<script>alert('Deleted Successfully!'); window.location='address.php';</script>";
																		exit(); 
																	}
	}
	
	if(isset($_POST["delete1"])){
		$sqldel5 = "DELETE FROM subaddress WHERE id=$user_id";
				if(mysqli_query($conn,$sqldel5)){
																		echo "<script>alert('Deleted Successfully!'); window.location='address.php';</script>";
																		exit(); 
																	}
	}
	
	
	
	
	
	
	
	if(isset($_POST["submit"])){
		$sql = "SELECT `id`, `region`, `province`, `barangay`, `city`, `zipcode`, `street` FROM `subaddress` WHERE id=$user_id";
	$result = $conn->query($sql); // assuming $mysqli is your MySQLi connection object

	if ($result->num_rows > 0) {
		while ($row = $result->fetch_assoc()) {
			$id = $row['id'];
			$region = $row['region'];
			$province = $row['province'];
			$barangay = $row['barangay'];
			$city = $row['city'];
			$zipcode = $row['zipcode'];
			$street = $row['street'];
		
		}
	}
										$sql2 = "SELECT `id`, `region`, `province`, `barangay`, `city`, `zipcode`, `street` FROM `customer` WHERE id=$user_id";
									$resultz = $conn->query($sql2); 

									if ($resultz->num_rows > 0) {
										while ($row1 = $resultz->fetch_assoc()) {
											$id1 = $row1['id'];
											$region1 = $row1['region'];
											$province1 = $row1['province'];
											$barangay1 = $row1['barangay'];
											$city1 = $row1['city'];
											$zipcode1 = $row1['zipcode'];
											$street1 = $row1['street'];
											
										}
									}

			$sqlko = "UPDATE `customer` 
			  SET `region`='$region', 
				  `province`='$province', 
				  `barangay`='$barangay', 
				  `city`='$city', 
				  `zipcode`='$zipcode', 
				  `street`='$street' 
			  WHERE `id`='$user_id'";

				if(mysqli_query($conn,$sqlko)){
					
				}
												$sqlko1 = "UPDATE `subaddress` 
													  SET `region`='$region1', 
														  `province`='$province1', 
														  `barangay`='$barangay1', 
														  `city`='$city1', 
														  `zipcode`='$zipcode1', 
														  `street`='$street1' 
													  WHERE `id`='$user_id'";

														if(mysqli_query($conn,$sqlko1)){
															echo "<script>alert('Submitted Successfully!'); window.location='address.php';</script>";
															exit(); 
														}


	}//submit semicolon
	?>