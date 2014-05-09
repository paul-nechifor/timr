<table class="orar">
<thead>
    <tr>
        <td>Zi</td>
        <td>Ore</td>
        <td>Disciplină</td>
        <td>Profesor</td>
        <td>Sală</td>
        {if isset($cuGrupe)}
            <td>Grupe</td>
        {/if}
        <td>Frecvenţă</td>
    </tr>
</thead>
<tbody>
    {foreach from=$discipline item=disciplina}
        <tr>
            <td>{$disciplina.zi}</td>
            <td>{$disciplina.start}&ndash;{$disciplina.final}</td>
            <td>
                <a href="materii.php?disciplina={$disciplina.den}">{$disciplina.den}</a>
                ({$disciplina.tip})
            </td>
            <td>
                {$disciplina.titprof}
                <a href="profesori.php?prof={$disciplina.prof}">{$disciplina.prof}</a>
            </td>
            <td><a href="sali.php?sala={$disciplina.sala}">{$disciplina.sala}</a></td>
            {if isset($cuGrupe)}
                <td>{$disciplina.parti}</td>
            {/if}
            <td>{$disciplina.frec}</td>
        </tr>
    {/foreach}
</tbody>
</table>
