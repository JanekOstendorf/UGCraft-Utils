<?php

require_once '../libs/spyc.class.php';

/**
 * @author Janek Ostendorf (ozzy) <ozzy2345de@gmail.com>
 * @copyright Copyright (c) Janek Ostendorf
 * @license http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 * @uses Spyc
 */

class Levelled {
    
    /**
     * Storage file array
     * @var array 
     */
    private $storage;
    
    /**
     * Config file array
     * @var type 
     */
    private $config;
    
    /**
     * Load the files
     * @param string $config_path
     * @param string $storage_path
     * @uses Spyc::YAMLLoad() 
     */
    public function __construct($config_path, $storage_path) {
        
        $data = $this->config = array();
        
        $data = Spyc::YAMLLoad($storage_path);
        $this->config = Spyc::YAMLLoad($config_path);
        
        $data = $data['storage'];
        
        // Put the storage array in a more convinient form        
        $i = 0;
        
        foreach($data as $key => $line) {
            
            $tmp[$i]['name'] = $key;
            $tmp[$i]['points'] = $line['points'];
            $tmp[$i]['pblock'] = $line['pblock'];
            $tmp[$i]['bblock'] = $line['bblock'];
            $tmp[$i]['time'] = $line['time'];
            $tmp[$i]['group'] = $line['group'];
            
            $i++;
            
            
        }
        
        $this->storage = $tmp;
        
    }
    
    /**
     * Returns an array of the points Top 
     * @param int $count How many players should be returned?
     * @return array Array of players and other data
     */
    public function getTopPoints($count = 10) {
        
        $data = $this->storage;
        
        $sortArray = array(); 
        
        foreach($data as $key => $array) { 
            $sortArray[$key] = $array['points']; 
        } 

        array_multisort($sortArray, SORT_DESC, SORT_NUMERIC, $data);
        
        if(count($data) > $count) {
            
            $data = array_splice($data, 0, $count);
            
        }
        
        // Return
        return $data;
        
    }
    
    /**
     * Returns an array of the broken blocks Top 
     * @param int $count How many players should be returned?
     * @return array Array of players and other data
     */
    public function getTopBBlocks($count = 10) {
        
        $data = $this->storage;
        
        $sortArray = array(); 
        
        foreach($data as $key => $array) { 
            $sortArray[$key] = $array['bblock']; 
        } 

        array_multisort($sortArray, SORT_DESC, SORT_NUMERIC, $data);
        
        if(count($data) > $count) {
            
            $data = array_splice($data, 0, $count);
            
        }
        
        // Return
        return $data;
        
    }
    
    /**
     * Returns an array of the placed blocks Top 
     * @param int $count How many players should be returned?
     * @return array Array of players and other data
     */
    public function getTopPBlocks($count = 10) {
        
        $data = $this->storage;
        
        $sortArray = array(); 
        
        foreach($data as $key => $array) { 
            $sortArray[$key] = $array['pblock']; 
        } 

        array_multisort($sortArray, SORT_DESC, SORT_NUMERIC, $data);
        
        if(count($data) > $count) {
            
            $data = array_splice($data, 0, $count);
            
        }
        
        // Return
        return $data;
        
    }
    
    /**
     * Returns an array of the time Top 
     * @param int $count How many players should be returned?
     * @return array Array of players and other data
     */
    public function getTopTime($count = 10) {
        
        $data = $this->storage;
        
        $sortArray = array(); 
        
        foreach($data as $key => $array) { 
            $sortArray[$key] = $array['time']; 
        } 

        array_multisort($sortArray, SORT_DESC, SORT_NUMERIC, $data);
        
        if(count($data) > $count) {
            
            $data = array_splice($data, 0, $count);
            
        }
        
        // Return
        return $data;
        
    }
    
    /**
     * Transcodes the short levelname to the long one
     * @param string $short Permissions group
     * @return string Level name
     */
    public function getLevelName($short) {
        
        return isset($this->config['levels'][$short]['name']) ? $this->config['levels'][$short]['name'] : false;
        
    }
    
}

?>