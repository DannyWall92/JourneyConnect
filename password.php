<?php
ob_start();
if (!isset($_COOKIE['user_id'])) {
    header('Location: https://dewdevelopment.com/connect/signin.php');
} else {
    include 'config.php';
    $link = mysqli_connect($host, $dbuser, $dbpass, $dbname);
    $user_id = mysqli_real_escape_string($link, htmlspecialchars($_COOKIE['user_id']));
    $user_sql = "select * from users where user_id = $user_id";
    $user_result = mysqli_query($link, $user_sql);
    $user_row = mysqli_fetch_assoc($user_result);
    $user_id = $user_row['user_id'];
    $email = $user_row['email'];
    $name = $user_row['name'];
    if (isset($_POST['submit'])){
        $password = mysqli_real_escape_string($link,htmlspecialchars($_POST['password']));
        $password = password_hash($password, PASSWORD_DEFAULT);
        $upd_sql = "update users set password = '$password' where user_id = $user_id";
        $upd_result = mysqli_query($link, $upd_sql);
        header('Location: https://dewdevelopment.com/connect/connect.php');
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
        <div class="header_spacer">
            &nbsp;
        </div>
        <div class="body_wrapper">
            <div class="top_section">
                <h2>Change Password</h2>
                <form action="signin.php" method="POST">
                    <p>Password: <input type="text" name="password" required></p>
                    <input type="submit" name="submit" value="Update Password" />
                </form>
            </div>
        </div>
    </body>
</html>