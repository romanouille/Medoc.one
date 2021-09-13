<?php
/**
 * Effectue le rendu de la page
 */
function renderPage() {
	$data = ob_get_contents();
	ob_end_clean();
	
	preg_match_all("`<!--(.+)-->`isU", $data, $comments);
	$comments = $comments[0];
	
	foreach ($comments as $comment) {
		$data = str_replace($comment, "", $data);
	}
	
	$data = str_replace("> <", "><", str_replace("  ", "", str_replace("\n", "", str_replace("	", "", $data))));
	
	echo $data;
}

/**
 * Génère le slug d'une chaîne
 *
 * @param string $text Chaîne
 *
 * @return string Slug
 */
function slug(string $text) : string {
	$text = strtolower($text);
	
	$replace = [
		"é" => "e",
		"è" => "e",
		"ê" => "e",
		"à" => "a",
		"â" => "a",
		"ç" => "c",
		"î" => "i",
		"ô" => "o",
		"ù" => "u",
		"û" => "u"
	];
	
	foreach ($replace as $accent=>$letter) {
		$text = str_replace($accent, $letter, $text);
	}
	
	$chars = str_split("abcdefghijklmnopqrstuvwxyz0123456789-");
	$text = str_replace(" ", "-", strtolower($text));

	$text = str_split($text);
	
	foreach ($text as $id=>$char) {
		if (!in_array($char, $chars)) {
			unset($text[$id]);
		}
	}

	$text = implode("", $text);

	return $text;
}