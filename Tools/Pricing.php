<?php
require "Init.php";

$query = $db->prepare("SELECT cis, REPLACE(price, ',', '.') AS price FROM cis_cip_bpdm");
$query->execute();
$data = $query->fetchAll();

$prices = [];
foreach ($data as $value) {
	$value = array_map("trim", $value);
	
	if ($value["price"] == 0) {
		continue;
	}
	
	if (substr_count($value["price"], ".") == 2) {
		$value["price"] = explode(".", $value["price"]);
		$value["price"] = $value["price"][0].$value["price"][1].".".$value["price"][2];
	}
	
	$query = $db->prepare("SELECT status FROM cis_bpdm WHERE id = :id");
	$query->bindValue(":id", $value["cis"], PDO::PARAM_INT);
	$query->execute();
	$data2 = $query->fetch();
	if (trim($data2["status"]) == "Non commercialisée") {
		continue;
	}
	
	$prices[$value["cis"]] = $value["price"];
}

asort($prices);
$prices = array_combine( array_keys( $prices ), array_reverse( array_values( $prices ) ) );

print_r($prices);