{include file="antet.tpl" titlu="Săli"}
{if isset($sala)}
<h3>Orar pentru {$sala}</h3>
{else}
<h3>Săli</h3>
{/if}
{$afiseaza}

{if isset($discipline)}
    {include file="tabel_orar.tpl" discipline=$discipline cuGrupe="da"}
{/if}

{include file="subsol.tpl"}
