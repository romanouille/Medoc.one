<?php
require "Pages/Website/Layout/Start.php";
?>
<h1>Résultats de la recherche pour "<?=htmlspecialchars($text)?>"</h1>

<h2>Médicaments</h2>
<?php
if (!empty($data["drugs"])) {
?>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Nom du médicament
	</thead>
	
	<tbody>
<?php
	foreach ($data["drugs"] as $value) {
?>
		<tr>
			<td><a href="/drug/<?=$value["id"]?>-<?=slug($value["name"])?>" title="<?=htmlspecialchars($value["name"])?>"><?=htmlspecialchars($value["name"])?></a>
<?php
	}
?>
	</tbody>
</table>
<?php
} else {
?>
<div class="alert alert-warning">
	Il n'y a aucun médicament correspondant à votre recherche.
</div>
<?php
}
?>
<br><br>

<h2>Substances</h2>
<?php
if (!empty($data["substances"])) {
?>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Nom du médicament
			<th>Nom de la substance
	</thead>
	
	<tbody>
<?php
	foreach ($data["substances"] as $value) {
?>
		<tr>
			<td><a href="/drug/<?=$value["cis"]?>-<?=slug($value["medicament_name"])?>" title="<?=htmlspecialchars($value["medicament_name"])?>"><?=htmlspecialchars($value["medicament_name"])?></a>
			<td><?=htmlspecialchars($value["substance_name"])?>
<?php
	}
?>
	</tbody>
</table>
<?php
} else {
?>
<div class="alert alert-warning">
	Il n'y a aucune substance correspondant à votre recherche.
</div>
<?php
}

require "Pages/Website/Layout/End.php";