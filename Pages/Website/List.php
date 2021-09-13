<?php
require "Pages/Website/Layout/Start.php";
?>
<h1>Liste complète des médicaments</h1>

<table class="table table-striped">
	<thead>
		<tr>
			<th>Nom du médicament
	</thead>
	
	<tbody>
<?php
foreach ($data as $value) {
?>
		<tr>
			<td><a href="/drug/<?=$value["id"]?>-<?=slug($value["name"])?>" title="<?=htmlspecialchars($value["name"])?>"><?=htmlspecialchars($value["name"])?></a>
<?php
}
?>
	</tbody>
</table>

<?php
if ($match[0] > 1) {
?>
<a href="/list/page-<?=$match[0]-1?>" title="Page précédente" class="btn btn-primary">Page précédente</a>
<?php
}

if ($match[0] < $totalPages) {
?>
<a href="/list/page-<?=$match[0]+1?>" title="Page suivante" class="btn btn-primary">Page suivante</a>
<?php
}
?>
<br><br>

<?php

require "Pages/Website/Layout/End.php";