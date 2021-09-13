<?php
ini_set("memory_limit", -1);

$dev = !isset($_SERVER["REMOTE_ADDR"]) || in_array($_SERVER["REMOTE_ADDR"], ["127.0.0.1", "135.125.102.48", "5.196.158.16"]);

if ($dev) {
	error_reporting(-1);
	ini_set("display_errors", true);
} else {
	error_reporting(0);
	ini_set("display_errors", false);
}

set_time_limit(600);
ignore_user_abort(true);

set_include_path("../");
chdir("../");

require "Core/Functions.php";
require "Core/Routes.php";
require "Core/Cache.class.php";

ob_start();
register_shutdown_function("renderPage");

// Recherche de la route
foreach ($routes as $route=>$routeData) {
	if (preg_match($route, $_SERVER["REQUEST_URI"], $match)) {
		unset($match[0]);
		$match = array_values($match);
		$isApi = strstr($routeData["handler"], "Api_");
		
		require "Core/Init.php";
		
		$query = $db->prepare("SELECT value FROM config WHERE name = 'maintenance'");
		$query->execute();
		$data = $query->fetch();
		if ($data["value"] == 1) {
			http_response_code(503);
			header("Content-Type:text/plain;charset=utf-8");
			exit("Nous sommes en maintenance pour quelques minutes, nous revenons dans un instant.");
		}
		
		require "Handlers/{$routeData["handler"]}";
		exit;
	}
}

unset($route, $routeData);


// Aucune route correspondante

http_response_code(404);

require "Core/Init.php";
require "Handlers/Website/Error.php";