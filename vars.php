<?php
// Passing all Slack POST data payload into variable
$token = $_POST['token'];
$team_id = $_POST['team_id'];
$team_domain = $_POST['team_domain'];
$enterprise_id = $_POST['enterprise_id'];
$enterprise_name = $_POST['enterprise_name'];
$channel_id = $_POST['channel_id'];
$channel_name = $_POST['channel_name'];
$user_id = $_POST['user_id'];
$user_name = $_POST['user_name'];
$command = str_replace("/", "", $_POST['command']);
$text = trim($_POST['text']);
$response_url = $_POST['response_url'];
$trigger_id = $_POST['trigger_id'];

$MAIN_DIR = "/home/dw1"; // Main directory for shell execution
$LOG_DIR = "/tmp"; // Log data from receive commands, make sure it's writable
$DISALLOW_CMD = "/(sudo|rm|ln|cp|touch|\>|passwd|\.ssh|\.pem|\.bash)/"; // Disallowing specific command pattern
$ALLOW_USERS = "/(dwisiswant0)/"; // Allow command for specific users