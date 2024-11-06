<?php
    session_start();
    session_destroy();
    setcookie('background_color', '', time() - 3600, "/");
    setcookie('font_color', '', time() - 3600, "/");
    header("Location: index.php");
    exit();