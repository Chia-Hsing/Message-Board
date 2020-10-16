<?php
    session_start();

    session_unset();
    setcookie("PHPSESSID","", time()-3600*24, "/");
    session_destroy();

    header ("Location: ../sign-in/sign_in.php");
?>
