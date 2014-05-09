<?php
require_once("include/BazaDeDate.php");
require_once("include/smarty.php");

BazaDeDate::deschide();
session_start();

$referer = isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : "";
$erori = array();

if (isset($_SESSION["email"]))
    $erori[] = "Ești deja autentificat. Trebuie să <a href='/iesire.php'>ieși</a> dacă vrei să intrii din nou.";

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $email = str_replace('"', '', $_POST["email"]);
    $md5parola = md5($_POST["parola"]);
    $vineDeLa = $_POST["vineDeLa"];

    if (!BazaDeDate::existaUtilizatorul($email))
    {
        $erori[] = "Nu există nimeni cu adresa de <em>email</em> „${email}“.";
    }
    else
    {
        $dateUtilizator = BazaDeDate::getDateUtilizator($email);
        if ($dateUtilizator["md5parola"] !== $md5parola)
            $erori[] = "Parola nu se potrivește. Dacă ai uitat parola poți să o <a href='/recuperare.php'>recuperezi</a>.";
    }

    if (count($erori) === 0)
    {
        BazaDeDate::modificaTimpAutentificare($email);

        $_SESSION["email"] = $email;
        $_SESSION["nume"] = $dateUtilizator["nume"];
        $_SESSION["grupa"] = $dateUtilizator["grupa"];

        $baza = "http://" . $_SERVER["HTTP_HOST"];

        if (strpos($vineDeLa, $baza) !== 0 && $vineDeLa[0] != "/")
            $vineDeLa = ""; // Nu e de pe saitul ăsta.
        if ($vineDeLa == $vineDeLa . $_SERVER["PHP_SELF"])
            $vineDeLa = ""; // Nu trimite pe pagina asta.

        if ($vineDeLa == "")
            $vineDeLa = $baza . "/index.php";

        header("Location: $vineDeLa");
        exit;
    }
}

$smarty->assign("erori", $erori);
$smarty->assign("referer", $referer);
$smarty->display("autentificare.tpl");

BazaDeDate::inchide();
?>
