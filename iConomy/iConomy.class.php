<?php

/**
 * @author Janek Ostendorf (ozzy) <ozzy2345de@gmail.com>
 * @copyright Copyright (c) Janek Ostendorf
 * @license http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 * @package UGCraft-Utils
 */
class iConomy {
    
    /**
     * Variable holding the account information
     * @var array
     */
    private $storage;
    
    /**
     * Read the info from the file and write it into our array
     * @param string $flatfile Path to 'accounts.mini' or similar
     * @param array $ignore Array of accounts to ignore
     * @return boolean 
     */
    public function __construct($flatfile, $ignore = array()) {
        
        $file = file($flatfile, FILE_SKIP_EMPTY_LINES & FILE_IGNORE_NEW_LINES);
        
        if($file === false)
            return false;
        
        
        $i = 0;
        foreach($file as $line) {
            
            $tmp_arr = explode(" ", $line);
            
            if(in_array($tmp_arr[0], $ignore))
                continue;
            
            $this->storage[$i]['name'] = $tmp_arr[0];
            $this->storage[$i]['balance'] = substr($tmp_arr[1], 8);
            $this->storage[$i]['status'] = substr($tmp_arr[2], 7);
             
            $i++;
            
        }
        
        return true;
        
    }
    
    /**
     * Get the top balances from the storage file
     * @param int $count Count of players to be shown
     * @return array 
     */
    public function getTop($count = 10) {
        
        // Sort the array
        $data = $this->storage;
        
        $sortArray = array(); 
        
        foreach($data as $key => $array) { 
            $sortArray[$key] = $array['balance']; 
        } 

        array_multisort($sortArray, SORT_DESC, SORT_NUMERIC, $data);
        
        if(count($data) > $count) {
            
            $data = array_splice($data, 0, $count);
            
        }
        
        return $data;
        
    }
    
}

?>
