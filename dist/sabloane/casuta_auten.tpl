<div id="casuta_auten">
    {if isset($smarty.session.email)}
        <ul>
            <li><span>Salut, {$smarty.session.nume}</span></li>
            <li><a href="/timr/modificare.php">Profil</a></li>
            <li><a href="/timr/iesire.php">Ieșire</a></li>
        </ul>
    {else}
        <form action="/autentificare.php" method="post">
            <fieldset>
                <ul>
                    <li><input id="email_casuta" name="email" type="text" value="adresă email"/></li>
                    <li><input id="parola_casuta" name="parola" type="password" value="parola ta"/></li>
                    <li><input type="submit" value="Intră"/></li>
                    <li><a href="/timr/inregistrare.php">Înregistrare</a></li>
                </ul>
                <input type="hidden" name="vineDeLa" value="{$smarty.server.PHP_SELF}"/>
            </fieldset>
        </form>
    {/if}
</div>
