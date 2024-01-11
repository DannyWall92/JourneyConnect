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
        <link rel="stylesheet" href="mobile_styles.css" />
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
        <div class="body_wrapper">
            <div class="connect_section">
                <?php
                $peeps_sql = "select * from users";
                $peeps_result = mysqli_query($link, $peeps_sql);
                while ($peeps_row = mysqli_fetch_assoc($peeps_result)) {
                    echo ("<div class='flex_container'>");
                        $pic = $peeps_row['profile_pic'];
                        echo ("<div class='pic'><img width='99%' src='images/$pic' /></div>");
                        $peep_id = $peeps_row['user_id'];
                        $name = $peeps_row['name'];
                        $city = $peeps_row['city'];
                        $state = $peeps_row['state'];
                        $spiritual = $peeps_row['spiritual'];
                        $experts = $peeps_row['experts'];
                        $books = $peeps_row['books'];
                        $seminars = $peeps_row['seminars'];
                        $workshops = $peeps_row['workshops'];
                        $gender = $peeps_row['gender'];
                        $lookingfor = $peeps_row['lookingfor'];
                        $profile_description = $peeps_row['profile_description'];
                        echo ("<div class='deets'>");
                            echo ("<h2>$name is a $gender looking for a $lookingfor</h2>");
                            echo ("<P><strong>Lives in:</strong> $city, $state</P>");
                            echo ("<P><strong>Spirituality:</strong> $spiritual</p>");
                            echo ("<P><strong>Experts:</strong> $experts</p>");
                            echo ("<P><strong>Books:</strong> $books</p>");
                            echo ("<P><strong>Seminars:</strong> $seminars</p>");
                            echo ("<P><strong>Workshops:</strong> $workshops</p>");
                            echo ("<P><strong>Profile Description:</strong> $profile_description</p>");
                            echo ("<P><a href='message.php?id=$peep_id&new_message=yes'>Message This Person</a></p>");
                        echo ("</div>");
                        /*
                        echo ("<div class='actions'>");
                            echo ("<a href='message.php?id=$peep_id&new_message=yes'>Message</a><br />");
                            echo ("<a href='#' onclick='like($peep_id)'>Like</a><br />");
                        echo ("</div>");
                        */
                    echo ("</div>");
                    echo ("<hr /><hr />");
                }
                ?>
            </div>
        </div>
    </body>
</html>