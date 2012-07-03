<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

if(defined('ABSPATH')) 
    require_once ABSPATH.'custom-php/Honeypot/Honeypot.class.php';
else
    require_once './Honeypot/Honeypot.class.php';

/**
 * @author Janek Ostendorf (ozzy) <ozzy2345de@gmail.com>
 * @copyright Copyright (c) Janek Ostendorf
 * @license http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 * @package UGCraft-Utils
 */

$hp_config = new HPConfig();
$hp_config->logfile = '/home/minecraft/ugcraft/plugins/Honeypot/honeypot.log';
$hp_config->page_name = 'UGCraft - Honeypot logs';

$hp = new Honeypot($hp_config);

$hp->printTable();

?>
