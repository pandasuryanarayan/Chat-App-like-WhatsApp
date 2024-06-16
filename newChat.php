<?php
/*
$host = 'sql12.freemysqlhosting.net:3306';
$username = 'sql12664995';
$password = 'mkIpwmbBAz';
$database = 'sql12664995';
*/
$host = 'localhost:3306';
$username = 'root';
$password = '';
$database = 'cn_project';

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}else{
    // Get data from the JavaScript
    $name = $_POST['name'];
    $mobileNumber = $_POST['mobileNumber'];

    // SQL query to insert data into the 'newchat' table
    $stmt = $conn->prepare("INSERT INTO newChat (Name, MobileNumber) VALUES (?,?);");
    $stmt->bind_param("si",$name, $mobileNumber);

    if ($stmt->execute()) {
        echo "Chat created and data inserted successfully";
        $conn->commit();
    }else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>