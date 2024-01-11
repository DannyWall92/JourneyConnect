<?php
ob_start();
if (isset($_GET['submit'])) {
    $gender = htmlspecialchars($_GET['gender']);
    $lookingfor = htmlspecialchars($_GET['lookingfor']);
} else {
    header ('Location: https://dewdevelopment.com/connect/index.html');
}
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
                <h2>Traditions & Experts</h2>
                <p>Here you say what spiritual traditions and spiritual experts are important to you</p>
                <form action="step3.php" method="GET">
                    <input type="hidden" name="gender" value="<?php echo $gender ?>">
                    <input type="hidden" name="lookingfor" value="<?php echo $lookingfor ?>">
                    <p>
                        Spiritual Traditions (comma separated)<br />
                        <input type="text" class="textinput" name="spiritual" size="50" placeholder="Example: Yoga, Kundalini" />
                    </p>
                    <P>
                        Experts (comma separated)<br />
                        <input type="text" class="textinput" name="experts" size="50" placeholder="Example: Eckhart Tolle, Dr. Joe Dispenza" />
                    </p>
                    <p>
                        The Best Books You&apos;ve Read (comma separated)<br />
                        <input type="text" class="textinput" name="books" size="50" placeholder="Example: Becoming Supernatural, You Are Here" />
                    </p>
                    <p>
                        Seminars You&apos;ve Been To (comma separated, single day events)<br />
                        <input type="text" class="textinput" name="seminars" size="50" placeholder="Example: Echart Tolle: Toronto, Neale Donald Walsch: Tucson" />
                    </p>
                    <P>
                        The Best Workshops You&apos;ve Been To (comma separated, multi day events)<br />
                        <input type="text" class="textinput" name="workshops" size="50" placeholder="Example: Joe Dispenza: Denver, Bruce Lipton: Sedona" />
                    </p>
                    <input type="submit" name="submit" value="Next >>">
                </form>
            </div>
        </div>
    </body>
</html>