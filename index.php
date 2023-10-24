<!-- // function bindData(articles){
    //     console.log(articles[0].content);
    //     document.write(articles[0].description);
    // }

    // let url = 'https://gnews.io/api/v4/search?q=';
    // let API_KEY = 'e5ca2f6d205ea50bc4fde627b212ef1f';
    // async function fetchNews(query){
    //     const result = await fetch('https://gnews.io/api/v4/search?q=example&country=india&max=100&apikey=e5ca2f6d205ea50bc4fde627b212ef1f');
    //     console.log(`${url}${query}&apiKey=${API_KEY}`);
    //     const data = await result.json();
    //     console.log(data)
    // }
     -->

<?php
    session_start();
    if (!((isset($_SESSION["email_id"]) && isset($_SESSION['loggedin'])) && $_SESSION['loggedin'] == true)){
        header("Location: OtherPages/login.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" href="selection.css">
    <script src="config.js"></script>
    <script defer src="script.js"></script>
</head>
<body>
    <nav class="navbar">
        <div class="logo" onclick="document.location.href='index.php'">E - News</div>
        <div class="nav-links">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="#">About Us</a></li>
                <li><a href="OtherPages/contactus.php">Contact Us</a></li>
                <li><a href="OtherPages/review.php">Review Us</a></li>
            </ul>
        </div>
        <div class="loginBtn">
            <button class="btn" onclick="document.location.href = 'OtherPages/login.php'">Login</button>
            <button class="btn" style="margin-right: -80px; margin-left: 20px;" onclick="document.location.href = 'OtherPages/signup.php'">Sign Up</button>
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
    <button class="btn" id="loadMoreBtn" onclick="loadMoreNews(`Business`)">Load More</button>
</body>

<script src="selection.js"></script>
</html>