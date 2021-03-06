<?php
require "../Config.php";
require '../../vendor/autoload.php';

$db = Config::initDb();
$business = new \Delight\Auth\Business($db);
$Media = new \Delight\Auth\Media($db);
$search_text = '';
$district = '';
$category1 = '';
$category2 = '';
$text;
if (isset($_POST)) {
	if (isset($_POST['action'])) {
		
		if($_POST['action'] === 'search'){
			if (isset($_POST['searchText']) and $_POST['searchText'] != ''){
				$search_text = $_POST['searchText'];
			}
			
			if (isset($_POST['category1']) and $_POST['category1'] != ''){
				$category1 = $_POST['category1'];
			}
			
			if (isset($_POST['category2']) and $_POST['category2'] != ''){
				$category2 = $_POST['category2'];
			}
			
			if (isset($_POST['district']) and $_POST['district'] != ''){
				$district = $_POST['district'];
			}
			
			$result = $business->search($category1,$category2,$district,$search_text);
			
			$text = '<div class="card-columns"> ';
			
			if(!empty($result)){
				foreach($result as $key => $value) {
				$text = $text.'
					<div class="card">

					  <img class="card-img-top img-fluid" src="../Merchant/images/profile/'.$Media->getProfileImage($value['business_id'], true).'" alt="Card image cap">
					  <div class="card-block">
						<h4 class="card-title">'.$value['business_name'].'</h4>
						<div class="row">
						
						
						<div class="col-xs-12 text-muted">
						<address>
						<img  src="../../assets/icons/location.png" alt="Card image cap">
						'.$value['branch_address1'].', '.$value['branch_address2'].','.$value['branch_address3'].'</address>
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
					  
							<div class="card-footer text-center">
								<div id="MoreDetails" style="cursor: pointer" class="btn btn-outline-primary btn-sm btn-block more-detail" data-businessid="'.$value['business_id'].'">More Details</div>
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