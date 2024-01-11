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
}
if (isset($_GET['new_message'])) {
    $message_to_id = mysqli_real_escape_string($link, htmlspecialchars($_GET['id']));
    $action="new";
}
if (isset($_POST['send_message'])) {
    $message_to_id = mysqli_real_escape_string($link, htmlspecialchars($_POST['id']));
    $subject = mysqli_real_escape_string($link, htmlspecialchars($_POST['subject']));
    $body = mysqli_real_escape_string($link, htmlspecialchars($_POST['body']));
    $action = "update";
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
            <div class="connect_logo"><a href="connect.php">Journey Connect</a></div>
            <div class="nav">
                <a href="center.php">Message Center</a> | 
                <a href="profile.php">Edit Profile</a> | 
                <a href="logout.php">Logout</a>
            </div>
        </div>
        <div class="body_wrapper">
            <div class="top_section">
                <h2>Message</h2>
                <P><a href="connect.php">Return to Home</a></p>
                <?php
                if ($action == "new") {
                    $get_sql = "select * from users where user_id = $message_to_id";
                    $get_result = mysqli_query($link, $get_sql);
                    $get_row = mysqli_fetch_assoc($get_result);
                    $to_name = $get_row['name'];
                    echo ("<p>Sending Message To $to_name</p>");
                    ?>
                    <form action="message.php" method="POST">
                        <P>Message Subject:<br />
                        <input type="text" class="textinput" name="subject" size="50" /></p>
                        <p>Message Body:<br />
                        <textarea class="inputarea" name="body" rows="20" cols="50"></textarea></p>
                        <input type="hidden" name="send_message" value="yes" />
                        <input type="hidden" name="id" value="<?php echo $message_to_id ?>">
                        <P><input type="submit" name="submit" value="Send Message" /></p>
                    </form>
                    <?php
                }
                if ($action == "update") {
                    $msg_sql = "insert into messages (from_user_id, to_user_id, subject, body)";
                    $msg_sql = $msg_sql . " VALUES ";
                    $msg_sql = $msg_sql . "($user_id, $message_to_id, '$subject', '$body')";
                    $msg_result = mysqli_query($link, $msg_sql);
                    $get_sql = "select * from users where user_id = $message_to_id";
                    $get_result = mysqli_query($link, $get_sql);
                    $get_row = mysqli_fetch_assoc($get_result);
                    $to_name = $get_row['name'];
                    echo ("<P>Message sent to $to_name</P>");
                    echo ("<P>Message Subject<br />$subject</P>");
                    echo ("<P>Message Body<br />$body</P>");
                    echo ("<P><a href='connect.php'>Return to Home</a></p>");
                }
                ?> 
            </div>
        </div>
    </body>
</html>