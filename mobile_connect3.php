<?php
ob_start();
$android = strpos($_SERVER['HTTP_USER_AGENT'],"Android");
$bberry = strpos($_SERVER['HTTP_USER_AGENT'],"BlackBerry");
$iphone = strpos($_SERVER['HTTP_USER_AGENT'],"iPhone");
$ipod = strpos($_SERVER['HTTP_USER_AGENT'],"iPod");
$webos = strpos($_SERVER['HTTP_USER_AGENT'],"webOS");
if (!$android && !$bberry && !$iphone && !$ipod && !$webos== true) { 
    header('Location: https://dewdevelopment.com/connect/connect.php');
} else {
    if (!isset($_COOKIE['user_id'])) {
        header('Location: https://dewdevelopment.com/connect/signin.php');
    } else {
        include 'config.php';
        $link = mysqli_connect($host, $dbuser, $dbpass, $dbname);
        $user_id = mysqli_real_escape_string($link, htmlspecialchars($_COOKIE['user_id']));
        if (is_numeric($user_id)) {
            $user_sql = "select * from users where user_id = $user_id";
            $user_result = mysqli_query($link, $user_sql);
            $user_row = mysqli_fetch_assoc($user_result);
            $user_id = $user_row['user_id'];
        } else {
            setcookie ('user_id', $user_id, time() - (86400 * 30));
            header ('Location: https://dewdevelopment.com/connect/signin.php');
        }
    }
}
ob_end_flush();
?>
<html>
    <head>
        <title>Journey Connect</title>
        <link rel="stylesheet" href="mobile_styles3.css" />
        <script src="mobile_scripts.js"></script>
    </head>

   <body>
       <div class="header">
            <div class="connect_logo">
                <a href="connect.php">Journey Connect</a> | 
                <a href="center.php">Message Center</a> | 
                <a href="profile.php">Edit Profile</a> | 
                <a href="logout.php">Logout</a>
            </div>
        </div>
        <div class="header_spacer">&nbsp;</div>

        <div class="slider-wrap">
            <div class="slider" id="slider">
                <div class="holder">
                <?php
                $peeps_sql = "select * from users";
                $peeps_result = mysqli_query($link, $peeps_sql);
                while ($peeps_row = mysqli_fetch_assoc($peeps_result)) {
                    echo ("<div class='slide-wrapper'>");
                        echo ("<div class='slide'>");
                            $pic = $peeps_row['profile_pic'];
                            echo ("<img class='slide-image' src='images/$pic' /></div>");
                            $peep_id = $peeps_row['user_id'];
                            $name = $peeps_row['name'];
                            echo ("<span class='temp'>");
                                echo ("<P><a href='message.php?id=$peep_id&new_message=yes'>$name</a></p>");
                            echo ("</span>");
                        echo ("</div>");
                    echo ("</div>");
                }
                ?>
            </div>
        </div>
    </body>
</html>