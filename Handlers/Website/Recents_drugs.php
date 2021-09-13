<?php
require "Core/Medicaments.class.php";

$data = Medicaments::getRecents();

$pageTitle = "Médicaments récents";

require "Pages/Website/Recents_drugs.php";