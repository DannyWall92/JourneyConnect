<?php
setcookie ('user_id', $user_id, time() - (86400 * 30));
header('Location: https://dewdevelopment.com/connect/signin.php');
?>