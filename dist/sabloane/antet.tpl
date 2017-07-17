<?xml version="1.0" encoding="utf-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
        <title>Timer - {$titlu}</title>
        <script src="/timr/cod/mootools-1.2.4-core-yc.js" type="text/javascript"></script>
        <script src="/timr/cod/main.js" type="text/javascript"></script>
        <link href="/timr/stil.css" rel="stylesheet" type="text/css"/>
        <link type="image/png" href="/timr/imagini/favicon.png" rel="shortcut icon"/>
    </head>
    <body>
        <div id="antet">
            <div id="centru_antet">
                <h1><a href="/timr/">Timer</a></h1>
                <p>orarul Facultății de Informatică</p>
                {include file="casuta_auten.tpl"}
                <div id="timp">
                    <p id="pTimp"></p>
                </div>
            </div>
        </div>

        <div id="corp">
            <div id="continut">
                <div id="meniu">
                    <ul>
                        {foreach from=$paginiDinMeniu item=pagina}
                            {if $pagina[1] == $numeFisier}<li class="activ">{else}<li>{/if}<a href="/timr/{$pagina[1]}">{$pagina[0]}</a></li>
                        {/foreach}
                    </ul>
                </div>
                <div id="textul">
