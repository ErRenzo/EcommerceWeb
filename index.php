<?php
    session_unset();
    session_destroy(); 
    session_start();
    $_SESSION["logUtente"] = false;
    $_SESSION["idUtente"] = null;
    header("Location: login.php");
    exit;
?>