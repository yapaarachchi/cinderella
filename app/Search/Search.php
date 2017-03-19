<?php
require "../Config.php";
require '../../vendor/autoload.php';

$db = Config::initDb();
$business = new \Delight\Auth\Business($db);
$search_text = null;
$district = null;
$category1 = null;
$category2 = null;
$text;
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
			
			$text = '';
			
			if(!empty($result)){
				foreach($result as $key => $value) {
				$text = $text.'
					<div class="card">

					  <img class="card-img-top img-fluid" src="../../assets/ads/10.png" alt="Card image cap" style="width: 100%">
					  <div class="card-block">
						<h4 class="card-title">'.$value['business_name'].'</h4>
						<div class="row">
						
						
						<div class="col-xs-12">
						<address>
						'.$value['branch_address1'].', '.$value['branch_address2'].','.$value['branch_address3'].'.</address>
						</div>
						</div>
						<div class="row">
						
						
						<div class="col-xs-12">
						'.$value['business_mobile'].'
						</div>
						</div>
						
						<div class="row">
						<div class="float-right">
							<a href="#" class="btn btn-outline-primary btn-sm">more</a>
							</div >
						</div>
					  </div>
					</div>
					</br>
				
				';
				}
				
			}
			else{
				$text = '
					<div class="alert alert-danger" role="alert">
					  <strong>No Businesses Found!</strong> Please check your search items again.
					</div>
				';
			}
			echo $text;
			return;
		}
	}
}
?>