{include file="antet.tpl" titlu="Orar"}

{if isset($grupa)}
    <h3>Orar pentru {$grupa}</h3>
{else}
    <h3>Orar</h3>
{/if}

{if isset($discipline)}
    {include file="tabel_orar.tpl" discipline=$discipline}
{/if}

{$afiseaza}

{include file="subsol.tpl"}
