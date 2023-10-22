<?php
    session_start();
    if (!(isset($_SESSION["email_id"]))){
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
</head>
<body>
    <form action="review.php" method="post">
        <label for="fname">First Name</label>
        <input type="text" id="fname" name="fname" required><br><br>

        <label for="lname">Last Name</label>
        <input type="text" id="lname" name="lname" required><br><br>

        <label for="email">Email</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="review-info">Feedback</label>
        <textarea name="review-info" id="review-info" cols="30" rows="10"></textarea>

        <input type="submit" value="Submit">
    </form>
</body>
</html>

<?php
include("dbconnection.php");
function addReview($conn,$first_name,$last_name,$email_id, $review_info)
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
        echo "Table REVIEW_DETAILS created or already exists.";

        $query = "INSERT INTO REVIEW_DETAILS (FIRST_NAME, LAST_NAME, EMAIL_ID, REVIEW_INFO) VALUES ('$first_name', '$last_name', '$email_id', '$review_info')";

        if (!(isExists($conn, $email_id,"REVIEW_DETAILS"))) {
            if (mysqli_query($conn, $query)) {
                echo "Review Added Successfully!";
            } else {
                echo "Error Adding Review: " . mysqli_error($conn);
            }
        } else {
            echo "Error Adding Review : User has Already Reviewed !!";
        }
    } else {
        echo "Error creating table: " . mysqli_error($conn);
    }
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $first_name = $_POST["fname"];
    $last_name = $_POST["lname"];
    $email_id = $_POST["email"];
    $review_info = $_POST["review-info"];
    
    $conn = establishConnection();
    addReview($conn,$first_name,$last_name,$email_id, $review_info);
    closeConnection($conn);
}
?>