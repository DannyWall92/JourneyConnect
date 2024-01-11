<?php
ob_start();
if (!isset($_COOKIE['user_id'])) {
    header ('Location: https://dewdevelopment.com/connect/index.html');
} else {
    include 'config.php';
    $link = mysqli_connect($host, $dbuser, $dbpass, $dbname);
    $user_id = mysqli_real_escape_string($link, htmlspecialchars($_COOKIE['user_id']));
    if (is_numeric($user_id)) {
        if(isset($_FILES['image'])){
            $errors= array();
            $file_name = $_FILES['image']['name'];
            $file_size = $_FILES['image']['size'];
            $file_tmp = $_FILES['image']['tmp_name'];
            $file_type = $_FILES['image']['type'];
            $file_ext=strtolower(end(explode('.',$_FILES['image']['name'])));

            $file_name = "$user_id" . "_1" . "." . "$file_ext";
            $upd_sql = "update users set profile_pic = '$file_name' where user_id = $user_id";
            $upd_result = mysqli_query($link, $upd_sql);

            $extensions=array("jpeg","jpg","png");

            if(in_array($file_ext,$extensions)=== false){
                $errors[]="extension not allowed, please choose a JPEG or PNG file.";
            }

            if($file_size > 6097152) {
                $errors[]='File size must not exceed 6 MB';
            }

            if(empty($errors)==true) {
                move_uploaded_file($file_tmp,"images/".$file_name);
                echo "Success";
            }else{
                print_r($errors);
            }
        }

        if (isset($_POST['submit'])) {
            $profile_description = mysqli_real_escape_string($link, htmlspecialchars($_POST['profile_description']));
            $sql = "update users set profile_description = '$profile_description' where user_id = $user_id";
            $result = mysqli_query($link, $sql);
        }
    } else {
        setcookie ('user_id', $user_id, time() - (86400 * 30));
        header ('Location: https://dewdevelopment.com/connect/signin.php');
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
        <div class="header">
            <div class="connect_logo">Journey Connect</div>
            <div class="nav">Sign In</div>
        </div>
        <div class="body_wrapper">
            <div class="top_section">
                <h2>Now Upload A Picture Of You</h2>
                <p>Image must be jpg or jpeg only</p>
                <form action="" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="user_id" value="<?php echo $user_id ?>" />
                    <input type = "file" name = "image" />
                    <input type = "submit" name="file_submit" />

                    <?php
                    if (isset($errors)) {
                        echo ("<p>$errors</p>");
                    }

                    if (isset($file_name)) {
                    ?>
                        <h2><a href="connect.php">If you like your first image, Click Here to proceed</a></h2>
                        <p>If not, upload a new image by selecting above</p>
                        <img width="99%" src="images/<?php echo $file_name ?>" />
                    <?php
                    }
                    ?>
                </form>
            </div>
        </div>
    </body>
</html>