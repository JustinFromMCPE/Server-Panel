<?php
$username = $_POST["username"];
$password = $_POST["password"];
$settings = file_get_contents("../options.txt");
$lines = explode("\n", $settings);
$formatted;
for($i = 0; $i < count($lines); $i++) {
	$formatted[$i] = explode("=", $lines[$i]);
}
if(password_verify($username, rtrim($formatted[1][1]))) {
	if(password_verify($password, rtrim($formatted[2][1]))) {
		session_start();
		$_SESSION["username"] = $username;
		$_SESSION["password"] = $password;
		header("Location: ../");
	}
	else {
		header("Location: ./");
	}
}
else {
	header("Location: ./");
}
?>
