<?php
$serverSettings = "../server/server.properties";
$new = "";
$i = 0;
foreach($_POST as $key=>$value) {
	if($i <= 1) {
		$new .= $key."\n";
	}
	else {
		$new .= $key."=".$value."\n";
	}
	$i++;
}
print_r(json_encode($new));
file_put_contents($serverSettings, $new);
?>