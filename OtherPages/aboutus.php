<?php
$login_btn_text = '';
session_start();
if ((isset($_SESSION["email_id"]) && isset($_SESSION['loggedin'])) && $_SESSION['loggedin'] == true) {
    $login_btn_text = 'Loggedin';
} else {
    $login_btn_text = 'LoggedOut';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="../utils.css">
    <style>
        .main {
            margin: auto;
            margin-top: 10px;
            width: 90vw;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            justify-content: flex-start;
            color: var(--primary_color);
        }

        .main>h1 {
            margin: auto;
            color: var(--primary_color);
            font-size: 2.6rem;
        }
    </style>
</head>

<body>
    <?php include '../navbar.php' ?>
    <div class="main">
        <h1>About Us</h1>
        <div class="info flex">
            <div style="width: 45%;">
                <img src="/Main/assets/about-img-1.jpg" alt="aboutus-image" class="aboutus-image">
            </div>
            <div class="aboutus-description" style="width: 55%; margin-left: 100px;">
                <h1>Welcome to E - News</h1>
                <p style="margin-top: 15px;">E - News is trusted source for the latest news and updates. We are dedicated to providing you with accurate and timely news from around the world. Our mission is to empower you with knowledge and keep you informed about the events that matter most.</p>
                <button class="btn" style="margin-top: 30px; width: 30%; border-radius: 8px;" onclick="document.location.href = '/Main/index.php'">Explore</button>
            </div>
        </div>
        <div class="info flex">
            <div class="aboutus-description" style="width: 55%;">
                <h1>Passion, Purpose, and Dedication</h1>
                <p style="margin-top: 15px;">Our team of experienced journalists and editors work tirelessly to bring you the most relevant stories. We believe in the power of quality journalism to inspire, educate, and create positive change in the world. We strive to provide you with a diverse range of news, including politics, technology, entertainment, sports, health, and more.</p>
            </div>
            <div style="width: 45%;">
                <img src="/Main/assets/about-img-2.jpg" alt="aboutus-image" class="aboutus-image">
            </div>
        </div>

        <div class="info flex">
            <div style="width: 45%;">
                <img src="/Main/assets/about-img-3.jpg" alt="aboutus-image" class="aboutus-image">
            </div>
            <div class="aboutus-description" style="width: 55%; margin-left: 100px;">
                <h1>Committed to Integrity, Transparency, and Reliability</h1>
                <p style="margin-top: 15px;">At E - News, we take pride in our commitment to journalistic integrity, fact-checking, and unbiased reporting. We believe in transparency and accountability, and our goal is to be a reliable source of information for our readers.</p>
            </div>
        </div>

        <div class="info flex">
            <div class="aboutus-description" style="width: 55%;">
                <h1>Your Gateway to Diverse and Quality Content</h1>
                <p style="margin-top: 15px;">Whether you're interested in the latest political developments, technology trends, entertainment news, or sports updates, E - News has you covered. Our goal is to keep you informed and engaged with high-quality content that reflects the diverse interests and preferences of our readers.</p>
            </div>
            <div style="width: 45%;">
                <img src="/Main/assets/about-img-4.jpg" alt="aboutus-image" class="aboutus-image">
            </div>
        </div>
    </div>

    <?php include '../footer.php' ?>
</body>

</html>