<?php
require "Pages/Website/Layout/Start.php";
?>
<h1>Médicaments récents</h1>

<table class="table striped">
	<thead>
		<tr>
			<th>Date
			<th>Nom
	</thead>
	
	<tbody>
<?php
foreach ($data as $value) {
?>
		<tr>
			<td><?=$value["date"]?>
			<td><a href="/drug/<?=$value["id"]?>-<?=slug($value["name"])?>" title="<?=htmlspecialchars($value["name"])?>"><?=htmlspecialchars($value["name"])?>
<?php
}
?>
	</tbody>
</table>
<?php
require "Pages/Website/Layout/End.php";