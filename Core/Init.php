<?php
$config = parse_ini_file(".env", true);

$db = new PDO("pgsql:dbname={$config["db"]["db_name"]};host={$config["db"]["db_server"]}", $config["db"]["db_username"], $config["db"]["db_password"], [PDO::ATTR_PERSISTENT => true]);

if (!isset($dev) || $dev) {
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}

if (isset($_SERVER["REMOTE_ADDR"])) {
	$token = sha1($_SERVER["REMOTE_ADDR"]);
}