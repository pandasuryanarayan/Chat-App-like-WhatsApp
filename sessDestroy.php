<?php
  session_start();
    
  if (isset($_SESSION['user_id'])) {

    // Destroy the session
    session_destroy();

    header("Location: index.html");
    exit();
  }
  
?>
