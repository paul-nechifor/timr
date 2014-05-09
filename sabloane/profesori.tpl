{include file="antet.tpl" titlu="Profesori"}
{if isset($nume)}
<h3>Orar pentru {$nume}</h3>
{else}
<h3>Profesori</h3>
{/if}
{$afiseaza}

{if isset($discipline)}
    {include file="tabel_orar.tpl" discipline=$discipline cuGrupe="da"}
{/if}

{include file="subsol.tpl"}
