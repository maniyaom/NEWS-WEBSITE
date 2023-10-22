<?php
session_start();

// Check if the user is already logged in
if (isset($_SESSION["email_id"])) {
    header("Location: welcome.php");
    exit();
}
else{
    session_destroy();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>
</head>
<body>
    <h2>Login</h2>
    <form action="login.php" method="post">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>
        <input type="submit" value="Login">
    </form>

    <?php
    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve user input
        $email_id = $_POST["email"];
        $user_password = $_POST["password"];

        include("dbconnection.php");
        $conn = establishConnection();
        $query = "SELECT EMAIL_ID, PASSWORD FROM USER_DETAILS WHERE EMAIL_ID = '$email_id' AND PASSWORD = '$user_password'";
        $result = mysqli_query($conn, $query);

        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                // Redirect to the welcome page if a matching user is found
                session_start();
                $_SESSION['email_id'] = $email_id;
                closeConnection($conn);
                header("Location: welcome.php");
                exit();
            } else {
                // Invalid email or password
                echo "Invalid Email or Password !!";
            }
        } else {
            // Handle query execution errors
            echo "Error: " . mysqli_error($conn);
        }
    }
    ?>
</body>
</html>
