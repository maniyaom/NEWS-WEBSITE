<?php
    session_start();

    // Check if the user is already logged in
    if (isset($_SESSION["email_id"]) && isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
        header("Location: ../index.php");
        exit();
    }
?>

<?php
    $usr_err_msg = "";
    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve user input
        $email_id = $_POST["email"];
        $user_password = $_POST["password"];

        include("../dbconnection.php");
        $conn = establishConnection();

        $query = "SELECT * FROM USER_DETAILS WHERE EMAIL_ID = '$email_id'";
        $result = mysqli_query($conn, $query);
        $row = $result->fetch_assoc();

        if (password_verify($user_password, $row['PASSWORD'])) {
            // Redirect to the welcome page if a matching user is found
    
            $_SESSION['email_id'] = $email_id;
            $_SESSION['loggedin'] = true;

            setcookie("First_Name", $row['FIRST_NAME'], time() + 60 * 60 * 24 * 365, '/');
            setcookie("Last_Name", $row['LAST_NAME'], time() + 60 * 60 * 24 * 365, '/');

            closeConnection($conn);
            header("Location: ../index.php");
            exit();
        } else {
            // Invalid email or password
            $usr_err_msg = "Invalid Email or Password !!";
        }
    }
?>

<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <link rel="stylesheet" href="../utils.css">
    <style>
        form {
            width: 30%;
            padding: 40px 45px;
        }

        .inputFields {
            width: 90%;
            margin-bottom: 0px;
            background-color: white;
        }

        .btn {
            width: 100%;
        }

        #usr_err_msg {
            color: red;
            font-size: 13px;
            margin-top: -15px;
            margin-bottom: 10px;
            margin-left: 5px;
        }

        .user-icon-div {
            display: flex;
            align-items: center;
            border: 1px solid rgba(128, 128, 128, 0.329);
            padding: 5px 5px 5px 25px;
            border-radius: 8px;
            margin-bottom: 20px;
            justify-content: space-between;
        }

        .user-icon-div>i {
            margin-right: 10px;
        }

        .password-div {
            margin-bottom: 0px;
            width: 100%;
            background-color: white;
        }
        
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../style.css">
    <script src="../functions.js"></script>
</head>

<body>
    <nav class="navbar">
        <div class="logo" onclick="document.location.href='index.php'">E - News</div>
        <div class="nav-links">
            <ul>
                <li><a href="../index.php">Home</a></li>
                <li><a href="/Main/OtherPages/aboutus.php">About Us</a></li>
                <li><a href="/Main/OtherPages/contactus.php">Contact Us</a></li>
                <li><a href="/Main/OtherPages/reviewus.php">Review Us</a></li>
            </ul>
        </div>
        <div class="loginBtn">
            <button class="btn" style="margin-right: -80px; margin-left: 20px;"
                onclick="document.location.href = '/Main/OtherPages/signup.php'">Sign Up</button>
        </div>
    </nav>

    <div class="main" style="height: 70vh">
        <form action="login.php" method="post" autocomplete="off">
            <span class="center-span">Login</span>
            <div class="user-icon-div">
                <i class="fa fa-user" style="font-size:36px"></i>
                <input type="email" id="email" class="inputFields" name="email" placeholder="Email" required>
            </div>
            <div class="user-icon-div">
                <i class="fa fa-key" aria-hidden="true" style="font-size: 30px;"></i>
                <!-- <input type="password" id="password" class="inputFields" name="password" placeholder="Password" required> -->
                <div class="password-div" id="password">
                    <input type="password" class="inputFields" name="password" placeholder="Password" required>
                    <i class="fa fa-eye" aria-hidden="true" onclick="showHidePassword('password')"></i>
                    <i class="fa fa-eye-slash" aria-hidden="true" onclick="showHidePassword('password')"></i>
                </div>
            </div>
            <span id="usr_err_msg"></span>
            <input type="submit" class="btn" style="width : 100%" value="Login">
            <span class="center-span font-sm myt-15">Don't Have an Account ? <a href="/Main/OtherPages/signup.php">Sign Up</a></span>
        </form>
    </div>

    <script>
        document.getElementById("usr_err_msg").innerHTML = "<?php echo $usr_err_msg ?>";
    </script>

    <?php include '../footer.php' ?>
</body>
</html>