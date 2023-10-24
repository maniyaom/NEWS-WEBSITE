<?php
    session_start();
    if (((isset($_SESSION["email_id"]) && isset($_SESSION['loggedin'])) && $_SESSION['loggedin'] == true)){
        header("Location: ../index.php");
        exit();
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sign Up Page</title>
    <link rel="stylesheet" href="../utils.css">
    <style>
        form{
            width: 40%;
        }

        #signUpBtn{
            width: 100%;
        }

        #dobDiv{
            width: 55%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
            font-size: 18px;
        }

        #dobDiv > input{
            width: 65%;
            margin-bottom: 0px;
        }

        #genderDiv{
            width: 60%;
            display: flex;
            justify-content: space-around;
            margin-bottom: 20px;
            margin-left: -19px;
            font-size: 18px;
        }

        #genderDiv > input{
            margin-right: -23px;
            height: 16px;
            width: 16px;
            margin-top: 5px;
            accent-color: rgb(254, 64, 102);
        }

    </style>
    <link rel="stylesheet" href="../utils.css">
</head>
<body>
    <div class="main">
        <form action="signup.php" method="post" autocomplete="off">
            <span>Sign Up</span>
        
            <input type="text" id="fname" class="inputFields" name="fname" placeholder="First Name" required>
            <input type="text" id="lname" class="inputFields" name="lname" placeholder="Last Name" required>

            <div id="dobDiv">
                <label for="birthdate">Birth Date :</label>
                <input type="date" id="birthdate" class="inputFields" name="birthdate" required>
            </div>

            <div id="genderDiv">
                <label>Gender : </label>
                <input type="radio" name="gender" id="male" value="Male">Male
                <input type="radio" name="gender" id="female" value="Female">Female
            </div>

            <input type="email" id="email" class="inputFields" name="email" placeholder="Email" required>
            <input type="password" id="password" class="inputFields" name="password" placeholder="Password" required>

            <input type="submit" class="btn" id="signUpBtn" value="Sign Up">
        </form>
    </div>
</body>
</html>

<?php

include("../dbconnection.php");

$usr_msg = '';
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

        $user_password = password_hash($user_password, PASSWORD_DEFAULT);

        $query = "INSERT INTO USER_DETAILS (FIRST_NAME, LAST_NAME, BIRTHDATE, GENDER, EMAIL_ID, PASSWORD) VALUES ('$first_name', '$last_name', '$birthdate', '$gender', '$email_id', '$user_password')";

        if (!(isExists($conn, $email_id,"USER_DETAILS"))) {
            if (mysqli_query($conn, $query)) {
                $usr_msg = "Account Created Successfully !!";
                closeConnection($conn);
            } else {
                $usr_msg = mysqli_error($conn);
            }
        } else {
            $usr_msg = "E-mail address Already taken !!";
        }
    } else {
        $usr_msg = mysqli_error($conn);
    }
    return $usr_msg;
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $first_name = $_POST["fname"];
    $last_name = $_POST["lname"];
    $birthdate = $_POST["birthdate"];
    $gender = $_POST["gender"];
    $email_id = $_POST["email"];
    $user_password = $_POST["password"];
    
    $conn = establishConnection();
    $usr_msg = createUser($conn,$first_name,$last_name,$birthdate,$gender,$email_id,$user_password);
}
?>

<script>
    let usr_msg = "<?php echo $usr_msg ?>"
    if(usr_msg != ''){
        alert(usr_msg);
    }
</script>