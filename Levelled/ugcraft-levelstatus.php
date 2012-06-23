<?php

/**
 * @author Janek Ostendorf (ozzy) <ozzy2345de@gmail.com>
 * @copyright Copyright (c) Janek Ostendorf
 * @license http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */

require_once './Levelled.class.php';

$dir = '/home/minecraft/ugcraft/plugins/Levelled/';

$status = @new Levelled($dir.'config.yml', $dir.'storage.yml');



?>
<div style="width: 49%; float: left;">
    <h3>Punkte - Top 10</h3>
    <!-- Points -->
    <table style="width: 100%;">
        <thead>
            <tr>
                <th>
                    #
                </th>
                <th>
                    Spieler
                </th>
                <th>
                    Aktivitätspunkte
                </th>
                <th>
                    Level
                </th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 0;
            foreach(@$status->getTopPoints() as $line) {
                $i++;
            ?>
            
            <tr>
                <td>
                    <?=$i?>.
                </td>
                <td>
                    <img src="http://minotar.net/helm/<?=$line['name']?>/24.png" style="vertical-align: middle; margin-right: 10px;" /> <?=$line['name']?>
                </td>
                <td>
                    <?=round($line['points'])?>
                </td>
                <td>
                    <?=$line['group'] == null ? '&mdash;' : @$status->getLevelName($line['group'])?>
                </td>
            </tr>
            
            <?php
            }
            ?>
        </tbody>
    </table>
</div>
<div style="width: 49%; float: right;">
    <h3>Zeit - Top 10</h3>
    <!-- Time -->
    <table style="width: 100%;">
        <thead>
            <tr>
                <th>
                    #
                </th>
                <th>
                    Spieler
                </th>
                <th>
                    Stunden gespielt
                </th>
                <th>
                    Level
                </th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 0;
            foreach(@$status->getTopTime() as $line) {
                $i++;
                
                
            ?>
            
            <tr>
                <td>
                    <?=$i?>.
                </td>
                <td>
                    <img src="http://minotar.net/helm/<?=$line['name']?>/24.png" style="vertical-align: middle; margin-right: 10px;" /> <?=$line['name']?>
                </td>
                <td>
                    <?=floor($line['time'] / 3600) . ":" . str_pad(floor(($line['time'] % 3600) / 60), 2, '0') . " h"?>
                </td>
                <td>
                    <?=$line['group'] == null ? '&mdash;' : @$status->getLevelName($line['group'])?>
                </td>
            </tr>
            
            <?php
            }
            ?>
        </tbody>
    </table>
</div>
<br style="clear: both;" />
<div style="width: 49%; float: left;">
    <h3>Gesetzte Blöcke - Top 10</h3>
    <!-- Placed Blocks -->
    <table style="width: 100%;">
        <thead>
            <tr>
                <th>
                    #
                </th>
                <th>
                    Spieler
                </th>
                <th>
                    Gesetzte Blöcke
                </th>
                <th>
                    Level
                </th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 0;
            foreach(@$status->getTopPBlocks() as $line) {
                $i++;
            ?>
            
            <tr>
                <td>
                    <?=$i?>.
                </td>
                <td>
                    <img src="http://minotar.net/helm/<?=$line['name']?>/24.png" style="vertical-align: middle; margin-right: 10px;" /> <?=$line['name']?>
                </td>
                <td>
                    <?=round($line['pblock'])?>
                </td>
                <td>
                    <?=$line['group'] == null ? '&mdash;' : @$status->getLevelName($line['group'])?>
                </td>
            </tr>
            
            <?php
            }
            ?>
        </tbody>
    </table>
</div>
<div style="width: 49%; float: right;">
    <h3>Abgebaute Blöcke - Top 10</h3>
    <!-- Broken blocks -->
    <table style="width: 100%;">
        <thead>
            <tr>
                <th>
                    #
                </th>
                <th>
                    Spieler
                </th>
                <th>
                    Abgebaute Blöcke
                </th>
                <th>
                    Level
                </th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 0;
            foreach(@$status->getTopBBlocks() as $line) {
                $i++;
            ?>
            
            <tr>
                <td>
                    <?=$i?>.
                </td>
                <td>
                    <img src="http://minotar.net/helm/<?=$line['name']?>/24.png" style="vertical-align: middle; margin-right: 10px;" /> <?=$line['name']?>
                </td>
                <td>
                    <?=round($line['bblock'])?>
                </td>
                <td>
                    <?=$line['group'] == null ? '&mdash;' : @$status->getLevelName($line['group'])?>
                </td>
            </tr>
            
            <?php
            }
            ?>
        </tbody>
    </table>
</div>
<br style="clear: both;" />