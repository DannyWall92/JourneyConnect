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
            $user_city = $user_row['city'];
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
            <div style='padding-left:15%;'>
                Help us defray the costs of providing this service free to the community.
                <form action="https://www.paypal.com/donate" method="post" target="_top">
                    <input type="hidden" name="business" value="GL75699DXZXHA" />
                    <input type="hidden" name="no_recurring" value="0" />
                    <input type="hidden" name="item_name" value="Help cover costs for providing Journey Connect to the Dr. Joe Dispenza community for free." />
                    <input type="hidden" name="currency_code" value="USD" />
                    <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif" border="0" name="submit" title="PayPal - The safer, easier way to pay online!" alt="Donate with PayPal button" />
                    <img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1" />
                </form>
            </div>

                <?php
                $peeps_sql = "select * from users where city like '$user_city' and user_id <> $user_id";
                $peeps_result = mysqli_query($link, $peeps_sql);
                while ($peeps_row = mysqli_fetch_assoc($peeps_result)) {
                    echo ("<div style='width:100%;border-bottom:1px solid black;'>");
                        echo ("<div style='width: 85%;margin:0 auto;'>");
                            $pic = $peeps_row['profile_pic'];
                            $peep_id = $peeps_row['user_id'];
                            $name = $peeps_row['name'];
                            echo ("<h2>$name</h2>");
                            echo ("<img style='width:100%' src='images/$pic' />");
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

                            echo ("<span>");
                                echo ("<p>Is a $gender looking for $lookingfor</p>");
                                echo ("<p>$profile_discription</p>");
                                echo ("<P><a style='color:blue;' href='message.php?id=$peep_id&new_message=yes'>Message $name</a></p>");
                                echo ("<P>Lives: $city, $state</p>");
                                echo ("<p>Spiritual Traditions: $spiritual</p>");
                                echo ("<p>Enjoys Learning From: $experts</p>");
                                echo ("<p>Has Read: $books</p>");
                                echo ("<p>Attended These Seminars: $seminars</p>");
                                echo ("<p>Been To These Workshops: $workshops</p>");
                            echo ("</span>");
                        echo ("</div>");
                    echo ("</div>");
                }
                
                $peeps_sql = "select * from users where city NOT like '$user_city' and user_id <> $user_id";
                $peeps_result = mysqli_query($link, $peeps_sql);
                while ($peeps_row = mysqli_fetch_assoc($peeps_result)) {
                    echo ("<div style='width:100%;border-bottom:1px solid black;'>");
                        echo ("<div style='width: 85%;margin:0 auto;'>");
                            $pic = $peeps_row['profile_pic'];
                            $peep_id = $peeps_row['user_id'];
                            $name = $peeps_row['name'];
                            $gender = $peeps_row['gender'];
                            $lookingfor = $peeps_row['lookingfor'];
                            echo ("<h2>$name is a $gender looking for a $lookingfor</h2>");
                            echo ("<img style='width:100%' src='images/$pic' />");
                            $city = $peeps_row['city'];
                            $state = $peeps_row['state'];
                            $spiritual = $peeps_row['spiritual'];
                            $experts = $peeps_row['experts'];
                            $books = $peeps_row['books'];
                            $seminars = $peeps_row['seminars'];
                            $workshops = $peeps_row['workshops'];
                            $profile_description = $peeps_row['profile_description'];

                            echo ("<span>");
                                echo ("<p>$profile_discription</p>");
                                echo ("<P><a href='message.php?id=$peep_id&new_message=yes'>Message $name</a></p>");
                                echo ("<P>Lives: $city, $state</p>");
                                echo ("<p>Spiritual Traditions: $spiritual</p>");
                                echo ("<p>Enjoys Learning From: $experts</p>");
                                echo ("<p>Has Read: $books</p>");
                                echo ("<p>Attended These Seminars: $seminars</p>");
                                echo ("<p>Been To These Workshops: $workshops</p>");
                            echo ("</span>");
                        echo ("</div>");
                    echo ("</div>");
                }
                ?>

    </body>
</html>