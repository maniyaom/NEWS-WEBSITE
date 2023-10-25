<?php
session_start();
if (!((isset($_SESSION["email_id"]) && isset($_SESSION['loggedin'])) && $_SESSION['loggedin'] == true)) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review Us</title>
    <link rel="stylesheet" href="../utils.css">
    <style>
        form {
            width: 40%;
            padding: 40px 40px;
        }

        #review-info {
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
        <div>
        <span class="user-profile"><i class="fa fa-user" aria-hidden="true" style="font-size: 28px"></i><?php echo $_COOKIE["First_Name"] ." ". $_COOKIE["Last_Name"] ?></span>
            <button class="btn" onclick="document.location.href='logout.php'">Logout</button>
        </div>
    </nav>

    <div class="main">
        <form action="review.php" method="post">
            <span class="center-span">Review Us</span>
            <input type="text" id="fname" class="inputFields" name="fname" placeholder="First Name"
                value="<?php echo $_COOKIE['First_Name'] ?>" readonly>
            <input type="text" id="lname" class="inputFields" name="lname" placeholder="Last Name"
                value="<?php echo $_COOKIE['Last_Name'] ?>" readonly>
            <input type="email" id="email" class="inputFields" name="email" placeholder="Email"
                value="<?php echo $_SESSION['email_id'] ?>" readonly>
            <textarea name="review_info" id="review-info" placeholder="Feedback" cols="30" rows="10"></textarea>
            <input type="submit" class="btn" value="Submit" style="width: 100%; margin-top: 30px">
        </form>
    </div>
</body>

</html>

<?php

include("../dbconnection.php");
$usr_msg = '';
function addReview($conn, $first_name, $last_name, $email_id, $review_info)
{
    $query = "CREATE TABLE IF NOT EXISTS REVIEW_DETAILS (
        Sr_No int(11) AUTO_INCREMENT,
        FIRST_NAME varchar(255),
        LAST_NAME varchar(255),
        EMAIL_ID varchar(255) NOT NULL,
        REVIEW_INFO varchar(1000),
        PRIMARY KEY (Sr_No,EMAIL_ID)
    )";
    #FOREIGN KEY (EMAIL_ID) REFERENCES USER_DETAILS(EMAIL_ID)

    if (mysqli_query($conn, $query)) {
        $query = "INSERT INTO REVIEW_DETAILS (FIRST_NAME, LAST_NAME, EMAIL_ID, REVIEW_INFO) VALUES ('$first_name', '$last_name', '$email_id', '$review_info')";

        if (!(isExists($conn, $email_id, "REVIEW_DETAILS"))) {
            if (mysqli_query($conn, $query)) {
                $usr_msg = "Review Added Successfully !";
            } else {
                $usr_msg = mysqli_error($conn);
            }
        } else {
            $usr_msg = "You have Already Reviewed !!";
        }
    } else {
        $usr_msg = mysqli_error($conn);
    }
    return $usr_msg;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST["fname"];
    $last_name = $_POST["lname"];
    $email_id = $_POST["email"];
    $review_info = $_POST["review_info"];

    // var_dump($first_name, $last_name, $email_id, $review_info);

    $conn = establishConnection();
    $usr_msg = addReview($conn, $first_name, $last_name, $email_id, $review_info);
    closeConnection($conn);
}
?>

<script>
    let usr_msg = "<?php echo $usr_msg; ?>";

    if (usr_msg !== '') {
        alert(usr_msg);
    }
</script>