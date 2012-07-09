<?php

/**
 * Clsss executed by a cron job. Used to restart the server automatically - if needed
 * @author Janek Ostendorf aka. ozzy2345 <ozzy2345de@gmail.com>
 * @license GNU General Public License Version 3
 * @copyright Copyright (c) Janek Ostendorf
 */
class AutoRestart {
    
    /**
     * Path to the logfile
     * @var string
     */
    private $logfile;
    
    /**
     * Log handler 
     * @var resource
     */
    private $log;
    
    /**
     * Startscript to start the server again (with arguments!)
     * @var string
     */
    private $startscript_start;
    
    /**
     * Startscript to stop the server again (with arguments!)
     * @var string
     */
    private $startscript_stop;
    
    /**
     * Server host
     * @var string
     */
    private $server;
    
    /**
     * Port the server runs on
     * @var int
     */
    private $port;
    
    /**
     * Timeout for connection
     * @var int
     */
    private $timeout;
    
    
    /**
     * Does all the stuff
     * @param string $server Minecraft server host
     * @param int $port Port of the MC server
     * @param string $startscript_start Startscript with arguments for starting the server
     * @param string $startscript_stop Startscript with arguments for stopping the server
     * @param string $logfile Logfile for restart logginf
     * @param type $timeout Timeout - boundary value for restarting
     */
    public function __construct($server, int $port, $startscript_start, $startscript_stop, $logfile, $timeout) {
        
        
        $this->server = $server;
        $this->port = $port;
        $this->startscript_start = $startscript_start;
        $this->startscript_stop = $startscript_stop;
        $this->logfile = $logfile;
        $this->timeout = $timeout;
        
        // Logfile
        $this->log = fopen($this->logfile, 'a');
        
        // Check the server
        if(!$this->isOnline()) {
            
            $this->log('Server not reacting after '.$timeout.' seconds. Attempting to restart ...');
            
            $this->stop();
            sleep(10);
            $this->start();
            
            sleep(30);
            
            if($this->isOnline()) {
                
                $this->log('Server successfully restarted.');
                
            }
            else {
                
                $this->log('ERROR: Failed to restart the server!');
                
            }
            
        }
        
        // Logfile
        fclose($this->log);
                
    }
    
    /**
     * Checks if the server is up and running - or not
     * @return boolean Is the server up?
     */
    private function isOnline() {
        
        $s = fsockopen($this->server, $this->port, $errno, $errstr, 30);
        
        return $s === false;
        
    }
    
    /**
     * Logs $string into the logfile
     * @param string $string Log message
     */
    private function log($string) {
        
        fwrite($this->log, '['.date('d.m.Y H:i:sO').'] '.$string);
        
    }
    
    /**
     * Stops the server using the start script 
     */
    private function stop() {
        
        exec($this->startscript_stop);
        
    }
    
    /**
     * Starts the server using the start script 
     */
    private function start() {
        
        exec($this->startscript_start);
        
    }
    
}

?>
