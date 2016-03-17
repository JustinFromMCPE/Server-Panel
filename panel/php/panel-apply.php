<?php
$settings = "../options.txt";
$new = "name=".$_POST['name']."\nusername=".md5($_POST['username'])."\npassword=".md5($_POST['password'])."\nwrapper-port=".$_POST['port']."\nserver-jar=".$_POST['jar']."\nserver-port=".$_POST['server-port']."\nram=".$_POST['ram']."\nmap=".$_POST["map"];
file_put_contents($settings, $new);
?>