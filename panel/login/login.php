<?php
$username = password_hash($_POST["username"], PASSWORD_DEFAULT);
$password = password_hash($_POST["password"], PASSWORD_DEFAULT);
$settings = file_get_contents("../options.txt");
$lines = explode("\n", $settings);
$formatted;
for($i = 0; $i < count($lines); $i++) {
	$formatted[$i] = explode("=", $lines[$i]);
}
if($username == rtrim($formatted[1][1])) {
	if($password == rtrim($formatted[2][1])) {
		header("Location: ../");
		session_start();
		$_SESSION["username"] = $username;
		$_SESSION["password"] = $password;
	}
	else {
		header("Location: ./");
	}
}
else {
	header("Location: ./");
}
?>
