<?php
ob_start();
if (!isset($_COOKIE['user_id'])) {
    header('Location: https://dewdevelopment.com/connect/signin.php');
} else {
    header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
    header("Pragma: no-cache"); // HTTP 1.0.
    header("Expires: 0"); // Proxies.
    
    include 'config.php';
    $link = mysqli_connect($host, $dbuser, $dbpass, $dbname);
    $user_id = mysqli_real_escape_string($link, htmlspecialchars($_COOKIE['user_id']));
    $user_sql = "select * from users where user_id = $user_id";
    $user_result = mysqli_query($link, $user_sql);
    $user_row = mysqli_fetch_assoc($user_result);
    $user_id = $user_row['user_id'];
    $email = $user_row['email'];
    $name = $user_row['name'];
    $city = $user_row['city'];
    $state = $user_row['state'];
    $gender = $user_row['gender'];
    $age = $user_row['age'];
    $job = $user_row['job'];
    $lookingfor = $user_row['lookingfor'];
    $spiritual = $user_row['spiritual'];
    $experts = $user_row['experts'];
    $books = $user_row['books'];
    $seminars = $user_row['seminars'];
    $workshops = $user_row['workshops'];
    $profile_description = $user_row['profile_description'];
    if (isset($_GET['del'])) {
        $message_id = mysqli_real_escape_string($link, htmlspecialchars($_GET['del']));
        $del_sql = "update messages set visible = 2 where to_user_id = $user_id and message_id = $message_id";
        $del_result = mysqli_query($link, $del_sql);
    }
    if (isset($_GET['edit'])) {
        $edit = htmlspecialchars($_GET['edit']);
    }
    if (isset($_POST['edit'])) {
        $edit = htmlspecialchars($_POST['edit']);
        if ($edit === "update") {
            $upd_sql = "update users set ";
            $name = mysqli_real_escape_string($link, htmlspecialchars($_POST['name']));
            $upd_sql = $upd_sql . "name = '" . $name . "', ";
            $email = mysqli_real_escape_string($link, htmlspecialchars($_POST['email']));
            $upd_sql = $upd_sql . "email = '" . $email . "', ";
            $city = mysqli_real_escape_string($link, htmlspecialchars($_POST['city']));
            $upd_sql = $upd_sql . "city = '" . $city . "', ";
            $state = mysqli_real_escape_string($link, htmlspecialchars($_POST['state']));
            $upd_sql = $upd_sql . "state = '" . $state . "', ";

            $age = mysqli_real_escape_string($link, htmlspecialchars($_POST['age']));
            $upd_sql = $upd_sql . "age = '" . $age . "', ";
            $job = mysqli_real_escape_string($link, htmlspecialchars($_POST['job']));
            $upd_sql = $upd_sql . "job = '" . $job . "', ";
            

            $spiritual = mysqli_real_escape_string($link, htmlspecialchars($_POST['spiritual']));
            $upd_sql = $upd_sql . "spiritual = '" . $spiritual . "', ";
            $experts = mysqli_real_escape_string($link, htmlspecialchars($_POST['experts']));
            $upd_sql = $upd_sql . "experts = '" . $experts . "', ";
            $books = mysqli_real_escape_string($link, htmlspecialchars($_POST['books']));
            $upd_sql = $upd_sql . "books = '" . $books . "', ";
            $seminars = mysqli_real_escape_string($link, htmlspecialchars($_POST['seminars']));
            $upd_sql = $upd_sql . "seminars = '" . $seminars . "', ";
            $workshops = mysqli_real_escape_string($link, htmlspecialchars($_POST['workshops']));
            $upd_sql = $upd_sql . "workshops = '" . $workshops . "', ";
            $profile_description = mysqli_real_escape_string($link, htmlspecialchars($_POST['profile_description']));
            $upd_sql = $upd_sql . "profile_description = '" . $profile_description . "' ";
            $upd_sql = $upd_sql . "where user_id = " . $user_id;
            $upd_result = mysqli_query($link, $upd_sql);
        }
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
                if ($edit === "yes" || $edit === "update") {
                    if ($edit === "yes") {
                        ?>
                        <h2>Edit Profile</h2>
                        <form action='profile.php' method="POST">
                            <input type="hidden" name="edit" value="update">
                            <p>Name: <input type="text" name="name" value="<?php echo $name ?>" /></p>
                            <p>Email: <input type="text" name="email" value="<?php echo $email ?>" /></p>
                            <p>City: <input type="text" name="city" value="<?php echo $city ?>" /></p>
                            <p>State: <input type="text" name="state" value="<?php echo $state ?>" /></p>
                            <p>Age: <input type="text" name="age" value="<?php echo $age ?>" /></p>
                            <p>Profession: <input type="text" name="job" value="<?php echo $job ?>" /></p>
                            <p>Spiritual Traditions (comma separated):<br /><input type="text" name="spiritual" value="<?php echo $spiritual ?>" size="50" placeholder="Example: Yoga, Kundalini" value="<?php echo $spiritual ?>" /></p>
                            <P>
                                Experts (comma separated)<br />
                                <input type="text" class="textinput" name="experts" size="50" value="<?php echo $experts ?>" placeholder="Example: Eckhart Tolle, Dr. Joe Dispenza" />
                            </p>
                            <p>
                                The Best Books You&apos;ve Read (comma separated)<br />
                                <input type="text" class="textinput" name="books" size="50" value="<?php echo $books ?>" placeholder="Example: Becoming Supernatural, You Are Here" />
                            </p>
                            <p>
                                Seminars You&apos;ve Been To (comma separated, single day events)<br />
                                <input type="text" class="textinput" name="seminars" size="50" value="<?php echo $seminars ?>" placeholder="Example: Echart Tolle: Toronto, Neale Donald Walsch: Tucson" />
                            </p>
                            <P>
                                The Best Workshops You&apos;ve Been To (comma separated, multi day events)<br />
                                <input type="text" class="textinput" name="workshops" size="50" value="<?php echo $workshops ?>" placeholder="Example: Joe Dispenza: Denver, Bruce Lipton: Sedona" />
                            </p>
                            <p>
                                Your Profile Description:<br />
                                <textarea class="inputarea" name="profile_description" rows="20" cols="50"><?php echo $profile_description ?></textarea>
                            </P>
                            <p><input type="submit" name="submit" value="update" /></p>
                        </FORM>
                        <?php
                    } else {
                        echo ("<h2>Your Profile <a href='profile.php?edit=yes'>(edit)</a></h2>");
                        echo ("<P><strong>Name:</strong> $name</P>");
                        echo ("<P><strong>Email:</strong> $email</P>");
                        echo ("<P><strong>City:</strong> $city</P>");
                        echo ("<P><strong>Age:</strong> $age</P>");
                        echo ("<P><strong>Profession:</strong> $job</P>");
                        echo ("<P><strong>State:</strong> $state</P>");
                        echo ("<P><strong>You are a:</strong> $gender <strong>Looking for a:</strong> $lookingfor</P>");
                        echo ("<P><strong>Following Spiritual Tradition(s):</strong> $spiritual</P>");
                        echo ("<P><strong>Experts:</strong> $experts</P>");
                        echo ("<P><strong>Books:</strong> $books</P>");
                        echo ("<P><strong>Seminars:</strong> $seminars</P>");
                        echo ("<P><strong>Workshops:</strong> $workshops</P>");
                        $profile_description = str_replace('\r\n', "<br />", $profile_description);
                        $profile_description = str_replace("\'", "&apos;", $profile_description);
                        $profile_description = str_replace('\"', "&quot;", $profile_description);
                        echo ("<P><strong>Profile Description:</strong> $profile_description</P>");
                        echo ("<p><a href='connect.php'>Return to Home Screen</a></P>");    
                    }
                } else {
                    echo ("<h2>Your Profile (<a href='profile.php?edit=yes'>edit</a>)</h2>");
                    echo ("<p><a href='password.php'>Update Your Password</a></p>");
                    echo ("<P><strong>Name:</strong> $name</P>");
                    echo ("<P><strong>Email:</strong> $email</P>");
                    echo ("<P><strong>City:</strong> $city</P>");
                    echo ("<P><strong>State:</strong> $state</P>");
                    echo ("<P><strong>Age:</strong> $age</P>");
                    echo ("<P><strong>Profession:</strong> $job</P>");
                    echo ("<P><strong>You are a:</strong> $gender <strong>Looking for a:</strong> $lookingfor</P>");
                    echo ("<P><strong>Following Spiritual Tradition(s):</strong> $spiritual</P>");
                    echo ("<P><strong>Experts:</strong> $experts</P>");
                    echo ("<P><strong>Books:</strong> $books</P>");
                    echo ("<P><strong>Seminars:</strong> $seminars</P>");
                    echo ("<P><strong>Workshops:</strong> $workshops</P>");
                    echo ("<P><strong>Profile Description:</strong> $profile_description</P>");
                    
                }
                ?>
            </div>
        </div>
    </body>
</html>