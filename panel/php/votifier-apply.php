<?php
$pub = "../public.key";
$priv = "../private.key";
$votifierOptions = "../votifier-options.txt";

file_put_contents($pub, $_POST["public"]);
file_put_contents($priv, $_POST["private"]);
file_put_contents($votifierOptions, "enabled=".$_POST["enabled"]."\nreward=".$_POST["reward"]);
$_POST = [];
?>