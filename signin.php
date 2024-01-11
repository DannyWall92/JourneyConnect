<?php
ob_start();
if (isset($_POST['submit'])){
    include 'config.php';
    $link = mysqli_connect($host, $dbuser, $dbpass, $dbname);
    $email = mysqli_real_escape_string($link,htmlspecialchars($_POST['email']));
    $password = mysqli_real_escape_string($link,htmlspecialchars($_POST['password']));
    $sql = "select * from users where email like '$email'";
    $result = mysqli_query($link, $sql);
    $num = mysqli_num_rows($result);
    if ($num == 1) {
        $row = mysqli_fetch_assoc($result);
        $user_id = $row['user_id'];
        $hash = $row['password'];
        if (password_verify($password, $hash)) {
            setcookie ('user_id', $user_id, time() + (86400 * 30));
            header('Location: https://dewdevelopment.com/connect/connect.php');
        }
    } else {
        $login = "failed";
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
                <h2>Login</h2>
                <?php
                if (isset($login)) {
                    echo ("<p><strong>Login Failed Please Try Again</strong></p>");
                    echo ("<P>$sql</p>");
                }
                ?>
                <form action="signin.php" method="POST">
                    <p>Username/Email: <input type="text" name="email"></p>
                    <p>Password: <input type="password" name="password"></p>
                    <input type="submit" name="submit" value="Submit" />
                </form>
            </div>
        </div>
    </body>
</html>