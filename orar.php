<?php
require_once("include/smarty.php");
require_once("include/BazaDeDate.php");

session_start();

BazaDeDate::deschide();

/*
if (isset($_SESSION["email"]))
    $text = "<p>Afișez orarul pentru grupa ${_SESSION['grupa']} pentru că ești autentificat și lista cu celelalte orare.</p>";
else
    $text = "<p>Afișez lista de orare pentru că nu ești autentificat.</p>";
$smarty->assign("text", $text);
*/


if (isset($_GET["grupa"]))
{
    $discipline = BazaDeDate::disciplinePentruGrupa($_GET["grupa"]);
    $smarty->assign("discipline", $discipline);
    $g = $_GET["grupa"];
    $grupa = "grupa " . $g[3] . $g[2] . ", anul " . $g[1];
    $smarty->assign("grupa", $grupa);
}
else
{
    $grupe = BazaDeDate::getGrupe();

    $trebuie = "1";
    $afiseaza = "";

    foreach ($grupe as $grupa)
    {
        if ($grupa[1] == $trebuie)
        {
            $afiseaza .= "</p><p>Anul $trebuie: ";
            $trebuie = (string) ($trebuie + 1);
        }

        $gr = $grupa[3] . $grupa[2];
        $afiseaza .= "<a href='orar.php?grupa=$grupa'>$gr</a> ";
    }

    $afiseaza = substr($afiseaza, 4) . "</p>";

    if (isset($_SESSION["email"]))
    {
        //$afiseaza = "<p></p>" . $afiseaza;
        $discipline = BazaDeDate::disciplinePentruGrupa($_SESSION["grupa"]);
        $smarty->assign("discipline", $discipline);
        $g = $_SESSION["grupa"];
        $grupa = "grupa " . $g[3] . $g[2] . ", anul " . $g[1];
        $smarty->assign("grupa", $grupa);

        $afiseaza = "<p>Acesta este orarul pentru grupa ta. Dacă vrei să vezi orarul pentru alte grupe selectează de mai jos.</p>" . $afiseaza;
    }
    else
    {
        $afiseaza = "<p>Nu ești înregistrat, deci îți afișez lista de grupe pentru care poți afla orarul.</p>" . $afiseaza;
    }

    $smarty->assign("afiseaza", $afiseaza);
}
BazaDeDate::inchide();

$smarty->display("orar.tpl");
?>
