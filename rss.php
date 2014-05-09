<?php
require_once("include/BazaDeDate.php");
BazaDeDate::deschide();

$g = $_GET["grupa"];
$discipline = BazaDeDate::disciplinePentruGrupa($g);
$lungG = "grupa ". $g[3] . $g[2];
$lungA = "anul " . $g[1];

print '
<?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0">
    <channel>
        <title>Orar '. $g .'</title>
        <link>http://paulnechifor.homeip.net</link>
        <description>Orarul pentru grupa '. $g .' de la Facultatea de Informatică</description>
';

foreach ($discipline as $d)
{
    print "\n        <item>
            <title>{$d['den']}</title>
            <link>http://paulnechifor.homeip.net</link>
            <description>Cu profesorul {$d['titprof']} {$d['prof']} în sala {$d['sala']}, {$d['zi']} de la ora {$d['start']} la {$d['final']}.</description>
        </item>\n";
}

print '    </channel>
</rss>';

BazaDeDate::inchide();
?>
