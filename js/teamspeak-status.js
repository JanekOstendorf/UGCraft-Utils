/**
 * Gibt die Spieleranzahl eines Minecraft Servers aus
 * @param string Host Hostname/IP
 * @param int Port Portnummer des Minequery Servers
 */
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