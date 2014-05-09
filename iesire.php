<?php
session_start();

if (isset($_SESSION["email"]))
    session_destroy();

if (isset($_SERVER["HTTP_REFERER"]))
    header("Location: " . $_SERVER["HTTP_REFERER"]);
else
    header("Location: http://" . $_SERVER["HTTP_HOST"] . "/index.php");
?>
