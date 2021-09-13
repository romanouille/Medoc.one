<?php
set_include_path("../");
chdir("../");

require "Core/Init.php";

$query = $db->prepare("UPDATE config SET value = 1 WHERE name = 'maintenance'");
$query->execute();

$query = $db->prepare("TRUNCATE cis_bpdm");
$query->execute();
$query = $db->prepare("TRUNCATE cis_cip_bpdm");
$query->execute();
$query = $db->prepare("TRUNCATE cis_compo_bpdm");
$query->execute();

$file = explode("\n", file_get_contents("http://base-donnees-publique.medicaments.gouv.fr/telechargement.php?fichier=CIS_bdpm.txt"));

echo "-> CIS_bpdm\n";

foreach ($file as $line) {
	$line = explode("	", $line);
	$line = array_map("utf8_encode", $line);
	
	if (!isset($line[1])) {
		continue;
	}
	
	$query = $db->prepare("INSERT INTO cis_bpdm(id, name, form, administration, administrative_status, authorization_procedure, status, amm, bdm_status, european_authorization, holders, surveillance) VALUES(:id, :name, :form, :administration, :administrative_status, :authorization_procedure, :status, :amm, :bdm_status, :european_authorization, :holders, :surveillance)");
	$query->bindValue(":id", $line[0], PDO::PARAM_INT);
	$query->bindValue(":name", $line[1], PDO::PARAM_STR);
	$query->bindValue(":form", $line[2], PDO::PARAM_STR);
	$query->bindValue(":administration", $line[3], PDO::PARAM_STR);
	$query->bindValue(":administrative_status", $line[4], PDO::PARAM_STR);
	$query->bindValue(":authorization_procedure", $line[5], PDO::PARAM_STR);
	$query->bindValue(":status", $line[6], PDO::PARAM_STR);
	$query->bindValue(":amm", $line[7], PDO::PARAM_STR);
	$query->bindValue(":bdm_status", $line[8], PDO::PARAM_STR);
	$query->bindValue(":european_authorization", $line[9], PDO::PARAM_STR);
	$query->bindValue(":holders", $line[10], PDO::PARAM_STR);
	$query->bindValue(":surveillance", $line[11], PDO::PARAM_STR);
	$query->execute();
}


$file = explode("\n", file_get_contents("http://base-donnees-publique.medicaments.gouv.fr/telechargement.php?fichier=CIS_CIP_bdpm.txt"));

echo "-> CIS_CIP_bdpm\n";

foreach ($file as $line) {
	$line = explode("	", $line);
	$line = array_map("utf8_encode", $line);
	
	if (!isset($line[1])) {
		continue;
	}
	
	$query = $db->prepare("INSERT INTO cis_cip_bpdm(cis, cip7, presentation, administrative_status_of_presentation, marketing_status, marketing_date, cip13, communities, refund, price, refund_policy, marketing_date_timestamp) VALUES(:cis, :cip7, :presentation, :administrative_status_of_presentation, :marketing_status, :marketing_date, :cip13, :communities, :refund, :price, :refund_policy, :marketing_date_timestamp)");
	$query->bindValue(":cis", $line[0], PDO::PARAM_STR);
	$query->bindValue(":cip7", $line[1], PDO::PARAM_INT);
	$query->bindValue(":presentation", $line[2], PDO::PARAM_STR);
	$query->bindValue(":administrative_status_of_presentation", $line[3], PDO::PARAM_STR);
	$query->bindValue(":marketing_status", $line[4], PDO::PARAM_STR);
	$query->bindValue(":marketing_date", $line[5], PDO::PARAM_STR);
	$query->bindValue(":cip13", $line[6], PDO::PARAM_INT);
	$query->bindValue(":communities", $line[7], PDO::PARAM_STR);
	$query->bindValue(":refund", $line[8], PDO::PARAM_STR);
	$query->bindValue(":price", !empty($line[9]) ? $line[9] : 0, PDO::PARAM_STR);
	$query->bindValue(":refund_policy", $line[10], PDO::PARAM_STR);
	$query->bindValue(":marketing_date_timestamp", strtotime(str_replace("/", "-", $line[5])), PDO::PARAM_INT);
	$query->execute();
}

$file = explode("\n", file_get_contents("http://base-donnees-publique.medicaments.gouv.fr/telechargement.php?fichier=CIS_COMPO_bdpm.txt"));

echo "-> CIS_COMPO_bdpm\n";

foreach ($file as $line) {
	$line = explode("	", $line);
	$line = array_map("utf8_encode", $line);
	
	if (!isset($line[1])) {
		continue;
	}
	
	$query = $db->prepare("INSERT INTO cis_compo_bpdm(cis, type, substance_code, substance_name, substance_dosage, dosage_reference, component_nature, link_number) VALUES(:cis, :type, :substance_code, :substance_name, :substance_dosage, :dosage_reference, :component_nature, :link_number)");
	$query->bindValue(":cis", $line[0], PDO::PARAM_INT);
	$query->bindValue(":type", $line[1], PDO::PARAM_STR);
	$query->bindValue(":substance_code", $line[2], PDO::PARAM_STR);
	$query->bindValue(":substance_name", $line[3], PDO::PARAM_STR);
	$query->bindValue(":substance_dosage", $line[4], PDO::PARAM_STR);
	$query->bindValue(":dosage_reference", $line[5], PDO::PARAM_STR);
	$query->bindValue(":component_nature", $line[6], PDO::PARAM_STR);
	$query->bindValue(":link_number", $line[7], PDO::PARAM_INT);
	$query->execute();
}

$query = $db->prepare("UPDATE config SET value = 0 WHERE name = 'maintenance'");
$query->execute();