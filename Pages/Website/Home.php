<?php
require "Pages/Website/Layout/Start.php";
?>
<div class="center">
	<h1>Rechercher un médicament</h1>

	<form method="get" action="/search">
		<input type="text" name="text" class="form-control" placeholder="Séresta, Tranxène, Stilnox, ..." required><br>
		<input type="submit" value="Rechercher" class="btn btn-primary">
	</form>
</div>
<?php
require "Pages/Website/Layout/End.php";