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
    if (isset($_GET['del'])) {
        $message_id = mysqli_real_escape_string($link, htmlspecialchars($_GET['del']));
        $del_sql = "update messages set visible = 2 where to_user_id = $user_id and message_id = $message_id";
        $del_result = mysqli_query($link, $del_sql);
    }
}
ob_end_flush();
?>
<html>
    <head>
        <title>Journey Connect</title>
        <link rel="stylesheet" href="styles.css" />
        <script src="scripts.js"></script>
    </head>

   <body>
       <div class="header">
            <div class="connect_logo"><a href="connect.php">Journey Connect</a></div>
            <div class="nav">
                <a href="center.php">Message Center</a> | 
                <a href="profile.php">Edit Profile</a> | 
                <a href="logout.php">Logout</a>
            </div>
        </div>
        <div class="header_spacer">&nbsp;</div>
        <div class="body_wrapper">
            <div class="connect_section">
                <?php
                $getmsg_sql = "select * from messages join users on messages.from_user_id = users.user_id where messages.to_user_id = $user_id and messages.visible = 1 order by messages.message_read";
                $getmsg_result = mysqli_query($link, $getmsg_sql);
                $rows = mysqli_num_rows($getmsg_result);
                if ($rows > 0) {
                    while ($msg_row = mysqli_fetch_assoc($getmsg_result)) {
                        $message_id = $msg_row['message_id'];
                        $name = $msg_row['name'];
                        $peep_id = $msg_row['user_id'];
                        $subject = $msg_row['subject'];
                        $body = $msg_row['body'];
                        echo ("<h2>Message From $name</h2>");
                        echo ("<P><strong>Subject:</strong> $subject</p>");
                        echo ("<P><strong>Body:</strong><br />$body</p>");
                        echo ("<P>");
                            echo ("<a href='message.php?id=$peep_id&new_message=yes'>Reply</a> | ");
                            echo ("<a href='#' onclick='del_message($message_id)'>Delete</a>");
                        echo ("</P>");
                        echo ("<hr /><hr />");
                    }
                } else {
                    echo ("<h2>No messages</h2>");
                    echo ("<P><a href='connect.php'>Return to home screen</a></p>");
                }
                ?>
            </div>
        </div>
    </body>
</html>