{include file="antet.tpl" titlu="Recuperare parolă"}
<h3>Recuperare parolă</h3>
{if count($erori) > 0}
    <div class="erori">
        <p>Au fost găsite probleme la recuperare:</p>
        <ul>{foreach from=$erori item=eroare}<li>{$eroare}</li>{/foreach}</ul>
    </div>
{else}
    {if $smarty.server.REQUEST_METHOD == "GET"}
        {if $stare == "trimisParola"}
            <p>Ți-a fost trimisă parola nouă pe „{$email}“.</p>
        {else}
            <p>Dacă ți-ai uitat parola poți să scrii aici adresa ta de <em>email</em> și îți va fi trimis codul pentru generarea automată a unei noi parole.</p>

            <form action="/recuperare.php" method="post">
                <fieldset>
                    <legend>Adresa de <em>email</em></legend>

                    <ul>
                        <li>
                            <label for="email">Adresă <em>email</em></label>
                            <input id="email" name="email" type="text"/>
                        </li>
                    </ul>

                    {if $referer != ""}
                    <input name="vineDeLa" type="hidden" value="{$referer}"/>
                    {/if}
                </fieldset>
                
                <p><input type="submit" value="Trimite"/></p>
            </form>
        {/if}
    {else}
        <p>Ți-a fost trimis codul generarea unei noi parole pe „{$email}“. Ai la dispoziție 24 de ore ca să folosești codul.</p>
    {/if}
{/if}
{include file="subsol.tpl"}
