<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.html");
    exit();
} else {
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

    $conn = new mysqli($host, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $mobileNumber = isset($_POST['mobileNumber']) ? $_POST['mobileNumber'] : null;
    if ($mobileNumber !== null) {
        $query = "SELECT * FROM newChat WHERE MobileNumber = '$mobileNumber';";
        $result = mysqli_query($conn, $query);

        // Fetch the name from the result
        if ($result && $row = mysqli_fetch_assoc($result)) {
            $name = $row['Name'];
            echo json_encode(array('name' => $name));
        } else {
            echo json_encode(array('error' => 'Person not found'));
        }
    } else {
        echo json_encode(array('error' => 'Invalid request'));
    }

    mysqli_close($conn);
}
?>
