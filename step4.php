<?php
ob_start();
include 'config.php';
$link = mysqli_connect($host, $dbuser, $dbpass, $dbname);

if (isset($_GET['submit'])){    
    $gender = mysqli_real_escape_string($link,htmlspecialchars($_GET['gender']));
    $lookingfor = mysqli_real_escape_string($link,htmlspecialchars($_GET['lookingfor']));
    $spiritual = mysqli_real_escape_string($link,htmlspecialchars($_GET['spiritual']));
    $experts = mysqli_real_escape_string($link,htmlspecialchars($_GET['experts']));
    $books = mysqli_real_escape_string($link,htmlspecialchars($_GET['books']));
    $seminars = mysqli_real_escape_string($link,htmlspecialchars($_GET['seminars']));
    $workshops = mysqli_real_escape_string($link,htmlspecialchars($_GET['workshops']));
    $firstlast = mysqli_real_escape_string($link,htmlspecialchars($_GET['firstlast']));
    $email = mysqli_real_escape_string($link,htmlspecialchars($_GET['email']));
    $password = mysqli_real_escape_string($link,htmlspecialchars($_GET['password']));
    $city = mysqli_real_escape_string($link,htmlspecialchars($_GET['city']));
    $state = mysqli_real_escape_string($link,htmlspecialchars($_GET['state']));
    $age = mysqli_real_escape_string($link,htmlspecialchars($_GET['age']));
    $job = mysqli_real_escape_string($link,htmlspecialchars($_GET['job']));
    $password = password_hash($password, PASSWORD_DEFAULT);

    $check_sql = "select * from users where username like '$email'";
    $check_result = mysqli_query($link, $check_sql);
    $user_exists = mysqli_num_rows($check_result);
    if ($user_exists == 0) {
        $sql = "insert into users (user_type, age, job, username, password, name, city, state, gender, lookingfor, email, spiritual, experts, books, seminars, workshops)";
        $sql = $sql . " VALUES ";
        $sql = $sql . "('regular', '$age', '$job', '$email', '$password', '$firstlast', '$city', '$state', '$gender', '$lookingfor', '$email', '$spiritual', '$experts', '$books', '$seminars', '$workshops')";
        $result = mysqli_query($link, $sql);
        $user_sql = "select * from users where username like '$email'";
        $user_result = mysqli_query($link, $user_sql);
        $user_row = mysqli_fetch_assoc($user_result);
        $user_id = $user_row['user_id'];
        setcookie ('user_id', $user_id, time() + (86400 * 30));
    } else {
        $user_row = mysqli_fetch_assoc($check_result);
        $user_id = $user_row['user_id'];
        setcookie ('user_id', $user_id, time() + (86400 * 30));
        $exists = "yes";
    }
}
ob_end_flush();
?>
<html>
<head>
        <title>Journey Connect</title>
        <link rel="stylesheet" href="styles.css" />
    </head>
    <body>
        <div class="header">
            <div class="connect_logo">Connect Logo</div>
            <div class="nav">Sign In</div>
        </div>
        <div class="body_wrapper">
            <div class="top_section">
                <?php
                if (isset($exists)) {
                    echo ("<h2>Your email is already registered</h2>");
                    echo ("<p>Please <a href='signing.php'>log in</a></p>");
                } else {
                ?>
                    <h2>Describe Yourself And What You Are Looking For</h2>
                    <p>For yourself talk about things like travel, how often you meditate, go into more detail about yourself spiritually, do you drink/smoke/420, and of course as much detail about what you are looking for in a partner as possible.</p>
                    <form action="step5.php" method="POST">
                        <textarea class="inputarea" name="profile_description" rows="20" cols="50"></textarea><br />
                        <input type="submit" name="submit" value="Next >>" />
                    </form>
                <?php
                }
                ?>
            </div>
        </div>
    </body>
</html>