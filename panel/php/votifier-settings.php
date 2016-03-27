<?php
$pub = file_get_contents("./public.key");
$priv = file_get_contents("./private.key");
$settings = file_get_contents("./votifier-options.txt");
$settings = split("\n", $settings);
$settings[0] = split("=", $settings[0]);
$settings[1] = split("=", $settings[1]);
echo "<script>var public = `".$pub."`;";
echo "var private = `".$priv."`;";
echo "var enabled = ".$settings[0][1].";";
echo "var reward = \"".$settings[1][1]."\";</script>";
?>
<script>
function SetVotifierConfig() {
	document.getElementById("votifier").checked = enabled;
	document.getElementById("public").value = public;
	document.getElementById("private").value = private;
	document.getElementById("reward").value = reward;
}
</script>