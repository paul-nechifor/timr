{include file="antet.tpl" titlu="Autentificare"}
<h3>Autentificare</h3>
{if count($erori) > 0}
    <div class="erori">
        <p>Au fost găsite probleme la autentificare:</p>
        <ul>{foreach from=$erori item=eroare}<li>{$eroare}</li>{/foreach}</ul>
    </div>
{else}
    {if $smarty.server.REQUEST_METHOD == "GET"}
        <p>Scrie adresa de <em>email</em> și parola cu care te-ai înregistrat pentru a te autentifica. Dacă ți-ai uitat parola poți s-o <a href="/timr/recuperare.php">recuperezi</a>.</p>
        <form action="/timr/autentificare.php" method="post">
            <fieldset>
                <legend>Autentificare</legend>

                <ul>
                    <li>
                        <label for="email">Adresă <em>email</em></label>
                        <input id="email" name="email" type="text"/>
                    </li>
                    <li>
                        <label for="parola">Parolă</label>
                        <input id="parola" name="parola" type="password"/>
                    </li>
                </ul>

                {if $referer != ""}
                <input name="vineDeLa" type="hidden" value="{$referer}"/>
                {/if}
            </fieldset>

            <p><input type="submit" value="Trimite"/></p>
        </form>
    {/if}
{/if}
{include file="subsol.tpl"}
