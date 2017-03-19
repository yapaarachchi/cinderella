<?php

$Category = new \Delight\Auth\Category($db);

?>

<div class="list-group">
<a href="app/Search/" style="font-size: 0.90rem; padding: 0.50rem;" class="list-group-item list-group-item-action" id="Search"><b>Search</b></a>
				  
</div>

</br>
<div class="list-group">
<?php
foreach($Category->getMainCategory() as $key => $value) {
	?>
	<?php echo  "<a style='font-size: 0.90rem; padding: 0.50rem;' class='list-group-item list-group-item-action' data-toggle='collapse' data-target='#".$value['id']."'> <b>".$value['category']."</b></a>";?>
	<?php echo "<div  id='".$value['id']."' class='sublinks collapse'>"; ?>
	<?php
	foreach($Category->getSubCategory($value['id']) as $key1 => $value1) {
	?>
	<?php echo "<a href='app/Search/index.php?main=".$value['id']."&sub=".$value1['id']."' style='font-size: 0.90rem; padding: 0.50rem;' class='list-group-item list-group-item-action' >".$value1['category2']."</a> ";?>
	<?php
	}
	?>
	</div>
	<?php
}
?>
</div>
