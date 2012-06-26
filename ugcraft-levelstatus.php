<?php

/**
 * @author Janek Ostendorf (ozzy) <ozzy2345de@gmail.com>
 * @copyright Copyright (c) Janek Ostendorf
 * @license http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3 
 * @package UGCraft-Utils
 */

require_once ABSPATH.'custom-php/Levelled/Levelled.class.php';
require_once ABSPATH.'custom-php/iConomy/iConomy.class.php';

$dir = '/home/minecraft/ugcraft/plugins/';

$levelled = @new Levelled($dir.'Levelled/config.yml', $dir.'Levelled/storage.yml');

$iconomy = @new iConomy($dir.'iConomy/accounts.mini', array('admin', 'ugcity'));

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
            foreach(@$levelled->getTopPoints() as $line) {
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
                    <?=$line['group'] == null ? '&mdash;' : @$levelled->getLevelName($line['group'])?>
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
            foreach(@$levelled->getTopTime() as $line) {
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
                    <?=$line['group'] == null ? '&mdash;' : @$levelled->getLevelName($line['group'])?>
                </td>
            </tr>
            
            <?php
            }
            ?>
        </tbody>
    </table>
</div>
<br style="clear: both;" />
<?php /*<div style="width: 49%; float: left;">
    <h3>Gesetzte Blöcke - Top 10</h3>
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
            foreach(@$levelled->getTopPBlocks() as $line) {
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
                    <?=$line['group'] == null ? '&mdash;' : @$levelled->getLevelName($line['group'])?>
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
            foreach(@$levelled->getTopBBlocks() as $line) {
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
                    <?=$line['group'] == null ? '&mdash;' : @$levelled->getLevelName($line['group'])?>
                </td>
            </tr>
            
            <?php
            }
            ?>
        </tbody>
    </table>
</div>
<br style="clear: both;" /> */?>
<div style="margin: 0 auto; width: 50%">
    <h3>Geld - Top 10</h3>
    <table style="width: 100%">
        <thead>
            <tr>
            <th>#</th>
            <th>Spieler</th>
            <th>Guthaben</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 0;
            foreach(@$iconomy->getTop() as $line) {
                $i++;
                number_
            ?>
            <tr>
                <td><?=$i?>.</td>
                <td><img src="http://minotar.net/helm/<?=$line['name']?>/24.png" style="vertical-align: middle; margin-right: 10px;" /> <?=$line['name']?></td>
                <td><?=@number_format($line['balance'], 2, ',', ' ')?> U</td>
            </tr>
            <?php
            }
            ?>

        </tbody>
    </table>
</div>