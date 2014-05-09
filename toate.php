<?php
require_once("include/smarty.php");
require_once("include/BazaDeDate.php");

BazaDeDate::deschide();

$grupe = BazaDeDate::getGrupe();

print "<html>";
foreach ($grupe as $grupa)
{
    $discipline = BazaDeDate::disciplinePentruGrupa($grupa);
    $smarty->assign("discipline", $discipline);
    $g = $grupa;
    $grupa = "grupa " . $g[3] . $g[2] . ", anul " . $g[1];
    $smarty->assign("grupa", $grupa);
    $smarty->display("toate.tpl");
}
print "</html>";
BazaDeDate::inchide();
?>
