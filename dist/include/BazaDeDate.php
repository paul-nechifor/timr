<?php
class BazaDeDate {
    const HOSTNAME = "";
    const USER = "root";
    const PASSWORD = "";
    const DATABASE = "orarbd";

    private static $mysqli = NULL;

    public static function deschide()
    {
        self::$mysqli = new mysqli(self::HOSTNAME, self::USER, self::PASSWORD, self::DATABASE);
    }
    public static function inchide()
    {
        self::$mysqli->close();
    }
    public static function executa($comanda)
    {
        $rezultat = self::$mysqli->query($comanda);
        if (!$rezultat) die("Comanda <b>$comanda</b>. Eroare: <b>" . self::$mysqli->error . "</b>");
        return $rezultat;
    }
    public static function numarDeRanduri($comanda)
    {
        $rezultat = self::executa($comanda);
        return $rezultat->num_rows;       
    }
    public static function primulRand($comanda)
    {
        $rezultat = self::executa($comanda);
        $rand = $rezultat->fetch_assoc();
        return $rand;
    }
    public static function dump($numeTabel)
    {
        $rezultat = self::executa("select * from $numeTabel;");
        if ($rezultat->num_rows == 0)
            return;

        echo "<h3>$numeTabel</h3>";
        echo "<table border='1'>";
        while ($rand = $rezultat->fetch_assoc())
        {
            echo "<tr>";
            foreach ($rand as $valoare)
                echo "<td>$valoare</td>";
            echo "</tr>";
        }
        echo "<table>";
    }
    public static function refaBazaDeDate()
    {
        self::deschide();

        $comenzi = array
        (
            "drop table if exists utilizatori;",
            "create table utilizatori
            (
                cod int not null auto_increment,
                nume char(40),
                md5parola char(128),
                codgrupa int,
                email char(40),
                timpinscr int,
                timpauten int,

                primary key(cod),
                foreign key(codgrupa) references participanti(cod)
            );",
            "drop table if exists participanti;",
            "create table participanti
            (
                cod int not null auto_increment,
                nume char(6) not null,
                codparinte int,

                primary key(cod),
                foreign key(codparinte) references participanti(cod)
            );",
            "drop table if exists recuperare;",
            "create table recuperare
            (
                codutil int not null,
                codrec char(128) not null,
                timp int not null
            );",
            "drop table if exists discipline;",
            "create table discipline
            (
                parti char(40) not null,
                zi int not null,
                start int not null,
                final int not null,
                den char(100) not null,
                tip char(16) not null,
                titprof char(16),
                prof char(32) not null,
                sala char(8) not null,
                frec char(5)
            );",
            "drop table if exists profi;",
            "create table profi
            (
                nume char(50) not null
            );",
            "drop table if exists sali;",
            "create table sali
            (
                nume char(10) not null
            );",
            "drop table if exists materii;",
            "create table materii
            (
                nume char(100) not null
            );"
        );

        $fisier = file_get_contents("/home/paul/http/include/date_orar.sql");
        $linii = explode("\n", $fisier);
        foreach ($linii as $linie)
            $comenzi[] = $linie;

        echo "<h3>Am făcut asta</h3><pre>";

        // Re-creez toate tabelele.
        foreach ($comenzi as $comanda)
        {
            if ($comanda == "") continue;
            echo $comanda . "\n";
            self::executa($comanda);
        }

        // Determin participanții.
        $url = "http://profs.info.uaic.ro/~orar/participanti/";
        $rez = file_get_contents($url);
        if (!$rez) die("Nu am putut să deschid '$url'.");
        preg_match_all('/>orar_([A-Z][0-9][A-Z][0-9]?|[A-Z]+[0-9]+).html</', $rez, $parrez);

        $participanti = array();
        foreach ($parrez[0] as $par)
             $participanti[] = substr($par, 6, -6); // Scoate ">orar_" și ".html<".
        sort($participanti); // ca să adauge în ordinea corectă

        $cod = array();
        $c = 1;
        foreach ($participanti as $par)
        {
            $cod[$par] = $c++;
            $parinte = "null";
            // Determin dacă există o grupă care conține grupa asta.
            if (($par[0] == 'I' && strlen($par) == 4) || ($par[0] == 'M' && ($par[strlen($par) - 2] <= '9')))
                $parinte = $cod[substr($par, 0, -1)];

            $comanda = "insert into participanti (nume, codparinte) values ('$par', $parinte);";
            echo $comanda . "\n";
            self::executa($comanda);
        }

        self::inchide();
    }
    public static function getParticipanti()
    {
        // Selectează grupele dar fără an sau semi-an.
        $rezultat = self::executa("select nume from participanti where cod not in (select distinct codparinte from participanti where codparinte is not null);");
        $participanti = array();
        while ($rand = $rezultat->fetch_assoc())
            $participanti[] = $rand["nume"];
        return $participanti;
    }
    public static function getGrupe()
    {
        $participanti = self::getParticipanti();
        $ret = array();
        foreach ($participanti as $participant)
            if (preg_match('/[A-Z][0-9][A-Z][0-9]/', $participant))
                $ret[] = $participant;
        return $ret;
    }
    public static function getProfi()
    {
        $rezultat = self::executa("select nume from profi;");
        $profi = array();
        while ($rand = $rezultat->fetch_assoc())
            $profi[] = $rand["nume"];
        return $profi;
    }
    public static function getSali()
    {
        $rezultat = self::executa("select nume from sali;");
        $sali = array();
        while ($rand = $rezultat->fetch_assoc())
            $sali[] = $rand["nume"];
        return $sali;
    }
    public static function getMaterii()
    {
        $rezultat = self::executa("select nume from materii;");
        $materii = array();
        while ($rand = $rezultat->fetch_assoc())
            $materii[] = $rand["nume"];
        return $materii;
    }
    public static function insereazaUtilizator($nume, $parola, $grupa, $email)
    {
        $md5parola = md5($parola);
        $timp = time();
        $q = "insert into utilizatori (nume, md5parola, codgrupa, email, timpinscr) values
                (\"$nume\", '$md5parola', (select cod from participanti where nume = '$grupa'), \"$email\", $timp);";
        self::executa($q);
    }
    public static function modificaTimpAutentificare($email)
    {
        $timp = time();
        self::executa("update utilizatori set timpauten = $timp where email = '$email';");
    }
    public static function setNumeSiGrupaUtilizator($email, $nume, $grupa)
    {
        self::executa("update utilizatori set nume=\"$nume\", codgrupa=(select cod from participanti where nume = \"$grupa\") where email = '$email';");
    }
    public static function getDateUtilizator($email)
    {
        return self::primulRand("select u.nume, u.md5parola, p.nume as grupa from utilizatori u, participanti p where u.codgrupa = p.cod and u.email = '$email';");
    }
    public static function existaUtilizatorul($email)
    {
        return self::numarDeRanduri("select * from utilizatori where email = '$email';") > 0;
    }
    public static function modificaParola($email, $parolaNoua)
    {
        $md5parola = md5($parolaNoua);
        self::executa("update utilizatori set md5parola = '$md5parola' where email = '$email';");
    }
    public static function insereazaRecuperare($codRecuperare, $email)
    {
        $timp = time();
        self::executa("insert into recuperare (codutil, codrec, timp) values ((select cod from utilizatori where email = '$email'), '$codRecuperare', $timp);");
    }
    public static function existaRecuperare($email)
    {
        return self::numarDeRanduri("select * from recuperare r, utilizatori u where r.codutil = u.cod and email = '$email';") > 0;
    }
    public static function stergeRecuperare($codRecuperare)
    {
        self::executa("delete from recuperare where codrec = '$codRecuperare';");
    }
    public static function stergeRecuperariExpirate()
    {
        $timp = time() - (24 * 60 * 60); // acum 24 de ore
        self::executa("delete from recuperare where timp < $timp;");
    }
    public static function getDateRecuperare($codRecuperare)
    {
        $rezultat = self::executa("select u.email, r.timp from utilizatori u, recuperare r where r.codutil = u.cod and r.codrec = '$codRecuperare';");
        if ($rezultat->num_rows === 0)
            return FALSE;
        return $rezultat->fetch_assoc();
    }
    public static function disciplinePentruProf($prof)
    {
        $rezultat = self::executa("select * from discipline where prof = '$prof' order by zi, start;");
        return self::intoarceTabel($rezultat);
    }
    public static function disciplinePentruMaterie($materie)
    {
        $rezultat = self::executa("select * from discipline where den = '$materie' order by zi, start;");
        return self::intoarceTabel($rezultat);
    }
    public static function disciplinePentruSala($sala)
    {
        $rezultat = self::executa("select * from discipline where sala = '$sala' order by zi, start;");
        return self::intoarceTabel($rezultat);
    }
    public static function materiileMele($grupa)
    {
        $an = substr($grupa, 0, 2);
        $semian = substr($grupa, 0, 3);

        $rezultat = self::executa("select distinct den from discipline where (parti like '%,$grupa,%') or (parti like '%,$semian,%');");
        $materii = array();
        while ($rand = $rezultat->fetch_assoc())
            $materii[] = $rand["den"];

        return $materii;
    }
    public static function profiiMei($grupa)
    {
        $an = substr($grupa, 0, 2);
        $semian = substr($grupa, 0, 3);

        $rezultat = self::executa("select distinct prof from discipline where (parti like '%,$grupa,%') or (parti like '%,$semian,%');");
        $profi = array();
        while ($rand = $rezultat->fetch_assoc())
            $profi[] = $rand["prof"];

        return $profi;
    }
    public static function disciplinePentruGrupa($grupa)
    {
        $an = substr($grupa, 0, 2);
        $semian = substr($grupa, 0, 3);

        $rezultat = self::executa("select * from discipline where (parti like '%,$grupa,%') or (parti like '%,$semian,%') order by zi, start;");
        return self::intoarceTabel($rezultat);
    }
    private static function intoarceTabel($rezultat)
    {
        $zile = array("luni", "marți", "miercuri", "joi", "vineri", "sâmbătă", "duminică");
        $discipline = array();
        for ($i = 0; $i < $rezultat->num_rows; $i++)
        {
            $assoc = $rezultat->fetch_assoc();
            $assoc["zi"] = $zile[$assoc["zi"]];
            if (strlen($assoc["start"]) < 2)
                $assoc["start"] = "0" . $assoc["start"];
            $assoc["parti"] = substr($assoc["parti"], 1, strlen($assoc["parti"]) - 2);
            $discipline[] = $assoc;
        }
        return $discipline;
    }
}
?>
