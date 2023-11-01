<?php
$login_btn_text = '';
session_start();
if (((isset($_SESSION["email_id"]) && isset($_SESSION['loggedin'])) && $_SESSION['loggedin'] == true)) {
    header("Location: ../index.php");
    exit();
} else {
    $login_btn_text = 'LoggedOut';
}
?>

<?php
$usr_msg = '';

include("../dbconnection.php");
function createUser($conn, $first_name, $last_name, $birthdate, $gender, $email_id, $user_password, $user_confirm_password)
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
    if ($user_password === $user_confirm_password) {
        if (mysqli_query($conn, $query)) {

            $user_password = password_hash($user_password, PASSWORD_DEFAULT);

            $query = "INSERT INTO USER_DETAILS (FIRST_NAME, LAST_NAME, BIRTHDATE, GENDER, EMAIL_ID, PASSWORD) VALUES ('$first_name', '$last_name', '$birthdate', '$gender', '$email_id', '$user_password')";

            if (!(isExists($conn, $email_id, "USER_DETAILS"))) {
                if (mysqli_query($conn, $query)) {
                    $usr_msg = "Account Created Successfully Login to continue...";
                    closeConnection($conn);
                } else {
                    $usr_msg = mysqli_error($conn);
                }
            } else {
                $usr_msg = "E-mail address Already Exists !!";
            }
        } else {
            $usr_msg = mysqli_error($conn);
        }
    } else {
        $usr_msg = "Passwords are not matching !!";
    }
    return $usr_msg;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST["fname"];
    $last_name = $_POST["lname"];
    $birthdate = $_POST["birthdate"];
    $gender = $_POST["gender"];
    $email_id = $_POST["email"];
    $user_password = $_POST["password"];
    $user_confirm_password = $_POST["confirm_password"];

    $conn = establishConnection();
    $usr_msg = createUser($conn, $first_name, $last_name, $birthdate, $gender, $email_id, $user_password, $user_confirm_password);
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Sign Up Page</title>

    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="../utils.css">
    <script src="../functions.js"></script>
    <style>
        .main {
            height: 100vh;
            width: 98vw;
        }

        form {
            width: 40%;
        }

        input[type=radio] {
            --s: 1em;
            /* control the size */
            --c: #009688;
            /* the active color */

            height: var(--s);
            aspect-ratio: 1;
            border: calc(var(--s)/8) solid #939393;
            padding: calc(var(--s)/8);
            background:
                radial-gradient(farthest-side, var(--c) 94%, #0000) 50%/0 0 no-repeat content-box;
            border-radius: 50%;
            outline-offset: calc(var(--s)/10);
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            cursor: pointer;
            font-size: inherit;
            transition: .3s;
            width: 25px;
            height: 25px;
        }

        input[type=radio]:checked {
            border-color: var(--c);
            background-size: 100% 100%;
        }
    </style>

</head>

<body>
    <?php include '../navbar.php' ?>

    <div id="alertBox">
        <!-- It will show dismissible alerts at the top of the page-->
    </div>

    <div class="main">
        <form action="signup.php" method="post" autocomplete="off">
            <span class="center-span">Sign Up</span>

            <input type="text" id="fname" class="inputFields" name="fname" placeholder="First Name" required>
            <input type="text" id="lname" class="inputFields" name="lname" placeholder="Last Name" required>

            <div id="dobDiv">
                <label for="birthdate">Birth Date :</label>
                <input type="date" id="birthdate" class="inputFields" name="birthdate" required>
            </div>

            <div id="genderDiv">
                <label>Gender : </label>
                <div>
                    <input type="radio" name="gender" id="male" value="Male" checked><label for="male">Male</label>
                </div>
                <div>
                    <input type="radio" name="gender" id="female" value="Female"><label for="female">Female</label>
                </div>
            </div>

            <input type="email" id="email" class="inputFields" name="email" placeholder="Email" required>

            <div class="password-div" id="password">
                <input type="password" class="inputFields" name="password" placeholder="Create Password" required>
                <i class="fa fa-eye" aria-hidden="true" onclick="showHidePassword('password')"></i>
                <i class="fa fa-eye-slash" aria-hidden="true" onclick="showHidePassword('password')"></i>
            </div>

            <div class="password-div" id="confirm-password">
                <input type="password" class="inputFields" name="confirm_password" placeholder="Confirm Password" required>
                <i class="fa fa-eye" aria-hidden="true" onclick="showHidePassword('confirm-password')"></i>
                <i class="fa fa-eye-slash" aria-hidden="true" onclick="showHidePassword('confirm-password')"></i>
            </div>

            <input type="submit" class="btn" id="signUpBtn" value="Sign Up">
            <span class="center-span font-sm myt-15">Already Have an Account ? <a href="login.php">Login</a></span>
        </form>

    </div>

    <script>
        let usr_msg = "<?php echo $usr_msg ?>"
        if (usr_msg != '') {
            if (usr_msg == 'Account Created Successfully Login to continue...')
                document.getElementById("alertBox").innerHTML = `<div class="alert success">` + usr_msg + `
                                                                   <span class="close" onclick="this.parentElement.style.display='none'"><i class="fa fa-close" style="font-size:24px; cursor: pointer;"></i></span>
                                                                </div>`;
            else
                document.getElementById("alertBox").innerHTML = `<div class="alert danger">` + usr_msg + `
                                                                   <span class="close" onclick="this.parentElement.style.display='none'"><i class="fa fa-close" style="font-size:24px; cursor: pointer;"></i></span>
                                                                </div>`;
        }
    </script>

    <!-- adding footer to the page -->
    <?php include '../footer.php'; ?>
</body>

</html>