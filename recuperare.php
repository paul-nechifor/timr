<?php
require_once("include/BazaDeDate.php");
require_once("include/Scrisoare.php");
require_once("include/smarty.php");

BazaDeDate::deschide();
BazaDeDate::stergeRecuperariExpirate();
session_start();

$erori = array();
$stare = NULL;
$email = NULL;


if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $email = str_replace('"', '', $_POST["email"]);

    if (!BazaDeDate::existaUtilizatorul($email))
        $erori[] = "Nu există adresa de <em>email</em> „${email}“.";
    else if (BazaDeDate::existaRecuperare($email))
        $erori[] = "A mai fost făcută o cerere de recuperare.";

    if (count($erori) === 0)
    {
        $codrec = md5(mt_rand()); // TODO: să pun un cod mai bun
        BazaDeDate::insereazaRecuperare($codrec, $email);

        $urlrec = "http://". $_SERVER["HTTP_HOST"] ."/recuperare.php?codrec=$codrec";
        $adresaIp = $_SERVER["REMOTE_ADDR"];
        $mesaj = "Ai solicitat crearea unei noi parole (de la $adresaIp). Încarcă URL-ul următor ca să-ți fie trimisă".
                " o parolă nouă.\n\n$urlrec\n\nDupă asta poți să-ți modifici parola din profil.\n\nDacă nu ai".
                " solicitat tu crearea unei noi parole poți să ignori acest mesaj.";

        Scrisoare::trimite($email, "Recuperare parolă", $mesaj);
    }
}
else
{
    if (isset($_GET["codrec"]))
    {
        $codrec = str_replace("'", "", $_GET["codrec"]);
        $rec = BazaDeDate::getDateRecuperare($codrec);

        if ($rec === FALSE)
            $erori[] = "Nu există acest cod de recuperare.";

        // Nu verific dacă codul de recuperare e prea vechi pentru că se șterg la început cele vechi.

        if (count($erori) === 0)
        {
            $email = $rec["email"];
            $parolaNoua = substr(md5(mt_rand()), 0, 10);

            BazaDeDate::stergeRecuperare($codrec);
            BazaDeDate::modificaParola($email, $parolaNoua);

            $urlauten = "http://" . $_SERVER["HTTP_HOST"] . "/autentificare.php";
            $mesaj = "Informații de autentificare\n\nEmail: $email\nParolă: $parolaNoua\n\nAcum poți să te autentifici pe:\n\n$urlauten.";

            Scrisoare::trimite($email, "Parolă nouă", $mesaj);
            $stare = "trimisParola";
        }
    }
}

$smarty->assign("erori", $erori);
$smarty->assign("email", $email);
$smarty->assign("stare", $stare);
$smarty->display("recuperare.tpl");

BazaDeDate::inchide();
?>
