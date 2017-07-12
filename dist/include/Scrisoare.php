<?php
require_once("Mail.php");

class Scrisoare
{
    public static function trimite($catre, $titlu, $text)
    {
        $dela = '"Timer" <timerrrrr@gmail.com>';
        $headers = array('From' => $dela, 'To' => $catre, 'Subject' => $titlu);
        $smtp = Mail::factory('smtp', array
        (
            'host' => "ssl://smtp.gmail.com",
            'port' => "465",
            'auth' => true,
            'username' => "timerrrrr@gmail.com",
            'password' => "cevaEGresitAici"
        ));

        $rez = $smtp->send($catre, $headers, $text);
        if ($rez != 1)
            die("Eroare la mail: " . $rez);
    }
}
?>
