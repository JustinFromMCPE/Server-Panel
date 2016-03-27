<?php
$filename = './server/server.properties';

if (file_exists($filename)) {
	echo "<script>console.log('Found server.properties!')</script>";
	$lines = file($filename, FILE_IGNORE_NEW_LINES);
	echo "<script>var Config = ". json_encode($lines) . ";</script>";
}
else {
	echo "<script>console.log('Could not find server.properties...')</script>";
}

?>
<script type="text/javascript">
function SetConfig() {
	var ConfigTable = document.getElementById("ConfigTable");
    var ConfigFormatted = [];
    for (i = 0; i < Config.length; i++) {
        ConfigFormatted[i] = Config[i].split("=");
		row = ConfigTable.insertRow(-1);
		cell1 = row.insertCell(0);
		cell2 = row.insertCell(1);
		cell1.innerHTML = ConfigFormatted[i][0];
		if(i < 2) {
			cell2.innerHTML = '<input class="form-control" hidden value="' + ConfigFormatted[i][1] + '">';
		}
		else {
			cell2.innerHTML = '<input class="form-control" value="' + ConfigFormatted[i][1] + '">';
		}

    }
} 
</script>