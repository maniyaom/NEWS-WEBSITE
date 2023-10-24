<!DOCTYPE html>
<html>

<head>
    <title>Welcome</title>
</head>

<body>
    <h2>Welcome, User!</h2>
   
    <?php
        session_start();
        if (((isset($_SESSION["email_id"]) && isset($_SESSION['loggedin'])) && $_SESSION['loggedin'] == true)) {
            echo "You are logged in with " . $_SESSION['email_id']." ". $_COOKIE['First_Name'];
        } else {
            // echo "Please Login to your account !!";
            header("Location: login.php");
            exit();
        }
    ?>

    <form action="welcome.php" method="post">
        <input type="submit" id="logoutBtn" name="logout" value="Logout">
    </form>

    <?php
    // Check if the "Logout" button was clicked
    if (isset($_POST["logout"])) {
        // Destroy the session to log the user out
        session_start();
        session_unset();
        session_destroy();
        // Redirect to the login page or any other desired page
        header("Location: login.php");
        exit(); // Add exit() to stop further script execution
    }
    ?>
</body>
</html>