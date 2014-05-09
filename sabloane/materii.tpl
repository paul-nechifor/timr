{include file="antet.tpl" titlu="Materii"}
{if isset($disciplina)}
    <h3>{$disciplina}</h3>
{else}
    <h3>Materii</h3>
{/if}

{$afiseaza}

{if isset($discipline)}
    {include file="tabel_orar.tpl" discipline=$discipline cuGrupe="da"}
{/if}

{include file="subsol.tpl"}
