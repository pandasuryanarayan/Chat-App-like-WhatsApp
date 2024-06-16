<?php
    /*
       You can use own remote MySQL Server also
    */
    $host = 'localhost:3306';
    $username = 'root';
    $password = '';
    $database = 'chatapp';

    $conn = new mysqli($host, $username, $password, $database);
    
    if(!$conn){
        die('Not Connected to ' . mysqli_connect_error());
    }else{
        echo 'Connection was Successful <br>';
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $name = $_POST['signup-name'];
            $moNo = $_POST['signup-MoNo'];
            $pass = $_POST['signup-password'];

            if(!$name && !$moNo && !$pass){
                alert('Enter all details..');
            }else {
                if($name === null || $name.trim($name) === ''){
                    echo "Name Empty";
                    header("Location: signup.html");
                    exit();
                }
                else if(strlen($moNo) !== 10 || strlen($pass) < 8){
                    echo "Mobile Number should be exactly 10 digits and password should be greater than 8";
                    header("Location: signup.html");
                    exit();
                }else{
                    $stmt = $conn->prepare("INSERT INTO signup (Name, MobileNumber, Password) VALUES (?,?,?);");
                    $stmt->bind_param("sis",$name, $moNo, $pass);
                    
                    if($stmt->execute()){
                        echo "Registeration Successful!!";
                        header("Location: index.html");
                        exit();
                    }
                    $stmt->close();
                }
            }
        }
    }
    $conn->close();
?>
