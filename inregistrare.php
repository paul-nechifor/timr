<?php
require_once("include/BazaDeDate.php");
require_once("include/smarty.php");

session_start();
BazaDeDate::deschide();

$participanti = BazaDeDate::getGrupe();
$participantiNume = array();
foreach ($participanti as $g)
    $participantiNume[] = "anul " . $g[1]. ", grupa " . $g[3] . $g[2];
$erori = array();

if (isset($_SESSION["email"]))
{
    header("Location: http://" . $_SERVER["HTTP_HOST"] . "/index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    // Verific dacă valorile sunt corecte și le adaug în baza de date.
    $nume = htmlspecialchars(str_replace('"', '', $_POST["nume"]));
    $parola1 = $_POST["parola1"];
    $parola2 = $_POST["parola2"];
    $grupa = $_POST["grupa"];
    $email = str_replace('"', '', $_POST["email"]);

    if (strlen($nume) < 1)
        $erori[] = "Numele „${nume}“ este prea mic.";
    if (strlen($nume) > 40)
        $erori[] = "Numele „${nume}“ este prea lung. Trebuie să aibă mai puțin de 40 de caractere.";
    if (!preg_match("/^[A-Z0-9._%-]+@[A-Z0-9][A-Z0-9.-]{0,61}[A-Z0-9]\.[A-Z]{2,6}$/i", $email))
        $erori[] = "Adresa <em>email</em> „${email}“ nu prea e validă.";
    if (BazaDeDate::existaUtilizatorul($email))
        $erori[] = "Adresă <em>email</em> „${email}“ există în baza de date. Dacă ți-ai uitat parola poți s-o <a href='/recuperare.php'>recuperezi</a>.";
    if (array_search($grupa, $participanti) === FALSE)
        $erori[] = "Nu există grupa „${grupa}“.";
    if (strlen($parola1) < 6)
        $erori[] = "Parola este prea scurtă.";
    if ($parola1 !== $parola2)
        $erori[] = "Parolele nu coincid.";

    if (count($erori) == 0)
        BazaDeDate::insereazaUtilizator($nume, $parola1, $grupa, $email);
}
BazaDeDate::inchide();

$smarty->assign("participanti", $participanti);
$smarty->assign("participantiNume", $participantiNume);
$smarty->assign("erori", $erori);
$smarty->display("inregistrare.tpl");
?>
