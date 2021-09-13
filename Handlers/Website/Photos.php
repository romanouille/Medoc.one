<?php
$pageTitle = "Photos de boîtes de médicaments";

require "Core/Medicaments.class.php";

$photos = glob("Public/img/box/*.jpg");
$result = [];
foreach ($photos as $photo) {
	$photo = explode("/", $photo);
	$photo = end($photo);
	
	$data = explode("_", $photo);
	
	$name = Medicaments::cisToName($data[0]);
	if (!isset($result[$data[0]])) {
		$result[$data[0]] = [
			"name" => $name,
			"photos" => []
		];
		
		$result[$data[0]]["photos"][] = str_replace(".jpg", "", $data[1]);
	} else {
		$result[$data[0]]["photos"][] = str_replace(".jpg", "", $data[1]);
	}
}

require "Pages/Website/Photos.php";