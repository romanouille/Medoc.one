<?php
require "Pages/Website/Layout/Start.php";
?>
<div class="center">
	<h1>Photos de boîtes de médicaments</h1>

<?php
foreach ($result as $cis=>$data) {
?>
	<h2><a href="/drug/<?=$cis."-".slug($data["name"])?>" title="<?=$data["name"]?>" target="_blank"><?=$data["name"]?></a></h2><br>
<?php
	foreach ($data["photos"] as $value) {
?>
	<a href="/img/box/<?=$cis?>_<?=$value?>.jpg" title="<?=$data["name"]?>" target="_blank"><img src="/img/box/<?=$cis?>_<?=$value?>.jpg" alt="<?=$data["name"]?>" style="width:100%"></a><br>
<?php
	}
?>
	<br><br>
<?php
}
?>

<p>
	Les photos peuvent être réutilisées librement.
</p>
</div>
<?php
require "Pages/Website/Layout/End.php";