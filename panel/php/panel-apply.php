<?php
$settings = "../options.txt";
$new = "name=".$_POST['name']."\nusername=".password_hash($_POST['username'], PASSWORD_DEFAULT)."\npassword=".password_hash($_POST['password'], PASSWORD_DEFAULT)."\nwrapper-port=".$_POST['port']."\nserver-jar=".$_POST["jar"];;
file_put_contents($settings, $new);
$_POST = [];
?>
