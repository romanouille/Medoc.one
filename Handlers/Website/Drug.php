<?php
require "Core/Captcha.class.php";
require "Core/Medicaments.class.php";

$data = Medicaments::load($match[0]);
if (empty($data)) {
	http_response_code(404);
	require "Handlers/Website/Error.php";
}

if ($match[1] != slug($data["name"])) {
	header("Location: /drug/{$match[0]}-".slug($data["name"]));
	exit;
}

if (count($_POST) > 0) {
	$messages = [];
	
	if (!isset($_POST["username"]) || !is_string($_POST["username"]) || empty(trim($_POST["username"]))) {
		$messages[] = "Vous devez spécifier votre pseudo.";
	}
	
	if (!isset($_POST["content"]) || !is_string($_POST["content"]) || empty(trim($_POST["content"]))) {
		$messages[] = "Vous devez spécifier le contenu de votre commentaire.";
	}
	
	if (!Captcha::check()) {
		$messages[] = "Vous devez prouver que vous n'êtes pas un robot.";
	}
	
	if (empty($messages)) {
		Medicaments::addComment($match[0], $_POST["username"], $_POST["content"]);
		$messages[] = "Votre commentaire a été ajouté.";
	}
}

$comments = Medicaments::getComments($match[0]);
$images = glob("Public/img/box/{$match[0]}_*");

$pageTitle = htmlspecialchars($data["name"]);

require "Pages/Website/Drug.php";