// JavaScript Document

// Initialize Variables
var Info;
var PlayerList;
var Status;

$("#console-form").on("submit", function (e) {SendCommand({"command":document.getElementById("command-line").value,"type":"command"});document.getElementById("command-line").value = ""; return false});
function GetStatus() {
    $.ajax({
      	type: "POST",
		async: false,
      	dataType: "json",
      	url: "php/query.php",
      	success: function(data) {
			Info = data[0];
			PlayerList = data[1];
			Dashboard();
	  	}
	 });
}
function SendCommand(request) {
	if(document.getElementById("say").checked === true && request.type == "command") {
		$.ajax({
			type: "POST",
			async: false,
			dataType: "json",
			data: {"command":"say " + request.command,"type":request.type},
			url: "php/send.php",
			success: function() {
			}
		 });
	}
	else {
		$.ajax({
			type: "POST",
			async: false,
			dataType: "json",
			data: {"command":request.command,"type":request.type},
			url: "php/send.php",
			success: function() {
			}
		 });
	}
}
function ApplySettings() {
	form = document.getElementById("panel-settings");
	$.ajax({
		type: "POST",
		async: false,
		dataType: "json",
		data: {"name":document.getElementById("name").value,"username":document.getElementById("username").value,"password":document.getElementById("password").value,"port":document.getElementById("port").value,"jar":document.getElementById("jar").value},
		url: 'php/panel-apply.php',
		success: function() {
			return false;
		}
	});
}
function ApplyServerSettings() {
	table = document.getElementById("ConfigTable");
	data = {};
	for(i = 0; i < table.rows.length; i++) {
		data[table.rows[i].cells[0].innerHTML] = table.rows[i].cells[1].children[0].value;
	}
	$.ajax({
		type: "POST",
		async: false,
		dataType: "json",
		data: data,
		url: 'php/server-apply.php',
		success: function() {
		}
	});
}
function ApplyVotifierSettings() {
	$.ajax({
		type: "POST",
		async: false,
		dataType: "json",
		data: {"enabled":document.getElementById("votifier").checked,"public":document.getElementById("public").value,"private":document.getElementById("private").value,"reward":document.getElementById("reward").value},
		url: 'php/votifier-apply.php',
	});
}
function ApplyWallpaper() {
	file = document.getElementById("wallpaper").value;
	$.ajax({
		type: "POST",
		async: false,
		data: new FormData(this),
		url: 'php/send-wallpaper.php'
	});
}
function Dashboard() {
	document.getElementById("players").value = Info.Players;
	document.getElementById("players").max = Info.MaxPlayers;
	if(Info.Players == Info.MaxPlayers) {
		document.getElementById("players").classList = "progress progress-danger";
	}
	else {
		document.getElementById("players").classList = "progress progress-info";
	}
	document.getElementById("version").value = Info.Version;
	document.getElementById("map").value = Info.Map;
	document.getElementById("plugins").value = "";
	for(i= 0; i > Info.Plugins.length; i++) {
		document.getElementById("plugins").value += Info.Plugins[i];
	}
	
	document.getElementById("player-list").innerHTML = "";
	for(i = 0; i < PlayerList.length; i++) {
		
		document.getElementById("player-list").innerHTML += "<tr><td>" + "<img src='http://cravatar.eu/helmavatar/" + PlayerList[i] + ".png'>" + "</td><td>" + PlayerList[i] + "</td><td>" + "<button class='btn btn-danger-outline' onClick='SendCommand({\"command\":\"kick " + PlayerList[i] + "\",\"type\":\"command\"})'>Kick</button>" + "</td><td>" + "<button class='btn btn-danger-outline' onClick='SendCommand({\"command\":\"ban " + PlayerList[i] + "\",\"type\":\"command\"})'>Ban</button>" + "</td></tr>";
	}
}
function GetConsole() {
	var Console = "";
    $.ajax({
      	type: "POST",
		async: false,
      	url: "php/console.php",
      	success: function(data) {
			Console = data.split("\n");
	  	}
	});
	document.getElementById("console-window").innerHTML = "";
	for(i = 15; i > 0; i--) {
		document.getElementById("console-window").innerHTML += "<td><xmp>" + Console[Console.length - i] + "</xmp></td>";
	}
	return false;
}