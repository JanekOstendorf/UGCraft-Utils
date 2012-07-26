<?php

if(defined('ABSPATH'))
    require_once(ABSPATH.'custom-php/MinecraftQuery/MineStatus.class.php');
else
    require_once('custom-php/MinecraftQuery/MineStatus.class.php');

/**
 * @author Janek Ostendorf (ozzy) <ozzy2345de@gmail.com>
 * @copyright Copyright (c) Janek Ostendorf
 * @license http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 * @package UGCraft-Utils
 */

function getVersion($ip, $port) {

    $cache_dir = (defined('ABSPATH') ? ABSPATH : './') . 'custom-php/cache/';

    $status = new MineStatus($ip, $port, 1);

    $server_version = $status->getVersion();

    if($server_version == null) {

        // Try to read from cache
        $server_version = file_get_contents($cache_dir.$ip.'-'.$port.'.txt');

    }
    else {

        // Write version into cache and return
        file_put_contents($cache_dir.$ip.'-'.$port.'.txt', $server_version);

    }

    return $server_version;

}

?>