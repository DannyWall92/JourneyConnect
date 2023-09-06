<?php
ob_start();
if (isset($_GET['submit'])){
    $gender = htmlspecialchars($_GET['gender']);
    $lookingfor = htmlspecialchars($_GET['lookingfor']);
    $spiritual = htmlspecialchars($_GET['spiritual']);
    $experts = htmlspecialchars($_GET['experts']);
    $books = htmlspecialchars($_GET['books']);
    $seminars = htmlspecialchars($_GET['seminars']);
    $workshops = htmlspecialchars($_GET['workshops']);
} else {
    header('Location: https://dewdevelopment.com/connect/index.html');
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
            <div class="connect_logo">Journey Connect</div>
            <div class="nav">Sign In</div>
        </div>
        <div class="body_wrapper">
            <div class="top_section">
                <h2>A Little About You</h2>
                <form action="step4.php" method="GET">
                    <input type="hidden" name="gender" value="<?php echo $gender ?>">
                    <input type="hidden" name="lookingfor" value="<?php echo $lookingfor ?>">
                    <input type="hidden" name="spiritual" value="<?php echo $spiritual ?>">
                    <input type="hidden" name="experts" value="<?php echo $experts ?>">
                    <input type="hidden" name="books" value="<?php echo $books ?>">
                    <input type="hidden" name="seminars" value="<?php echo $seminars ?>">
                    <input type="hidden" name="workshops" value="<?php echo $workshops ?>">
                    <p>
                        Your Real First & Last Name<br />
                        <input type="text" class="textinput" name="firstlast" size="50" required />
                    </p>
                    <p>
                        Your Age<br />
                        <input type="text" class="textinput" name="age" size="50" required />
                    </p>
                    <P>
                        Your Email (will also be your username)<br />
                        <input type="text" class="textinput" name="email" size="50" required />
                    </p>
                    <p>
                        Password You Want To Use<br />
                        <input type="text" class="textinput" name="password" size="50" required />
                    </p>
                    <p>
                        City You Live In<br />
                        <input type="text" class="textinput" name="city" size="50" required />
                    </p>
                    <P>
                        State You Live In<br />
                        <input type="text" class="textinput" name="state" size="50" required />
                    </p>
                    <p>
                        Your Profession<br />
                        <input type="text" class="textinput" name="job" size="50" required />
                    </p>
                    <input type="submit" name="submit" value="Next >>">
                </form>
            </div>
        </div>
    </body>
</html>