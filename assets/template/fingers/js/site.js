function setSiteURL() { 
	var server = window.location.host;
	window.site = "http://"+server+"/pltu/"; 
} 

$(document).ready( function() {
	setSiteURL();
});