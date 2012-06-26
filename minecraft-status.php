<?php

$server = 'localhost';
$port = 25566;
$playerlist = 0;

// Fetch server address
if(isset($_GET['server'])) {
    
    $server = $_GET['server'];
    
}
else {
    
    if(isset($_POST['server'])) {
        
        $server = $_POST['server'];
        
    }
    
}

// Fetch port (default: 25566)
if(isset($_GET['port'])) {
    
    $port = $_GET['port'];
    
}
else {
    
    if(isset($_POST['port'])) {
        
        $port = $_POST['port'];
        
    }
    
}

// Fetch if they want the playerlist
if(isset($_GET['playerlist'])) {
    
    $playerlist = $_GET['playerlist'] == 1 ? true : false;
    
}
else {
    
    if(isset($_POST['playerlist'])) {
        
        $playerlist = $_POST['playerlist'] == 1 ? true : false;
        
    }
    
}

// Our nice class <3
require_once './MinecraftQuery/MineStatus.class.php';

// Fetch status
$ugcraft = new MineStatus($server, $port);

// Print number of players
$ugcraft->outputPlayers();

// Display avatars if players are online
if($ugcraft->hasUsers() && $playerlist):
?>
<hr style="margin: 5px 0;" />
<?php

$ugcraft->outputPlayerList(true);

endif; // hasUsers()
?>