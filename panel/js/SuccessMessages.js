// JavaScript Document
function ConnectionSuccess() {
	console.log("Successfully connected to the SSH server!");
}
function ConnectionFail() {
	console.log("Could not connect to the SSH server...");
}
function LoginSuccess() {
	console.log("Successfully logged into the SSH server!");
}
function LoginFail() {
	console.log("Invalid SSH user/pass...");
}
function HookSuccess() {
	console.log("Found server settings!");
}
function HookFail() {
	console.log("Could not find server settings...");
}