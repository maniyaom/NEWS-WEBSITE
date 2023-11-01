<?php
    $login_btn_text = '';
    session_start();
    if (!(isset($_SESSION["email_id"]) && isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)){
        header("Location: OtherPages/login.php");
        exit();
    }
    else{
        $login_btn_text = 'Loggedin';
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="icon" type="image/x-icon" href="assets/news-logo.svg">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="utils.css">
    <link rel="stylesheet" href="selection.css">
    <script src="config.js"></script>
    <script src="script.js"></script>
    
    <style>
        #footer{
            display: none;
        }
    </style>

</head>
<body>
    <nav class="navbar" id="top">
        <div class="logo" onclick="document.location.href='/Main/index.php'">E - News</div>
        <div class="nav-links">
            <ul>
                <li><a href="/Main/index.php">Home</a></li>
                <li><a href="/Main/OtherPages/aboutus.php">About Us</a></li>
                <li><a href="/Main/OtherPages/contactus.php">Contact Us</a></li>
                <li><a href="/Main/OtherPages/reviewus.php">Review Us</a></li>
            </ul>
        </div>
        <div>
            <span class="user-profile"><i class="fa fa-user" aria-hidden="true" style="font-size: 28px"></i><?php echo $_COOKIE["First_Name"] ." ". $_COOKIE["Last_Name"] ?></span>
            <button class="btn" onclick="document.location.href='/Main/OtherPages/logout.php'">Logout</button>
        </div>
    </nav>

    <div id="categorySelectionBox">
        <!-- Fill With JavaScript -->
    </div>
    
    <div id="categoryDiv">
        <!-- Fill Using JavaScript -->
    </div>

    <div id="main">
        <!-- Fill using JavaScript -->
    </div>

    <div id="goToTopIcon">

    </div>

    <button class="btn" id="loadMoreBtn">Load More</button>

    <div id="footer">
        <?php include 'footer.php'; ?>
    </div>
</body>

<script src="selection.js"></script>
</html>