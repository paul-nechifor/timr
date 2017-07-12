<?php
require_once("include/smarty.php");
require_once("include/BazaDeDate.php");

session_start();
BazaDeDate::deschide();

if (isset($_GET["sala"]))
{
    $sala = $_GET["sala"];
    $smarty->assign("sala", $sala);

    $discipline = BazaDeDate::disciplinePentruSala($sala);
    $smarty->assign("discipline", $discipline);
}
else
{
    $sali = BazaDeDate::getSali();

    $afis = "<p>Lista de săli:</p><div class='c4'><ul>";
    foreach ($sali as $sala)
        $afis .= "<li><a href='sali.php?sala=$sala'>$sala</a></li>";
    $afis .= "</ul></div>";
    $smarty->assign("afiseaza", $afis);
}

BazaDeDate::inchide();
$smarty->display("sali.tpl");
?>
