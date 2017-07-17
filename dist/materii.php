<?php
require_once("include/smarty.php");
require_once("include/BazaDeDate.php");

session_start();
BazaDeDate::deschide();

if (isset($_SESSION["email"])) $auten = TRUE;
else $auten = FALSE;

if (isset($_GET["disciplina"]))
{
    $materie = $_GET["disciplina"];
    $smarty->assign("materie", $materie);

    $discipline = BazaDeDate::disciplinePentruMaterie($materie);
    $smarty->assign("discipline", $discipline);
}
else
{
    $materii = BazaDeDate::getMaterii();
    if ($auten) $mele = BazaDeDate::materiileMele($_SESSION["grupa"]);
    $afis = "<p>Lista de materii:</p><div class='c3'><ul>";
    foreach ($materii as $materie)
    {
        if ($auten && array_search($materie, $mele) !== FALSE)
            $afis .= "<li><strong><a href='/timr/materii.php?disciplina=$materie'>$materie</a></strong></li>";
        else
            $afis .= "<li><a href='/timr/materii.php?disciplina=$materie'>$materie</a></li>";
    }

    $afis .= "</ul></div>";
    $smarty->assign("afiseaza", $afis);
}

BazaDeDate::inchide();
$smarty->display("materii.tpl");
?>
