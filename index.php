<?php
    session_start();
    $_SESSION["logUtente"] = false;
    $_SESSION["idUtente"];
    header("Location: login.php");
    exit;
?>