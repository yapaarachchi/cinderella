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
			
			$text = '<div class="card-columns"> ';
			
			if(!empty($result)){
				foreach($result as $key => $value) {
				$text = $text.'
					<div class="card">

					  <img class="card-img-top img-fluid" src="../../assets/ads/10.png" alt="Card image cap" style="width: 100%; height: 150px;">
					  <div class="card-block">
						<h4 class="card-title">'.$value['business_name'].'</h4>
						<div class="row">
						
						
						<div class="col-xs-12 text-muted">
						<address>
						<img  src="../../assets/icons/location.png" alt="Card image cap">
						'.$value['branch_address1'].', '.$value['branch_address2'].','.$value['branch_address3'].'.</address>
						</div>
						</div>
						<div class="row">
						<div class="col-xs-12 text-muted">
						<img  src="../../assets/icons/phone.png" alt="Card image cap">
						'.$value['business_mobile'].'
						</div>
						</div>
						
						<div class="row">
						<div class="col-xs-12 text-muted">
						<img  src="../../assets/icons/mail.png" alt="Card image cap">
						'.$value['business_email'].'
						</div>
						</div>
						
					  </div>
					  
							<div class="card-footer text-muted text-center">
								<a href="../Merchant/Page/index.php?business='.$value['business_id'].'" class="btn btn-outline-primary btn-sm btn-block">More Details</a>
							</div>
							
					</div>
					</br>
				
				';
				}
				$text = $text.'</div>';
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