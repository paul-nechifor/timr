<?php
require_once("Smarty/Smarty.class.php");

$dir = dirname(__FILE__);
$smarty = new Smarty();
$smarty->template_dir = $dir . "/../sabloane";
$smarty->compile_dir = $dir . "/../sabloane/compile";
$smarty->cache_dir = $dir . "/../sabloane/cache";
$smarty->config_dir = $dir . "/../sabloane/config";

$paginiDinMeniu = array
(
    array("Prima pagină", "/index.php"),
    array("Orar", "/orar.php"),
    array("Materii", "/materii.php"),
    array("Profesori", "/profesori.php"),
    array("Săli", "/sali.php"),
    array("Autori", "/autori.php")
);

$smarty->assign("paginiDinMeniu", $paginiDinMeniu);
$smarty->assign("numeFisier", $_SERVER["PHP_SELF"]);
?>
