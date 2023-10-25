<?php
    session_start();
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
        // Destroy the session to log the user out
        session_unset();
        session_destroy();
        // // Redirect to the login page or any other desired page
        header("Location: login.php");
        exit(); // Add exit() to stop further script execution
    }
    else{
        header("Location: login.php");
        exit(); // Add exit() to stop further script execution
    }  
?>