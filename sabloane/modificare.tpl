{include file="antet.tpl" titlu="Modificare profil"}
<h3>Modificare profil</h3>
{if $smarty.server.REQUEST_METHOD == "GET"}
    <form action="/modificare.php" method="post">
        <fieldset>
            <legend>Informații personale</legend>

            <ul>
                <li>
                    <label for="nume">Nume</label>
                    <input id="nume" name="nume" type="text" value="{$numeVechi}"/>
                    <span id="eroareNume"></span>
                </li>
                <li>
                    <label for="grupa">Grupă</label>
                    <select id="grupa" name="grupa">{html_options values=$participanti output=$participantiNume selected=$grupaVeche}</select>
                </li>
            </ul>
        </fieldset>

        <fieldset>
            <legend>Parolă</legend>

            <ul>
                <li>
                    <label for="parolaVeche">Parolă veche</label>
                    <input id="parolaVeche" name="parolaVeche" type="password"/>
                </li>
                <li>
                    <label for="parolaNoua1">Parolă nouă</label>
                    <input id="parolaNoua1" name="parolaNoua1" type="password"/>
                    <span id="eroareParolaNoua"></span>
                </li>
                <li>
                    <label for="parolaNoua2">Verificare parolă nouă</label>
                    <input id="parolaNoua2" name="parolaNoua2" type="password"/>
                </li>
            </ul>
        </fieldset>
        
        <p><input type="submit" value="Salvează" id="trimiteModificare"/></p>
    </form>

{else}
    {if count($erori) == 0}
        <p>Informațiile au fost actualizate.</p>
    {else}
        <div class="erori">
            <p>Au fost găsite probleme la modificarea profilului:</p>
            <ul>{foreach from=$erori item=eroare}<li>{$eroare}</li>{/foreach}</ul>
        </div>
    {/if}
{/if}
{include file="subsol.tpl"}
