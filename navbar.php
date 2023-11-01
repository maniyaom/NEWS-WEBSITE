<nav class="navbar">
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
        <?php
        if ($login_btn_text == 'Loggedin') {
            echo '<span class="user-profile"><i class="fa fa-user" aria-hidden="true" style="font-size: 28px"></i>' . $_COOKIE["First_Name"] . " " . $_COOKIE["Last_Name"] . '</span>';
            echo '<button class="btn" onclick="document.location.href=\'/Main/OtherPages/logout.php\'">Logout</button>';
        } else {
            echo '<button class="btn" onclick="document.location.href=\'/Main/OtherPages/login.php\'">Login</button>';
        }
        ?>
    </div>
</nav>