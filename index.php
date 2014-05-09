<?php
require_once("include/smarty.php");

session_start();
$smarty->display("index.tpl");
?>
