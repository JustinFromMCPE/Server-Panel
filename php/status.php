<?php
function StartFunction() {
	sleep(1);
}

function StopFunction() {
	
}

function RestartFunction() {
	StopFunction();
	sleep(2);
	StartFunction();
}

?>
<script type="text/javascript">
// Initialize Variables
var Info;
var PlayerList;

function Verify(){
	var Status = "<?php echo "Online" ?>";
	// Check if server is online
	if (Status == "Online"){
		console.log(Status);
		// Enable "Restart" button
		document.getElementById("Restart").setAttribute("class", "btn btn-warning");
		document.getElementById("Restart").setAttribute("onClick",'SendCommand({"command":"restart","type":"action"})');
		// Enable "Stop" button
		document.getElementById("Stop").setAttribute("class", "btn btn-danger");
		document.getElementById("Stop").setAttribute("OnClick", 'SendCommand({"command":"restart","type":"action"})');
		// Disable "Start" button
		document.getElementById("Start").setAttribute("class", "btn btn-success-outline");
		document.getElementById("Start").setAttribute("OnClick","");
	}
	else if (Status == "Offline"){
		// Disable "Restart" button
		document.getElementById("Restart").setAttribute("class", "btn btn-warning-outline");
		document.getElementById("Restart").setAttribute("onClick", "");
		// Disable "Stop" button
		document.getElementById("Stop").setAttribute("class", "btn btn-danger-outline");
		document.getElementById("Stop").setAttribute("OnClick", "");
		// Enable "Start" button
		document.getElementById("Start").setAttribute("class", "btn btn-success");
		document.getElementById("Start").setAttribute("OnClick",'SendCommand({"command":"start","type":"action"})');
	}
	else {
		console.log("Error retrieving server status!");
	}
}
function Dashboard() {
	Status = Info["Status"];
	document.getElementById("players").value = Info["Players"];
	document.getElementById("players").max = Info["MaxPlayers"];
	if(Info["players"] == Info["MaxPlayers"]) {
		document.getElementById("players").classList = "progress progress-danger";
	}
	else {
		document.getElementById("players").classList = "progress progress-info";
	}
	document.getElementById("version").value = Info["Version"];
	document.getElementById("map").value = Info["Map"];
	document.getElementById("plugins").value = "";
	for(i= 0; i > Info["Plugins"].length; i++) {
		document.getElementById("plugins").value += Info["Plugins"][i];
	}
	
	document.getElementById("player-list").innerHTML = ""
	for(i = 0; i < PlayerList.length; i++) {
		
		document.getElementById("player-list").innerHTML += "<tr><td>" + "<img src='http://cravatar.eu/helmavatar/" + PlayerList[i] + ".png'>" + "</td><td>" + PlayerList[i] + "</td><td>" + "<button class='btn btn-danger-outline' onClick='SendCommand({\"command\":\"kick " + PlayerList[i] + "\",\"type\":\"command\"})'>Kick</button>" + "</td><td>" + "<button class='btn btn-danger-outline' onClick='SendCommand({\"command\":\"ban " + PlayerList[i] + "\",\"type\":\"command\"})'>Ban</button>" + "</td></tr>"
	}
}
</script>