<!DOCTYPE html>
<html>
<head>
    <title>Sign Up Page</title>
</head>
<body>
    <h2>Sign Up</h2>
    <form action="signup.php" method="post">
        <label for="fname">First Name</label>
        <input type="text" id="fname" name="fname" required><br><br>

        <label for="lname">Last Name</label>
        <input type="text" id="lname" name="lname" required><br><br>

        <label for="birthdate">Birth Date</label>
        <input type="date" id="birthdate" name="birthdate" required><br><br>

        <label>Gender</label>
        <input type="radio" name="gender" id="male" value="Male">Male
        <input type="radio" name="gender" id="female" value="Female">Female

        <label for="email">Email</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>

        <input type="submit" value="Sign Up">
    </form>
</body>
</html>

<?php

include("dbconnection.php");
function createUser($conn,$first_name,$last_name,$birthdate,$gender,$email_id,$user_password)
{
    $query = "CREATE TABLE IF NOT EXISTS USER_DETAILS (
        Sr_No int(11) AUTO_INCREMENT,
        FIRST_NAME varchar(255),
        LAST_NAME varchar(255),
        BIRTHDATE date,
        GENDER varchar(10),
        EMAIL_ID varchar(255) NOT NULL,
        PASSWORD varchar(255) NOT NULL,
        PRIMARY KEY (Sr_No, EMAIL_ID)
    )";    

    if (mysqli_query($conn, $query)) {
        echo "Table USER_DETAILS created or already exists.";

        $query = "INSERT INTO USER_DETAILS (FIRST_NAME, LAST_NAME, BIRTHDATE, GENDER, EMAIL_ID, PASSWORD) VALUES ('$first_name', '$last_name', '$birthdate', '$gender', '$email_id', '$user_password')";

        if (!(isExists($conn, $email_id,"USER_DETAILS"))) {
            if (mysqli_query($conn, $query)) {
                echo "User Created Successfully!";
                closeConnection($conn);
                header("Location: login.php");
                exit();
            } else {
                echo "Error creating user: " . mysqli_error($conn);
            }
        } else {
            echo "Error Creating User : User Already Exists !!";
        }
    } else {
        echo "Error creating table: " . mysqli_error($conn);
    }
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $first_name = $_POST["fname"];
    $last_name = $_POST["lname"];
    $birthdate = $_POST["birthdate"];
    $gender = $_POST["gender"];
    $email_id = $_POST["email"];
    $user_password = $_POST["password"];
    
    $conn = establishConnection();
    createUser($conn,$first_name,$last_name,$birthdate,$gender,$email_id,$user_password);
}
?>