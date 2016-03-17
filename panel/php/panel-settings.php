<?php
$settings = 'options.txt';

if (file_exists($settings)) {
	$lines = file($settings, FILE_IGNORE_NEW_LINES);
	echo "<script>var PanelConfig = ". json_encode($lines) . ";</script>";
}
?>
<script type="text/javascript">
var PanelConfigFormatted = [];
function SetServerConfig() {
    for (i = 0; i < PanelConfig.length; i++) {
        PanelConfigFormatted[i] = PanelConfig[i].split("=");
    }
	document.getElementById("name").value = PanelConfigFormatted[0][1];
	document.getElementById("brand").textContent = PanelConfigFormatted[0][1];
	document.getElementById("port").value = PanelConfigFormatted[3][1];
	document.getElementById("jar").value = PanelConfigFormatted[4][1];
	document.getElementById("server-port").value = PanelConfigFormatted[5][1];
	document.getElementById("ram").value = PanelConfigFormatted[6][1];
	document.getElementById("map-name").value = PanelConfigFormatted[7][1];
}
</script>