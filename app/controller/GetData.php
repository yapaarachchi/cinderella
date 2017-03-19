<?php
require "../Config.php";
require "../ErrorCode.php";
require '../../vendor/autoload.php';

$db = Config::initDb();
$category = new \Delight\Auth\Category($db);

if (!isset($_POST['action'])) {
	header('Location: ../../index.php');
}




if (isset($_POST)) {
	if (isset($_POST['action'])) {
		
		if($_POST['action'] === 'Category1'){
			try{
				echo "<option id='' value='' disabled selected>Main Category</option>";
				echo "<option id=''></option>";
				foreach($category->getMainCategory() as $key => $value) {
					echo "<option id='".$value['id']."' value='".$value['id']."'>".$value['category']."</option>";
				}
			}
			catch(Exception $e){
				echo 'false';
				return;
			}
		}
		
		if($_POST['action'] === 'Category2' and $_POST['Category1']){
			try{
				echo "<option id='' value='' disabled selected>Sub Category</option>";
				echo "<option id=''></option>";
				foreach($category->getSubCategory($_POST['Category1']) as $key => $value) {
					echo "<option id='".$value['id']."' value='".$value['id']."'>".$value['category2']."</option>";
				}
			}
			catch(Exception $e){
				echo 'false';
				return;
			}
		}
			
	}
}
?>