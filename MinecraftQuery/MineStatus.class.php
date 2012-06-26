<?php

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

class MinecraftQueryException extends Exception
{
	// Exception thrown by MinecraftQuery class
}

class MinecraftQuery
{
	/*
	 * Class written by xPaw
	 *
	 * Website: http://xpaw.ru
	 * GitHub: https://github.com/xPaw/PHP-Minecraft-Query
	 */
	
	const STATISTIC = 0x00;
	const HANDSHAKE = 0x09;
	
	private $Socket;
	private $Players;
	private $Info;
	
	public function Connect( $Ip, $Port = 25565, $Timeout = 3 )
	{
		if( !is_int( $Timeout ) || $Timeout < 0 )
		{
			throw new InvalidArgumentException( 'Timeout must be an integer.' );
		}
		
		$this->Socket = FSockOpen( 'udp://' . $Ip, (int)$Port, $ErrNo, $ErrStr, $Timeout );
		
		if( $ErrNo || $this->Socket === false )
		{
			throw new MinecraftQueryException( 'Could not create socket: ' . $ErrStr );
		}
		
		Stream_Set_Timeout( $this->Socket, $Timeout );
		Stream_Set_Blocking( $this->Socket, true );
		
		try
		{
			$Challenge = $this->GetChallenge( );
			
			$this->GetStatus( $Challenge );
		}
		// We catch this because we want to close the socket, not very elegant
		catch( MinecraftQueryException $e )
		{
			FClose( $this->Socket );
			
			throw new MinecraftQueryException( $e->getMessage( ) );
		}
		
		FClose( $this->Socket );
	}
	
	public function GetInfo( )
	{
		return isset( $this->Info ) ? $this->Info : false;
	}
	
	public function GetPlayers( )
	{
		return isset( $this->Players ) ? $this->Players : false;
	}
	
	private function GetChallenge( )
	{
		$Data = $this->WriteData( self :: HANDSHAKE );
		
		if( $Data === false )
		{
			throw new MinecraftQueryException( "Failed to receive challenge." );
		}
		
		return Pack( 'N', $Data );
	}
	
	private function GetStatus( $Challenge )
	{
		$Data = $this->WriteData( self :: STATISTIC, $Challenge . Pack( 'c*', 0x00, 0x00, 0x00, 0x00 ) );
		
		if( !$Data )
		{
			throw new MinecraftQueryException( "Failed to receive status." );
		}
		
		$Last = "";
		$Info = Array( );
		
		$Data    = SubStr( $Data, 11 ); // splitnum + 2 int
		$Data    = Explode( "\x00\x00\x01player_\x00\x00", $Data );
		$Players = SubStr( $Data[ 1 ], 0, -2 );
		$Data    = Explode( "\x00", $Data[ 0 ] );
		
		// Array with known keys in order to validate the result
		// It can happen that server sends custom strings containing bad things (who can know!)
		$Keys = Array(
			'hostname'   => 'HostName',
			'gametype'   => 'GameType',
			'version'    => 'Version',
			'plugins'    => 'Plugins',
			'map'        => 'Map',
			'numplayers' => 'Players',
			'maxplayers' => 'MaxPlayers',
			'hostport'   => 'HostPort',
			'hostip'     => 'HostIp'
		);
		
		foreach( $Data as $Key => $Value )
		{
			if( ~$Key & 1 )
			{
				if( !Array_Key_Exists( $Value, $Keys ) )
				{
					$Last = false;
					continue;
				}
				
				$Last = $Keys[ $Value ];
				$Info[ $Last ] = "";
			}
			else if( $Last != false )
			{
				$Info[ $Last ] = $Value;
			}
		}
		
		// Ints
		$Info[ 'Players' ]    = IntVal( $Info[ 'Players' ] );
		$Info[ 'MaxPlayers' ] = IntVal( $Info[ 'MaxPlayers' ] );
		$Info[ 'HostPort' ]   = IntVal( $Info[ 'HostPort' ] );
		
		// Parse "plugins", if any
		if( $Info[ 'Plugins' ] )
		{
			$Data = Explode( ": ", $Info[ 'Plugins' ], 2 );
			
			$Info[ 'RawPlugins' ] = $Info[ 'Plugins' ];
			$Info[ 'Software' ]   = $Data[ 0 ];
			
			if( Count( $Data ) == 2 )
			{
				$Info[ 'Plugins' ] = Explode( "; ", $Data[ 1 ] );
			}
		}
		else
		{
			$Info[ 'Software' ] = 'Vanilla';
		}
		
		$this->Info = $Info;
		
		if( $Players )
		{
			$this->Players = Explode( "\x00", $Players );
		}
	}
	
	private function WriteData( $Command, $Append = "" )
	{
		$Command = Pack( 'c*', 0xFE, 0xFD, $Command, 0x01, 0x02, 0x03, 0x04 ) . $Append;
		$Length  = StrLen( $Command );
		
		if( $Length !== FWrite( $this->Socket, $Command, $Length ) )
		{
			throw new MinecraftQueryException( "Failed to write on socket." );
		}
		
		$Data = FRead( $this->Socket, 1440 );
		
		if( $Data === false )
		{
			throw new MinecraftQueryException( "Failed to read from socket." );
		}
		
		if( StrLen( $Data ) < 5 || $Data[ 0 ] != $Command[ 2 ] )
		{
			return false;
		}
		
		return SubStr( $Data, 5 );
	}
}

?>