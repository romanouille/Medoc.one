<?php
require "Pages/Website/Layout/Start.php";
?>
<h1><?=htmlspecialchars($data["name"])?></h1>

<table class="table table-striped">
	<tbody>
		<tr>
			<td>Statut
			<td><?=$data["status"]?>
			
		<tr>
			<td>Titulaires
			<td><?=str_replace(";", "<br>", $data["holders"])?>
		
		<tr>
			<td>Présentation
			<td><?=$data["presentation"]?>
			
		<tr>
			<td>Date de mise en vente
			<td><?=$data["marketing_date"]?>
			
		<tr>
			<td>Taux de remboursement
			<td><?=!empty($data["refund"]) ? $data["refund"] : "Inconnu"?>
			
		<tr>
			<td>Prix
			<td><?=$data["price"] > 0 ? "{$data["price"]}€" : "Inconnu"?>
		
		<tr>
			<td>Substance
			<td><?=htmlspecialchars($data["substance_name"])?>
		
<?php
if (!empty($images)) {
?>
		<tr>
			<td>Boîte
			<td>
<?php
	foreach ($images as $id=>$image) {
		if ($id > 0) {
			echo "<br><br>";
		}
		
		$uri = str_replace("Public", "", $image);
?>
				<a href="<?=$uri?>" target="_blank"><img src="<?=$uri?>" class="img-fluid" title="<?=htmlspecialchars($data["name"])?>" alt="<?=htmlspecialchars($data["name"])?>"></a>
<?php
	}
}
?>
	</tbody>
</table>
<br><br>

<h2>Commentaires</h2>
<h4>Ajouter un commentaire</h4>

<?php
if (isset($messages) && !empty($messages)) {
?>
<div class="alert alert-info">
<?php
	foreach ($messages as $id=>$message) {
		if ($id > 0) {
			echo "<br>";
		}
		
		echo $message;
	}
?>
</div>
<?php
}
?>
<form method="post">
	<input type="hidden" name="token" value="<?=$token?>">
	<input type="text" class="form-control" name="username" placeholder="Votre pseudo" maxlength="20" value="<?=isset($_POST["username"]) && is_string($_POST["username"]) ? htmlspecialchars($_POST["username"]) : ""?>" required><br>
	<textarea class="form-control" name="content" placeholder="Votre commentaire" required><?=isset($_POST["content"]) && is_string($_POST["content"]) ? htmlspecialchars($_POST["content"]) : ""?></textarea><br>
	<?=Captcha::generate()?><br>
	<input type="submit" class="btn btn-success" value="Envoyer le commentaire">
</form>

<br><br>
<?php
if (!empty($comments)) {
?>
<table class="table table-striped">
	<tbody>
		<tr>
			<th>Pseudo
			<th>Date
			<th>Contenu
			
<?php
	foreach ($comments as $comment) {
?>
		<tr>
<?php
if ($comment["username"] == "Administrateur") {
?>
			<td><span style="color:#C00;font-weight:bold">Administrateur</span>
<?php
} else {
?>
			<td><?=htmlspecialchars($comment["username"])?>
<?php
}
?>
			<td><?=date("d/m/Y H:i:s", $comment["timestamp"])?>
			<td><?=nl2br(htmlspecialchars($comment["content"]))?>
<?php
	}
?>
	</tbody>
</table>
<?php
} else {
?>
<div class="alert alert-info">
	Il n'y a aucun commentaire de posté pour ce médicament.
</div>
<?php
}
?>
<br>

<h2>Médicaments liés</h2>
<div class="list-group">
<?php
foreach ($allDrugs as $drug) {
?>
	<a href="/drug/<?=$drug["id"]?>-<?=slug($drug["name"])?>" class="list-group-item list-group-item-action<?=$match[0] == $drug["id"] ? " active" : ""?>"><?=htmlspecialchars($drug["name"])?></a>
<?php
}
?>
</div>

<?php

require "Pages/Website/Layout/End.php";