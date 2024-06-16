<?php
/*
    You can use own remote MySQL Server also
*/
$host = 'localhost:3306';
$username = 'root';
$password = '';
$database = 'chatapp';

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    // Get data from the JavaScript
    //$mobileNumber = $_POST['mobileNumber'];
    $mobileNumber = isset($_POST['mobileNumber']) ? $_POST['mobileNumber'] : null;

  if ($mobileNumber !== null){
    $sql = "DELETE FROM newChat WHERE MobileNumber = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $mobileNumber);

    if ($stmt->execute()) {
        echo "Item deleted Successfully";
        $conn->commit();
    } else {
        echo "Error deleting item: " . $stmt->error;
        error_log($stmt->error);
    }

    $stmt->close();
    }else{
        echo "Mobile number not provided in the request.";
    }
}

$conn->close();
?>
