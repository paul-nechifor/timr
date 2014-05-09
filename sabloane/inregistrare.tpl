{include file="antet.tpl" titlu="Înregistrare"}
<h3>Înregistrare</h3>

{if count($erori) > 0}
    <div class="erori">
        <p>Au fost găsite probleme la înregistrare:</p>
        <ul>{foreach from=$erori item=eroare}<li>{$eroare}</li>{/foreach}</ul>
    </div>
{else}
    {if $smarty.server.REQUEST_METHOD == "GET"}
        <p>Completează aici datele pentru te înregistra pe sait. După ce te-ai înregistrat poți să te autentifici folosind adresa de <em>email</em> și parola.</p>
        <p>Dacă mai târziu îți uiți parola poți să alegi să-ți fie trimisă una nouă pe <em>email</em>, deci verifică dacă e corectă adresa.</p>

        <form action="/inregistrare.php" method="post">
            <fieldset>
                <legend>Informații personale</legend>

                <ul>
                    <li>
                        <label for="nume">Nume</label>
                        <input id="nume" name="nume" type="text"/>
                        <span id="eroareNume"></span>
                    </li>
                    <li>
                        <label for="email">Adresă <em>email</em></label>
                        <input id="email" name="email" type="text"/>
                        <span id="eroareEmail"></span>
                    </li>
                    <li>
                        <label for="grupa">Grupă</label>
                        <select id="grupa" name="grupa">{html_options values=$participanti output=$participantiNume}</select>
                    </li>
                </ul>
            </fieldset>

            <fieldset>
                <legend>Parolă</legend>

                <ul>
                    <li>
                        <label for="parola1">Parolă</label>
                        <input id="parola1" name="parola1" type="password"/>
                        <span id="eroareParola"></span>
                    </li>
                    <li>
                        <label for="parola2">Verificare parolă</label>
                        <input id="parola2" name="parola2" type="password"/>
                        <span id="eroreEmail"></span>
                    </li>
                </ul>
            </fieldset>
            
            <p><input type="submit" value="Trimite" id="trimiteInregistrare"/></p>
        </form>
    {else}
        <p>Ai fost înregistrat. Acum poți să te <a href="/autentificare.php">autentifici</a>.</p>
    {/if}
{/if}
{include file="subsol.tpl"}
