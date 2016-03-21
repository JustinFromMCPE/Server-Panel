<?php
$settings = "../options.txt";
$new = "name=".$_POST['name']."\nusername=".password_verify($_POST['username'], PASSWORD_DEFAULT)."\npassword=".password_hash($_POST['password'], PASSWORD_DEFAULT)."\nwrapper-port=".$_POST['port']."\nserver-jar=".$_POST['jar']."\nserver-port=".$_POST['server-port']."\nram=".$_POST['ram']."\nmap=".$_POST["map"];
file_put_contents($settings, $new);
?>
