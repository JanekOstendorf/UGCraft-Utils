<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

if(defined('ABSPATH')) 
    require_once ABSPATH.'custom-php/Levelled/Levelled.class.php';
else
    require_once '../Levelled/Levelled.class.php';



/**
 * @author Janek Ostendorf (ozzy) <ozzy2345de@gmail.com>
 * @copyright Copyright (c) Janek Ostendorf
 * @license http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 * @package UGCraft-Utils
 * @uses Levelled
 * @uses playerInfo
 */

class userBanner {
    
    /**
     * @var Levelled
     */
    private $levelled;
    
    /**
     * Image handler
     * @var resource 
     */
    private $image;
    
    /**
     * Avatar image
     * @var resource
     */
    private $avatar;
    
    /**
     * Player name
     * @var string
     */
    private $playerName;
    
    /**
     * Player info
     * @var playerInfo
     */
    private $userInfo;
    
    public function __construct($player, Levelled $levelled) {
        
        $this->playerName = $player;
        $this->levelled = $levelled;
        
        // Create the pic
        $this->image = @imagecreatefrompng('./wrapper.png');
        
        // Get the avatar
        $this->avatar = @imagecreatefrompng('http://minotar.net/helm/'.$player.'/48.png');
        
        if(!$this->image) {
            
            die('Hintergrund konnte nicht geladen werden!');
            
        }
        
        if(!$this->avatar) {
            
            $this->avatar = @imagecreatefrompng('./default-avatar.png');
            
            if(!$this->avatar)
                die('Standard-Avatar konnte nicht geladen werden!');
            
        }
        
        // Get info
        $this->userInfo = $levelled->getPlayerInfo($player);
        
        if($this->userInfo === false) {
            
            // User not in the Levelled DB
            $this->userInfo = new playerInfo();
            $this->userInfo->points = 0;
            $this->userInfo->pblock = 0;
            $this->userInfo->bblock = 0;
            $this->userInfo->time = 0;
            $this->userInfo->group = null;
            
        }
        
        $this->addPlayer();
        $this->addAvatar();
        $this->addInfo();
        
        // Send header
        header('Content-type: image/png');
        
        imagepng($this->image);
        imagedestroy($this->avatar);
        imagedestroy($this->image);
        
    }
    
    private function addPlayer() {
        
        $white = imagecolorallocate($this->image, 255, 255, 255);
        
        imagettftext($this->image, 14, 0, 66, 28, $white, './minecraft.ttf', $this->playerName);
        
    }
    
    private function addAvatar() {
        
        imagecopy($this->image, $this->avatar, 7, 6, 0, 0, 48, 48);
        
    }
    
    private function addInfo() {
        
        $white = imagecolorallocate($this->image, 255, 255, 255);
        
        imagettftext($this->image, 9, 0, 380, 28, $white, './Ubuntu-R.ttf', floor($this->userInfo->time / 3600) . ":" . str_pad(floor(($this->userInfo->time % 3600) / 60), 2, '0') . " h");
        imagettftext($this->image, 9, 0, 380, 42, $white, './Ubuntu-R.ttf', is_null($this->userInfo->group) ? '[kein Level]' : $this->levelled->getLevelName($this->userInfo->group));
        
    }
    
}

$dir = '/home/minecraft/ugcraft/plugins/';

new userBanner($_GET['player'], new Levelled($dir.'Levelled/config.yml', $dir.'Levelled/storage.yml'));

?>