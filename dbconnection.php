<?php
    function establishConnection()
    {
        $serverName = "localhost";
        $username = "root";
        $dbPassword = "";
        $databaseName = "news_website";
        $conn = new mysqli($serverName, $username, $dbPassword, $databaseName);
        if (mysqli_connect_error()) {
            die("Connection failed: " . mysqli_connect_error());
        }
        return $conn;
    }
    
    function closeConnection($conn)
    {
        $conn->close();
    }

    function isExists($conn, $emailId, $table_name)
    {
        $emailId = mysqli_real_escape_string($conn, $emailId); // Sanitize input
        $query = "SELECT EMAIL_ID FROM $table_name WHERE EMAIL_ID = '$emailId'";
        $result = mysqli_query($conn, $query);
        
        if ($result) {
            return mysqli_num_rows($result) > 0;
        } else {
            return false;
        }
    }
?>