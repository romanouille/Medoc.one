<?php
require "Core/Medicaments.class.php";

$text = str_replace("%", "Escaped", urldecode($match[0]));
$data = Medicaments::search($text);

$pageTitle = "Résultats de la recherche pour '".htmlspecialchars($text)."'";

require "Pages/Website/Search.php";