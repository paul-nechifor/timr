window.addEvent("domready", main);

// Variabile globale.
var pTimp;

function main()
{
    // Inițializez variabilele globale.
    pTimp = $("pTimp");

    pornesteCeas();
    adaugaEfectFocalizare();
    adaugaVerificareInregistrare();
    adaugaVerificareModificare();

    // Dacă există, la apasare golește.
    email_casuta = $("email_casuta");
    parola_casuta = $("parola_casuta");
    if (email_casuta != null)
        email_casuta.addEvent("click", function(){email_casuta.value = "";});
    if (parola_casuta != null)
        parola_casuta.addEvent("click", function(){parola_casuta.value = "";});

    
}
function adaugaVerificareModificare()
{
    if ($("trimiteModificare") == null)
        return;

    $("trimiteModificare").addEvent("click", function(e)
    {
        var eroare = false;

        $("eroareNume").innerHTML = "";
        $("eroareParolaNoua").innerHTML = "";

        if ($("nume").value.length == 0){$("eroareNume").innerHTML = "Numele este prea mic."; eroare = true;}
        if ($("nume").value.length > 40){$("eroareNume").innerHTML = "Numele este prea mare."; eroare = true;}
        //if ($("parolaNoua1").value.length < 6){$("eroareParolaNoua").innerHTML = "Parola are mai puțin de 6 caractere."; eroare = true;}
        if ($("parolaNoua1").value != $("parolaNoua2").value){$("eroareParolaNoua").innerHTML = "Parolele nu se potrivesc."; eroare = true;}

        if (eroare) e.stop();
    });
}
function adaugaVerificareInregistrare()
{
    if ($("trimiteInregistrare") == null)
        return;

    $("trimiteInregistrare").addEvent("click", function(e)
    {
        var eroare = false;
        
        $("eroareNume").innerHTML = "";
        $("eroareEmail").innerHTML = "";
        $("eroareParola").innerHTML = "";

        if ($("nume").value.length == 0){$("eroareNume").innerHTML = "Numele este prea mic."; eroare = true;}
        if ($("nume").value.length > 40){$("eroareNume").innerHTML = "Numele este prea mare."; eroare = true;}
        if ($("parola1").value.length < 6){$("eroareParola").innerHTML = "Parola este prea scurtă. Trebuie cel puțin 6 caractere."; eroare = true;}
        if ($("parola1").value != $("parola2").value){$("eroareParola").innerHTML = "Parolele nu se potrivesc."; eroare = true;}
        if ($("email").value.search(/^[^@]+@[^@]+.[a-z]{2,}$/i) == -1){$("eroareEmail").innerHTML = "Adresă invalidă."; eroare = true;}

        if (eroare) e.stop();
    });
}
function adaugaEfectFocalizare()
{
    $each($$("input"), function(elem)
    {
        if (elem.type != "text" && elem.type != "password")
            return;

        elem.addEvent("focus", function()
        {
            var morf = new Fx.Morph(elem);
            morf.start({"background-color":"#ffffff", "border":"1px solid #3b7b9b"});
        });
        elem.addEvent("blur", function()
        {
            var morf = new Fx.Morph(elem);
            morf.start({"background-color":"#e0e9f9", "border":"1px solid #8baddb"});
        });
    });
}
function pornesteCeas()
{
    var z = function(n) {return (n < 10) ? ("0" + n) : n};
    var zile = ["luni", "marți", "miercuri", "joi", "vineri", "sâmbătă", "duminică"];
    var luni = ["ianuarie", "februarie", "martie", "aprilie", "mai", "iunie", "iulie", "august", "septembrie", "octombrie", "noiembrie", "decembrie"];
    var acum = new Date();
    var timp = z(acum.getHours()) + ":" + z(acum.getMinutes()) + ":" + z(acum.getSeconds());
    var data = zile[acum.getDay()] + " " + acum.getDate() + " " + luni[acum.getMonth()] + " " + acum.getFullYear();

    pTimp.innerHTML = timp + ", " + data; 

    setTimeout("pornesteCeas()", 1000);
}
