<?php
require_once("include/BazaDeDate.php");
require_once("include/smarty.php");

session_start();
BazaDeDate::deschide();

if (!isset($_SESSION["email"]))
{
    header("Location: http://" . $_SERVER["HTTP_HOST"] . "/autentificare.php");
    exit;
}

$participanti = BazaDeDate::getGrupe();
$participantiNume = array();
foreach ($participanti as $g)
    $participantiNume[] = "anul " . $g[1]. ", grupa " . $g[3] . $g[2];
$erori = array();
$dateUtilizator = BazaDeDate::getDateUtilizator($_SESSION["email"]);

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    // Verific dacă valorile sunt corecte și le adaug în baza de date.
    $nume = htmlspecialchars(str_replace('"', '', $_POST["nume"]));
    $parolaVeche = $_POST["parolaVeche"];
    $parolaNoua1 = $_POST["parolaNoua1"];
    $parolaNoua2 = $_POST["parolaNoua2"];
    $grupa = $_POST["grupa"];

    if (strlen($nume) < 1)
        $erori[] = "Numele „${nume}“ este prea mic.";
    if (strlen($nume) > 40)
        $erori[] = "Numele „${nume}“ este prea lung. Trebuie să aibă mai puțin de 40 de caractere.";
    if (array_search($grupa, $participanti) === FALSE)
        $erori[] = "Nu există grupa „${grupa}“.";

    if (count($erori) === 0)
    {
        BazaDeDate::setNumeSiGrupaUtilizator($_SESSION["email"], $nume, $grupa);

        $_SESSION["nume"] = $nume;
        $_SESSION["grupa"] = $grupa;

        // Dacă vrea să modifice și parola.
        if ($parolaNoua1 != "" || $parolaNoua2 != "")
        {
            if ($dateUtilizator["md5parola"] !== md5($parolaVeche))
                $erori[] = "Parola vechie este incorectă.";
            if (strlen($parolaNoua1) < 6)
                $erori[] = "Parola nouă este prea mică.";
            if ($parolaNoua1 !== $parolaNoua2)
                $erori[] = "Parolele nu sunt identice.";

            if (count($erori) === 0)
                BazaDeDate::modificaParola($_SESSION["email"], $parolaNoua1);
        }
    }
}

$smarty->assign("participanti", $participanti);
$smarty->assign("participantiNume", $participantiNume);
$smarty->assign("numeVechi", $dateUtilizator["nume"]);
$smarty->assign("grupaVeche", $dateUtilizator["grupa"]);
$smarty->assign("erori", $erori);
$smarty->display("modificare.tpl");

BazaDeDate::inchide();
?>
