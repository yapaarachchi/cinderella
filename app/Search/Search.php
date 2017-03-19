<?php
require "../Config.php";
require '../../vendor/autoload.php';

$db = Config::initDb();
$business = new \Delight\Auth\Business($db);
$search_text = null;
$district = null;
$category1 = null;
$category2 = null;
if (isset($_POST)) {
	if (isset($_POST['action'])) {
		
		if($_POST['action'] === 'search'){
			if (isset($_POST['searchText']) and $_POST['searchText'] !== ''){
				$search_text = $_POST['searchText'];
			}
			
			if (isset($_POST['category1']) and $_POST['category1'] !== ''){
				$category1 = $_POST['category1'];
			}
			
			if (isset($_POST['category2']) and $_POST['category2'] !== ''){
				$category2 = $_POST['category2'];
			}
			
			if (isset($_POST['district']) and $_POST['district'] !== ''){
				$district = $_POST['district'];
			}
			
			$result = $business->search($category1,$category2,$district,$search_text);
			
			if(!empty($result)){
				foreach($result as $key => $value) {
				echo "<p>".$value['business_name']."</p>";	
				}
			}
			else{
				echo "<p> No Data</p>";
			}
			
			return;
		}
	}
}
?>