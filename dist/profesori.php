<?php
require_once("include/smarty.php");
require_once("include/BazaDeDate.php");

session_start();
BazaDeDate::deschide();

if (isset($_SESSION["email"])) $auten = TRUE;
else $auten = FALSE;

if (isset($_GET["prof"]))
{
    $nume = $_GET["prof"];
    $smarty->assign("nume", $nume);

    $discipline = BazaDeDate::disciplinePentruProf($nume);
    $smarty->assign("discipline", $discipline);
}
else
{
    $profi = BazaDeDate::getProfi();
    if ($auten) $mei = BazaDeDate::profiiMei($_SESSION["grupa"]);

    $afis = "<p>Lista de profesori:</p><div class='c4'><ul>";
    foreach ($profi as $prof)
    {
        if ($auten && array_search($prof, $mei) !== FALSE)
            $afis .= "<li><strong><a href='/timr/profesori.php?prof=$prof'>$prof</a></strong></li>";
        else
            $afis .= "<li><a href='/timr/profesori.php?prof=$prof'>$prof</a></li>";
    }
    $afis .= "</ul></div>";
    $smarty->assign("afiseaza", $afis);
}

BazaDeDate::inchide();
$smarty->display("profesori.tpl");
?>
