<?php
    session_start();
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
    
    if(!$conn){
        die('Not Connected to ' . mysqli_connect_error());
    }else{
        echo 'Connection was Successful <br>';
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $moNo = $_POST['signin-MoNo'];
            $pass = $_POST['signin-password'];

            if(!$moNo && !$pass){
                echo "Enter all details..";
                header("Location: index.html");
                exit();
            }else {
                if(strlen($moNo) !== 10 || strlen($pass) < 8){
                    echo "Mobile Number should be exactly 10 digits and password should be greater than 8";
                    header("Location: index.html");
                    exit();
                }else{
                    $sql = "SELECT * FROM signup WHERE MobileNumber = '$moNo' ";
                    $result = $conn->query($sql);
                    if($result && $result->num_rows > 0){
                        $row = $result->fetch_assoc();
                        $_SESSION['user_id'] = session_id();
                        
                        header("Location: chats.php");
                        exit();
                    }else{
                        echo "Error";
                    }
                }
            }
        }
    }
    $conn->close();
?>