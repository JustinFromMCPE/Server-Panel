<?php
$address = "localhost";
$port = 8040;
$socket = fsockopen($address, $port);
if($_POST["type"] == "command") {
	fwrite($socket,('['.json_encode($_POST["command"]).','.json_encode("command").']'));
	
}
else if($_POST["type"] == "action") {
	fwrite($socket,('['.json_encode($_POST["command"]).','.json_encode("action").']'));
}
else {
	// Other Thing
}
?>