<?php
require "Core/Medicaments.class.php";

$data = Medicaments::getList($match[0]);
$totalPages = Medicaments::getListPagesNb();

if ($match[0] > $totalPages) {
	http_response_code(404);
	require "Handlers/Error.php";
}

$pageTitle = "Page {$match[0]} - Liste de tous les médicaments";

require "Pages/Website/List.php";