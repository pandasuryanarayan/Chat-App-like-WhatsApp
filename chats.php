<?php 
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.html");
    exit();
}else{
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

    $query = "SELECT * FROM newChat";
    $result = mysqli_query($conn, $query);

    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="chats.css">
        <script type="text/javascript" src="chats.js"> </script>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title> Speedy </title>
    </head>

    <body>

        <section id="sidebar">
        <div id="profile">
                <img src="https://rb.gy/sgk8em" id="img1" width="45px" height="45px"/>
                <span> Suryanarayan Puranchand Panda </span>
                <span id="chkConfirm"></span>
                <div id="dot">
                    <button onclick="toggleDropdown()" id="toggle"> ፧ </button>
                    <div id="dropdown">
                        <a onclick="newchat()" href="#"> New Chat </a>
                        <a onclick="activateAllCheckboxes()" href="#"> Create Group </a>
                        <a onclick="DirectMessage()" href="#"> Send Message </a>
                        <a onclick="openSettingsModal()" href="#"> Settings </a>
                        <a href="sessDestroy.php"> LOG OUT </a>
                    </div>
                </div>
        </div>

        <div id="search">
            <form id="searchForm">
                <input type="search" placeholder="Type to Search"/>
            </form>
        </div>

        <div id="people-container">

        <?php
        while ($row = mysqli_fetch_assoc($result)) {
            $mobileNumber = $row['MobileNumber'];
            $name = $row['Name'];

            echo '<button mobile-id="' . $mobileNumber . '" oncontextmenu="showContextMenu(event)" onclick="openChatPage(event, this)" class="people">
                    <input type="checkbox" class="checkbox" disabled>
                    <img src="https://rb.gy/sgk8em" class="peImg" width="40px" height="40px"/>
                    ' . $name . '
                  </button>';
        }
        ?>
        
        </div>
        </section>

        <section id="sec1">
            <div id="main">
                <button" onclick="toggleNav()" id="toggle2">☰</button>
            </div>
            <div id="app-name">
                <h1> Speedy </h1>
                <h5>🔒 All Chats are end to end encrypted </h5>
            </div>
        </section>
    
        <div id="send-message">
            <div id="message-form">
                <spanonclick="closeDirectMessage()">&times;</span>
                Mobile Number <br>
                <input type="number" id="number-id"lder="Enter number"/><br>
                <input type="text" id="message-id"lder="Type a message"/>
                <input type="submit" onclick="sendMessage()" id="messageSendbtn" value="Send"/>
            </div>
        </div>
    
        <div id="contextMenu">
            <div id="context-menu-item" onclick="deleteButton()"> Delete </div>
        </div>
    
        <div id="settings-modal"
            <divontent">
                <spanonclick="closeSettingsModal()">&times;</span>
                <label for="imageInput">Enter Image URL:</label>
                <input type="text" id="imageInput" placeholder="Image URL">
                <button onclick="updateProfileImage()">Update Image</button>
            </div>
        </div>
    
    </body>
    </html>
    
    <?php
        mysqli_close($conn);
    }
?>
