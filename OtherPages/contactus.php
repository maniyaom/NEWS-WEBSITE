<?php
    session_start();
    if (!((isset($_SESSION["email_id"]) && isset($_SESSION['loggedin'])) && $_SESSION['loggedin'] == true)){
        header("Location: login.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="../utils.css">
    <style>
        #messageBox {
            padding: 12px 15px;
            border-radius: 8px;
            outline: none;
            border: none;
            background-color: #eeeeee;
            font-size: 16px;
        }
    </style>
    <link rel="stylesheet" href="../style.css">
</head>

<body>
<nav class="navbar">
        <div class="logo" onclick="document.location.href='index.php'">E - News</div>
        <div class="nav-links">
            <ul>
                <li><a href="../index.php">Home</a></li>
                <li><a href="#">About Us</a></li>
                <li><a href="contactus.php">Contact Us</a></li>
                <li><a href="review.php">Review Us</a></li>
            </ul>
        </div>
        <div class="loginBtn">
            <button class="btn" onclick="document.location.href = 'OtherPages/login.php'">Login</button>
            <button class="btn" style="margin-right: -80px; margin-left: 20px;" onclick="document.location.href = 'OtherPages/signup.php'">Sign Up</button>
        </div>
    </nav>

    <div class="main">
        <form onsubmit="sendEmail(); reset(); return false;" autocomplete="off">
            <span>Contact Us</span>
            <input type="text" name="fname" id="fname" class="inputFields" placeholder="First Name" value="<?php echo $_COOKIE['First_Name'] ?>" readonly>
            <input type="text" name="lname" id="lname" class="inputFields" placeholder="Last Name" value="<?php echo $_COOKIE['Last_Name'] ?>" readonly>
            <input type="text" name="title" id="title" class="inputFields" placeholder="Title" required>
            <input type="email" name="email" id="email" class="inputFields" placeholder="Email" value="<?php echo $_SESSION['email_id'] ?>" readonly>
            <textarea name="message" id="messageBox" cols="45" rows="10" placeholder="Enter Your Message" required></textarea>

            <button type="submit" class="btn" style="width: 100%; margin-top: 20px">Submit</button>
        </form>
    </div>

    <script src="https://smtpjs.com/v3/smtp.js"></script>

    <script>
        function sendEmail(){
            Email.send({
                Host : "smtp.elasticemail.com",
                Username : "ommaniya000@gmail.com",
                Password : "8C621CCF7ECEB431CBA080D3F6BDA681FFC3",
                To : 'newswebsite02@gmail.com',
                From : "ommaniya000@gmail.com",
                Subject : title.value,
                Body : "First Name : "+document.getElementById("fname").value+
                       "<br>Last Name : "+document.getElementById("lname").value+
                       "<br>Email : "+document.getElementById("email").value+
                       "<br>Query : "+document.getElementById("messageBox").value
            }).then(
                message => alert(message)
                );

            //     Email.send({
            //     Host : "smtp.elasticemail.com",
            //     Username : "ommaniya000@gmail.com",
            //     Password : "8C621CCF7ECEB431CBA080D3F6BDA681FFC3",
            //     To : document.getElementById("email").value,
            //     From : "ommaniya000@gmail.com",
            //     Subject : title.value,
            //     Body : "Dear "+document.getElementById("fname").value+" "+document.getElementById("lname")+
            //             "<br>We have Successfully received your message<br>Thank you for contacting us, we will respond to your message within 24-48 hours..."
            // }).then(
            //     message => alert(message)
            //     );
        }
    </script>
</body>

</html>