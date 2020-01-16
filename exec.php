<?php
if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] !== 'POST') exit(header('HTTP/1.1 404 Not Found'));
if (isset($_SERVER['HTTP_USER_AGENT']) && !preg_match("/^Slackbot/", $_SERVER['HTTP_USER_AGENT'])) exit(header('HTTP/1.1 403 Forbidden'));
require_once "functions.php";

switch ($command) {
	case 'exec':
		if (preg_match("/(rm|ln)/", $text)) {
			$data = response("ephemeral", "Mon maap, perintah itu dilarang. :zipper_mouth_face::");
		} elseif (!preg_match("/(dsiswanto)/", $user_name)) {
			$data = response("ephemeral", "Mon maap nih, elo siapa? :amaze:");
		} else {
			$shell = shellExec("${text}");
			if ($shell !== NULL) {
				$data = response("in_channel", "```${shell}```");
			} else {
				$data = response("ephemeral", "Command `" . explode(" ", $text)[0] . "` not found. :fb_wow:");
			}
		}
		break;
	case 'sonar-scanner':
		if ($text == "*") {
			$shell = shellExec("/usr/local/bin/sonar-all", true);
			$data = response("in_channel", ":dabbing: Run *${command}* for *ALL PROJECT* in queue. `[PID: ${shell}]` :zackky:");
		} else {
			$check_dir = checkDir($text);
			if ($check_dir !== NULL) {
				$shell = shellExec("cd ${text}; ${command} -Dsonar.projectKey=${text} -Dsonar.projectBaseDir=\$PWD", true);
				$data = response("in_channel", ":dabbing: Run *${command}* for *${text}* in queue. `[PID: ${shell}]` :zackky:");
			} else {
				$data = response("in_channel", "Ups! Project *${text}* directory DOES NOT exist. :bherly:");
			}
		}
		break;
	default:
		$data = response("ephemeral", "Lu ngapain sih? :confused_parrot:");
		break;
}

writeLog($_POST);

header('Content-Type: application/json');
ob_end_clean();
ignore_user_abort();
ob_start();
header("Connection: close");
print_r(json_encode($data, JSON_PRETTY_PRINT));
header("Content-Length: " . ob_get_length());
ob_end_flush();
flush();
?>