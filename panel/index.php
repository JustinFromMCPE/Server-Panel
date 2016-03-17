<?php
session_start();
$username = $_SESSION["username"];
$password = $_SESSION["password"];
unset($_SESSION["username"]);
unset($_SESSION["password"]);
$settings = file_get_contents("options.txt");
$lines = explode("\n", $settings);
$formatted;
for($i = 0; $i < count($lines); $i++) {
	$formatted[$i] = explode("=", $lines[$i]);
}
if($username == rtrim($formatted[1][1])) {
	if($password == rtrim($formatted[2][1])) {
		echo "<script>console.log('Authentication successful!')</script>";
	}
	else {
		header("Location: /login");
	}
}
else {
	header("Location: /login");
}
include './php/server-settings.php';
include './php/panel-settings.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="A simple, yet non-minimalistic Minecraft server control panel.">
    <meta name="author" content="Cole &quot;Rocket_Scientist&quot; Crouter">
    <link rel="icon" href="../../favicon.ico">

    <title>Server Control Panel</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/dashboard.css" rel="stylesheet">
</head>

<body onLoad="SetConfig(); SetServerConfig(); GetConsole(); setInterval(GetConsole,2000); GetStatus(); setInterval(GetStatus,2000);" background="wallpaper.png" style="background-attachment:fixed; background-size: cover">

    <nav class="navbar navbar-dark navbar-fixed-top bg-inverse">
        <button type="button" class="navbar-toggler hidden-md-up col-xs-2" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
		&#9776;
        </button>
		<div class="hidden-sm-down">
       		<a class="navbar-brand" id="brand"></a>
		</div>
        <div>
            <div class="col-xs-9 col-sm-6 col-md-5 col-lg-4 col-xl-3 pull-xs-right">
				<div class="hidden-lg-down col-xl-4"></div>
				<div class="btn-group">
					<button id="Start" class="btn btn-success-outline" onClick='SendCommand({"command":"restart","type":"action"})'>Start</button>
					<button id="Restart" class="btn btn-warning-outline" onClick='SendCommand({"command":"restart","type":"action"})'>Restart</button>
					<button id="Stop" class="btn btn-danger-outline" onClick='SendCommand({"command":"stop","type":"action"})'>Stop</button>
				</div>
            </div>
        </div>
    </nav>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-3 col-md-2 sidebar" style="background-color:rgba(200,200,200,0.8); -webkit-backdrop-filter: blur(4px); backdrop-filter: blur(4px);" id="navbar">
                <ul class="nav nav-tabs nav-stacked">
                    <li class="nav-item active"><a data-toggle="tab" href="#Overview" class="nav-link">Overview</a>
                    </li>
                    <li class="nav-item"><a data-toggle="tab" href="#Console" class="nav-link">Console</a>
                    </li>
                    <li class="nav-item"><a data-toggle="tab" href="#Config" class="nav-link">Server Settings</a>
                    </li>
                    <li class="nav-item"><a data-toggle="tab" href="#Settings" class="nav-link">Panel Settings</a>
                    </li>
                </ul>
            </div>

            <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main tab-content">
                <div class="tab-content">
					<div id="Overview" class="tab-pane fade in active card card-block">
					<h2>Overview</h2>
						<div class="col-xs-8">
							<ul class="list-group list-group-flush">
								<li class="list-group-item">
									<h4>Players</h4>
									<progress id="players" class="progress progress-striped progress-animated" value="" max="">25%</progress>
								</li>
								<li class="list-group-item">
									<h4>Version</h4>
									<input class="form-control" id="version" readonly>
								</li>
								<li class="list-group-item">
									<h4>Map</h4>
									<input class="form-control" id="map" readonly>
								</li>
								<li class="list-group-item">
									<h4>Plugins</h4>
									<input class="form-control" id="plugins" readonly>
								</li>
							</ul>
						</div>
						<div class="col-xs-4">
							<h4>Players Online</h4>
							<table class="table table-striped">
								<tbody id="player-list">
								</tbody>
							</table>
						</div>
						<br>
						<br>
						<br>
						<br>
						<br>
						<br>
						<br>
						<br>
						<br>
						<br>
						<br>
						<br>
						<br>
						<br>
						<br>
						<br>
						<br>
                    </div>
                    <div id="Console" class="tab-pane fade card card-block">
                        <h2>Console</h2>
                        <p>
						<table class="table table-striped">
							<tbody id="console-window">
							</tbody>
						</table>
						<form class="input-group" id="console-form">
							<span class="input-group-addon">
							<input type="checkbox" id="say"> /say 
							</span>
							<input type="text" class="form-control" id="command-line">
							<span class="input-group-btn">
							<input type="submit" class="btn btn-info-outline">
							</span>
						</form>
                    </div>
                    <div class="tab-pane fade card card-block" id="Config">
                        <h2>Server Settings</h2>
                        <p>
                            <table class="table table-striped" id="ConfigTable">
                            </table>
                            <div class="alert alert-warning pull-lg-left"><strong>Warning!</strong> You must restart the server before changes will take effect.</div>
						<br><br><br>
                    </div>
                    <div id="Settings" class="tab-pane fade card card-block">
                        <h2>Panel Settings</h2>
                        <p>
                            <form name="panel-settings" method="post" onSubmit="ApplySettings();">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td>
                                                Server Name
                                            </td>
                                            <td>
                                                <input id="name" type="text" class="form-control" name="name">
                                            </td>
                                        </tr>
										<tr>
											<td>
												Login Username
											</td>
											<td>
												<input id="username" type="text" class="form-control" name="username">
											</td>
										</tr>
										<tr>
											<td>
												Login Password
											</td>
											<td>
												<input id="password" type="password" class="form-control" name="password">
											</td>
										</tr>
										<tr>
											<td>
												Wrapper Port
											</td>
											<td>
												<input id="port" type="text" class="form-control" name="port">
											</td>
										</tr>
										<tr>
											<td>
												Server Jarfile
											</td>
											<td>
												<input id="jar" type="text" class="form-control" name="jar">
											</td>
										</tr>
										<tr>
											<td>
												Server Port
											</td>
											<td>
												<input id="server-port" type="text" class="form-control" name="server-port">
											</td>
										</tr>
										<tr>
											<td>
												Allocated RAM
											</td>
											<td>
												<div class="input-group">
													<input id="ram" type="text" class="form-control" name="ram">
													<span class="input-group-addon">GB</span>
												</div>
											</td>
										</tr>
										<tr>
											<td>
												Map Name
											</td>
											<td>
												<input id="map-name" type="text" class="form-control" name="map-name">
											</td>
										</tr>
                                    </tbody>
                                </table>
                                <input class="btn btn-info-outline pull-lg-right" type="submit">
                            </form><br><br>
							<form>
								<table class="table">
									<tbody>
										<tr>
											<td class="col-xs-2">
                            				Site Wallpaper (Must be .png)
											</td>
											<td>
												<span class="col-xs-11">
													<input id="wallpaper" type="file" class="form-control" disabled>
												</span>
                                				<button class="pull-md-right btn btn-secondary">Reset</button>
											</td>
										</tr>
									</tbody>
								</table>
							</form>

                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="js/ie10-viewport-bug-workaround.js"></script>
	<script src="js/update.js"></script>
</body>

</html>