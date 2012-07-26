<?php

if(defined('ABSPATH'))
    require_once ABSPATH.'custom-php/MinecraftQuery/MinecraftQuery.class.php';
else
    require_once dirname(__FILE__).'/MinecraftQuery.class.php';

/**
 * Class for proper formating of Minequery data
 * @author Janek Ostendorf aka. ozzy2345 <ozzy2345de@gmail.com>
 * @license GNU General Public License Version 3
 * @copyright Copyright (c) Janek Ostendorf
 */
class MineStatus {

    /**
     * MinecraftQuery Handler
     * @var MinecraftQuery
     */
    private $handler;

    /**
     * Status of the server
     * @var array
     */
    private $status;
    
    /**
     * Output buffer
     * @var string
     */
    private $output;
    
    /**
     * Playerlist output
     * @var array
     */
    private $playerList;
    
    /**
     * Messages
     * @var array
     */
    private $messages = array(
        
        // General error message
        'error'     => '<em>Fehler.</em>',
        
        // Output format for player numbers
        // %players     --> Number of players currently online
        // %maxPlayers  --> Maximal number of players
        'output'    => 'Es sind <strong>%players / %maxPlayers</strong> Spielern online.'
    
    );

     
    /**
     * Fetch data from server
     * @param $host     Host of the Minecraft server
     * @param $port     Port the Minecraft server is running on. Default: 25565
     * @param $timeout  Timeout in seconds. Default: 30
     */
    public function __construct($host, $port = 25565, $timeout = 30) {
        
        // Fetch status
        try {
        
            $this->handler = new MinecraftQuery();
            $this->handler->Connect($host, $port, $timeout);
            $this->playerList = $this->handler->GetPlayers();
            $this->status = $this->handler->GetInfo();
            
        }
        catch(MinecraftQueryException $e) {
        
            $this->output = $this->messages['error'];
            return;
        
        }
        
        // Prepare output
        $this->output = str_replace('%maxPlayers', $this->status['MaxPlayers'], str_replace('%players', $this->status['Players'], $this->messages['output']));
        
    }
    
    /**
     * Prints the number of players
     * Format: see UGCraftStatus::messages['output']
     * @return void
     */
    public function outputPlayers() {
        
        echo $this->output;
        
    }
    
    /**
     * Prints the player list
     * @param $with_images Shall we print the player's faces? Names will be available as tooltip. If `false`: One player each line.
     * @return void
     */
    public function outputPlayerList($with_images = true) {
        
        if($this->status === false) {
            
            echo $this->messages['error'];
            return;
            
        }
        
        // Buffer for output
        $output = '';
        
        foreach($this->playerList as $player) {
        
            if(empty($player))
                continue;
            
            if($with_images) {
                
                $output .= '<img src="http://minotar.net/helm/'.$player.'/48.png" title="'.$player.'" style="display: inline; padding: 2px 4px;" />';
                
            }
            else {
                
                $output .= '$player<br />';
                
            }
            
            
        }
        
        echo $output;
        
    }
    
    /**
     * Are users online?
     * @return boolean Are users online?
     */
    public function hasUsers() {
        
        if($this->status['Players'] > 0)
            return true;
        else
            return false;
        
    }
    
    /**
     * Gets the Minecraft server version
     * @return string Server version
     */
    public function getVersion() {
        
        return $this->status['Version'];
        
    }

}
?>