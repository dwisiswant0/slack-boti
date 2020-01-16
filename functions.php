<?php
include "vars.php";

function shellExec($cmd, $run_in_background = null) {
	global $MAIN_DIR;
	if ($run_in_background) $cmd .= " > /dev/null 2>/dev/null & echo \$!";
	return trim(shell_exec("cd ${MAIN_DIR} && ${cmd}"));
}

function checkDir($path) {
	return shellExec("[ -d '${path}' ] && echo 'OK'");
}

function writeLog($data) {
	global $LOG_DIR;
	$log = "[" . date("H:i:s") . "] " . json_encode($data, JSON_FORCE_OBJECT) . PHP_EOL;
	file_put_contents("${LOG_DIR}/slack_bot-sabuk_pengaman-" . date("dmY") . ".log", $log, FILE_APPEND);
}

function response($type, $message) {
	return array("response_type" => $type, "text" => $message);
}