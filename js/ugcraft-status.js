/**
 * Gibt die Spieleranzahl eines Minecraft Servers aus
 * @param string Host Hostname/IP
 * @param int Port Portnummer des Minequery Servers
 */
jQuery.fn.mcStatus = function(Host, Port, Playerlist) {
    
    var container = jQuery(this);
    
    jQuery.post("/custom-php/minecraft-status.php", {
            server: Host,
            port: Port,
            playerlist: Playerlist
        }, function(data) {
            container.html(data);
        }
    );
    
};

jQuery.fn.ts3Status = function() {
    
    var container = jQuery(this);
    
    jQuery.post("/custom-php/ugcraft-ts3.html",
        function(data) {
            container.html(data);
        }
    );
    
};

/*
 * Container beschreiben
 */

function getServerStatus() {

    // UGCraft
    jQuery("#ugcraft_status").mcStatus("46.38.242.91", 25565, 1);
    
    // UGCraft-Creative
    jQuery("#ugcraft-c_status").mcStatus("46.38.235.242", 25565, 1);
    
    jQuery("#teamspeak_status").ts3Status();

}

// Alle 30 Sekunden neu laden
var timer = setInterval(reloadStatus, 30000);

function reloadStatus() {

	getServerStatus();
	
}

function restartTimer() {
	clearInterval(timer);
	timer = setInterval(reloadStatus, 30000);
}

// Beim Seitenaufruf laden
jQuery(document).ready(function() {
    getServerStatus();
});