<?php
$routes = [
	"#^\/$#" => [
		"handler" => "Website/Home.php"
	],
	
	"#^\/search\?text=(.+)$#" => [
		"handler" => "Website/Search.php"
	],
	
	"#^\/drug\/([0-9]+)-(.+)$#" => [
		"handler" => "Website/Drug.php"
	],
	
	"#^\/list\/page-([0-9]+)$#" => [
		"handler" => "Website/List.php"
	],
	
	"#^\/recents$#" => [
		"handler" => "Website/Recents_drugs.php"
	],
	
	"#^\/photos$#" => [
		"handler" => "Website/Photos.php"
	],
	
	"#^\/nextly$#" => [
		"handler" => "Website/Nextly.php"
	]
];